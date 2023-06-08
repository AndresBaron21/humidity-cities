<!DOCTYPE html>
<html>
<head>
    <title>Historical Log - Humidity Cities</title>
    <!-- Include CSS assets -->
    <!-- Example: -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>Historical Log</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>City</th>
                <th>Humidity</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through the historical data and display rows -->
            <!-- Example: -->
            @foreach ($historicalData as $data)
            <tr>
                {{-- <td>{{ $data->date }}</td>
                <td>{{ $data->city }}</td>
                <td>{{ $data->humidity }}</td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
