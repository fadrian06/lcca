<?php

namespace LCCA\Controllers;

use Error;
use LCCA\App;

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
    $loggedUser = App::loggedUser();

    if ($loggedUser->isCorrectPassword($passwords->oldPassword)) {
      $loggedUser->changePassword($passwords->newPassword);
    }

    App::redirect(App::request()->referrer);
  }

  static function handleProfileInfoChange(): void
  {
    $profileData = App::request()->data;
    $loggedUser = App::loggedUser();

    try {
      $signatureImagePath = $_FILES['signature']['tmp_name'];
    } catch (Error) {
      $signatureImagePath = $loggedUser->getSignatureUrl();
    }

    $loggedUser->updateProfile(
      $profileData->name,
      $profileData->idCard,
      $signatureImagePath
        ? base64_encode(file_get_contents($signatureImagePath))
        : null,
      $profileData->secretQuestion,
      $profileData->secretAnswer
    );

    App::redirect(App::request()->referrer);
  }

  static function deleteAccount(): void {
    App::loggedUser()?->delete();

    App::redirect('./salir');
  }
}
