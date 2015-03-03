<?php

namespace Pep\Element\Models;

use Jenssegers\Mongodb\Model as Moloquent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Pep\Element\Validation\ValidatorException;

abstract class MongoModel extends Moloquent {

  protected $rules = [];

  public function validate($extraRules = []) {
    $rules = array_merge($this->rules, $extraRules);

    $validator = Validator::make(
      $this->getMutatedArray(),
      $rules,
      Config::get('element-cms::validation.messages', [])
    );

    if ($validator->fails()) {
      throw new ValidatorException($validator->messages());
    }
  }

}