<?php

namespace LCCA\Middlewares;

use LCCA\App;
use LCCA\Models\UserModel;
use Leaf\Flash;

final readonly class EnsureUserIsCoordinator
{
  function before()
  {
    $loggedUser = App::view()->get('loggedUser');
    assert($loggedUser instanceof UserModel);

    if ($loggedUser->isCoordinator()) {
      return true;
    }

    Flash::set(['Acceso denegado'], 'errors');
    App::redirect(App::request()->referrer);

    exit;
  }
}
