<!DOCTYPE html>
<html class="no-js" lang="{{ Config::get('app.language') }}">
<head>
  <meta charset="utf-8">
  <title>{{ Config::get('element::cms.title') }} &mdash; @yield('element::title')</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <meta name="csrf" content="{{ csrf_token(); }}">

  {{-- <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> --}}

  <link rel="stylesheet" type="text/css" href="{{ Pep\Element\Support\AssetHelper::url('css/element/base.css') }}">
  @yield('element::header.styles')

  <script type="text/javascript" src="{{ asset('vendor/modernizr/modernizr.js') }}"></script>
  @yield('element::header.scripts')
</head>
<body ng-app="cmsApp">

  @if (Auth::element2cms()->check())
  @include('element::partials.header')
  @endif

  <section class="container">
    @yield('element::content')
  </section>

  <script type="text/javascript" src="{{ Pep\Element\Support\AssetHelper::url('dist/element.bundle.js') }}"></script>
  <script type="text/javascript" src="{{ Pep\Element\Support\AssetHelper::url('dist/element.js') }}"></script>
  <script type="text/javascript" src="{{ Pep\Element\Support\AssetHelper::url('dist/element/minimap.js') }}"></script>
  <script type="text/javascript">
  </script>
  @yield('element::footer.scripts')
</body>
</html>