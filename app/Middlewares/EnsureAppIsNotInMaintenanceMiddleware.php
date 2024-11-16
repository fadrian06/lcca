<?php

namespace LCCA\Middlewares;

use LCCA\App;

final class EnsureAppIsNotInMaintenanceMiddleware {
  function before() {
    if ($_ENV['MAINTENANCE']) {
      http_response_code(503);
      App::renderPage('maintenance', 'Servicio no disponible', 'mercury-error');

      exit;
    }
  }
}
