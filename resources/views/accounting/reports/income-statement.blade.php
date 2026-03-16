@extends('layouts.qbo')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-chart-line mr-2"></i>
                        Income Statement
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

                <!-- Net Income Summary -->
                <div class="mb-8 p-6 {{ $incomeStatement['net_income'] >= 0 ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium {{ $incomeStatement['net_income'] >= 0 ? 'text-green-900' : 'text-red-900' }}">
                                Net Income
                            </h3>
                            <p class="text-sm {{ $incomeStatement['net_income'] >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                {{ $incomeStatement['net_income'] >= 0 ? 'Profit' : 'Loss' }} for the period
                            </p>
                        </div>
                        <p class="text-3xl font-bold {{ $incomeStatement['net_income'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            ${{ number_format($incomeStatement['net_income'], 2) }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Revenue Section -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-arrow-up text-green-600 mr-2"></i>
                            Revenue
                        </h3>
                        
                        @if(empty($incomeStatement['revenues']))
                            <p class="text-gray-500 text-sm">No revenue entries found</p>
                        @else
                            <div class="space-y-2">
                                @foreach($incomeStatement['revenues'] as $revenue)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $revenue['account']->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $revenue['account']->account_code }}</p>
                                        </div>
                                        <p class="text-sm font-medium text-green-600">
                                            ${{ number_format($revenue['credit'], 2) }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4 pt-4 border-t-2 border-gray-300">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-900">Total Revenue</span>
                                    <span class="text-lg font-bold text-green-600">
                                        ${{ number_format($incomeStatement['total_revenue'], 2) }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Expenses Section -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-arrow-down text-red-600 mr-2"></i>
                            Expenses
                        </h3>
                        
                        @if(empty($incomeStatement['expenses']))
                            <p class="text-gray-500 text-sm">No expense entries found</p>
                        @else
                            <div class="space-y-2">
                                @foreach($incomeStatement['expenses'] as $expense)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $expense['account']->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $expense['account']->account_code }}</p>
                                        </div>
                                        <p class="text-sm font-medium text-red-600">
                                            ${{ number_format($expense['debit'], 2) }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4 pt-4 border-t-2 border-gray-300">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-900">Total Expenses</span>
                                    <span class="text-lg font-bold text-red-600">
                                        ${{ number_format($incomeStatement['total_expense'], 2) }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Summary -->
                <div class="mt-8 bg-white border border-gray-200 rounded-lg p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                            <span class="text-lg font-medium text-gray-900">Total Revenue</span>
                            <span class="text-lg font-bold text-green-600">
                                ${{ number_format($incomeStatement['total_revenue'], 2) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                            <span class="text-lg font-medium text-gray-900">Total Expenses</span>
                            <span class="text-lg font-bold text-red-600">
                                ${{ number_format($incomeStatement['total_expense'], 2) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">Net Income</span>
                            <span class="text-xl font-bold {{ $incomeStatement['net_income'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                ${{ number_format($incomeStatement['net_income'], 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
