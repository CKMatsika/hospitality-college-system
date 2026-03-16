<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        // Assets
        $assets = [
            ['code' => '1000', 'name' => 'Cash and Cash Equivalents', 'type' => 'asset', 'subtype' => 'current_asset'],
            ['code' => '1010', 'name' => 'Petty Cash', 'type' => 'asset', 'subtype' => 'current_asset', 'parent_account_id' => 1],
            ['code' => '1020', 'name' => 'Bank Account - Main', 'type' => 'asset', 'subtype' => 'current_asset', 'parent_account_id' => 1],
            ['code' => '1100', 'name' => 'Accounts Receivable', 'type' => 'asset', 'subtype' => 'current_asset'],
            ['code' => '1200', 'name' => 'Student Tuition Receivable', 'type' => 'asset', 'subtype' => 'current_asset', 'parent_account_id' => 4],
            ['code' => '1300', 'name' => 'Prepaid Expenses', 'type' => 'asset', 'subtype' => 'prepaid_expense'],
            ['code' => '1310', 'name' => 'Prepaid Rent', 'type' => 'asset', 'subtype' => 'prepaid_expense', 'parent_account_id' => 6],
            ['code' => '1320', 'name' => 'Prepaid Insurance', 'type' => 'asset', 'subtype' => 'prepaid_expense', 'parent_account_id' => 6],
            ['code' => '1500', 'name' => 'Fixed Assets', 'type' => 'asset', 'subtype' => 'fixed_asset'],
            ['code' => '1510', 'name' => 'Furniture and Fixtures', 'type' => 'asset', 'subtype' => 'fixed_asset', 'parent_account_id' => 9],
            ['code' => '1520', 'name' => 'Computer Equipment', 'type' => 'asset', 'subtype' => 'fixed_asset', 'parent_account_id' => 9],
            ['code' => '1530', 'name' => 'Building', 'type' => 'asset', 'subtype' => 'fixed_asset', 'parent_account_id' => 9],
            ['code' => '1600', 'name' => 'Accumulated Depreciation', 'type' => 'asset', 'subtype' => 'fixed_asset', 'is_contra' => true],
            ['code' => '1610', 'name' => 'Accum. Depreciation - Furniture', 'type' => 'asset', 'subtype' => 'fixed_asset', 'is_contra' => true, 'parent_account_id' => 12],
        ];

        // Liabilities
        $liabilities = [
            ['code' => '2000', 'name' => 'Accounts Payable', 'type' => 'liability', 'subtype' => 'current_liability'],
            ['code' => '2100', 'name' => 'Salaries Payable', 'type' => 'liability', 'subtype' => 'current_liability'],
            ['code' => '2200', 'name' => 'Tax Payable', 'type' => 'liability', 'subtype' => 'current_liability'],
            ['code' => '2210', 'name' => 'VAT Payable', 'type' => 'liability', 'subtype' => 'current_liability', 'parent_account_id' => 15],
            ['code' => '2300', 'name' => 'Deferred Revenue', 'type' => 'liability', 'subtype' => 'deferred_revenue'],
            ['code' => '2310', 'name' => 'Unearned Tuition Fees', 'type' => 'liability', 'subtype' => 'deferred_revenue', 'parent_account_id' => 17],
            ['code' => '2500', 'name' => 'Long-term Liabilities', 'type' => 'liability', 'subtype' => 'long_term_liability'],
            ['code' => '2510', 'name' => 'Bank Loans', 'type' => 'liability', 'subtype' => 'long_term_liability', 'parent_account_id' => 19],
        ];

        // Equity
        $equity = [
            ['code' => '3000', 'name' => 'Owner\'s Equity', 'type' => 'equity', 'subtype' => 'share_capital'],
            ['code' => '3100', 'name' => 'Share Capital', 'type' => 'equity', 'subtype' => 'share_capital', 'parent_account_id' => 21],
            ['code' => '3200', 'name' => 'Retained Earnings', 'type' => 'equity', 'subtype' => 'retained_earnings'],
            ['code' => '3300', 'name' => 'Current Period Earnings', 'type' => 'equity', 'subtype' => 'retained_earnings'],
        ];

        // Revenue
        $revenue = [
            ['code' => '4000', 'name' => 'Tuition Fee Revenue', 'type' => 'revenue', 'subtype' => 'tuition_fee'],
            ['code' => '4100', 'name' => 'Registration Fee Revenue', 'type' => 'revenue', 'subtype' => 'registration_fee'],
            ['code' => '4200', 'name' => 'Other Fee Revenue', 'type' => 'revenue', 'subtype' => 'other_fee'],
            ['code' => '4210', 'name' => 'Library Fee Revenue', 'type' => 'revenue', 'subtype' => 'other_fee', 'parent_account_id' => 26],
            ['code' => '4220', 'name' => 'Lab Fee Revenue', 'type' => 'revenue', 'subtype' => 'other_fee', 'parent_account_id' => 26],
            ['code' => '4300', 'name' => 'Other Revenue', 'type' => 'revenue', 'subtype' => 'other_revenue'],
            ['code' => '4310', 'name' => 'Interest Income', 'type' => 'revenue', 'subtype' => 'other_revenue', 'parent_account_id' => 29],
            ['code' => '4320', 'name' => 'Rental Income', 'type' => 'revenue', 'subtype' => 'other_revenue', 'parent_account_id' => 29],
        ];

        // Expenses
        $expenses = [
            ['code' => '5000', 'name' => 'Salaries and Wages', 'type' => 'expense', 'subtype' => 'salaries'],
            ['code' => '5100', 'name' => 'Teaching Staff Salaries', 'type' => 'expense', 'subtype' => 'salaries', 'parent_account_id' => 31],
            ['code' => '5110', 'name' => 'Administrative Staff Salaries', 'type' => 'expense', 'subtype' => 'salaries', 'parent_account_id' => 31],
            ['code' => '5200', 'name' => 'Rent Expense', 'type' => 'expense', 'subtype' => 'rent'],
            ['code' => '5300', 'name' => 'Utilities', 'type' => 'expense', 'subtype' => 'utilities'],
            ['code' => '5310', 'name' => 'Electricity', 'type' => 'expense', 'subtype' => 'utilities', 'parent_account_id' => 35],
            ['code' => '5320', 'name' => 'Water', 'type' => 'expense', 'subtype' => 'utilities', 'parent_account_id' => 35],
            ['code' => '5330', 'name' => 'Internet', 'type' => 'expense', 'subtype' => 'utilities', 'parent_account_id' => 35],
            ['code' => '5400', 'name' => 'Supplies', 'type' => 'expense', 'subtype' => 'supplies'],
            ['code' => '5410', 'name' => 'Office Supplies', 'type' => 'expense', 'subtype' => 'supplies', 'parent_account_id' => 39],
            ['code' => '5420', 'name' => 'Teaching Supplies', 'type' => 'expense', 'subtype' => 'supplies', 'parent_account_id' => 39],
            ['code' => '5500', 'name' => 'Depreciation Expense', 'type' => 'expense', 'subtype' => 'depreciation'],
            ['code' => '5510', 'name' => 'Depreciation - Furniture', 'type' => 'expense', 'subtype' => 'depreciation', 'parent_account_id' => 42],
            ['code' => '5520', 'name' => 'Depreciation - Equipment', 'type' => 'expense', 'subtype' => 'depreciation', 'parent_account_id' => 42],
            ['code' => '6000', 'name' => 'Other Expenses', 'type' => 'expense', 'subtype' => 'other_expense'],
            ['code' => '6100', 'name' => 'Marketing Expenses', 'type' => 'expense', 'subtype' => 'other_expense', 'parent_account_id' => 45],
            ['code' => '6200', 'name' => 'Professional Fees', 'type' => 'expense', 'subtype' => 'other_expense', 'parent_account_id' => 45],
            ['code' => '6300', 'name' => 'Travel Expenses', 'type' => 'expense', 'subtype' => 'other_expense', 'parent_account_id' => 45],
        ];

        $allAccounts = array_merge($assets, $liabilities, $equity, $revenue, $expenses);

        foreach ($allAccounts as $accountData) {
            Account::create($accountData);
        }
    }
}
