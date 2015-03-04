@extends('element::layouts.default')

@section('element::title') Not found @stop

@section('element::content')
<legend>
  <h1>Page not found</h1>
  <p><a href="@route('Cms', 'pages.home')">Click here to go home.</a></p>
</legend>
@stop