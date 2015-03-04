<?php

namespace Pep\Element;

use Illuminate\Support\ServiceProvider;
use Pep\Element\Commands\User\CreateCommand;

class ElementServiceProvider extends ServiceProvider {

  public function boot() {
    $this->package('pep/element');

    include __DIR__ . '/../../filters.php';
    include __DIR__ . '/../../routes.php';
  }

  public function register() {
    $this->app->bind('element::user:create', function($app) {
      return new CreateCommand;
    });

    $this->commands([
      'element::user:create',
    ]);
  }

}