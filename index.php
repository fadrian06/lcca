<?php

use LCCA\App;
use LCCA\Models\UserModel;
use Symfony\Component\Dotenv\Dotenv;

require_once 'vendor/autoload.php';
require_once 'app/routes.php';

if (!file_exists('.env')) {
  copy('.env.example', '.env');
}

(new Dotenv)->load('.env');
$_ENV['PDO_DSN'] ??= 'sqlite::memory';
$_ENV['PDO_USER'] ??= null;
$_ENV['PDO_PASSWORD'] ??= null;

session_start();
$_SESSION['loggedUser'] ??= [];
$_SESSION['messages'] ??= ['error' => null, 'success' => null];

if (key_exists('id', $_SESSION['loggedUser'])) {
  $loggedUser = UserModel::searchById($_SESSION['loggedUser']['id']);

  App::view()->set('loggedUser', $loggedUser);
}

App::start();
