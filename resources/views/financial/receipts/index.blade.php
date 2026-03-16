@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-receipt mr-3"></i>
                    Receipts
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('financial.receipts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Generate Receipt
                    </a>
                    <a href="{{ route('financial.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-green-700">
                        <i class="fas fa-chart-line mr-2"></i>
                        Financial Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Manage and track all financial receipts</p>
        </div>

        <!-- Receipts Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-receipt text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Receipts</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $receipts->total() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-dollar-sign text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Amount</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($receipts->sum('amount'), 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-calendar-day text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Today's Receipts</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $receipts->where('receipt_date', today())->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-credit-card text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Payment Methods</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $receipts->pluck('payment_method_id')->unique()->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Receipts List -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-list mr-2"></i>
                        Receipt Records
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $receipts->total() }} total receipts
                    </div>
                </div>

                @if($receipts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Receipt #
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Customer
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payment Method
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($receipts as $receipt)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $receipt->receipt_number }}</div>
                                            @if($receipt->invoice)
                                                <div class="text-xs text-gray-500">Invoice: {{ $receipt->invoice->invoice_number }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $receipt->receipt_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $receipt->receipt_date->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if($receipt->student)
                                                    {{ $receipt->student->first_name }} {{ $receipt->student->last_name }}
                                                @elseif($receipt->staff)
                                                    {{ $receipt->staff->first_name }} {{ $receipt->staff->last_name }}
                                                @else
                                                    {{ $receipt->customer_name ?? 'N/A' }}
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                @if($receipt->student)
                                                    Student
                                                @elseif($receipt->staff)
                                                    Staff
                                                @else
                                                    Customer
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $receipt->description }}</div>
                                            @if($receipt->reference_number)
                                                <div class="text-xs text-gray-500">Ref: {{ $receipt->reference_number }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">${{ number_format($receipt->amount, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if($receipt->paymentMethod)
                                                    {{ $receipt->paymentMethod->name }}
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($receipt->status === 'paid')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Paid
                                                </span>
                                            @elseif($receipt->status === 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ ucfirst($receipt->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button type="button" class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    View
                                                </button>
                                                <button type="button" class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-download mr-1"></i>
                                                    PDF
                                                </button>
                                                <button type="button" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash mr-1"></i>
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $receipts->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-receipt text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No receipts found</p>
                        <p class="text-gray-400 text-sm mt-2">Generate your first receipt to get started</p>
                        <div class="mt-6">
                            <a href="{{ route('financial.receipts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Generate First Receipt
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
