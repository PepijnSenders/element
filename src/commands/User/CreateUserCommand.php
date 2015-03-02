<?php

namespace Pep\Element\Commands\User;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Pep\Element\User\CmsUser;

class CreateUserCommand extends Command {

  protected $name = 'element-cms::user:create';

  protected $description = 'Create user for element CMS.';

  public function fire() {
    $user = new CmsUser();

    $this->info('Fill in the admin user credentials.');

    $user->email = $this->ask('Admin email:');
    $user->password = Hash::make($this->secret('Admin password:'));

    $user->save();

    $this->info('User saved.');
  }

}