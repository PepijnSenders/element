@extends('element::layouts.default')

@section('element::title')
Manager &mdash; Minimap &mdash; Blocks
@stop

@section('element::content')
<div class="row">
  @include('element::partials.minimap', ['minimap' => $minimap])
  <div class="col-sm-4">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>
            Identifier
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($minimap->elementIdentifiers as $elementIdentifier)
        <tr>
          <td>
            {{ $elementIdentifier }}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@stop

@section('element::header.styles')
<style type="text/css">
  {{ $minimap->style }}
</style>
@stop