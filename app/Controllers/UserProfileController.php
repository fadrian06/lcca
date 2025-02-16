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
    $loggedUser = App::loggedUser();

    if ($loggedUser->isCorrectPassword($passwords->oldPassword)) {
      $loggedUser->changePassword($passwords->newPassword);
    }

    flash()->set('Contraseña actualizada exitosamente', 'success');
    App::redirect(App::request()->referrer);
  }

  function handleProfileInfoChange(): void
  {
    $profileData = $this->getValidatedData([
      'nombre' => ['required', 'name'],
      'cédula' => ['required', 'number', 'min:1'],
      'pregunta_secreta' => ['required', 'question'],
      'respuesta_secreta' => ['required', 'alphanum']
    ]);

    $profileData = App::request()->data;
    $loggedUser = App::loggedUser();

    try {
      $signatureImagePath = $_FILES['signature']['tmp_name'];
    } catch (Error) {
      $signatureImagePath = $loggedUser->getSignatureUrl();
    }

    $this->tryOfFail(static fn(): UserModel => $loggedUser->updateProfile(
      $profileData->nombre,
      $profileData->cédula,
      $signatureImagePath
        ? base64_encode(file_get_contents($signatureImagePath))
        : null,
      $profileData->pregunta_secreta,
      $profileData->respuesta_secreta
    ));

    flash()->set('Perfil actualizado exitosamente', 'success');
    App::redirect(App::request()->referrer);
  }

  static function disableAccount(): void
  {
    App::loggedUser()->disable();

    flash()->set('Cuenta desactivada exitosamente', 'success');
    App::redirect('/salir');
  }
}
