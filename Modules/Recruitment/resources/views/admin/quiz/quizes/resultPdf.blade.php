<!DOCTYPE html>
<html>

<head>
    <title>Quiz Results</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>{{ $statusText }} Candidates</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Score</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($examAttempts as $index => $attempt)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $attempt->candidate->candidateInfo->name ?? 'N/A' }}</td>
                    <td>{{ $attempt->candidate->candidateInfo->email ?? 'N/A' }}</td>
                    <td>{{ $attempt->score }}%</td>
                    <td>{{ $statusText }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
