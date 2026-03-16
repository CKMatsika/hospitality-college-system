@extends('layouts.qbo')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-balance-scale mr-2"></i>
                        Trial Balance
                    </h1>
                    <a href="{{ route('accounting.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Dashboard
                    </a>
                </div>

                @if($currentPeriod)
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <h3 class="text-lg font-medium text-blue-900">
                            Financial Period: {{ $currentPeriod->name }}
                        </h3>
                        <p class="text-sm text-blue-700">
                            {{ $currentPeriod->start_date->format('M d, Y') }} - {{ $currentPeriod->end_date->format('M d, Y') }}
                        </p>
                    </div>
                @endif

                <!-- Summary -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Total Debits</h3>
                        <p class="text-3xl font-bold text-gray-900">${{ number_format($trialBalance['total_debits'], 2) }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Total Credits</h3>
                        <p class="text-3xl font-bold text-gray-900">${{ number_format($trialBalance['total_credits'], 2) }}</p>
                    </div>
                </div>

                <!-- Balance Check -->
                <div class="mb-6 p-4 {{ $trialBalance['total_debits'] == $trialBalance['total_credits'] ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                    <div class="flex items-center">
                        <i class="fas {{ $trialBalance['total_debits'] == $trialBalance['total_credits'] ? 'fa-check-circle text-green-600' : 'fa-exclamation-circle text-red-600' }} text-xl mr-3"></i>
                        <div>
                            <h3 class="text-lg font-medium {{ $trialBalance['total_debits'] == $trialBalance['total_credits'] ? 'text-green-900' : 'text-red-900' }}">
                                {{ $trialBalance['total_debits'] == $trialBalance['total_credits'] ? 'Trial Balance is Balanced' : 'Trial Balance is Out of Balance' }}
                            </h3>
                            <p class="text-sm {{ $trialBalance['total_debits'] == $trialBalance['total_credits'] ? 'text-green-700' : 'text-red-700' }}">
                                Difference: ${{ number_format(abs($trialBalance['total_debits'] - $trialBalance['total_credits']), 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Trial Balance Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Account Code
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Account Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Debit
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Credit
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($trialBalance['accounts'] as $account)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $account['account']->account_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $account['account']->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $account['account']->type === 'asset' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $account['account']->type === 'liability' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $account['account']->type === 'equity' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $account['account']->type === 'revenue' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $account['account']->type === 'expense' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($account['account']->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                                        ${{ number_format($account['debit'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                                        ${{ number_format($account['credit'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900">
                                    Totals
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-gray-900">
                                    ${{ number_format($trialBalance['total_debits'], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-gray-900">
                                    ${{ number_format($trialBalance['total_credits'], 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if(empty($trialBalance['accounts']))
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No journal entries found for this period</p>
                        <p class="text-gray-400 text-sm mt-2">Start by creating journal entries to see them here</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
