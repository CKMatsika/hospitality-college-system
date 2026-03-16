<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinancialPeriod;

class FinancialPeriodSeeder extends Seeder
{
    public function run(): void
    {
        FinancialPeriod::create([
            'name' => '2026 Academic Year',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'status' => 'open',
        ]);
    }
}
