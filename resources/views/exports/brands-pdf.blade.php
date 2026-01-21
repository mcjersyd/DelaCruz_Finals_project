<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Brands Report</title>
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
        }
        th {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f5f5f5;
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
    <h1>Brands Report</h1>
    <div class="timestamp">Generated on {{ now()->format('F d, Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Vehicles Count</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->vehicles_count ?? 0 }}</td>
                    <td>{{ $brand->created_at->format('M d, Y') }}</td>
                    <td>{{ $brand->updated_at->format('M d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Brands: {{ count($brands) }}</p>
        <p>This is an automatically generated report</p>
    </div>
</body>
</html>
