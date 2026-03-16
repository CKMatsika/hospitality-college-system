@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-money-bill-wave mr-3"></i>
                    Add Cash Transaction
                </h1>
                <a href="{{ route('financial.cash-book.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Cash Book
                </a>
            </div>
            <p class="text-gray-600 mt-2">Record a new cash transaction (credit or debit)</p>
        </div>

        <!-- Form -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('financial.cash-book.store') }}" class="space-y-6">
                    @csrf

                    <!-- Transaction Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="transaction_date" class="block text-sm font-medium text-gray-700">
                                Transaction Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="transaction_date" name="transaction_date" required
                                   value="{{ now()->format('Y-m-d') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                            @error('transaction_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="transaction_type" class="block text-sm font-medium text-gray-700">
                                Transaction Type <span class="text-red-500">*</span>
                            </label>
                            <select id="transaction_type" name="transaction_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Type</option>
                                <option value="credit">Credit (Money In)</option>
                                <option value="debit">Debit (Money Out)</option>
                            </select>
                            @error('transaction_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">
                                Amount <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="amount" name="amount" required step="0.01" min="0.01"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., 1000.00">
                            @error('amount')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="reference_number" class="block text-sm font-medium text-gray-700">
                                Reference Number
                            </label>
                            <input type="text" id="reference_number" name="reference_number"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., RECEIPT-001, PAYMENT-001">
                            @error('reference_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description and Category -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="description" name="description" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., Student fee payment, Office supplies">
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">
                                Category
                            </label>
                            <select id="category" name="category"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Category</option>
                                <option value="fees">Student Fees</option>
                                <option value="supplies">Office Supplies</option>
                                <option value="salary">Salary/Wages</option>
                                <option value="utilities">Utilities</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="equipment">Equipment</option>
                                <option value="rent">Rent/Lease</option>
                                <option value="other">Other</option>
                            </select>
                            @error('category')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Account and Person Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="bank_account_id" class="block text-sm font-medium text-gray-700">
                                Bank Account
                            </label>
                            <select id="bank_account_id" name="bank_account_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Bank Account</option>
                                @foreach($bankAccounts as $bankAccount)
                                    <option value="{{ $bankAccount->id }}">{{ $bankAccount->account_name }} ({{ $bankAccount->bank->bank_name }})</option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-sm text-gray-500">Leave blank for cash transactions</p>
                            @error('bank_account_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="person_type" class="block text-sm font-medium text-gray-700">
                                Person Type
                            </label>
                            <select id="person_type" name="person_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Person Type</option>
                                <option value="student">Student</option>
                                <option value="staff">Staff</option>
                                <option value="other">Other</option>
                            </select>
                            @error('person_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="student_field" style="display: none;">
                            <label for="student_id" class="block text-sm font-medium text-gray-700">
                                Student
                            </label>
                            <select id="student_id" name="student_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="staff_field" style="display: none;">
                            <label for="staff_id" class="block text-sm font-medium text-gray-700">
                                Staff Member
                            </label>
                            <select id="staff_id" name="staff_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Staff Member</option>
                                @php
                                    $staffMembers = \App\Models\Staff::orderBy('first_name')->get();
                                @endphp
                                @foreach($staffMembers as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->first_name }} {{ $staff->last_name }}</option>
                                @endforeach
                            </select>
                            @error('staff_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="other_person_field" style="display: none;">
                            <label for="person_name" class="block text-sm font-medium text-gray-700">
                                Person Name
                            </label>
                            <input type="text" id="person_name" name="person_name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="Enter person's name">
                            @error('person_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">
                            Notes
                        </label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                  placeholder="Enter any additional notes about this transaction"></textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status and Settings -->
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="requires_approval" name="requires_approval" value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="requires_approval" class="ml-2 block text-sm text-gray-900">
                                Requires Approval
                            </label>
                            <p class="text-sm text-gray-500">Transaction requires manual approval before posting</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="is_recurring" name="is_recurring" value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="is_recurring" class="ml-2 block text-sm text-gray-900">
                                Recurring Transaction
                            </label>
                            <p class="text-sm text-gray-500">This is a recurring transaction</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>
                            Save Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const personTypeSelect = document.getElementById('person_type');
    const studentField = document.getElementById('student_field');
    const staffField = document.getElementById('staff_field');
    const otherPersonField = document.getElementById('other_person_field');

    function togglePersonFields() {
        const value = personTypeSelect.value;
        
        studentField.style.display = value === 'student' ? 'block' : 'none';
        staffField.style.display = value === 'staff' ? 'block' : 'none';
        otherPersonField.style.display = value === 'other' ? 'block' : 'none';
        
        // Clear values when hiding
        if (value !== 'student') {
            document.getElementById('student_id').value = '';
        }
        if (value !== 'staff') {
            document.getElementById('staff_id').value = '';
        }
        if (value !== 'other') {
            document.getElementById('person_name').value = '';
        }
    }

    personTypeSelect.addEventListener('change', togglePersonFields);
});
</script>
@endsection
