@extends('layouts.commonMaster')

@section('title', 'Daftar Klien')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Daftar Klien</h4>
        <div>
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addKlienModal">
              Tambah Klien
          </button>
          <a href="{{ route('klien.downloadTemplate') }}" class="btn btn-success btn-sm">Download Template</a>
          <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">Import Excel</button>
        </div>
      </div>

      <div class="card-body">
       @if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

        <div class="mb-3">
          <form action="{{ route('klien.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-auto">
              <select name="jenis_klien" class="form-select form-select-sm">
                <option value="">Semua Jenis</option>
                <option value="Perorangan" {{ request('jenis_klien') == 'Perorangan' ? 'selected' : '' }}>Perorangan</option>
                <option value="Perusahaan" {{ request('jenis_klien') == 'Perusahaan' ? 'selected' : '' }}>Perusahaan</option>
              </select>
            </div>

            <div class="col-auto">
              <button type="submit" class="btn btn-primary btn-sm">Filter</button>
              @if(request('search') || request('jenis_klien'))
                <a href="{{ route('klien.index') }}" class="btn btn-secondary btn-sm">Reset</a>
              @endif
            </div>
          </form>
        </div>

        <div class="table-responsive text-nowrap">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>NPWP</th>
                <th>Jenis Klien</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($klien as $k)
              <tr>
                <td>{{ $loop->iteration + ($klien->currentPage()-1)*$klien->perPage() }}</td>
                <td>{{ $k->nama }}</td>
                <td>{{ $k->alamat }}</td>
                <td>{{ $k->email }}</td>
                <td>{{ $k->telepon }}</td>
                <td>{{ $k->npwp }}</td>
                <td>{{ $k->jenis_klien }}</td>
                <td>
                  <!-- Tombol Edit modal -->
                  <button type="button" class="btn btn-sm btn-warning"
                    onclick="editKlien(
                        {{ $k->id }},
                        '{{ addslashes($k->nama) }}',
                        '{{ addslashes($k->alamat) }}',
                        '{{ addslashes($k->email) }}',
                        '{{ addslashes($k->telepon) }}',
                        '{{ addslashes($k->npwp) }}',
                        '{{ $k->jenis_klien }}'
                    )">
                    Edit
                  </button>

                  <!-- Tombol Hapus dengan SweetAlert2 -->
                  <button type="button" class="btn btn-sm btn-danger" onclick="hapusKlien({{ $k->id }}, '{{ addslashes($k->nama) }}')">
                    Hapus
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <div class="mt-2">
            {{ $klien->links('pagination::bootstrap-5') }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Klien -->
<div class="modal fade" id="addKlienModal" tabindex="-1" aria-labelledby="addKlienModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('klien.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addKlienModalLabel">Tambah Klien</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="alamat" class="form-label">Alamat</label>
              <input type="text" name="alamat" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="telepon" class="form-label">Telepon</label>
              <input type="text" name="telepon" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="npwp" class="form-label">NPWP</label>
              <input type="text" name="npwp" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="jenis_klien" class="form-label">Jenis Klien</label>
              <select name="jenis_klien" class="form-select">
                <option value="">Pilih</option>
                <option value="Perorangan">Perorangan</option>
                <option value="Perusahaan">Perusahaan</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Klien -->
<div class="modal fade" id="editKlienModal" tabindex="-1" aria-labelledby="editKlienModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="editKlienForm" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editKlienModalLabel">Edit Klien</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="edit_nama" class="form-label">Nama</label>
              <input type="text" name="nama" id="edit_nama" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="edit_alamat" class="form-label">Alamat</label>
              <input type="text" name="alamat" id="edit_alamat" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="edit_email" class="form-label">Email</label>
              <input type="email" name="email" id="edit_email" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="edit_telepon" class="form-label">Telepon</label>
              <input type="text" name="telepon" id="edit_telepon" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="edit_npwp" class="form-label">NPWP</label>
              <input type="text" name="npwp" id="edit_npwp" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="edit_jenis_klien" class="form-label">Jenis Klien</label>
              <select name="jenis_klien" id="edit_jenis_klien" class="form-select">
                <option value="">Pilih</option>
                <option value="Perorangan">Perorangan</option>
                <option value="Perusahaan">Perusahaan</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('klien.import') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importModalLabel">Import Excel Klien</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <input type="file" name="file" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Import</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@push('after-scripts')
<script>
function hapusKlien(id, nama) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: `Data klien "${nama}" akan dihapus!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ url("master/klien") }}/' + id;

            let csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            let method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            form.appendChild(method);

            document.body.appendChild(form);
            form.submit();
        }
    });
}

function editKlien(id, nama, alamat, email, telepon, npwp, jenis_klien) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_alamat').value = alamat;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_telepon').value = telepon;
    document.getElementById('edit_npwp').value = npwp;
    document.getElementById('edit_jenis_klien').value = jenis_klien;

    var form = document.getElementById('editKlienForm');
    form.action = '{{ url("master/klien") }}/' + id + '/update'; // <-- perbaiki URL

    var editModal = new bootstrap.Modal(document.getElementById('editKlienModal'));
    editModal.show();
}

</script>
@endpush
