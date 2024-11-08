<?php

namespace LCCA\Controllers;

use LCCA\App;

final readonly class HomeController
{
  static function showHome(): void
  {
    App::renderPage('home', 'Inicio', 'mercury-home');
  }
}
