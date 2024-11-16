<?php

use LCCA\App;
use LCCA\Middlewares\EnsureAppIsNotInMaintenanceMiddleware;
use LCCA\Models\UserModel;
use Symfony\Component\Dotenv\Dotenv;

require_once 'vendor/autoload.php';

App::group('', function (): void {
  require_once 'app/routes.php';
}, [EnsureAppIsNotInMaintenanceMiddleware::class]);

if (!file_exists('.env')) {
  copy('.env.example', '.env');
}

(new Dotenv)->load('.env');
$_ENV['PDO_DSN'] ??= 'sqlite::memory';
$_ENV['PDO_USER'] ??= null;
$_ENV['PDO_PASSWORD'] ??= null;
$_ENV['MAINTENANCE'] = ($_ENV['MAINTENANCE'] ?? 'false') === 'true';

date_default_timezone_set($_ENV['TIMEZONE'] ?? 'America/Caracas');

session_start();
$_SESSION['loggedUser'] ??= [];
$_SESSION['messages'] ??= ['error' => null, 'success' => null];

if (key_exists('id', $_SESSION['loggedUser'])) {
  $loggedUser = UserModel::searchById($_SESSION['loggedUser']['id']);

  App::view()->set('loggedUser', $loggedUser);
}

App::map('notFound', function (): void {
  App::renderPage('404', 'Página no encontrada', 'mercury-error');
});

App::view()->preserveVars = false;
App::start();
