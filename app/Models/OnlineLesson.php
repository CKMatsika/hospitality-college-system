<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnlineLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'instructor_id',
        'lesson_type',
        'content',
        'video_url',
        'duration_minutes',
        'scheduled_start_time',
        'scheduled_end_time',
        'is_published',
        'allow_comments',
        'order',
        'materials',
    ];

    protected $casts = [
        'scheduled_start_time' => 'datetime',
        'scheduled_end_time' => 'datetime',
        'is_published' => 'boolean',
        'allow_comments' => 'boolean',
        'materials' => 'array',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(LessonEnrollment::class);
    }

    public function isVideo(): bool
    {
        return $this->lesson_type === 'video';
    }

    public function isText(): bool
    {
        return $this->lesson_type === 'text';
    }

    public function isInteractive(): bool
    {
        return $this->lesson_type === 'interactive';
    }

    public function isLiveSession(): bool
    {
        return $this->lesson_type === 'live_session';
    }

    public function isAssignment(): bool
    {
        return $this->lesson_type === 'assignment';
    }

    public function isScheduled(): bool
    {
        return $this->scheduled_start_time && $this->scheduled_end_time;
    }

    public function isLive(): bool
    {
        return $this->isLiveSession() && 
               $this->scheduled_start_time && 
               $this->scheduled_end_time && 
               now()->between($this->scheduled_start_time, $this->scheduled_end_time);
    }
}
