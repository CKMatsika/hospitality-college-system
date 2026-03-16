@extends('layouts.qbo')

@section('title', 'CPD Dashboard')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-award mr-2"></i>
            CPD Dashboard
        </h1>
        <p class="text-gray-600 mt-2">Track your Continuing Professional Development progress.</p>
    </div>

    <!-- CPD Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Active Points" 
            value="{{ number_format($summary['active_points'], 1) }}" 
            icon="fas fa-star" 
            color="blue"
            trend="up"
            trendValue="Current total"
        />
        <x-stat-card 
            title="Current Level" 
            value="{{ ucfirst($summary['level']) }}" 
            icon="fas fa-trophy" 
            color="green"
            trend="stable"
            trendValue="Achievement level"
        />
        <x-stat-card 
            title="Total Activities" 
            value="{{ $summary['total_activities'] }}" 
            icon="fas fa-certificate" 
            color="purple"
            trend="up"
            trendValue="Completed"
        />
        <x-stat-card 
            title="Next Level" 
            value="{{ $summary['next_level_points'] }} pts" 
            icon="fas fa-clock" 
            color="yellow"
            trend="stable"
            trendValue="Points needed"
        />
    </div>

    <!-- Level Progress & Categories -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Level Progress -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">
                <i class="fas fa-chart-line mr-2"></i>
                Level Progress
            </h2>
            <div class="space-y-4">
                @foreach(['beginner' => 0, 'basic' => 10, 'intermediate' => 25, 'advanced' => 50, 'expert' => 100] as $level => $requiredPoints)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-4 h-4 rounded-full 
                                {{ $summary['active_points'] >= $requiredPoints ? 'bg-green-500' : 'bg-gray-300' }}">
                            </div>
                            <span class="ml-3 text-sm font-medium {{ $summary['level'] === $level ? 'text-blue-600' : 'text-gray-900' }}">
                                {{ ucfirst($level) }}
                            </span>
                        </div>
                        <span class="text-sm text-gray-500">{{ $requiredPoints }} pts</span>
                    </div>
                @endforeach
                
                <div class="mt-6">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Progress to Expert</span>
                        <span>{{ round(($summary['active_points'] / 100) * 100) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ round(($summary['active_points'] / 100) * 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Points by Category -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">
                <i class="fas fa-chart-pie mr-2"></i>
                Points by Category
            </h2>
            <div class="space-y-3">
                @foreach($summary['points_by_category'] as $category => $data)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $category }}</p>
                            <p class="text-xs text-gray-500">{{ $data['activities'] }} activities</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ number_format($data['active_points'], 1) }} pts</p>
                            <p class="text-xs text-gray-500">{{ number_format($data['total_points'], 1) }} total</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Upcoming Expirations & Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Upcoming Expirations -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Upcoming Expirations
            </h2>
            @if($summary['upcoming_expirations']->count() > 0)
                <div class="space-y-3">
                    @foreach($summary['upcoming_expirations'] as $expiration)
                        <div class="flex items-center justify-between p-3 
                            {{ $expiration['days_until_expiry'] <= 7 ? 'bg-red-50 border border-red-200' : 'bg-yellow-50 border border-yellow-200' }} rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $expiration['activity'] }}</p>
                                <p class="text-xs text-gray-500">{{ $expiration['category'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium 
                                    {{ $expiration['days_until_expiry'] <= 7 ? 'text-red-600' : 'text-yellow-600' }}">
                                    {{ $expiration['days_until_expiry'] }} days
                                </p>
                                <p class="text-xs text-gray-500">{{ $expiration['expiry_date']->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-green-500 text-4xl mb-3"></i>
                    <p class="text-gray-500">No upcoming expirations</p>
                </div>
            @endif
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">
                <i class="fas fa-history mr-2"></i>
                Recent Activities
            </h2>
            <div class="space-y-3">
                @foreach($summary['recent_activities'] as $activity)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $activity->activity_name }}</p>
                            <p class="text-xs text-gray-500">{{ $activity->getActivityTypeLabel() }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ $activity->getFormattedPoints() }} pts</p>
                            <p class="text-xs text-gray-500">{{ $activity->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('cpd.external-training') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Add External Training
            </a>
            <a href="{{ route('cpd.generate-certificate') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-certificate mr-2"></i> Generate Certificate
            </a>
            <a href="{{ route('cpd.analytics') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-chart-bar mr-2"></i> View Analytics
            </a>
        </div>
    </div>

@endsection
