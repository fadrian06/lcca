<?php

namespace LCCA\Controllers;

use Exception;
use LCCA\App;
use LCCA\Enums\Role;
use LCCA\Models\UserModel;

final readonly class AccountRegistrationController extends Controller
{
  static function showRegistration(): void
  {
    App::renderPage('account-registration', 'Regístrarse', 'mercury-login');
  }

  function handleRegistration(): void
  {
    $userData = $this->getValidatedData([
      'nombre' => ['required', 'name'],
      'cédula' => ['required', 'number', 'min:1'],
      'contraseña' => ['required', 'password'],
      'pregunta_secreta' => ['required', 'question'],
      'respuesta_secreta' => ['required', 'alphanum']
    ]);

    $user = $this->tryOfFail(static fn(): UserModel => UserModel::create(
      $userData->nombre,
      $userData->cédula,
      $userData->contraseña,
      Role::Coordinator->value,
      $userData->pregunta_secreta,
      $userData->respuesta_secreta
    ));

    dd($user);

    // TODO: Send success message
    $_SESSION['messages']['success'] = 'Cuenta de coordinador creada exitósamente';
    unset($_SESSION['lastData']);
    LoginController::handleLogin();
  }
}
