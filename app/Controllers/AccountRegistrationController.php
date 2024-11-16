<?php

namespace LCCA\Controllers;

use LCCA\App;
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
      $userData->email,
      $userData->password,
      $userData->secretQuestion,
      $userData->secretAnswer
    );

    // TODO: Send success message
    App::redirect('/ingresar');
  }
}
