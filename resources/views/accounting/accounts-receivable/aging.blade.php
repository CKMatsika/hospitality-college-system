@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-clock mr-3"></i>
                    Accounts Receivable Aging
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('accounting.accounts-receivable.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to A/R
                    </a>
                    <a href="{{ route('accounting.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-chart-line mr-2"></i>
                        Accounting Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Detailed aging analysis of outstanding receivables by time periods</p>
        </div>

        <!-- Aging Summary -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Current</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($agingBuckets['current'], 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-xs text-gray-500">Not overdue</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">1-30 Days</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($agingBuckets['1-30'], 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-xs text-gray-500">Slightly overdue</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-orange-500 rounded-md p-3">
                            <i class="fas fa-exclamation-circle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">31-60 Days</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($agingBuckets['31-60'], 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-xs text-gray-500">Moderately overdue</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                            <i class="fas fa-times-circle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">61-90 Days</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($agingBuckets['61-90'], 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-xs text-gray-500">Seriously overdue</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-ban text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">90+ Days</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($agingBuckets['90+'], 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-xs text-gray-500">Critically overdue</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aging Chart -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Aging Distribution
                </h3>
                <div class="space-y-4">
                    @php
                        $totalAging = array_sum($agingBuckets);
                    @endphp
                    @foreach(['current' => 'Current', '1-30' => '1-30 Days', '31-60' => '31-60 Days', '61-90' => '61-90 Days', '90+' => '90+ Days'] as $key => $label)
                        @php
                            $percentage = $totalAging > 0 ? ($agingBuckets[$key] / $totalAging) * 100 : 0;
                            $color = match($key) {
                                'current' => 'bg-green-500',
                                '1-30' => 'bg-yellow-500',
                                '31-60' => 'bg-orange-500',
                                '61-90' => 'bg-red-500',
                                '90+' => 'bg-purple-500',
                                default => 'bg-gray-500'
                            };
                        @endphp
                        <div class="flex items-center">
                            <div class="w-32 text-sm font-medium text-gray-700">{{ $label }}</div>
                            <div class="flex-1 mx-4">
                                <div class="w-full bg-gray-200 rounded-full h-6">
                                    <div class="{{ $color }} h-6 rounded-full flex items-center justify-center text-xs text-white font-medium" style="width: {{ $percentage }}%">
                                        {{ number_format($percentage, 1) }}%
                                    </div>
                                </div>
                            </div>
                            <div class="w-24 text-right">
                                <div class="text-sm font-medium text-gray-900">${{ number_format($agingBuckets[$key], 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Customer Aging Details -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-users mr-2"></i>
                        Customer Aging Details
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ count($customerAging) }} customers with balances
                    </div>
                </div>

                @if(count($customerAging) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Customer
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Current
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        1-30 Days
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        31-60 Days
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        61-90 Days
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        90+ Days
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($customerAging as $customerData)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <span class="text-blue-600 font-medium text-xs">
                                                            {{ strtoupper(substr($customerData['customer']->first_name, 0, 1) . substr($customerData['customer']->last_name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $customerData['customer']->first_name }} {{ $customerData['customer']->last_name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">{{ $customerData['customer']->student_id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-green-600">
                                                ${{ number_format($customerData['buckets']['current'], 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-yellow-600">
                                                ${{ number_format($customerData['buckets']['1-30'], 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-orange-600">
                                                ${{ number_format($customerData['buckets']['31-60'], 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-red-600">
                                                ${{ number_format($customerData['buckets']['61-90'], 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-purple-600">
                                                ${{ number_format($customerData['buckets']['90+'], 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">
                                                ${{ number_format($customerData['total'], 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('accounting.accounts-receivable.customer', $customerData['customer']) }}" class="text-blue-600 hover:text-blue-900 mr-2">
                                                View
                                            </a>
                                            <a href="{{ route('accounting.student-statements.show', $customerData['customer']) }}" class="text-green-600 hover:text-green-900">
                                                Statement
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td class="px-6 py-3 text-sm font-medium text-gray-900">Totals</td>
                                    <td class="px-6 py-3 text-sm font-medium text-green-600">${{ number_format($agingBuckets['current'], 2) }}</td>
                                    <td class="px-6 py-3 text-sm font-medium text-yellow-600">${{ number_format($agingBuckets['1-30'], 2) }}</td>
                                    <td class="px-6 py-3 text-sm font-medium text-orange-600">${{ number_format($agingBuckets['31-60'], 2) }}</td>
                                    <td class="px-6 py-3 text-sm font-medium text-red-600">${{ number_format($agingBuckets['61-90'], 2) }}</td>
                                    <td class="px-6 py-3 text-sm font-medium text-purple-600">${{ number_format($agingBuckets['90+'], 2) }}</td>
                                    <td class="px-6 py-3 text-sm font-bold text-gray-900">${{ number_format($totalAging, 2) }}</td>
                                    <td class="px-6 py-3"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-clock text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No aging data available</p>
                        <p class="text-gray-400 text-sm mt-2">All customer accounts are current</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Export Options -->
        <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-download mr-2"></i>
                    Export Aging Report
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-green-700">
                        <i class="fas fa-file-excel mr-2"></i>
                        Export to Excel
                    </button>
                    <button class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-red-700">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Export to PDF
                    </button>
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                        <i class="fas fa-print mr-2"></i>
                        Print Report
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
