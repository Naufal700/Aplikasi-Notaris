@php
$containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
$notasysName = 'Notasys';
$notasysUrl  = '#'; // bisa diisi website resmi Notasys jika ada
$contactEmail = 'support@notasys.com'; // sesuaikan jika ada email support
@endphp

<!-- Footer -->
<footer class="content-footer footer bg-white border-top">
  <div class="{{ $containerFooter }}">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center py-3">
      
      {{-- Bagian kiri --}}
      <div class="text-muted small">
        © <script>document.write(new Date().getFullYear())</script> 
        <strong>{{ $notasysName }}</strong>. All rights reserved.
      </div>

      {{-- Bagian kanan --}}
      <div class="mt-2 mt-md-0 d-flex flex-wrap align-items-center gap-3">
        <a href="{{ $notasysUrl }}" target="_blank" class="footer-link">Official Site</a>
        <a href="mailto:{{ $contactEmail }}" class="footer-link">Support</a>
        <a href="{{ config('variables.documentation') ?? '#' }}" target="_blank" class="footer-link">Documentation</a>
        <span class="text-muted d-none d-sm-inline">| Version 1.0</span>
      </div>

    </div>
  </div>
</footer>

{{-- CSS tambahan --}}
<style>
.footer {
  font-size: 0.875rem;
  background-color: #ffffff; /* putih murni */
  border-top: 1px solid #e0e0e0;
}
.footer .footer-link {
  color: #6c757d;
  transition: all 0.2s;
  text-decoration: none;
}
.footer .footer-link:hover {
  color: #7367F0; /* warna tema Notasys */
  text-decoration: underline;
}
</style>
