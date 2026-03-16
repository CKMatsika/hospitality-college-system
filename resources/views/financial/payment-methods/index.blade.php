@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-credit-card mr-3"></i>
                    Payment Methods
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('financial.payment-methods.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Add Payment Method
                    </a>
                    <a href="{{ route('financial.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-green-700">
                        <i class="fas fa-chart-line mr-2"></i>
                        Financial Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Configure payment platforms and methods for transactions</p>
        </div>

        <!-- Payment Methods Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-credit-card text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Methods</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $paymentMethods->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Methods</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $paymentMethods->where('is_active', true)->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-mobile-alt text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Mobile Money</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $paymentMethods->where('type', 'mobile_money')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-university text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Bank Cards</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $paymentMethods->where('type', 'bank_card')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods List -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-list mr-2"></i>
                        Available Payment Methods
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $paymentMethods->count() }} payment methods configured
                    </div>
                </div>

                @if($paymentMethods->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($paymentMethods as $paymentMethod)
                            <div class="border rounded-lg p-4 {{ $paymentMethod->is_active ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @if($paymentMethod->type == 'mobile_money')
                                                <i class="fas fa-mobile-alt text-2xl {{ $paymentMethod->is_active ? 'text-green-600' : 'text-gray-400' }}"></i>
                                            @elseif($paymentMethod->type == 'bank_card')
                                                <i class="fas fa-credit-card text-2xl {{ $paymentMethod->is_active ? 'text-green-600' : 'text-gray-400' }}"></i>
                                            @elseif($paymentMethod->type == 'bank_transfer')
                                                <i class="fas fa-university text-2xl {{ $paymentMethod->is_active ? 'text-green-600' : 'text-gray-400' }}"></i>
                                            @elseif($paymentMethod->type == 'online_payment')
                                                <i class="fas fa-globe text-2xl {{ $paymentMethod->is_active ? 'text-green-600' : 'text-gray-400' }}"></i>
                                            @else
                                                <i class="fas fa-money-bill text-2xl {{ $paymentMethod->is_active ? 'text-green-600' : 'text-gray-400' }}"></i>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-lg font-medium text-gray-900">{{ $paymentMethod->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $paymentMethod->type)) }}</p>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        @if($paymentMethod->is_active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Inactive
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="text-sm text-gray-600">
                                        <p><strong>Provider:</strong> {{ $paymentMethod->provider ?? 'N/A' }}</p>
                                        <p><strong>Account:</strong> {{ $paymentMethod->account_number ?? 'N/A' }}</p>
                                        @if($paymentMethod->transaction_fee)
                                            <p><strong>Transaction Fee:</strong> {{ $paymentMethod->transaction_fee }}%</p>
                                        @endif
                                        @if($paymentMethod->min_amount)
                                            <p><strong>Min Amount:</strong> ${{ number_format($paymentMethod->min_amount, 2) }}</p>
                                        @endif
                                        @if($paymentMethod->max_amount)
                                            <p><strong>Max Amount:</strong> ${{ number_format($paymentMethod->max_amount, 2) }}</p>
                                        @endif
                                    </div>
                                </div>

                                @if($paymentMethod->description)
                                    <div class="mt-3">
                                        <p class="text-sm text-gray-500">{{ $paymentMethod->description }}</p>
                                    </div>
                                @endif

                                <div class="mt-4 flex justify-between items-center">
                                    <div class="text-xs text-gray-500">
                                        Sort Order: {{ $paymentMethod->sort_order }}
                                    </div>
                                    <div class="flex space-x-2">
                                        <button type="button" class="text-blue-600 hover:text-blue-900 text-sm">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </button>
                                        @if($paymentMethod->is_active)
                                            <button type="button" class="text-red-600 hover:text-red-900 text-sm">
                                                <i class="fas fa-ban mr-1"></i>
                                                Disable
                                            </button>
                                        @else
                                            <button type="button" class="text-green-600 hover:text-green-900 text-sm">
                                                <i class="fas fa-check mr-1"></i>
                                                Enable
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-credit-card text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No payment methods found</p>
                        <p class="text-gray-400 text-sm mt-2">Add payment methods to enable transactions</p>
                        <div class="mt-6">
                            <a href="{{ route('financial.payment-methods.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Add First Payment Method
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
