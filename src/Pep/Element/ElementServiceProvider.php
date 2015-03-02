<?php

namespace Pep\Element;

use Illuminate\Support\ServiceProvider;

class ElementServiceProvider extends ServiceProvider {

  public function boot() {
    $this->package('pep/element-cms');

    include __DIR__ . '/../../filters.php';
    include __DIR__ . '/../../routes.php';
    include __DIR__ . '/../../artisan.php';
  }

}