@php
  use Illuminate\Support\Facades\Auth;
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
  <div class="container-fluid">

    <!-- Spacer biar konten di kanan -->
    <div class="flex-grow-1"></div>

    <!-- Search bar (optional, bisa hapus kalau ga perlu) -->
    <form class="d-none d-md-flex me-3">
      <input class="form-control form-control-sm rounded-pill px-3" type="search" placeholder="Cari..." aria-label="Search">
    </form>

    <!-- User Dropdown -->
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
           data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=random"
               class="rounded-circle me-2" width="36" height="36" alt="avatar">
          <span class="fw-semibold d-none d-lg-inline">{{ Auth::user()->name ?? 'User' }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
          <li class="px-3 py-2">
            <div class="d-flex align-items-center">
              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=random"
                   class="rounded-circle me-2" width="40" height="40" alt="avatar">
              <div>
                <h6 class="mb-0">{{ Auth::user()->name ?? 'User' }}</h6>
                <small class="text-muted">{{ Auth::user()->role ?? 'User' }}</small>
              </div>
            </div>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#"><i class="ri-user-3-line me-2"></i> Profil</a></li>
          <li><a class="dropdown-item" href="#"><i class="ri-settings-4-line me-2"></i> Pengaturan</a></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item text-danger">
                <i class="ri-logout-box-r-line me-2"></i> Logout
              </button>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
