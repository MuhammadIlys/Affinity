<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Data</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            font-size: 12px; /* Reduce font size for better readability */
        }

        /* Page layout */
        .container {
            width: 100%; /* Ensure container takes full width */
            margin: 0 auto;
            padding: 10px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto; /* Allow horizontal scrolling if needed */
        }

        /* Header styling */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 22px;
            color: #333;
            font-weight: bold;
        }

        .header p {
            font-size: 14px;
            color: #777;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px 12px; /* Slightly increased padding */
            text-align: left;
            word-wrap: break-word;
            max-width: 200px; /* Limit column width */
        }

        table th {
            background-color: #343a40; /* Dark background for header */
            color: white;
            font-weight: bold;
            text-align: center;
        }

        table td {
            background-color: #f9f9f9;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #e2e2e2; /* Slight hover effect */
        }

        /* Footer Styling */
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }

        .footer p {
            margin: 0;
        }

        /* Styling for the table headers and cells */
        table th {
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Users Data</h1>
            <p>Below is a list of all users and their respective details.</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Gender</th>
                    <th>Job Title</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>{{ $user->job_title }}</td>
                        <td>{{ $user->total_amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>

</body>
</html>
