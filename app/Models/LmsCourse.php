<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LmsCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'instructor_id', 'title', 'slug', 'description',
        'thumbnail', 'level', 'duration_hours', 'is_published', 'is_free', 'price',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_free' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(LmsModule::class)->orderBy('sort_order');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(LmsEnrollment::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(LmsAssignment::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(LmsQuiz::class);
    }
}
