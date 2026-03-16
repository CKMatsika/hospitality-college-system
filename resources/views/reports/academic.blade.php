<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Academic Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Overview</h3>
                        <p class="text-sm text-gray-500">Top courses by enrollment and program/department statistics.</p>
                    </div>
                    <a href="{{ route('reports.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Back to Reports</a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Top Courses by Enrollment</h3>
                    </div>
                    <div class="p-6">
                        @if($courseEnrollment->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Enrollments</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($courseEnrollment as $course)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $course->name }}</td>
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
                        <h3 class="text-lg font-medium text-gray-900">Programs (Students / Courses)</h3>
                    </div>
                    <div class="p-6">
                        @if($programStats->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Program</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Students</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Courses</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($programStats as $program)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $program->name }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900 text-right font-semibold">{{ $program->students_count }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900 text-right font-semibold">{{ $program->courses_count }}</td>
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
                    <h3 class="text-lg font-medium text-gray-900">Departments (Programs / Staff)</h3>
                </div>
                <div class="p-6">
                    @if($departmentStats->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Programs</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Staff</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($departmentStats as $dept)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $dept->name }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900 text-right font-semibold">{{ $dept->programs_count }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900 text-right font-semibold">{{ $dept->staff_count }}</td>
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
