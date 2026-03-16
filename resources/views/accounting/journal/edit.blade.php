@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Journal Entry #{{ $journalEntry->entry_number }}
                    </h1>
                    <div class="flex space-x-3">
                        <a href="{{ route('accounting.journal.show', $journalEntry) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Entry
                        </a>
                        <a href="{{ route('accounting.journal') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-list mr-2"></i>
                            All Entries
                        </a>
                    </div>
                </div>

                @if($journalEntry->status === 'posted')
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mr-3"></i>
                            <div>
                                <h3 class="text-lg font-medium text-yellow-900">Entry Already Posted</h3>
                                <p class="text-sm text-yellow-700">
                                    This journal entry has already been posted and cannot be edited. You can create a reversal entry if needed.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($journalEntry->status !== 'posted')
                    <form action="{{ route('accounting.journal.update', $journalEntry) }}" method="POST">
                        @csrf
                        
                        <!-- Entry Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="entry_date" class="block text-sm font-medium text-gray-700">Entry Date</label>
                                    <input type="date" id="entry_date" name="entry_date" value="{{ $journalEntry->entry_date->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                </div>
                                
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ $journalEntry->description }}</textarea>
                                </div>
                                
                                <div>
                                    <label for="reference" class="block text-sm font-medium text-gray-700">Reference</label>
                                    <input type="text" id="reference" name="reference" value="{{ $journalEntry->reference }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="financial_period_id" class="block text-sm font-medium text-gray-700">Financial Period</label>
                                    <select id="financial_period_id" name="financial_period_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        @foreach($periods as $period)
                                            <option value="{{ $period->id }}" {{ $journalEntry->financial_period_id == $period->id ? 'selected' : '' }}>
                                                {{ $period->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Entry Lines -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Entry Lines</h3>
                            
                            <div class="space-y-4" id="lines-container">
                                @foreach($journalEntry->lines as $index => $line)
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 p-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Account</label>
                                            <select name="lines[{{ $index }}][account_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                                @foreach($accounts as $account)
                                                    <option value="{{ $account->id }}" {{ $line->account_id == $account->id ? 'selected' : '' }}>
                                                        {{ $account->account_code }} - {{ $account->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Type</label>
                                            <select name="lines[{{ $index }}][entry_type]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                                <option value="debit" {{ $line->debit > 0 ? 'selected' : '' }}>Debit</option>
                                                <option value="credit" {{ $line->credit > 0 ? 'selected' : '' }}>Credit</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Amount</label>
                                            <input type="number" name="lines[{{ $index }}][amount]" value="{{ $line->debit > 0 ? $line->debit : $line->credit }}" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Description</label>
                                            <input type="text" name="lines[{{ $index }}][description]" value="{{ $line->description }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        
                                        <div class="flex items-end">
                                            <button type="button" onclick="removeLine({{ $index }})" class="text-red-600 hover:text-red-800 text-sm">
                                                <i class="fas fa-trash mr-1"></i>
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <button type="button" onclick="addLine()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-plus mr-2"></i>
                                Add Line
                            </button>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('accounting.journal.show', $journalEntry) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-save mr-2"></i>
                                Update Entry
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function addLine() {
    const container = document.getElementById('lines-container');
    const index = container.children.length;
    
    const newLine = document.createElement('div');
    newLine.className = 'grid grid-cols-1 md:grid-cols-5 gap-4 p-4 bg-gray-50 rounded-lg';
    newLine.innerHTML = `
        <div>
            <label class="block text-sm font-medium text-gray-700">Account</label>
            <select name="lines[${index}][account_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->account_code }} - {{ $account->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Type</label>
            <select name="lines[${index}][entry_type]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                <option value="debit">Debit</option>
                <option value="credit">Credit</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Amount</label>
            <input type="number" name="lines[${index}][amount]" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <input type="text" name="lines[${index}][description]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        
        <div class="flex items-end">
            <button type="button" onclick="removeLine(${index})" class="text-red-600 hover:text-red-800 text-sm">
                <i class="fas fa-trash mr-1"></i>
                Remove
            </button>
        </div>
    `;
    
    container.appendChild(newLine);
}

function removeLine(index) {
    const container = document.getElementById('lines-container');
    if (container.children[index]) {
        container.removeChild(container.children[index]);
        // Re-index remaining lines
        Array.from(container.children).forEach((child, i) => {
            if (i > index) {
                // Update all name attributes
                const inputs = child.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name && name.includes(`[${i}]`)) {
                        const newName = name.replace(`[${i}]`, `[${i-1}]`);
                        input.setAttribute('name', newName);
                    }
                });
            }
        });
    }
}
</script>
@endsection
