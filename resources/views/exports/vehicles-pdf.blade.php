<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vehicles Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        h1 {
            color: #222;
            text-align: center;
            margin-bottom: 20px;
        }
        .timestamp {
            text-align: right;
            font-size: 12px;
            color: #666;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }
        th {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .color-box {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
            margin-right: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Vehicles Report</h1>
    <div class="timestamp">Generated on {{ now()->format('F d, Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Plate Number</th>
                <th>Color</th>
                <th>Brand</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->id }}</td>
                    <td>{{ $vehicle->name }}</td>
                    <td>{{ $vehicle->plate_number }}</td>
                    <td>
                        <span class="color-box" style="background-color: {{ $vehicle->color }};"></span>
                        {{ $vehicle->color }}
                    </td>
                    <td>{{ $vehicle->brand ? $vehicle->brand->name : 'No Brand' }}</td>
                    <td>{{ $vehicle->created_at->format('M d, Y') }}</td>
                    <td>{{ $vehicle->updated_at->format('M d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Vehicles: {{ count($vehicles) }}</p>
        <p>This is an automatically generated report</p>
    </div>
</body>
</html>
