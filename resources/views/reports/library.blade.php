<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Library Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Overview</h3>
                        <p class="text-sm text-gray-500">Popular books, monthly usage, and overdue loans.</p>
                    </div>
                    <a href="{{ route('reports.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Back to Reports</a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Most Popular Books</h3>
                    </div>
                    <div class="p-6">
                        @if($popularBooks->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Loans</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($popularBooks as $row)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $row->title }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-700">{{ $row->author }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900 text-right font-semibold">{{ $row->loan_count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No data available.</p>
                        @endif
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Usage by Month (Last 12)</h3>
                    </div>
                    <div class="p-6">
                        @if($libraryUsage->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Loans</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($libraryUsage as $row)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $row->year }}-{{ str_pad($row->month, 2, '0', STR_PAD_LEFT) }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900 text-right font-semibold">{{ $row->loans }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No data available.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Overdue Books</h3>
                </div>
                <div class="p-6">
                    @if($overdueBooks->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Book</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Borrower</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($overdueBooks as $loan)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $loan->book->title ?? 'N/A' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-700">{{ $loan->user->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ optional($loan->due_date)->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No overdue loans found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
