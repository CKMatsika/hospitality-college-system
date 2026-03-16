<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'subtype',
        'is_active',
        'is_contra',
        'parent_account_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_contra' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_account_id');
    }

    public function children()
    {
        return $this->hasMany(Account::class, 'parent_account_id');
    }

    public function journalEntryLines()
    {
        return $this->hasMany(JournalEntryLine::class);
    }

    public function balances()
    {
        return $this->hasMany(AccountBalance::class);
    }

    public function currentBalance($financialPeriodId = null)
    {
        $periodId = $financialPeriodId ?? FinancialPeriod::where('status', 'open')->first()?->id;
        
        if (!$periodId) {
            return 0;
        }

        $balance = $this->balances()->where('financial_period_id', $periodId)->first();
        return $balance?->closing_balance ?? 0;
    }

    public function getNormalBalanceAttribute()
    {
        return in_array($this->type, ['asset', 'expense']) ? 'debit' : 'credit';
    }

    public function getFullNameAttribute()
    {
        return $this->code . ' - ' . $this->name;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOfSubtype($query, $subtype)
    {
        return $query->where('subtype', $subtype);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_account_id');
    }
}
