@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-users mr-3"></i>
                    User Management
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.roles') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-purple-700">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Manage Roles
                    </a>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Manage user roles and permissions</p>
        </div>

        <!-- Users Table -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-users mr-2"></i>
                        System Users
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $users->total() }} total users
                    </div>
                </div>

                @if($users->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Current Roles
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
                                @foreach($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <span class="text-blue-600 font-medium">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $user->name }}
                                                    </div>
                                                    @if($user->student)
                                                        <div class="text-xs text-gray-500">Student: {{ $user->student->student_id }}</div>
                                                    @elseif($user->staff)
                                                        <div class="text-xs text-gray-500">Staff: {{ $user->staff->staff_id }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($user->roles as $role)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $role->name === 'super-admin' ? 'bg-red-100 text-red-800' : 
                                                           ($role->name === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                                           ($role->name === 'finance-manager' ? 'bg-green-100 text-green-800' : 
                                                           ($role->name === 'academic-manager' ? 'bg-blue-100 text-blue-800' : 
                                                           ($role->name === 'teacher' ? 'bg-yellow-100 text-yellow-800' : 
                                                           ($role->name === 'librarian' ? 'bg-indigo-100 text-indigo-800' : 
                                                           'bg-gray-100 text-gray-800'))) }}">
                                                        {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($user->is_active)
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button onclick="openRoleModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->roles->pluck('name')->implode(',') }}')" 
                                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                                <i class="fas fa-user-tag mr-1"></i>
                                                Manage Roles
                                            </button>
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
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-users text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No users found</p>
                        <p class="text-gray-400 text-sm mt-2">There are no users in the system yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Role Management Modal -->
<div id="roleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Manage User Roles</h3>
            <p class="text-sm text-gray-500 mb-4">Select roles for: <span id="modalUserName" class="font-medium"></span></p>
            
            <form id="roleForm">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="userId" name="user_id">
                
                <div class="space-y-3">
                    @foreach($roles as $role)
                        <label class="flex items-center">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">{{ ucfirst(str_replace('-', ' ', $role->name)) }}</span>
                        </label>
                    @endforeach
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeRoleModal()" 
                            class="px-4 py-2 bg-gray-300 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Roles
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRoleModal(userId, userName, currentRoles) {
    document.getElementById('userId').value = userId;
    document.getElementById('modalUserName').textContent = userName;
    document.getElementById('roleModal').classList.remove('hidden');
    
    // Clear all checkboxes
    document.querySelectorAll('input[name="roles[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Check current roles
    if (currentRoles) {
        currentRoles.split(',').forEach(role => {
            const checkbox = document.querySelector(`input[name="roles[]"][value="${role.trim()}"]`);
            if (checkbox) checkbox.checked = true;
        });
    }
}

function closeRoleModal() {
    document.getElementById('roleModal').classList.add('hidden');
}

// Handle form submission
document.getElementById('roleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const userId = document.getElementById('userId').value;
    const formData = new FormData(this);
    
    fetch(`/admin/users/${userId}/roles`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(formData)
    })
    .then(response => response.json())
    .then(data => {
        closeRoleModal();
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>
@endsection
