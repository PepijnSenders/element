@extends('element::layouts.default')

@section('element::title')
Welcome
@stop

@section('element::content')
<h1>Welcome, {{ $user->name }}</h1>
Recent history.
@stop