<aside class="navbar navbar-vertical navbar-expand-lg d-print-none" data-bs-theme="dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark">
      <a href="{{ url('/') }}">
        E-BPHTB
      </a>
    </h1>
    <div class="navbar-nav flex-row d-lg-none">
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <span class="avatar avatar-sm" style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }})"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
          <div class="dropdown-divider"></div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" class="dropdown-item" 
               onclick="event.preventDefault(); this.closest('form').submit();">
               Logout
            </a>
          </form>
        </div>
      </div>
    </div>
    <div class="navbar-collapse show" id="sidebar-menu">
      <ul class="navbar-nav pt-lg-3">
        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dashboard') }}" >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
            </span>
            <span class="nav-link-title">
              Dashboard
            </span>
          </a>
        </li>
        <li class="nav-item dropdown {{ (request()->is('permohonan*') || request()->is('admin/verifikasi*')) ? 'active' : '' }}">
          <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="{{ (request()->is('permohonan*') || request()->is('admin/verifikasi*')) ? 'true' : 'false' }}" >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /><path d="M16 5.25l-8 4.5" /></svg>
            </span>
            <span class="nav-link-title">
              Permohonan
            </span>
          </a>
          <div class="dropdown-menu {{ (request()->is('permohonan*') || request()->is('admin/verifikasi*')) ? 'show' : '' }}">
            <div class="dropdown-menu-columns">
              <div class="dropdown-menu-column">
                <a class="dropdown-item {{ request()->routeIs('permohonan.index') ? 'active' : '' }}" href="{{ route('permohonan.index') }}">
                  Daftar Permohonan
                </a>
                <a class="dropdown-item {{ request()->routeIs('permohonan.create') ? 'active' : '' }}" href="{{ route('permohonan.create') }}">
                  Input Baru
                </a>
              </div>
            </div>
          </div>
        </li>
        @if(auth()->user()->role === \App\Enums\UserRole::Admin)
        <li class="nav-item">
          <a class="nav-link {{ request()->is('admin/verifikasi*') ? 'active' : '' }}" href="{{ route('admin.verifikasi.index') }}" >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
            </span>
            <span class="nav-link-title">
              Verifikasi Permohonan
            </span>
          </a>
        </li>

        <li class="nav-item dropdown {{ (request()->is('njop*') || request()->is('npoptkp*')) ? 'active' : '' }}">
          <a class="nav-link dropdown-toggle" href="#navbar-master" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="{{ (request()->is('njop*') || request()->is('npoptkp*')) ? 'true' : 'false' }}" >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
            </span>
            <span class="nav-link-title">
              Data Master
            </span>
          </a>
          <div class="dropdown-menu {{ (request()->is('njop*') || request()->is('npoptkp*')) ? 'show' : '' }}">
            <div class="dropdown-menu-columns">
              <div class="dropdown-menu-column">
                <a class="dropdown-item {{ request()->routeIs('njop.index') ? 'active' : '' }}" href="{{ route('njop.index') }}">
                  NJOP Wilayah
                </a>
                <a class="dropdown-item {{ request()->routeIs('npoptkp.index') ? 'active' : '' }}" href="{{ route('npoptkp.index') }}">
                  NPOPTKP
                </a>
              </div>
            </div>
          </div>
        </li>
        @endif

        <li class="nav-item">
          <a class="nav-link {{ request()->is('pembayaran*') ? 'active' : '' }}" href="{{ route('pembayaran.index') }}" >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 8l4 4l-4 4" /><path d="M3 12l18 0" /><path d="M7 8l-4 4l4 4" /></svg>
            </span>
            <span class="nav-link-title">
              Pembayaran & SSPD
            </span>
          </a>
        </li>

        @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Ppat)
        <li class="nav-item">
          <a class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" href="{{ route('laporan.index') }}" >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" /><path d="M18 14v4h4" /><path d="M18 11v-4a2 2 0 0 0 -2 -2h-2" /><path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M8 11h4" /><path d="M8 15h3" /></svg>
            </span>
            <span class="nav-link-title">
              Laporan Realisasi
            </span>
          </a>
        </li>
        @endif
      </ul>
    </div>
  </div>
</aside>
