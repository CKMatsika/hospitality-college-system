@extends('layouts.qbo')

@section('title', 'Accounts Payable')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-arrow-up mr-2"></i>
            Accounts Payable
        </h1>
        <p class="text-gray-600 mt-2">Manage vendor bills, track expenses, and monitor payment obligations.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                    <i class="fas fa-money-bill-wave text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Payable</dt>
                        <dd class="text-lg font-medium text-gray-900">$0.00</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-orange-500 rounded-md p-3">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Overdue</dt>
                        <dd class="text-lg font-medium text-gray-900">$0.00</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                        <dd class="text-lg font-medium text-gray-900">0</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Paid This Month</dt>
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
            <a href="{{ route('accounting.student-statements') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-file-invoice-dollar mr-2"></i> Student Statements
            </a>
        </div>
    </div>

    <!-- Bills & Payments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Outstanding Bills</h2>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-download mr-1"></i> Export
                </button>
            </div>
        </div>

        <div class="text-center py-12">
            <i class="fas fa-file-invoice text-gray-400 text-5xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Outstanding Bills</h3>
            <p class="text-gray-500">All vendor bills have been paid. Great job managing expenses!</p>
        </div>
    </div>
@endsection
