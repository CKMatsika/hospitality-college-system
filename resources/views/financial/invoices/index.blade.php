@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-file-invoice-dollar mr-3"></i>
                    Enhanced Invoices
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('accounting.invoices.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Create Invoice
                    </a>
                    <a href="{{ route('financial.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-green-700">
                        <i class="fas fa-chart-line mr-2"></i>
                        Financial Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Manage invoices with integrated payment processing and tracking</p>
        </div>

        <!-- Invoice Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-file-invoice text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Invoices</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $invoices->total() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Paid Invoices</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $invoices->where('status', 'paid')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $invoices->where('status', 'pending')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-dollar-sign text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($invoices->sum('total'), 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices List -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-list mr-2"></i>
                        Invoice Management
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $invoices->total() }} total invoices
                    </div>
                </div>

                @if($invoices->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Invoice #
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Customer
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Due Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Paid
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Balance
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
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $invoice->invoice_number }}</div>
                                            <div class="text-xs text-gray-500">{{ $invoice->type ?? 'Standard' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if($invoice->invoiceable_type === 'App\Models\Student')
                                                    {{ $invoice->invoiceable->first_name }} {{ $invoice->invoiceable->last_name }}
                                                @elseif($invoice->invoiceable_type === 'App\Models\Staff')
                                                    {{ $invoice->invoiceable->first_name }} {{ $invoice->invoiceable->last_name }}
                                                @else
                                                    {{ $invoice->customer_name ?? 'N/A' }}
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                @if($invoice->invoiceable_type === 'App\Models\Student')
                                                    Student
                                                @elseif($invoice->invoiceable_type === 'App\Models\Staff')
                                                    Staff
                                                @else
                                                    {{ $invoice->invoiceable_type ? class_basename($invoice->invoiceable_type) : 'Customer' }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $invoice->invoice_date->format('M d, Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $invoice->due_date->format('M d, Y') }}</div>
                                            @if($invoice->due_date->isPast() && $invoice->status !== 'paid')
                                                <div class="text-xs text-red-600">Overdue</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">${{ number_format($invoice->total, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-green-600">${{ number_format($invoice->amount_paid, 2) }}</div>
                                            @if($invoice->payments->count() > 0)
                                                <div class="text-xs text-gray-500">{{ $invoice->payments->count() }} payment(s)</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium {{ $invoice->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                                ${{ number_format($invoice->balance, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($invoice->status === 'paid')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Paid
                                                </span>
                                            @elseif($invoice->status === 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @elseif($invoice->status === 'overdue')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Overdue
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('accounting.invoices.show', $invoice->id) }}" class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    View
                                                </a>
                                                @if($invoice->balance > 0)
                                                    <form method="POST" action="{{ route('financial.invoices.payment.process', $invoice->id) }}" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                                            <i class="fas fa-credit-card mr-1"></i>
                                                            Pay
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($invoice->status !== 'posted')
                                                    <form method="POST" action="{{ route('accounting.invoices.post', $invoice->id) }}" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-purple-600 hover:text-purple-900">
                                                            <i class="fas fa-check mr-1"></i>
                                                            Post
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $invoices->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-file-invoice text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No invoices found</p>
                        <p class="text-gray-400 text-sm mt-2">Create your first invoice to get started</p>
                        <div class="mt-6">
                            <a href="{{ route('accounting.invoices.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Create First Invoice
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Payment Activity -->
        <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-clock mr-2"></i>
                    Recent Payment Activity
                </h3>
                
                <div class="space-y-3">
                    @php
                        $recentPayments = collect();
                        foreach($invoices as $invoice) {
                            foreach($invoice->payments as $payment) {
                                $recentPayments->push((object)[
                                    'invoice' => $invoice,
                                    'payment' => $payment,
                                    'date' => $payment->created_at
                                ]);
                            }
                        }
                        $recentPayments = $recentPayments->sortByDesc('date')->take(5);
                    @endphp
                    
                    @if($recentPayments->count() > 0)
                        @foreach($recentPayments as $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-credit-card text-green-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            Invoice #{{ $item->invoice->invoice_number }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $item->payment->payment_method->name ?? 'Payment Method' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-green-600">
                                        ${{ number_format($item->payment->amount, 2) }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $item->date->format('M d, Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-credit-card text-gray-400 text-3xl mb-2"></i>
                            <p class="text-gray-500 text-sm">No recent payment activity</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
