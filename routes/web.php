<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\master\StafController;
use App\Http\Controllers\order\OrderController;
use App\Http\Controllers\Master\KlienController;
use App\Http\Controllers\master\KontakController;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\master\JenisAktaController;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\master\TemplateDokumenController;
use App\Http\Controllers\authentications\ForgotPasswordBasic;

// ------------------------------------
// Authentication Routes
// ------------------------------------
// Login Page
Route::get('/login', [LoginBasic::class, 'index'])->name('login');

// Login Process
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'login' => ['required'],
        'password' => ['required'],
    ]);

    $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

    if (Auth::attempt([$login_type => $request->login, 'password' => $request->password], $request->filled('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'login' => 'Nama pengguna atau kata sandi salah',
    ]);
})->name('login.post');

// Logout
Route::post('/logout', [LoginBasic::class, 'logout'])->name('logout');

// Register Page
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');

// Register Process
Route::post('/auth/register-basic', [RegisterBasic::class, 'store'])->name('auth-register-post');

// Forgot Password Page
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// ------------------------------------
// Protected Routes (Login Required)
// ------------------------------------
Route::middleware('auth')->group(function () {

    // Dashboard
    // Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
// Route Klien
Route::middleware('auth')->prefix('master')->group(function () {
    Route::get('klien', [KlienController::class, 'index'])->name('klien.index');
    Route::get('klien/create', [KlienController::class, 'create'])->name('klien.create');
    Route::post('klien/store', [KlienController::class, 'store'])->name('klien.store');
    Route::get('klien/{id}/edit', [KlienController::class, 'edit'])->name('klien.edit');
    Route::put('klien/{id}/update', [KlienController::class, 'update'])->name('klien.update');
    Route::delete('klien/{id}', [KlienController::class, 'destroy'])->name('klien.destroy');

    Route::get('klien/download-template', [KlienController::class, 'downloadTemplate'])->name('klien.downloadTemplate');
    Route::post('klien/import', [KlienController::class, 'import'])->name('klien.import');
});
// Route Kontak
Route::resource('kontak', KontakController::class);
// Route Jenis Akta
Route::resource('jenis_akta', JenisAktaController::class);
// Route Template Dokumen
Route::resource('template_dokumen', TemplateDokumenController::class);
// Route Staff
Route::prefix('master')->group(function () {
    Route::resource('staf', StafController::class)->except(['show', 'create', 'edit']);
});
// Route Order
Route::prefix('orders/daftar-order')->name('daftar-order.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index'); // <<< FIXED
    Route::post('/', [OrderController::class, 'store'])->name('store');
    Route::put('/{id}', [OrderController::class, 'update'])->name('update');
    Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');

    // Export
    Route::get('/export/pdf', [OrderController::class, 'exportPDF'])->name('exportPDF');
    Route::get('/export/excel', [OrderController::class, 'exportExcel'])->name('exportExcel');
});
// Route Arsip Order
Route::prefix('orders/arsip')->name('arsip.')->group(function () {
    Route::get('/', [OrderController::class, 'arsipIndex'])->name('index');
    Route::get('/export/pdf', [OrderController::class, 'arsipExportPDF'])->name('exportPDF');
    Route::get('/export/excel', [OrderController::class, 'arsipExportExcel'])->name('exportExcel');
});
// Route Proses Akta
Route::prefix('orders/proses')->name('proses.')->group(function () {
    Route::get('/', [OrderController::class, 'prosesIndex'])->name('index');
    Route::post('/', [OrderController::class, 'prosesStore'])->name('store');
    Route::put('/{id}', [OrderController::class, 'prosesUpdate'])->name('update');
    Route::put('/{id}/batal', [OrderController::class, 'prosesBatal'])->name('batal');
});
Route::put('/orders/{id}/kembalikan-draft', [OrderController::class, 'kembalikanDraft'])
    ->name('order.kembalikanDraft');
