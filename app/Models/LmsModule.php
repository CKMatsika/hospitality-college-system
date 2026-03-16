<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LmsModule extends Model
{
    use HasFactory;

    protected $fillable = ['lms_course_id', 'title', 'description', 'sort_order'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(LmsCourse::class, 'lms_course_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(LmsLesson::class)->orderBy('sort_order');
    }
}
