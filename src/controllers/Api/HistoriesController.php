<?php

namespace Pep\Element\Controllers\Api;

use Illuminate\Routing\Controller;
use Honor\Models\Cms\History;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;

class HistoriesController extends Controller {

  public function getByKey() {
    $histories = History::where('key', Input::get('key'))
      ->orderBy('created_at', 'DESC')
      ->paginate(Input::get('count', 10))
      ->toArray();

    return Response::json([
      'histories' => $histories,
    ], 200);
  }

}