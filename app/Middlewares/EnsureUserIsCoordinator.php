<?php

namespace LCCA\Middlewares;

use LCCA\App;
use Leaf\Flash;

final readonly class EnsureUserIsCoordinator
{
  function before()
  {
    $loggedUser = App::loggedUser();

    if ($loggedUser?->isCoordinator()) {
      return true;
    }

    Flash::set(['Acceso denegado'], 'errors');
    App::redirect(App::request()->referrer);

    exit;
  }
}
