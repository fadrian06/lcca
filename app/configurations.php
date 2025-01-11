<?php

use Jenssegers\Date\Date;
use LCCA\App;
use LCCA\Models\UserModel;
use Symfony\Component\Dotenv\Dotenv;

///////////////////////////
// Environment variables //
///////////////////////////
if (!file_exists('.env')) {
  copy('.env.example', '.env');
}

(new Dotenv)->load('.env');
$_ENV['PDO_DSN'] ??= 'sqlite::memory';
$_ENV['PDO_USER'] ??= null;
$_ENV['PDO_PASSWORD'] ??= null;
$_ENV['MYSQLDUMP_PATH'] ??= 'C:/xampp/mysql/bin/mysqldump';
$_ENV['MAINTENANCE'] = ($_ENV['MAINTENANCE'] ?? 'false') === 'true';

/////////////////////
// Datetime locale //
/////////////////////
date_default_timezone_set($_ENV['TIMEZONE'] ?? 'America/Caracas');
Date::setLocale($_ENV['LOCALE'] ?? 'es');

/////////////
// Session //
/////////////
session_start();
$_SESSION['loggedUser'] ??= [];
$_SESSION['messages'] ??= ['error' => null, 'success' => null];

if (key_exists('id', $_SESSION['loggedUser'])) {
  $loggedUser = UserModel::searchById($_SESSION['loggedUser']['id']);

  App::view()->set('loggedUser', $loggedUser);
}

//////////////
// 404 page //
//////////////
App::map('notFound', function (): void {
  App::renderPage('404', 'Página no encontrada', 'mercury-error');
});

//////////////////
// Views engine //
//////////////////
App::view()->preserveVars = false;
