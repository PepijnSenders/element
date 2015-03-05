<div class="minimap">
  <div element-minimap-highlight element-minimap-scale="{{ isset($scale) ? $scale : 1 }}" class="minimap__scale" id="{{ $minimap->identifier }}" ng-cloak>
    {{ $minimap->container }}
  </div>
</div>