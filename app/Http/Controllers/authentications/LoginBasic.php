<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginBasic extends Controller
{
  // Tampilkan halaman login
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  // Proses login
  public function authenticate(Request $request)
  {
    // Validasi input
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    // Cek login
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate(); // regenerasi session
      return redirect()->intended('/'); // arahkan ke dashboard
    }

    return back()->withErrors([
      'email' => 'Email atau password salah!',
    ])->withInput();
  }

  // Logout
  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
  }
}
