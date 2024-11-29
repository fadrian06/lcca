<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Enums\Role;
use LCCA\Models\UserModel;

final readonly class AccountRegistrationController
{
  static function showRegistration(): void
  {
    App::renderPage('account-registration', 'Regístrarse', 'mercury-login');
  }

  static function handleRegistration(): void
  {
    $userData = App::request()->data;

    if (
      !$userData->name
      || !preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ]{3,}$/', $userData->name)
    ) {
      $_SESSION['messages']['error'] = 'Nombre requerido o inválido (Debe tener al menos 3 letras)';
    } elseif (
      !$userData->idCard
      || !is_numeric($userData->idCard)
      || $userData->idCard <= 0
    ) {
      $_SESSION['messages']['error'] = 'Cédula requerida o inválida';
    } elseif (
      !$userData->password
      || !preg_match('/^(?=.*\d)(?=.*[A-ZÑ])(?=.*\W).{8,}$/', $userData->password)
    ) {
      $_SESSION['messages']['error'] = 'Contraseña requerida o inválida (Debe tener mínimo 8 caracteres, 1 dígito, 1 símbolo y una mayúscula)';
    } elseif (!$userData->secretQuestion) {
      $_SESSION['messages']['error'] = 'Pregunta de seguridad requerida';
    } elseif (!$userData->secretAnswer) {
      $_SESSION['messages']['error'] = 'Respuesta de seguridad requerida';
    }

    if ($_SESSION['messages']['error']) {
      $_SESSION['lastData'] = $userData->getData();

      App::redirect(App::request()->referrer);

      return;
    }

    // TODO: Validate empty data
    // TODO: Validate duplicates
    UserModel::create(
      $userData->name,
      $userData->idCard,
      $userData->password,
      Role::Coordinator->value,
      $userData->secretQuestion,
      $userData->secretAnswer
    );

    // TODO: Send success message
    $_SESSION['messages']['success'] = 'Cuenta de coordinador creada exitósamente';
    unset($_SESSION['lastData']);
    LoginController::handleLogin();
  }
}
