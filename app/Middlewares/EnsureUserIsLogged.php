<?php

namespace LCCA\Middlewares;

use LCCA\App;

final class EnsureUserIsLogged
{
  function before()
  {
    if (auth()->user() !== null) {
      return true;
    }

    App::redirect('/ingresar', 401);

    exit;
  }
}
