@extends('layouts.qbo')

@section('title', 'Payroll Employees')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-users mr-2"></i>
            Payroll Employees
        </h1>
        <p class="text-gray-600 mt-2">Manage staff salary and payroll information.</p>
    </div>

    <!-- Employees List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">All Staff Members</h2>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff Member</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Base Salary</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Payroll</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($staff as $staffMember)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-500 text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $staffMember->first_name }} {{ $staffMember->last_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $staffMember->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $staffMember->position ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $staffMember->department ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">${{ number_format($staffMember->salary ?? 0, 2) }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $staffMember->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($staffMember->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{-- Calculate last payroll date --}}
                                @php
                                    $lastPayroll = $staffMember->payrollItems()->latest()->first();
                                @endphp
                                @if($lastPayroll)
                                    {{ $lastPayroll->created_at->format('M d, Y') }}
                                @else
                                    <span class="text-gray-400">Never</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex space-x-2">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                    <a href="#" class="text-green-600 hover:text-green-800 font-medium">History</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                <i class="fas fa-users text-4xl mb-4"></i>
                                <p>No staff members found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($staff->hasPages())
            <div class="mt-6">
                {{ $staff->links() }}
            </div>
        @endif
    </div>

@endsection
