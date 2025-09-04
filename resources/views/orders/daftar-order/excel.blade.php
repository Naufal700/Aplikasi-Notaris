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
            <td>{{ $order->biaya }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
