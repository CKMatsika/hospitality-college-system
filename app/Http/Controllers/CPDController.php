<?php

namespace App\Http\Controllers;

use App\Models\CpdRecord;
use App\Models\CpdCategory;
use App\Models\Certificate;
use App\Services\CPDManagementService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CPDController extends Controller
{
    use AuthorizesRequests;
    
    protected CPDManagementService $cpdService;

    public function __construct(CPDManagementService $cpdService)
    {
        $this->cpdService = $cpdService;
    }

    // Main CPD Dashboard
    public function dashboard(): View
    {
        $userId = auth()->id();
        $summary = $this->cpdService->getUserCPDSummary($userId);
        
        return view('cpd.dashboard', compact('summary'));
    }

    // CPD Points History
    public function history(): View
    {
        $records = CpdRecord::where('user_id', auth()->id())
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('cpd.history', compact('records'));
    }

    // CPD Certificate Verification
    public function verifyCertificate(Request $request): View
    {
        $verificationCode = $request->input('verification_code');
        $certificate = null;
        
        if ($verificationCode) {
            $certificate = Certificate::where('verification_code', $verificationCode)
                ->where('type', 'cpd_certificate')
                ->with('user')
                ->first();
        }

        return view('cpd.verify', compact('certificate', 'verificationCode'));
    }

    // CPD Level Progress
    public function levelProgress(): View
    {
        $userId = auth()->id();
        $summary = $this->cpdService->getUserCPDSummary($userId);
        
        $requirements = [
            'basic' => $this->cpdService->meetsCPDRequirements($userId, 'basic'),
            'intermediate' => $this->cpdService->meetsCPDRequirements($userId, 'intermediate'),
            'advanced' => $this->cpdService->meetsCPDRequirements($userId, 'advanced'),
            'expert' => $this->cpdService->meetsCPDRequirements($userId, 'expert'),
        ];

        return view('cpd.level-progress', compact('summary', 'requirements'));
    }

    // External Training Registration
    public function externalTraining(): View
    {
        $categories = CpdCategory::orderBy('name')->get();
        
        return view('cpd.external-training', compact('categories'));
    }

    // Submit External Training for CPD Points
    public function submitExternalTraining(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'activity_name' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'hours' => 'required|integer|min:1',
            'cpd_category_id' => 'required|exists:cpd_categories,id',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $cpdData = [
            'activity_type' => 'external_training',
            'activity_id' => null, // External training
            'activity_name' => $validated['activity_name'],
            'description' => $validated['description'],
            'provider' => $validated['provider'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'hours' => $validated['hours'],
            'category_name' => CpdCategory::find($validated['cpd_category_id'])->name,
            'points' => $this->calculateExternalTrainingPoints($validated['hours']),
        ];

        // Handle certificate upload
        if ($request->hasFile('certificate_file')) {
            $path = $request->file('certificate_file')->store('cpd-certificates', 'public');
            $cpdData['certificate_path'] = $path;
        }

        $record = $this->cpdService->awardCPDPoints(auth()->id(), $cpdData);

        return redirect()->route('cpd.history')
            ->with('success', 'External training submitted for CPD points approval.');
    }

    // CPD Certificate Generation
    public function generateCertificate(): View
    {
        $userId = auth()->id();
        $summary = $this->cpdService->getUserCPDSummary($userId);
        
        $availableLevels = [];
        foreach (['basic', 'intermediate', 'advanced', 'expert'] as $level) {
            $requirements = $this->cpdService->meetsCPDRequirements($userId, $level);
            if ($requirements['meets_requirements']) {
                $availableLevels[] = [
                    'level' => $level,
                    'requirements' => $requirements,
                ];
            }
        }

        return view('cpd.generate-certificate', compact('summary', 'availableLevels'));
    }

    // Process CPD Certificate Generation
    public function processCertificate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'level' => 'required|in:basic,intermediate,advanced,expert',
        ]);

        $userId = auth()->id();
        $requirements = $this->cpdService->meetsCPDRequirements($userId, $validated['level']);

        if (!$requirements['meets_requirements']) {
            return redirect()->back()
                ->with('error', 'You do not meet the requirements for this CPD level.');
        }

        // Check if certificate already exists
        $existingCertificate = Certificate::where('user_id', $userId)
            ->where('cpd_level', $validated['level'])
            ->where('type', 'cpd_certificate')
            ->where('status', 'active')
            ->first();

        if ($existingCertificate) {
            return redirect()->route('cpd.certificates')
                ->with('info', 'You already have an active CPD certificate for this level.');
        }

        $certificate = $this->cpdService->createCPDCertificate($userId, $validated['level']);

        return redirect()->route('cpd.certificates')
            ->with('success', 'CPD certificate generated successfully!');
    }

    // CPD Certificates List
    public function certificates(): View
    {
        $certificates = Certificate::where('user_id', auth()->id())
            ->where('type', 'cpd_certificate')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('cpd.certificates', compact('certificates'));
    }

    // CPD Analytics
    public function analytics(): View
    {
        $userId = auth()->id();
        $summary = $this->cpdService->getUserCPDSummary($userId);
        
        $analytics = [
            'points_trend' => $this->getPointsTrend($userId),
            'category_breakdown' => $summary['points_by_category'],
            'expiry_timeline' => $this->getExpiryTimeline($userId),
            'achievement_milestones' => $this->getAchievementMilestones($summary),
        ];

        return view('cpd.analytics', compact('summary', 'analytics'));
    }

    // Admin: CPD Management (for administrators)
    public function adminIndex(): View
    {
        $this->authorize('admin', CpdRecord::class);
        
        $pendingRecords = CpdRecord::where('status', 'pending')
            ->with('user', 'category')
            ->paginate(20);

        return view('cpd.admin.index', compact('pendingRecords'));
    }

    // Admin: Approve CPD Record
    public function approveRecord(CpdRecord $record): RedirectResponse
    {
        $this->authorize('admin', CpdRecord::class);
        
        $record->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'CPD record approved successfully.');
    }

    // Admin: Reject CPD Record
    public function rejectRecord(Request $request, CpdRecord $record): RedirectResponse
    {
        $this->authorize('admin', CpdRecord::class);
        
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $record->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'CPD record rejected.');
    }

    // Private helper methods
    private function calculateExternalTrainingPoints($hours): int
    {
        // 1 CPD point per hour of training, max 10 points per activity
        return min($hours, 10);
    }

    private function getPointsTrend($userId): array
    {
        // Calculate points earned over time
        $records = CpdRecord::where('user_id', $userId)
            ->where('status', 'approved')
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($record) {
                return $record->created_at->format('Y-m');
            });

        return $records->map(function ($monthRecords) {
            return [
                'month' => $monthRecords->first()->created_at->format('M Y'),
                'points' => $monthRecords->sum('points'),
                'activities' => $monthRecords->count(),
            ];
        })->values()->toArray();
    }

    private function getExpiryTimeline($userId): array
    {
        $upcomingExpiries = CpdRecord::where('user_id', $userId)
            ->where('expiry_date', '>', now())
            ->where('expiry_date', '<=', now()->addMonths(12))
            ->orderBy('expiry_date')
            ->get();

        return $upcomingExpiries->map(function ($record) {
            return [
                'activity' => $record->activity_name,
                'points' => $record->points,
                'expiry_date' => $record->expiry_date,
                'days_until_expiry' => now()->diffInDays($record->expiry_date),
                'category' => $record->category->name,
            ];
        })->toArray();
    }

    private function getAchievementMilestones($summary): array
    {
        $milestones = [
            ['points' => 10, 'title' => 'CPD Beginner', 'achieved' => $summary['total_points_earned'] >= 10],
            ['points' => 25, 'title' => 'CPD Intermediate', 'achieved' => $summary['total_points_earned'] >= 25],
            ['points' => 50, 'title' => 'CPD Advanced', 'achieved' => $summary['total_points_earned'] >= 50],
            ['points' => 100, 'title' => 'CPD Expert', 'achieved' => $summary['total_points_earned'] >= 100],
        ];

        return $milestones;
    }
}
