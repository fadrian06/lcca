<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Enums\Role;
use LCCA\Models\UserModel;

final readonly class AccountRegistrationController extends Controller
{
  function __construct(private LoginController $loginController)
  {
    parent::__construct();
  }

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

    $this->tryOfFail(static fn(): UserModel => UserModel::create(
      $userData->nombre,
      $userData->cédula,
      $userData->contraseña,
      Role::Coordinator->value,
      $userData->pregunta_secreta,
      $userData->respuesta_secreta
    ));

    flash()->set('Cuenta de coordinador creada exitósamente', 'success');
    session()->remove('lastData');
    $this->loginController->handleLogin();
  }
}
