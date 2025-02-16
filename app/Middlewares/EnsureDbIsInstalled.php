<?php

namespace LCCA\Middlewares;

use LCCA\App;
use PDOException;

final readonly class EnsureDbIsInstalled
{
  function before()
  {
    try {
      App::db()->query('SELECT * FROM users LIMIT 1');
    } catch (PDOException) {
      App::renderPage('db-install-loader', 'Instalando base de datos', 'mercury-login');

      exit;
    }
  }
}
