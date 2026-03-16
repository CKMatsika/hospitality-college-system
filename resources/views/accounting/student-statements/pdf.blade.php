<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Statement - {{ $student->first_name }} {{ $student->last_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .student-info {
            margin-bottom: 30px;
        }
        .student-info h2 {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }
        .info-item {
            margin-bottom: 5px;
        }
        .info-item strong {
            color: #333;
        }
        .summary {
            margin-bottom: 30px;
        }
        .summary h2 {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 15px;
        }
        .summary-item {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .summary-item .amount {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .summary-item .label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            color: #333;
        }
        .text-right {
            text-align: right;
        }
        .status-paid {
            color: #28a745;
            font-weight: bold;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-overdue {
            color: #dc3545;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Student Financial Statement</h1>
        <p>Hospitality College Management System</p>
        <p>Generated on: {{ now()->format('F j, Y, g:i A') }}</p>
    </div>

    <div class="student-info">
        <h2>Student Information</h2>
        <div class="info-grid">
            <div class="info-item"><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</div>
            <div class="info-item"><strong>Student ID:</strong> {{ $student->student_id }}</div>
            <div class="info-item"><strong>Program:</strong> {{ $student->program->name ?? 'N/A' }}</div>
            <div class="info-item"><strong>Status:</strong> {{ ucfirst($student->status) }}</div>
            <div class="info-item"><strong>Email:</strong> {{ $student->email ?? 'N/A' }}</div>
            <div class="info-item"><strong>Phone:</strong> {{ $student->phone ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="summary">
        <h2>Financial Summary</h2>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="amount">${{ number_format($student->fees->sum('amount'), 2) }}</div>
                <div class="label">Total Billed</div>
            </div>
            <div class="summary-item">
                <div class="amount">${{ number_format($student->fees->sum('paid'), 2) }}</div>
                <div class="label">Total Paid</div>
            </div>
            <div class="summary-item">
                <div class="amount">${{ number_format($student->fees->sum('balance'), 2) }}</div>
                <div class="label">Balance Due</div>
            </div>
            <div class="summary-item">
                <div class="amount">{{ now()->format('M d, Y') }}</div>
                <div class="label">Statement Date</div>
            </div>
        </div>
    </div>

    <h2>Fee Details</h2>
    <table>
        <thead>
            <tr>
                <th>Fee Type</th>
                <th>Description</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Paid</th>
                <th class="text-right">Balance</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($student->fees as $fee)
                <tr>
                    <td>{{ $fee->feeStructure->name ?? 'N/A' }}</td>
                    <td>{{ $fee->feeStructure->description ?? 'Fee payment' }}</td>
                    <td class="text-right">${{ number_format($fee->amount, 2) }}</td>
                    <td class="text-right">${{ number_format($fee->paid, 2) }}</td>
                    <td class="text-right">${{ number_format($fee->balance, 2) }}</td>
                    <td>{{ $fee->due_date ? $fee->due_date->format('M d, Y') : 'N/A' }}</td>
                    <td>
                        @if($fee->balance <= 0)
                            <span class="status-paid">Paid</span>
                        @elseif($fee->due_date && now()->greaterThan($fee->due_date))
                            <span class="status-overdue">Overdue</span>
                        @else
                            <span class="status-pending">Pending</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Totals</th>
                <th class="text-right">${{ number_format($student->fees->sum('amount'), 2) }}</th>
                <th class="text-right">${{ number_format($student->fees->sum('paid'), 2) }}</th>
                <th class="text-right">${{ number_format($student->fees->sum('balance'), 2) }}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>

    @if($student->fees->flatMap->feePayments->count() > 0)
        <h2>Payment History</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Method</th>
                    <th class="text-right">Amount</th>
                    <th>Reference</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($student->fees->flatMap->feePayments->sortByDesc('payment_date') as $payment)
                    <tr>
                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                        <td>{{ ucfirst($payment->payment_method) }}</td>
                        <td class="text-right">${{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->reference_number ?? 'N/A' }}</td>
                        <td><span class="status-paid">Completed</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>This is an official financial statement from the Hospitality College Management System.</p>
        <p>For questions or concerns, please contact the finance department.</p>
    </div>
</body>
</html>
