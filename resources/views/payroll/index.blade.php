@extends('layouts.qbo')

@section('title', 'Payroll Management')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-users mr-2"></i>
            Payroll Management
        </h1>
        <p class="text-gray-600 mt-2">Manage staff payroll and salary payments.</p>
    </div>

    <!-- Payroll Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Staff" 
            value="{{ $totalStaff }}" 
            icon="fas fa-users" 
            color="blue"
            trend="stable"
            trendValue="All employees"
        />
        <x-stat-card 
            title="Active Staff" 
            value="{{ $activeStaff }}" 
            icon="fas fa-user-check" 
            color="green"
            trend="up"
            trendValue="Eligible for payroll"
        />
        <x-stat-card 
            title="This Month Payroll" 
            value="${{ number_format($totalPayrollThisMonth, 2) }}" 
            icon="fas fa-money-bill-wave" 
            color="purple"
            trend="up"
            trendValue="Total processed"
        />
        <x-stat-card 
            title="Payroll Runs" 
            value="{{ $payrolls->count() }}" 
            icon="fas fa-calendar-check" 
            color="yellow"
            trend="stable"
            trendValue="Total runs"
        />
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('payroll.run') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-play mr-2"></i> Run Payroll
            </a>
            <a href="{{ route('payroll.employees') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-users mr-2"></i> Manage Employees
            </a>
            <a href="{{ route('payroll.index') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-cog mr-2"></i> Payroll Settings
            </a>
        </div>
    </div>

    <!-- Recent Payroll Runs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Payroll Runs</h2>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pay Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff Count</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($payrolls as $payroll)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $payroll->pay_date->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $payroll->pay_period_start->format('M d') }} - {{ $payroll->pay_period_end->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $payroll->total_staff }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">${{ number_format($payroll->total_amount, 2) }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $payroll->status == 'processed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($payroll->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex space-x-2">
                                    <a href="{{ route('payroll.show', $payroll->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                                    <a href="#" class="text-green-600 hover:text-green-800 font-medium">Download</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                <i class="fas fa-users text-4xl mb-4"></i>
                                <p>No payroll runs found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($payrolls->hasPages())
            <div class="mt-6">
                {{ $payrolls->links() }}
            </div>
        @endif
    </div>

@endsection
