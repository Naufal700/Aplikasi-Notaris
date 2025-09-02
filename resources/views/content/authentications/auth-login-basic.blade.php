@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('content')
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-6 mx-4">

     <!-- Login Card -->
<div class="card p-7 shadow-lg border-0 rounded-3">
  <!-- Logo -->
  <div class="app-brand justify-content-center mt-5">
    <a href="{{ url('/') }}" class="app-brand-link gap-3">
      <span class="app-brand-logo demo">@include('_partials.macros',["height"=>40,"withbg"=>'fill: #0d6efd;'])</span>
      <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
    </a>
  </div>
      <!-- /Logo -->
  <div class="card-body mt-4">
    <h4 class="mb-1 text-center">Selamat Datang! 👋</h4>
    <p class="mb-5 text-center">Silakan masuk untuk memulai perjalanan Anda</p>

    <form id="formAuthentication" class="mb-4" action="{{ route('login.post') }}" method="POST">
      @csrf
      @if ($errors->any())
        <div class="alert alert-danger text-center">
          {{ $errors->first() }}
        </div>
      @endif

      <div class="form-floating form-floating-outline mb-4">
        <input type="text" class="form-control" id="login" name="login" placeholder="Nama atau Email" autofocus required>
        <label for="login">Nama atau Email</label>
      </div>

      <div class="form-password-toggle mb-4">
        <div class="input-group input-group-merge">
          <div class="form-floating form-floating-outline">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <label for="password">Kata Sandi</label>
          </div>
          <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line ri-20px"></i></span>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
          <label class="form-check-label" for="remember-me">Ingat Saya</label>
        </div>
        <a href="{{ route('auth-reset-password-basic') }}">Lupa Kata Sandi?</a>
      </div>

      <button class="btn btn-primary d-grid w-100 mb-4" type="submit">Masuk</button>
    </form>

    <p class="text-center mb-0">
      <span>Belum punya akun?</span>
      <a href="{{ route('auth-register-basic') }}">
        <span>Buat Akun</span>
      </a>
    </p>
  </div>
</div>
<!-- /Login Card -->
      <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block">
      <img src="{{ asset('assets/img/illustrations/auth-basic-mask-light.png') }}" class="authentication-image d-none d-lg-block" height="172" alt="triangle-bg">
      <img src="{{ asset('assets/img/illustrations/tree.png') }}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block">
    </div>
  </div>
</div>
@endsection
