<?php

namespace Pep\Element\Locale;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class Locale {

  const GLOB_REGION = 'GLOB';
  const GLOB_LANG = 'en';
  const GLOB_LOCALE = 'en_GLOB';

  public static function locale() {
    return self::language() . '_' . strtoupper(self::region());
  }

  public static function language($locale = null) {
    $locale = \locale_parse($locale ? $locale : App::getLocale());

    if (array_key_exists('language', $locale)) {
      $language = strtolower($locale['language']);

      foreach (Config::get('element::i18n.locales') as $region => $languages) {
        if (in_array($language, $languages)) {
          return $language;
        }
      }
    }

    $defaultLocale = \locale_parse(Config::get('app.fallback_locale'));
    if (array_key_exists('language', $defaultLocale)) {
      return strtolower($defaultLocale['language']);
    } else {
      return self::GLOB_LANG;
    }
  }

  public static function region($locale = null) {
    $locale = \locale_parse($locale ? $locale : App::getLocale());

    if (array_key_exists('region', $locale)) {
      $region = strtolower($locale['region']);
      if (array_key_exists($region, Config::get('element::i18n.locales'))) {
        return $region;
      }
    }

    return self::GLOB_REGION;
  }

}