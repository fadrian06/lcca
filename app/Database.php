<?php

namespace LCCA;

use Error;
use PDO;

final class Database extends PDO
{
  static function autoConnect(): self
  {
    return new self($_ENV['PDO_DSN'], $_ENV['PDO_USER'], $_ENV['PDO_PASSWORD'], [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
  }

  function backup(): self
  {
    if (self::isSqlite()) {
      [, $dbPath] = explode('sqlite:', $_ENV['PDO_DSN']);

      copy($dbPath, "$dbPath.backup");
    } elseif (self::isMysql()) {
      $dbParams = explode(';', explode('mysql:', $_ENV['PDO_DSN'])[1]);

      foreach ($dbParams as $index => $param) {
        [$name, $value] = explode('=', $param);

        $dbParams[$name] = $value;
        unset($dbParams[$index]);
      }

      $backupPath = dirname(__DIR__) . '/db/backup.mysql.sql';
      exec("\"{$_ENV['MYSQLDUMP_PATH']}\" {$dbParams['dbname']} --user={$_ENV['PDO_USER']} --password={$_ENV['PDO_PASSWORD']}", $output);
      file_put_contents($backupPath, join(PHP_EOL, $output));
    } else {
      throw new Error('DB ' . explode(':', $_ENV['PDO_DSN'])[0] . ' backup not implemented');
    }

    return $this;
  }

  static function restore(): void
  {
    if (self::isSqlite()) {
      [, $dbPath] = explode('sqlite:', $_ENV['PDO_DSN']);
      $backupPath = "$dbPath.backup";

      copy($backupPath, $dbPath);
    } elseif (self::isMysql()) {
      $backupPath = dirname(__DIR__) . '/db/backup.mysql.sql';
      $database = self::autoConnect();

      $queries = explode(
        ';',
        file_get_contents($backupPath)
      );

      foreach ($queries as $query) {
        $database?->query($query);
      }
    } else {
      throw new Error('DB ' . explode(':', $_ENV['PDO_DSN'])[0] . ' backup not implemented');
    }
  }

  private static function isSqlite(): bool
  {
    return str_contains($_ENV['PDO_DSN'], 'sqlite');
  }

  private static function isMysql(): bool
  {
    return str_contains($_ENV['PDO_DSN'], 'mysql');
  }
}
