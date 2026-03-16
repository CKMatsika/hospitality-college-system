<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_name',
        'institution_tagline',
        'address',
        'phone',
        'email',
        'website',
        'logo_path',
        'theme',
        'primary_color',
        'secondary_color',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], []);
    }
}
