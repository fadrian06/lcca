<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Models\UserModel;

final readonly class UserProfileController
{
  static function showConfigurations(): void
  {
    App::renderPage(
      'user-profile-configs',
      'Configuraciones de la cuenta',
      'mercury-home'
    );
  }

  static function handlePasswordChange(): void {
    $passwords = App::request()->data;

    /** @var UserModel */
    $loggedUser = App::view()->get('loggedUser');

    if ($loggedUser->isCorrectPassword($passwords->oldPassword)) {
      $loggedUser->changePassword($passwords->newPassword);
    }

    App::redirect(App::request()->referrer);
  }

  static function handleProfileInfoChange(): void {}
}
