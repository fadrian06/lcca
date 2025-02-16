<?php

namespace LCCA\Middlewares;

use LCCA\App;

final class EnsureUserIsNotLoggedMiddleware
{
  function before()
  {
    if (auth()->user() === null) {
      return true;
    }

    App::redirect('/');
  }
}
