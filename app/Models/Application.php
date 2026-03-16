<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_number',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'nationality',
        'national_id',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'phone',
        'email',
        'emergency_contact_name',
        'emergency_contact_phone',
        'program_id',
        'status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth->age;
    }

    protected static function booted()
    {
        static::creating(function ($application) {
            $application->application_number = 'APP-' . strtoupper(uniqid());
        });
    }
}
