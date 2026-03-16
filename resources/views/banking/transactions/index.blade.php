@extends('layouts.qbo')

@section('title', 'Bank Transactions')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-exchange-alt mr-2"></i>
            Bank Transactions
        </h1>
        <p class="text-gray-600 mt-2">View and manage all bank transactions and transfers.</p>
    </div>

    <!-- Transaction Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Today's Transactions" 
            value="24" 
            icon="fas fa-calendar-day" 
            color="blue"
            trend="up"
            trendValue="Today"
        />
        <x-stat-card 
            title="This Week" 
            value="156" 
            icon="fas fa-calendar-week" 
            color="green"
            trend="up"
            trendValue="Last 7 days"
        />
        <x-stat-card 
            title="This Month" 
            value="642" 
            icon="fas fa-calendar-alt" 
            color="purple"
            trend="up"
            trendValue="Current month"
        />
        <x-stat-card 
            title="Total Volume" 
            value="KES 8.2M" 
            icon="fas fa-chart-line" 
            color="yellow"
            trend="up"
            trendValue="Transaction value"
        />
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="#" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Record Transaction
            </a>
            <a href="{{ route('banking.accounts') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-university mr-2"></i> Manage Accounts
            </a>
            <a href="{{ route('banking.reconciliation') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-balance-scale mr-2"></i> Reconciliation
            </a>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Transactions</h2>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-download mr-1"></i> Export
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Account</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">2026-03-06</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Student Fee Payment - John Smith</td>
                            <div class="text-sm text-gray-500">Tuition payment</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Fees Collection</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Income</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="text-green-600 font-medium">+</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-green-600">KES 45,000</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">KES 404,200</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Completed</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">2026-03-06</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Staff Salary Payment</div>
                            <div class="text-sm text-gray-500">March payroll</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Main Operating</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Expense</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="text-red-600 font-medium">-</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-red-600">KES 125,000</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">KES 1,109,500</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Completed</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">2026-03-05</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Supplier Payment - Food Corp</div>
                            <div class="text-sm text-gray-500">Kitchen supplies</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Main Operating</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Expense</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="text-red-600 font-medium">-</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-red-600">KES 28,500</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">KES 1,234,500</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Completed</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
