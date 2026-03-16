@extends('layouts.qbo')

@section('title', 'Student Statements')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-file-invoice-dollar mr-2"></i>
            Student Statements
        </h1>
        <p class="text-gray-600 mt-2">Generate and manage student financial statements and payment histories.</p>
    </div>
                    Student Statements
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('accounting.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-chart-line mr-2"></i>
                        Accounting Dashboard
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Generate and manage student financial statements</p>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Students</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $students->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-dollar-sign text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Billed</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    ${{ number_format($students->sum(function($student) {
                                        return $student->fees->sum('amount');
                                    }), 2) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-hand-holding-usd text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Paid</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    ${{ number_format($students->sum(function($student) {
                                        return $student->fees->sum('paid');
                                    }), 2) }}
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
                                <dt class="text-sm font-medium text-gray-500 truncate">Outstanding</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    ${{ number_format($students->sum(function($student) {
                                        return $student->fees->sum('balance');
                                    }), 2) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student List -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-users mr-2"></i>
                        Student Financial Statements
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $students->total() }} total students
                    </div>
                </div>

                @if($students->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Billed
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Paid
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Balance
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
                                @foreach($students as $student)
                                    @php
                                        $totalBilled = $student->fees->sum('amount');
                                        $totalPaid = $student->fees->sum('paid');
                                        $balance = $student->fees->sum('balance');
                                        $hasBalance = $balance > 0;
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <span class="text-blue-600 font-medium">
                                                            {{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $student->first_name }} {{ $student->last_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{ $student->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $student->student_id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">${{ number_format($totalBilled, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-green-600">${{ number_format($totalPaid, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium {{ $hasBalance ? 'text-red-600' : 'text-green-600' }}">
                                                ${{ number_format($balance, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($hasBalance)
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Outstanding
                                                </span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Paid
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('accounting.student-statements.show', $student) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                                View Statement
                                            </a>
                                            <a href="{{ route('accounting.student-statements.pdf', $student) }}" class="text-green-600 hover:text-green-900">
                                                Download PDF
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $students->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-file-invoice text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No students found</p>
                        <p class="text-gray-400 text-sm mt-2">No student records available for statements</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-tasks mr-2"></i>
                    Bulk Actions
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-3">
                            <i class="fas fa-envelope text-blue-600 text-3xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Email Statements</h4>
                        <p class="text-xs text-gray-500 mb-3">Send statements to all students with outstanding balances</p>
                        <button class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-blue-700">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send All
                        </button>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center mb-3">
                            <i class="fas fa-file-pdf text-red-600 text-3xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Download All PDFs</h4>
                        <p class="text-xs text-gray-500 mb-3">Generate PDF statements for all students</p>
                        <button class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-red-700">
                            <i class="fas fa-download mr-2"></i>
                            Download
                        </button>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center mb-3">
                            <i class="fas fa-print text-green-600 text-3xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Print Statements</h4>
                        <p class="text-xs text-gray-500 mb-3">Print statements for mailing or distribution</p>
                        <button class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-black text-sm hover:bg-green-700">
                            <i class="fas fa-print mr-2"></i>
                            Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
