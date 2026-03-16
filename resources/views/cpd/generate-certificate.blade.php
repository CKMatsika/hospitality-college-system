@extends('layouts.qbo')

@section('title', 'Generate CPD Certificate')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-certificate mr-2"></i>
            Generate CPD Certificate
        </h1>
        <p class="text-gray-600 mt-2">Create and generate new CPD certificates for your professional achievements.</p>
    </div>
            </h1>
            <p class="text-gray-600 mt-2">Create professional CPD certificates for your achievements</p>
        </div>

        <!-- Current Summary -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-chart-line mr-2"></i>
                    Your CPD Summary
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ number_format($summary['active_points'], 1) }}</div>
                        <div class="text-sm text-gray-500">Active Points</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ ucfirst($summary['level']) }}</div>
                        <div class="text-sm text-gray-500">Current Level</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $summary['total_activities'] }}</div>
                        <div class="text-sm text-gray-500">Total Activities</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $summary['expired_points'] }}</div>
                        <div class="text-sm text-gray-500">Expired Points</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Certificates -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">
                    <i class="fas fa-award mr-2"></i>
                    Available Certificates
                </h3>
                
                @if(empty($availableLevels))
                    <div class="text-center py-12">
                        <i class="fas fa-lock text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No certificates available yet</p>
                        <p class="text-gray-400 text-sm mt-2">Complete more CPD activities to unlock certificate levels</p>
                        <div class="mt-4">
                            <a href="{{ route('cpd.external-training') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Add CPD Activities
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($availableLevels as $levelData)
                            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-xl font-bold text-gray-900">
                                        {{ ucfirst($levelData['level']) }} Level
                                    </h4>
                                    <div class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        Available
                                    </div>
                                </div>
                                
                                <div class="space-y-3 mb-6">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Your Points:</span>
                                        <span class="font-medium">{{ $levelData['requirements']['current_points'] }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Required Points:</span>
                                        <span class="font-medium">{{ $levelData['requirements']['required_points'] }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Points Needed:</span>
                                        <span class="font-medium {{ $levelData['requirements']['points_needed'] > 0 ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $levelData['requirements']['points_needed'] }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Category Requirements -->
                                @if(isset($levelData['requirements']['category_requirements']))
                                    <div class="mb-6">
                                        <h5 class="text-sm font-medium text-gray-700 mb-2">Category Requirements:</h5>
                                        <div class="space-y-2">
                                            @foreach($levelData['requirements']['category_requirements'] as $category => $req)
                                                <div class="flex justify-between text-xs">
                                                    <span class="text-gray-600">{{ $category }}:</span>
                                                    <span class="{{ $req['met'] ? 'text-green-600' : 'text-red-600' }}">
                                                        {{ $req['earned'] }}/{{ $req['required'] }}
                                                        {{ $req['met'] ? '✓' : '✗' }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <form action="{{ route('cpd.certificate.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="level" value="{{ $levelData['level'] }}">
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <i class="fas fa-certificate mr-2"></i>
                                        Generate {{ ucfirst($levelData['level']) }} Certificate
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Certificate Information -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-blue-900 mb-4">
                <i class="fas fa-info-circle mr-2"></i>
                Certificate Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-blue-800 mb-2">Validity Period</h4>
                    <ul class="space-y-1 text-sm text-blue-700">
                        <li>• Basic Level: 12 months</li>
                        <li>• Intermediate Level: 18 months</li>
                        <li>• Advanced Level: 24 months</li>
                        <li>• Expert Level: 36 months</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-blue-800 mb-2">Certificate Features</h4>
                    <ul class="space-y-1 text-sm text-blue-700">
                        <li>• Professional PDF certificate</li>
                        <li>• Unique verification code</li>
                        <li>• Online verification system</li>
                        <li>• Industry recognition</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
