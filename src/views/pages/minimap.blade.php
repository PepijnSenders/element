@extends('element::layouts.default')

@section('element::title')
Minimap &mdash; {{ Str::title($key) }}
@stop

@section('element::content')
<div class="row">
  <div class="minimap">
    <div cms-minimap-highlight cms-minimap-scale class="minimap__scale" id="{{ $minimap->getNamespace() }}" ng-cloak>
      {{ $minimap->getContainer() }}
    </div>
  </div>
  <div class="col-sm-9 col-sm-offset-3 blocks__container" ng-controller="BlocksCtrl">
    <ul class="blocks-list">
      <li ng-repeat="block in blocks" class="blocks-list__item">
        <legend class="blocks-list__header">
          <h3>
            @{{block | title}}
            <button ng-click="close(block);" class="btn btn-danger pull-right">X</button>
          </h3>
        </legend>
        <form class="form-horizontal" ng-controller="EditCtrl" ng-init="getForBlock(block);">
          <table class="table table-striped table-hover">
            <tr ng-repeat="editable in editables" cms-field="editable"></tr>
          </table>
        </form>
      </li>
    </ul>
  </div>
</div>
@stop

@section('element::header.styles')
<style type="text/css">
  {{ $minimap->getStyle() }}
</style>
@stop