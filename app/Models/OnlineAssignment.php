<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnlineAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'instructor_id',
        'deadline',
        'published_at',
        'total_marks',
        'allow_late_submission',
        'late_penalty_percentage',
        'instructions',
        'attachment_files',
        'is_published',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'published_at' => 'datetime',
        'allow_late_submission' => 'boolean',
        'is_published' => 'boolean',
        'attachment_files' => 'array',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function isOverdue(): bool
    {
        return $this->deadline && now()->gt($this->deadline);
    }

    public function isPublished(): bool
    {
        return $this->is_published && $this->published_at && now()->gte($this->published_at);
    }

    public function getDaysUntilDeadline(): int
    {
        if (!$this->deadline) {
            return 0;
        }
        
        return now()->diffInDays($this->deadline);
    }

    public function getFormattedDeadline(): string
    {
        return $this->deadline ? $this->deadline->format('M d, Y H:i') : 'No deadline';
    }
}
