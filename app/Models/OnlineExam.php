<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnlineExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'instructor_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'passing_score',
        'total_marks',
        'allow_multiple_attempts',
        'max_attempts',
        'is_published',
        'require_proctoring',
        'proctoring_instructions',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'allow_multiple_attempts' => 'boolean',
        'is_published' => 'boolean',
        'require_proctoring' => 'boolean',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class)->orderBy('order');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(ExamSubmission::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function isLive(): bool
    {
        return now()->between($this->start_time, $this->end_time);
    }

    public function hasStarted(): bool
    {
        return now()->gte($this->start_time);
    }

    public function hasEnded(): bool
    {
        return now()->gt($this->end_time);
    }
}
