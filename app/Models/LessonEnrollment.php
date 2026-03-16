<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'student_id',
        'enrolled_at',
        'started_at',
        'completed_at',
        'progress_percentage',
        'time_spent_minutes',
        'status',
        'notes',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'progress_percentage' => 'decimal:2',
        'time_spent_minutes' => 'integer',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(OnlineLesson::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function isEnrolled(): bool
    {
        return $this->status === 'enrolled';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isDropped(): bool
    {
        return $this->status === 'dropped';
    }

    public function getCompletionTime(): ?int
    {
        if (!$this->started_at || !$this->completed_at) {
            return null;
        }
        
        return $this->started_at->diffInMinutes($this->completed_at);
    }
}
