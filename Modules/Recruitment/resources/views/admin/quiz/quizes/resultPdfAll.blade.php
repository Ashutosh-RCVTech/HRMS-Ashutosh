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

        th, td {
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
    <h2>Quiz Results - {{ $quiz->name }}</h2>
    <p><strong>Placement:</strong> {{ $placement->name }}</p>
    <p><strong>College:</strong> {{ $placementCollege->college->name }}</p>
    <p><strong>Passing Percentage:</strong> {{ $passingPercentage }}%</p>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Obtained Score</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($candidatesWithAttempts as $index => $data)
            @php
                $candidate = $data['candidate'];
                $score = $data['score'];
                $status = $data['status'];
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $candidate->candidateInfo->name ?? 'N/A' }}</td>
                <td>{{ $candidate->candidateInfo->email ?? 'N/A' }}</td>
                <td>
                    @if ($score !== null)
                        {{ $score }}%
                    @else
                       -
                    @endif
                </td>
                <td>{{ $status }}</td>
            </tr>
        @endforeach
        
        </tbody>
    </table>
</body>

</html>
