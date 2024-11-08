<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Models\UserModel;

final readonly class LoginController {
  static function showLogin(): void {
    App::renderPage('login', 'Ingreso', 'mercury-login');
  }

  static function handleLogin(): void {
    $credentials = App::request()->data;

    // TODO: Validate empty data
    $userFound = UserModel::searchByEmail($credentials->email);

    if ($userFound?->isCorrectPassword($credentials->password)) {
      $_SESSION['loggedUser']['id'] = $userFound->id;

      App::redirect('/');
    } else {
      $_SESSION['loggedUser'] = null;
      
      App::redirect(App::request()->referrer);
    }
  }

  static function handleLogout(): void {
    $_SESSION['loggedUser'] = [];

    App::redirect('/ingresar');
  }
}
