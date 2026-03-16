<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'document_type',
        'original_filename',
        'stored_filename',
        'path',
        'size_kb',
        'mime_type',
    ];

    protected $casts = [
        'size_kb' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    public function getFormattedSizeAttribute()
    {
        $size = $this->size_kb;
        if ($size < 1024) {
            return $size . ' KB';
        }
        return number_format($size / 1024, 2) . ' MB';
    }
}
