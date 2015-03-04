<?php

namespace Pep\Element\Validation;

use Pep\Element\ElementException;

class ValidatorException extends ElementException {

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