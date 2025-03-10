<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Transaction History</h2>
    <p><strong>Start Date:</strong> {{ $start_date }}</p>
    <p><strong>End Date:</strong> {{ $end_date }}</p>
    <p><strong>Total In:</strong> {{ $total_in }} Taka</p>
    <p><strong>Total Out:</strong> {{ $total_out }} Taka</p>

    <p><strong>Total Amount:</strong> {{ $total_amount }} Taka</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Number</th>
                <th>Agent Number</th>
                <th>Payment Method</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($all_transactions as $index => $transaction)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $transaction->name }}</td>
                <td>{{ $transaction->cus_number }}</td>
                <td>{{ $transaction->number->agent_number }} ({{$transaction->number->type1->name}})</td>
                <td>{{ $transaction->payment_method->type }}</td>
                <td>{{ $transaction->amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
