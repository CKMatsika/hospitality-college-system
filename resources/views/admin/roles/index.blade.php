@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-shield-alt mr-3"></i>
                    Role Management
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                        <i class="fas fa-users mr-2"></i>
                        Manage Users
                    </a>
                    <a href="{{ route('admin.permissions') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-green-700">
                        <i class="fas fa-key mr-2"></i>
                        Permissions
                    </a>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Manage system roles and their permissions</p>
        </div>

        <!-- Create New Role -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Create New Role
                </h3>
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                            <input type="text" id="name" name="name" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Use lowercase with hyphens (e.g., 'content-manager')</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                            <div class="space-y-2 max-h-32 overflow-y-auto border rounded-md p-3">
                                @foreach($permissions as $group => $groupPermissions)
                                    <div class="mb-2">
                                        <p class="text-xs font-semibold text-gray-700 uppercase">{{ $group }}</p>
                                        @foreach($groupPermissions as $permission)
                                            <label class="flex items-center">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-xs text-gray-600">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i>
                            Create Role
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Existing Roles -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Existing Roles
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $roles->total() }} total roles
                    </div>
                </div>

                @if($roles->count() > 0)
                    <div class="space-y-4">
                        @foreach($roles as $role)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-medium text-gray-900">
                                            {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                        </h4>
                                        <p class="text-sm text-gray-500">{{ $role->permissions->count() }} permissions</p>
                                        
                                        <div class="mt-3">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($role->permissions->take(10) as $permission)
                                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                                        {{ $permission->name }}
                                                    </span>
                                                @endforeach
                                                @if($role->permissions->count() > 10)
                                                    <span class="px-2 py-1 text-xs bg-gray-200 text-gray-600 rounded">
                                                        +{{ $role->permissions->count() - 10 }} more
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-2 ml-4">
                                        @if($role->name !== 'super-admin')
                                            <button onclick="editRole({{ $role->id }}, '{{ $role->name }}')" 
                                                    class="text-blue-600 hover:text-blue-900 text-sm">
                                                <i class="fas fa-edit mr-1"></i>
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                                    <i class="fas fa-trash mr-1"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-500">Protected</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $roles->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-shield-alt text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No roles found</p>
                        <p class="text-gray-400 text-sm mt-2">Create your first role above</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function editRole(roleId, roleName) {
    // This would open an edit modal - for now just reload
    location.reload();
}
</script>
@endsection
