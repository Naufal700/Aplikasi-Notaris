<div class="mb-3">
  <label class="form-label">Nomor Order</label>
  <input type="text" name="nomor_order" class="form-control" 
         value="{{ old('nomor_order', $nomor_order ?? '') }}" readonly>
</div>

<div class="mb-3">
  <label class="form-label">Klien</label>
  <select name="klien_id" class="form-select" required>
    <option value="">-- Pilih Klien --</option>
    @foreach(\App\Models\Master\Klien::all() as $klien)
      <option value="{{ $klien->id }}" 
        {{ old('klien_id', $order->klien_id ?? '') == $klien->id ? 'selected' : '' }}>
        {{ $klien->nama }}
      </option>
    @endforeach
  </select>
</div>

<div class="mb-3">
  <label class="form-label">Jenis Akta</label>
  <select name="jenis_akta_id" class="form-select" required>
    <option value="">-- Pilih Jenis Akta --</option>
    @foreach(\App\Models\Master\JenisAkta::all() as $akta)
      <option value="{{ $akta->id }}" 
        {{ old('jenis_akta_id', $order->jenis_akta_id ?? '') == $akta->id ? 'selected' : '' }}>
        {{ $akta->nama }}
      </option>
    @endforeach
  </select>
</div>

<div class="mb-3">
  <label class="form-label">Tanggal Order</label>
  <input type="date" name="tanggal_order" class="form-control" 
    value="{{ old('tanggal_order', $order->tanggal_order ?? '') }}" required>
</div>

<div class="mb-3">
  <label class="form-label">Status</label>
  <select name="status" class="form-select" required>
    @foreach(['draft','proses','selesai','batal'] as $st)
      <option value="{{ $st }}" 
        {{ old('status', $order->status ?? '') == $st ? 'selected' : '' }}>
        {{ ucfirst($st) }}
      </option>
    @endforeach
  </select>
</div>

<div class="mb-3">
  <label class="form-label">Biaya</label>
  <input type="text" id="biaya" name="biaya" class="form-control" 
         value="{{ old('biaya', $order->biaya ?? '') }}">
</div>


{{-- <div class="mb-3">
  <label class="form-label">Keterangan</label>
  <textarea name="keterangan" class="form-control">{{ old('keterangan', $order->keterangan ?? '') }}</textarea>
</div> --}}
<script>
const biayaInput = document.getElementById('biaya');

biayaInput.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, ''); // Hanya angka
    if(value) {
        value = new Intl.NumberFormat('id-ID').format(value);
        e.target.value = 'Rp ' + value;
    } else {
        e.target.value = '';
    }
});

// Saat form disubmit, hapus 'Rp' dan titik supaya bisa dikirim sebagai angka
document.querySelector('form').addEventListener('submit', function() {
    biayaInput.value = biayaInput.value.replace(/[^0-9]/g, '');
});
</script>
