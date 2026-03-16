@extends('layouts.qbo')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-book mr-3"></i>
                    General Ledger
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('accounting.reports.trial-balance') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                        <i class="fas fa-balance-scale mr-2"></i>
                        Trial Balance
                    </a>
                    <a href="{{ route('accounting.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-chart-line mr-2"></i>
                        Accounting Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Complete ledger of all financial transactions by account</p>
        </div>

        <!-- Account Summary -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-list text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Accounts</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $accounts->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-arrow-up text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Debits</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($journalEntries->sum('debit'), 2) }}</dd>
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
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Credits</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($journalEntries->sum('credit'), 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-exchange-alt text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Balance</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($journalEntries->sum('debit') - $journalEntries->sum('credit'), 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Ledger Entries -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-list mr-2"></i>
                        Ledger Entries
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $journalEntries->total() }} total entries
                    </div>
                </div>

                @if($journalEntries->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Account
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reference
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Debit
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Credit
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Balance
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($journalEntryLines as $line)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $line->journalEntry->entry_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $line->journalEntry->entry_date->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $line->account->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $line->account->account_code }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $line->journalEntry->description }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $line->journalEntry->reference ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($line->debit > 0)
                                                <div class="text-sm font-medium text-red-600">${{ number_format($line->debit, 2) }}</div>
                                            @else
                                                <div class="text-sm text-gray-400">-</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($line->credit > 0)
                                                <div class="text-sm font-medium text-green-600">${{ number_format($line->credit, 2) }}</div>
                                            @else
                                                <div class="text-sm text-gray-400">-</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                ${{ number_format($line->debit - $line->credit, 2) }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $journalEntryLines->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-book text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No ledger entries found</p>
                        <p class="text-gray-400 text-sm mt-2">Start by adding journal entries to see them here</p>
                        <div class="mt-6">
                            <a href="{{ route('accounting.journal.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Add Journal Entry
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Account Summary -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-list-alt mr-2"></i>
                        Chart of Accounts
                    </h3>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        @foreach($accounts as $account)
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-folder text-blue-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $account->account_code }} - {{ $account->name }}</p>
                                        <p class="text-xs text-gray-500">{{ ucfirst($account->type) }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('accounting.general-ledger.account', $account) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Account Type Summary
                    </h3>
                    @php
                        $accountTypes = $accounts->groupBy('type')->map(function($accounts) {
                            return [
                                'count' => $accounts->count(),
                                'accounts' => $accounts
                            ];
                        });
                    @endphp
                    
                    <div class="space-y-3">
                        @foreach($accountTypes as $type => $data)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if($type === 'asset')
                                            <i class="fas fa-dollar-sign text-green-600"></i>
                                        @elseif($type === 'liability')
                                            <i class="fas fa-credit-card text-red-600"></i>
                                        @elseif($type === 'equity')
                                            <i class="fas fa-chart-line text-blue-600"></i>
                                        @elseif($type === 'revenue')
                                            <i class="fas fa-arrow-up text-green-600"></i>
                                        @elseif($type === 'expense')
                                            <i class="fas fa-arrow-down text-red-600"></i>
                                        @else
                                            <i class="fas fa-folder text-gray-600"></i>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ ucfirst($type) }}</p>
                                        <p class="text-xs text-gray-500">{{ $data['count'] }} accounts</p>
                                    </div>
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
