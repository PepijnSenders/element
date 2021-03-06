@extends('element::layouts.default')

@section('element::title')
Login
@stop

@section('element::content')
<form class="form-horizontal" method="POST" action="{{ URL::route('element::api.users.login') }}">
  <input type="hidden" name="_token" value="{{ csrf_token(); }}">
  <input type="hidden" name="url" value="{{ $url }}">
  <legend>
    <h1>Welcome, to the {{ Config::get('element::cms.title') }}.</h1>
    <p>Please login to gain entry</p>
  </legend>
  @if (isset($messages))
    @include('element::partials.messages', ['messages' => $messages])
  @endif
  <div class="form-group">
    <label class="col-sm-2 control-label" for="email">
      Email:
    </label>
    <div class="col-sm-8">
      <input id="email" name="email" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="password">
      Password:
    </label>
    <div class="col-sm-8">
      <input id="password" name="password" type="password" class="form-control">
    </div>
  </div>
  <div class="form-group col-sm-2">
    <button class="btn btn-default pull-right" type="submit">Submit</button>
  </div>
</form>
@stop