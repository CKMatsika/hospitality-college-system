<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'method_name', 'method_type', 'provider', 'is_active',
        'supports_refunds', 'fees', 'daily_limit', 'monthly_limit',
        'integration_config', 'description', 'icon', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'supports_refunds' => 'boolean',
        'daily_limit' => 'decimal:2',
        'monthly_limit' => 'decimal:2',
        'fees' => 'decimal:2',
        'integration_config' => 'array',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }
}
