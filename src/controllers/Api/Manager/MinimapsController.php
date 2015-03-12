<?php

namespace Pep\Element\Controllers\Api\Manager;

use Pep\Element\Controllers\BaseController;
use Pep\Element\Minimap\Minimap;
use Pep\Element\Minimap\MinimapException;
use Pep\Element\Models\Manager\Page;
use Pep\Element\Models\Data\Text;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use ErrorException;

class MinimapsController extends BaseController {

  public function load() {
    $page = Page::where('name', Input::get('route'))
      ->first();

    if (!$page) {
      $page = new Page;
    }

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
        'page' => $page->name,
      ]);
    } else {
      return Redirect::route('element::pages.manager.minimap.load')
        ->with('messages', [
          ['Route doesn\'t return a view instance.'],
        ]);
    }
  }

  public function finalize() {
    $page = Page::where('name', Input::get('page'))
      ->first();

    $page->identifiers = explode(', ', Input::get('identifiers'));

    $page->save();

    try {
      $minimap = new Minimap($page);
    } catch (MinimapException $e) {
      return Redirect::route('element::pages.manager.minimap.finalize')
        ->with('messages', [
          [$e->getMessage()],
        ]);
    }

    $translateables = $minimap->loadTranslateables();

    foreach ($translateables as $identifier => $textNodes) {
      foreach ($textNodes as $textNode) {
        $text = Text::where('default', $textNode)
          ->first();

        if (!$text) {
          $text = new Text;

          $text->default = $textNode;
          $text->blocks = ["$page->name $identifier"];
        } else if (!array_key_exists($page->name, $text->blocks)) {
          $blocks = $text->blocks;
          $blocks[] = "$page->name $identifier";
          $text->blocks = $blocks;
        }

        $text->save();
      }
    }

    return Redirect::route('element::pages.manager.minimap.finalize', [
      'page' => $page->name,
    ]);
  }

}