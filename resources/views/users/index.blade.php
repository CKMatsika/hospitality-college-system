@extends('layouts.qbo')

@section('title', 'User Management')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-users-cog mr-2"></i>
            User Management
        </h1>
        <p class="text-gray-600 mt-2">Manage system users and their roles.</p>
    </div>

    <!-- User Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Users" 
            value="{{ $users->total() }}" 
            icon="fas fa-users" 
            color="blue"
            trend="stable"
            trendValue="All registered users"
        />
        <x-stat-card 
            title="Admins" 
            value="{{ $users->where('role', 'admin')->count() }}" 
            icon="fas fa-user-shield" 
            color="red"
            trend="stable"
            trendValue="System administrators"
        />
        <x-stat-card 
            title="Staff" 
            value="{{ $users->where('role', 'staff')->count() }}" 
            icon="fas fa-chalkboard-teacher" 
            color="green"
            trend="stable"
            trendValue="Teaching staff"
        />
        <x-stat-card 
            title="Students" 
            value="{{ $users->where('role', 'student')->count() }}" 
            icon="fas fa-user-graduate" 
            color="purple"
            trend="stable"
            trendValue="Student accounts"
        />
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">All Users</h2>
            <a href="{{ route('users.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Add User
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-500 text-xs"></i>
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                       ($user->role === 'staff' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex space-x-2">
                                    <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                                    <a href="{{ route('users.edit', $user) }}" class="text-green-600 hover:text-green-800 font-medium">Edit</a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>

@endsection
