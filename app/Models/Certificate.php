<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'program_id', 'certificate_number', 'type', 'title',
        'description', 'issue_date', 'expiry_date', 'status', 'file_path', 'issued_by',
        'exam_id', 'course_id', 'score', 'percentage', 'verification_code', 'certificate_url',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'score' => 'decimal:2',
        'percentage' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(OnlineExam::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function isActive(): bool
    {
        return $this->status === 'active' || $this->status === 'issued';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired' || ($this->expiry_date && now()->gt($this->expiry_date));
    }

    public function isRevoked(): bool
    {
        return $this->status === 'revoked';
    }

    public function getVerificationUrl(): string
    {
        return $this->verification_code 
            ? route('certificates.verify', $this->verification_code)
            : '#';
    }

    public function getFormattedScore(): string
    {
        return $this->score ? number_format($this->score, 2) : 'N/A';
    }

    public function getFormattedPercentage(): string
    {
        return $this->percentage ? number_format($this->percentage, 2) . '%' : 'N/A';
    }
}
