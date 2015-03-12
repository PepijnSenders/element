<?php

namespace Pep\Element\Minimap;

use Pep\Element\Models\Manager\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;
use DOMDocument;
use DOMNode;
use ErrorException;
use Leafo\ScssPhp\Compiler as ScssCompiler;
use Pep\Element\Minimap\MinimapException;

class Builder {

  const STYLE = 'stylesheet';

  public static function html(Page $page) {
    if ($cached = self::getCached('html', $page)) {
      return $cached;
    }

    try {
      $html = View::make($page->view)
        ->with('no-translate', true)
        ->render();
    } catch (ErrorException $e) {
      throw new MinimapException('Error while rendering view, please solve the following error: "' . $e->getMessage() . '"');
    }

    self::saveCache('html', $page, $html);

    return $html;
  }

  public static function tips(Page $page) {
    if ($cached = self::getCached('tips', $page)) {
      return $cached;
    }

    $html = self::html($page);

    $crawler = new Crawler;

    $crawler->addContent($html);
    $crawler
      ->filter('section *')
      ->each(function(Crawler $element) use (&$tips) {
        if ($element->attr('id')) {
          $tips[] = $element->attr('id');
        }
      });

    self::saveCache('tips', $page, $tips);

    return $tips;
  }

  public static function container(Page $page, $identifier) {
    if ($cached = self::getCached('container', $page)) {
      return $cached;
    }

    $document = self::domDocument($page);
    $body = $document->getElementsByTagName('body');
    foreach ($body as $node) { $body = $node; }

    if (!$body) {
      throw new MinimapException('No body present in HTML.');
    }

    self::addIds($body);

    self::removeTags($body, 'script');
    self::removeTags($body, 'link');

    $document = self::removeAttributes($body, ['ng-app', 'ng-if', 'ng-bind', 'ng-controller', 'ng-repeat', 'ng-switch', 'ng-switch-when', 'ng-switch-default']);
    $html = $document->saveHTML();

    self::removeIds($body);

    self::saveCache('container', $page, $html);

    return $html;
  }

  public static function style(Page $page, $identifier) {
    if ($cached = self::getCached('style', $page)) {
      return $cached;
    }

    $document = self::domDocument($page);
    $linkElements = $document->getElementsByTagName('link');

    $stylesheets = [];
    foreach ($linkElements as $linkElement) {
      if ($linkElement->getAttribute('rel') === self::STYLE) {
        $relativePath = str_replace(URL::asset(''), '', $linkElement->getAttribute('href'));
        $absolutePath = public_path($relativePath);
        if (File::exists($absolutePath)) {
          $stylesheets[] = File::get($absolutePath);
        }
      }
    }

    $style = implode('', $stylesheets);
    self::cleanCss($style);

    $containeredStyle = "#{$identifier} { $style }";

    $compiler = new ScssCompiler;

    $css = $compiler->compile($containeredStyle);

    self::saveCache('style', $page, $css);

    return $css;
  }

  public static function cleanCss(&$css) {
    $css = preg_replace('/(\@font\-face\s\{[A-Za-z0-9\s\:\'\.\/\?\#\-\;\(\)\_\=\&\,]*\})/', '', $css);
    $css = preg_replace('/(\@import url\([A-Za-z0-9\.\/\-\_\'\"]*\)\;)/', '', $css);
  }

  public static function removeAttributes(DOMNode &$node, $attributes) {
    $crawler = new Crawler;

    $document = new DOMDocument();
    $document->appendChild($document->importNode($node, true));

    $crawler->addContent(self::outerHTML($node));
    $crawler
      ->filter('[' . implode('],[', $attributes) . ']')
      ->each(function($angularTag) use (&$document, $attributes) {
        $angularTagNode = $document->getElementById($angularTag->attr('id'));
        foreach ($attributes as $attribute) {
          $angularTagNode->removeAttribute($attribute);
        }
      });

    return $document;
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

  public static function removeTags(DOMNode &$node, $tagName) {
    $elements = $node->getElementsByTagName($tagName);

    $copiedElements = [];
    foreach ($elements as $element) {
      $copiedElements[] = $element;
    }

    foreach ($copiedElements as $copiedElement) {
      try {
        $node->removeChild($copiedElement);
      } catch (ErrorException $e) {
        throw new MinimapException($e->getMessage());
      }
    }
  }

  public static function addIds(DOMNode &$node) {
    foreach ($node->childNodes as $childNode) {
      if (is_a($childNode, 'DOMElement')) {
        if (!$childNode->getAttribute('id')) {
          $childNode->setAttribute('id', uniqid('minimap-', true));
        }

        if ($childNode->childNodes && $childNode->childNodes->length > 0) {
          self::addIds($childNode);
        }
      }
    }
  }

  public static function removeIds(DOMNode &$node) {
    foreach ($node->childNodes as $childNode) {
      if (is_a($childNode, 'DOMElement')) {
        if (Str::startsWith($childNode->getAttribute('id'), 'minimap-')) {
          $childNode->removeAttribute('id');
        }

        if ($childNode->childNodes && $childNode->childNodes->length > 0) {
          self::removeIds($childNode);
        }
      }
    }
  }

  public static function domDocument(Page $page) {
    $html = self::html($page);

    \libxml_use_internal_errors(true);
    $document = new DOMDocument;
    $document->loadHTML($html);
    \libxml_clear_errors();

    return $document;
  }

  public static function getCacheIdentifier($name, Page $page) {
    return "element::minimap.$name.{$page->name}";
  }

  public static function getCached($name, Page $page) {
    if (Cache::has(self::getCacheIdentifier($name, $page))) {
      return false && Cache::get(self::getCacheIdentifier($name, $page));
    }
  }

  public static function saveCache($name, Page $page, $value) {
    Cache::put(self::getCacheIdentifier($name, $page), $value, Carbon::now()->addMinutes(10));
  }

}