@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-list-alt mr-3"></i>
                    Add Bank Account
                </h1>
                <a href="{{ route('financial.bank-accounts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Bank Accounts
                </a>
            </div>
            <p class="text-gray-600 mt-2">Add a new bank account to track balances and transactions</p>
        </div>

        <!-- Form -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('financial.bank-accounts.store') }}" class="space-y-6">
                    @csrf

                    <!-- Bank Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="bank_id" class="block text-sm font-medium text-gray-700">
                                Bank <span class="text-red-500">*</span>
                            </label>
                            <select id="bank_id" name="bank_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Bank</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->bank_name }} - {{ $bank->branch_name ?? 'Main Branch' }}</option>
                                @endforeach
                            </select>
                            @error('bank_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="account_name" class="block text-sm font-medium text-gray-700">
                                Account Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="account_name" name="account_name" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., Main Operating Account, Payroll Account">
                            @error('account_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="account_number" class="block text-sm font-medium text-gray-700">
                                Account Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="account_number" name="account_number" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 1234567890">
                            @error('account_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="account_type" class="block text-sm font-medium text-gray-700">
                                Account Type <span class="text-red-500">*</span>
                            </label>
                            <select id="account_type" name="account_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Account Type</option>
                                <option value="checking">Checking Account</option>
                                <option value="savings">Savings Account</option>
                                <option value="business">Business Account</option>
                                <option value="investment">Investment Account</option>
                            </select>
                            @error('account_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Account Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="routing_number" class="block text-sm font-medium text-gray-700">
                                Routing Number
                            </label>
                            <input type="text" id="routing_number" name="routing_number"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 021000021">
                            @error('routing_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="swift_code" class="block text-sm font-medium text-gray-700">
                                SWIFT Code
                            </label>
                            <input type="text" id="swift_code" name="swift_code"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., BOJAUSJNXXX">
                            @error('swift_code')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700">
                                Currency
                            </label>
                            <select id="currency" name="currency"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="USD">USD - US Dollar</option>
                                <option value="JMD">JMD - Jamaican Dollar</option>
                                <option value="EUR">EUR - Euro</option>
                                <option value="GBP">GBP - British Pound</option>
                            </select>
                            @error('currency')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="branch_code" class="block text-sm font-medium text-gray-700">
                                Branch Code
                            </label>
                            <input type="text" id="branch_code" name="branch_code"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 001, MAIN">
                            @error('branch_code')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Balance Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="opening_balance" class="block text-sm font-medium text-gray-700">
                                Opening Balance
                            </label>
                            <input type="number" id="opening_balance" name="opening_balance" step="0.01" value="0.00"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 10000.00">
                            @error('opening_balance')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="current_balance" class="block text-sm font-medium text-gray-700">
                                Current Balance
                            </label>
                            <input type="number" id="current_balance" name="current_balance" step="0.01" value="0.00"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 15000.00">
                            @error('current_balance')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="available_balance" class="block text-sm font-medium text-gray-700">
                                Available Balance
                            </label>
                            <input type="number" id="available_balance" name="available_balance" step="0.01"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 14500.00">
                            @error('available_balance')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="overdraft_limit" class="block text-sm font-medium text-gray-700">
                                Overdraft Limit
                            </label>
                            <input type="number" id="overdraft_limit" name="overdraft_limit" step="0.01"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 5000.00">
                            @error('overdraft_limit')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="account_holder_name" class="block text-sm font-medium text-gray-700">
                                Account Holder Name
                            </label>
                            <input type="text" id="account_holder_name" name="account_holder_name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., Hospitality College Ltd">
                            @error('account_holder_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700">
                                Contact Phone
                            </label>
                            <input type="tel" id="contact_phone" name="contact_phone"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., +1-876-123-4567">
                            @error('contact_phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Payment Method Integration -->
                    <div>
                        <label for="default_payment_method_id" class="block text-sm font-medium text-gray-700">
                            Default Payment Method
                        </label>
                        <select id="default_payment_method_id" name="default_payment_method_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                            <option value="">Select Payment Method</option>
                            @foreach($paymentMethods as $paymentMethod)
                                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }} ({{ $paymentMethod->provider }})</option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-sm text-gray-500">Default payment method for transactions from this account</p>
                        @error('default_payment_method_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Information -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                  placeholder="Enter any additional notes about this account"></textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status and Settings -->
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" checked
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Active Account
                            </label>
                            <p class="text-sm text-gray-500">Enable this account for transactions</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="allow_overdraft" name="allow_overdraft" value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="allow_overdraft" class="ml-2 block text-sm text-gray-900">
                                Allow Overdraft
                            </label>
                            <p class="text-sm text-gray-500">Allow transactions to exceed available balance</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="requires_approval" name="requires_approval" value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="requires_approval" class="ml-2 block text-sm text-gray-900">
                                Requires Approval
                            </label>
                            <p class="text-sm text-gray-500">Transactions require manual approval</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>
                            Save Bank Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
