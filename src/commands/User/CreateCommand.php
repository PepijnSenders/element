<?php

namespace Pep\Element\Commands\User;

use Pep\Element\Commands\ElementCommand;
use Illuminate\Support\Facades\Hash;
use Pep\Element\Models\User\CmsUser;
use Pep\Element\Validation\ValidatorException;

class CreateCommand extends ElementCommand {

  protected $name = 'user:create';
  protected $description = 'Create new CMS user.';

  public function fire() {
    $user = new CmsUser;

    $this->info('Provide admin credentials.');
    $user->email = $this->ask('Admin email:');
    $user->name = $this->ask('Amin name:');
    $user->password = Hash::make($this->secret('Admin password:'));

    try {
      $user->validate();
    } catch (ValidatorException $e) {
      $messages = $e->getMessageBag()->getMessages();

      foreach ($messages as $message) {
        foreach ($message as $_message) {
          $this->error($_message);
        }
      }

      exit();
    }

    $user->save();

    $this->info('Done');
  }

}