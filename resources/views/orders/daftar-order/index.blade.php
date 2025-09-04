@extends('layouts.commonMaster')

@section('title', 'Daftar Order')

@section('content')
<div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Daftar Order</h5>
  <div>
   <a href="{{ route('daftar-order.exportPDF', request()->query()) }}" class="btn btn-danger">
  <i class="ti ti-file-text"></i> Export PDF
</a>
<a href="{{ route('daftar-order.exportExcel', request()->query()) }}" class="btn btn-success">
  <i class="ti ti-file-spreadsheet"></i> Export Excel
</a>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
      <i class="ti ti-plus"></i> Tambah Order
    </button>
  </div>
</div>

  <div class="card-body">
    {{-- Filter --}}
    <form method="GET" action="{{ route('daftar-order.index') }}" class="row g-2 mb-3">
      <div class="col-md-3">
        <input type="text" name="search" class="form-control" placeholder="Cari nomor order / klien" value="{{ $search }}">
      </div>
      <div class="col-md-3">
        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
      </div>
      <div class="col-md-3">
        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
      </div>
      <div class="col-md-3">
        <button type="submit" class="btn btn-outline-primary"><i class="ti ti-filter"></i> Filter</button>
      </div>
    </form>

    {{-- Tabel --}}
    <div class="table-responsive text-wrap">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Nomor Order</th>
            <th>Klien</th>
            <th>Jenis Akta</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Biaya</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($orders as $i => $order)
          <tr>
            <td>{{ $orders->firstItem() + $i }}</td>
            <td>{{ $order->nomor_order }}</td>
            <td>{{ $order->klien->nama }}</td>
            <td>{{ $order->jenisAkta->nama }}</td>
            <td>{{ $order->tanggal_order }}</td>
            <td>
              <span class="badge bg-{{ $order->status == 'selesai' ? 'success' : ($order->status == 'proses' ? 'info' : 'secondary') }}">
                {{ ucfirst($order->status) }}
              </span>
            </td>
            <td>Rp {{ number_format($order->biaya, 0, ',', '.') }}</td>
            <td>
    <!-- Tombol Edit -->
    <button class="btn btn-sm btn-warning" 
            data-bs-toggle="modal" 
            data-bs-target="#modalEdit{{ $order->id }}">
        <i class="ti ti-edit"></i> Edit
    </button>

    <!-- Tombol Hapus inline -->
    <form action="{{ route('daftar-order.destroy', $order->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">
            Hapus
        </button>
    </form>
</td>

          </tr>

          {{-- Modal Edit --}}
          <div class="modal fade" id="modalEdit{{ $order->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form action="{{ route('daftar-order.update', $order->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    @include('orders.partials.form', ['order' => $order])
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          @empty
          <tr>
            <td colspan="8" class="text-center">Tidak ada data</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $orders->links() }}
    </div>
  </div>
</div>

{{-- Modal Create --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('daftar-order.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @include('orders.partials.form', ['order' => null])
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
