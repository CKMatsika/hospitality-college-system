@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-university mr-3"></i>
                    Banks Management
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('financial.banks.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Add Bank
                    </a>
                    <button onclick="showTransactionModal()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-green-700">
                        <i class="fas fa-exchange-alt mr-2"></i>
                        Add Transaction
                    </button>
                    <button onclick="showMultipleTransactionsModal()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-indigo-700">
                        <i class="fas fa-list mr-2"></i>
                        Multiple Transactions
                    </button>
                    <button onclick="showImportModal()" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-purple-700">
                        <i class="fas fa-file-import mr-2"></i>
                        Import CSV
                    </button>
                    <a href="{{ route('financial.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-chart-line mr-2"></i>
                        Financial Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Manage banking institutions and financial service providers</p>
        </div>

        <!-- Banks Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-university text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Banks</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $banks->total() }}</dd>
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
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Banks</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $banks->where('is_active', true)->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-bank text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Accounts</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $banks->sum(function($bank) { return $bank->bankAccounts->count(); }) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-globe text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Countries</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $banks->pluck('country')->unique()->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Banks List -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-list mr-2"></i>
                        Registered Banks
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $banks->total() }} total banks
                    </div>
                </div>

                @if($banks->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bank Code
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bank Name
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Account Type
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Branch
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Country
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
                                @foreach($banks as $bank)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $bank->bank_code }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $bank->bank_name }}</div>
                                            @if($bank->website)
                                                <div class="text-xs text-gray-500">
                                                    <a href="{{ $bank->website }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                                        <i class="fas fa-external-link-alt mr-1"></i>
                                                        Website
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ ucfirst($bank->account_type) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $bank->branch_name ?? 'Main Branch' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $bank->country ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($bank->is_active)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('financial.bank-accounts.index') }}?bank_id={{ $bank->id }}" class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-list-alt mr-1"></i>
                                                    Accounts
                                                </a>
                                                <a href="{{ route('financial.banks.edit', $bank->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    <i class="fas fa-edit mr-1"></i>
                                                    Edit
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $banks->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-university text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No banks found</p>
                        <p class="text-gray-400 text-sm mt-2">Add your first bank to get started with financial management</p>
                        <div class="mt-6">
                            <a href="{{ route('financial.banks.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Add First Bank
                            </a>
                        </div>
                    </div>
                @endif
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
                            @foreach($banks as $bank)
                                @foreach($bank->bankAccounts as $account)
                                    <option value="{{ $account->id }}">{{ $bank->bank_name }} - {{ $account->account_name }}</option>
                                @endforeach
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

    <!-- Import CSV Modal -->
    <div id="importModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-file-import mr-2"></i>
                    Import Bank Transactions
                </h3>
                <form method="POST" action="{{ route('financial.bank-transactions.import') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bank Account</label>
                        <select name="bank_account_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Select Bank Account</option>
                            @foreach($banks as $bank)
                                @foreach($bank->bankAccounts as $account)
                                    <option value="{{ $account->id }}">{{ $bank->bank_name }} - {{ $account->account_name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">CSV File</label>
                        <input type="file" name="csv_file" accept=".csv" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">CSV format: Date,Description,Amount,Type,Reference</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-md">
                        <p class="text-sm text-blue-800">
                            <strong>CSV Format Example:</strong><br>
                            2024-01-15,Deposit from customer,1000.00,credit,REF001<br>
                            2024-01-16,Office supplies payment,-250.00,debit,REF002
                        </p>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="hideImportModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                            <i class="fas fa-file-import mr-2"></i>
                            Import Transactions
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Multiple Transactions Modal -->
    <div id="multipleTransactionsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-2/3 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-list mr-2"></i>
                    Add Multiple Transactions
                </h3>
                <form method="POST" action="{{ route('financial.bank-transactions.store-multiple') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bank Account</label>
                        <select name="bank_account_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Select Bank Account</option>
                            @foreach($banks as $bank)
                                @foreach($bank->bankAccounts as $account)
                                    <option value="{{ $account->id }}">{{ $bank->bank_name }} - {{ $account->account_name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="block text-sm font-medium text-gray-700">Transactions</label>
                            <button type="button" onclick="addTransactionRow()" class="px-3 py-1 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                                <i class="fas fa-plus mr-1"></i>
                                Add Row
                            </button>
                        </div>
                        <div id="transactionRows" class="space-y-2">
                            <!-- Initial transaction row -->
                            <div class="transaction-row grid grid-cols-6 gap-2">
                                <input type="date" name="transactions[0][date]" required class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ now()->format('Y-m-d') }}">
                                <select name="transactions[0][type]" required class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="credit">Credit</option>
                                    <option value="debit">Debit</option>
                                </select>
                                <input type="number" name="transactions[0][amount]" step="0.01" required placeholder="Amount" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <input type="text" name="transactions[0][description]" required placeholder="Description" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <input type="text" name="transactions[0][reference]" placeholder="Reference" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <button type="button" onclick="removeTransactionRow(this)" class="px-2 py-1 bg-red-600 text-white text-sm rounded-md hover:bg-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="hideMultipleTransactionsModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <i class="fas fa-save mr-2"></i>
                            Save All Transactions
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let transactionRowCount = 1;

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

        function showMultipleTransactionsModal() {
            document.getElementById('multipleTransactionsModal').classList.remove('hidden');
        }

        function hideMultipleTransactionsModal() {
            document.getElementById('multipleTransactionsModal').classList.add('hidden');
        }

        function addTransactionRow() {
            const container = document.getElementById('transactionRows');
            const newRow = document.createElement('div');
            newRow.className = 'transaction-row grid grid-cols-6 gap-2';
            newRow.innerHTML = `
                <input type="date" name="transactions[${transactionRowCount}][date]" required class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ now()->format('Y-m-d') }}">
                <select name="transactions[${transactionRowCount}][type]" required class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="credit">Credit</option>
                    <option value="debit">Debit</option>
                </select>
                <input type="number" name="transactions[${transactionRowCount}][amount]" step="0.01" required placeholder="Amount" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <input type="text" name="transactions[${transactionRowCount}][description]" required placeholder="Description" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <input type="text" name="transactions[${transactionRowCount}][reference]" placeholder="Reference" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <button type="button" onclick="removeTransactionRow(this)" class="px-2 py-1 bg-red-600 text-white text-sm rounded-md hover:bg-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(newRow);
            transactionRowCount++;
        }

        function removeTransactionRow(button) {
            button.parentElement.remove();
        }
    </script>
</div>
@endsection
