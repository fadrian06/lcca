<?php

namespace LCCA\Models;

use LCCA\App;
use LCCA\Enums\Role;
use PDO;
use PDOException;
use Stringable;

final class UserModel implements Stringable
{
  private string $name;

  private function __construct(
    public readonly string $id,
    string $name,
    private int $idCard,
    private string $password,
    private Role $role,
    private ?string $signatureImagePath,
    public readonly string $secretQuestion,
    private readonly string $secretAnswer
  ) {
    $this->name = mb_convert_case($name, MB_CASE_TITLE);
  }

  function isCorrectPassword(string $password): bool
  {
    return password_verify($password, $this->password);
  }

  function isCorrectSecretAnswer(string $secretAnswer): bool
  {
    return password_verify($secretAnswer, $this->secretAnswer);
  }

  function getIdCard(): int
  {
    return $this->idCard;
  }

  function getSignatureImagePath(): ?string
  {
    return $this->signatureImagePath;
  }

  function getRole(): string
  {
    return $this->role->value;
  }

  function haveSignature(): bool
  {
    return $this->signatureImagePath !== null;
  }

  function changePassword(string $newPassword): self
  {
    $this->password = password_hash($newPassword, PASSWORD_DEFAULT);

    try {
      $stmt = App::db()->prepare('
        UPDATE users SET password = :newPassword WHERE id = :id
      ');

      $stmt->execute([':id' => $this->id, ':newPassword' => $this->password]);
    } catch (PDOException $exception) {
      dd($exception);
    }

    return $this;
  }

  function updateProfile(
    string $name,
    int $idCard,
    string $signatureImagePath
  ): self {
    $this->name = mb_convert_case($name, MB_CASE_TITLE);
    $this->idCard = $idCard;
    $this->signatureImagePath = $signatureImagePath ?: null;

    try {
      $stmt = App::db()->prepare('
        UPDATE users SET name = :name, idCard = :idCard,
        signatureImagePath = :signatureImagePath WHERE id = :id
      ');

      $stmt->execute([
        ':id' => $this->id,
        ':name' => $this->name,
        ':idCard' => $this->idCard,
        ':signatureImagePath' => $this->signatureImagePath
      ]);
    } catch (PDOException $exception) {
      dd($exception);
    }

    return $this;
  }

  function delete(): void {
    $stmt = App::db()->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$this->id]);
  }

  static function create(
    string $name,
    int $idCard,
    string $password,
    string $role,
    string $secretQuestion,
    string $secretAnswer
  ): self {
    $userModel = new self(
      uniqid(),
      $name,
      $idCard,
      password_hash($password, PASSWORD_DEFAULT),
      Role::from($role),
      null,
      $secretQuestion,
      password_hash($secretAnswer, PASSWORD_DEFAULT)
    );

    try {
      $stmt = App::db()->prepare('
        INSERT INTO users(id, name, idCard, password, role, secretQuestion,
        secretAnswer) VALUES (:id, :name, :idCard, :password, :role,
        :secretQuestion, :secretAnswer)
      ');

      $stmt->execute([
        ':id' => $userModel->id,
        ':name' => $userModel->name,
        ':idCard' => $userModel->idCard,
        ':password' => $userModel->password,
        ':role' => $userModel->role->value,
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

  /** @return self[] */
  static function all(?Role $role = null): array
  {
    $query = $role
      ? 'SELECT * FROM users WHERE role = ?'
      : 'SELECT * FROM users';

    $stmt = App::db()->prepare($query);
    $stmt->execute([$role->value]);

    return $stmt->fetchAll(PDO::FETCH_FUNC, [__CLASS__, 'mapper']);
  }

  private static function searchByField(string $field, string $value): ?self
  {
    $stmt = App::db()->prepare("SELECT * FROM users WHERE $field = ?");
    $stmt->execute([$value]);
    $userData = $stmt->fetch() ?: null;

    if ($userData) {
      return self::mapper(
        $userData->id,
        $userData->name,
        $userData->idCard,
        $userData->password,
        $userData->role,
        $userData->signatureImagePath,
        $userData->secretQuestion,
        $userData->secretAnswer
      );
    }

    return $userData;
  }

  private static function mapper(
    string $id,
    string $name,
    int $idCard,
    string $password,
    string $role,
    ?string $signatureImagePath,
    string $secretQuestion,
    string $secretAnswer
  ): self {
    return new self(
      $id,
      $name,
      $idCard,
      $password,
      Role::from($role),
      $signatureImagePath,
      $secretQuestion,
      $secretAnswer
    );
  }

  function __toString(): string
  {
    return $this->name;
  }
}
