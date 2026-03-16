@extends('layouts.qbo')

@section('title', 'Accounting Dashboard')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-calculator mr-2"></i>
            Accounting Dashboard
        </h1>
        <p class="text-gray-600 mt-2">Manage your financial operations and accounting records.</p>
    </div>

    @if($currentPeriod)
        <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-xl">
            <h3 class="text-lg font-medium text-blue-900">
                <i class="fas fa-calendar-alt mr-2"></i>
                Current Financial Period: {{ $currentPeriod->name }}
            </h3>
            <p class="text-sm text-blue-700">
                {{ $currentPeriod->start_date->format('M d, Y') }} - {{ $currentPeriod->end_date->format('M d, Y') }}
            </p>
        </div>
    @else
        <div class="mb-8 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
            <h3 class="text-lg font-medium text-yellow-900">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                No Open Financial Period
            </h3>
            <p class="text-sm text-yellow-700">
                Please create an open financial period to start recording transactions.
            </p>
        </div>
    @endif

    <!-- Accounting Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-stat-card 
            title="Trial Balance" 
            value="{{ count($trialBalance['accounts']) }} Accounts" 
            icon="fas fa-balance-scale" 
            color="green"
            trend="stable"
            trendValue="Debits: ${{ number_format($trialBalance['total_debits'], 2) }}"
        />
        <x-stat-card 
            title="Net Income" 
            value="${{ number_format($incomeStatement['net_income'], 2) }}" 
            icon="fas fa-chart-line" 
            color="{{ $incomeStatement['net_income'] >= 0 ? 'green' : 'red' }}"
            trend="{{ $incomeStatement['net_income'] >= 0 ? 'up' : 'down' }}"
            trendValue="Revenue: ${{ number_format($incomeStatement['total_revenue'], 2) }}"
        />
        <x-stat-card 
            title="Total Assets" 
            value="${{ number_format($balanceSheet['total_assets'], 2) }}" 
            icon="fas fa-wallet" 
            color="purple"
            trend="stable"
            trendValue="Equity: ${{ number_format($balanceSheet['total_equity'], 2) }}"
        />
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('accounting.journal.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> New Journal Entry
            </a>
            <a href="{{ route('accounting.reports.trial-balance') }}" class="flex items-center justify-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-balance-scale mr-2"></i> Trial Balance
            </a>
            <a href="{{ route('accounting.reports.income-statement') }}" class="flex items-center justify-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-chart-line mr-2"></i> Income Statement
            </a>
            <a href="{{ route('accounting.reports.balance-sheet') }}" class="flex items-center justify-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-balance-scale mr-2"></i> Balance Sheet
            </a>
        </div>
    </div>

    <!-- Recent Accounting Activity -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Accounting Activity</h2>
            <a href="{{ route('accounting.journal') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
        </div>
        
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-history text-4xl mb-4"></i>
            <p>Recent journal entries and transactions will appear here</p>
        </div>
    </div>

@endsection
