@extends('layouts.qbo')

@section('title', 'Reports & Analytics')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-chart-bar mr-2"></i>
            Reports & Analytics
        </h1>
        <p class="text-gray-600 mt-2">Generate and view system reports and analytics.</p>
    </div>
            <!-- Reports Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Enrollment Reports -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-graduate text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Enrollment Reports</h3>
                                <p class="text-sm text-gray-500">Student enrollment statistics and trends</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('reports.enrollment') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                View Reports →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Academic Reports -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Academic Reports</h3>
                                <p class="text-sm text-gray-500">Courses, programs, and department analytics</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('reports.academic') }}" class="text-green-600 hover:text-green-800 font-medium text-sm">
                                View Reports →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Financial Reports -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Financial Reports</h3>
                                <p class="text-sm text-gray-500">Revenue, payments, and fee structures</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('reports.financial') }}" class="text-yellow-600 hover:text-yellow-800 font-medium text-sm">
                                View Reports →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Library Reports -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book-open text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Library Reports</h3>
                                <p class="text-sm text-gray-500">Book loans, reservations, and usage statistics</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('reports.library') }}" class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                                View Reports →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Staff Reports -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Staff Reports</h3>
                                <p class="text-sm text-gray-500">Staff statistics and department distribution</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('reports.staff') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                View Reports →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- LMS Reports -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-laptop text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">LMS Reports</h3>
                                <p class="text-sm text-gray-500">Online course enrollment and completion rates</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('reports.lms') }}" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                View Reports →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custom Report Generator -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Custom Report Generator</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('reports.custom') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="report_type" class="block text-sm font-medium text-gray-700">Report Type</label>
                                <select id="report_type" name="report_type" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select report type</option>
                                    <option value="enrollment">Enrollment Report</option>
                                    <option value="academic">Academic Report</option>
                                    <option value="financial">Financial Report</option>
                                    <option value="library">Library Report</option>
                                    <option value="staff">Staff Report</option>
                                    <option value="lms">LMS Report</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" id="start_date" name="start_date"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" id="end_date" name="end_date"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Export Format</label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="format" value="web" checked class="mr-2">
                                    <span class="text-sm text-gray-700">View in Browser</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="format" value="pdf" class="mr-2">
                                    <span class="text-sm text-gray-700">Export as PDF</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="format" value="excel" class="mr-2">
                                    <span class="text-sm text-gray-700">Export as Excel</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                                <i class="fas fa-file-alt mr-2"></i> Generate Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="text-2xl font-bold text-blue-600">{{ \App\Models\Student::count() }}</div>
                        <div class="text-sm text-gray-500">Total Students</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="text-2xl font-bold text-green-600">{{ \App\Models\Staff::count() }}</div>
                        <div class="text-sm text-gray-500">Total Staff</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="text-2xl font-bold text-yellow-600">{{ number_format(\App\Models\FeePayment::sum('amount'), 0) }}</div>
                        <div class="text-sm text-gray-500">Total Revenue</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="text-2xl font-bold text-purple-600">{{ \App\Models\Book::count() }}</div>
                        <div class="text-sm text-gray-500">Library Books</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
