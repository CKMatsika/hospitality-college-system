<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - {{ $payment->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .receipt {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .receipt-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .receipt-info div {
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .receipt-info strong {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .payment-details {
            margin-bottom: 20px;
        }
        .payment-details table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .payment-details th,
        .payment-details td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .payment-details th {
            background: #f0f0f0;
            font-weight: bold;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
        }
        .print-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .print-btn:hover {
            background: #0056b3;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .print-btn {
                display: none;
            }
            .receipt {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>{{ $systemSettings?->institution_name ?? 'Hospitality College Management System' }}</h1>
            @if(!empty($systemSettings?->institution_tagline))
                <p>{{ $systemSettings?->institution_tagline }}</p>
            @endif
            @if(!empty($systemSettings?->address))
                <p>{{ $systemSettings?->address }}</p>
            @endif
            @if(!empty($systemSettings?->phone) || !empty($systemSettings?->email) || !empty($systemSettings?->website))
                <p>
                    @if(!empty($systemSettings?->phone)){{ $systemSettings?->phone }}@endif
                    @if(!empty($systemSettings?->phone) && !empty($systemSettings?->email)) | @endif
                    @if(!empty($systemSettings?->email)){{ $systemSettings?->email }}@endif
                    @if((!empty($systemSettings?->phone) || !empty($systemSettings?->email)) && !empty($systemSettings?->website)) | @endif
                    @if(!empty($systemSettings?->website)){{ $systemSettings?->website }}@endif
                </p>
            @endif
            <p>Payment Receipt</p>
            <p>Receipt #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>

        <div class="receipt-info">
            <div>
                <strong>Payment Date:</strong>
                {{ $payment->payment_date->format('M d, Y') }}
            </div>
            <div>
                <strong>Payment Method:</strong>
                {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
            </div>
            <div>
                <strong>Transaction ID:</strong>
                {{ $payment->transaction_id ?: 'N/A' }}
            </div>
            <div>
                <strong>Payment Type:</strong>
                {{ $payment->payment_type == 'advance' ? 'Advance Payment' : 'Invoice Payment' }}
            </div>
        </div>

        <div class="payment-details">
            @if($payment->payment_type != 'advance' && $payment->studentFee)
                <h3>Student Information</h3>
                <table>
                    <tr>
                        <th>Student Name:</th>
                        <td>{{ $payment->studentFee->student->full_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Student ID:</th>
                        <td>{{ $payment->studentFee->student->student_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Fee Structure:</th>
                        <td>{{ $payment->studentFee->feeStructure->name ?? 'N/A' }}</td>
                    </tr>
                </table>
            @endif

            <h3>Payment Details</h3>
            <table>
                <tr>
                    <th>Description</th>
                    <td>{{ $payment->payment_type == 'advance' ? 'Advance Payment' : ($payment->studentFee->feeStructure->name ?? 'Tuition Fee') }}</td>
                </tr>
                <tr>
                    <th>Amount Paid:</th>
                    <td>${{ number_format($payment->amount, 2) }}</td>
                </tr>
                @if($payment->notes)
                    <tr>
                        <th>Notes:</th>
                        <td>{{ $payment->notes }}</td>
                    </tr>
                @endif
            </table>

            <div class="total">
                Total Amount: ${{ number_format($payment->amount, 2) }}
            </div>
        </div>

        @if($payment->notes)
            <div style="margin-bottom: 20px;">
                <strong>Additional Notes:</strong>
                <p>{{ $payment->notes }}</p>
            </div>
        @endif

        <div class="footer">
            <p>Thank you for your payment!</p>
            <p>This receipt is automatically generated and serves as proof of payment.</p>
            <p>Generated on: {{ now()->format('M d, Y H:i:s') }}</p>
        </div>
    </div>

    <button class="print-btn" onclick="window.print()">
        <i class="fas fa-print"></i> Print Receipt
    </button>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('finance.payments.index') }}" style="color: #007bff; text-decoration: none;">
            ← Back to Payments
        </a>
    </div>
</body>
</html>
