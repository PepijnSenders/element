@extends('element::layouts.default')

@section('element::title')
Manager &mdash; Minimap &mdash; Blocks
@stop

@section('element::content')
<section ng-controller="MinimapBlocksCtrl">
  <div class="row">
    <div id="blocks-minimap">
      @include('element::partials.minimap', ['minimap' => $minimap, 'scale' => 3 / 12])
    </div>
    <form action="{{ URL::route('element::api.manager.minimap.finalize') }}" method="POST" class="col-sm-offset-3 col-sm-9">
      <input type="hidden" value="{{ $minimap->page->name }}" name="page">
      <input type="hidden" value="@{{ blocks.joined }}" name="identifiers">
      <button type="submit" class="btn btn-warning" style="margin-top: 20px;">Continue</button>
    </form>
    <div class="col-sm-9 col-sm-offset-3">
      <form class="form-horizontal">
        <legend>
          <h1>Configure page blocks</h1>
          <p>Add identifiers with editable elements</p>
        </legend>
        <div class="form-group">
          <label class="control-label col-sm-3" for="identifiers">Blocks</label>
          <div class="col-sm-9">
            <input id="identifiers" type="text" ng-model="blocks.joined" class="form-control" disabled>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-9 col-sm-offset-3">
      <h3>Block tips</h3>
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
            <td class="col-sm-10" element-minimap-trigger-hover="'#{{ $tip }}'" ng-mouseenter="triggerHover();" ng-mouseleave="off();">
              #{{ $tip }}
            </td>
            <td class="col-sm-2">
              <button class="btn btn-success btn-sm pull-right" ng-click="addIdentifier('#{{ $tip }}');">Add identifier</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <form class="form-horizontal">
        <legend>
          <h4>Custom identifier</h4>
        </legend>
        <div class="form-group">
          <label class="control-label col-sm-3" for="custom">Identifier</label>
          <div class="col-sm-8">
            <input id="custom" type="text" ng-model="blocks.custom" class="form-control">
          </div>
          <div class="col-sm-1">
            <button class="btn btn-success pull-right" ng-click="search(blocks.custom);">Search</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@stop

@section('element::header.styles')
<style type="text/css">
  {{ $minimap->style }}
</style>
@stop