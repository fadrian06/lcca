<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Models\UserModel;

final readonly class LoginController
{
  static function showLogin(): void
  {
    App::renderPage('login', 'Ingresar', 'mercury-login');
  }

  static function handleLogin(): void
  {
    $credentials = App::request()->data;

    // TODO: Validate empty data
    $userFound = UserModel::searchByIdCard($credentials->idCard);

    if (
      $userFound?->isCorrectPassword($credentials->password)
      && !$userFound->isDeleted()
    ) {
      $_SESSION['loggedUser']['id'] = $userFound->id;
      App::redirect('/');

      return;
    }

    $_SESSION['loggedUser'] = [];

    App::redirect(App::request()->referrer);
  }

  static function handleLogout(): void
  {
    $_SESSION['loggedUser'] = [];

    App::redirect('/ingresar');
  }

  static function showRecover(?int $userIdCard): void
  {
    $userFound = null;

    if (!$userIdCard) {
      App::request()->query->cedula && App::redirect('/perfil/recuperar/' . App::request()->query->cedula);
    } else {
      $userFound = UserModel::searchByIdCard($userIdCard);
    }

    App::renderPage(
      'recover-profile',
      'Recuperar perfil',
      'mercury-login',
      compact('userFound')
    );
  }

  static function checkAnswer(int $userIdCard): void
  {
    $userFound = UserModel::searchByIdCard($userIdCard);

    if (!$userFound->isCorrectSecretAnswer(App::request()->data->secretAnswer)) {
      App::redirect(App::request()->referrer);
    } else {
      App::renderPage(
        'recover-password',
        'Cambiar contraseña',
        'mercury-login',
        compact('userFound')
      );
    }
  }

  static function recoverPassword(int $userIdCard): void
  {
    $userFound = UserModel::searchByIdCard($userIdCard);
    $userFound->changePassword(App::request()->data->password);

    App::request()->data->idCard = $userFound->getIdCard();
    self::handleLogin();
  }
}
