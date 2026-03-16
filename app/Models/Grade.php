<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'course_id', 'academic_term_id', 'assessment_type',
        'assessment_name', 'max_marks', 'marks_obtained', 'weight_percentage',
        'remarks', 'graded_by',
    ];

    protected $casts = [
        'max_marks' => 'decimal:2',
        'marks_obtained' => 'decimal:2',
        'weight_percentage' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function academicTerm(): BelongsTo
    {
        return $this->belongsTo(AcademicTerm::class);
    }

    public function gradedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    public function getPercentageAttribute(): float
    {
        return $this->max_marks > 0 ? ($this->marks_obtained / $this->max_marks) * 100 : 0;
    }
}
