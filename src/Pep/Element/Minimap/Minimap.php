<?php

namespace Pep\Cms;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Pep\Element\Minimap\MinimapException;
use Leafo\ScssPhp\Compiler as ScssCompiler;
use DOMDocument;
use DOMNode;
use ErrorException;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class Minimap {

  private $page;
  private $document;
  private $namespace;
  private $html;

  public function __construct($page) {
    $this->page = $page;

    if (!View::exists($page)) {
      throw new MinimapException("No such view: $page.");
    }

    $this->html = View::make($page)
      ->render();

    \libxml_use_internal_errors(true);

    $this->document = new DOMDocument();
    $this->document->loadHTML($this->html);

    \libxml_clear_errors();

    $this->namespace = Str::camel(preg_replace('/\./', '_', $this->page));
  }

  public function getHtml() {
    return $this->html;
  }

  public static function outerHTML(DOMNode $node) {
    $document = new DOMDocument();
    $document->appendChild($document->importNode($node, true));
    return $document->saveHTML();
  }

  public static function innerHTML(DOMNode $node) {
    $innerHTML = "";
    $children = $node->childNodes;

    foreach ($children as $child) {
      $innerHTML .= $node->ownerDocument->saveHTML($child);
    }

    return $innerHTML;
  }

  public function getNamespace() {
    return $this->namespace;
  }

  public function getStyle() {
    if (Cache::has("element::$this->page.css")) {
      return Cache::get("element::$this->page.css");
    }

    $nodeList = $this->document->getElementsByTagName('link');
    foreach ($nodeList as $index => $node) {
      if ($node->getAttribute('rel') === 'stylesheet') {
        $url = str_replace(asset(''), '', $node->getAttribute('href'));
        $stylesheetLink = public_path($url);
        if (File::exists($stylesheetLink)) {
          $stylesheets[] = File::get($stylesheetLink);
        }
      }
    }

    $style = preg_replace('/\.\./', '.', implode('', $stylesheets));
    $style = "#{$this->namespace} { $style }";
    $compiler = new ScssCompiler();

    $css = $compiler->compile($style);

    Cache::put("element::$this->page.css", $css, Carbon::now()->addMinutes(30));

    return $css;
  }

  public static function addIds(DOMNode &$node) {
    foreach ($node->childNodes as $childNode) {
      if (is_a($childNode, 'DOMElement')) {
        if (!$childNode->getAttribute('id')) {
          $childNode->setAttribute('id', uniqid('cleaner-', true));
        }

        if ($childNode->childNodes && $childNode->childNodes->length > 0) {
          self::addIds($childNode);
        }
      }
    }
  }

  public static function cleanHTML(DOMNode &$node) {
    self::addIds($node);

    $scriptTags = $node->getElementsByTagName('script');
    $nodesToRemove = [];
    foreach ($scriptTags as $scriptNode) {
      $nodesToRemove[] = $scriptNode;
    }

    $linkTags = $node->getElementsByTagName('link');
    foreach ($linkTags as $linkNode) {
      $nodesToRemove[] = $linkNode;
    }

    foreach ($nodesToRemove as $nodeToRemove) {
      try {
        $node->removeChild($nodeToRemove);
      } catch (ErrorException $e) {
        Log::error($e);
      }
    }

    $crawler = new Crawler();

    $crawler->addContent(self::outerHTML($node));

    $document = new DOMDocument();
    $document->appendChild($document->importNode($node, true));

    $crawler->filter('[ng-app], [ng-controller], [ng-if], [ng-bind]')->each(function($app) use ($document) {
      $appNode = $document->getElementById($app->attr('id'));
      $appNode->removeAttribute('ng-app');
      $appNode->removeAttribute('ng-bind');
      $appNode->removeAttribute('ng-controller');
      $appNode->removeAttribute('ng-if');
    });

    return $document->saveHTML();
  }

  public function getContainer() {
    if (Cache::has("$this->page.html")) {
      return Cache::get("$this->page.html");
    }

    $node = $this->document->getElementById('container');

    if (!$node) {
      throw new MinimapException('No container present in HTML');
    }

    $html = self::cleanHTML($node);

    Cache::put("$this->page.html", $html, Carbon::now()->addMinutes(30));

    return $html;
  }

}