<?php

namespace LCCA;

use Flight;
use LCCA\Models\UserModel;

final class App extends Flight
{
  private static ?Database $db = null;

  static function renderPage(
    string $pageName,
    string $title,
    string $layout,
    array $pageData = []
  ): void {
    $pageData['lastData'] ??= (array) flash()->display('lastData');

    self::render("pages/$pageName", $pageData, 'page');
    self::render("layouts/$layout", compact('title'));
  }

  static function renderComponent(
    string $componentName,
    array $componentData = []
  ): void {
    self::render("components/$componentName", $componentData);
  }

  static function db(): Database
  {
    if (!self::$db) {
      self::$db = Database::autoConnect();
    }

    return self::$db;
  }

  static function restoreDb(): void
  {
    self::$db = null;

    Database::restore();
  }

  static function loggedUser(): ?UserModel
  {
    return self::view()->get('loggedUser');
  }
}
