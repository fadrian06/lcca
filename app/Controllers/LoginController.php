<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Models\UserModel;
use Leaf\Flash;

final readonly class LoginController extends Controller
{
  static function showLogin(): void
  {
    App::renderPage('login', 'Ingresar', 'mercury-login');
  }

  function handleLogin(): void
  {
    $credentials = $this->getValidatedData([
      'cédula' => ['required'],
      'contraseña' => ['required']
    ]);

    $wasLoggedSuccessfully = auth()->login([
      'idCard' => $credentials->cédula,
      'password' => $credentials->contraseña
    ]);

    if (!$wasLoggedSuccessfully) {
      Flash::set(auth()->errors(), 'errors');
      App::redirect('/ingresar');

      exit;
    }

    App::redirect('/');
  }

  static function handleLogout(): void
  {
    auth()->logout();
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

  function recoverPassword(int $userIdCard): void
  {
    $userFound = UserModel::searchByIdCard($userIdCard);
    $userFound->changePassword($this->data->contraseña);
    $this->data->cédula = $userFound->getIdCard();
    $this->handleLogin();
  }
}
