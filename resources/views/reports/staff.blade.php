<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Overview</h3>
                        <p class="text-sm text-gray-500">Staff distribution by department, status and employment type.</p>
                    </div>
                    <a href="{{ route('reports.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Back to Reports</a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Staff by Department</h3>
                    </div>
                    <div class="p-6">
                        @if($staffByDepartment->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Count</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($staffByDepartment as $row)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $row->name }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900 text-right font-semibold">{{ $row->count }}</td>
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
                        <h3 class="text-lg font-medium text-gray-900">Staff Status</h3>
                    </div>
                    <div class="p-6">
                        @if($staffStatus->count() > 0)
                            <div class="space-y-3">
                                @foreach($staffStatus as $row)
                                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                                        <div class="text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $row->status ?? 'unknown')) }}</div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $row->count }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No data available.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Employment Types</h3>
                </div>
                <div class="p-6">
                    @if($employmentTypes->count() > 0)
                        <div class="space-y-3">
                            @foreach($employmentTypes as $row)
                                <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                                    <div class="text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $row->employment_type ?? 'unknown')) }}</div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $row->count }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
