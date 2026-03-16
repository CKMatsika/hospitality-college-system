<div>
    <!-- Payment Success Message -->
    @if(session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Student Information -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            <i class="fas fa-user mr-2"></i>
            Student: {{ $student->first_name }} {{ $student->last_name }}
        </h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-500">Student ID:</span>
                <span class="ml-2 font-medium">{{ $student->student_id }}</span>
            </div>
            <div>
                <span class="text-gray-500">Total Balance:</span>
                <span class="ml-2 font-medium text-red-600">
                    ${{ number_format($student->fees->sum('balance'), 2) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Fee Selection -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            <i class="fas fa-list mr-2"></i>
            Select Fees to Pay
        </h3>
        
        @if($student->fees->count() > 0)
            <div class="space-y-3">
                @foreach($student->fees as $fee)
                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" 
                               wire:model.live="selectedFees" 
                               value="{{ $fee->id }}"
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <div class="ml-3 flex-1">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $fee->feeStructure->name ?? 'Fee Payment' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                Due: {{ $fee->due_date ? $fee->due_date->format('M d, Y') : 'N/A' }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium text-red-600">
                                ${{ number_format($fee->balance, 2) }}
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No outstanding fees found.</p>
        @endif
    </div>

    <!-- Payment Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            <i class="fas fa-credit-card mr-2"></i>
            Payment Details
        </h3>
        
        <form wire:submit="processPayment">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                    <input type="text" 
                           wire:model="amount" 
                           readonly
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                    <select wire:model="paymentMethod" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="check">Check</option>
                        <option value="mobile_money">Mobile Money</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Payment Date</label>
                    <input type="date" 
                           wire:model="paymentDate" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('paymentDate')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Reference Number</label>
                    <input type="text" 
                           wire:model="referenceNumber" 
                           placeholder="Optional reference number"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>
            
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea wire:model="notes" 
                          rows="3"
                          placeholder="Optional payment notes"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" 
                        wire:click="$refresh"
                        class="px-4 py-2 bg-gray-300 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-400">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
                    <i class="fas fa-check mr-2"></i>
                    Process Payment
                </button>
            </div>
        </form>
    </div>
</div>