@extends('layouts/blankLayout')

@section('title', 'Register')

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('content')
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-6 mx-4">
<!-- Register Card -->
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
    <h4 class="mb-1 text-center">Selamat Datang! 🚀</h4>
    <p class="mb-5 text-center">Buat akunmu dan mulai petualanganmu sekarang</p>

    <form id="formAuthentication" class="mb-4" action="{{ route('auth-register-post') }}" method="POST">
      @csrf
      @if ($errors->any())
        <div class="alert alert-danger">
          {{ $errors->first() }}
        </div>
      @endif

      <div class="form-floating form-floating-outline mb-4">
        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" autofocus required>
        <label for="name">Nama Lengkap</label>
      </div>

      <div class="form-floating form-floating-outline mb-4">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        <label for="email">Email</label>
      </div>

      <div class="form-floating form-floating-outline mb-4">
        <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi" required>
        <label for="password">Kata Sandi</label>
      </div>

      <div class="form-floating form-floating-outline mb-4">
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required>
        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
      </div>

      <div class="mb-4 py-2">
        <div class="form-check mb-0">
          <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required>
          <label class="form-check-label" for="terms-conditions">
            Saya menyetujui
            <a href="javascript:void(0);">kebijakan privasi & syarat dan ketentuan</a>
          </label>
        </div>
      </div>

      <button class="btn btn-primary d-grid w-100 mb-4" type="submit">
        Daftar
      </button>
    </form>

    <p class="text-center mb-0">
      <span>Sudah punya akun?</span>
      <a href="{{ route('login') }}">
        <span>Masuk di sini</span>
      </a>
    </p>
  </div>
</div>
<!-- /Register Card -->


      <img src="{{asset('assets/img/illustrations/tree-3.png')}}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block">
      <img src="{{asset('assets/img/illustrations/auth-basic-mask-light.png')}}" class="authentication-image d-none d-lg-block" height="172" alt="triangle-bg">
      <img src="{{asset('assets/img/illustrations/tree.png')}}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block">

    </div>
  </div>
</div>
@endsection
