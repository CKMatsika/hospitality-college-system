<?php

use App\Models\Certificate;

?>

@extends('layouts.qbo')

@section('title', 'CPD Certificates')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-certificate mr-2"></i>
            CPD Certificates
        </h1>
        <p class="text-gray-600 mt-2">View and manage your earned CPD certificates and achievements.</p>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-certificate mr-3"></i>
                CPD Certificates
            </h1>
            <p class="text-gray-600 mt-2">View and manage your Continuing Professional Development certificates</p>
        </div>

        <!-- Certificate Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-award text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Certificates</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ Certificate::where('user_id', auth()->id())->where('type', 'cpd_certificate')->where('status', 'active')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-history text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Earned</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ Certificate::where('user_id', auth()->id())->where('type', 'cpd_certificate')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Expiring Soon</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ Certificate::where('user_id', auth()->id())->where('type', 'cpd_certificate')->where('expiry_date', '>', now())->where('expiry_date', '<=', now()->addDays(30))->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-bolt mr-2"></i>
                    Quick Actions
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('cpd.generate-certificate') }}" class="inline-flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i>
                        Generate New Certificate
                    </a>
                    <a href="{{ route('cpd.verify') }}" class="inline-flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                        <i class="fas fa-search mr-2"></i>
                        Verify Certificate
                    </a>
                    <a href="{{ route('cpd.history') }}" class="inline-flex items-center justify-center px-4 py-3 bg-purple-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-purple-700">
                        <i class="fas fa-list mr-2"></i>
                        View CPD History
                    </a>
                </div>
            </div>
        </div>

        <!-- Certificates List -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-list-alt mr-2"></i>
                        Your CPD Certificates
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $certificates->total() }} total certificates
                    </div>
                </div>

                @if($certificates->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Certificate
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Level
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Issue Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Expiry Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($certificates as $certificate)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $certificate->title }}</div>
                                            <div class="text-xs text-gray-500">Code: {{ $certificate->verification_code }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $certificate->level === 'basic' ? 'bg-green-100 text-green-800' : 
                                                   ($certificate->level === 'intermediate' ? 'bg-blue-100 text-blue-800' : 
                                                   ($certificate->level === 'advanced' ? 'bg-purple-100 text-purple-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                                {{ ucfirst($certificate->level ?? 'basic') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $certificate->issue_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($certificate->expiry_date)
                                                {{ $certificate->expiry_date->format('M d, Y') }}
                                            @else
                                                <span class="text-gray-400">No expiry</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($certificate->expiry_date && $certificate->expiry_date->isPast())
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Expired
                                                </span>
                                            @elseif($certificate->expiry_date && $certificate->expiry_date->diffInDays(now()) <= 30)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Expiring Soon
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('certificates.download', $certificate->id) }}" class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-download mr-1"></i>
                                                    Download
                                                </a>
                                                <a href="{{ route('certificates.show', $certificate->id) }}" class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    View
                                                </a>
                                                <button onclick="shareCertificate('{{ $certificate->verification_code }}')" class="text-purple-600 hover:text-purple-900">
                                                    <i class="fas fa-share mr-1"></i>
                                                    Share
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $certificates->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-certificate text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No CPD certificates yet</p>
                        <p class="text-gray-400 text-sm mt-2">Complete CPD activities to earn certificates</p>
                        <div class="mt-6">
                            <a href="{{ route('cpd.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to CPD Dashboard
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Certificate Templates Preview -->
        <div class="bg-white overflow-hidden shadow rounded-lg mt-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-images mr-2"></i>
                    Available Certificate Templates
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="aspect-w-16 aspect-h-9 bg-gradient-to-r from-green-400 to-green-600 rounded-lg mb-4 flex items-center justify-center">
                            <i class="fas fa-certificate text-white text-4xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Basic CPD Certificate</h4>
                        <p class="text-xs text-gray-600 mb-3">Entry-level professional development recognition</p>
                        <div class="text-xs text-gray-500">
                            <i class="fas fa-trophy mr-1"></i>
                            10 CPD points required
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="aspect-w-16 aspect-h-9 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg mb-4 flex items-center justify-center">
                            <i class="fas fa-award text-white text-4xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Intermediate CPD Certificate</h4>
                        <p class="text-xs text-gray-600 mb-3">Mid-level professional achievement</p>
                        <div class="text-xs text-gray-500">
                            <i class="fas fa-trophy mr-1"></i>
                            25 CPD points required
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="aspect-w-16 aspect-h-9 bg-gradient-to-r from-purple-400 to-purple-600 rounded-lg mb-4 flex items-center justify-center">
                            <i class="fas fa-star text-white text-4xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Advanced CPD Certificate</h4>
                        <p class="text-xs text-gray-600 mb-3">Senior professional excellence</p>
                        <div class="text-xs text-gray-500">
                            <i class="fas fa-trophy mr-1"></i>
                            50 CPD points required
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function shareCertificate(verificationCode) {
    if (navigator.share) {
        navigator.share({
            title: 'My CPD Certificate',
            text: 'Check out my CPD certificate!',
            url: '{{ route('cpd.verify') }}?code=' + verificationCode
        });
    } else {
        // Fallback - copy to clipboard
        const url = '{{ route('cpd.verify') }}?code=' + verificationCode;
        navigator.clipboard.writeText(url).then(function() {
            alert('Certificate link copied to clipboard!');
        });
    }
}
</script>
@endsection
