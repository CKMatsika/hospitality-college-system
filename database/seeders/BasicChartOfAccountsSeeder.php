<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChartOfAccount;

class BasicChartOfAccountsSeeder extends Seeder
{
    public function run(): void
    {
        // Create basic chart of accounts for testing
        $accounts = [
            ['account_code' => '1000', 'name' => 'Cash', 'type' => 'asset'],
            ['account_code' => '1100', 'name' => 'Accounts Receivable', 'type' => 'asset'],
            ['account_code' => '4000', 'name' => 'Tuition Fee Revenue', 'type' => 'revenue'],
            ['account_code' => '5000', 'name' => 'Operating Expenses', 'type' => 'expense'],
        ];

        foreach ($accounts as $account) {
            ChartOfAccount::create($account);
        }
    }
}
