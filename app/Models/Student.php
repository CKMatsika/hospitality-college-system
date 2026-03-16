<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'student_id', 'program_id', 'first_name', 'last_name',
        'date_of_birth', 'gender', 'nationality', 'national_id', 'address',
        'city', 'state', 'postal_code', 'country', 'phone',
        'emergency_contact_name', 'emergency_contact_phone',
        'admission_date', 'expected_graduation', 'status', 'medical_notes',
        'registration_status', 'registration_completed_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
        'expected_graduation' => 'date',
        'registration_completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function fees(): HasMany
    {
        return $this->hasMany(StudentFee::class);
    }

    public function feePayments(): HasMany
    {
        return $this->hasMany(FeePayment::class);
    }

    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function cpdRecords(): HasMany
    {
        return $this->hasMany(CpdRecord::class);
    }

    public function lmsEnrollments(): HasMany
    {
        return $this->hasMany(LmsEnrollment::class, 'user_id', 'user_id');
    }

    public function examSubmissions(): HasMany
    {
        return $this->hasMany(ExamSubmission::class, 'student_id');
    }

    public function lessonEnrollments(): HasMany
    {
        return $this->hasMany(LessonEnrollment::class, 'student_id');
    }

    public function assignmentSubmissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class, 'student_id');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
