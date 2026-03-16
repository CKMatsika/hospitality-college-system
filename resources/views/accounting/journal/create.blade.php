@extends('layouts.qbo')

@section('title', 'Create Journal Entry')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-plus mr-2"></i>
            Create Journal Entry
        </h1>
        <p class="text-gray-600 mt-2">Create a double-entry journal entry with automatic balance validation.</p>
    </div>

    <!-- Balance Indicator -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-balance-scale text-blue-600 mr-2"></i>
                <span class="text-sm font-medium text-blue-900">Entry Balance:</span>
                <span id="balance-difference" class="ml-2 text-lg font-bold text-blue-900">$0.00</span>
            </div>
            <div id="balance-status" class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                <i class="fas fa-check mr-1"></i> Balanced
            </div>
        </div>
    </div>

    <!-- Journal Entry Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('accounting.journal.store') }}" id="journal-form">
            @csrf
            
            <!-- Entry Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="entry_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Entry Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="entry_date" name="entry_date" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           value="{{ now()->format('Y-m-d') }}">
                </div>
                
                <div>
                    <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Reference Number
                    </label>
                    <input type="text" id="reference_number" name="reference_number"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="e.g., INV-2024-001">
                </div>
                
                <div>
                    <label for="entry_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Entry Type <span class="text-red-500">*</span>
                    </label>
                    <select id="entry_type" name="entry_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="manual">Manual Entry</option>
                        <option value="adjustment">Adjustment</option>
                        <option value="reversal">Reversal</option>
                        <option value="closing">Closing Entry</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea id="description" name="description" rows="3" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                          placeholder="Enter a detailed description of this journal entry"></textarea>
            </div>

            <!-- Journal Entry Lines -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Journal Entry Lines</h3>
                    <button type="button" onclick="addJournalLine()" 
                            class="px-4 py-2 bg-green-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-plus mr-2"></i> Add Line
                    </button>
                </div>

                <!-- Table Headers -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-300" id="journal-lines">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Account
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Debit
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Credit
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody id="journal-lines-body">
                            <!-- Line 1 -->
                            <tr class="journal-line">
                                <td class="px-4 py-3">
                                    <select name="lines[0][account_id]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                        <option value="">Select Account</option>
                                        <option value="1000">1000 - Cash</option>
                                        <option value="1100">1100 - Accounts Receivable</option>
                                        <option value="1200">1200 - Inventory</option>
                                        <option value="2000">2000 - Accounts Payable</option>
                                        <option value="5000">5000 - Cost of Goods Sold</option>
                                        <option value="6000">6000 - Operating Expenses</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="lines[0][description]" 
                                           class="w-full px-2 py-1 border border-gray-300 rounded text-sm"
                                           placeholder="Line description">
                                </td>
                                <td class="px-4 py-3">
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">$</span>
                                        </span>
                                        <input type="number" name="lines[0][debit]" step="0.01" 
                                               class="w-full pl-6 pr-2 py-1 border border-gray-300 rounded text-sm debit-field"
                                               placeholder="0.00" onchange="calculateBalance()">
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">$</span>
                                        </span>
                                        <input type="number" name="lines[0][credit]" step="0.01" 
                                               class="w-full pl-6 pr-2 py-1 border border-gray-300 rounded text-sm credit-field"
                                               placeholder="0.00" onchange="calculateBalance()">
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <button type="button" onclick="removeJournalLine(this)" 
                                            class="text-red-600 hover:text-red-900 text-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="2" class="px-4 py-3 text-right font-semibold text-gray-900">
                                    Totals:
                                </td>
                                <td class="px-4 py-3">
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">$</span>
                                        </span>
                                        <input type="text" id="total-debit" readonly 
                                               class="w-full pl-6 pr-2 py-1 bg-gray-100 border-gray-300 rounded text-sm font-bold"
                                               value="0.00">
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">$</span>
                                        </span>
                                        <input type="text" id="total-credit" readonly 
                                               class="w-full pl-6 pr-2 py-1 bg-gray-100 border-gray-300 rounded text-sm font-bold"
                                               value="0.00">
                                    </div>
                                </td>
                                <td class="px-4 py-3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Additional Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="posting_period" class="block text-sm font-medium text-gray-700 mb-2">
                        Posting Period
                    </label>
                    <select id="posting_period" name="posting_period"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Current Period</option>
                        <option value="2024-Q4">Q4 2024 (Oct-Dec)</option>
                        <option value="2025-Q1">Q1 2025 (Jan-Mar)</option>
                    </select>
                </div>
                
                <div>
                    <label for="auto_post" class="block text-sm font-medium text-gray-700 mb-2">
                        Auto Post
                    </label>
                    <div class="flex items-center">
                        <input id="auto_post" name="auto_post" type="checkbox" value="1"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="auto_post" class="ml-2 text-sm text-gray-700">
                            Automatically post when balanced
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <div class="flex space-x-4">
                    <a href="{{ route('accounting.journal') }}" 
                       class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </a>
                    <button type="button" onclick="saveAsDraft()" 
                            class="px-4 py-2 bg-yellow-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        <i class="fas fa-save mr-2"></i>
                        Save as Draft
                    </button>
                </div>
                <button type="submit" id="submit-entry" 
                        class="px-6 py-2 bg-blue-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-check mr-2"></i>
                    Post Entry
                </button>
            </div>
        </form>
    </div>

    <script>
        let lineCount = 1;

        function addJournalLine() {
            const tbody = document.getElementById('journal-lines-body');
            const newLine = document.createElement('tr');
            newLine.className = 'journal-line';
            newLine.innerHTML = `
                <td class="px-4 py-3">
                    <select name="lines[${lineCount}][account_id]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                        <option value="">Select Account</option>
                        <option value="1000">1000 - Cash</option>
                        <option value="1100">1100 - Accounts Receivable</option>
                        <option value="1200">1200 - Inventory</option>
                        <option value="2000">2000 - Accounts Payable</option>
                        <option value="5000">5000 - Cost of Goods Sold</option>
                        <option value="6000">6000 - Operating Expenses</option>
                    </select>
                </td>
                <td class="px-4 py-3">
                    <input type="text" name="lines[${lineCount}][description]" 
                           class="w-full px-2 py-1 border border-gray-300 rounded text-sm"
                           placeholder="Line description" onchange="calculateBalance()">
                </td>
                <td class="px-4 py-3">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                            <span class="text-gray-500 text-sm">$</span>
                        </span>
                        <input type="number" name="lines[${lineCount}][debit]" step="0.01" 
                               class="w-full pl-6 pr-2 py-1 border border-gray-300 rounded text-sm debit-field"
                               placeholder="0.00" onchange="calculateBalance()">
                    </div>
                </td>
                <td class="px-4 py-3">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                            <span class="text-gray-500 text-sm">$</span>
                        </span>
                        <input type="number" name="lines[${lineCount}][credit]" step="0.01" 
                               class="w-full pl-6 pr-2 py-1 border border-gray-300 rounded text-sm credit-field"
                               placeholder="0.00" onchange="calculateBalance()">
                    </div>
                </td>
                <td class="px-4 py-3">
                    <button type="button" onclick="removeJournalLine(this)" 
                            class="text-red-600 hover:text-red-900 text-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(newLine);
            lineCount++;
        }

        function removeJournalLine(button) {
            const row = button.closest('tr');
            const tbody = document.getElementById('journal-lines-body');
            if (tbody.children.length > 1) {
                row.remove();
                calculateBalance();
            }
        }

        function calculateBalance() {
            let totalDebit = 0;
            let totalCredit = 0;
            
            const debitFields = document.querySelectorAll('.debit-field');
            const creditFields = document.querySelectorAll('.credit-field');
            
            debitFields.forEach(field => {
                totalDebit += parseFloat(field.value) || 0;
            });
            
            creditFields.forEach(field => {
                totalCredit += parseFloat(field.value) || 0;
            });
            
            document.getElementById('total-debit').value = totalDebit.toFixed(2);
            document.getElementById('total-credit').value = totalCredit.toFixed(2);
            
            const difference = totalDebit - totalCredit;
            const balanceElement = document.getElementById('balance-difference');
            const statusElement = document.getElementById('balance-status');
            
            balanceElement.textContent = '$' + Math.abs(difference).toFixed(2);
            
            if (difference === 0) {
                balanceElement.className = 'ml-2 text-lg font-bold text-green-600';
                statusElement.className = 'px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium';
                statusElement.innerHTML = '<i class="fas fa-check mr-1"></i> Balanced';
            } else {
                balanceElement.className = 'ml-2 text-lg font-bold text-red-600';
                statusElement.className = 'px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium';
                statusElement.innerHTML = '<i class="fas fa-times mr-1"></i> Out of Balance';
            }
        }

        // Initialize balance calculation
        document.addEventListener('DOMContentLoaded', function() {
            calculateBalance();
        });
    </script>
@endsection
