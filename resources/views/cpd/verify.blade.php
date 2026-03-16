@extends('layouts.qbo')

@section('title', 'CPD Certificate Verification')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-check-circle mr-2"></i>
            CPD Certificate Verification
        </h1>
        <p class="text-gray-600 mt-2">Verify the authenticity of CPD certificates using the verification code.</p>
    </div>
            </h1>
            <p class="text-gray-600 mt-2">Verify the authenticity of CPD certificates</p>
        </div>

        <!-- Verification Form -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('cpd.verify') }}" method="GET" class="space-y-4">
                    <div>
                        <label for="verification_code" class="block text-sm font-medium text-gray-700">
                            Enter Verification Code
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" id="verification_code" name="verification_code" 
                                value="{{ $verificationCode ?? '' }}"
                                class="block w-full rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="e.g., CPD_ABC123XYZ">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-r-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-search mr-2"></i>
                                Verify
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Verification Results -->
        @if($certificate)
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
                <div class="flex items-center mb-4">
                    <i class="fas fa-check-circle text-green-600 text-3xl mr-4"></i>
                    <div>
                        <h2 class="text-2xl font-bold text-green-900">Certificate Verified</h2>
                        <p class="text-green-700">This CPD certificate is authentic and valid</p>
                    </div>
                </div>
                
                <!-- Certificate Details -->
                <div class="bg-white rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Certificate Holder</h3>
                                <p class="text-lg font-medium text-gray-900">{{ $certificate->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $certificate->user->email }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Certificate Details</h3>
                                <p class="text-lg font-medium text-gray-900">{{ $certificate->title }}</p>
                                <p class="text-sm text-gray-600">{{ $certificate->description }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">CPD Level</h3>
                                <p class="text-lg font-medium text-gray-900">{{ ucfirst($certificate->cpd_level) }}</p>
                                <p class="text-sm text-gray-600">{{ $certificate->cpd_points }} active points</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Issue Information</h3>
                                <p class="text-sm text-gray-900">
                                    <strong>Issue Date:</strong> {{ $certificate->issue_date->format('F d, Y') }}
                                </p>
                                <p class="text-sm text-gray-900">
                                    <strong>Expiry Date:</strong> {{ $certificate->expiry_date->format('F d, Y') }}
                                </p>
                                <p class="text-sm text-gray-900">
                                    <strong>Status:</strong> 
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $certificate->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($certificate->status) }}
                                    </span>
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Verification</h3>
                                <p class="text-sm text-gray-900">
                                    <strong>Verification Code:</strong> 
                                    <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $certificate->verification_code }}</span>
                                </p>
                                <p class="text-sm text-gray-600">This code uniquely identifies this certificate</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Issued By</h3>
                                <p class="text-sm text-gray-900">Hospitality College System</p>
                                <p class="text-sm text-gray-600">Professional Development Division</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        @elseif($verificationCode)
            <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-8">
                <div class="flex items-center mb-4">
                    <i class="fas fa-times-circle text-red-600 text-3xl mr-4"></i>
                    <div>
                        <h2 class="text-2xl font-bold text-red-900">Certificate Not Found</h2>
                        <p class="text-red-700">The certificate with this verification code was not found</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Possible Reasons:</h3>
                    <ul class="space-y-1 text-sm text-gray-600">
                        <li>• Incorrect verification code entered</li>
                        <li>• Certificate has been revoked</li>
                        <li>• Certificate does not exist in our system</li>
                        <li>• Typographical error in the verification code</li>
                    </ul>
                    
                    <div class="mt-4">
                        <p class="text-sm text-gray-700 mb-2">Please check the verification code and try again, or contact the issuing institution for assistance.</p>
                        <button onclick="history.back()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Try Again
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Instructions -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                <i class="fas fa-question-circle mr-2"></i>
                How to Verify a Certificate
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                        <span class="text-blue-600 font-bold">1</span>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Locate Code</h4>
                    <p class="text-sm text-gray-600">Find the verification code on the CPD certificate</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                        <span class="text-blue-600 font-bold">2</span>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Enter Code</h4>
                    <p class="text-sm text-gray-600">Type the verification code in the search field above</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                        <span class="text-blue-600 font-bold">3</span>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Verify</h4>
                    <p class="text-sm text-gray-600">Click verify to confirm certificate authenticity</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
