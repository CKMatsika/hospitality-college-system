@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-credit-card mr-3"></i>
                    Add Payment Method
                </h1>
                <a href="{{ route('financial.payment-methods.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Payment Methods
                </a>
            </div>
            <p class="text-gray-600 mt-2">Configure a new payment method for transactions</p>
        </div>

        <!-- Form -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('financial.payment-methods.store') }}" class="space-y-6">
                    @csrf

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Payment Method Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., Visa Card, PayNow, Mobile Money">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">
                                Payment Type <span class="text-red-500">*</span>
                            </label>
                            <select id="type" name="type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Payment Type</option>
                                <option value="mobile_money">Mobile Money</option>
                                <option value="bank_card">Bank Card (Credit/Debit)</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="online_payment">Online Payment Gateway</option>
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                            </select>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="provider" class="block text-sm font-medium text-gray-700">
                                Provider
                            </label>
                            <input type="text" id="provider" name="provider"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., Visa, Mastercard, PayPal, PayNow">
                            @error('provider')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="account_number" class="block text-sm font-medium text-gray-700">
                                Account Number / Merchant ID
                            </label>
                            <input type="text" id="account_number" name="account_number"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., Merchant ID, Account Number">
                            @error('account_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Configuration -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="transaction_fee" class="block text-sm font-medium text-gray-700">
                                Transaction Fee (%)
                            </label>
                            <input type="number" id="transaction_fee" name="transaction_fee" step="0.01" min="0" max="100"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 2.5">
                            @error('transaction_fee')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="min_amount" class="block text-sm font-medium text-gray-700">
                                Minimum Amount ($)
                            </label>
                            <input type="number" id="min_amount" name="min_amount" step="0.01" min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 10.00">
                            @error('min_amount')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="max_amount" class="block text-sm font-medium text-gray-700">
                                Maximum Amount ($)
                            </label>
                            <input type="number" id="max_amount" name="max_amount" step="0.01" min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 10000.00">
                            @error('max_amount')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- API Configuration -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="api_key" class="block text-sm font-medium text-gray-700">
                                API Key
                            </label>
                            <input type="password" id="api_key" name="api_key"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="Enter API key for payment gateway">
                            @error('api_key')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="api_secret" class="block text-sm font-medium text-gray-700">
                                API Secret
                            </label>
                            <input type="password" id="api_secret" name="api_secret"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="Enter API secret for payment gateway">
                            @error('api_secret')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Settings -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700">
                                Sort Order
                            </label>
                            <input type="number" id="sort_order" name="sort_order" value="1" min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="Display order (lower numbers appear first)">
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="settlement_days" class="block text-sm font-medium text-gray-700">
                                Settlement Days
                            </label>
                            <input type="number" id="settlement_days" name="settlement_days" value="2" min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="Number of days for settlement">
                            @error('settlement_days')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                  placeholder="Enter description of this payment method"></textarea>
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
                                Active Payment Method
                            </label>
                            <p class="text-sm text-gray-500">Enable this payment method for transactions</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="requires_approval" name="requires_approval" value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="requires_approval" class="ml-2 block text-sm text-gray-900">
                                Requires Approval
                            </label>
                            <p class="text-sm text-gray-500">Transactions require manual approval</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="supports_refunds" name="supports_refunds" value="1" checked
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="supports_refunds" class="ml-2 block text-sm text-gray-900">
                                Supports Refunds
                            </label>
                            <p class="text-sm text-gray-500">Allow refunds through this payment method</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>
                            Save Payment Method
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
