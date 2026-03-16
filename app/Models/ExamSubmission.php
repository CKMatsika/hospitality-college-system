<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'start_time',
        'end_time',
        'score',
        'percentage',
        'status',
        'attempt_number',
        'proctoring_data',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'score' => 'decimal:2',
        'percentage' => 'decimal:2',
        'proctoring_data' => 'array',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(OnlineExam::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class);
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    public function isGraded(): bool
    {
        return $this->status === 'graded';
    }

    public function hasPassed(): bool
    {
        return $this->status === 'passed' || ($this->percentage && $this->exam && $this->percentage >= $this->exam->passing_score);
    }

    public function hasFailed(): bool
    {
        return $this->status === 'failed' || ($this->percentage && $this->exam && $this->percentage < $this->exam->passing_score);
    }

    public function getDuration(): int
    {
        return $this->start_time && $this->end_time 
            ? $this->start_time->diffInMinutes($this->end_time)
            : 0;
    }
}
