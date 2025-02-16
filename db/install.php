<?php

use LCCA\App;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/configurations.php';

set_time_limit(0);
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

function waitOneSecond(): void
{
  sleep(1);
}

App::sendServerEventMessage('Base de datos no instalada', 'waitOneSecond');
App::sendServerEventMessage('Instalando base de datos...', 'waitOneSecond');
