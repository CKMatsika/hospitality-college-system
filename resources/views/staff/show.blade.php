@extends('layouts.qbo')

@section('title', 'Staff Member Details')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user-tie mr-2"></i>
            Staff Member Details
        </h1>
        <p class="text-gray-600 mt-2">View and manage staff member information and records.</p>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Staff Profile Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img class="h-20 w-20 rounded-full" src="https://picsum.photos/seed/{{ $staff->id }}/100/100.jpg" alt="">
                            <div class="ml-6">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $staff->full_name }}</h1>
                                <p class="text-gray-600">Staff ID: {{ $staff->staff_id }}</p>
                                <p class="text-gray-600">{{ $staff->position }}</p>
                                <p class="text-gray-600">{{ $staff->department->name ?? 'No Department' }}</p>
                                <span class="mt-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $staff->status == 'active' ? 'bg-green-100 text-green-800' : 
                                       ($staff->status == 'inactive' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($staff->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('staff.edit', $staff) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            <a href="{{ route('staff.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button class="tab-btn py-2 px-6 border-b-2 border-green-500 font-medium text-sm text-green-600" data-tab="personal">
                            Personal Info
                        </button>
                        <button class="tab-btn py-2 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="professional">
                            Professional
                        </button>
                        <button class="tab-btn py-2 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="financial">
                            Financial
                        </button>
                        <button class="tab-btn py-2 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="leave">
                            Leave & Attendance
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Personal Information Tab -->
                    <div id="personal-tab" class="tab-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                                <dl class="space-y-3">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Date of Birth:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->date_of_birth->format('M d, Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Gender:</dt>
                                        <dd class="text-sm text-gray-900">{{ ucfirst($staff->gender) }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">National ID:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->national_id }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Employment Type:</dt>
                                        <dd class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $staff->employment_type)) }}</dd>
                                    </div>
                                </dl>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                                <dl class="space-y-3">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Email:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->user->email ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Phone:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->phone }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Address:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->address }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">City:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->city }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Tab -->
                    <div id="professional-tab" class="tab-content hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Professional Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dl class="space-y-3">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Department:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->department->name ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Position:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->position }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Qualification:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->qualification }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Specialization:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->specialization ?? 'N/A' }}</dd>
                                    </div>
                                </dl>
                            </div>
                            <div>
                                <dl class="space-y-3">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Hire Date:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->hire_date->format('M d, Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Years of Service:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->hire_date->diffInYears(now()) }} years</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Termination Date:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->termination_date?->format('M d, Y') ?? 'N/A' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Contracts</h4>
                            @if($staff->contracts->count() > 0)
                                <div class="space-y-2">
                                    @foreach($staff->contracts as $contract)
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <p class="text-sm font-medium text-gray-900">{{ $contract->type ?? 'Contract' }}</p>
                                            <p class="text-xs text-gray-500">From: {{ $contract->start_date->format('M d, Y') }} - {{ $contract->end_date?->format('M d, Y') ?? 'Ongoing' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No contracts found</p>
                            @endif
                        </div>
                    </div>

                    <!-- Financial Tab -->
                    <div id="financial-tab" class="tab-content hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-3">Salary Information</h4>
                                <dl class="space-y-3">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Basic Salary:</dt>
                                        <dd class="text-sm text-gray-900">{{ number_format($staff->basic_salary, 2) }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Bank Name:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->bank_name }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Bank Account:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->bank_account }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Tax ID:</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->tax_id ?? 'N/A' }}</dd>
                                    </div>
                                </dl>
                            </div>
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-3">Recent Payroll Records</h4>
                                @if($staff->payrolls->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($staff->payrolls->take(5) as $payroll)
                                            <div class="bg-green-50 p-3 rounded-lg">
                                                <p class="text-sm font-medium text-gray-900">{{ number_format($payroll->net_salary, 2) }}</p>
                                                <p class="text-xs text-gray-500">Period: {{ $payroll->pay_period ?? 'Monthly' }}</p>
                                                <p class="text-xs text-gray-500">Date: {{ $payroll->payment_date?->format('M d, Y') ?? 'Pending' }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No payroll records found</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Leave & Attendance Tab -->
                    <div id="leave-tab" class="tab-content hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Leave & Attendance</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-3">Leave Requests</h4>
                                @if($staff->leaveRequests->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($staff->leaveRequests->take(5) as $leave)
                                            <div class="bg-gray-50 p-3 rounded-lg">
                                                <p class="text-sm font-medium text-gray-900">{{ $leave->leave_type ?? 'Leave' }}</p>
                                                <p class="text-xs text-gray-500">{{ $leave->start_date->format('M d, Y') }} - {{ $leave->end_date->format('M d, Y') }}</p>
                                                <p class="text-xs text-gray-500">Status: {{ ucfirst($leave->status ?? 'pending') }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No leave requests found</p>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-3">Performance Reviews</h4>
                                @if($staff->performanceReviews->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($staff->performanceReviews->take(5) as $review)
                                            <div class="bg-blue-50 p-3 rounded-lg">
                                                <p class="text-sm font-medium text-gray-900">{{ $review->review_period ?? 'Review' }}</p>
                                                <p class="text-xs text-gray-500">Rating: {{ $review->rating ?? 'N/A' }}/5</p>
                                                <p class="text-xs text-gray-500">Date: {{ $review->review_date->format('M d, Y') }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No performance reviews found</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabName = button.getAttribute('data-tab');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    
                    // Remove active state from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-green-500', 'text-green-600');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });
                    
                    // Show selected tab content
                    document.getElementById(tabName + '-tab').classList.remove('hidden');
                    
                    // Add active state to clicked button
                    button.classList.remove('border-transparent', 'text-gray-500');
                    button.classList.add('border-green-500', 'text-green-600');
                });
            });
        });
    </script>
@endsection
