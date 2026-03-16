@extends('layouts.qbo')

@section('title', 'Record Payment')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-money-check-alt mr-2"></i>
            Record Payment
        </h1>
        <p class="text-gray-600 mt-2">Record a new student payment.</p>
    </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('finance.payments.store') }}" method="POST">
                        @csrf
                        
                        <!-- Payment Type Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Payment Type</label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="payment_type" value="invoice" checked class="mr-2" onchange="togglePaymentType()">
                                    <span class="text-sm">Invoice Payment</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="payment_type" value="advance" class="mr-2" onchange="togglePaymentType()">
                                    <span class="text-sm">Advance Payment</span>
                                </label>
                            </div>
                        </div>

                        <div id="invoice-section">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="student_fee_id" class="block text-sm font-medium text-gray-700">Student Fee</label>
                                    <select id="student_fee_id" name="student_fee_id" required
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        <option value="">Select a student fee</option>
                                        @foreach($studentFees as $studentFee)
                                            <option value="{{ $studentFee->id }}" {{ old('student_fee_id') == $studentFee->id ? 'selected' : '' }}>
                                                {{ $studentFee->student->full_name ?? 'N/A' }} - {{ $studentFee->feeStructure->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('student_fee_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div id="advance-section" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="student_id" class="block text-sm font-medium text-gray-700">Student</label>
                                    <select id="student_id" name="student_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        <option value="">Select a student</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                                {{ $student->full_name }} - {{ $student->student_id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="fee_structure_id" class="block text-sm font-medium text-gray-700">Fee Structure (Optional)</label>
                                    <select id="fee_structure_id" name="fee_structure_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        <option value="">Select a fee structure (optional)</option>
                                        @foreach($feeStructures as $feeStructure)
                                            <option value="{{ $feeStructure->id }}" {{ old('fee_structure_id') == $feeStructure->id ? 'selected' : '' }}>
                                                {{ $feeStructure->name }} - {{ $feeStructure->amount }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('fee_structure_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <select id="payment_method" name="payment_method" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="mobile_money">Mobile Money</option>
                                    <option value="check">Check</option>
                                </select>
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="transaction_id" class="block text-sm font-medium text-gray-700">Transaction ID</label>
                                <input type="text" id="transaction_id" name="transaction_id" value="{{ old('transaction_id') }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <p class="mt-1 text-sm text-gray-500">Transaction reference number (optional)</p>
                                @error('transaction_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="number" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                                <input type="date" id="payment_date" name="payment_date" value="{{ old('payment_date', now()->format('Y-m-d')) }}" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                @error('payment_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Payment Notes</label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('notes') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Add any additional notes about this payment.</p>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="generate_receipt" value="1" checked class="mr-2">
                                <span class="text-sm font-medium text-gray-700">Generate Receipt</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500">Automatically generate and download receipt after payment is recorded.</p>
                        </div>

                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('finance.payments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-money-bill-wave mr-2"></i> Record Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePaymentType() {
            const paymentType = document.querySelector('input[name="payment_type"]:checked').value;
            const invoiceSection = document.getElementById('invoice-section');
            const advanceSection = document.getElementById('advance-section');
            const studentFeeSelect = document.getElementById('student_fee_id');
            const studentSelect = document.getElementById('student_id');
            
            if (paymentType === 'invoice') {
                invoiceSection.style.display = 'block';
                advanceSection.style.display = 'none';
                studentFeeSelect.required = true;
                studentSelect.required = false;
            } else {
                invoiceSection.style.display = 'none';
                advanceSection.style.display = 'block';
                studentFeeSelect.required = false;
                studentSelect.required = true;
            }
        }
    </script>
@endsection
