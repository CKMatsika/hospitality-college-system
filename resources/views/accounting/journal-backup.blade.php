@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-book mr-2"></i>
                        Journal Entries
                    </h1>
                    <div class="flex space-x-3">
                        <a href="{{ route('accounting.journal.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-plus mr-2"></i>
                            New Entry
                        </a>
                        <a href="{{ route('accounting.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Dashboard
                        </a>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-blue-900">Total Entries</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ $entries->total() }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-green-900">Posted</h3>
                        <p class="text-2xl font-bold text-green-600">{{ $entries->where('status', 'posted')->count() }}</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-yellow-900">Draft</h3>
                        <p class="text-2xl font-bold text-yellow-600">{{ $entries->where('status', 'draft')->count() }}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-purple-900">This Month</h3>
                        <p class="text-2xl font-bold text-purple-600">{{ $entries->filter(function($entry) { return $entry->entry_date && $entry->entry_date->month == now()->month; })->count() }}</p>
                    </div>
                </div>

                <!-- Journal Entries Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Entry Number
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reference
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Period
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($entries as $entry)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $entry->entry_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry->entry_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $entry->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry->reference ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry->financialPeriod->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $entry->status === 'posted' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $entry->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                            {{ ucfirst($entry->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($entry->total_debit + $entry->total_credit, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($entry->status === 'draft')
                                            <a href="{{ route('accounting.journal.edit', $entry->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                            <form action="{{ route('accounting.journal.post', $entry->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Post</button>
                                            </form>
                                            <form action="{{ route('accounting.journal.delete', $entry->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this journal entry?')">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        @else
                                            <a href="{{ route('accounting.journal.show', $entry->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                            <form action="{{ route('accounting.journal.reverse', $entry->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reverse this posted entry?')">
                                                @csrf
                                                <button type="submit" class="text-orange-600 hover:text-orange-900">Reverse</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($entries->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No journal entries found</p>
                        <p class="text-gray-400 text-sm mt-2">Start by creating your first journal entry</p>
                        <div class="mt-4">
                            <a href="{{ route('accounting.journal.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Create Journal Entry
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Pagination -->
                @if($entries->hasPages())
                    <div class="mt-6">
                        {{ $journalEntries->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
