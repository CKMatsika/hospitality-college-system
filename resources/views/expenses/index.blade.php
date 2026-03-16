@extends('layouts.qbo')

@section('title', 'Expense Management')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-file-invoice-dollar mr-2"></i>
            Expense Management
        </h1>
        <p class="text-gray-600 mt-2">Track and manage business expenses and vendor payments.</p>
    </div>

    <!-- Expense Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Expenses" 
            value="$18,750.00" 
            icon="fas fa-money-bill-alt" 
            color="red"
            trend="up"
            trendValue="This month"
        />
        <x-stat-card 
            title="Pending Claims" 
            value="5" 
            icon="fas fa-clock" 
            color="yellow"
            trend="down"
            trendValue="Awaiting approval"
        />
        <x-stat-card 
            title="Vendors" 
            value="12" 
            icon="fas fa-truck" 
            color="blue"
            trend="stable"
            trendValue="Active vendors"
        />
        <x-stat-card 
            title="Reimbursed" 
            value="$3,200.00" 
            icon="fas fa-hand-holding-usd" 
            color="green"
            trend="up"
            trendValue="This month"
        />
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('expenses.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Add Expense
            </a>
            <a href="{{ route('vendors.index') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-truck mr-2"></i> Manage Vendors
            </a>
            <a href="{{ route('expenses.index') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-file-export mr-2"></i> Generate Report
            </a>
        </div>
    </div>

    <!-- Recent Expenses -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Expenses</h2>
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
            <table class="min-w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendor</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">Mar 6, 2026</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Office Supplies Purchase</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Office</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">Office Depot</td>
                        <td class="px-4 py-3 text-sm font-medium text-red-600 text-right">$450.00</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                                <a href="#" class="text-green-600 hover:text-green-800 font-medium">Receipt</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">Mar 5, 2026</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Catering Services</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Events</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">Gourmet Catering Co.</td>
                        <td class="px-4 py-3 text-sm font-medium text-red-600 text-right">$1,200.00</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                                <a href="#" class="text-orange-600 hover:text-orange-800 font-medium">Approve</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">Mar 4, 2026</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Internet Service</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Utilities</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">Comcast Business</td>
                        <td class="px-4 py-3 text-sm font-medium text-red-600 text-right">$250.00</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                                <a href="#" class="text-gray-600 hover:text-gray-800 font-medium">Receipt</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Vendor Overview -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Top Vendors</h2>
            <a href="{{ route('vendors.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Vendor 1 -->
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-truck text-blue-500 text-xs"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Office Depot</h3>
                            <p class="text-xs text-gray-500">Office Supplies</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Spent:</span>
                    <span class="font-medium text-gray-900">$3,450.00</span>
                </div>
                <div class="flex justify-between text-sm mt-1">
                    <span class="text-gray-500">Last Payment:</span>
                    <span class="text-gray-900">Mar 6, 2026</span>
                </div>
            </div>

            <!-- Vendor 2 -->
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-utensils text-green-500 text-xs"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Gourmet Catering</h3>
                            <p class="text-xs text-gray-500">Food Services</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Spent:</span>
                    <span class="font-medium text-gray-900">$8,200.00</span>
                </div>
                <div class="flex justify-between text-sm mt-1">
                    <span class="text-gray-500">Last Payment:</span>
                    <span class="text-gray-900">Mar 5, 2026</span>
                </div>
            </div>

            <!-- Vendor 3 -->
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-wifi text-purple-500 text-xs"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Comcast Business</h3>
                            <p class="text-xs text-gray-500">Internet Services</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Spent:</span>
                    <span class="font-medium text-gray-900">$2,750.00</span>
                </div>
                <div class="flex justify-between text-sm mt-1">
                    <span class="text-gray-500">Last Payment:</span>
                    <span class="text-gray-900">Mar 4, 2026</span>
                </div>
            </div>
        </div>
    </div>

@endsection
