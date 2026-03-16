@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-university mr-3"></i>
                    Add New Bank
                </h1>
                <a href="{{ route('financial.banks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Banks
                </a>
            </div>
            <p class="text-gray-600 mt-2">Register a new banking institution in the system</p>
        </div>

        <!-- Form -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('financial.banks.store') }}" class="space-y-6">
                    @csrf

                    <!-- Bank Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="bank_code" class="block text-sm font-medium text-gray-700">
                                Bank Code <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="bank_code" name="bank_code" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., BOJ, NCB, SCB">
                            @error('bank_code')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bank_name" class="block text-sm font-medium text-gray-700">
                                Bank Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="bank_name" name="bank_name" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., Bank of Jamaica, National Commercial Bank">
                            @error('bank_name')
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

                        <div>
                            <label for="branch_name" class="block text-sm font-medium text-gray-700">
                                Branch Name
                            </label>
                            <input type="text" id="branch_name" name="branch_name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., Main Branch, Downtown Branch">
                            @error('branch_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">
                                Address
                            </label>
                            <textarea id="address" name="address" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                      placeholder="Enter bank address"></textarea>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">
                                City
                            </label>
                            <input type="text" id="city" name="city"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., Kingston, Montego Bay">
                            @error('city')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700">
                                Country
                            </label>
                            <input type="text" id="country" name="country"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., Jamaica, United States">
                            @error('country')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700">
                                Postal Code
                            </label>
                            <input type="text" id="postal_code" name="postal_code"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 00000, JM12345">
                            @error('postal_code')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Contact Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Phone
                            </label>
                            <input type="tel" id="phone" name="phone"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., +1-876-123-4567">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email
                            </label>
                            <input type="email" id="email" name="email"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., info@bank.com">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700">
                                Website
                            </label>
                            <input type="url" id="website" name="website"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., https://www.bank.com">
                            @error('website')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="contact_person" class="block text-sm font-medium text-gray-700">
                                Contact Person
                            </label>
                            <input type="text" id="contact_person" name="contact_person"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., John Smith, Branch Manager">
                            @error('contact_person')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="account_number" class="block text-sm font-medium text-gray-700">
                                Account Number
                            </label>
                            <input type="text" id="account_number" name="account_number"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 1234567890">
                            @error('account_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status and Notes -->
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" checked
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Active Bank
                            </label>
                            <p class="text-sm text-gray-500">Mark this bank as active for transactions</p>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">
                                Notes
                            </label>
                            <textarea id="notes" name="notes" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                      placeholder="Enter any additional notes about this bank"></textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>
                            Save Bank
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
