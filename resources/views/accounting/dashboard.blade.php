@extends('layouts.qbo')

@section('title', 'Accounting Dashboard')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-calculator mr-2"></i>
            Accounting Dashboard
        </h1>
        <p class="text-gray-600 mt-2">Complete financial management system with QuickBooks-style functionality.</p>
    </div>

    <!-- Financial Period Alert -->
    @if($currentPeriod ?? null)
        <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-xl">
            <h3 class="text-lg font-medium text-blue-900">
                <i class="fas fa-calendar-alt mr-2"></i>
                Current Financial Period: {{ $currentPeriod->name ?? 'Default' }}
            </h3>
            <p class="text-sm text-blue-700">
                {{ $currentPeriod->start_date?->format('M d, Y') ?? 'N/A' }} - {{ $currentPeriod->end_date?->format('M d, Y') ?? 'N/A' }}
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

    <!-- Financial Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <i class="fas fa-wallet text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Bank Balance</dt>
                        <dd class="text-lg font-medium text-gray-900">${{ number_format($balanceSheet['cash'] ?? 0, 2) }}</dd>
                        <dt class="text-xs text-green-600">Available funds</dt>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <i class="fas fa-arrow-down text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Income</dt>
                        <dd class="text-lg font-medium text-gray-900">${{ number_format($incomeStatement['total_revenue'] ?? 0, 2) }}</dd>
                        <dt class="text-xs text-green-600">This period</dt>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                    <i class="fas fa-arrow-up text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Expenses</dt>
                        <dd class="text-lg font-medium text-gray-900">${{ number_format($incomeStatement['total_expenses'] ?? 0, 2) }}</dd>
                        <dt class="text-xs text-red-600">This period</dt>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Net Income</dt>
                        <dd class="text-lg font-medium text-gray-900">${{ number_format($incomeStatement['net_income'] ?? 0, 2) }}</dd>
                        <dt class="text-xs {{ ($incomeStatement['net_income'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ ($incomeStatement['net_income'] ?? 0) >= 0 ? 'Profit' : 'Loss' }}
                        </dt>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
            </div>
            <div class="space-y-3">
                <a href="{{ route('accounting.journal.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors w-full">
                    <i class="fas fa-plus mr-2"></i> New Journal Entry
                </a>
                <a href="{{ route('accounting.invoices.create') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors w-full">
                    <i class="fas fa-file-invoice mr-2"></i> Create Invoice
                </a>
                <a href="{{ route('accounting.reports.trial-balance') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors w-full">
                    <i class="fas fa-balance-scale mr-2"></i> Trial Balance
                </a>
                <a href="{{ route('accounting.reports.income-statement') }}" class="flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-lg transition-colors w-full">
                    <i class="fas fa-chart-bar mr-2"></i> Income Statement
                </a>
            </div>
        </div>

        <!-- Cash Flow Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Cash Flow</h2>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-download mr-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="h-64">
                <canvas id="cashFlowChart"></canvas>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Recent Transactions</h2>
                <a href="{{ route('accounting.journal') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    View All
                </a>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-arrow-down text-green-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Tuition Payment</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                    </div>
                    <span class="text-green-600 font-medium">+$1,200.00</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-arrow-up text-red-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Office Supplies</p>
                            <p class="text-xs text-gray-500">5 hours ago</p>
                        </div>
                    </div>
                    <span class="text-red-600 font-medium">-$150.00</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-arrow-down text-green-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Course Registration</p>
                            <p class="text-xs text-gray-500">Yesterday</p>
                        </div>
                    </div>
                    <span class="text-green-600 font-medium">+$850.00</span>
                </div>
                
                <div class="text-center py-4">
                    <a href="{{ route('accounting.journal') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View all transactions →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Balances & Aging -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Account Balances -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Account Balances</h2>
                <a href="{{ route('accounting.accounts') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    Manage Accounts
                </a>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 border-l-4 border-blue-500 bg-blue-50">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Checking Account</p>
                        <p class="text-xs text-gray-500">Primary Business Account</p>
                    </div>
                    <span class="font-medium text-gray-900">${{ number_format($balanceSheet['cash'] ?? 0, 2) }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 border-l-4 border-green-500 bg-green-50">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Accounts Receivable</p>
                        <p class="text-xs text-gray-500">Outstanding Invoices</p>
                    </div>
                    <span class="font-medium text-gray-900">${{ number_format($balanceSheet['accounts_receivable'] ?? 0, 2) }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 border-l-4 border-purple-500 bg-purple-50">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Fixed Assets</p>
                        <p class="text-xs text-gray-500">Equipment & Property</p>
                    </div>
                    <span class="font-medium text-gray-900">${{ number_format($balanceSheet['fixed_assets'] ?? 0, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Accounts Receivable Aging -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">A/R Aging Summary</h2>
                <a href="{{ route('accounting.accounts-receivable.aging') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    Full Report
                </a>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3">
                    <span class="text-sm font-medium text-gray-700">Current (0-30 days)</span>
                    <span class="font-medium text-green-600">${{ number_format($agingReceivables['current'] ?? 0, 2) }}</span>
                </div>
                <div class="flex items-center justify-between p-3">
                    <span class="text-sm font-medium text-gray-700">31-60 days</span>
                    <span class="font-medium text-yellow-600">${{ number_format($agingReceivables['days_31_60'] ?? 0, 2) }}</span>
                </div>
                <div class="flex items-center justify-between p-3">
                    <span class="text-sm font-medium text-gray-700">61-90 days</span>
                    <span class="font-medium text-orange-600">${{ number_format($agingReceivables['days_61_90'] ?? 0, 2) }}</span>
                </div>
                <div class="flex items-center justify-between p-3">
                    <span class="text-sm font-medium text-gray-700">Over 90 days</span>
                    <span class="font-medium text-red-600">${{ number_format($agingReceivables['over_90'] ?? 0, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Reports Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Financial Reports</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('accounting.reports.trial-balance') }}" class="flex items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-balance-scale text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Trial Balance</p>
                    <p class="text-xs text-gray-500">Verify account balances</p>
                </div>
            </a>
            
            <a href="{{ route('accounting.reports.income-statement') }}" class="flex items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-chart-bar text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Income Statement</p>
                    <p class="text-xs text-gray-500">Revenue & expenses</p>
                </div>
            </a>
            
            <a href="{{ route('accounting.reports.balance-sheet') }}" class="flex items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-chart-pie text-purple-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Balance Sheet</p>
                    <p class="text-xs text-gray-500">Assets & liabilities</p>
                </div>
            </a>
            
            <a href="{{ route('accounting.reports.cash-flow') }}" class="flex items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-water text-orange-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Cash Flow</p>
                    <p class="text-xs text-gray-500">Cash movement</p>
                </div>
            </a>
        </div>
    </div>

    <script>
        // Cash Flow Chart
        const cashFlowCtx = document.getElementById('cashFlowChart').getContext('2d');
        new Chart(cashFlowCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Income',
                    data: [12000, 15000, 13500, 16000, 18000, 17500],
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4
                }, {
                    label: 'Expenses',
                    data: [8000, 9500, 8200, 10500, 11000, 9800],
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
