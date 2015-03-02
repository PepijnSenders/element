@extends('element-cms::layouts.default')

@section('element-cms::title') Error @stop

@section('element-cms::content')
<legend>
  <h1>Error</h1>
  <p><a href="@route('Cms', 'pages.home')">Click here to go home.</a></p>
</legend>
@stop