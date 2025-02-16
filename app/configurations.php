<?php

use Illuminate\Container\Container;
use Jenssegers\Date\Date;
use LCCA\App;
use LCCA\Models\UserModel;
use Symfony\Component\Dotenv\Dotenv;

///////////////////////////
// Environment variables //
///////////////////////////
if (!file_exists(__DIR__ . '/../.env')) {
  copy(__DIR__ . '/../.env.example', __DIR__ . '/../.env');
}

(new Dotenv)->load(__DIR__ . '/../.env');
$_ENV['PDO_DSN'] ??= 'sqlite::memory';
$_ENV['PDO_USER'] ??= null;
$_ENV['PDO_PASSWORD'] ??= null;
$_ENV['MYSQLDUMP_PATH'] ??= 'C:/xampp/mysql/bin/mysqldump';
$_ENV['MAINTENANCE'] = ($_ENV['MAINTENANCE'] ?? 'false') === 'true';

$_ENV['PDO_DSN'] = str_replace('%s', __DIR__ . '/../', $_ENV['PDO_DSN']);

/////////////////////
// Datetime locale //
/////////////////////
date_default_timezone_set($_ENV['TIMEZONE'] ?? 'America/Caracas');
Date::setLocale($_ENV['LOCALE'] ?? 'es');

///////////////
// Container //
///////////////
$container = Container::getInstance();

$container->singletonIf(PDO::class, static fn(): PDO => App::db());

App::registerContainerHandler([$container, 'get']);

////////////////////
// Authentication //
////////////////////
db()->connection($container->get(PDO::class));
auth()->dbConnection($container->get(PDO::class));

$loginParamsError = '¡Cédula o contraseña incorrecta!';
auth()->config('messages.loginParamsError', $loginParamsError);
auth()->config('messages.loginPasswordError', $loginParamsError);
auth()->config('session', true);
auth()->config('timestamps', false);
auth()->config('unique', ['idCard', 'signature']);

/////////////////
// Validations //
/////////////////
form()->message([
  'email' => '{Field} must be a valid email address',
  'alpha' => '{Field} must contain only alphabets and spaces',
  'text' => '{Field} must contain only alphabets and spaces',
  'string' => '{Field} must contain only alphabets and spaces',
  'textonly' => '{Field} must contain only alphabets',
  'alphanum' => '{Field} debe contener sólo letras y números',
  'alphadash' => '{Field} must contain only alphabets, numbers, dashes and underscores',
  'username' => '{Field} must contain only alphabets, numbers and underscores',
  'number' => '{Field} debe contener sólo números',
  'numeric' => '{Field} must be numeric',
  'float' => '{Field} must contain only floating point numbers',
  'hardfloat' => '{Field} must contain only floating point numbers',
  'date' => '{Field} must be a valid date',
  'min' => '{Field} debe tener al menos %s caracteres',
  'max' => '{Field} must not exceed %s characters',
  'between' => '{Field} must be between %s and %s characters long',
  'match' => '{Field} must match the %s field',
  'matchesvalueof' => '{Field} must match the value of %s',
  'contains' => '{Field} must contain %s',
  'boolean' => '{Field} must be a boolean',
  'truefalse' => '{Field} must be a boolean',
  'in' => '{Field} must be one of the following: %s',
  'notin' => '{Field} must not be one of the following: %s',
  'ip' => '{Field} must be a valid IP address',
  'ipv4' => '{Field} must be a valid IPv4 address',
  'ipv6' => '{Field} must be a valid IPv6 address',
  'url' => '{Field} must be a valid URL',
  'domain' => '{Field} must be a valid domain',
  'creditcard' => '{Field} must be a valid credit card number',
  'phone' => '{Field} must be a valid phone number',
  'uuid' => '{Field} must be a valid UUID',
  'slug' => '{Field} must be a valid slug',
  'json' => '{Field} must be a valid JSON string',
  'regex' => '{Field} must match the pattern %s',
  'array' => '{field} must be an array',
]);

form()->rule('required', '/^.+$/', '{Field} es requerido');

form()->rule(
  'name',
  '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,}$/',
  '{Field} debe contener solo letras y espacios'
);

form()->rule(
  'password',
  '/^(?=.*\d)(?=.*[A-ZÑ])(?=.*\W).{8,}$/',
  '{Field} debe contener al menos 8 caracteres, una letra mayúscula, un número y un caracter especial'
);

form()->rule(
  'question',
  '/^[a-z-A-Z0-9áéíóúÁÉÍÓÚñÑ\?\¿\s]+$/',
  '{Field} debe contener solo letras, números y los caracteres especiales: ¿?'
);

/////////////
// Session //
/////////////
if (auth()->id() !== null) {
  $loggedUser = UserModel::searchById(auth()->id());

  App::view()->set('loggedUser', $loggedUser);
}

//////////////
// 404 page //
//////////////
App::map('notFound', static function (): void {
  App::renderPage('404', 'Página no encontrada', 'mercury-error');
});

//////////////////
// Views engine //
//////////////////
App::view()->preserveVars = false;
