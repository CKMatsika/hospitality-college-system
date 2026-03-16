@extends('layouts.qbo')

@section('title', 'User Details')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user mr-2"></i>
            User Details
        </h1>
        <p class="text-gray-600 mt-2">View user information and activity.</p>
    </div>

    <!-- User Profile -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-user text-blue-500 text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
            </div>
            <div class="space-x-3">
                <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Basic Info -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                <div class="space-y-4">
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-sm text-gray-500">User ID</span>
                        <span class="text-sm font-medium text-gray-900">#{{ $user->id }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-sm text-gray-500">Full Name</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->name }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-sm text-gray-500">Email Address</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-sm text-gray-500">Role</span>
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                               ($user->role === 'staff' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-sm text-gray-500">Email Verified</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $user->email_verified_at ? 'Yes (' . $user->email_verified_at->format('M d, Y') . ')' : 'No' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Timestamps -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Timestamps</h3>
                <div class="space-y-4">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $user->created_at->format('M d, Y') }}</div>
                        <div class="text-sm text-gray-500">Created Date</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $user->updated_at->format('M d, Y') }}</div>
                        <div class="text-sm text-gray-500">Last Updated</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Recent Activity</h2>
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-history text-4xl mb-4"></i>
            <p>No recent activity to display.</p>
        </div>
    </div>

@endsection
