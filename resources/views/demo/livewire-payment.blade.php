@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-credit-card mr-3"></i>
                    Livewire Fee Payment Demo
                </h1>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Dashboard
                </a>
            </div>
            <p class="text-gray-600 mt-2">Interactive fee payment form using Livewire</p>
        </div>

        <!-- Livewire Component -->
        @if(isset($student))
            <livewire:fee-payment-form :student="$student" />
        @else
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Select a Student</h3>
                    <p class="text-gray-500">Please select a student from the list below to process their fee payment.</p>
                    
                    <div class="mt-6">
                        <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                            <i class="fas fa-users mr-2"></i>
                            View Students
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
