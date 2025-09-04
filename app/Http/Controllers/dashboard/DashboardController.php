<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Order\Order;
use App\Models\Master\Klien;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  public function index()
  {
    $totalKlien      = Klien::count();
    $totalOrder      = Order::count();
    $orderProses     = Order::where('status', 'proses')->count();
    $totalPendapatan = Order::sum('biaya');

    $pendapatanBulanan = Order::selectRaw("EXTRACT(MONTH FROM tanggal_order)::int as bulan, SUM(biaya) as total")
      ->groupBy('bulan')
      ->orderBy('bulan')
      ->get();

    $chartPendapatan = $pendapatanBulanan->pluck('total');
    $bulanPendapatan = $pendapatanBulanan->map(function ($item) {
      return \Carbon\Carbon::create()->month((int)$item->bulan)->translatedFormat('F');
    });

    $logs = DB::table('activity_log')
      ->join('users', 'activity_log.causer_id', '=', 'users.id')
      ->select('activity_log.*', 'users.name as user_name')
      ->orderBy('activity_log.created_at', 'desc')
      ->limit(5)
      ->get()
      ->map(function ($log) {
        $log->created_at = Carbon::parse($log->created_at);
        return $log;
      });

    return view('dashboard.dashboard', [
      'totalKlien'      => $totalKlien,
      'totalOrder'      => $totalOrder,
      'orderProses'     => $orderProses,
      'totalPendapatan' => $totalPendapatan,
      'chartPendapatan' => $chartPendapatan,
      'bulanPendapatan' => $bulanPendapatan,
      'logs'            => $logs,
    ]);
  }
}
