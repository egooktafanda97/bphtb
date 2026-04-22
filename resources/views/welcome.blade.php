<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>E-BPHTB - Sistem Pelayanan BPHTB Online</title>
    @vite(['resources/css/app.css', 'resources/css/tabler.scss', 'resources/js/app.js'])
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="." class="navbar-brand navbar-brand-autodark">
            <h1 class="display-4 font-weight-bold">E-BPHTB</h1>
          </a>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Sistem Pelayanan BPHTB Online</h2>
            <p class="text-secondary text-center">
              Selamat datang di portal layanan Bea Perolehan Hak atas Tanah dan Bangunan (BPHTB).
              Lakukan pendaftaran, verifikasi, dan pembayaran secara mandiri dan transparan.
            </p>
            <div class="hr-text">Akses Aplikasi</div>
            <div class="form-footer">
              <div class="row g-2">
                @auth
                <div class="col-12">
                  <a href="{{ route('dashboard') }}" class="btn btn-primary w-100">
                    Buka Dashboard
                  </a>
                </div>
                @else
                <div class="col-6">
                  <a href="{{ route('login') }}" class="btn btn-white w-100">
                    Masuk
                  </a>
                </div>
                <div class="col-6">
                  <a href="{{ route('register') }}" class="btn btn-primary w-100">
                    Daftar (Wajib Pajak/PPAT)
                  </a>
                </div>
                @endauth
              </div>
            </div>
          </div>
        </div>
        <div class="text-center text-secondary mt-3">
          &copy; {{ date('Y') }} Pemerintah Daerah. All rights reserved.
        </div>
      </div>
    </div>
  </body>
</html>
