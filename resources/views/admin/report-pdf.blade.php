<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Report Summary</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <h1>Report Summary</h1>

    <h2>Total Statistics</h2>
    <ul>
        <li><strong>Total Users:</strong> {{ $totalUsers }}</li>
        <li><strong>Total Token Regenerations:</strong> {{ $totalTokenRegenerations }}</li>
        <li><strong>Total Complaints:</strong> {{ $totalComplaints }}</li>
    </ul>

    <h2>Recent Users</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role}}</td>
                <td>{{ $user->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Recent Token Regenerations</h2>
    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Status</th>
                <th>Requested At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tokenRegenerations as $request)
            <tr>
                <td>{{ $request->voter->email }}</td>
                <td>{{ $request->status }}</td>
                <td>{{ $request->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Recent Complaints</h2>
    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Description</th>
                <th>Status</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $complaint)
            <tr>
                <td>{{ $complaint->email }}</td>
                <td>{{ \Illuminate\Support\Str::limit($complaint->description, 200) }}</td>
                <td>{{$complaint->status}}</td>
                <td>{{ $complaint->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="text-align: center;">Genrerated At {{now()}}</p>
</body>

</html>