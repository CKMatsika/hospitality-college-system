@extends('layouts.qbo')

@section('title', 'Customers')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user-friends mr-2"></i>
            Customers
        </h1>
        <p class="text-gray-600 mt-2">Manage your customer database and track relationships.</p>
    </div>

    <!-- Customer Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Customers" 
            value="156" 
            icon="fas fa-users" 
            color="blue"
            trend="up"
            trendValue="All time"
        />
        <x-stat-card 
            title="Active Customers" 
            value="142" 
            icon="fas fa-user-check" 
            color="green"
            trend="up"
            trendValue="Currently active"
        />
        <x-stat-card 
            title="New This Month" 
            value="12" 
            icon="fas fa-user-plus" 
            color="purple"
            trend="up"
            trendValue="March 2026"
        />
        <x-stat-card 
            title="Total Revenue" 
            value="KES 2.4M" 
            icon="fas fa-chart-line" 
            color="yellow"
            trend="up"
            trendValue="Year to date"
        />
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="#" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Add Customer
            </a>
            <a href="{{ route('sales.invoices') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-file-invoice mr-2"></i> Create Invoice
            </a>
            <a href="{{ route('sales.receipts') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-receipt mr-2"></i> View Receipts
            </a>
        </div>
    </div>

    <!-- Customers List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Customer List</h2>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-blue-600 text-sm font-medium">J</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">John Smith</div>
                                    <div class="text-sm text-gray-500">ID: #0001</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">john@example.com</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">(555) 123-4567</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-green-600">KES 1,250.00</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">2024-01-15</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            <button class="text-gray-600 hover:text-gray-900 mr-3">Edit</button>
                            <button class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-green-600 text-sm font-medium">S</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Sarah Johnson</div>
                                    <div class="text-sm text-gray-500">ID: #0002</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">sarah@company.com</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">(555) 234-5678</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">KES 0.00</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">2024-01-20</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            <button class="text-gray-600 hover:text-gray-900 mr-3">Edit</button>
                            <button class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-purple-600 text-sm font-medium">M</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Mike Wilson</div>
                                    <div class="text-sm text-gray-500">ID: #0003</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">mike@business.com</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">(555) 345-6789</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-red-600">KES -450.50</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">2024-02-01</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            <button class="text-gray-600 hover:text-gray-900 mr-3">Edit</button>
                            <button class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-yellow-600 text-sm font-medium">E</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Emily Davis</div>
                                    <div class="text-sm text-gray-500">ID: #0004</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">emily@shop.com</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">(555) 456-7890</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-green-600">KES 875.25</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">2024-02-10</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            <button class="text-gray-600 hover:text-gray-900 mr-3">Edit</button>
                            <button class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-red-600 text-sm font-medium">R</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Robert Brown</div>
                                    <div class="text-sm text-gray-500">ID: #0005</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">robert@service.com</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">(555) 567-8901</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">KES 0.00</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Inactive</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">2024-02-15</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            <button class="text-gray-600 hover:text-gray-900 mr-3">Edit</button>
                            <button class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
