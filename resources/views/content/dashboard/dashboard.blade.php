@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

{{-- Vendor Style --}}
@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
<style>
/* -------------------- Glassmorphism Card -------------------- */
.hover-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-radius: 1rem;
    border: 1px solid rgba(255,255,255,0.2);
    transition: transform 0.5s ease, box-shadow 0.5s ease;
    cursor: pointer;
}
.hover-card:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 25px 50px rgba(0,0,0,0.25);
}

/* -------------------- CountUp -------------------- */
.count-up {
    font-weight: 700;
    font-size: 2rem;
    transition: transform 0.5s, color 0.5s;
}
.count-up.animate {
    transform: scale(1.2);
    color: #7367F0;
}

/* -------------------- Icon Hover -------------------- */
.icon-hover i {
    transition: transform 0.4s, color 0.3s;
}
.icon-hover:hover i {
    transform: rotate(15deg) scale(1.3);
    color: #fff;
}

/* -------------------- Progress Mini Bar -------------------- */
.progress-mini {
    height: 6px;
    border-radius: 4px;
    background: rgba(200,200,200,0.2);
    overflow: hidden;
}
.progress-bar {
    transition: width 1.5s ease-in-out, background 0.5s;
    background: linear-gradient(90deg, #7367F0, #9f7fff);
}

/* -------------------- Aktivitas Log -------------------- */
.activity-log {
    max-height: 400px;
    overflow-y: auto;
}
.activity-log li {
    opacity: 0;
    transform: translateX(-30px);
    animation: slideIn 0.6s forwards;
    animation-delay: calc(var(--i) * 0.1s);
    transition: background 0.3s;
}
.activity-log li:hover {
    background: rgba(115, 103, 240, 0.1);
    border-radius: 0.5rem;
}
@keyframes slideIn {
    to { opacity: 1; transform: translateX(0); }
}

/* -------------------- Typing Effect -------------------- */
#dashboard-typing::after {
    content: '|';
    animation: blink 0.8s infinite;
    margin-left: 2px;
}
@keyframes blink { 0%,50%,100%{opacity:1;} 25%,75%{opacity:0;} }
</style>
@endsection

{{-- Vendor Script --}}
@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

{{-- Page Script --}}
@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/countup.js@2.0.7/dist/countUp.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    /* -------------------- CountUp -------------------- */
    document.querySelectorAll('.count-up').forEach(counter => {
        const countUp = new CountUp(counter, counter.getAttribute('data-value'), {
            duration: 2,
            useEasing: true,
            separator: '.',
        });
        if (!countUp.error) { 
            countUp.start(() => counter.classList.add('animate'));
        }
    });

    /* -------------------- Chart Pendapatan -------------------- */
    var options = {
        series: [{
            name: "Pendapatan",
            data: @json($chartPendapatan)
        }],
        chart: {
            type: 'area',
            height: 350,
            toolbar: { show: true },
            zoom: { enabled: true },
        },
        colors: ['#7367F0'],
        fill: { 
            type: 'gradient',
            gradient: { shade: 'light', type:'vertical', opacityFrom:0.7, opacityTo:0.2, stops:[0,90,100] }
        },
        stroke: { curve: 'smooth', width: 3 },
        markers: { size: 6, colors:['#fff'], strokeColors:'#7367F0', strokeWidth:3, hover:{size:9} },
        xaxis: { categories: @json($bulanPendapatan), labels: { style:{ fontSize:'13px' } } },
        yaxis: { labels: { formatter: val => "Rp " + new Intl.NumberFormat().format(val) } },
        tooltip: { y: { formatter: val => "Rp " + new Intl.NumberFormat().format(val) } }
    };
    new ApexCharts(document.querySelector("#chartPendapatan"), options).render();

    /* -------------------- Typing Effect -------------------- */
    const messages = [
        "Selamat datang di Notasys!",
        "Pantau semua aktivitas notaris Anda secara real-time.",
        "Pendapatan meningkat, tetap semangat!"
    ];

    let i = 0, j = 0, currentMessage = '', isDeleting = false;
    const typingSpeed = 100, erasingSpeed = 50, delayBetween = 2000;

    function type() {
        const typingElement = document.getElementById('dashboard-typing');
        if (!isDeleting && j < messages[i].length) {
            currentMessage += messages[i][j];
            typingElement.textContent = currentMessage;
            j++;
            setTimeout(type, typingSpeed);
        } else if (isDeleting && j > 0) {
            currentMessage = currentMessage.slice(0, -1);
            typingElement.textContent = currentMessage;
            j--;
            setTimeout(type, erasingSpeed);
        } else {
            isDeleting = !isDeleting;
            if (!isDeleting) i = (i + 1) % messages.length;
            setTimeout(type, delayBetween);
        }
    }

    type();
});
</script>
@endsection

@section('content')
<div class="mb-4 text-center">
    <h4 class="fw-bold" id="dashboard-typing"></h4>
</div>

<div class="row g-4 mb-4">
    @php
        $cards = [
            ['title'=>'Total Klien','value'=>$totalKlien,'icon'=>'bi-people','color'=>'primary','progress'=>75],
            ['title'=>'Total Order','value'=>$totalOrder,'icon'=>'bi-file-earmark-text','color'=>'success','progress'=>60],
            ['title'=>'Pendapatan','value'=>$totalPendapatan,'icon'=>'bi-currency-dollar','color'=>'warning','progress'=>50],
            ['title'=>'Order Proses','value'=>$orderProses,'icon'=>'bi-hourglass-split','color'=>'info','progress'=>40],
        ];
    @endphp

    @foreach($cards as $card)
    <div class="col-lg-3 col-md-6 col-12">
        <div class="card hover-card shadow-sm border-0 rounded-4">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">{{ $card['title'] }}</h6>
                        <div class="count-up" data-value="{{ $card['value'] }}">0</div>
                    </div>
                    <div class="avatar bg-gradient-{{ $card['color'] }} rounded-3 p-3 icon-hover">
                        <i class="bi {{ $card['icon'] }} fs-3 text-white"></i>
                    </div>
                </div>
                <div class="progress progress-mini mt-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $card['progress'] }}%"></div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pendapatan Bulanan</h5>
                <i class="bi bi-bar-chart-line"></i>
            </div>
            <div class="card-body">
                <div id="chartPendapatan"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Aktivitas Terbaru</h5>
                <i class="bi bi-clock"></i>
            </div>
            <div class="card-body activity-log">
                <ul class="list-group list-group-flush">
                    @forelse($logs as $i => $log)
                        <li class="list-group-item d-flex justify-content-between align-items-start" style="--i: {{ $i }}">
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
