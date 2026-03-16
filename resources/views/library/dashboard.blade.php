@extends('layouts.qbo')

@section('title', 'Library Dashboard')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-book-open mr-2"></i>
            Library Dashboard
        </h1>
        <p class="text-gray-600 mt-2">Manage your library collection, loans, and reservations.</p>
    </div>

    <!-- Library Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Books" 
            value="{{ $stats['total_books'] }}" 
            icon="fas fa-book" 
            color="indigo"
            trend="stable"
            trendValue="In collection"
        />
        <x-stat-card 
            title="Available Books" 
            value="{{ $stats['available_books'] }}" 
            icon="fas fa-check-circle" 
            color="green"
            trend="stable"
            trendValue="Ready to borrow"
        />
        <x-stat-card 
            title="Borrowed Books" 
            value="{{ $stats['borrowed_books'] }}" 
            icon="fas fa-hand-holding" 
            color="yellow"
            trend="stable"
            trendValue="Currently out"
        />
        <x-stat-card 
            title="Overdue Books" 
            value="{{ $stats['overdue_books'] }}" 
            icon="fas fa-exclamation-triangle" 
            color="red"
            trend="down"
            trendValue="Need attention"
        />
    </div>

    <!-- Recent Loans -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Loans</h2>
            <a href="{{ route('library.loans.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
        </div>
        @if($recentLoans->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Borrower</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Borrow Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recentLoans as $loan)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $loan->book->title }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $loan->borrowable->full_name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $loan->borrow_date->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $loan->due_date->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $loan->status == 'borrowed' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($loan->status == 'returned' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-hand-holding text-4xl mb-4"></i>
                <p>No loans recorded yet.</p>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('library.books.create') }}" class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Add Book
            </a>
            <a href="{{ route('library.loans.create') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-hand-holding mr-2"></i> Borrow Book
            </a>
            <a href="{{ route('library.reservations.create') }}" class="flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-bookmark mr-2"></i> Reserve Book
            </a>
            <a href="{{ route('library.books.index') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-list mr-2"></i> Browse Books
            </a>
        </div>
    </div>

@endsection
