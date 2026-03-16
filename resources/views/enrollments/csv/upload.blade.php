@extends('layouts.qbo')

@section('title', 'CSV Bulk Import')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-file-csv mr-2"></i>
            CSV Bulk Import
        </h1>
        <p class="text-gray-600 mt-2">Import multiple students at once using a CSV file.</p>
    </div>

    <!-- Import Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Import Students from CSV</h2>
        </div>
        
        <div class="mb-8 p-4 bg-yellow-50 rounded-lg">
            <h4 class="text-sm font-medium text-yellow-900 mb-2">📋 Required CSV Format</h4>
                        <p class="text-sm text-yellow-700 mb-3">Your CSV file must include the following columns in this exact order:</p>
                        <div class="text-sm text-yellow-700 font-mono bg-yellow-100 p-3 rounded">
                            student_id,first_name,last_name,date_of_birth,gender,nationality,national_id,address,city,country,phone,emergency_contact_name,emergency_contact_phone,program_id,admission_date,email,password
                        </div>
                        <div class="mt-3 text-sm text-yellow-700">
                            <p><strong>Notes:</strong></p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>date_of_birth format: YYYY-MM-DD</li>
                                <li>gender: male, female, or other</li>
                                <li>program_id must match existing program IDs</li>
                                <li>admission_date format: YYYY-MM-DD</li>
                                <li>Optional columns: state, postal_code, expected_graduation, medical_notes</li>
                            </ul>
                        </div>
                    </div>

                    <form action="{{ route('enrollments.csv.preview') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label for="csv_file" class="block text-sm font-medium text-gray-700">CSV File</label>
                            <input type="file" id="csv_file" name="csv_file" required
                                   accept=".csv,.txt"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('csv_file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('enrollments.manual.index') }}" class="text-gray-600 hover:text-gray-900 font-medium py-2 px-4 rounded-lg border border-gray-300">
                                Back to Enrollment Options
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                                Preview CSV
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">💡 Tips</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Save your Excel file as CSV (Comma delimited)</li>
                            <li>• Remove any special characters from student IDs</li>
                            <li>• Ensure all email addresses are unique</li>
                            <li>• Use strong passwords for student accounts</li>
                            <li>• The preview will show first 5 rows with validation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
