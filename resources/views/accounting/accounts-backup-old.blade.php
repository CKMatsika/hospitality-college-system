@extends('layouts.qbo')

@section('title', 'Chart of Accounts')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-list-alt mr-2"></i>
            Chart of Accounts
        </h1>
        <p class="text-gray-600 mt-2">Manage your complete chart of accounts with account types and hierarchies.</p>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('accounting.accounts.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> New Account
            </a>
            <button class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-download mr-2"></i> Import Accounts
            </button>
            <button class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-file-export mr-2"></i> Export Chart
            </button>
        </div>
    </div>

    <!-- Account Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <i class="fas fa-wallet text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Asset Accounts</dt>
                        <dd class="text-lg font-medium text-gray-900">12</dd>
                        <dt class="text-xs text-gray-600">Active accounts</dt>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                    <i class="fas fa-credit-card text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Liability Accounts</dt>
                        <dd class="text-lg font-medium text-gray-900">8</dd>
                        <dt class="text-xs text-gray-600">Active accounts</dt>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Equity Accounts</dt>
                        <dd class="text-lg font-medium text-gray-900">4</dd>
                        <dt class="text-xs text-gray-600">Active accounts</dt>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                    <i class="fas fa-chart-bar text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Revenue Accounts</dt>
                        <dd class="text-lg font-medium text-gray-900">15</dd>
                        <dt class="text-xs text-gray-600">Active accounts</dt>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart of Accounts Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">All Accounts</h2>
            <div class="flex space-x-2">
                <div class="relative">
                    <input type="text" placeholder="Search accounts..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
                <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="asset">Assets</option>
                    <option value="liability">Liabilities</option>
                    <option value="equity">Equity</option>
                    <option value="revenue">Revenue</option>
                    <option value="expense">Expenses</option>
                </select>
            </div>
        </div>

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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Classification
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Balance
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Assets Section -->
                    <tr class="bg-gray-50">
                        <td colspan="7" class="px-6 py-3 text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-wallet mr-2"></i> ASSETS
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">1000</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mr-2 text-xs"></i>
                                Cash and Cash Equivalents
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Asset</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Current Asset</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">$15,234.50</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <a href="#" class="text-gray-600 hover:text-gray-900">View</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">1100</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mr-2 text-xs"></i>
                                Accounts Receivable
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Asset</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Current Asset</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">$12,450.00</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <a href="#" class="text-gray-600 hover:text-gray-900">View</a>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Liabilities Section -->
                    <tr class="bg-gray-50">
                        <td colspan="7" class="px-6 py-3 text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-credit-card mr-2"></i> LIABILITIES
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">2000</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mr-2 text-xs"></i>
                                Accounts Payable
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Liability</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Current Liability</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">$3,200.00</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <a href="#" class="text-gray-600 hover:text-gray-900">View</a>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Equity Section -->
                    <tr class="bg-gray-50">
                        <td colspan="7" class="px-6 py-3 text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-chart-line mr-2"></i> EQUITY
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">3000</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mr-2 text-xs"></i>
                                Owner's Equity
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Equity</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Equity</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">$24,484.50</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <a href="#" class="text-gray-600 hover:text-gray-900">View</a>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Revenue Section -->
                    <tr class="bg-gray-50">
                        <td colspan="7" class="px-6 py-3 text-xs font-semibold text-gray-700 uppercase">
                            <i class="fas fa-chart-bar mr-2"></i> REVENUE
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">4000</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mr-2 text-xs"></i>
                                Tuition Revenue
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Revenue</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Operating Revenue</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">$45,000.00</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <a href="#" class="text-gray-600 hover:text-gray-900">View</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
