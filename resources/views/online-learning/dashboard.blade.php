@extends('layouts.qbo')

@section('title', 'Online Learning Dashboard')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-laptop mr-2"></i>
            Online Learning Dashboard
        </h1>
        <p class="text-gray-600 mt-2">Comprehensive overview of online exams, lessons, and assignments.</p>
    </div>

    <!-- Learning Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Exams" 
            value="24" 
            icon="fas fa-graduation-cap" 
            color="blue"
            trend="up"
            trendValue="Active exams"
        />
        <x-stat-card 
            title="Online Lessons" 
            value="45" 
            icon="fas fa-book-open" 
            color="green"
            trend="up"
            trendValue="Available lessons"
        />
        <x-stat-card 
            title="Assignments" 
            value="32" 
            icon="fas fa-tasks" 
            color="purple"
            trend="stable"
            trendValue="Active assignments"
        />
        <x-stat-card 
            title="Certificates Issued" 
            value="156" 
            icon="fas fa-certificate" 
            color="yellow"
            trend="up"
            trendValue="This month"
        />
    </div>

    <!-- Learning Activity Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Exams -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Recent Exams</h2>
                <a href="{{ route('online-learning.exams.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-graduation-cap text-blue-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Hospitality Management Final</h3>
                            <p class="text-sm text-gray-500">Due: Mar 15, 2026</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">45 students</span>
                        <p class="text-xs text-green-600">Published</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-graduation-cap text-green-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Food Safety Certification</h3>
                            <p class="text-sm text-gray-500">Due: Mar 20, 2026</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">32 students</span>
                        <p class="text-xs text-green-600">Published</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-graduation-cap text-yellow-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Customer Service Skills</h3>
                            <p class="text-sm text-gray-500">Due: Mar 25, 2026</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">28 students</span>
                        <p class="text-xs text-yellow-600">Draft</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Lessons -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Recent Lessons</h2>
                <a href="{{ route('online-learning.lessons.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-book-open text-purple-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Introduction to Hospitality</h3>
                            <p class="text-sm text-gray-500">12 modules</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">89% complete</span>
                        <p class="text-xs text-gray-500">45 students</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-book-open text-indigo-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Front Office Operations</h3>
                            <p class="text-sm text-gray-500">8 modules</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">76% complete</span>
                        <p class="text-xs text-gray-500">38 students</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-book-open text-pink-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Housekeeping Management</h3>
                            <p class="text-sm text-gray-500">10 modules</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">92% complete</span>
                        <p class="text-xs text-gray-500">52 students</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Engagement Metrics -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Student Engagement</h2>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">This Week</button>
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">This Month</button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">87%</div>
                <div class="text-sm text-gray-500">Course Completion Rate</div>
                <div class="text-xs text-green-600 mt-1">↑ 5% from last month</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">4.2</div>
                <div class="text-sm text-gray-500">Average Rating</div>
                <div class="text-xs text-green-600 mt-1">↑ 0.3 from last month</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">156</div>
                <div class="text-sm text-gray-500">Active Students Today</div>
                <div class="text-xs text-green-600 mt-1">↑ 12% from yesterday</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-600 mb-2">23h</div>
                <div class="text-sm text-gray-500">Avg. Learning Time</div>
                <div class="text-xs text-red-600 mt-1">↓ 1h from last month</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Learning Management</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('online-learning.exams.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Create Exam
            </a>
            <a href="{{ route('online-learning.lessons.create') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Add Lesson
            </a>
            <a href="{{ route('online-learning.assignments.create') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Create Assignment
            </a>
            <a href="{{ route('online-learning.certificates.index') }}" class="flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-certificate mr-2"></i> Certificates
            </a>
        </div>
    </div>

@endsection
