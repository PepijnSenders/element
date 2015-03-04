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

    foreach ($this->attributes as $key => $value) {
      $properties[$key] = $this->$key;
    }

    $validator = Validator::make(
      $properties,
      $rules,
      Config::get('element::validation.messages', [])
    );

    if ($validator->fails()) {
      throw new ValidatorException($validator->messages());
    }
  }

}