@extends('layouts.qbo')

@section('title', 'Certificates')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-certificate mr-2"></i>
            Certificates
        </h1>
        <p class="text-gray-600 mt-2">View and manage earned certificates and achievements.</p>
                        </a>
                    </div>
                </div>

                <!-- Certificates Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($certificates as $certificate)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $certificate->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $certificate->description }}
                                        </p>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $certificate->isActive() ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $certificate->isExpired() ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $certificate->isRevoked() ? 'bg-gray-100 text-gray-800' : '' }}">
                                            {{ ucfirst($certificate->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Score:</span>
                                        <span class="font-medium">{{ $certificate->getFormattedScore() }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Percentage:</span>
                                        <span class="font-medium">{{ $certificate->getFormattedPercentage() }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Issue Date:</span>
                                        <span class="font-medium">{{ $certificate->issue_date->format('M d, Y') }}</span>
                                    </div>
                                    @if($certificate->expiry_date)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">Expires:</span>
                                            <span class="font-medium {{ $certificate->isExpired() ? 'text-red-600' : 'text-gray-900' }}">
                                                {{ $certificate->expiry_date->format('M d, Y') }}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Verification:</span>
                                        <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">
                                            {{ $certificate->verification_code }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('certificates.show', $certificate) }}" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                            <i class="fas fa-eye mr-2"></i>
                                            View
                                        </a>
                                        
                                        @if($certificate->certificate_url)
                                            <a href="{{ route('certificates.download', $certificate) }}" class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-green-700">
                                                <i class="fas fa-download mr-2"></i>
                                                Download
                                            </a>
                                        @endif
                                        
                                        <button onclick="navigator.clipboard.writeText('{{ route('certificates.verify', $certificate->verification_code) }}')" class="inline-flex items-center px-3 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                                            <i class="fas fa-copy mr-2"></i>
                                            Copy Link
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($certificates->isEmpty())
                    <div class="text-center py-12">
                        <i class="fas fa-award text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No certificates found</p>
                        <p class="text-gray-400 text-sm mt-2">Complete exams and assignments to earn certificates</p>
                        <div class="mt-4">
                            <a href="{{ route('online-learning.exams.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Browse Exams
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
