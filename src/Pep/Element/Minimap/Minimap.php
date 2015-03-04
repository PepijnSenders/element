<?php

namespace Pep\Element\Minimap;

use Pep\Element\Minimap\MinimapException;
use Pep\Element\Models\Manager\Page;
use Illuminate\Support\Facades\View;
use Pep\Element\Minimap\Builder;

class Minimap {

  public $page;
  public $html;
  public $elementIdentifiers;
  public $container;
  public $identifier;
  public $style;

  public function __construct(Page $page) {
    $this->route = $page;

    $this->html = Builder::html($page);
    $this->elementIdentifiers = Builder::elementIdentifiers($page);

    $this->identifier = self::createIdentifer($page);
    $this->container = Builder::container($page, $this->identifier);
    $this->style = Builder::style($page, $this->identifier);
  }

  public static function createIdentifer(Page $page) {
    return str_replace('.', '-', $page->name);
  }



}