<?php

namespace LCCA\Middlewares;

use LCCA\App;

final class EnsureUserIsLoggedMiddleware
{
  function before()
  {
    if ($_SESSION['loggedUser'] !== []) {
      return true;
    }

    App::redirect('/ingresar', 401);
  }
}
