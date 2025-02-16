<?php

namespace LCCA\Middlewares;

use LCCA\App;

final readonly class EnsureDbIsInstalled
{
  function before()
  {
    App::renderPage('db-install-loader', 'Instalando base de datos', 'mercury-login');

    exit;
  }
}
