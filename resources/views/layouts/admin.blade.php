<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- <link rel="icon" href="../../favicon.ico"> --}}

    <title>{{ config('app.name') }}</title>

    <link href="{{ mix('app_assets/css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.App = {!! json_encode([
            'title' => config('app.name'),
            'basePath' => '/',
            'csrfToken' => csrf_token(),
            'user' => auth()->user() ? collect(auth()->user()->toArray())->only('id', 'name', 'email') : null,
            'avatar' => auth()->user() ? auth()->user()->avatar_43_url : null,
            'maxFileSize' => intval(file_upload_max_size()),
        ]) !!};
    </script>
  </head>

  <body>
    <div id="app" :class="bodyClass">
        @include('layouts.admin.main-navbar')

        <div id="body">
            @include('layouts.admin.side-navbar')

            <div id="content">
                @yield('content')
            </div><!-- /#content -->
        </div>
    </div><!-- /#app -->

    <script src="{{ mix('app_assets/js/app.js') }}"></script>
  </body>
</html>
