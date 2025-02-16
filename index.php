<?php

use LCCA\App;
use LCCA\Middlewares\EnsureAppIsNotInMaintenanceMiddleware;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/configurations.php';

App::group(
  '',
  static fn() => require_once __DIR__ . '/app/routes.php',
  [EnsureAppIsNotInMaintenanceMiddleware::class]
);

App::start();
