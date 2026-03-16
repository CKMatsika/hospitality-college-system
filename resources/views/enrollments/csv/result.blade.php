@extends('layouts.qbo')

@section('title', 'Import Results')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-file-import mr-2"></i>
            Import Results
        </h1>
        <p class="text-gray-600 mt-2">View the results of your CSV import operation.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Import Complete</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-green-50 p-6 rounded-lg">
                            <div class="flex items-center">
                                <div class="bg-green-100 rounded-full p-3 mr-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-green-900">{{ $imported }}</p>
                                    <p class="text-sm text-green-700">Students Imported</p>
                                </div>
                            </div>
                        </div>

                        <div class="{{ $failed > 0 ? 'bg-red-50' : 'bg-gray-50' }} p-6 rounded-lg">
                            <div class="flex items-center">
                                <div class="{{ $failed > 0 ? 'bg-red-100' : 'bg-gray-200' }} rounded-full p-3 mr-4">
                                    <svg class="w-6 h-6 {{ $failed > 0 ? 'text-red-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold {{ $failed > 0 ? 'text-red-900' : 'text-gray-500' }}">{{ $failed }}</p>
                                    <p class="text-sm {{ $failed > 0 ? 'text-red-700' : 'text-gray-500' }}">Failed Imports</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($failed > 0)
                        <div class="mb-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Failed Import Details</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Row</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Student ID</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Error</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($failures as $failure)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $failure['row'] }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $failure['student_id'] }}</td>
                                                <td class="px-4 py-2 text-sm text-red-600">{{ $failure['error'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if($imported > 0)
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <h4 class="text-sm font-medium text-blue-900 mb-2">📧 Next Steps</h4>
                            <p class="text-sm text-blue-700">
                                Successfully imported students can now log in using their email and password. 
                                You may want to:
                            </p>
                            <ul class="text-sm text-blue-700 list-disc list-inside mt-2 space-y-1">
                                <li>Send login credentials to students</li>
                                <li>Assign academic terms and enrollments</li>
                                <li>Set up fee structures for the new students</li>
                                <li>Review student profiles for completeness</li>
                            </ul>
                        </div>
                    @endif

                    <div class="flex justify-between">
                        <a href="{{ route('enrollments.csv.upload') }}" class="text-gray-600 hover:text-gray-900 font-medium py-2 px-4 rounded-lg border border-gray-300">
                            Import Another File
                        </a>
                        <div class="space-x-2">
                            @if($imported > 0)
                                <a href="{{ route('students.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    View Students
                                </a>
                            @endif
                            <a href="{{ route('enrollments.manual.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                Back to Enrollment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
