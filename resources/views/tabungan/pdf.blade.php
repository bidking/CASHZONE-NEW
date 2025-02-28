<!DOCTYPE html>
<html>
<head>
    <title>Data Tabungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .title {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="title">
        <h1>Data Tabungan - {{ $kelas }}</h1>
        
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Total Masuk</th>
                <th>Tagihan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tabungans as $index => $tabungan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $tabungan->name }}</td>
                    <td>{{ number_format($tabungan->total_masuk, 0, ',', '.') }}</td>
                    <td>{{ number_format($tabungan->tagihan, 0, ',', '.') }}</td>
                    <td>{{ $tabungan->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>