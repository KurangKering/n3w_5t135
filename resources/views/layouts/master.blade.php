<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> --}}
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper" id="app">
    @include('layouts.partials.navbar')
    @include('layouts.partials.sidebar')
    <div class="content-wrapper">
      @include('layouts.partials.content_header')
      <div class="content">
        <div class="container-fluid">
          @yield('content')
        </div>
      </div>
    </div>
    <footer class="main-footer">{{-- 
      <div class="float-right d-none d-sm-inline">
      </div>
      <strong>Copyright &copy; 2014-2018 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
     --}}</footer>
  </div>
  <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
