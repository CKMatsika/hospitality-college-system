@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-yellow-100">
                <i class="fas fa-search text-yellow-600 text-xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Page Not Found</h2>
            <p class="mt-2 text-sm text-gray-600">
                The page you're looking for doesn't exist or has been moved.
            </p>
        </div>
        
        <div class="mt-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">What happened?</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-2"></i>
                        <span>The URL may be typed incorrectly</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-2"></i>
                        <span>The page may have been removed or renamed</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-2"></i>
                        <span>You may not have permission to view this page</span>
                    </li>
                </ul>
            </div>
            
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Try these instead:</h3>
                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors">
                        <i class="fas fa-home mr-2"></i> Go to Dashboard
                    </a>
                    <a href="{{ route('students.index') }}" class="block w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg text-center transition-colors">
                        <i class="fas fa-users mr-2"></i> View Students
                    </a>
                    <a href="{{ url()->previous() }}" class="block w-full border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg text-center transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Go Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
