<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CpdCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'max_points'];

    public function records(): HasMany
    {
        return $this->hasMany(CpdRecord::class);
    }
}
