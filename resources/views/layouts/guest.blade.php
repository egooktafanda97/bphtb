<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-BPHTB - Login/Auth</title>
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
          <a href="{{ url('/') }}" class="navbar-brand navbar-brand-autodark">
            <h1 class="font-weight-bold">E-BPHTB</h1>
          </a>
        </div>
        
        {{ $slot }}

        <div class="text-center text-secondary mt-3">
            &copy; {{ date('Y') }} E-BPHTB.
        </div>
      </div>
    </div>
  </body>
</html>
