@extends('layouts.qbo')

@section('title', 'Sales Invoices')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-file-invoice mr-2"></i>
            Sales Invoices
        </h1>
        <p class="text-gray-600 mt-2">Manage customer invoices and receipts.</p>
    </div>

    <!-- Sales Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Revenue" 
            value="$45,250.00" 
            icon="fas fa-dollar-sign" 
            color="green"
            trend="up"
            trendValue="This month"
        />
        <x-stat-card 
            title="Pending Invoices" 
            value="8" 
            icon="fas fa-clock" 
            color="yellow"
            trend="down"
            trendValue="Awaiting payment"
        />
        <x-stat-card 
            title="Paid Invoices" 
            value="23" 
            icon="fas fa-check-circle" 
            color="blue"
            trend="up"
            trendValue="This month"
        />
        <x-stat-card 
            title="Overdue" 
            value="2" 
            icon="fas fa-exclamation-triangle" 
            color="red"
            trend="down"
            trendValue="Need attention"
        />
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('sales.invoices.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Create Invoice
            </a>
            <a href="{{ route('sales.receipts') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-receipt mr-2"></i> View Receipts
            </a>
            <a href="{{ route('customers.index') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-user-friends mr-2"></i> Manage Customers
            </a>
        </div>
    </div>

    <!-- Recent Invoices -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Invoices</h2>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice #</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Issue Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">INV-2026-001</a>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-user text-blue-500 text-xs"></i>
                                </div>
                                John Smith
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">Mar 1, 2026</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Mar 15, 2026</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">$2,500.00</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                                <a href="#" class="text-green-600 hover:text-green-800 font-medium">Download</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">INV-2026-002</a>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-user text-green-500 text-xs"></i>
                                </div>
                                Sarah Johnson
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">Mar 3, 2026</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Mar 17, 2026</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">$1,850.00</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                                <a href="#" class="text-green-600 hover:text-green-800 font-medium">Send</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">INV-2026-003</a>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-user text-purple-500 text-xs"></i>
                                </div>
                                Mike Wilson
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">Mar 5, 2026</td>
                        <td class="px-4 py-3 text-sm text-gray-900">Mar 19, 2026</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">$3,200.00</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Overdue</span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                                <a href="#" class="text-orange-600 hover:text-orange-800 font-medium">Reminder</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
