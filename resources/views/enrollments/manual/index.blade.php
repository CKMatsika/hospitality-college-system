@extends('layouts.qbo')

@section('title', 'Manual Enrollment')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user-plus mr-2"></i>
            Manual Enrollment
        </h1>
        <p class="text-gray-600 mt-2">Directly enroll students into courses and programs.</p>
    </div>

    <!-- Enrollment Options -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Enrollment Options</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-100 rounded-full p-3 mr-4">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-900">Single Student Enrollment</h4>
                            </div>
                            <p class="text-gray-600 mb-4">
                                Manually enroll a single student with all their details and optional document uploads.
                            </p>
                            <a href="{{ route('enrollments.manual.create') }}" class="inline-flex items-center text-blue-600 hover:text-blue-900 font-medium">
                                Enroll Single Student
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="bg-green-100 rounded-full p-3 mr-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-900">Bulk CSV Import</h4>
                            </div>
                            <p class="text-gray-600 mb-4">
                                Import multiple students at once using a CSV file with validation and error reporting.
                            </p>
                            <a href="{{ route('enrollments.csv.upload') }}" class="inline-flex items-center text-green-600 hover:text-green-900 font-medium">
                                Import from CSV
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">📋 Quick Tips</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Single enrollment allows document uploads (ID, transcripts, etc.)</li>
                            <li>• CSV import requires specific column headers and formats</li>
                            <li>• Both methods create user accounts and student records</li>
                            <li>• Students will be automatically enrolled in their program</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
