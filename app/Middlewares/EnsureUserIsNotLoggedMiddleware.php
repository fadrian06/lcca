<?php

namespace LCCA\Middlewares;

use LCCA\App;

final class EnsureUserIsNotLoggedMiddleware
{
  function before()
  {
    if (auth()->id() === null) {
      return true;
    }

    App::redirect('/');
  }
}
