<!DOCTYPE html>
<html>
<head>
    <title>Payouts report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Payouts Report</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Referrer</th>
                <th>Approved By</th>
                <th>Date</th>
                {{-- Add more columns as needed --}}
            </tr>
        </thead>
        <tbody>
            @foreach($payouts as $payout)
                <tr>
                    <td>{{ $payout->id }}</td>
                    <td>{{ $payout->total_amount }}</td>
                    <td>{{ $payout->referrer_name }}</td>
                    <td>{{ $payout->approved_by }}</td>
                    <td>{{ $payout->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
