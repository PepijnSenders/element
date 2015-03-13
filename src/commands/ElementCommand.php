<?php

namespace Pep\Element\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class ElementCommand extends Command {

  public function __construct() {
    parent::__construct();
    Config::set('database.connections.pep__element', Config::get('element::database'));
  }

}