@extends('layouts.qbo')

@section('title', 'Run Payroll')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-play mr-2"></i>
            Run Payroll
        </h1>
        <p class="text-gray-600 mt-2">Process payroll for selected staff members.</p>
    </div>

    <!-- Payroll Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <form action="{{ route('payroll.process') }}" method="POST">
            @csrf
            
            <!-- Pay Period Settings -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Pay Period Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="pay_date" class="block text-sm font-medium text-gray-700 mb-2">Pay Date *</label>
                        <input type="date" id="pay_date" name="pay_date" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('pay_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="pay_period_start" class="block text-sm font-medium text-gray-700 mb-2">Period Start *</label>
                        <input type="date" id="pay_period_start" name="pay_period_start" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('pay_period_start')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="pay_period_end" class="block text-sm font-medium text-gray-700 mb-2">Period End *</label>
                        <input type="date" id="pay_period_end" name="pay_period_end" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('pay_period_end')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Staff Selection -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Select Staff Members</h3>
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" id="selectAll" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">Select All Active Staff</span>
                    </label>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    <input type="checkbox" id="selectAllTable" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Base Salary</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Allowances</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deductions</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Net Pay</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($activeStaff as $staff)
                                <tr>
                                    <td class="px-4 py-3">
                                        <input type="checkbox" name="selected_staff[]" value="{{ $staff->id }}" 
                                               class="staff-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-user text-blue-500 text-xs"></i>
                                            </div>
                                            {{ $staff->first_name }} {{ $staff->last_name }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $staff->position ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">${{ number_format($staff->salary ?? 0, 2) }}</td>
                                    <td class="px-4 py-3">
                                        <input type="number" name="allowances[{{ $staff->id }}]" value="0" step="0.01" min="0"
                                               class="w-24 px-2 py-1 border border-gray-300 rounded text-sm">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" name="deductions[{{ $staff->id }}]" value="0" step="0.01" min="0"
                                               class="w-24 px-2 py-1 border border-gray-300 rounded text-sm">
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900 net-pay-display">
                                        ${{ number_format($staff->salary ?? 0, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                        <i class="fas fa-users text-4xl mb-4"></i>
                                        <p>No active staff found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Summary -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Payroll Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <span class="text-sm text-gray-500">Selected Staff:</span>
                        <span class="ml-2 text-lg font-bold text-gray-900" id="selectedCount">0</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Total Gross Pay:</span>
                        <span class="ml-2 text-lg font-bold text-green-600" id="totalGross">$0.00</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Total Net Pay:</span>
                        <span class="ml-2 text-lg font-bold text-blue-600" id="totalNet">$0.00</span>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between">
                <a href="{{ route('payroll.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Payroll
                </a>
                <div class="space-x-3">
                    <a href="{{ route('payroll.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium">
                        <i class="fas fa-check mr-2"></i> Process Payroll
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const selectAllTableCheckbox = document.getElementById('selectAllTable');
    const staffCheckboxes = document.querySelectorAll('.staff-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    const totalGross = document.getElementById('totalGross');
    const totalNet = document.getElementById('totalNet');

    function updateSummary() {
        const selected = document.querySelectorAll('.staff-checkbox:checked');
        let count = 0;
        let gross = 0;
        let net = 0;

        selected.forEach(checkbox => {
            const row = checkbox.closest('tr');
            const baseSalary = parseFloat(row.querySelector('td:nth-child(4)').textContent.replace(/[$,]/g, '')) || 0;
            const allowances = parseFloat(row.querySelector('input[name*="allowances"]').value) || 0;
            const deductions = parseFloat(row.querySelector('input[name*="deductions"]').value) || 0;
            
            count++;
            gross += baseSalary + allowances;
            net += baseSalary + allowances - deductions;
        });

        selectedCount.textContent = count;
        totalGross.textContent = '$' + gross.toFixed(2);
        totalNet.textContent = '$' + net.toFixed(2);
    }

    function updateNetPay(row) {
        const baseSalary = parseFloat(row.querySelector('td:nth-child(4)').textContent.replace(/[$,]/g, '')) || 0;
        const allowances = parseFloat(row.querySelector('input[name*="allowances"]').value) || 0;
        const deductions = parseFloat(row.querySelector('input[name*="deductions"]').value) || 0;
        const netPay = baseSalary + allowances - deductions;
        
        row.querySelector('.net-pay-display').textContent = '$' + netPay.toFixed(2);
    }

    selectAllCheckbox.addEventListener('change', function() {
        staffCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        selectAllTableCheckbox.checked = this.checked;
        updateSummary();
    });

    selectAllTableCheckbox.addEventListener('change', function() {
        staffCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        selectAllCheckbox.checked = this.checked;
        updateSummary();
    });

    staffCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSummary();
            const allChecked = Array.from(staffCheckboxes).every(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
            selectAllTableCheckbox.checked = allChecked;
        });
    });

    // Update net pay when allowances or deductions change
    document.querySelectorAll('input[name*="allowances"], input[name*="deductions"]').forEach(input => {
        input.addEventListener('input', function() {
            const row = this.closest('tr');
            updateNetPay(row);
            updateSummary();
        });
    });
});
</script>
@endpush
