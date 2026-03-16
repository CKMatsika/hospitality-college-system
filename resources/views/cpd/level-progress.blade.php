@extends('layouts.qbo')

@section('title', 'CPD Level Progress')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-chart-line mr-2"></i>
            CPD Level Progress
        </h1>
        <p class="text-gray-600 mt-2">Track your CPD level advancement and professional development milestones.</p>
    </div>
            </h1>
            <p class="text-gray-600 mt-2">Track your professional development journey and certification requirements</p>
        </div>

        <!-- Current Level Overview -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-trophy mr-2"></i>
                        Current Level: {{ ucfirst($summary['level']) }}
                    </h3>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-blue-600">{{ $summary['active_points'] }}</div>
                        <div class="text-sm text-gray-500">Active CPD Points</div>
                    </div>
                </div>

                <!-- Level Progress Visual -->
                <div class="space-y-4">
                    @foreach(['beginner' => 0, 'basic' => 10, 'intermediate' => 25, 'advanced' => 50, 'expert' => 100] as $level => $requiredPoints)
                        <div class="flex items-center justify-between p-3 rounded-lg {{ $summary['level'] === $level ? 'bg-blue-50 border border-blue-200' : 'bg-gray-50' }}">
                            <div class="flex items-center">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center
                                    {{ $summary['active_points'] >= $requiredPoints ? 'bg-green-500' : 'bg-gray-300' }}">
                                    @if($summary['active_points'] >= $requiredPoints)
                                        <i class="fas fa-check text-white text-xs"></i>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium {{ $summary['level'] === $level ? 'text-blue-600' : 'text-gray-900' }}">
                                        {{ ucfirst($level) }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $requiredPoints }} points required</div>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($summary['active_points'] >= $requiredPoints)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Achieved
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $requiredPoints - $summary['active_points'] }} points to go
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Progress to Next Level -->
                @if($summary['level'] !== 'expert')
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-blue-900">Progress to {{ ucfirst($summary['next_level_points']['level'] ?? 'Expert' )}}</span>
                            <span class="text-sm text-blue-700">
                                {{ $summary['active_points'] }} / {{ $summary['next_level_points']['required'] ?? 100 }} points
                            </span>
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" 
                                 style="width: {{ isset($summary['next_level_points']['required']) && $summary['next_level_points']['required'] > 0 ? min(100, ($summary['active_points'] / $summary['next_level_points']['required']) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Certification Requirements -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Basic Requirements -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-certificate mr-2 text-green-500"></i>
                        Basic Certification
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Points Required</span>
                            <span class="text-sm font-medium {{ $requirements['basic']['meets_requirements'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $requirements['basic']['required_points'] }} pts
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Current Points</span>
                            <span class="text-sm font-medium text-gray-900">{{ $requirements['basic']['current_points'] }} pts</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Status</span>
                            @if($requirements['basic']['meets_requirements'])
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Eligible
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    In Progress
                                </span>
                            @endif
                        </div>
                        @if(!$requirements['basic']['meets_requirements'])
                            <div class="mt-3 p-2 bg-yellow-50 rounded">
                                <p class="text-xs text-yellow-800">
                                    Need {{ $requirements['basic']['points_needed'] }} more points
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Advanced Requirements -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-award mr-2 text-purple-500"></i>
                        Advanced Certification
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Points Required</span>
                            <span class="text-sm font-medium {{ $requirements['advanced']['meets_requirements'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $requirements['advanced']['required_points'] }} pts
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Current Points</span>
                            <span class="text-sm font-medium text-gray-900">{{ $requirements['advanced']['current_points'] }} pts</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Status</span>
                            @if($requirements['advanced']['meets_requirements'])
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Eligible
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    In Progress
                                </span>
                            @endif
                        </div>
                        @if(!$requirements['advanced']['meets_requirements'])
                            <div class="mt-3 p-2 bg-yellow-50 rounded">
                                <p class="text-xs text-yellow-800">
                                    Need {{ $requirements['advanced']['points_needed'] }} more points
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Points Breakdown -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-chart-pie mr-2"></i>
                    Points Breakdown
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $summary['active_points'] }}</div>
                        <div class="text-sm text-gray-500">Active Points</div>
                        <div class="text-xs text-gray-400 mt-1">Valid and current</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $summary['expired_points'] }}</div>
                        <div class="text-sm text-gray-500">Expired Points</div>
                        <div class="text-xs text-gray-400 mt-1">No longer valid</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $summary['total_points_earned'] }}</div>
                        <div class="text-sm text-gray-500">Total Earned</div>
                        <div class="text-xs text-gray-400 mt-1">All time achievements</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Progress -->
        @if($summary['points_by_category']->isNotEmpty())
            <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-tags mr-2"></i>
                        Progress by Category
                    </h3>
                    <div class="space-y-4">
                        @foreach($summary['points_by_category'] as $category => $data)
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-sm font-medium text-gray-900">{{ ucfirst($category) }}</h4>
                                    <span class="text-sm text-gray-600">{{ $data['active_points'] }} / {{ $data['total_points'] }} points</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" 
                                         style="width: {{ $data['total_points'] > 0 ? ($data['active_points'] / $data['total_points']) * 100 : 0 }}%"></div>
                                </div>
                                <div class="mt-2 text-xs text-gray-500">
                                    {{ $data['activities'] }} activities completed
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Upcoming Expirations -->
        @if($summary['upcoming_expirations']->isNotEmpty())
            <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-exclamation-triangle mr-2 text-yellow-500"></i>
                        Upcoming Point Expirations
                    </h3>
                    <div class="space-y-3">
                        @foreach($summary['upcoming_expirations'] as $record)
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $record->activity_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $record->category->name ?? 'General' }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-yellow-800">{{ $record->points }} pts</div>
                                    <div class="text-xs text-yellow-600">
                                        Expires {{ $record->expiry_date->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Action Items -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-tasks mr-2"></i>
                    Recommended Actions
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">
                            <i class="fas fa-arrow-up mr-2 text-blue-500"></i>
                            Next Steps
                        </h4>
                        <ul class="space-y-1 text-xs text-gray-600">
                            <li>• Focus on {{ $summary['points_by_category']->isNotEmpty() ? $summary['points_by_category']->keys()->first() : 'core' }} activities</li>
                            <li>• Complete {{ isset($summary['next_level_points']['required']) ? ($summary['next_level_points']['required'] - $summary['active_points']) : 0 }} more points for next level</li>
                            <li>• Renew expiring points before they expire</li>
                        </ul>
                    </div>
                    
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">
                            <i class="fas fa-certificate mr-2 text-green-500"></i>
                            Certification Goals
                        </h4>
                        <ul class="space-y-1 text-xs text-gray-600">
                            <li>• Basic certification: {{ $requirements['basic']['points_needed'] ?? 0 }} points needed</li>
                            <li>• Advanced certification: {{ $requirements['advanced']['points_needed'] ?? 0 }} points needed</li>
                            <li>• Expert certification: {{ $requirements['expert']['points_needed'] ?? 0 }} points needed</li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-6">
                    @if($requirements['basic']['meets_requirements'])
                        <a href="{{ route('cpd.generate-certificate') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-green-700">
                            <i class="fas fa-download mr-2"></i>
                            Generate Basic Certificate
                        </a>
                    @endif
                    <a href="{{ route('cpd.external-training') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Add External Training
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
