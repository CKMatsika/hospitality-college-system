<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'submitted_at',
        'score',
        'percentage',
        'status',
        'feedback',
        'late_penalty_applied',
        'is_late',
        'submission_text',
        'attachment_files',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'score' => 'decimal:2',
        'percentage' => 'decimal:2',
        'late_penalty_applied' => 'decimal:2',
        'is_late' => 'boolean',
        'attachment_files' => 'array',
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(OnlineAssignment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    public function isGraded(): bool
    {
        return $this->status === 'graded';
    }

    public function needsRevision(): bool
    {
        return $this->status === 'returned_for_revision';
    }

    public function hasPassed(): bool
    {
        return $this->isGraded() && $this->percentage && $this->percentage >= 50.00;
    }

    public function getFormattedScore(): string
    {
        return $this->score ? number_format($this->score, 2) : 'Not graded';
    }

    public function getFormattedPercentage(): string
    {
        return $this->percentage ? number_format($this->percentage, 2) . '%' : 'Not graded';
    }
}
