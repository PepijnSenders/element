@extends('element::layouts.default')

@section('element::title')
Manager &mdash; Minimap &mdash; Finalize
@stop

@section('element::content')
<section ng-controller="ManagerCustomTextCtrl">
  <div class="row">
    <div class="col-sm-12">
      <form method="POST" action="{{ URL::route('element::api.manager.minimap.finish') }}">
        <input type="hidden" name="customs" value="@{{ customs }}">
        <button type="submit" class="btn btn-warning" style="margin-top: 20px;">Continue</button>
      </form>
    </div>
  </div>
  <h1>Translations found for {{ $page->name }}:</h1>
  @foreach($page->identifiers as $identifier)
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Block: {{ $identifier }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach (Pep\Element\Models\Data\Text::forBlock($page->name, $identifier) as $text)
      <tr>
        <td>{{ $text->default }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endforeach
  <form class="form-horizontal">
    <legend>
      <h4>Add custom texts</h4>
    </legend>
    <button ng-click="addCustom();" class="btn btn-default">Add</button>
    <div ng-repeat="custom in customs">
      <div class="form-group">
        <label for="identifier" class="col-sm-3 control-label">
          Identifier
        </label>
        <div class="col-sm-9">
          <input type="text" ng-model="custom.identifier" class="form-control" disabled="true">
        </div>
      </div>
      <div class="form-group">
        <label for="default" class="col-sm-3 control-label">
          Default
        </label>
        <div class="col-sm-9">
          <input type="text" ng-model="custom.default" class="form-control">
        </div>
      </div>
    </div>
  </form>
</section>
@stop

@section('element::footer.scripts')
<script type="text/javascript">
  elementManagerApp.constant('PAGE', '{{ $page->name }}');
</script>
@stop