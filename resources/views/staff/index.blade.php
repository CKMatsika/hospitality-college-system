@extends('layouts.qbo')

@section('title', 'Staff Members')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-chalkboard-teacher mr-2"></i>
            Staff Members
        </h1>
        <p class="text-gray-600 mt-2">Manage faculty and staff information.</p>
    </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">All Staff Members</h3>
                        <a href="{{ route('staff.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i> Add New Staff
                        </a>
                    </div>

                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('staff.index') }}" class="flex gap-4">
                            <input type="text" name="search" placeholder="Search staff..." value="{{ request('search') }}" 
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <select name="department" class="rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">All Departments</option>
                                @foreach($departments ?? [] as $department)
                                    <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </form>
                    </div>

                    <!-- Staff Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Staff Member</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($staff as $member)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img class="h-10 w-10 rounded-full" src="https://picsum.photos/seed/{{ $member->id }}/50/50.jpg" alt="">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $member->full_name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $member->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $member->staff_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $member->position }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $member->department->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $member->status == 'active' ? 'bg-green-100 text-green-800' : 
                                                   ($member->status == 'inactive' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($member->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('staff.show', $member) }}" class="text-green-600 hover:text-green-900 mr-3">View</a>
                                            <a href="{{ route('staff.edit', $member) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <form action="{{ route('staff.destroy', $member) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No staff members found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($staff->hasPages())
                        <div class="mt-6">
                            {{ $staff->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
