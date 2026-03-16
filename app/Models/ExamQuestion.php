<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question_text',
        'question_type',
        'marks',
        'order',
        'options',
        'correct_answer',
        'explanation',
        'is_required',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(OnlineExam::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class);
    }

    public function getOptionsArray(): array
    {
        return $this->options ?? [];
    }

    public function isMultipleChoice(): bool
    {
        return $this->question_type === 'multiple_choice';
    }

    public function isTrueFalse(): bool
    {
        return $this->question_type === 'true_false';
    }

    public function isShortAnswer(): bool
    {
        return $this->question_type === 'short_answer';
    }

    public function isEssay(): bool
    {
        return $this->question_type === 'essay';
    }
}
