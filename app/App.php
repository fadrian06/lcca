<?php

namespace LCCA;

use Flight;
use PDO;

final class App extends Flight
{
  static function renderPage(
    string $pageName,
    string $title,
    string $layout,
    array $pageData = []
  ): void {
    Flight::render("pages/$pageName", $pageData, 'page');
    Flight::render("layouts/$layout", compact('title'));
  }

  static function db(): PDO {
    static $pdo = null;

    if (!$pdo) {
      $pdo = new PDO($_ENV['PDO_DSN'], $_ENV['PDO_USER'], $_ENV['PDO_PASSWORD'], [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
      ]);
    }

    return $pdo;
  }
}
