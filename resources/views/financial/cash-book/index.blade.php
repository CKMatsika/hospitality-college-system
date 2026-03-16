@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-money-bill-wave mr-3"></i>
                    Cash Book
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('financial.cash-book.create') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 border border-transparent rounded-lg font-bold text-black text-lg hover:bg-emerald-700 shadow-lg transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Add Transaction
                    </a>
                    <a href="{{ route('financial.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-chart-line mr-2"></i>
                        Financial Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Manage cash transactions and track cash flow</p>
        </div>

        <!-- Cash Book Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-dollar-sign text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Current Balance</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($balance, 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-arrow-up text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Credits</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($transactions->where('transaction_type', 'credit')->sum('amount'), 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                            <i class="fas fa-arrow-down text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Debits</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($transactions->where('transaction_type', 'debit')->sum('amount'), 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-list text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Transactions</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $transactions->total() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions List -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-list mr-2"></i>
                        Cash Transactions
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $transactions->total() }} total transactions
                    </div>
                </div>

                @if($transactions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Account
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Person
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
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $transaction->transaction_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $transaction->transaction_date->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $transaction->description }}</div>
                                            @if($transaction->reference_number)
                                                <div class="text-xs text-gray-500">Ref: {{ $transaction->reference_number }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($transaction->transaction_type === 'credit')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Credit
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Debit
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium {{ $transaction->transaction_type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                                ${{ number_format($transaction->amount, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if($transaction->bankAccount)
                                                    {{ $transaction->bankAccount->account_name }}
                                                @else
                                                    Cash
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if($transaction->student)
                                                    {{ $transaction->student->first_name }} {{ $transaction->student->last_name }}
                                                @elseif($transaction->staff)
                                                    {{ $transaction->staff->first_name }} {{ $transaction->staff->last_name }}
                                                @else
                                                    {{ $transaction->person_name ?? 'N/A' }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($transaction->approved_by)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Approved
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button type="button" class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    View
                                                </button>
                                                @if(!$transaction->approved_by)
                                                    <button type="button" class="text-green-600 hover:text-green-900">
                                                        <i class="fas fa-check mr-1"></i>
                                                        Approve
                                                    </button>
                                                @endif
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
                        {{ $transactions->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-money-bill-wave text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No cash transactions found</p>
                        <p class="text-gray-400 text-sm mt-2">Add your first cash transaction to get started</p>
                        <div class="mt-6">
                            <a href="{{ route('financial.cash-book.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Add First Transaction
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Activity Summary -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Daily Summary -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-calendar-day mr-2"></i>
                        Today's Summary
                    </h3>
                    @php
                        $todayTransactions = $transactions->filter(function($t) {
                            return $t->transaction_date->isToday();
                        });
                    @endphp
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">
                                ${{ number_format($todayTransactions->where('transaction_type', 'credit')->sum('amount'), 2) }}
                            </div>
                            <div class="text-sm text-green-800">Credits Today</div>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <div class="text-2xl font-bold text-red-600">
                                ${{ number_format($todayTransactions->where('transaction_type', 'debit')->sum('amount'), 2) }}
                            </div>
                            <div class="text-sm text-red-800">Debits Today</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Summary -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Monthly Summary
                    </h3>
                    @php
                        $monthlyTransactions = $transactions->filter(function($t) {
                            return $t->transaction_date->isCurrentMonth();
                        });
                    @endphp
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">
                                ${{ number_format($monthlyTransactions->where('transaction_type', 'credit')->sum('amount'), 2) }}
                            </div>
                            <div class="text-sm text-blue-800">Credits This Month</div>
                        </div>
                        <div class="text-center p-4 bg-orange-50 rounded-lg">
                            <div class="text-2xl font-bold text-orange-600">
                                ${{ number_format($monthlyTransactions->where('transaction_type', 'debit')->sum('amount'), 2) }}
                            </div>
                            <div class="text-sm text-orange-800">Debits This Month</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Floating Action Button -->
    <div class="fixed bottom-8 right-8 z-50">
        <a href="{{ route('financial.cash-book.create') }}" class="inline-flex items-center px-6 py-4 bg-emerald-600 border border-transparent rounded-full font-bold text-black text-lg hover:bg-emerald-700 shadow-2xl transform hover:scale-110 transition-all duration-200">
            <i class="fas fa-plus mr-2"></i>
            Add Transaction
        </a>
    </div>
</div>
@endsection
