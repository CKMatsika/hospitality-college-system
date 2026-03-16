<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('LMS Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Overview</h3>
                        <p class="text-sm text-gray-500">Course completion, enrollments and student progress.</p>
                    </div>
                    <a href="{{ route('reports.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Back to Reports</a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Enrollment by Course</h3>
                    </div>
                    <div class="p-6">
                        @if($enrollmentByCourse->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Enrollments</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($enrollmentByCourse as $course)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $course->title }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900 text-right font-semibold">{{ $course->enrollments_count }}</td>
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
                        <h3 class="text-lg font-medium text-gray-900">Progress by Status</h3>
                    </div>
                    <div class="p-6">
                        @if($studentProgress->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Count</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Avg Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($studentProgress as $row)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ ucfirst($row->status ?? 'unknown') }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900 text-right font-semibold">{{ $row->count }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900 text-right font-semibold">{{ number_format($row->avg_progress ?? 0, 1) }}%</td>
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
                    <h3 class="text-lg font-medium text-gray-900">Course Completion Rates</h3>
                </div>
                <div class="p-6">
                    @if($courseCompletion->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Completion Rate</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($courseCompletion as $course)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $course->title }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900 text-right font-semibold">{{ number_format($course->completion_rate ?? 0, 1) }}%</td>
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
    </div>
</x-app-layout>
