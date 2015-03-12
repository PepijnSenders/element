@extends('element::layouts.default')

@section('element::title')
Manager &mdash; Minimap &mdash; Blocks
@stop

@section('element::content')
<section ng-controller="MinimapBlocksCtrl">
  <div class="row">
    @include('element::partials.minimap', ['minimap' => $minimap, 'scale' => 3 / 12])
    <div class="col-sm-9 col-sm-offset-3">
      <form class="form-horizontal">
        <legend>
          <h1>Configure page blocks</h1>
          <p>Add identifiers with editable elements</p>
        </legend>
        <div class="form-group">
          <label class="control-label col-sm-3" for="identifiers">Blocks</label>
          <div class="col-sm-9">
            <input id="identifiers" type="text" ng-model="blocks.identifiers.join(', ')" class="form-control">
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-9 col-sm-offset-3">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>
              Identifier
            </th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($minimap->tips as $tip)
          <tr>
            <td element-minimap-trigger-hover="'#{{ $tip }}'" ng-mouseenter="triggerHover();" ng-mouseleave="off();">
              #{{ $tip }}
            </td>
            <td>
              <button class="btn btn-success" ng-click="addIdentifier('#{{ $tip }}');">Add identifier</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@stop

@section('element::header.styles')
<style type="text/css">
  {{ $minimap->style }}
</style>
@stop