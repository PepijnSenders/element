<?php

namespace Pep\Element\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Honor\Models\Cms\Field;
use Honor\Models\Cms\History;
use Honor\Models\Cms\CmsGlobal;
use MongoRegex;

class FieldsController extends Controller {

  public function get() {
    $field = Field::where('key', Input::get('key'))
      ->first();

    return Response::json([
      'field' => $field,
    ], 200);
  }

  public function save() {
    $key = Input::get('key');
    $locale = Input::get('locale');
    $value = Input::get('value');

    $field = Field::where('key', $key)
      ->first();

    $field->setTranslationForLocale($locale, $value);
    History::add($key, $locale, $value);

    $field->save();

    return Response::json([
      'field' => $field,
      'translation' => $field->getTranslationForLocale(Input::get('locale')),
    ]);
  }

  public function translation() {
    $field = Field::where('key', Input::get('key'))
      ->first();

    return Response::json([
      'field' => $field,
      'translation' => $field->getTranslationForLocale(Input::get('locale')),
    ], 200);
  }

  public function editables() {
    $block = Input::get('block');

    $globals = CmsGlobal::where('key', 'regex', new MongoRegex("/^$block/"))
      ->where('translation', '!=', 'block')
      ->get();

    return Response::json([
      'globals' => $globals,
    ], 200);
  }

}