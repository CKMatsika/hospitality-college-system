@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Access Denied</h2>
            <p class="mt-2 text-sm text-gray-600">
                You don't have permission to access this resource.
            </p>
        </div>
        
        <div class="mt-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">What can you do?</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>Contact your administrator if you believe this is an error</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>Make sure you have the proper role and permissions</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>Try logging out and logging back in</span>
                    </li>
                </ul>
            </div>
            
            <div class="mt-6 flex space-x-4">
                <a href="{{ route('dashboard') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors">
                    Go to Dashboard
                </a>
                <a href="{{ url()->previous() }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg text-center transition-colors">
                    Go Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
