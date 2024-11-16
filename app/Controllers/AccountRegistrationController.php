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

    // TODO: Validate empty data
    // TODO: Validate duplicates
    UserModel::create(
      $userData->name,
      $userData->idCard,
      $userData->password,
      Role::Admin->value,
      $userData->secretQuestion,
      $userData->secretAnswer
    );

    // TODO: Send success message
    LoginController::handleLogin();
  }
}
