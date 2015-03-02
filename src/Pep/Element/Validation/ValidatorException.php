<?php

namespace Pep\Element\Validation;

use Exception;

class ValidatorException extends Exception {

  /**
   * @var Illuminate\Support\MessageBag $messageBag
   */
  private $messageBag;

  /**
   * @param Illuminate\Support\MessageBag $messageBag
   */
  public function __construct($messageBag) {
    parent::__construct('Validation errors');

    $this->messageBag = $messageBag;
  }

  /**
   * @return Illuminate\Support\MessageBag
   */
  public function getMessageBag() {
    return $this->messageBag;
  }

}