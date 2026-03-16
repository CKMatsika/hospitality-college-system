@extends('layouts.qbo')

@section('title', 'CPD History')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-history mr-2"></i>
            CPD History
        </h1>
        <p class="text-gray-600 mt-2">View your complete CPD activity history and track your professional development journey.</p>
    </div>
                    CPD History
                </h1>
                <p class="text-gray-600 mt-2">Complete record of your CPD activities</p>
            </div>
            <a href="{{ route('cpd.external-training') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>
                Add Activity
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <form method="GET" action="{{ route('cpd.history') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="activity_type" class="block text-sm font-medium text-gray-700">Activity Type</label>
                        <select id="activity_type" name="activity_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Types</option>
                            <option value="exam">Online Exam</option>
                            <option value="lesson">Online Lesson</option>
                            <option value="short_course">Short Course</option>
                            <option value="external_training">External Training</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            @foreach(App\Models\CpdCategory::orderBy('name')->get() as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                            <i class="fas fa-filter mr-2"></i>
                            Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- CPD Records Table -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Activity
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Points
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Expiry
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($records as $record)
                                <tr class="{{ $record->isExpired() ? 'bg-red-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $record->activity_name }}</p>
                                            @if($record->provider)
                                                <p class="text-xs text-gray-500">{{ $record->provider }}</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $record->getActivityTypeLabel() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $record->category->name ?? 'General' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $record->getFormattedPoints() }} pts
                                        </div>
                                        @if($record->hours)
                                            <p class="text-xs text-gray-500">{{ $record->hours }} hours</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            bg-{{ $record->getStatusColor() }}-100 text-{{ $record->getStatusColor() }}-800">
                                            {{ $record->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($record->expiry_date)
                                            <div class="{{ $record->isExpired() ? 'text-red-600' : 'text-gray-900' }}">
                                                {{ $record->expiry_date->format('M d, Y') }}
                                            </div>
                                            <p class="text-xs {{ $record->isExpired() ? 'text-red-500' : 'text-gray-500' }}">
                                                {{ $record->getDaysUntilExpiry() > 0 ? $record->getDaysUntilExpiry() . ' days left' : 'Expired' }}
                                            </p>
                                        @else
                                            <span class="text-sm text-gray-500">No expiry</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $record->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if($record->certificate_path)
                                                <a href="{{ asset('storage/' . $record->certificate_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            @endif
                                            @if($record->isPending())
                                                <button class="text-yellow-600 hover:text-yellow-900" title="Pending Approval">
                                                    <i class="fas fa-clock"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($records->isEmpty())
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No CPD records found</p>
                        <p class="text-gray-400 text-sm mt-2">Start adding activities to build your CPD portfolio</p>
                        <div class="mt-4">
                            <a href="{{ route('cpd.external-training') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Add Your First Activity
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if($records->hasPages())
            <div class="mt-6">
                {{ $records->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
