<?php

namespace Pep\Element;

use Illuminate\Support\ServiceProvider;

class ElementServiceProvider extends ServiceProvider {

  public function boot() {
    $this->package('pep/element-cms');

    include __DIR__ . '/../../filters.php';
    include __DIR__ . '/../../routes.php';
  }

  public function register() {
    $this->app->bind('element::user:create', function($app) {
      return Pep\Element\Commands\User\CreateCommand;
    });
  }

}