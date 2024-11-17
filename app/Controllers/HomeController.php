<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Enums\Role;
use LCCA\Models\EnrollmentModel;
use LCCA\Models\UserModel;

final readonly class HomeController
{
  static function showHome(): void
  {
    $teachersAmount = count(UserModel::all(Role::Teacher));
    $activeStudentsAmount = count(EnrollmentModel::allActives());

    App::renderPage(
      'home',
      'Inicio',
      'mercury-home',
      compact('teachersAmount',  'activeStudentsAmount')
    );
  }
}
