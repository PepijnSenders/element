<?php

namespace Pep\Element\Support;

use Illuminate\Support\Facades\URL;

class AssetHelper {

  public static function url($path) {
    return URL::asset("packages/pep/element/$path");
  }

}