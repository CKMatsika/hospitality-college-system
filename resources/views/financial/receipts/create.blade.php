@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-receipt mr-3"></i>
                    Generate Receipt
                </h1>
                <a href="{{ route('financial.receipts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Receipts
                </a>
            </div>
            <p class="text-gray-600 mt-2">Generate a new receipt for payment received</p>
        </div>

        <!-- Form -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('financial.receipts.store') }}" class="space-y-6">
                    @csrf

                    <!-- Receipt Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="receipt_date" class="block text-sm font-medium text-gray-700">
                                Receipt Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="receipt_date" name="receipt_date" required
                                   value="{{ now()->format('Y-m-d') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                            @error('receipt_date')
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
                            <label for="payment_method_id" class="block text-sm font-medium text-gray-700">
                                Payment Method <span class="text-red-500">*</span>
                            </label>
                            <select id="payment_method_id" name="payment_method_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Payment Method</option>
                                @foreach($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }} ({{ $paymentMethod->provider }})</option>
                                @endforeach
                            </select>
                            @error('payment_method_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

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
                            @error('bank_account_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="customer_type" class="block text-sm font-medium text-gray-700">
                                Customer Type <span class="text-red-500">*</span>
                            </label>
                            <select id="customer_type" name="customer_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Customer Type</option>
                                <option value="student">Student</option>
                                <option value="staff">Staff</option>
                                <option value="other">Other</option>
                            </select>
                            @error('customer_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="invoice_id" class="block text-sm font-medium text-gray-700">
                                Invoice (Optional)
                            </label>
                            <select id="invoice_id" name="invoice_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Invoice</option>
                                @foreach($invoices as $invoice)
                                    <option value="{{ $invoice->id }}">{{ $invoice->invoice_number }} - ${{ number_format($invoice->balance, 2) }}</option>
                                @endforeach
                            </select>
                            @error('invoice_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="student_field" style="display: none;">
                            <label for="student_id" class="block text-sm font-medium text-gray-700">
                                Student <span class="text-red-500">*</span>
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
                                Staff Member <span class="text-red-500">*</span>
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

                        <div id="other_customer_field" style="display: none;">
                            <label for="customer_name" class="block text-sm font-medium text-gray-700">
                                Customer Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="customer_name" name="customer_name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="Enter customer name">
                            @error('customer_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="other_customer_email_field" style="display: none;">
                            <label for="customer_email" class="block text-sm font-medium text-gray-700">
                                Customer Email
                            </label>
                            <input type="email" id="customer_email" name="customer_email"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="customer@example.com">
                            @error('customer_email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Receipt Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="reference" class="block text-sm font-medium text-gray-700">
                                Reference Number
                            </label>
                            <input type="text" id="reference" name="reference"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                   placeholder="e.g., PAY-001, REF-123">
                            @error('reference')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select id="category" name="category" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300">
                                <option value="">Select Category</option>
                                <option value="tuition">Tuition Fees</option>
                                <option value="fees">Other Fees</option>
                                <option value="accommodation">Accommodation</option>
                                <option value="meals">Meals</option>
                                <option value="transport">Transportation</option>
                                <option value="supplies">Supplies</option>
                                <option value="other">Other</option>
                            </select>
                            @error('category')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="3" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300"
                                  placeholder="Enter payment description"></textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Options -->
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="send_email" name="send_email" value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="send_email" class="ml-2 block text-sm text-gray-900">
                                Send Email Receipt
                            </label>
                            <p class="text-sm text-gray-500">Send receipt copy to customer's email</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="print_receipt" name="print_receipt" value="1" checked
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="print_receipt" class="ml-2 block text-sm text-gray-900">
                                Print Receipt
                            </label>
                            <p class="text-sm text-gray-500">Generate printable receipt after saving</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-receipt mr-2"></i>
                            Generate Receipt
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const customerTypeSelect = document.getElementById('customer_type');
    const studentField = document.getElementById('student_field');
    const staffField = document.getElementById('staff_field');
    const otherCustomerField = document.getElementById('other_customer_field');
    const otherCustomerEmailField = document.getElementById('other_customer_email_field');

    function toggleCustomerFields() {
        const value = customerTypeSelect.value;
        
        studentField.style.display = value === 'student' ? 'block' : 'none';
        staffField.style.display = value === 'staff' ? 'block' : 'none';
        otherCustomerField.style.display = value === 'other' ? 'block' : 'none';
        otherCustomerEmailField.style.display = value === 'other' ? 'block' : 'none';
        
        // Clear values when hiding
        if (value !== 'student') {
            document.getElementById('student_id').value = '';
        }
        if (value !== 'staff') {
            document.getElementById('staff_id').value = '';
        }
        if (value !== 'other') {
            document.getElementById('customer_name').value = '';
            document.getElementById('customer_email').value = '';
        }
    }

    customerTypeSelect.addEventListener('change', toggleCustomerFields);
});
</script>
@endsection
