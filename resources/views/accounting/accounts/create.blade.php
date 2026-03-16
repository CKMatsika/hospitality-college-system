@extends('layouts.qbo')

@section('title', 'Create Account')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-plus mr-2"></i>
            Create New Account
        </h1>
        <p class="text-gray-600 mt-2">Add a new account to your chart of accounts.</p>
    </div>

    <!-- Account Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('accounting.accounts.store') }}" class="space-y-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="account_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Account Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="account_code" name="account_code" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="e.g., 1000">
                    <p class="mt-1 text-xs text-gray-500">Unique identifier for the account (e.g., 1000, 2000)</p>
                </div>
                
                <div>
                    <label for="account_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Account Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="account_name" name="account_name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="e.g., Cash and Cash Equivalents">
                    <p class="mt-1 text-xs text-gray-500">Descriptive name for the account</p>
                </div>
            </div>

            <!-- Account Type and Classification -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="account_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Account Type <span class="text-red-500">*</span>
                    </label>
                    <select id="account_type" name="account_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Select Account Type</option>
                        <option value="asset">Asset</option>
                        <option value="liability">Liability</option>
                        <option value="equity">Equity</option>
                        <option value="revenue">Revenue</option>
                        <option value="expense">Expense</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Financial statement category</p>
                </div>
                
                <div>
                    <label for="account_classification" class="block text-sm font-medium text-gray-700 mb-2">
                        Account Classification <span class="text-red-500">*</span>
                    </label>
                    <select id="account_classification" name="account_classification" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Select Classification</option>
                        <option value="current">Current</option>
                        <option value="non_current">Non-Current</option>
                        <option value="operating">Operating</option>
                        <option value="non_operating">Non-Operating</option>
                        <option value="equity">Equity</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Balance sheet classification</p>
                </div>
            </div>

            <!-- Parent Account and Description -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="parent_account_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Parent Account
                    </label>
                    <select id="parent_account_id" name="parent_account_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">None (Top Level Account)</option>
                        <option value="1000">1000 - Cash and Cash Equivalents</option>
                        <option value="1100">1100 - Accounts Receivable</option>
                        <option value="2000">2000 - Accounts Payable</option>
                        <option value="3000">3000 - Owner's Equity</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Hierarchical parent account</p>
                </div>
                
                <div>
                    <label for="account_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="account_description" name="account_description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                              placeholder="Detailed description of the account purpose and usage"></textarea>
                    <p class="mt-1 text-xs text-gray-500">Additional information about the account</p>
                </div>
            </div>

            <!-- Opening Balance and Currency -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="opening_balance" class="block text-sm font-medium text-gray-700 mb-2">
                        Opening Balance
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" id="opening_balance" name="opening_balance" step="0.01"
                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="0.00">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Initial balance when creating the account</p>
                </div>
                
                <div>
                    <label for="account_currency" class="block text-sm font-medium text-gray-700 mb-2">
                        Currency
                    </label>
                    <select id="account_currency" name="account_currency"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="USD" selected>USD - US Dollar</option>
                        <option value="EUR">EUR - Euro</option>
                        <option value="GBP">GBP - British Pound</option>
                        <option value="CAD">CAD - Canadian Dollar</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Account currency</p>
                </div>
            </div>

            <!-- Account Status and Settings -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="account_status" class="block text-sm font-medium text-gray-700 mb-2">
                        Account Status <span class="text-red-500">*</span>
                    </label>
                    <select id="account_status" name="account_status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="archived">Archived</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Current status of the account</p>
                </div>
                
                <div>
                    <label for="allow_posting" class="block text-sm font-medium text-gray-700 mb-2">
                        Allow Posting
                    </label>
                    <div class="flex items-center">
                        <input id="allow_posting" name="allow_posting" type="checkbox" value="1" checked
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="allow_posting" class="ml-2 text-sm text-gray-700">
                            Enable transactions for this account
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Whether transactions can be posted to this account</p>
                </div>
                
                <div>
                    <label for="requires_approval" class="block text-sm font-medium text-gray-700 mb-2">
                        Requires Approval
                    </label>
                    <div class="flex items-center">
                        <input id="requires_approval" name="requires_approval" type="checkbox" value="1"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="requires_approval" class="ml-2 text-sm text-gray-700">
                            Transactions require approval
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Whether transactions need approval</p>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="account_notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Additional Notes
                </label>
                <textarea id="account_notes" name="account_notes" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                          placeholder="Any additional notes or comments about this account"></textarea>
                <p class="mt-1 text-xs text-gray-500">Internal notes for reference</p>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('accounting.accounts') }}" 
                   class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>
                    Create Account
                </button>
            </div>
        </form>
    </div>
@endsection
