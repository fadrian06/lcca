<?php

use LCCA\App;
use LCCA\Middlewares\EnsureAppIsNotInMaintenanceMiddleware;

require_once 'vendor/autoload.php';
require_once 'app/configurations.php';

App::group('', function (): void {
  require_once 'app/routes.php';
}, [EnsureAppIsNotInMaintenanceMiddleware::class]);

App::start();
