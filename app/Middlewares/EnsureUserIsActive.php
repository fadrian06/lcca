<?php

namespace LCCA\Middlewares;

use LCCA\App;

final readonly class EnsureUserIsActive
{
  function before()
  {
    $loggedUser = App::loggedUser();

    if ($loggedUser?->isActive()) {
      return true;
    }

    flash()->set(['Tu cuenta se encuentra desactivada'], 'errors');
    App::redirect('/salir');

    exit;
  }
}
