<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $payment->transaction_id ?? $payment->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            box-sizing: border-box;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #1d4ed8;
            font-weight: bold;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
            font-size: 18px;
        }
        .status-badge {
            background: #dcfce7;
            color: #166534;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #777;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                MEDICAL STUDIO
                            </td>
                            
                            <td>
                                <strong>Invoice #:</strong> {{ $payment->transaction_id ?? $payment->id }}<br>
                                <strong>Date:</strong> {{ $payment->created_at->format('M d, Y') }}<br>
                                <strong>Status:</strong> <span class="status-badge">PAID</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>From:</strong><br>
                                Medical Studio Inc.<br>
                                123 Education Hub, Sector 5<br>
                                New Delhi, India 110001<br>
                                GSTIN: 07AABCU9603R1ZJ
                            </td>
                            
                            <td>
                                <strong>Billed To:</strong><br>
                                {{ $user->name }}<br>
                                {{ $user->email }}<br>
                                {{ $user->phone ?? 'N/A' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>Item Description</td>
                <td>Amount</td>
            </tr>
            
            <tr class="item">
                <td>
                    <strong>{{ $package->name }}</strong><br>
                    <small>Premium access to Seat Matrix, Allotment Data, and Choice Filling Tools.</small>
                </td>
                <td>₹{{ number_format($payment->amount, 2) }}</td>
            </tr>
            
            <tr class="total">
                <td></td>
                <td>Total: ₹{{ number_format($payment->amount, 2) }}</td>
            </tr>
        </table>
        
        <div class="footer">
            Thank you for your purchase!<br>
            If you have any questions about this invoice, please contact support@medicalstudio.in
        </div>
    </div>
</body>
</html>
