<?php

use LCCA\App;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/configurations.php';

set_time_limit(0);
header('Content-Type: text/event-stream');

function wait(): void
{
  sleep(3);
}

App::sendServerEventMessage('Base de datos no instalada', 'wait');
App::sendServerEventMessage('Creando la base de datos...', 'wait');
App::sendServerEventMessage('Cargando el esquema de tablas...', 'wait');

$driver = match (true) {
  App::db()->isMysql() => 'mysql',
  App::db()->isSqlite() => 'sqlite',
  default => throw new Exception('No se ha encontrado un driver de base de datos válido'),
};

$schema = file_get_contents(__DIR__ . "/init.$driver.sql");

App::sendServerEventMessage('Creando tablas...', 'wait');

foreach (explode(';', $schema) as $query) {
  if (!$query) {
    continue;
  }

  App::db()->exec($query);
}

App::sendServerEventMessage('Tablas creadas', 'wait');
App::sendServerEventMessage('Cargando datos iniciales...', 'wait');
App::sendServerEventMessage('Base de datos instalada exitósamente', 'wait');
App::sendServerEventMessage('Recargando...', 'wait');
App::sendServerEventMessage('end');
