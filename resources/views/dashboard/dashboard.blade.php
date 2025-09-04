@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

{{-- Vendor Style --}}
@section('vendor-style')
  @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

{{-- Vendor Script --}}
@section('vendor-script')
  @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

{{-- Page Script --}}
@section('page-script')
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Chart Pendapatan Bulanan
      var options = {
        series: [{
          name: "Pendapatan",
          data: @json($chartPendapatan) // data dari controller
        }],
        chart: {
          height: 300,
          type: 'area',
          toolbar: { show: false }
        },
        colors: ['#7367F0'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: {
          categories: @json($bulanPendapatan), // misalnya ["Jan", "Feb", ...]
          labels: { style: { fontSize: '12px' } }
        },
        yaxis: {
          labels: {
            formatter: function (val) {
              return "Rp " + new Intl.NumberFormat().format(val);
            }
          }
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "Rp " + new Intl.NumberFormat().format(val);
            }
          }
        }
      };
      var chart = new ApexCharts(document.querySelector("#chartPendapatan"), options);
      chart.render();
    });
  </script>
@endsection

@section('content')
<div class="row">
  {{-- Card Statistik --}}
  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card shadow-sm border-0 rounded-3">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h6 class="text-muted mb-2">Total Klien</h6>
          <h3 class="mb-0">{{ $totalKlien }}</h3>
        </div>
        <div class="avatar bg-label-primary rounded-2">
          <i class="ti ti-users fs-3"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card shadow-sm border-0 rounded-3">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h6 class="text-muted mb-2">Total Order</h6>
          <h3 class="mb-0">{{ $totalOrder }}</h3>
        </div>
        <div class="avatar bg-label-success rounded-2">
          <i class="ti ti-file-invoice fs-3"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card shadow-sm border-0 rounded-3">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h6 class="text-muted mb-2">Pendapatan</h6>
          <h3 class="mb-0">Rp {{ number_format($totalPendapatan,0,',','.') }}</h3>
        </div>
        <div class="avatar bg-label-warning rounded-2">
          <i class="ti ti-currency-dollar fs-3"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card shadow-sm border-0 rounded-3">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h6 class="text-muted mb-2">Order Proses</h6>
          <h3 class="mb-0">{{ $orderProses }}</h3>
        </div>
        <div class="avatar bg-label-info rounded-2">
          <i class="ti ti-activity fs-3"></i>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Grafik Pendapatan --}}
<div class="row">
  <div class="col-lg-8 mb-4">
    <div class="card shadow-sm border-0 rounded-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Grafik Pendapatan Bulanan</h5>
        <i class="ti ti-chart-area"></i>
      </div>
      <div class="card-body">
        <div id="chartPendapatan"></div>
      </div>
    </div>
  </div>

  {{-- Aktivitas Log --}}
  <div class="col-lg-4 mb-4">
    <div class="card shadow-sm border-0 rounded-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Aktivitas Terbaru</h5>
        <i class="ti ti-clock"></i>
      </div>
      <div class="card-body">
        <ul class="list-group list-group-flush">
          @forelse($logs as $log)
            <li class="list-group-item d-flex justify-content-between align-items-start">
              <div>
                <div class="fw-semibold">{{ $log->description }}</div>
                <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
              </div>
              <span class="badge bg-label-primary">{{ $log->user->name ?? 'System' }}</span>
            </li>
          @empty
            <li class="list-group-item text-muted">Belum ada aktivitas</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
