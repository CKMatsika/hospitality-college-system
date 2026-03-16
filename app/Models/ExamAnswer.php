<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'question_id',
        'answer',
        'is_correct',
        'marks_obtained',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'marks_obtained' => 'decimal:2',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(ExamSubmission::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(ExamQuestion::class);
    }

    public function getFormattedMarks(): string
    {
        return $this->marks_obtained ? number_format($this->marks_obtained, 2) : 'Not graded';
    }

    public function isCorrect(): bool
    {
        return $this->is_correct === true;
    }
}
