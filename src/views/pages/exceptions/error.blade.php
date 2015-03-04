@extends('element::layouts.default')

@section('element::title') Error @stop

@section('element::content')
<legend>
  <h1>Error</h1>
  <p><a href="@route('Cms', 'pages.home')">Click here to go home.</a></p>
</legend>
@stop