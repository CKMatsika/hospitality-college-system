<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CpdRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'cpd_category_id', 'activity_type', 'activity_id',
        'activity_name', 'description', 'provider', 'start_date', 'end_date',
        'hours', 'points', 'certificate_path', 'status', 'approved_by',
        'approved_at', 'rejection_reason', 'expiry_date', 'validity_period_months',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'expiry_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CpdCategory::class, 'cpd_category_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes for different activity types
    public function scopeExam($query)
    {
        return $query->where('activity_type', 'exam');
    }

    public function scopeLesson($query)
    {
        return $query->where('activity_type', 'lesson');
    }

    public function scopeShortCourse($query)
    {
        return $query->where('activity_type', 'short_course');
    }

    public function scopeExternalTraining($query)
    {
        return $query->where('activity_type', 'external_training');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'approved')
                    ->where(function ($q) {
                        $q->whereNull('expiry_date')
                          ->orWhere('expiry_date', '>', now());
                    });
    }

    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<=', now());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->status === 'approved' && 
               ($this->expiry_date === null || $this->expiry_date > now());
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date <= now();
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function getDaysUntilExpiry(): int
    {
        if (!$this->expiry_date) {
            return -1; // No expiry
        }
        
        return now()->diffInDays($this->expiry_date, false);
    }

    public function getFormattedPoints(): string
    {
        return number_format($this->points, 1);
    }

    public function getActivityTypeLabel(): string
    {
        $labels = [
            'exam' => 'Online Exam',
            'lesson' => 'Online Lesson',
            'short_course' => 'Short Course',
            'external_training' => 'External Training',
        ];

        return $labels[$this->activity_type] ?? 'Other';
    }

    public function getStatusLabel(): string
    {
        $labels = [
            'pending' => 'Pending Approval',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ];

        return $labels[$this->status] ?? 'Unknown';
    }

    public function getStatusColor(): string
    {
        $colors = [
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
        ];

        return $colors[$this->status] ?? 'gray';
    }
}
