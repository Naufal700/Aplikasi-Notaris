<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Orders</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Laporan Orders</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Order</th>
                <th>Klien</th>
                <th>Jenis Akta</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $i => $order)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $order->nomor_order }}</td>
                <td>{{ $order->klien->nama }}</td>
                <td>{{ $order->jenisAkta->nama }}</td>
                <td>{{ $order->tanggal_order }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>Rp {{ number_format($order->biaya, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
