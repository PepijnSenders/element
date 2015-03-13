<?php

namespace Pep\Element\Models\User;

use Pep\Element\Models\User\User;

class CmsUser extends User {

  protected $collection = 'element2user_cms_users';

  protected $rules = [
    'email' => 'email|required|unique:element2user_cms_users',
    'name' => 'required',
    'password' => 'required',
  ];

}