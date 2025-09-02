@php
use Illuminate\Support\Facades\Route;
$currentRouteName = Route::currentRouteName();
@endphp

<ul class="menu-sub">
  @foreach($menu as $submenu)
    @php
      $isActive = false;

      // cek slug level ini
      $slugs = is_array($submenu->slug ?? null) ? $submenu->slug : [$submenu->slug ?? ''];
      foreach($slugs as $slug) {
        if($slug && str_starts_with($currentRouteName, $slug)) {
          $isActive = true;
          break;
        }
      }

      // cek anak (recursive)
      if(isset($submenu->submenu)) {
        foreach($submenu->submenu as $sub) {
          $subSlugs = is_array($sub->slug ?? null) ? $sub->slug : [$sub->slug ?? ''];
          foreach($subSlugs as $slug) {
            if($slug && str_starts_with($currentRouteName, $slug)) {
              $isActive = true;
              break 2;
            }
          }
        }
      }

      $liClass = $isActive ? 'active open' : '';
    @endphp

    <li class="menu-item {{ $liClass }}">
      <a href="{{ isset($submenu->submenu) ? 'javascript:void(0);' : (isset($submenu->slug) && Route::has($submenu->slug) ? route($submenu->slug) : '#') }}"
         class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}">
        @isset($submenu->icon)
          <i class="{{ $submenu->icon }}"></i>
        @endisset
        <div>{{ $submenu->name ?? '' }}</div>
      </a>

      {{-- Recursive Submenu --}}
      @isset($submenu->submenu)
        <ul class="menu-sub {{ $isActive ? 'd-block' : '' }}">
          @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
        </ul>
      @endisset
    </li>
  @endforeach
</ul>
