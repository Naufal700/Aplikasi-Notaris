@extends('layouts.commonMaster')

@section('title', 'Proses Akta')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Daftar Proses Akta</h5>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
      <i class="ti ti-plus"></i> Tambah Proses
    </button>
  </div>
  <div class="card-body">
    <!-- Filter -->
    <form method="GET" action="{{ route('proses.index') }}" class="row mb-3">
      <div class="col-md-3">
        <input type="text" name="search" class="form-control" placeholder="Cari nomor/klien" value="{{ $search }}">
      </div>
      <div class="col-md-2">
        <select name="status" class="form-control">
          <option value="">-- Semua Status --</option>
          <option value="draft" {{ $status=='draft' ? 'selected' : '' }}>Draft</option>
          <option value="proses" {{ $status=='proses' ? 'selected' : '' }}>Proses</option>
        </select>
      </div>
      <div class="col-md-3">
        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
      </div>
      <div class="col-md-3">
        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
      </div>
      <div class="col-md-1">
        <button class="btn btn-secondary w-100"><i class="ti ti-search"></i>Cari</button>
      </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-light">
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
          @forelse($orders as $key => $order)
          <tr>
            <td>{{ $orders->firstItem() + $key }}</td>
            <td>{{ $order->nomor_order }}</td>
            <td>{{ $order->klien->nama ?? '-' }}</td>
            <td>{{ $order->jenisAkta->nama ?? '-' }}</td>
            <td>{{ $order->tanggal_order }}</td>
            <td>
              @if($order->status == 'draft')
                <span class="badge bg-secondary">Draft</span>
              @elseif($order->status == 'proses')
                <span class="badge bg-info">Proses</span>
              @elseif($order->status == 'selesai')
                <span class="badge bg-success">Selesai</span>
              @elseif($order->status == 'batal')
                <span class="badge bg-danger">Batal</span>
              @endif
            </td>
            <td>{{ number_format($order->biaya,0,',','.') }}</td>
            <td>
              <!-- Edit -->
              <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $order->id }}">
                <i class="ti ti-edit"></i>Edit
              </button>

              <!-- Batal -->
                       <form action="{{ route('proses.batal', $order->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Yakin batalkan proses ini?')">
                @csrf
                @method('PUT')
                <button class="btn btn-sm btn-danger"><i class="ti ti-x"></i>Batal</button>
              </form>
                       @if($order->status == 'proses' || $order->status == 'selesai')
    <form action="{{ route('order.kembalikanDraft', $order->id) }}" method="POST" style="display:inline">
      @csrf
      @method('PUT')
      <button type="submit" class="btn btn-sm btn-secondary"
        onclick="return confirm('Yakin ingin mengembalikan ke Draft?')">
        Cancel
      </button>
    </form>
  @endif
            </td>
          </tr>

          <!-- Modal Edit -->
          <div class="modal fade" id="modalEdit{{ $order->id }}" tabindex="-1">
            <div class="modal-dialog">
              <form method="POST" action="{{ route('proses.update', $order->id) }}" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                  <h5 class="modal-title">Edit Proses Akta</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Klien</label>
                    <select name="klien_id" class="form-control" required>
                      @foreach(\App\Models\Master\Klien::all() as $kl)
                        <option value="{{ $kl->id }}" {{ $order->klien_id == $kl->id ? 'selected' : '' }}>
                          {{ $kl->nama }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Jenis Akta</label>
                    <select name="jenis_akta_id" class="form-control" required>
                      @foreach(\App\Models\Master\JenisAkta::all() as $ja)
                        <option value="{{ $ja->id }}" {{ $order->jenis_akta_id == $ja->id ? 'selected' : '' }}>
                          {{ $ja->nama }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Tanggal Order</label>
                    <input type="date" name="tanggal_order" class="form-control" value="{{ $order->tanggal_order }}" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Biaya</label>
                    <input type="number" name="biaya" class="form-control" value="{{ $order->biaya }}">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{ $order->keterangan }}</textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
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

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('proses.store') }}" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah Proses Akta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Pilih Order (Draft)</label>
          <select name="order_id" class="form-control" required>
            <option value="">-- Pilih Order --</option>
            @foreach(\App\Models\Order\Order::where('status','draft')->get() as $o)
              <option value="{{ $o->id }}">{{ $o->nomor_order }} - {{ $o->klien->nama ?? '-' }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Proses</button>
      </div>
    </form>
  </div>
</div>
@endsection
