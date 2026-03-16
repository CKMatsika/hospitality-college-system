@extends('layouts.qbo')

@section('title', 'Bank Reconciliation')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-balance-scale mr-2"></i>
            Bank Reconciliation
        </h1>
        <p class="text-gray-600 mt-2">Reconcile bank statements with internal records.</p>
    </div>

    <!-- Reconciliation Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Pending Reconciliations" 
            value="3" 
            icon="fas fa-clock" 
            color="yellow"
            trend="stable"
            trendValue="Awaiting review"
        />
        <x-stat-card 
            title="Reconciled This Month" 
            value="12" 
            icon="fas fa-check-circle" 
            color="green"
            trend="up"
            trendValue="Successfully reconciled"
        />
        <x-stat-card 
            title="Discrepancies Found" 
            value="2" 
            icon="fas fa-exclamation-triangle" 
            color="red"
            trend="down"
            trendValue="Need attention"
        />
        <x-stat-card 
            title="Last Reconciled" 
            value="2 days ago" 
            icon="fas fa-calendar-check" 
            color="blue"
            trend="stable"
            trendValue="Most recent"
        />
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="#" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Start Reconciliation
            </a>
            <a href="{{ route('banking.accounts') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-university mr-2"></i> Manage Accounts
            </a>
            <a href="{{ route('banking.transactions') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-exchange-alt mr-2"></i> View Transactions
            </a>
        </div>
    </div>

    <!-- Reconciliation List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Reconciliation History</h2>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Account</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statement Balance</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book Balance</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Difference</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">March 2026</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Main Operating Account</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">KES 1,234,500</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">KES 1,234,500</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-green-600">KES 0</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Reconciled</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            <button class="text-gray-600 hover:text-gray-900">Download</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">February 2026</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Salary Account</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">KES 856,300</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">KES 856,300</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-green-600">KES 0</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Reconciled</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            <button class="text-gray-600 hover:text-gray-900">Download</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">March 2026</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Fees Collection</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">KES 359,200</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">KES 361,500</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-red-600">KES 2,300</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">Review</button>
                            <button class="text-orange-600 hover:text-orange-900">Resolve</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
