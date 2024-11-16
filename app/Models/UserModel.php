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
    public int $idCard,
    private string $password,
    public string $secretQuestion,
    private string $secretAnswer
  ) {
    $this->name = mb_convert_case($name, MB_CASE_TITLE);
  }

  function isCorrectPassword(string $password): bool
  {
    return password_verify($password, $this->password);
  }

  static function create(
    string $name,
    int $idCard,
    string $password,
    string $secretQuestion,
    string $secretAnswer
  ): self {
    $userModel = new self(
      uniqid(),
      $name,
      $idCard,
      password_hash($password, PASSWORD_DEFAULT),
      $secretQuestion,
      password_hash($secretAnswer, PASSWORD_DEFAULT)
    );

    try {
      $stmt = App::db()->prepare('
        INSERT INTO users(id, name, idCard, password, secretQuestion,
        secretAnswer) VALUES (:id, :name, :idCard, :password, :secretQuestion,
        :secretAnswer)
      ');

      $stmt->execute([
        ':id' => $userModel->id,
        ':name' => $userModel->name,
        ':idCard' => $userModel->idCard,
        ':password' => $userModel->password,
        ':secretQuestion' => $userModel->secretQuestion,
        ':secretAnswer' => $userModel->secretAnswer
      ]);
    } catch (PDOException $exception) {
      dd($exception);
    }

    return $userModel;
  }

  static function searchByIdCard(int $idCard): ?self
  {
    return self::searchByField('idCard', $idCard);
  }

  static function searchById(string $id): ?self
  {
    return self::searchByField('id', $id);
  }

  private static function searchByField(string $field, string $value): ?self
  {
    $stmt = App::db()->prepare("
      SELECT id, name, idCard, password, secretQuestion, secretAnswer FROM users
      WHERE $field = ?
    ");

    $stmt->execute([$value]);
    $userData = $stmt->fetch() ?: null;

    if ($userData) {
      $userData = new self(
        $userData->id,
        $userData->name,
        $userData->idCard,
        $userData->password,
        $userData->secretQuestion,
        $userData->secretAnswer
      );
    }

    return $userData;
  }

  function __toString(): string
  {
    return $this->name;
  }
}
