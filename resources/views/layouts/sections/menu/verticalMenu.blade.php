@php
use Illuminate\Support\Facades\Route;

$currentRouteName = Route::currentRouteName();
@endphp

<aside id="layout-menu"
       class="layout-menu menu-vertical menu bg-white border-end shadow-sm">

  <!-- App Brand -->
  <div class="app-brand demo d-flex align-items-center px-3 py-2">
    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
      <span class="me-2">@include('_partials.macros', ["height" => 24])</span>
      <span class="fw-bold fs-5 text-primary">{{ config('variables.templateName') }}</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle ms-auto text-muted d-xl-none">
      <i class="ri-close-line fs-4"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-3 px-2" style="overflow-y:auto; max-height:100vh;">
    @foreach ($menuData[0]->menu as $menu)

      {{-- Menu Header --}}
      @if (isset($menu->menuHeader))
        <li class="menu-header small fw-semibold text-muted mt-4 mb-2 px-2">
          {{ __($menu->menuHeader) }}
        </li>
      @else
        @php
          $activeClass = '';
          if ($currentRouteName === $menu->slug) {
            $activeClass = 'active';
          } elseif (isset($menu->submenu)) {
            $slugs = is_array($menu->slug) ? $menu->slug : [$menu->slug];
            foreach ($slugs as $slug) {
              if (str_starts_with($currentRouteName, $slug)) {
                $activeClass = 'active open';
                break;
              }
            }
          }
        @endphp

        {{-- Main Menu --}}
        <li class="menu-item {{ $activeClass }}">
          <a href="{{ isset($menu->submenu) ? 'javascript:void(0);' : (isset($menu->url) ? url($menu->url) : '#') }}"
             class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }} d-flex align-items-center rounded px-3 py-2">
            @isset($menu->icon)
              <i class="{{ $menu->icon }} fs-5 me-2 text-muted"></i>
            @endisset
            <div class="flex-grow-1">{{ $menu->name ?? '' }}</div>
            @isset($menu->badge)
              <span class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</span>
            @endisset
          </a>

          {{-- Recursive Submenu --}}
          @isset($menu->submenu)
            @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
          @endisset
        </li>
      @endif

    @endforeach
  </ul>
</aside>

<style>
  /* Modern Sidebar Look */
  #layout-menu {
    transition: all 0.3s ease;
    width: 260px;
  }
  #layout-menu .menu-item .menu-link {
    color: #444;
    font-weight: 500;
    transition: background 0.2s, color 0.2s;
  }
  #layout-menu .menu-item .menu-link:hover {
    background: #f5f7fa;
    color: #0d6efd;
  }
  #layout-menu .menu-item.active > .menu-link {
    background: #e9f2ff;
    color: #0d6efd;
    font-weight: 600;
  }
  #layout-menu .menu-item.active i {
    color: #0d6efd;
  }
  /* Scrollbar slim */
  #layout-menu ul::-webkit-scrollbar {
    width: 6px;
  }
  #layout-menu ul::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
  }
</style>
