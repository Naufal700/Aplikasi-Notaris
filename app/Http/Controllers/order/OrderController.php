<?php

namespace App\Http\Controllers\order;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order\Order;
use App\Exports\OrderExport;
use App\Models\Master\Klien;
use Illuminate\Http\Request;
use App\Models\Master\JenisAkta;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    // Tampil daftar order dengan search, filter tanggal & pagination
    public function index(Request $request)
    {
        $search = $request->get('search');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Order::with(['klien', 'jenisAkta']);

        if ($search) {
            $query->where('nomor_order', 'like', "%$search%")
                ->orWhereHas('klien', fn($q) => $q->where('nama', 'like', "%$search%"));
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_order', [$startDate, $endDate]);
        }

        $orders = $query->orderBy('id', 'desc')->paginate(10);

        // Generate nomor order otomatis
        $tanggal = now()->format('Ymd'); // YYYYMMDD
        $lastOrder = Order::whereDate('created_at', now()->toDateString())
            ->orderBy('id', 'desc')
            ->first();
        $noUrut = $lastOrder ? intval(substr($lastOrder->nomor_order, -3)) + 1 : 1;
        $nomor_order = 'ORD-' . $tanggal . '-' . str_pad($noUrut, 3, '0', STR_PAD_LEFT);

        return view('orders.daftar-order.index', compact('orders', 'nomor_order', 'search', 'startDate', 'endDate'));
    }

    // Simpan order baru dengan nomor_order otomatis
    public function store(Request $request)
    {
        $request->validate([
            'klien_id'       => 'required|exists:klien,id',
            'jenis_akta_id'  => 'required|exists:jenis_akta,id',
            'tanggal_order'  => 'required|date',
            'biaya'          => 'nullable',
            'keterangan'     => 'nullable|string',
        ]);

        // Generate nomor_order otomatis
        $tanggal = now()->format('Ymd');
        $lastOrder = Order::whereDate('created_at', now()->toDateString())
            ->orderBy('id', 'desc')
            ->first();
        $noUrut = $lastOrder ? intval(substr($lastOrder->nomor_order, -3)) + 1 : 1;
        $nomor_order = 'ORD-' . $tanggal . '-' . str_pad($noUrut, 3, '0', STR_PAD_LEFT);

        $data = [
            'nomor_order'   => $nomor_order,
            'klien_id'      => $request->klien_id,
            'jenis_akta_id' => $request->jenis_akta_id,
            'tanggal_order' => $request->tanggal_order,
            'biaya'         => $request->biaya ? preg_replace('/[^0-9]/', '', $request->biaya) : null,
            'keterangan'    => $request->keterangan,
            'status'        => 'draft',
        ];

        Order::create($data);

        return redirect()->route('daftar-order.index')->with('success', 'Order berhasil ditambahkan!');
    }

    // Update order
    // Update order
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'klien_id'      => 'required|exists:klien,id',
            'jenis_akta_id' => 'required|exists:jenis_akta,id',
            'tanggal_order' => 'required|date',
            'status'        => 'required|in:draft,proses,selesai,batal',
            'biaya'         => 'nullable',
            'keterangan'    => 'nullable|string',
        ]);

        $data = [
            'klien_id'      => $request->klien_id,
            'jenis_akta_id' => $request->jenis_akta_id,
            'tanggal_order' => $request->tanggal_order,
            'status'        => $request->status,
            'biaya'         => $request->biaya ? preg_replace('/[^0-9]/', '', $request->biaya) : null,
            'keterangan'    => $request->keterangan,
        ];

        $order->update($data);

        return redirect()->route('daftar-order.index')->with('success', 'Order berhasil diperbarui!');
    }

    // Hapus order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Order berhasil dihapus!');
    }

    // Export Excel dengan filter
    public function exportExcel(Request $request)
    {
        $orders = $this->getFilteredOrders($request)->get();
        return Excel::download(new OrderExport($orders), 'orders.xlsx');
    }

    // Export PDF dengan filter
    public function exportPDF(Request $request)
    {
        $orders = $this->getFilteredOrders($request)->get();
        $pdf = Pdf::loadView('orders.daftar-order.pdf', compact('orders'));
        return $pdf->download('daftar-order.pdf');
    }

    // Reusable query filter (biar ga duplikat)
    private function getFilteredOrders(Request $request)
    {
        $search = $request->get('search');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Order::with(['klien', 'jenisAkta']);

        if ($search) {
            $query->where('nomor_order', 'like', "%$search%")
                ->orWhereHas('klien', fn($q) => $q->where('nama', 'like', "%$search%"));
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_order', [$startDate, $endDate]);
        }

        return $query->orderBy('id', 'desc');
    }
    // Menampilkan Arsip Order
    public function arsipIndex(Request $request)
    {
        $search = $request->get('search');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Order::with(['klien', 'jenisAkta'])
            ->whereIn('status', ['selesai', 'batal']); // Hanya arsip

        if ($search) {
            $query->where('nomor_order', 'like', "%$search%")
                ->orWhereHas('klien', fn($q) => $q->where('nama', 'like', "%$search%"));
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_order', [$startDate, $endDate]);
        }

        $orders = $query->orderBy('id', 'desc')->paginate(10);

        return view('orders.arsip.index', compact('orders', 'search', 'startDate', 'endDate'));
    }

    // Export PDF Arsip
    public function arsipExportPDF(Request $request)
    {
        $orders = $this->getFilteredArsip($request)->get();
        $pdf = Pdf::loadView('orders.arsip.pdf', compact('orders'));
        return $pdf->download('arsip-order.pdf');
    }

    // Export Excel Arsip
    public function arsipExportExcel(Request $request)
    {
        $orders = $this->getFilteredArsip($request)->get();
        return Excel::download(new OrderExport($orders), 'arsip-order.xlsx');
    }

    // Reusable filter query untuk arsip
    private function getFilteredArsip(Request $request)
    {
        $search = $request->get('search');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Order::with(['klien', 'jenisAkta'])
            ->whereIn('status', ['selesai', 'batal']);

        if ($search) {
            $query->where('nomor_order', 'like', "%$search%")
                ->orWhereHas('klien', fn($q) => $q->where('nama', 'like', "%$search%"));
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_order', [$startDate, $endDate]);
        }

        return $query->orderBy('id', 'desc');
    }
    public function prosesIndex(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status'); // filter status draft/proses/batal
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Order::with(['klien', 'jenisAkta'])
            ->whereIn('status', ['draft', 'proses']); // hanya yg belum arsip

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_order', 'like', "%$search%")
                    ->orWhereHas('klien', fn($q2) => $q2->where('nama', 'like', "%$search%"));
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_order', [$startDate, $endDate]);
        }

        $orders = $query->orderBy('id', 'desc')->paginate(10);

        return view('orders.proses.index', compact('orders', 'search', 'status', 'startDate', 'endDate'));
    }

    // Tambah Proses Akta (status otomatis jadi "proses")
    public function prosesStore(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        // update status jadi proses
        $order->status = 'proses';
        $order->save();

        return redirect()->back()->with('success', 'Order berhasil diproses!');
    }
    // Update Proses Akta
    public function prosesUpdate(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'klien_id' => 'required|exists:klien,id',
            'jenis_akta_id' => 'required|exists:jenis_akta,id',
            'tanggal_order' => 'required|date',
            'biaya' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['status'] = 'proses'; // pastikan tetap proses

        $order->update($data);

        return redirect()->back()->with('success', 'Proses Akta berhasil diperbarui!');
    }

    // Batalkan Proses Akta
    public function prosesBatal($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'batal']);

        return redirect()->back()->with('success', 'Proses Akta berhasil dibatalkan!');
    }
    public function kembalikanDraft($id)
    {
        $order = Order::findOrFail($id);

        if (in_array($order->status, ['proses', 'selesai'])) {
            $order->status = 'draft';
            $order->save();
        }

        return redirect()->route('proses.index')->with('success', 'Order berhasil dikembalikan ke draft.');
    }
}
