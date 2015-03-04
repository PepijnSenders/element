<?php

namespace Pep\Element\Models\User;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Pep\Element\Models\MongoModel;

abstract class User extends MongoModel implements UserInterface {

  use UserTrait;

}