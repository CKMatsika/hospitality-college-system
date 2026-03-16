@extends('layouts.qbo')

@section('title', 'Banking Management')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-university mr-2"></i>
            Banking Management
        </h1>
        <p class="text-gray-600 mt-2">Manage bank accounts and financial transactions.</p>
    </div>

    <!-- Banking Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Balance" 
            value="$125,450.00" 
            icon="fas fa-wallet" 
            color="green"
            trend="up"
            trendValue="All accounts"
        />
        <x-stat-card 
            title="Bank Accounts" 
            value="3" 
            icon="fas fa-piggy-bank" 
            color="blue"
            trend="stable"
            trendValue="Active accounts"
        />
        <x-stat-card 
            title="Today's Transactions" 
            value="12" 
            icon="fas fa-exchange-alt" 
            color="purple"
            trend="up"
            trendValue="Processed today"
        />
        <x-stat-card 
            title="Pending Transfers" 
            value="2" 
            icon="fas fa-clock" 
            color="yellow"
            trend="down"
            trendValue="Awaiting clearance"
        />
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('banking.accounts') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-university mr-2"></i> Manage Accounts
            </a>
            <a href="{{ route('banking.transactions') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-list mr-2"></i> View Transactions
            </a>
            <a href="{{ route('banking.reconciliation') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-balance-scale mr-2"></i> Reconciliation
            </a>
            <a href="#" class="flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-paper-plane mr-2"></i> Transfer Funds
            </a>
        </div>
    </div>

    <!-- Bank Accounts Overview -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Bank Accounts</h2>
            <a href="{{ route('banking.accounts') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Account 1 -->
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-university text-blue-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Main Operating Account</h3>
                            <p class="text-sm text-gray-500">****4589</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-2">$85,250.00</div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Available Balance</span>
                    <span class="text-green-600">+$2,450 today</span>
                </div>
            </div>

            <!-- Account 2 -->
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-piggy-bank text-green-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Savings Account</h3>
                            <p class="text-sm text-gray-500">****7823</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-2">$25,000.00</div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Available Balance</span>
                    <span class="text-gray-600">No change</span>
                </div>
            </div>

            <!-- Account 3 -->
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-credit-card text-purple-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Petty Cash</h3>
                            <p class="text-sm text-gray-500">****1245</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-2">$15,200.00</div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Available Balance</span>
                    <span class="text-red-600">-$150 today</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Transactions</h2>
            <a href="{{ route('banking.transactions') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">Mar 6, 2026</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Student Fee Payment</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Main Operating</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Income</span>
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-green-600 text-right">+$1,250.00</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Cleared</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">Mar 6, 2026</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Staff Salary Payment</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Main Operating</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Payroll</span>
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-red-600 text-right">-$3,500.00</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Cleared</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">Mar 5, 2026</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Office Supplies</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Petty Cash</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Expenses</span>
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-red-600 text-right">-$150.00</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Cleared</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
