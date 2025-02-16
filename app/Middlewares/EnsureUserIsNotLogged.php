<?php

namespace LCCA\Middlewares;

use LCCA\App;

final class EnsureUserIsNotLogged
{
  function before()
  {
    if (auth()->user() === null) {
      return true;
    }

    App::redirect('/');
  }
}
