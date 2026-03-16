<?php

namespace App\Services;

use App\Models\CpdRecord;
use App\Models\CpdCategory;
use App\Models\OnlineExam;
use App\Models\OnlineLesson;
use App\Models\Certificate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CPDManagementService
{
    // Calculate CPD points for completed activities
    public function calculateCPDPoints($userId, $activityType, $activityId): array
    {
        $points = 0;
        $validityPeriod = null;
        $expiryDate = null;
        
        switch ($activityType) {
            case 'exam':
                $exam = OnlineExam::find($activityId);
                if ($exam) {
                    $submission = $exam->submissions()->where('student_id', $userId)->first();
                    if ($submission && $submission->percentage >= 50) {
                        $points = $this->calculateExamPoints($exam, $submission);
                        $validityPeriod = $exam->cpd_validity_months ?? 12; // Default 12 months
                        $expiryDate = now()->addMonths($validityPeriod);
                    }
                }
                break;
                
            case 'lesson':
                $lesson = OnlineLesson::find($activityId);
                if ($lesson) {
                    $enrollment = $lesson->enrollments()->where('student_id', $userId)->first();
                    if ($enrollment && $enrollment->status === 'completed') {
                        $points = $this->calculateLessonPoints($lesson, $enrollment);
                        $validityPeriod = $lesson->cpd_validity_months ?? 6; // Default 6 months
                        $expiryDate = now()->addMonths($validityPeriod);
                    }
                }
                break;
                
            case 'short_course':
                $points = $this->calculateShortCoursePoints($activityId);
                $validityPeriod = 24; // Short courses valid for 24 months
                $expiryDate = now()->addMonths($validityPeriod);
                break;
                
            case 'external_training':
                $points = $this->validateExternalTraining($activityId);
                $validityPeriod = 12; // External training valid for 12 months
                $expiryDate = now()->addMonths($validityPeriod);
                break;
        }
        
        return [
            'points' => $points,
            'validity_period' => $validityPeriod,
            'expiry_date' => $expiryDate,
            'activity_type' => $activityType,
            'activity_id' => $activityId,
        ];
    }
    
    // Award CPD points to user
    public function awardCPDPoints($userId, array $cpdData): CpdRecord
    {
        return DB::transaction(function () use ($userId, $cpdData) {
            // Check if already awarded
            $existing = CpdRecord::where('user_id', $userId)
                ->where('activity_type', $cpdData['activity_type'])
                ->where('activity_id', $cpdData['activity_id'])
                ->first();
                
            if ($existing) {
                return $existing; // Already awarded
            }
            
            // Get or create CPD category
            $category = $this->getOrCreateCategory($cpdData['category_name'] ?? 'General');
            
            return CpdRecord::create([
                'user_id' => $userId,
                'cpd_category_id' => $category->id,
                'activity_type' => $cpdData['activity_type'],
                'activity_id' => $cpdData['activity_id'],
                'activity_name' => $cpdData['activity_name'],
                'description' => $cpdData['description'] ?? null,
                'provider' => $cpdData['provider'] ?? 'Hospitality College',
                'start_date' => $cpdData['start_date'] ?? now(),
                'end_date' => $cpdData['end_date'] ?? now(),
                'hours' => $cpdData['hours'] ?? 1,
                'points' => $cpdData['points'],
                'certificate_path' => $cpdData['certificate_path'] ?? null,
                'status' => 'approved',
                'approved_by' => 1, // System approved
                'expiry_date' => $cpdData['expiry_date'],
                'validity_period_months' => $cpdData['validity_period'],
            ]);
        });
    }
    
    // Get user's CPD summary
    public function getUserCPDSummary($userId): array
    {
        $records = CpdRecord::where('user_id', $userId)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $totalPoints = $records->sum('points');
        $activePoints = $records->where('expiry_date', '>', now())->sum('points');
        $expiredPoints = $records->where('expiry_date', '<=', now())->sum('points');
        
        $pointsByCategory = $records->groupBy('category.name')->map(function ($categoryRecords) {
            return [
                'total_points' => $categoryRecords->sum('points'),
                'active_points' => $categoryRecords->where('expiry_date', '>', now())->sum('points'),
                'activities' => $categoryRecords->count(),
            ];
        });
        
        $upcomingExpirations = $records->where('expiry_date', '>', now())
            ->where('expiry_date', '<=', now()->addDays(30))
            ->sortBy('expiry_date');
            
        return [
            'total_points_earned' => $totalPoints,
            'active_points' => $activePoints,
            'expired_points' => $expiredPoints,
            'points_by_category' => $pointsByCategory,
            'upcoming_expirations' => $upcomingExpirations,
            'total_activities' => $records->count(),
            'recent_activities' => $records->take(5),
            'level' => $this->calculateCPDLevel($activePoints),
            'next_level_points' => $this->getNextLevelPoints($activePoints),
        ];
    }
    
    // Check if user meets CPD requirements for certification
    public function meetsCPDRequirements($userId, $requirementLevel = 'basic'): array
    {
        $summary = $this->getUserCPDSummary($userId);
        
        $requirements = $this->getCPDRequirements($requirementLevel);
        
        return [
            'meets_requirements' => $summary['active_points'] >= $requirements['required_points'],
            'current_points' => $summary['active_points'],
            'required_points' => $requirements['required_points'],
            'points_needed' => max(0, $requirements['required_points'] - $summary['active_points']),
            'category_requirements_met' => $this->checkCategoryRequirements($summary['points_by_category'], $requirements['category_requirements']),
            'expiry_concerns' => $summary['upcoming_expirations']->count() > 0,
        ];
    }
    
    // Create CPD certificate
    public function createCPDCertificate($userId, $level): Certificate
    {
        $user = User::find($userId);
        $summary = $this->getUserCPDSummary($userId);
        
        return Certificate::create([
            'user_id' => $userId,
            'title' => "CPD Certificate - {$level} Level",
            'description' => "Awarded for achieving {$level} level CPD with {$summary['active_points']} active points",
            'type' => 'cpd_certificate',
            'issue_date' => now(),
            'expiry_date' => now()->addMonths($this->getCPDCertificateValidity($level)),
            'status' => 'active',
            'verification_code' => $this->generateCPDVerificationCode(),
            'cpd_level' => $level,
            'cpd_points' => $summary['active_points'],
        ]);
    }
    
    // Process automatic CPD point awards
    public function processAutomaticAwards(): void
    {
        // Award points for completed exams
        $this->awardPointsForCompletedExams();
        
        // Award points for completed lessons
        $this->awardPointsForCompletedLessons();
        
        // Check for level upgrades
        $this->processLevelUpgrades();
        
        // Send expiry notifications
        $this->sendExpiryNotifications();
    }
    
    // Private helper methods
    private function calculateExamPoints($exam, $submission): int
    {
        $basePoints = $exam->cpd_points ?? 10;
        $scoreBonus = ($submission->percentage / 100) * ($exam->cpd_bonus_points ?? 5);
        
        return (int) ($basePoints + $scoreBonus);
    }
    
    private function calculateLessonPoints($lesson, $enrollment): int
    {
        $basePoints = $lesson->cpd_points ?? 5;
        $timeBonus = min($enrollment->time_spent_minutes / 60, 2); // Max 2 bonus points
        $completionBonus = $enrollment->progress_percentage >= 100 ? 2 : 1;
        
        return (int) ($basePoints + $timeBonus + $completionBonus);
    }
    
    private function calculateShortCoursePoints($courseId): int
    {
        // Short courses typically worth 15-30 points
        return 20; // Default
    }
    
    private function validateExternalTraining($trainingId): int
    {
        // External training points based on validation
        return 10; // Default after validation
    }
    
    private function getOrCreateCategory($categoryName): CpdCategory
    {
        return CpdCategory::firstOrCreate(['name' => $categoryName], [
            'description' => "CPD category for {$categoryName}",
            'max_points' => 100,
        ]);
    }
    
    private function calculateCPDLevel($points): string
    {
        if ($points >= 100) return 'expert';
        if ($points >= 50) return 'advanced';
        if ($points >= 25) return 'intermediate';
        if ($points >= 10) return 'basic';
        return 'beginner';
    }
    
    private function getNextLevelPoints($currentPoints): int
    {
        if ($currentPoints >= 100) return 100; // Already expert
        if ($currentPoints >= 50) return 100;
        if ($currentPoints >= 25) return 50;
        if ($currentPoints >= 10) return 25;
        return 10;
    }
    
    private function getCPDRequirements($level): array
    {
        $requirements = [
            'basic' => [
                'required_points' => 10,
                'category_requirements' => [
                    'Hospitality Operations' => 5,
                    'Customer Service' => 3,
                ],
            ],
            'intermediate' => [
                'required_points' => 25,
                'category_requirements' => [
                    'Hospitality Operations' => 10,
                    'Customer Service' => 8,
                    'Management' => 5,
                ],
            ],
            'advanced' => [
                'required_points' => 50,
                'category_requirements' => [
                    'Hospitality Operations' => 15,
                    'Customer Service' => 12,
                    'Management' => 15,
                    'Leadership' => 8,
                ],
            ],
            'expert' => [
                'required_points' => 100,
                'category_requirements' => [
                    'Hospitality Operations' => 25,
                    'Customer Service' => 20,
                    'Management' => 25,
                    'Leadership' => 15,
                    'Strategy' => 15,
                ],
            ],
        ];
        
        return $requirements[$level] ?? $requirements['basic'];
    }
    
    private function checkCategoryRequirements($pointsByCategory, $categoryRequirements): array
    {
        $metRequirements = [];
        
        foreach ($categoryRequirements as $category => $requiredPoints) {
            $userPoints = $pointsByCategory[$category]['active_points'] ?? 0;
            $metRequirements[$category] = [
                'required' => $requiredPoints,
                'earned' => $userPoints,
                'met' => $userPoints >= $requiredPoints,
            ];
        }
        
        return $metRequirements;
    }
    
    private function getCPDCertificateValidity($level): int
    {
        $validityPeriods = [
            'basic' => 12,
            'intermediate' => 18,
            'advanced' => 24,
            'expert' => 36,
        ];
        
        return $validityPeriods[$level] ?? 12;
    }
    
    private function generateCPDVerificationCode(): string
    {
        return 'CPD_' . strtoupper(uniqid());
    }
    
    private function awardPointsForCompletedExams(): void
    {
        // Implementation for automatic exam point awards
    }
    
    private function awardPointsForCompletedLessons(): void
    {
        // Implementation for automatic lesson point awards
    }
    
    private function processLevelUpgrades(): void
    {
        // Implementation for level upgrades
    }
    
    private function sendExpiryNotifications(): void
    {
        // Implementation for expiry notifications
    }
}
