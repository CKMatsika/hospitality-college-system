@extends('layouts.qbo')

@section('title', 'Admissions Dashboard')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user-plus mr-2"></i>
            Admissions Dashboard
        </h1>
        <p class="text-gray-600 mt-2">Comprehensive overview of student applications and enrollment management.</p>
    </div>

    <!-- Admissions Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Applications" 
            value="156" 
            icon="fas fa-file-alt" 
            color="blue"
            trend="up"
            trendValue="This semester"
        />
        <x-stat-card 
            title="Pending Review" 
            value="23" 
            icon="fas fa-clock" 
            color="yellow"
            trend="stable"
            trendValue="Need attention"
        />
        <x-stat-card 
            title="Enrolled Students" 
            value="89" 
            icon="fas fa-user-check" 
            color="green"
            trend="up"
            trendValue="Accepted & enrolled"
        />
        <x-stat-card 
            title="Conversion Rate" 
            value="57%" 
            icon="fas fa-chart-line" 
            color="purple"
            trend="up"
            trendValue="Application to enrollment"
        />
    </div>

    <!-- Recent Activity Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Applications -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Recent Applications</h2>
                <a href="{{ route('applications.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-blue-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">John Smith</h3>
                            <p class="text-sm text-gray-500">Hospitality Management</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">APP-2026-001</span>
                        <p class="text-xs text-yellow-600">Pending</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-green-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Sarah Johnson</h3>
                            <p class="text-sm text-gray-500">Culinary Arts</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">APP-2026-002</span>
                        <p class="text-xs text-green-600">Approved</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-purple-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Mike Wilson</h3>
                            <p class="text-sm text-gray-500">Hotel Management</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">APP-2026-003</span>
                        <p class="text-xs text-red-600">Rejected</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Enrollments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Recent Enrollments</h2>
                <a href="{{ route('lms.enrollments.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-check text-green-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Emma Davis</h3>
                            <p class="text-sm text-gray-500">Front Office Operations</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">ENR-2026-045</span>
                        <p class="text-xs text-green-600">Active</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-check text-blue-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Robert Chen</h3>
                            <p class="text-sm text-gray-500">Food & Beverage</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">ENR-2026-044</span>
                        <p class="text-xs text-green-600">Active</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-check text-yellow-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Lisa Anderson</h3>
                            <p class="text-sm text-gray-500">Housekeeping</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">ENR-2026-043</span>
                        <p class="text-xs text-yellow-600">Pending</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrollment Methods -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Enrollment Methods</h2>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">This Month</button>
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">This Year</button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-6 bg-blue-50 rounded-lg">
                <div class="text-3xl font-bold text-blue-600 mb-2">45</div>
                <div class="text-sm text-gray-600 mb-2">Online Applications</div>
                <div class="text-xs text-blue-600">28.8% of total</div>
                <div class="mt-4">
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 28.8%"></div>
                    </div>
                </div>
            </div>
            
            <div class="text-center p-6 bg-green-50 rounded-lg">
                <div class="text-3xl font-bold text-green-600 mb-2">78</div>
                <div class="text-sm text-gray-600 mb-2">Manual Enrollments</div>
                <div class="text-xs text-green-600">50.0% of total</div>
                <div class="mt-4">
                    <div class="w-full bg-green-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 50%"></div>
                    </div>
                </div>
            </div>
            
            <div class="text-center p-6 bg-purple-50 rounded-lg">
                <div class="text-3xl font-bold text-purple-600 mb-2">33</div>
                <div class="text-sm text-gray-600 mb-2">CSV Enrollments</div>
                <div class="text-xs text-purple-600">21.2% of total</div>
                <div class="mt-4">
                    <div class="w-full bg-purple-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: 21.2%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Admissions Management</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('applications.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> New Application
            </a>
            <a href="{{ route('applications.index') }}" class="flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-list mr-2"></i> Review Applications
            </a>
            <a href="{{ route('enrollments.manual.index') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-user-plus mr-2"></i> Manual Enrollment
            </a>
            <a href="{{ route('enrollments.csv.upload') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-file-csv mr-2"></i> CSV Enrollment
            </a>
        </div>
    </div>

@endsection
