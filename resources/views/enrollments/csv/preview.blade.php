@extends('layouts.qbo')

@section('title', 'CSV Preview')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-file-csv mr-2"></i>
            CSV Preview
        </h1>
        <p class="text-gray-600 mt-2">Preview and validate CSV data before import.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Preview First 5 Rows</h3>
                    
                    <div class="mb-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Row</th>
                                    @foreach($headers as $header)
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ $header }}</th>
                                    @endforeach
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Errors</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($preview as $item)
                                    <tr class="{{ !empty($item['errors']) ? 'bg-red-50' : '' }}">
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $item['row'] }}</td>
                                        @foreach($headers as $header)
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $item['data'][$header] ?? '' }}</td>
                                        @endforeach
                                        <td class="px-4 py-2 text-sm">
                                            @if(!empty($item['errors']))
                                                <div class="text-red-600">
                                                    @foreach($item['errors'] as $error)
                                                        <div>• {{ $error }}</div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-green-600">✓ Valid</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if(collect($preview)->contains(function($item) { return !empty($item['errors']); }))
                        <div class="mb-6 p-4 bg-red-50 rounded-lg">
                            <h4 class="text-sm font-medium text-red-900 mb-2">⚠️ Validation Errors Found</h4>
                            <p class="text-sm text-red-700">
                                Some rows have validation errors. Please fix these errors in your CSV file before importing, or proceed with caution (only valid rows will be imported).
                            </p>
                        </div>
                    @else
                        <div class="mb-6 p-4 bg-green-50 rounded-lg">
                            <h4 class="text-sm font-medium text-green-900 mb-2">✅ All Preview Rows Valid</h4>
                            <p class="text-sm text-green-700">
                                The first 5 rows passed validation. You can proceed with the import.
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('enrollments.csv.import') }}" method="POST">
                        @csrf
                        <div class="flex justify-between">
                            <a href="{{ route('enrollments.csv.upload') }}" class="text-gray-600 hover:text-gray-900 font-medium py-2 px-4 rounded-lg border border-gray-300">
                                Back to Upload
                            </a>
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-6 rounded-lg transition-colors"
                                    onclick="return confirm('This will import all valid rows from your CSV file. Continue?')">
                                Import CSV Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
