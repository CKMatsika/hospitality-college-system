@extends('layouts.qbo')

@section('title', 'Journal Entry Details')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-eye mr-2"></i>
            Journal Entry Details
        </h1>
        <p class="text-gray-600 mt-2">View and manage journal entry details with line items and account information.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        Journal Entry #{{ $journalEntry->entry_number }}
                    </h1>
                    <div class="flex space-x-3">
                        @if($journalEntry->status !== 'posted')
                            <a href="{{ route('accounting.journal.edit', $journalEntry) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Entry
                            </a>
                        @endif
                        
                        <form action="{{ route('accounting.journal.post', $journalEntry) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to post this entry?')">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-check mr-2"></i>
                                Post Entry
                            </button>
                        </form>
                        
                        @if($journalEntry->status === 'posted')
                            <form action="{{ route('accounting.journal.reverse', $journalEntry) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reverse this entry?')">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    <i class="fas fa-undo mr-2"></i>
                                    Reverse Entry
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('accounting.journal') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to List
                        </a>
                    </div>
                </div>

                <!-- Entry Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Entry Details</h3>
                            <dl class="mt-2 space-y-1">
                                <div class="flex justify-between py-2 px-4 bg-gray-50">
                                    <dt class="text-sm font-medium text-gray-500">Entry Number</dt>
                                    <dd class="text-sm text-gray-900">{{ $journalEntry->entry_number }}</dd>
                                </div>
                                <div class="flex justify-between py-2 px-4 bg-gray-50">
                                    <dt class="text-sm font-medium text-gray-500">Entry Date</dt>
                                    <dd class="text-sm text-gray-900">{{ $journalEntry->entry_date->format('M d, Y') }}</dd>
                                </div>
                                <div class="flex justify-between py-2 px-4 bg-gray-50">
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $journalEntry->status === 'posted' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $journalEntry->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $journalEntry->status === 'reversed' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($journalEntry->status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="flex justify-between py-2 px-4 bg-gray-50">
                                    <dt class="text-sm font-medium text-gray-500">Financial Period</dt>
                                    <dd class="text-sm text-gray-900">{{ $journalEntry->financialPeriod->name ?? 'N/A' }}</dd>
                                </div>
                                <div class="flex justify-between py-2 px-4 bg-gray-50">
                                    <dt class="text-sm font-medium text-gray-500">Reference</dt>
                                    <dd class="text-sm text-gray-900">{{ $journalEntry->reference ?? 'N/A' }}</dd>
                                </div>
                                <div class="flex justify-between py-2 px-4 bg-gray-50">
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="text-sm text-gray-900">{{ $journalEntry->description }}</dd>
                                </div>
                                <div class="flex justify-between py-2 px-4 bg-gray-50">
                                    <dt class="text-sm font-medium text-gray-500">Created By</dt>
                                    <dd class="text-sm text-gray-900">{{ $journalEntry->createdBy->name ?? 'System' }}</dd>
                                </div>
                                <div class="flex justify-between py-2 px-4 bg-gray-50">
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="text-sm text-gray-900">{{ $journalEntry->created_at->format('M d, Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Entry Lines -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Entry Lines</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Account
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Debit
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Credit
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($journalEntry->lines as $line)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div>
                                                <p class="font-medium">{{ $line->account->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $line->account->account_code }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $line->debit > 0 ? 'bg-blue-100 text-blue-800' : '' }}">
                                                Debit
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                                            ${{ number_format($line->debit, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $line->credit > 0 ? 'bg-green-100 text-green-800' : '' }}">
                                                Credit
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                                            ${{ number_format($line->credit, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $line->description }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-sm font-medium text-gray-900">
                                        Totals
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-gray-900">
                                        ${{ number_format($journalEntry->lines->sum('debit'), 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-gray-900">
                                        ${{ number_format($journalEntry->lines->sum('credit'), 2) }}
                                    </td>
                                    <td colspan="2" class="px-6 py-4 text-sm text-gray-500"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    @if($journalEntry->lines->isEmpty())
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                            <p class="text-gray-500 text-lg">No entry lines found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
