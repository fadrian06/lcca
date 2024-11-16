<?php

namespace LCCA\Models;

use LCCA\App;
use PDOException;
use Stringable;

final readonly class UserModel implements Stringable
{
  public string $name;

  private function __construct(
    public string $id,
    string $name,
    public string $email,
    private string $password
  ) {
    $this->name = mb_convert_case($name, MB_CASE_TITLE);
  }

  function isCorrectPassword(string $password): bool
  {
    return password_verify($password, $this->password);
  }

  static function create(string $name, string $email, string $password): self
  {
    $userModel = new self(
      uniqid(),
      $name,
      $email,
      password_hash($password, PASSWORD_DEFAULT)
    );

    try {
      $stmt = App::db()->prepare('
        INSERT INTO users(id, name, email, password)
        VALUES (:id, :name, :email, :password)
      ');

      $stmt->execute([
        ':id' => $userModel->id,
        ':name' => $userModel->name,
        ':email' => $userModel->email,
        ':password' => $userModel->password
      ]);
    } catch (PDOException $exception) {
      dd($exception);
    }

    return $userModel;
  }

  static function searchByEmail(string $email): ?self
  {
    return self::searchByField('email', $email);
  }

  static function searchById(string $id): ?self
  {
    return self::searchByField('id', $id);
  }

  private static function searchByField(string $field, string $value): ?self
  {
    $stmt = App::db()->prepare("
      SELECT id, name, email, password FROM users
      WHERE $field = ?
    ");

    $stmt->execute([$value]);
    $userData = $stmt->fetch() ?: null;

    if ($userData) {
      $userData = new self(
        $userData->id,
        $userData->name,
        $userData->email,
        $userData->password
      );
    }

    return $userData;
  }

  function __toString(): string
  {
    return $this->name;
  }
}
