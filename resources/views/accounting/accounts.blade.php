@extends('layouts.qbo')

@section('title', 'Chart of Accounts')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-list-alt mr-2"></i>
            Chart of Accounts
        </h1>
        <p class="text-gray-600 mt-2">Manage your chart of accounts with hierarchical structure and account balances.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        Chart of Accounts
                    </h1>
                    <div class="flex space-x-3">
                        <a href="{{ route('accounting.accounts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-plus mr-2"></i>
                            New Account
                        </a>
                        <a href="{{ route('accounting.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Dashboard
                        </a>
                    </div>
                </div>

                <!-- Account Type Summary -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-blue-900">Assets</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ $accounts->where('type', 'asset')->count() }}</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-yellow-900">Liabilities</h3>
                        <p class="text-2xl font-bold text-yellow-600">{{ $accounts->where('type', 'liability')->count() }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-green-900">Equity</h3>
                        <p class="text-2xl font-bold text-green-600">{{ $accounts->where('type', 'equity')->count() }}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-purple-900">Revenue</h3>
                        <p class="text-2xl font-bold text-purple-600">{{ $accounts->where('type', 'revenue')->count() }}</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-red-900">Expenses</h3>
                        <p class="text-2xl font-bold text-red-600">{{ $accounts->where('type', 'expense')->count() }}</p>
                    </div>
                </div>

                <!-- Accounts Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Code
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Account Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
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
                            @foreach($accounts as $account)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $account->account_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            @if($account->parent_id)
                                                <i class="fas fa-angle-right text-gray-400 mr-2"></i>
                                            @endif
                                            {{ $account->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $account->type === 'asset' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $account->type === 'liability' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $account->type === 'equity' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $account->type === 'revenue' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $account->type === 'expense' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($account->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $account->description ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $account->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $account->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($accounts->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No accounts found</p>
                        <p class="text-gray-400 text-sm mt-2">Get started by creating your first account</p>
                        <div class="mt-4">
                            <a href="{{ route('accounting.accounts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Create Account
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
