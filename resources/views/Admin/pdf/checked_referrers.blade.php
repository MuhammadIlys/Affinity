<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Referrers Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>

    <h2>Referrers Reportt</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Job Title</th>
                <th>Total Points</th>
            </tr>
        </thead>
        <tbody>
            @if (@$users)
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->Gender ?? 'N/A' }}</td>
                        <td>{{ $user->job_title }}</td>
                        <td>{{ $user->total_points ?? 0 }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <p style="margin-top: 20px;">Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>

</body>

</html>
