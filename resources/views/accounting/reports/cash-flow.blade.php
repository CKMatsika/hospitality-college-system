@extends('layouts.qbo')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-exchange-alt mr-2"></i>
                        Cash Flow Statement
                    </h1>
                    <a href="{{ route('accounting.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Dashboard
                    </a>
                </div>

                @if($currentPeriod)
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <h3 class="text-lg font-medium text-blue-900">
                            Financial Period: {{ $currentPeriod->name }}
                        </h3>
                        <p class="text-sm text-blue-700">
                            {{ $currentPeriod->start_date->format('M d, Y') }} - {{ $currentPeriod->end_date->format('M d, Y') }}
                        </p>
                    </div>
                @endif

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-yellow-600 text-xl mr-3"></i>
                        <div>
                            <h3 class="text-lg font-medium text-yellow-900">Cash Flow Statement</h3>
                            <p class="text-sm text-yellow-700">
                                This report shows the movement of cash in your organization. The cash flow is derived from changes in cash and bank accounts during the period.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Cash Flow Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-green-50 p-6 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-arrow-down text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Cash Inflows</h3>
                                <p class="text-2xl font-bold text-green-600">
                                    ${{ number_format($cashFlow['cash_inflows'] ?? 0, 2) }}
                                </p>
                                <p class="text-sm text-gray-600">From operations & financing</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-red-50 p-6 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 bg-red-100 rounded-full">
                                <i class="fas fa-arrow-up text-red-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Cash Outflows</h3>
                                <p class="text-2xl font-bold text-red-600">
                                    ${{ number_format($cashFlow['cash_outflows'] ?? 0, 2) }}
                                </p>
                                <p class="text-sm text-gray-600">Expenses & investments</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 p-6 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-wallet text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Net Cash Flow</h3>
                                <p class="text-2xl font-bold {{ ($cashFlow['net_cash_flow'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    ${{ number_format($cashFlow['net_cash_flow'] ?? 0, 2) }}
                                </p>
                                <p class="text-sm text-gray-600">Period change</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cash Flow Details -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Cash Flow Analysis</h3>
                    
                    <div class="space-y-6">
                        <!-- Operating Activities -->
                        <div>
                            <h4 class="text-md font-medium text-gray-700 mb-3">
                                <i class="fas fa-cogs text-gray-600 mr-2"></i>
                                Operating Activities
                            </h4>
                            <div class="bg-white p-4 rounded border border-gray-200">
                                <p class="text-sm text-gray-600">
                                    Cash generated from main business activities including student fee payments and operating expenses.
                                </p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">Net Operating Cash Flow</span>
                                    <span class="text-sm font-bold text-blue-600">
                                        ${{ number_format($cashFlow['operating_cash_flow'] ?? 0, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Investing Activities -->
                        <div>
                            <h4 class="text-md font-medium text-gray-700 mb-3">
                                <i class="fas fa-chart-line text-gray-600 mr-2"></i>
                                Investing Activities
                            </h4>
                            <div class="bg-white p-4 rounded border border-gray-200">
                                <p class="text-sm text-gray-600">
                                    Cash used for or generated from long-term assets and investments.
                                </p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">Net Investing Cash Flow</span>
                                    <span class="text-sm font-bold text-purple-600">
                                        ${{ number_format($cashFlow['investing_cash_flow'] ?? 0, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Financing Activities -->
                        <div>
                            <h4 class="text-md font-medium text-gray-700 mb-3">
                                <i class="fas fa-dollar-sign text-gray-600 mr-2"></i>
                                Financing Activities
                            </h4>
                            <div class="bg-white p-4 rounded border border-gray-200">
                                <p class="text-sm text-gray-600">
                                    Cash from loans, owner contributions, and dividend payments.
                                </p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">Net Financing Cash Flow</span>
                                    <span class="text-sm font-bold text-green-600">
                                        ${{ number_format($cashFlow['financing_cash_flow'] ?? 0, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="mt-6 pt-6 border-t-2 border-gray-300">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-900">Net Change in Cash</span>
                            <span class="text-lg font-bold {{ ($cashFlow['net_cash_flow'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                ${{ number_format($cashFlow['net_cash_flow'] ?? 0, 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Note -->
                <div class="mt-6 text-sm text-gray-500">
                    <p><strong>Note:</strong> This is a simplified cash flow statement. For detailed cash flow analysis, ensure all cash transactions are properly categorized and recorded through the appropriate cash and bank accounts.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
