<?php

namespace Pep\Element\Models\Data;

use Pep\Element\Models\MongoModel;
use Pep\Element\Locale\Locale;
use MongoRegex;

class Data extends MongoModel {

  protected function setTranslationForLocale($translation, $locale = Locale::GLOB_LOCALE) {
    list($region, $language) = [Locale::region($locale), Locale::language($locale)];

    $this->translations[$region][$language] = $translation;
  }

  public static function forBlock($page, $block) {
    $models = static::raw(function($collection) use ($page, $block) {
      return $collection->find([
        'blocks' => ["$page $block"],
      ]);
    });

    return $models;
  }

}