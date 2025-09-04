@extends('layouts.commonMaster')

@section('title', 'Arsip Order')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Arsip Order</h5>
    <div>
      <a href="{{ route('arsip.exportPDF', request()->all()) }}" class="btn btn-sm btn-danger me-1">
        <i class="ti ti-file"></i> PDF
      </a>
      <a href="{{ route('arsip.exportExcel', request()->all()) }}" class="btn btn-sm btn-success">
        <i class="ti ti-file"></i> Excel
      </a>
    </div>
  </div>

  <div class="card-body">
    <form method="GET" class="row g-2 mb-3">
      <div class="col-md-3">
        <input type="text" name="search" class="form-control" placeholder="Cari nomor/klien" value="{{ $search }}">
      </div>
      <div class="col-md-3">
        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
      </div>
      <div class="col-md-3">
        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
      </div>
      <div class="col-md-3">
        <button type="submit" class="btn btn-primary">Filter</button>
      </div>
    </form>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nomor Order</th>
          <th>Klien</th>
          <th>Jenis Akta</th>
          <th>Tanggal</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $index => $order)
        <tr>
          <td>{{ $orders->firstItem() + $index }}</td>
          <td>{{ $order->nomor_order }}</td>
          <td>{{ $order->klien->nama }}</td>
          <td>{{ $order->jenisAkta->nama }}</td>
          <td>{{ $order->tanggal_order }}</td>
          <td>{{ ucfirst($order->status) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    {{ $orders->links() }}
  </div>
</div>
@endsection
