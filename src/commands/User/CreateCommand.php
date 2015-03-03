<?php

namespace Pep\Element\Commands\User;

use Pep\Element\Commands\ElementCommand;
use Illuminate\Support\Facades\Hash;

class CreateCommand extends ElementCommand {

  protected $name = 'user:create';
  protected $description = 'Create new CMS user.';

  public function fire() {
    $user = new CmsUser;

    $this->info('Provide admin credentials.');
    $user->email = $this->ask('Admin email:');
    $user->password = Hash::make($this->secret('Admin password:'));

    $user->save();

    $this->info('Done');
  }

}