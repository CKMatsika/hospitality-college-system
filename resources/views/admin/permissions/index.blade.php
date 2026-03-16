@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-key mr-3"></i>
                    Permission Management
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.roles') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-purple-700">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Manage Roles
                    </a>
                    <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                        <i class="fas fa-users mr-2"></i>
                        Manage Users
                    </a>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Manage system permissions and access control</p>
        </div>

        <!-- Create New Permission -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Create New Permission
                </h3>
                <form action="{{ route('admin.permissions.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Permission Name</label>
                            <input type="text" id="name" name="name" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Use format: 'module.action' (e.g., 'students.edit')</p>
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            <p class="mt-1 text-xs text-gray-500">Optional description of what this permission allows</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-green-700">
                            <i class="fas fa-save mr-2"></i>
                            Create Permission
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Existing Permissions -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-key mr-2"></i>
                        System Permissions
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $permissions->flatten()->count() }} total permissions
                    </div>
                </div>

                @if($permissions->count() > 0)
                    <div class="space-y-6">
                        @foreach($permissions as $group => $groupPermissions)
                            <div class="border rounded-lg p-4">
                                <h4 class="text-lg font-medium text-gray-900 mb-3">
                                    <i class="fas fa-folder mr-2"></i>
                                    {{ ucfirst($group) }} Permissions
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach($groupPermissions as $permission)
                                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $permission->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $permission->created_at->format('M d, Y') }}</p>
                                            </div>
                                            <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permission?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-key text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No permissions found</p>
                        <p class="text-gray-400 text-sm mt-2">Create your first permission above</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
