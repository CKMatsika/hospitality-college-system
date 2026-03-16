@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-sync-alt mr-3"></i>
                    Bank Reconciliation
                </h1>
                <div class="flex space-x-3">
                    <button onclick="showTransactionModal()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-green-700">
                        <i class="fas fa-exchange-alt mr-2"></i>
                        Add Transaction
                    </button>
                    <button onclick="showImportModal()" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-purple-700">
                        <i class="fas fa-file-import mr-2"></i>
                        Import Statement
                    </button>
                    <a href="{{ route('financial.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-chart-line mr-2"></i>
                        Financial Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Match bank statements with internal records and reconcile accounts</p>
        </div>

        <!-- Reconciliation Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-university text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Bank Accounts</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $bankAccounts->count() }}</dd>
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
                                <dt class="text-sm font-medium text-gray-500 truncate">Reconciled</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $bankAccounts->where('last_reconciled_at', '!=', null)->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $bankAccounts->where('last_reconciled_at', null)->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-dollar-sign text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Balance</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($bankAccounts->sum('current_balance'), 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bank Accounts for Reconciliation -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-list mr-2"></i>
                        Bank Accounts Reconciliation
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $bankAccounts->count() }} accounts to reconcile
                    </div>
                </div>

                @if($bankAccounts->count() > 0)
                    <div class="space-y-6">
                        @foreach($bankAccounts as $bankAccount)
                            <div class="border rounded-lg p-6 {{ $bankAccount->last_reconciled_at ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-white' }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-university text-2xl {{ $bankAccount->last_reconciled_at ? 'text-green-600' : 'text-gray-400' }}"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-medium text-gray-900">{{ $bankAccount->bank->bank_name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $bankAccount->account_name }}</p>
                                            <p class="text-sm text-gray-500">Account: {{ $bankAccount->account_number }}</p>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        @if($bankAccount->last_reconciled_at)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Reconciled
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Current Balance</p>
                                        <p class="text-lg font-semibold text-gray-900">${{ number_format($bankAccount->current_balance, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Last Reconciled</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $bankAccount->last_reconciled_at ? $bankAccount->last_reconciled_at->format('M d, Y') : 'Never' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Account Type</p>
                                        <p class="text-sm text-gray-600">{{ ucfirst($bankAccount->account_type) }}</p>
                                    </div>
                                </div>

                                @if($bankAccount->last_reconciled_at)
                                    <div class="mt-4 p-3 bg-green-100 rounded-md">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-check-circle text-green-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-green-800">
                                                    Last reconciled on {{ $bankAccount->last_reconciled_at->format('M d, Y H:i') }}
                                                </p>
                                                @if($bankAccount->reconciliation_notes)
                                                    <p class="text-sm text-green-700 mt-1">{{ $bankAccount->reconciliation_notes }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-6 flex justify-between items-center">
                                    <div class="text-sm text-gray-500">
                                        Created: {{ $bankAccount->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="flex space-x-3">
                                        <button type="button" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                            <i class="fas fa-history mr-1"></i>
                                            View History
                                        </button>
                                        <form method="POST" action="{{ route('financial.reconciliation.reconcile', $bankAccount->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 text-sm font-medium">
                                                <i class="fas fa-sync-alt mr-1"></i>
                                                Reconcile Now
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-university text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No bank accounts found</p>
                        <p class="text-gray-400 text-sm mt-2">Add bank accounts to enable reconciliation</p>
                        <div class="mt-6">
                            <a href="{{ route('financial.bank-accounts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Add Bank Account
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Reconciliation Activity -->
        <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-clock mr-2"></i>
                    Recent Reconciliation Activity
                </h3>
                
                <div class="space-y-3">
                    @php
                        $recentReconciliations = $bankAccounts
                            ->where('last_reconciled_at', '!=', null)
                            ->sortByDesc('last_reconciled_at')
                            ->take(5);
                    @endphp
                    
                    @if($recentReconciliations->count() > 0)
                        @foreach($recentReconciliations as $account)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $account->bank->bank_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $account->account_name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-900">{{ $account->last_reconciled_at->format('M d, Y H:i') }}</p>
                                    <p class="text-xs text-gray-500">${{ number_format($account->current_balance, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-clock text-gray-400 text-3xl mb-2"></i>
                            <p class="text-gray-500 text-sm">No recent reconciliation activity</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Modal -->
    <div id="transactionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-exchange-alt mr-2"></i>
                    Add Bank Transaction
                </h3>
                <form method="POST" action="{{ route('financial.bank-transactions.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bank Account</label>
                        <select name="bank_account_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Select Bank Account</option>
                            @foreach($bankAccounts as $account)
                                <option value="{{ $account->id }}">{{ $account->bank->bank_name }} - {{ $account->account_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Transaction Type</label>
                        <select name="transaction_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="credit">Credit (Deposit)</option>
                            <option value="debit">Debit (Withdrawal)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Amount</label>
                        <input type="number" name="amount" step="0.01" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <input type="text" name="description" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Transaction description">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Transaction Date</label>
                        <input type="date" name="transaction_date" required value="{{ now()->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Reference</label>
                        <input type="text" name="reference_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Reference number">
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="hideTransactionModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i>
                            Save Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Import Statement Modal -->
    <div id="importModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-file-import mr-2"></i>
                    Import Bank Statement
                </h3>
                <form method="POST" action="{{ route('financial.reconciliation.import') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bank Account</label>
                        <select name="bank_account_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Select Bank Account</option>
                            @foreach($bankAccounts as $account)
                                <option value="{{ $account->id }}">{{ $account->bank->bank_name }} - {{ $account->account_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Statement File</label>
                        <input type="file" name="statement_file" accept=".csv,.ofx,.qfx" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">Supported formats: CSV, OFX, QFX</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-md">
                        <p class="text-sm text-blue-800">
                            <strong>CSV Format:</strong> Date,Description,Amount,Type,Reference<br>
                            <strong>OFX/QFX:</strong> Standard bank statement formats
                        </p>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="hideImportModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                            <i class="fas fa-file-import mr-2"></i>
                            Import Statement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showTransactionModal() {
            document.getElementById('transactionModal').classList.remove('hidden');
        }

        function hideTransactionModal() {
            document.getElementById('transactionModal').classList.add('hidden');
        }

        function showImportModal() {
            document.getElementById('importModal').classList.remove('hidden');
        }

        function hideImportModal() {
            document.getElementById('importModal').classList.add('hidden');
        }
    </script>
</div>
@endsection
