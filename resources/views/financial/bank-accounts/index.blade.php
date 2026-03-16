@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-list-alt mr-3"></i>
                    Bank Accounts
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('financial.bank-accounts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Add Bank Account
                    </a>
                    <a href="{{ route('financial.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-green-700">
                        <i class="fas fa-chart-line mr-2"></i>
                        Financial Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Manage bank accounts and track balances across all financial institutions</p>
        </div>

        <!-- Bank Accounts Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-list-alt text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Accounts</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $bankAccounts->total() }}</dd>
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
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Accounts</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $bankAccounts->where('is_active', true)->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-dollar-sign text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Balance</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($bankAccounts->sum('current_balance'), 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-university text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Banks</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $bankAccounts->pluck('bank_id')->unique()->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bank Accounts List -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-list mr-2"></i>
                        Bank Accounts Management
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $bankAccounts->total() }} total accounts
                    </div>
                </div>

                @if($bankAccounts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Account Name
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bank
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Account Number
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Current Balance
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Last Reconciled
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($bankAccounts as $bankAccount)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $bankAccount->account_name }}</div>
                                            @if($bankAccount->description)
                                                <div class="text-xs text-gray-500">{{ $bankAccount->description }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $bankAccount->bank->bank_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $bankAccount->bank->branch_name ?? 'Main Branch' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $bankAccount->account_number }}</div>
                                            @if($bankAccount->routing_number)
                                                <div class="text-xs text-gray-500">Routing: {{ $bankAccount->routing_number }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ ucfirst($bankAccount->account_type) }}</div>
                                            @if($bankAccount->currency)
                                                <div class="text-xs text-gray-500">{{ $bankAccount->currency }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">${{ number_format($bankAccount->current_balance, 2) }}</div>
                                            @if($bankAccount->available_balance !== null)
                                                <div class="text-xs text-gray-500">Available: ${{ number_format($bankAccount->available_balance, 2) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($bankAccount->is_active)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $bankAccount->last_reconciled_at ? $bankAccount->last_reconciled_at->format('M d, Y') : 'Never' }}
                                            </div>
                                            @if($bankAccount->last_reconciled_at)
                                                <div class="text-xs text-gray-500">
                                                    {{ $bankAccount->last_reconciled_at->diffForHumans() }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button type="button" class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    View
                                                </button>
                                                <button type="button" class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-sync-alt mr-1"></i>
                                                    Reconcile
                                                </button>
                                                <button type="button" class="text-indigo-600 hover:text-indigo-900">
                                                    <i class="fas fa-edit mr-1"></i>
                                                    Edit
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
                        {{ $bankAccounts->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-list-alt text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No bank accounts found</p>
                        <p class="text-gray-400 text-sm mt-2">Add your first bank account to start tracking balances</p>
                        <div class="mt-6">
                            <a href="{{ route('financial.bank-accounts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Add First Bank Account
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Account Balance Summary -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Balance by Bank -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Balance by Bank
                    </h3>
                    <div class="space-y-3">
                        @php
                            $balancesByBank = $bankAccounts->groupBy('bank.bank_name')->map(function($accounts) {
                                return [
                                    'total_balance' => $accounts->sum('current_balance'),
                                    'account_count' => $accounts->count(),
                                    'accounts' => $accounts
                                ];
                            })->sortByDesc('total_balance');
                        @endphp
                        
                        @foreach($balancesByBank as $bankName => $data)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-university text-blue-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $bankName }}</p>
                                        <p class="text-xs text-gray-500">{{ $data['account_count'] }} account(s)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">
                                        ${{ number_format($data['total_balance'], 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Account Types -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-tags mr-2"></i>
                        Account Types
                    </h3>
                    <div class="space-y-3">
                        @php
                            $accountTypes = $bankAccounts->groupBy('account_type')->map(function($accounts) {
                                return [
                                    'total_balance' => $accounts->sum('current_balance'),
                                    'account_count' => $accounts->count()
                                ];
                            });
                        @endphp
                        
                        @foreach($accountTypes as $type => $data)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if($type === 'checking')
                                            <i class="fas fa-money-check text-green-600"></i>
                                        @elseif($type === 'savings')
                                            <i class="fas fa-piggy-bank text-pink-600"></i>
                                        @elseif($type === 'business')
                                            <i class="fas fa-briefcase text-blue-600"></i>
                                        @else
                                            <i class="fas fa-chart-line text-purple-600"></i>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ ucfirst($type) }}</p>
                                        <p class="text-xs text-gray-500">{{ $data['account_count'] }} account(s)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">
                                        ${{ number_format($data['total_balance'], 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
