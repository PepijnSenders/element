<?php

namespace Pep\Element\User;

use Illuminate\Support\Facades\Config;

class Auth {

  public static function check() {
    $permission = Config::get('element::cms.permission');

    $response = $permission();

    return !!$response;
  }

}