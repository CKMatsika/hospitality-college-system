@extends('layouts.qbo')

@section('title', 'Vendors')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-truck mr-2"></i>
            Vendors
        </h1>
        <p class="text-gray-600 mt-2">Manage vendor relationships and supplier information.</p>
    </div>

    <!-- Vendor Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Vendors" 
            value="84" 
            icon="fas fa-truck" 
            color="blue"
            trend="up"
            trendValue="All time"
        />
        <x-stat-card 
            title="Active Vendors" 
            value="76" 
            icon="fas fa-check-circle" 
            color="green"
            trend="up"
            trendValue="Currently active"
        />
        <x-stat-card 
            title="New This Month" 
            value="5" 
            icon="fas fa-user-plus" 
            color="purple"
            trend="up"
            trendValue="March 2026"
        />
        <x-stat-card 
            title="Total Purchases" 
            value="KES 1.8M" 
            icon="fas fa-shopping-cart" 
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
                <i class="fas fa-plus mr-2"></i> Add Vendor
            </a>
            <a href="{{ route('expenses.create') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-receipt mr-2"></i> Record Expense
            </a>
            <a href="{{ route('expenses.index') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-file-invoice-dollar mr-2"></i> View Expenses
            </a>
        </div>
    </div>

    <!-- Vendors List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Vendor List</h2>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Purchases</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-blue-600 text-sm font-medium">F</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Food Corp Ltd</div>
                                    <div class="text-sm text-gray-500">ID: #V001</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Food Supplies</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">John Manager</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">orders@foodcorp.com</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">(555) 123-4567</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">KES 456,000</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                        </td>
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
                                    <span class="text-green-600 text-sm font-medium">C</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Clean Services Co</div>
                                    <div class="text-sm text-gray-500">ID: #V002</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Cleaning</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Sarah Supervisor</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">info@cleanservices.co</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">(555) 234-5678</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">KES 125,000</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                        </td>
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
                                    <span class="text-purple-600 text-sm font-medium">T</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Tech Supplies Inc</div>
                                    <div class="text-sm text-gray-500">ID: #V003</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">IT Equipment</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Mike Tech</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">sales@techsupplies.inc</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">(555) 345-6789</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">KES 289,500</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                        </td>
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
                                    <span class="text-yellow-600 text-sm font-medium">S</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Stationery World</div>
                                    <div class="text-sm text-gray-500">ID: #V004</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Office Supplies</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Emily Office</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">orders@stationery.world</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">(555) 456-7890</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">KES 67,800</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                        </td>
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
                                    <span class="text-red-600 text-sm font-medium">M</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Maintenance Pro</div>
                                    <div class="text-sm text-gray-500">ID: #V005</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Maintenance</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Robert Fix</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">service@maintenance.pro</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">(555) 567-8901</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">KES 156,200</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Inactive</span>
                        </td>
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
