<?php

namespace Pep\Element\Minimap;

use Pep\Element\Minimap\MinimapException;
use Pep\Element\Models\Manager\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Pep\Element\Minimap\Builder;
use Symfony\Component\DomCrawler\Crawler;
use ErrorException;

class Minimap {

  public $page;
  public $html;
  public $tips;
  public $container;
  public $identifier;
  public $style;

  public function __construct(Page $page) {
    $this->page = $page;

    $this->html = Builder::html($page);
    $this->tips = Builder::tips($page);

    $this->identifier = self::createIdentifer($page);
    $this->container = Builder::container($page, $this->identifier);
    $this->style = Builder::style($page, $this->identifier);
  }

  public function loadTranslateables() {
    $crawler = new Crawler;
    $crawler->addContent($this->container);

    $translateables = [];
    foreach ($this->page->identifiers as $identifier) {
      $translateables[$identifier] = [];

      $crawler
        ->filter($identifier)
        ->each(function(Crawler $element) use (&$translateables, $identifier) {
          $element
            ->filter('*')
            ->each(function(Crawler $element) use (&$translateables, $identifier) {
              $text = trim($element->text());
              if (
                strlen($text) > 0 &&
                count($element->children()) === 0 &&
                !preg_match('/no-translate/', $element->attr('class')) &&
                $text !== '__translated__'
              ) {
                $translateables[$identifier][] = $text;
              }
            });
        });
    }

    $path = View::make($this->page->view)
      ->getPath();

    $contents = File::get($path);

    $textNodes = (object) ['flattened' => []];
    array_walk_recursive($translateables, function(&$value, $key, &$textNodes) {
      $textNodes->flattened[] = $value;
    }, $textNodes);

    if (!!count($textNodes->flattened)) {
      foreach ($textNodes->flattened as $textNode) {
        $contents = str_replace($textNode, '@translate("' . addslashes($textNode) . '")', $contents);
      }

      try {
        File::put($path, $contents);
      } catch (ErrorException $e) {
        try {
          chmod($path, 0750);
          File::put($path, $contents);
        } catch (ErrorException $e) {
          throw new MinimapException('File is not writeable.');
        }
      }
    }

    return $translateables;
  }

  public static function createIdentifer(Page $page) {
    return str_replace('.', '-', $page->name);
  }



}