@extends('layouts.commonMaster')

@section('title', 'Daftar Template Dokumen')

@section('content')
<div class="card">
<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4">Daftar Template Dokumen</h4>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Search & Add --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" action="{{ route('template_dokumen.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama template..." value="{{ $search ?? '' }}">
            <button class="btn btn-primary"><i class="ti ti-search"></i> Search</button>
            @if(isset($search) && $search != '')
            <a href="{{ route('template_dokumen.index') }}" class="btn btn-secondary ms-2"><i class="ti ti-refresh"></i> Reset</a>
            @endif
        </form>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCreate">
            <i class="ti ti-plus"></i> Tambah Template
        </button>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th style="width:5%;">No</th>
                    <th>Nama Template</th>
                    <th>Jenis Akta</th>
                    <th class="text-center" style="width:20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templateDokumen as $index => $t)
                <tr>
                    <td>{{ $templateDokumen->firstItem() + $index }}</td>
                    <td>{{ $t->nama_template }}</td>
                    <td>{{ $t->jenisAkta?->nama ?? '-' }}</td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $t->id }}">
                            <i class="ti ti-pencil"></i> Edit
                        </button>
                        <form action="{{ route('template_dokumen.destroy', $t->id) }}" method="POST" class="d-inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="ti ti-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>

                {{-- Modal Edit --}}
                <div class="modal fade" id="modalEdit{{ $t->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('template_dokumen.update', $t->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="ti ti-pencil"></i> Edit Template</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <input type="text" name="nama_template" class="form-control form-control-sm" placeholder="Nama Template" value="{{ $t->nama_template }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <select name="jenis_akta_id" class="form-select form-select-sm">
                                            <option value="">-- Pilih Jenis Akta --</option>
                                            @foreach(\App\Models\Master\JenisAkta::all() as $ja)
                                            <option value="{{ $ja->id }}" {{ $ja->id == $t->jenis_akta_id ? 'selected' : '' }}>
                                                {{ $ja->nama }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <input type="file" name="file" class="form-control form-control-sm" accept="application/pdf">
                                        @if($t->file_path)
                                        <div class="mt-2" style="height:300px; overflow:auto; border:1px solid #ccc;">
                                            <iframe src="{{ asset('storage/'.$t->file_path) }}" width="100%" height="300px" style="border:none;"></iframe>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="ti ti-x"></i> Batal</button>
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="ti ti-check"></i> Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="4" class="text-center py-3">Data tidak ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-2">
        {{ $templateDokumen->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Modal Create --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('template_dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-plus"></i> Tambah Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <input type="text" name="nama_template" class="form-control form-control-sm" placeholder="Nama Template" required>
                    </div>
                    <div class="mb-2">
                        <select name="jenis_akta_id" class="form-select form-select-sm">
                            <option value="">-- Pilih Jenis Akta --</option>
                            @foreach(\App\Models\Master\JenisAkta::all() as $ja)
                            <option value="{{ $ja->id }}">{{ $ja->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <input type="file" name="file" class="form-control form-control-sm" accept="application/pdf" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="ti ti-x"></i> Batal</button>
                    <button type="submit" class="btn btn-success btn-sm"><i class="ti ti-check"></i> Simpan</button>
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
