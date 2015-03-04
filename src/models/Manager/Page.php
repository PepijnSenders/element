<?php

namespace Pep\Element\Models\Manager;

use Pep\Element\Models\MongoModel;
use Illuminate\Support\Facades\Route as LaravelRoute;
use Illuminate\Support\Str;

class Page extends MongoModel {

  protected $collection = 'element2manager_pages';
  protected $laravelRoute;

  public static function getAllRoutes() {
    $allRoutes = LaravelRoute::getRoutes();

    return $allRoutes;
  }

  public static function getAvailableRoutes() {
    $savedRoutes = self::get();
    $allRoutes = self::getAllRoutes();

    foreach ($allRoutes as $route) {
      if (!Str::startsWith($route->getName(), 'element::') && !is_null($route->getName())) {
        foreach ($savedRoutes as $savedRoute) {
          if ($savedRoute->name === $route->getName()) {
            continue;
          }
        }
        $availableRoutes[] = [
          'name' => $route->getName(),
          'path' => $route->getPath(),
        ];
      }
    }

    return $availableRoutes;
  }

  public function getLaravelRoute() {
    if ($this->laravelRoute) {
      return $this->laravelRoute;
    }

    $allRoutes = self::getAllRoutes();

    return $allRoutes->getByName($this->name);
  }

}