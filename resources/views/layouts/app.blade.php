<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'E-BPHTB') }}</title>
    
    @vite(['resources/css/app.css', 'resources/css/tabler.scss', 'resources/js/app.js'])
  </head>
  <body class="layout-fluid">
    <div class="page">
      <!-- Sidebar -->
      @include('layouts.partials.sidebar')

      <div class="page-wrapper">
        <!-- Topbar -->
        @include('layouts.partials.header')

        <!-- Page header -->
        @hasSection('page-header')
          <div class="page-header d-print-none">
            <div class="container-xl">
              @yield('page-header')
            </div>
          </div>
        @endif

        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            @yield('content')
          </div>
        </div>

        <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    Copyright &copy; {{ date('Y') }}
                    <a href="." class="link-secondary">E-BPHTB</a>.
                    All rights reserved.
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    @stack('scripts')
  </body>
</html>
