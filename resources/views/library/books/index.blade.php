@extends('layouts.qbo')

@section('title', 'Library Books')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-book-open mr-2"></i>
            Library Books
        </h1>
        <p class="text-gray-600 mt-2">Manage your library book collection.</p>
    </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Book Collection</h3>
                        <a href="{{ route('library.books.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i> Add New Book
                        </a>
                    </div>

                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('library.books.index') }}" class="flex gap-4">
                            <input type="text" name="search" placeholder="Search books..." value="{{ request('search') }}" 
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <select name="category" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Categories</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </form>
                    </div>

                    <!-- Books Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($books as $book)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-semibold text-gray-900 line-clamp-2">{{ $book->title }}</h4>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $book->available_copies > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $book->available_copies > 0 ? 'Available' : 'Unavailable' }}
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 mb-4">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Author:</span> {{ $book->author }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">ISBN:</span> {{ $book->isbn }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Category:</span> {{ $book->category->name ?? 'N/A' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Copies:</span> {{ $book->available_copies }}/{{ $book->total_copies }}
                                        </p>
                                        @if($book->publication_year)
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Year:</span> {{ $book->publication_year }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    @if($book->description)
                                        <p class="text-sm text-gray-700 mb-4 line-clamp-3">{{ $book->description }}</p>
                                    @endif
                                    
                                    <div class="flex justify-between">
                                        <a href="{{ route('library.books.show', $book) }}" 
                                           class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                            View Details
                                        </a>
                                        <div class="space-x-2">
                                            <a href="{{ route('library.loans.create', ['book_id' => $book->id]) }}" 
                                               class="text-green-600 hover:text-green-800 font-medium text-sm">
                                                Borrow
                                            </a>
                                            <a href="{{ route('library.books.edit', $book) }}" 
                                               class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                                Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500">No books found.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($books->hasPages())
                        <div class="mt-8">
                            {{ $books->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
