<?php

namespace Pep\Element\Controllers\Site\Manager\Minimap;

use Pep\Element\Controllers\BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Pep\Element\Models\Manager\Page;
use Pep\Element\Minimap\Minimap;
use Pep\Element\Minimap\MinimapException;
use Pep\Element\Models\Data\Text;

class PagesController extends BaseController {

  public function load() {
    $availableRoutes = Page::getAvailableRoutes();

    return View::make('element::pages.manager.minimap.load')
      ->with('availableRoutes', $availableRoutes)
      ->with('messages', Session::get('messages', []));
  }

  public function blocks(Page $page) {
    try {
      $minimap = new Minimap($page);
    } catch (MinimapException $e) {
      return Redirect::route('element::pages.manager.minimap.load')
        ->with('messages', [
          [$e->getMessage()],
        ]);
    }

    return View::make('element::pages.manager.minimap.blocks')
      ->with('messages', Session::get('messages', []))
      ->with('minimap', $minimap);
  }

  public function finalize(Page $page) {


    return View::make('element::pages.manager.minimap.finalize')
      ->with('page', $page);
  }

}