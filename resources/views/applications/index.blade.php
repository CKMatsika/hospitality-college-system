@extends('layouts.qbo')

@section('title', 'Student Applications')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-file-alt mr-2"></i>
            Student Applications
        </h1>
        <p class="text-gray-600 mt-2">Manage student applications and admissions process.</p>
    </div>

    <!-- Application Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Applications" 
            value="156" 
            icon="fas fa-file-alt" 
            color="blue"
            trend="up"
            trendValue="All time"
        />
        <x-stat-card 
            title="Pending Review" 
            value="23" 
            icon="fas fa-clock" 
            color="yellow"
            trend="stable"
            trendValue="Awaiting decision"
        />
        <x-stat-card 
            title="Approved" 
            value="89" 
            icon="fas fa-check-circle" 
            color="green"
            trend="up"
            trendValue="Accepted students"
        />
        <x-stat-card 
            title="Rejected" 
            value="44" 
            icon="fas fa-times-circle" 
            color="red"
            trend="down"
            trendValue="Not accepted"
        />
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('applications.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> New Application
            </a>
            <a href="{{ route('enrollments.manual.index') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-user-plus mr-2"></i> Manual Enrollment
            </a>
            <a href="{{ route('enrollments.csv.upload') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-file-csv mr-2"></i> CSV Enrollment
            </a>
        </div>
    </div>

    <!-- Applications List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Applications</h2>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-download mr-1"></i> Export
                </button>
            </div>
        </div>
                        </a>
                    </div>

                    @if ($applications->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">App #</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Program</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Applied</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($applications as $application)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $application->application_number }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $application->full_name }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $application->email }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $application->program->name }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $application->status == 'approved' ? 'bg-green-100 text-green-800' : 
                                                       ($application->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $application->created_at->format('M d, Y') }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">
                                                <a href="{{ route('applications.show', $application) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $applications->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No applications found.</p>
                            <a href="{{ route('applications.create') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-900">
                                Submit the first application →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
