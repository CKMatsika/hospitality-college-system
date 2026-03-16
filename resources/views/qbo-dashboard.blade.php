@extends('layouts.qbo')

@section('title', 'Dashboard')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Hospitality College Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome back, {{ auth()->user()->name }}! Here's your complete system overview.</p>
    </div>

    <!-- Main Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Students" 
            value="{{ $stats['total_students'] }}" 
            icon="fas fa-user-graduate" 
            color="blue"
            trend="up"
            trendValue="Active enrollment"
        />
        <x-stat-card 
            title="Total Staff" 
            value="{{ $stats['total_staff'] }}" 
            icon="fas fa-chalkboard-teacher" 
            color="green"
            trend="up"
            trendValue="Faculty & Admin"
        />
        <x-stat-card 
            title="Total Courses" 
            value="{{ $stats['total_courses'] }}" 
            icon="fas fa-book" 
            color="purple"
            trend="up"
            trendValue="Available programs"
        />
        <x-stat-card 
            title="Programs" 
            value="{{ $stats['total_programs'] }}" 
            icon="fas fa-graduation-cap" 
            color="yellow"
            trend="stable"
            trendValue="Academic programs"
        />
    </div>

    <!-- Module Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        
        <!-- Recent Students -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Recent Students</h2>
                <a href="{{ route('students.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
            </div>
            @if($recentStudents->count() > 0)
                <div class="space-y-4">
                    @foreach($recentStudents as $student)
                        <div class="flex items-center">
                            <img class="h-10 w-10 rounded-full" src="https://picsum.photos/seed/{{ $student->id }}/50/50.jpg" alt="">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $student->full_name }}</div>
                                <div class="text-sm text-gray-500">{{ $student->program->name ?? 'No Program' }} • ID: {{ $student->student_id }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No students registered yet.</p>
            @endif
        </div>

        <!-- Recent Staff -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Recent Staff</h2>
                <a href="{{ route('staff.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
            </div>
            @if($recentStaff->count() > 0)
                <div class="space-y-4">
                    @foreach($recentStaff as $staff)
                        <div class="flex items-center">
                            <img class="h-10 w-10 rounded-full" src="https://picsum.photos/seed/{{ $staff->id }}/50/50.jpg" alt="">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $staff->full_name }}</div>
                                <div class="text-sm text-gray-500">{{ $staff->position }} • {{ $staff->department->name ?? 'No Department' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No staff registered yet.</p>
            @endif
        </div>
    </div>

    <!-- Module Quick Access -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Module Quick Access</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <a href="{{ route('students.index') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors">
                <i class="fas fa-user-graduate text-blue-500 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Students</span>
            </a>
            <a href="{{ route('staff.index') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition-colors">
                <i class="fas fa-chalkboard-teacher text-green-500 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Staff</span>
            </a>
            <a href="{{ route('courses.index') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-colors">
                <i class="fas fa-book text-purple-500 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Courses</span>
            </a>
            <a href="{{ route('programs.index') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-yellow-300 hover:bg-yellow-50 transition-colors">
                <i class="fas fa-graduation-cap text-yellow-500 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Programs</span>
            </a>
            <a href="{{ route('accounting.dashboard') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-colors">
                <i class="fas fa-calculator text-indigo-500 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Accounting</span>
            </a>
            <a href="{{ route('finance.dashboard') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition-colors">
                <i class="fas fa-dollar-sign text-green-500 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Finance</span>
            </a>
            <a href="{{ route('library.dashboard') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-colors">
                <i class="fas fa-book-open text-purple-500 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">Library</span>
            </a>
            <a href="{{ route('lms.dashboard') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors">
                <i class="fas fa-laptop text-blue-500 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">LMS</span>
            </a>
            <a href="{{ route('cpd.dashboard') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-orange-300 hover:bg-orange-50 transition-colors">
                <i class="fas fa-certificate text-orange-500 text-2xl mb-2"></i>
                <span class="text-sm font-medium text-gray-700">CPD</span>
            </a>
            @if(Auth::user()->role === 'super_admin')
                <a href="{{ route('system-settings.edit') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-gray-600 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-cog text-gray-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Settings</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Financial Overview Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- Financial Stats -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Financial Overview</h2>
                    <a href="{{ route('finance.dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View details</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">$45,231</div>
                        <div class="text-sm text-green-700">Total Revenue</div>
                    </div>
                    <div class="text-center p-4 bg-red-50 rounded-lg">
                        <div class="text-2xl font-bold text-red-600">$12,456</div>
                        <div class="text-sm text-red-700">Total Expenses</div>
                    </div>
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">$32,775</div>
                        <div class="text-sm text-blue-700">Net Profit</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h2>
            <div class="space-y-3">
                <a href="{{ route('students.create') }}" class="w-full flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i> Add Student
                </a>
                <a href="{{ route('staff.create') }}" class="w-full flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i> Add Staff
                </a>
                <a href="{{ route('courses.create') }}" class="w-full flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i> Add Course
                </a>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Cash Flow Chart
    const cashFlowCtx = document.getElementById('cashFlowChart').getContext('2d');
    new Chart(cashFlowCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue',
                data: [30000, 35000, 32000, 38000, 42000, 45231],
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Expenses',
                data: [15000, 18000, 14000, 16000, 13000, 12456],
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Invoice Status Chart
    const invoiceStatusCtx = document.getElementById('invoiceStatusChart').getContext('2d');
    new Chart(invoiceStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Unpaid', 'Overdue', 'Draft'],
            datasets: [{
                data: [45, 12, 8, 3],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(59, 130, 246)',
                    'rgb(249, 115, 22)',
                    'rgb(107, 114, 128)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush
