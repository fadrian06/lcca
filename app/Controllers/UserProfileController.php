<?php

namespace LCCA\Controllers;

use Error;
use LCCA\App;
use LCCA\Models\UserModel;

final readonly class UserProfileController extends Controller
{
  static function showConfigurations(): void
  {
    App::renderPage(
      'user-profile-configs',
      'Configuraciones de la cuenta',
      'mercury-home'
    );
  }

  static function handlePasswordChange(): void
  {
    $passwords = App::request()->data;

    /** @var UserModel */
    $loggedUser = App::view()->get('loggedUser');

    if ($loggedUser->isCorrectPassword($passwords->oldPassword)) {
      $loggedUser->changePassword($passwords->newPassword);
    }

    App::redirect(App::request()->referrer);
  }

  static function handleProfileInfoChange(): void
  {
    $profileData = App::request()->data;

    /** @var UserModel */
    $loggedUser = App::view()->get('loggedUser');

    try {
      $signatureImagePath = self::ensureThatFileIsSaved(
        'signature',
        '',
        $loggedUser->id,
        'signatures',
        'La firma es requerida'
      );
    } catch (Error) {
      $signatureImagePath = $loggedUser->getSignatureImagePath();
    }

    $loggedUser->updateProfile(
      $profileData->name,
      $profileData->idCard,
      $signatureImagePath
    );

    App::redirect(App::request()->referrer);
  }
}
