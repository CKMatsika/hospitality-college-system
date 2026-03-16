<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Book Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $book->title }}</h1>
                            <p class="text-gray-600">ISBN: {{ $book->isbn }}</p>
                            <p class="text-gray-600">{{ $book->author }}</p>
                            <p class="text-gray-600">{{ $book->category->name ?? 'No Category' }}</p>
                            <span class="mt-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $book->available_copies > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $book->available_copies > 0 ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('library.books.edit', $book) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            <a href="{{ route('library.books.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Book Information</h3>
                        </div>
                        <div class="p-6">
                            @if($book->description)
                                <div class="mb-6">
                                    <h4 class="text-md font-medium text-gray-900 mb-2">Description</h4>
                                    <p class="text-gray-700">{{ $book->description }}</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">ISBN</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $book->isbn }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Author</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $book->author }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Publisher</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $book->publisher ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Publication Year</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $book->publication_year ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Total Copies</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $book->total_copies }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Available Copies</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $book->available_copies }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Location</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $book->location ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loan History -->
                    <div class="bg-white shadow-sm sm:rounded-lg mt-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">Loan History</h3>
                                <span class="text-sm text-gray-500">{{ $book->loans->count() }} loans recorded</span>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($book->loans->count() > 0)
                                <div class="space-y-3">
                                    @foreach($book->loans as $loan)
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="font-medium text-gray-900">{{ $loan->borrowable->full_name ?? 'N/A' }}</h4>
                                                    <p class="text-sm text-gray-500">ID: {{ $loan->borrowable->student_id ?? $loan->borrowable->staff_id }}</p>
                                                    <p class="text-sm text-gray-500">Borrowed: {{ $loan->borrow_date->format('M d, Y') }}</p>
                                                </div>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                    {{ $loan->status == 'borrowed' ? 'bg-yellow-100 text-yellow-800' : 
                                                       ($loan->status == 'returned' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($loan->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No loan history found.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Statistics -->
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Statistics</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-indigo-600">{{ $book->total_copies }}</div>
                                    <div class="text-sm text-gray-500">Total Copies</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-green-600">{{ $book->available_copies }}</div>
                                    <div class="text-sm text-gray-500">Available</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-yellow-600">{{ $book->loans->count() }}</div>
                                    <div class="text-sm text-gray-500">Total Loans</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @if($book->available_copies > 0)
                                    <a href="{{ route('library.loans.create', ['book_id' => $book->id]) }}" class="block w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors">
                                        <i class="fas fa-hand-holding mr-2"></i> Borrow Book
                                    </a>
                                @else
                                    <div class="block w-full bg-gray-300 text-gray-500 font-medium py-2 px-4 rounded-lg text-center">
                                        <i class="fas fa-times-circle mr-2"></i> Book Unavailable
                                    </div>
                                @endif
                                <a href="{{ route('library.reservations.create', ['book_id' => $book->id]) }}" class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors">
                                    <i class="fas fa-bookmark mr-2"></i> Reserve Book
                                </a>
                                <a href="{{ route('library.books.edit', $book) }}" class="block w-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors">
                                    <i class="fas fa-edit mr-2"></i> Edit Book
                                </a>
                                <a href="{{ route('library.books.index') }}" class="block w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors">
                                    <i class="fas fa-list mr-2"></i> All Books
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
