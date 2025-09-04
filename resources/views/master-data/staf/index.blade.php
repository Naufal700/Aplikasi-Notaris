@extends('layouts.commonMaster')

@section('title', 'Daftar Staf')

@section('content')
<div class="card">
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Daftar Staf</h4>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Search & Add --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" action="{{ route('staf.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau email..." value="{{ $search ?? '' }}">
            <button class="btn btn-primary"><i class="ti ti-search"></i> Search</button>
            @if(isset($search) && $search != '')
                <a href="{{ route('staf.index') }}" class="btn btn-secondary ms-2"><i class="ti ti-refresh"></i> Reset</a>
            @endif
        </form>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCreate">
            <i class="ti ti-plus"></i> Tambah Staf
        </button>
    </div>

    {{-- Table --}}
  <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered">
        <thead>
                <tr>
                    <th style="width:5%;">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Jabatan</th>
                    <th>Role</th>
                    <th class="text-center" style="width:20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staf as $index => $s)
                <tr>
                    <td>{{ $staf->firstItem() + $index }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->email }}</td>
                    <td>{{ $s->telepon ?? '-' }}</td>
                    <td>{{ $s->jabatan ?? '-' }}</td>
                    <td>{{ ucfirst($s->role) }}</td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $s->id }}">
                            <i class="ti ti-pencil"></i> Edit
                        </button>
                        <form action="{{ route('staf.destroy', $s->id) }}" method="POST" class="d-inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                {{-- Modal Edit --}}
                <div class="modal fade" id="modalEdit{{ $s->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('staf.update', $s->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="ti ti-pencil"></i> Edit Staf</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="nama" class="form-control" value="{{ $s->nama }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $s->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Telepon</label>
                                        <input type="text" name="telepon" class="form-control" value="{{ $s->telepon }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jabatan</label>
                                        <input type="text" name="jabatan" class="form-control" value="{{ $s->jabatan }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <select name="role" class="form-select" required>
                                            <option value="admin" {{ $s->role=='admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="notaris" {{ $s->role=='notaris' ? 'selected' : '' }}>Notaris</option>
                                            <option value="staff" {{ $s->role=='staff' ? 'selected' : '' }}>Staff</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password <small>(kosongkan jika tidak diubah)</small></label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ti ti-x"></i> Batal</button>
                                    <button type="submit" class="btn btn-primary"><i class="ti ti-check"></i> Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="7" class="text-center py-3">Data tidak ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $staf->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Modal Create --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('staf.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-plus"></i> Tambah Staf</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="notaris">Notaris</option>
                            <option value="staff" selected>Staff</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ti ti-x"></i> Batal</button>
                    <button type="submit" class="btn btn-success"><i class="ti ti-check"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
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
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
