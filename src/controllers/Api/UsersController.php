<?php

namespace Pep\Element\Controllers\Api;

use Pep\Element\Controllers\BaseController;
use Pep\Element\Models\User\CmsUser;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Pep\Element\Validation\ValidatorException;

class UsersController extends BaseController {

  public function login() {
    $user = new CmsUser();

    $user->email = Input::get('email');
    $user->password = Input::get('password');

    try {
      $user->validate([
        'email' => 'required|email',
        'name' => '',
      ]);
    } catch (ValidatorException $e) {
      return View::make('element::pages.users.login')
        ->with('url', Input::get('url'))
        ->with('messages', $e->getMessageBag()->getMessages());
    }

    $attempt = Auth::element2cms()->attempt([
      'email' => $user->email,
      'password' => $user->password,
    ]);

    if ($attempt) {
      if (Input::has('url')) {
        return Redirect::to(Input::get('url'));
      } else {
        return Redirect::route('element::pages.home');
      }
    } else {
      return View::make('element::pages.users.login')
        ->with('url', Input::get('url'))
        ->with('messages', [
          ['Login failed.'],
        ]);
    }
  }

  public function logout() {
    Auth::element2cms()->logout();

    return Redirect::route('element::pages.users.login');
  }

}