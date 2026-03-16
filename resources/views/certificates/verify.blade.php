@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-check-circle text-green-600 mr-3"></i>
                        Certificate Verification
                    </h1>
                    <p class="text-gray-600">Verify the authenticity of a certificate</p>
                </div>

                @if($certificate)
                    <!-- Certificate Found -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                        <div class="text-center">
                            <i class="fas fa-check-circle text-green-600 text-5xl mb-4"></i>
                            <h2 class="text-2xl font-bold text-green-900 mb-2">
                                Certificate Verified
                            </h2>
                            <p class="text-green-700">
                                This certificate is authentic and valid.
                            </p>
                        </div>
                    </div>

                    <!-- Certificate Details -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Certificate Information</h3>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Certificate Number:</span>
                                            <span class="font-medium">{{ $certificate->certificate_number }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Verification Code:</span>
                                            <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">{{ $certificate->verification_code }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Status:</span>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $certificate->isActive() ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $certificate->isExpired() ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $certificate->isRevoked() ? 'bg-gray-100 text-gray-800' : '' }}">
                                                {{ ucfirst($certificate->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Performance</h3>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Score:</span>
                                            <span class="font-medium">{{ $certificate->getFormattedScore() }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Percentage:</span>
                                            <span class="font-medium">{{ $certificate->getFormattedPercentage() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Recipient</h3>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-gray-500">Student Name:</span>
                                                <span class="font-medium">{{ $certificate->student->name }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-500">Email:</span>
                                                <span class="font-medium">{{ $certificate->student->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Dates</h3>
                                            <div class="space-y-2">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-500">Issue Date:</span>
                                                    <span class="font-medium">{{ $certificate->issue_date->format('M d, Y') }}</span>
                                                </div>
                                                @if($certificate->expiry_date)
                                                    <div class="flex justify-between">
                                                        <span class="text-gray-500">Expiry Date:</span>
                                                        <span class="font-medium {{ $certificate->isExpired() ? 'text-red-600' : 'text-gray-900' }}">
                                                            {{ $certificate->expiry_date->format('M d, Y') }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="text-center text-sm text-gray-500">
                                <p class="mb-2">This certificate was issued by:</p>
                                <p class="font-medium">{{ $certificate->issuedBy->name ?? 'Hospitality College System' }}</p>
                                <p class="text-xs text-gray-400 mt-2">
                                    Verification URL: {{ $certificate->getVerificationUrl() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Certificate Not Found -->
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                        <div class="text-center">
                            <i class="fas fa-times-circle text-red-600 text-5xl mb-4"></i>
                            <h2 class="text-2xl font-bold text-red-900 mb-2">
                                Certificate Not Found
                            </h2>
                            <p class="text-red-700">
                                The certificate with verification code "{{ request()->route('verification_code') }}" was not found in our system.
                            </p>
                            <p class="text-red-600 text-sm mt-2">
                                Please check the verification code and try again, or contact the issuing institution.
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Verification Form -->
                <div class="mt-8 text-center">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Verify Another Certificate</h3>
                        <form action="{{ route('certificates.verify') }}" method="GET" class="space-y-4">
                            <div>
                                <label for="verification_code" class="block text-sm font-medium text-gray-700">Enter Verification Code</label>
                                <input type="text" id="verification_code" name="verification_code" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg font-mono text-center"
                                    placeholder="XXXX-XXXX-XX" required>
                            </div>
                            <div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-search mr-2"></i>
                                    Verify Certificate
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
