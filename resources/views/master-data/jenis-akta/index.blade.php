@extends('layouts.commonMaster')

@section('title', 'Daftar Jenis Akta')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="bg-white p-4 rounded shadow-sm">

        <h4 class="fw-bold py-3 mb-4">Daftar Jenis Akta</h4>

        {{-- Alert --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- Search & Add --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form method="GET" action="{{ route('jenis_akta.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari nama..." value="{{ $search ?? '' }}">
                <button class="btn btn-primary"><i class="ti ti-search"></i> Search</button>
                @if(isset($search) && $search != '')
                <a href="{{ route('jenis_akta.index') }}" class="btn btn-secondary ms-2"><i class="ti ti-refresh"></i> Reset</a>
                @endif
            </form>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCreate">
                <i class="ti ti-plus"></i> Tambah Jenis Akta
            </button>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th style="width:5%;">No</th>
                        <th>Nama</th>
                        <th class="text-center" style="width:15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenisAkta as $index => $ja)
                    <tr>
                        <td>{{ $jenisAkta->firstItem() + $index }}</td>
                        <td>{{ $ja->nama }}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEdit{{ $ja->id }}">
                                <i class="ti ti-pencil"></i> Edit
                            </button>
                            <form action="{{ route('jenis_akta.destroy', $ja->id) }}" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="ti ti-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="modalEdit{{ $ja->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $ja->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('jenis_akta.update', $ja->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditLabel{{ $ja->id }}">Edit Jenis Akta</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" name="nama" class="form-control" value="{{ $ja->nama }}" required>
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
                        <td colspan="3" class="text-center py-3">Data tidak ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $jenisAkta->links('pagination::bootstrap-5') }}
        </div>

    </div> {{-- end bg-white --}}
</div>

{{-- Modal Create --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('jenis_akta.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-plus"></i> Tambah Jenis Akta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
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
