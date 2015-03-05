@extends('element::layouts.default')

@section('element::title')
Manager &mdash; Minimap &mdash; Load
@stop

@section('element::content')
<form class="form-horizontal" method="POST" action="{{ URL::route('element::api.manager.minimap.load') }}">
  <legend>
      <h1>Select route</h1>
  </legend>
  @if (isset($messages))
    @include('element::partials.messages', ['messages' => $messages])
  @endif
  <div class="form-group">
    <div class="col-sm-7">
      <input name="route" element-manager-routes type="text" class="form-control" placeholder="Enter route">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-7">
      <button type="submit" class="btn btn-default">Load</button>
    </div>
  </div>
</form>
@stop

@section('element::footer.scripts')
<script type="text/javascript">
  elementManagerApp.constant('ROUTES', {{ json_encode($availableRoutes) }});
</script>
@stop