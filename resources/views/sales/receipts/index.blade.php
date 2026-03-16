@extends('layouts.qbo')

@section('title', 'Sales Receipts')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-receipt mr-2"></i>
            Sales Receipts
        </h1>
        <p class="text-gray-600 mt-2">Manage and track all sales receipts and payment records.</p>
    </div>

    <!-- Receipt Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Today's Receipts" 
            value="18" 
            icon="fas fa-calendar-day" 
            color="blue"
            trend="up"
            trendValue="Today"
        />
        <x-stat-card 
            title="This Week" 
            value="124" 
            icon="fas fa-calendar-week" 
            color="green"
            trend="up"
            trendValue="Last 7 days"
        />
        <x-stat-card 
            title="This Month" 
            value="487" 
            icon="fas fa-calendar-alt" 
            color="purple"
            trend="up"
            trendValue="Current month"
        />
        <x-stat-card 
            title="Total Revenue" 
            value="KES 3.2M" 
            icon="fas fa-chart-line" 
            color="yellow"
            trend="up"
            trendValue="Month to date"
        />
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('sales.invoices.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Create Receipt
            </a>
            <a href="{{ route('sales.invoices') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-file-invoice mr-2"></i> Manage Invoices
            </a>
            <a href="{{ route('customers.index') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-user-friends mr-2"></i> Manage Customers
            </a>
        </div>
    </div>

    <!-- Receipts List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Receipts</h2>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt #</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">RCP-2026-001</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">John Smith</div>
                            <div class="text-sm text-gray-500">john.smith@email.com</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">2026-03-06</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">3 items</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">KES 15,750</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Card</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Paid</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            <button class="text-gray-600 hover:text-gray-900">Download</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">RCP-2026-002</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Sarah Johnson</div>
                            <div class="text-sm text-gray-500">sarah.j@email.com</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">2026-03-06</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">1 item</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">KES 8,500</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Cash</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Paid</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            <button class="text-gray-600 hover:text-gray-900">Download</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">RCP-2026-003</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Mike Wilson</div>
                            <div class="text-sm text-gray-500">mike.w@email.com</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">2026-03-05</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">5 items</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">KES 22,300</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">M-Pesa</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Paid</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            <button class="text-gray-600 hover:text-gray-900">Download</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
