<?php

namespace Pep\Element\Controllers\Api;

use Illuminate\Routing\Controller;
use Honor\Models\User\CmsUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Pep\ValidatorException;
use Honor\Router;

class UsersController extends Controller {

  public function login() {
    $user = new CmsUser();

    $user->email = Input::get('email');
    $user->password = Input::get('password');

    try {
      $user->validate([
        'email' => 'required|email',
      ]);
    } catch (ValidatorException $e) {
      return View::make('cms.pages.users.login')
        ->with('messages', $e->getMessageBag()->getMessages());
    }

    $attempt = Auth::cms()->attempt([
      'email' => $user->email,
      'password' => $user->password,
    ]);

    if ($attempt) {
      return Router::redirect('Cms', 'pages.home');
    } else {
      return View::make('cms.pages.users.login')
        ->with('messages', [
          ['Login failed.'],
        ]);
    }
  }

  public function logout() {
    Auth::cms()->logout();

    return Router::redirect('Cms', 'pages.users.login');
  }

}