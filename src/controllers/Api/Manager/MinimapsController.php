<?php

namespace Pep\Element\Controllers\Api\Manager;

use Pep\Element\Controllers\BaseController;
use Pep\Element\Minimap\Minimap;
use Pep\Element\Models\Manager\Page;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use ErrorException;

class MinimapsController extends BaseController {

  public function load() {
    $page = new Page;

    $page->name = Input::get('route');
    $action = $page->getLaravelRoute()->getAction();

    try {
      $pageResult = $action['uses']();
    } catch (ErrorException $e) {
      return Redirect::route('element::pages.manager.minimap.load')
        ->with('messages', [
          [$e->getMessage()],
        ]);
    }

    if ($pageResult instanceof View) {
      $name = $pageResult->getName();

      $page->view = $name;

      $page->save();

      return Redirect::route('element::pages.manager.minimap.blocks', [
        'route' => $page->name,
      ]);
    } else {
      return Redirect::route('element::pages.manager.minimap.load')
        ->with('messages', [
          ['Route doesn\'t return a view instance.'],
        ]);
    }
  }

}