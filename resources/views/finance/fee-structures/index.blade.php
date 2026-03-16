@extends('layouts.qbo')

@section('title', 'Fee Structures')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-list-alt mr-2"></i>
            Fee Structures
        </h1>
        <p class="text-gray-600 mt-2">Manage fee structures for different programs and courses.</p>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Fee Structures Management</h2>
            <a href="{{ route('finance.fee-structures.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Add Fee Structure
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="mb-6">
            <form method="GET" action="{{ route('finance.fee-structures.index') }}" class="flex gap-4">
                <input type="text" name="search" placeholder="Search fee structures..." value="{{ request('search') }}" 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <select name="program" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Programs</option>
                    @foreach($programs ?? [] as $program)
                        <option value="{{ $program->id }}" {{ request('program') == $program->id ? 'selected' : '' }}>
                            {{ $program->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>

        <!-- Fee Structures Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($feeStructures as $feeStructure)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $feeStructure->name }}</div>
                                    @if($feeStructure->description)
                                        <div class="text-xs text-gray-500">{{ Str::limit($feeStructure->description, 50) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $feeStructure->program->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                ${{ number_format($feeStructure->amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($feeStructure->payment_type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $feeStructure->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($feeStructure->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex space-x-2">
                                    <a href="{{ route('finance.student-fees.create', ['fee_structure_id' => $feeStructure->id]) }}" class="text-green-600 hover:text-green-800 font-medium">Assign</a>
                                    <a href="{{ route('finance.fee-structures.edit', $feeStructure) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                    <form action="{{ route('finance.fee-structures.destroy', $feeStructure) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this fee structure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                <i class="fas fa-list-alt text-4xl mb-4"></i>
                                <p>No fee structures found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($feeStructures->hasPages())
            <div class="mt-6">
                {{ $feeStructures->links() }}
            </div>
        @endif
    </div>

@endsection
