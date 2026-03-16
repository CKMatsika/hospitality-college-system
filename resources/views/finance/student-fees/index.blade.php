@extends('layouts.qbo')

@section('title', 'Student Fees')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user-graduate mr-2"></i>
            Student Fees
        </h1>
        <p class="text-gray-600 mt-2">Manage student fee assignments and payments.</p>
    </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Student Fees</h3>
                        <a href="{{ route('finance.student-fees.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i> Assign Fee
                        </a>
                    </div>

                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('finance.student-fees.index') }}" class="flex gap-4">
                            <input type="text" name="search" placeholder="Search student fees..." value="{{ request('search') }}" 
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            <select name="program" class="rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
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

                    <!-- Student Fees Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($studentFees as $studentFee)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img class="h-10 w-10 rounded-full" src="https://picsum.photos/seed/{{ $studentFee->student->id }}/50/50.jpg" alt="">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $studentFee->student->full_name ?? 'N/A' }}</div>
                                                    <div class="text-sm text-gray-500">{{ $studentFee->student->student_id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $studentFee->feeStructure->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ number_format($studentFee->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $studentFee->due_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $studentFee->status == 'paid' ? 'bg-green-100 text-green-800' : 
                                                   ($studentFee->status == 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($studentFee->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('finance.student-fees.show', $studentFee) }}" class="text-orange-600 hover:text-orange-900 mr-3">View</a>
                                            <a href="{{ route('finance.student-fees.edit', $studentFee) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <form action="{{ route('finance.student-fees.destroy', $studentFee) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No student fees found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($studentFees->hasPages())
                        <div class="mt-6">
                            {{ $studentFees->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
