<?php

namespace LCCA\Middlewares;

use LCCA\App;

final class EnsureUserIsLoggedMiddleware
{
  function before()
  {
    if (auth()->user() !== null) {
      return true;
    }

    App::redirect('/ingresar', 401);
  }
}
