@extends('element-cms::layouts.default')

@section('element-cms::title')
Login
@stop

@section('element-cms::content')
<legend>
  <h1>Welcome, to the Honor CMS.</h1>
  <p>Please login to gain entry</p>
</legend>

@if (isset($messages))
  @foreach ($messages as $message)
  <p class="text-danger">{{ $message[0] }}</p>
  @endforeach
@endif
<form class="form-horizontal" method="POST" action="@route('Cms', 'api.users.login')">
  <input type="hidden" name="_token" value="{{ csrf_token(); }}">
  <div class="form-group">
    <label class="col-sm-2 control-label" for="email">
      Email:
    </label>
    <div class="col-sm-8">
      <input id="email" name="email" type="text" class="form-control"
      @if (Pep\ServerCheck::isLocal() || Pep\ServerCheck::isStaging())
        value="honor@hihonor.com"
      @endif
        >
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="password">
      Password:
    </label>
    <div class="col-sm-8">
      <input id="password" name="password" type="password" class="form-control"
      @if (Pep\ServerCheck::isLocal() || Pep\ServerCheck::isStaging())
        value="92$0wIQViDoZa*zH2HsL"
      @endif
        >
    </div>
  </div>
  <div class="form-group col-sm-2">
    <button class="btn btn-default pull-right" type="submit">Submit</button>
  </div>
</form>
@stop