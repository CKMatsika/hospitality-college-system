@extends('layouts.qbo')

@section('title', 'Financial Dashboard')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-dollar-sign mr-2"></i>
            Financial Dashboard
        </h1>
        <p class="text-gray-600 mt-2">Manage fees, payments, and financial operations.</p>
    </div>

    <!-- Financial Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Revenue" 
            value="${{ number_format($stats['total_revenue'], 2) }}" 
            icon="fas fa-dollar-sign" 
            color="green"
            trend="up"
            trendValue="All time revenue"
        />
        <x-stat-card 
            title="Pending Fees" 
            value="${{ number_format($stats['pending_fees'], 2) }}" 
            icon="fas fa-clock" 
            color="red"
            trend="stable"
            trendValue="Outstanding fees"
        />
        <x-stat-card 
            title="Paid This Month" 
            value="${{ number_format($stats['paid_this_month'], 2) }}" 
            icon="fas fa-calendar-check" 
            color="purple"
            trend="up"
            trendValue="Monthly collections"
        />
        <x-stat-card 
            title="Total Students" 
            value="{{ $stats['total_students'] }}" 
            icon="fas fa-users" 
            color="blue"
            trend="stable"
            trendValue="Active enrollment"
        />
    </div>

    <!-- Student Statistics Breakdown -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Student Statistics</h2>
            <a href="{{ route('students.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
        </div>
        
        <!-- Gender Breakdown -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-male text-blue-500 text-2xl mr-3"></i>
                    <div>
                        <div class="text-sm text-gray-600">Male Students</div>
                        <div class="text-xl font-bold text-blue-600">{{ $stats['male_students'] }}</div>
                    </div>
                </div>
            </div>
            <div class="bg-pink-50 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-female text-pink-500 text-2xl mr-3"></i>
                    <div>
                        <div class="text-sm text-gray-600">Female Students</div>
                        <div class="text-xl font-bold text-pink-600">{{ $stats['female_students'] }}</div>
                    </div>
                </div>
            </div>
            <div class="bg-green-50 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-graduation-cap text-green-500 text-2xl mr-3"></i>
                    <div>
                        <div class="text-sm text-gray-600">Total Programs</div>
                        <div class="text-xl font-bold text-green-600">{{ count($stats['students_by_program']) }}</div>
                    </div>
                </div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-chart-pie text-purple-500 text-2xl mr-3"></i>
                    <div>
                        <div class="text-sm text-gray-600">Avg/Program</div>
                        <div class="text-xl font-bold text-purple-600">{{ $stats['total_students'] > 0 ? round($stats['total_students'] / max(1, count($stats['students_by_program']))) : 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Program Breakdown -->
        <div class="border-t pt-4">
            <h3 class="text-sm font-medium text-gray-700 mb-3">By Program</h3>
            <div class="space-y-3">
                @forelse($stats['students_by_program'] as $program)
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-graduation-cap text-indigo-500 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $program->name }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $program->male_count }}M / {{ $program->female_count }}F students
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-semibold text-gray-900">{{ $program->total }}</div>
                            <div class="text-xs text-gray-500">enrolled</div>
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-gray-500 text-center py-4">No program data available</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Payments</h2>
            <a href="{{ route('finance.payments.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
        </div>
        @if($recentPayments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recentPayments as $payment)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $payment->studentFee->student->full_name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $payment->studentFee->feeStructure->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    ${{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ ucfirst($payment->payment_method) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $payment->payment_date->format('M d, Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-money-bill-wave text-4xl mb-4"></i>
                <p>No payments recorded yet.</p>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('finance.fee-structures.index') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-list-alt mr-2"></i> Fee Structures
            </a>
            <a href="{{ route('finance.student-fees.index') }}" class="flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-user-graduate mr-2"></i> Student Fees
            </a>
            <a href="{{ route('finance.payments.create') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-money-bill-wave mr-2"></i> Record Payment
            </a>
            <a href="{{ route('finance.reports.revenue') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-chart-line mr-2"></i> Revenue Report
            </a>
        </div>
    </div>

@endsection
