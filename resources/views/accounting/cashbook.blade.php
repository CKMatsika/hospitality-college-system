@extends('layouts.qbo')

@section('title', 'Cashbook')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-book mr-2"></i>
            Cashbook
        </h1>
        <p class="text-gray-600 mt-2">Track daily cash transactions, manage bank accounts, and monitor cash flow.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <i class="fas fa-wallet text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Cash Balance</dt>
                        <dd class="text-lg font-medium text-gray-900">$0.00</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <i class="fas fa-university text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Bank Balance</dt>
                        <dd class="text-lg font-medium text-gray-900">$0.00</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                    <i class="fas fa-arrow-down text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Today's Receipts</dt>
                        <dd class="text-lg font-medium text-gray-900">$0.00</dd>
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
                        <dt class="text-sm font-medium text-gray-500 truncate">Today's Payments</dt>
                        <dd class="text-lg font-medium text-gray-900">$0.00</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('accounting.dashboard') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-chart-line mr-2"></i> Accounting Dashboard
            </a>
            <a href="{{ route('accounting.accounts-receivable') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-arrow-down mr-2"></i> Accounts Receivable
            </a>
            <a href="{{ route('accounting.accounts-payable') }}" class="flex items-center justify-center bg-red-500 hover:bg-red-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-arrow-up mr-2"></i> Accounts Payable
            </a>
        </div>
    </div>

    <!-- Cash Transactions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Today's Transactions</h2>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-download mr-1"></i> Export
                </button>
            </div>
        </div>

        <!-- Transaction Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                <div class="flex items-center">
                    <i class="fas fa-arrow-down text-green-600 mr-3"></i>
                    <div>
                        <p class="text-sm text-green-600 font-medium">Total Receipts</p>
                        <p class="text-lg font-bold text-green-900">$0.00</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                <div class="flex items-center">
                    <i class="fas fa-arrow-up text-red-600 mr-3"></i>
                    <div>
                        <p class="text-sm text-red-600 font-medium">Total Payments</p>
                        <p class="text-lg font-bold text-red-900">$0.00</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                <div class="flex items-center">
                    <i class="fas fa-balance-scale text-blue-600 mr-3"></i>
                    <div>
                        <p class="text-sm text-blue-600 font-medium">Net Movement</p>
                        <p class="text-lg font-bold text-blue-900">$0.00</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date & Time
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Receipt
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Payment
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Balance
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fas fa-exchange-alt text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Transactions Today</h3>
                            <p class="text-gray-500">Cash transactions will appear here as they are recorded.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
