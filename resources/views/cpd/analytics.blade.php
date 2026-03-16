@extends('layouts.qbo')

@section('title', 'CPD Analytics')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-chart-bar mr-2"></i>
            CPD Analytics
        </h1>
        <p class="text-gray-600 mt-2">Comprehensive analytics and insights for your continuing professional development.</p>
    </div>
            </h1>
            <p class="text-gray-600 mt-2">Comprehensive insights into your professional development journey</p>
        </div>

        <!-- Analytics Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-trophy text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Points</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $summary['total_points_earned'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-star text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Current Level</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ ucfirst($summary['level']) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-fire text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Streak</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $summary['total_activities'] ?? 0 }} days</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-calendar-check text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Activities</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $summary['total_activities'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Points Trend Chart -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-chart-line mr-2"></i>
                    Points Accumulation Trend
                </h3>
                <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                    <div class="text-center">
                        <i class="fas fa-chart-area text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500">Interactive chart showing your CPD points over time</p>
                        <p class="text-gray-400 text-sm mt-2">Chart visualization would be implemented here</p>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-green-600">+15%</div>
                        <div class="text-xs text-gray-500">Growth Rate</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-blue-600">{{ $summary['active_points'] }}</div>
                        <div class="text-xs text-gray-500">Active Points</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-purple-600">{{ $summary['expired_points'] }}</div>
                        <div class="text-xs text-gray-500">Expired Points</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Points by Category
                    </h3>
                    @if($summary['points_by_category']->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($summary['points_by_category'] as $category => $data)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 rounded-full bg-blue-500 mr-3"></div>
                                        <span class="text-sm font-medium text-gray-900">{{ ucfirst($category) }}</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-900">{{ $data['total_points'] }} pts</div>
                                        <div class="text-xs text-gray-500">{{ $data['activities'] }} activities</div>
                                    </div>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($data['total_points'] / $summary['total_points_earned']) * 100 }}%"></div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-chart-pie text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">No category data available</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-bullseye mr-2"></i>
                        Achievement Milestones
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                            <div class="flex items-center">
                                <i class="fas fa-trophy text-green-600 mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">First Certificate</div>
                                    <div class="text-xs text-gray-500">Basic CPD Certificate earned</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-green-600">Achieved</div>
                                <div class="text-xs text-gray-500">2 weeks ago</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center">
                                <i class="fas fa-medal text-blue-600 mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">100 Points Milestone</div>
                                    <div class="text-xs text-gray-500">Century of CPD points</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-blue-600">In Progress</div>
                                <div class="text-xs text-gray-500">{{ 100 - $summary['total_points_earned'] }} points to go</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-600 mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Level Progression</div>
                                    <div class="text-xs text-gray-500">Advanced level achievement</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-yellow-600">Upcoming</div>
                                <div class="text-xs text-gray-500">{{ (isset($summary['next_level_points']['required']) && isset($summary['active_points'])) ? ($summary['next_level_points']['required'] - $summary['active_points']) : 0 }} points needed</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expiry Timeline -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Points Expiry Timeline
                </h3>
                <div class="space-y-4">
                    @if($summary['upcoming_expirations']->isNotEmpty())
                        @foreach($summary['upcoming_expirations'] as $record)
                            <div class="flex items-center justify-between p-4 border-l-4 {{ $record->expiry_date->diffInDays(now()) <= 7 ? 'border-red-500 bg-red-50' : 'border-yellow-500 bg-yellow-50' }} rounded">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle {{ $record->expiry_date->diffInDays(now()) <= 7 ? 'text-red-600' : 'text-yellow-600' }} mr-3"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $record->activity_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $record->category->name ?? 'General' }} • {{ $record->points }} points</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium {{ $record->expiry_date->diffInDays(now()) <= 7 ? 'text-red-600' : 'text-yellow-600' }}">
                                        {{ $record->expiry_date->diffInDays(now()) }} days
                                    </div>
                                    <div class="text-xs text-gray-500">Until expiry</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-check text-green-500 text-4xl mb-4"></i>
                            <p class="text-gray-500">No points expiring soon</p>
                            <p class="text-gray-400 text-sm mt-2">All your CPD points are safe!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Performance Insights -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-brain mr-2"></i>
                        Learning Patterns
                    </h3>
                    <div class="space-y-4">
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <h4 class="text-sm font-medium text-blue-900 mb-2">Most Productive Period</h4>
                            <p class="text-xs text-blue-700">Tuesday-Thursday mornings (9-11 AM)</p>
                            <div class="mt-2 text-xs text-blue-600">You earn 35% more points during this time</div>
                        </div>
                        
                        <div class="p-4 bg-green-50 rounded-lg">
                            <h4 class="text-sm font-medium text-green-900 mb-2">Preferred Activity Type</h4>
                            <p class="text-xs text-green-700">Online Courses and Workshops</p>
                            <div class="mt-2 text-xs text-green-600">85% completion rate for these activities</div>
                        </div>
                        
                        <div class="p-4 bg-purple-50 rounded-lg">
                            <h4 class="text-sm font-medium text-purple-900 mb-2">Optimal Learning Frequency</h4>
                            <p class="text-xs text-purple-700">3-4 activities per month</p>
                            <div class="mt-2 text-xs text-purple-600">Maintains steady point accumulation</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Recommendations
                    </h3>
                    <div class="space-y-4">
                        <div class="p-4 border-l-4 border-blue-500 bg-blue-50 rounded">
                            <h4 class="text-sm font-medium text-blue-900 mb-2">Focus on {{ $summary['points_by_category']->keys()->first() ?? 'Core Skills' }}</h4>
                            <p class="text-xs text-blue-700">You're close to the next level in this category</p>
                            <div class="mt-2">
                                <a href="{{ route('cpd.external-training') }}" class="text-xs text-blue-600 hover:text-blue-800">Find activities →</a>
                            </div>
                        </div>
                        
                        <div class="p-4 border-l-4 border-green-500 bg-green-50 rounded">
                            <h4 class="text-sm font-medium text-green-900 mb-2">Maintain Your Streak</h4>
                            <p class="text-xs text-green-700">You're on a {{ $analytics['achievement_milestones']['current_streak'] ?? 0 }}-day streak!</p>
                            <div class="mt-2">
                                <a href="{{ route('cpd.external-training') }}" class="text-xs text-green-600 hover:text-green-800">Keep it going →</a>
                            </div>
                        </div>
                        
                        <div class="p-4 border-l-4 border-yellow-500 bg-yellow-50 rounded">
                            <h4 class="text-sm font-medium text-yellow-900 mb-2">Plan for Renewal</h4>
                            <p class="text-xs text-yellow-700">Schedule activities before points expire</p>
                            <div class="mt-2">
                                <a href="{{ route('cpd.certificates') }}" class="text-xs text-yellow-600 hover:text-yellow-800">View expiry dates →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Options -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-download mr-2"></i>
                    Export Analytics
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button class="inline-flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Download PDF Report
                    </button>
                    <button class="inline-flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-green-700">
                        <i class="fas fa-file-excel mr-2"></i>
                        Export to Excel
                    </button>
                    <button class="inline-flex items-center justify-center px-4 py-3 bg-purple-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-purple-700">
                        <i class="fas fa-print mr-2"></i>
                        Print Summary
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
