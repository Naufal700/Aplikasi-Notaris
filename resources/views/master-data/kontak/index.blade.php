@extends('layouts.commonMaster')

@section('title', 'Daftar Kontak')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Daftar Kontak</h5>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
      <i class="ti ti-plus"></i> Tambah Kontak
    </button>
  </div>

  <div class="card-body">
   @if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

    <!-- Search -->
    <form method="GET" action="{{ route('kontak.index') }}" class="mb-3">
      <div class="input-group" style="max-width: 350px;">
        <input type="text" name="search" class="form-control"
               placeholder="Cari nama / perusahaan / email"
               value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit">Cari</button>
      </div>
    </form>

    <!-- Table -->
    <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Perusahaan</th>
            <th>Jabatan</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Klien</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($kontak as $k)
          <tr>
            <td>{{ $loop->iteration + ($kontak->currentPage()-1)*$kontak->perPage() }}</td>
            <td>{{ $k->nama }}</td>
            <td>{{ $k->perusahaan }}</td>
            <td>{{ $k->jabatan }}</td>
            <td>{{ $k->telepon }}</td>
            <td>{{ $k->email }}</td>
            <td>{{ $k->klien?->nama }}</td>
            <td>
              <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $k->id }}">
                <i class="ti ti-edit"></i> Edit
              </button>
             <form action="{{ route('kontak.destroy', $k->id) }}" method="POST" class="d-inline-block form-delete">
  @csrf
  @method('DELETE')
  <button type="submit" class="btn btn-sm btn-danger">
    <i class="ti ti-trash"></i> Hapus
  </button>
</form>

            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center">Tidak ada data</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
      {{ $kontak->links('pagination::bootstrap-5') }}
    </div>
  </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('kontak.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kontak</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Perusahaan</label>
          <input type="text" name="perusahaan" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Jabatan</label>
          <input type="text" name="jabatan" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Telepon</label>
          <input type="text" name="telepon" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Klien</label>
          <select name="klien_id" class="form-select">
            <option value="">-- Pilih Klien --</option>
            @foreach($klien as $c)
              <option value="{{ $c->id }}">{{ $c->nama }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit (pindahkan keluar table biar rapi) -->
@foreach($kontak as $k)
<div class="modal fade" id="modalEdit{{ $k->id }}" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('kontak.update', $k->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Kontak</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" value="{{ $k->nama }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Perusahaan</label>
          <input type="text" name="perusahaan" class="form-control" value="{{ $k->perusahaan }}">
        </div>
        <div class="mb-3">
          <label class="form-label">Jabatan</label>
          <input type="text" name="jabatan" class="form-control" value="{{ $k->jabatan }}">
        </div>
        <div class="mb-3">
          <label class="form-label">Telepon</label>
          <input type="text" name="telepon" class="form-control" value="{{ $k->telepon }}">
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ $k->email }}">
        </div>
        <div class="mb-3">
          <label class="form-label">Klien</label>
          <select name="klien_id" class="form-select">
            <option value="">-- Pilih Klien --</option>
            @foreach($klien as $c)
              <option value="{{ $c->id }}" {{ $c->id == $k->klien_id ? 'selected' : '' }}>
                {{ $c->nama }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endforeach

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
      e.preventDefault(); // cegah submit langsung
      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data yang sudah dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit(); // submit kalau user pilih hapus
        }
      });
    });
  });
});
</script>
@endpush
