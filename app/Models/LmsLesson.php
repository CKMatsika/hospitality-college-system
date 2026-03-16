<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LmsLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'lms_module_id', 'title', 'content', 'type', 'video_url',
        'file_path', 'duration_minutes', 'sort_order', 'is_free_preview',
    ];

    protected $casts = [
        'is_free_preview' => 'boolean',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(LmsModule::class, 'lms_module_id');
    }
}
