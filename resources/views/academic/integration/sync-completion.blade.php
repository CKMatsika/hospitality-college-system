@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-sync mr-3"></i>
                Course Completion Sync
            </h1>
            <p class="text-gray-600 mt-2">Synchronize course completion status across Academic, LMS, and Online Learning systems</p>
        </div>

        <!-- Sync Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-book text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Courses</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $syncStats['total_courses'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Synced Courses</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $syncStats['synced_courses'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pending Syncs</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $syncStats['pending_syncs'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-percentage text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Success Rate</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $syncStats['sync_success_rate'] }}%</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sync Actions -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-cogs mr-2"></i>
                        Sync Operations
                    </h3>
                    <div class="text-sm text-gray-500">
                        Last sync: {{ $syncStats['last_sync'] }}
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <form action="{{ route('academic-integration.sync-completion') }}" method="POST" class="inline-block">
                        @csrf
                        <input type="hidden" name="sync_type" value="all">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Sync All Courses
                        </button>
                    </form>
                    
                    <form action="{{ route('academic-integration.sync-completion') }}" method="POST" class="inline-block">
                        @csrf
                        <input type="hidden" name="sync_type" value="pending">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-green-700">
                            <i class="fas fa-hourglass-half mr-2"></i>
                            Sync Pending Only
                        </button>
                    </form>
                    
                    <form action="{{ route('academic-integration.sync-completion') }}" method="POST" class="inline-block">
                        @csrf
                        <input type="hidden" name="sync_type" value="failed">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-red-700">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Retry Failed Syncs
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Pending Syncs -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-list-ul mr-2"></i>
                    Pending Course Synchronizations
                </h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Course
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Students
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Completion Rate
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last Activity
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pendingSyncs as $pendingSync)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $pendingSync['course']->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $pendingSync['course']->code }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pendingSync['students_count'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm text-gray-900 mr-2">{{ number_format($pendingSync['completion_rate'], 1) }}%</div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 max-w-xs">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $pendingSync['completion_rate'] }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pendingSync['last_activity'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('academic-integration.sync-completion') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $pendingSync['course']->id }}">
                                            <button type="submit" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-sync mr-1"></i>
                                                Sync Now
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
                                        <p class="text-gray-500 text-lg">All courses are synchronized!</p>
                                        <p class="text-gray-400 text-sm mt-2">No pending synchronizations at this time</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sync History -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-history mr-2"></i>
                    Recent Sync Activities
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-md">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Full system sync completed</p>
                                <p class="text-xs text-gray-500">45 courses synchronized across all platforms</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-900">2 hours ago</p>
                            <p class="text-xs text-green-600">Successful</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-md">
                        <div class="flex items-center">
                            <i class="fas fa-sync text-blue-600 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Partial sync completed</p>
                                <p class="text-xs text-gray-500">12 courses with completion updates</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-900">4 hours ago</p>
                            <p class="text-xs text-blue-600">Partial</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-md">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Sync completed with warnings</p>
                                <p class="text-xs text-gray-500">3 courses had data inconsistencies</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-900">6 hours ago</p>
                            <p class="text-xs text-yellow-600">Warning</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-md">
                        <div class="flex items-center">
                            <i class="fas fa-times-circle text-red-600 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Sync failed</p>
                                <p class="text-xs text-gray-500">LMS system temporarily unavailable</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-900">8 hours ago</p>
                            <p class="text-xs text-red-600">Failed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sync Configuration -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-sliders-h mr-2"></i>
                    Sync Configuration
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Sync Settings</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="text-sm text-gray-700">Auto-sync completion status</label>
                                <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="text-sm text-gray-700">Sync grades and scores</label>
                                <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="text-sm text-gray-700">Generate certificates on completion</label>
                                <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="text-sm text-gray-700">Send completion notifications</label>
                                <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Schedule</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm text-gray-700">Auto-sync Frequency</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option>Every 15 minutes</option>
                                    <option>Every hour</option>
                                    <option selected>Every 4 hours</option>
                                    <option>Daily</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm text-gray-700">Retry Failed Syncs</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option>Immediately</option>
                                    <option selected>After 1 hour</option>
                                    <option>After 4 hours</option>
                                    <option>Manual only</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm text-gray-700">Batch Size</label>
                                <input type="number" value="50" min="1" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>
                        Save Configuration
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
