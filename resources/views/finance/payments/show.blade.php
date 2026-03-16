@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-receipt mr-3"></i>
                    Payment Details
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('finance.payments.receipt', $payment->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-green-700">
                        <i class="fas fa-download mr-2"></i>
                        Download Receipt
                    </a>
                    <a href="{{ route('finance.payments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Payments
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">View detailed payment information and receipt</p>
        </div>

        <!-- Payment Details Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Receipt #{{ $payment->receipt_number }}
                    </h2>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            {{ ucfirst($payment->status ?? 'completed') }}
                        </span>
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $payment->payment_date->format('M d, Y') }}
                        </span>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h3>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Payment Amount:</dt>
                                    <dd class="text-sm font-bold text-gray-900">${{ number_format($payment->amount, 2) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Payment Method:</dt>
                                    <dd class="text-sm text-gray-900">{{ ucfirst($payment->payment_method) }}</dd>
                                </div>
                                @if($payment->reference_number)
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Transaction ID:</dt>
                                        <dd class="text-sm text-gray-900">{{ $payment->reference_number }}</dd>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Received By:</dt>
                                    <dd class="text-sm text-gray-900">{{ $payment->receivedBy->name ?? 'System' }}</dd>
                                </div>
                                @if($payment->notes)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Notes:</dt>
                                        <dd class="text-sm text-gray-900 mt-1">{{ $payment->notes }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Student Information</h3>
                            @if($payment->studentFee && $payment->studentFee->student)
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Student Name:</dt>
                                        <dd class="text-sm text-gray-900">{{ $payment->studentFee->student->first_name }} {{ $payment->studentFee->student->last_name }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Student ID:</dt>
                                        <dd class="text-sm text-gray-900">{{ $payment->studentFee->student->student_id }}</dd>
                                    </div>
                                    @if($payment->studentFee->student->email)
                                        <div class="flex justify-between">
                                            <dt class="text-sm font-medium text-gray-500">Email:</dt>
                                            <dd class="text-sm text-gray-900">{{ $payment->studentFee->student->email }}</dd>
                                        </div>
                                    @endif
                                </dl>
                            @else
                                <p class="text-sm text-gray-500">Student information not available</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Fee Information -->
                @if($payment->studentFee && $payment->studentFee->feeStructure)
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Fee Information</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fee Type:</dt>
                                    <dd class="text-sm text-gray-900 mt-1">{{ $payment->studentFee->feeStructure->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Fee:</dt>
                                    <dd class="text-sm text-gray-900 mt-1">${{ number_format($payment->studentFee->amount, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status:</dt>
                                    <dd class="text-sm text-gray-900 mt-1">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                                            $payment->studentFee->status === 'paid' ? 'bg-green-100 text-green-800' : 
                                            ($payment->studentFee->status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') 
                                        }}">
                                            {{ ucfirst($payment->studentFee->status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                            
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 border-t pt-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Amount Paid:</dt>
                                    <dd class="text-sm font-medium text-green-600 mt-1">${{ number_format($payment->studentFee->paid, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Balance:</dt>
                                    <dd class="text-sm font-medium {{ $payment->studentFee->balance > 0 ? 'text-red-600' : 'text-green-600' }} mt-1">
                                        ${{ number_format($payment->studentFee->balance, 2) }}
                                    </dd>
                                </div>
                                @if($payment->studentFee->due_date)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Due Date:</dt>
                                        <dd class="text-sm text-gray-900 mt-1">{{ $payment->studentFee->due_date->format('M d, Y') }}</dd>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('finance.payments.receipt', $payment->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-green-700">
                <i class="fas fa-print mr-2"></i>
                Print Receipt
            </a>
            <a href="{{ route('finance.payments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                <i class="fas fa-list mr-2"></i>
                All Payments
            </a>
        </div>
    </div>
</div>
@endsection
