<?php

namespace LCCA\Middlewares;

use LCCA\App;

final class EnsureUserIsNotLoggedMiddleware
{
  function before()
  {
    if ($_SESSION['loggedUser'] === []) {
      return true;
    }

    App::redirect('/');
  }
}
