@extends('layouts.qbo')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-balance-scale mr-2"></i>
                        Balance Sheet
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

                <!-- Balance Check -->
                <div class="mb-6 p-4 {{ abs($balanceSheet['total_assets'] - ($balanceSheet['total_liabilities'] + $balanceSheet['total_equity'])) < 0.01 ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                    <div class="flex items-center">
                        <i class="fas {{ abs($balanceSheet['total_assets'] - ($balanceSheet['total_liabilities'] + $balanceSheet['total_equity'])) < 0.01 ? 'fa-check-circle text-green-600' : 'fa-exclamation-circle text-red-600' }} text-xl mr-3"></i>
                        <div>
                            <h3 class="text-lg font-medium {{ abs($balanceSheet['total_assets'] - ($balanceSheet['total_liabilities'] + $balanceSheet['total_equity'])) < 0.01 ? 'text-green-900' : 'text-red-900' }}">
                                {{ abs($balanceSheet['total_assets'] - ($balanceSheet['total_liabilities'] + $balanceSheet['total_equity'])) < 0.01 ? 'Balance Sheet is Balanced' : 'Balance Sheet is Out of Balance' }}
                            </h3>
                            <p class="text-sm {{ abs($balanceSheet['total_assets'] - ($balanceSheet['total_liabilities'] + $balanceSheet['total_equity'])) < 0.01 ? 'text-green-700' : 'text-red-700' }}">
                                Assets = Liabilities + Equity: ${{ number_format($balanceSheet['total_assets'], 2) }} = ${{ number_format($balanceSheet['total_liabilities'] + $balanceSheet['total_equity'], 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Assets Section -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-cube text-blue-600 mr-2"></i>
                            Assets
                        </h3>
                        
                        @if(empty($balanceSheet['assets']))
                            <p class="text-gray-500 text-sm">No asset entries found</p>
                        @else
                            <div class="space-y-2">
                                @foreach($balanceSheet['assets'] as $asset)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $asset['account']->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $asset['account']->account_code }}</p>
                                        </div>
                                        <p class="text-sm font-medium text-blue-600">
                                            ${{ number_format($asset['debit'] - $asset['credit'], 2) }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4 pt-4 border-t-2 border-gray-300">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-900">Total Assets</span>
                                    <span class="text-lg font-bold text-blue-600">
                                        ${{ number_format($balanceSheet['total_assets'], 2) }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Liabilities Section -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-credit-card text-yellow-600 mr-2"></i>
                            Liabilities
                        </h3>
                        
                        @if(empty($balanceSheet['liabilities']))
                            <p class="text-gray-500 text-sm">No liability entries found</p>
                        @else
                            <div class="space-y-2">
                                @foreach($balanceSheet['liabilities'] as $liability)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $liability['account']->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $liability['account']->account_code }}</p>
                                        </div>
                                        <p class="text-sm font-medium text-yellow-600">
                                            ${{ number_format($liability['credit'] - $liability['debit'], 2) }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4 pt-4 border-t-2 border-gray-300">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-900">Total Liabilities</span>
                                    <span class="text-lg font-bold text-yellow-600">
                                        ${{ number_format($balanceSheet['total_liabilities'], 2) }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Equity Section -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-chart-pie text-green-600 mr-2"></i>
                            Equity
                        </h3>
                        
                        @if(empty($balanceSheet['equity']))
                            <p class="text-gray-500 text-sm">No equity entries found</p>
                        @else
                            <div class="space-y-2">
                                @foreach($balanceSheet['equity'] as $equity)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $equity['account']->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $equity['account']->account_code }}</p>
                                        </div>
                                        <p class="text-sm font-medium text-green-600">
                                            ${{ number_format($equity['credit'] - $equity['debit'], 2) }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4 pt-4 border-t-2 border-gray-300">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-900">Total Equity</span>
                                    <span class="text-lg font-bold text-green-600">
                                        ${{ number_format($balanceSheet['total_equity'], 2) }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Summary -->
                <div class="mt-8 bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Balance Sheet Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                                    <span class="text-sm font-medium text-gray-600">Total Assets</span>
                                    <span class="text-sm font-bold text-blue-600">
                                        ${{ number_format($balanceSheet['total_assets'], 2) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                                    <span class="text-sm font-medium text-gray-600">Total Liabilities</span>
                                    <span class="text-sm font-bold text-yellow-600">
                                        ${{ number_format($balanceSheet['total_liabilities'], 2) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Total Equity</span>
                                    <span class="text-sm font-bold text-green-600">
                                        ${{ number_format($balanceSheet['total_equity'], 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-900">Liabilities + Equity</span>
                                    <span class="text-lg font-bold text-gray-900">
                                        ${{ number_format($balanceSheet['total_liabilities'] + $balanceSheet['total_equity'], 2) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-sm text-gray-600">Balance Check</span>
                                    <span class="text-sm font-medium {{ abs($balanceSheet['total_assets'] - ($balanceSheet['total_liabilities'] + $balanceSheet['total_equity'])) < 0.01 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ abs($balanceSheet['total_assets'] - ($balanceSheet['total_liabilities'] + $balanceSheet['total_equity'])) < 0.01 ? 'Balanced' : 'Out of Balance' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
