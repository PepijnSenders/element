<!DOCTYPE html>
<html class="no-js" lang="{{ Config::get('app.language') }}">
<head>
  <meta charset="utf-8">
  <title>{{ Config::get('element-cms::cms.title') }} &mdash; @yield('element-cms::title')</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <meta name="csrf" content="{{ csrf_token(); }}">

  {{-- <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> --}}

  {{-- <link rel="stylesheet" type="text/css" href="css/element-cms/base.css"> --}}
  @yield('element-cms::header.styles')

  <script type="text/javascript" src="{{ asset('vendor/modernizr/modernizr.js') }}"></script>
  @yield('element-cms::header.scripts')
</head>
<body ng-app="cmsApp">

  @if (Pep\Element\User\Auth::check())
  @include('element-cms::partials.header')
  @endif

  <section class="container">
    @yield('element-cms::content')
  </section>

  <script type="text/javascript" src="{{ asset('dist/element-cms.bundle.js') }}"></script>
  <script type="text/javascript" src="{{ asset('dist/element-cms.js') }}"></script>
  <script type="text/javascript" src="{{ asset('dist/element-cms/minimap.js') }}"></script>
  <script type="text/javascript">
    cmsApp.constant('EDITABLE_GET_FOR_BLOCK', '{{ URL::route('cms.api.fields.editables') }}');
    cmsApp.constant('FIELD_GET', '{{ URL::route('cms.api.fields.get') }}');
    cmsApp.constant('FIELD_SAVE', '{{ URL::route('cms.api.fields.save') }}');
    cmsApp.constant('FIELD_TRANSLATION', '{{ URL::route('cms.api.fields.translation') }}');
    cmsApp.constant('HISTORY_GET_KEY', '{{ URL::route('api.histories.get.key') }}');
    cmsApp.constant('USER_SHOW', '{{ URL::route('cms.pages.users.show', ['username' => ''], false) }}');
  </script>
  @yield('element-cms::footer.scripts')

  @include('element-cms::partials.livereload')
</body>
</html>