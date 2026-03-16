@extends('layouts.qbo')

@section('title', 'Accounts Receivable')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-hand-holding-usd mr-2"></i>
            Accounts Receivable
        </h1>
        <p class="text-gray-600 mt-2">Manage customer invoices, track payments, and monitor outstanding balances.</p>
    </div>
                    Accounts Receivable
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('accounting.accounts-receivable.aging') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-orange-700">
                        <i class="fas fa-clock mr-2"></i>
                        Aging Report
                    </a>
                    <a href="{{ route('accounting.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-chart-line mr-2"></i>
                        Accounting Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Track outstanding balances and manage student receivables</p>
        </div>

        <!-- Receivables Summary -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Customers</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $customers->count() }}</dd>
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
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Receivable</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($totalReceivable, 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-calculator text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Average Balance</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($customers->count() > 0 ? $totalReceivable / $customers->count() : 0, 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Overdue Accounts</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $customers->filter(function($customer) {
                                        return $customer->fees && $customer->fees->filter(function($fee) {
                                            return $fee->balance > 0 && $fee->due_date && now()->greaterThan($fee->due_date);
                                        })->count() > 0;
                                    })->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer List -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-users mr-2"></i>
                        Customer Accounts
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $customers->total() }} total customers
                    </div>
                </div>

                @if($customers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Customer
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Balance
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fees Outstanding
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
                                @foreach($customers as $customer)
                                    @php
                                        $totalBalance = $customer->fees ? $customer->fees->sum('balance') : 0;
                                        $overdueFees = $customer->fees ? $customer->fees->filter(function($fee) {
                                            return $fee->balance > 0 && $fee->due_date && now()->greaterThan($fee->due_date);
                                        }) : collect();
                                        $isOverdue = $overdueFees->count() > 0;
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <span class="text-blue-600 font-medium">
                                                            {{ strtoupper(substr($customer->first_name, 0, 1) . substr($customer->last_name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $customer->first_name }} {{ $customer->last_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{ $customer->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $customer->student_id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium {{ $totalBalance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                                ${{ number_format($totalBalance, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $customer->fees ? $customer->fees->count() : 0 }}</div>
                                            <div class="text-xs text-gray-500">{{ $customer->fees ? $customer->fees->filter(fn($fee) => $fee->balance > 0)->count() : 0 }} outstanding</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($isOverdue)
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Overdue
                                                </span>
                                            @elseif($totalBalance > 0)
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Pending
                                                </span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Paid
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('accounting.accounts-receivable.customer', $customer) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                                View Details
                                            </a>
                                            <a href="{{ route('accounting.student-statements.show', $customer) }}" class="text-green-600 hover:text-green-900">
                                                Statement
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $customers->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-hand-holding-usd text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No outstanding receivables found</p>
                        <p class="text-gray-400 text-sm mt-2">All student accounts are paid up to date</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-envelope mr-2"></i>
                        Send Reminders
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">Send payment reminders to overdue accounts</p>
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send Reminders
                    </button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-file-export mr-2"></i>
                        Export Report
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">Download receivables report in Excel format</p>
                    <button class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-green-700">
                        <i class="fas fa-download mr-2"></i>
                        Export Excel
                    </button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Aging Analysis
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">View detailed aging analysis by time periods</p>
                    <a href="{{ route('accounting.accounts-receivable.aging') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-orange-700">
                        <i class="fas fa-clock mr-2"></i>
                        View Aging
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
