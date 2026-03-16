@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-file-invoice mr-3"></i>
                    Student Statement - {{ $student->first_name }} {{ $student->last_name }}
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('accounting.student-statements.pdf', $student) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-red-700">
                        <i class="fas fa-download mr-2"></i>
                        Download PDF
                    </a>
                    <a href="{{ route('accounting.student-statements.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Statements
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Complete financial statement for {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }})</p>
        </div>

        <!-- Student Information -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-user mr-2"></i>
                    Student Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Student Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->first_name }} {{ $student->last_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Student ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->student_id }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Program</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->program->name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                $student->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' 
                            }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statement Summary -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-dollar-sign text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Billed</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    ${{ number_format($student->fees->sum('amount'), 2) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-hand-holding-usd text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Paid</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    ${{ number_format($student->fees->sum('paid'), 2) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                            <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Balance Due</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    ${{ number_format($student->fees->sum('balance'), 2) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-calendar text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Statement Date</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ now()->format('M d, Y') }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fee Details -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-list mr-2"></i>
                        Fee Details
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $student->fees->count() }} fee records
                    </div>
                </div>

                @if($student->fees->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fee Type
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Paid
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Balance
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Due Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($student->fees as $fee)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $fee->feeStructure->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $fee->feeStructure->description ?? 'Fee payment' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                ${{ number_format($fee->amount, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-green-600">
                                                ${{ number_format($fee->paid, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium {{ $fee->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                                ${{ number_format($fee->balance, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $fee->due_date ? $fee->due_date->format('M d, Y') : 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($fee->balance <= 0)
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Paid
                                                </span>
                                            @elseif($fee->due_date && now()->greaterThan($fee->due_date))
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Overdue
                                                </span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="2" class="px-6 py-3 text-sm font-medium text-gray-900">Totals</td>
                                    <td class="px-6 py-3 text-sm font-medium text-gray-900">${{ number_format($student->fees->sum('amount'), 2) }}</td>
                                    <td class="px-6 py-3 text-sm font-medium text-green-600">${{ number_format($student->fees->sum('paid'), 2) }}</td>
                                    <td class="px-6 py-3 text-sm font-medium text-red-600">${{ number_format($student->fees->sum('balance'), 2) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-file-invoice text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No fee records found</p>
                        <p class="text-gray-400 text-sm mt-2">This student has no fee records in the system</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment History -->
        @if($student->fees->flatMap->feePayments->count() > 0)
            <div class="bg-white overflow-hidden shadow rounded-lg mt-8">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-history mr-2"></i>
                            Payment History
                        </h3>
                        <div class="text-sm text-gray-500">
                            {{ $student->fees->flatMap->feePayments->count() }} payments
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Method
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reference
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($student->fees->flatMap->feePayments->sortByDesc('payment_date') as $payment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $payment->payment_date->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ ucfirst($payment->payment_method) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-green-600">
                                                ${{ number_format($payment->amount, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $payment->reference_number ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Completed
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('accounting.student-statements.pdf', $student) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-red-700">
                <i class="fas fa-download mr-2"></i>
                Download PDF
            </a>
            <a href="{{ route('accounting.student-statements.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Statements
            </a>
        </div>
    </div>
</div>
@endsection
