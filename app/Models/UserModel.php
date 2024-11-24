<?php

namespace LCCA\Models;

use DateTimeImmutable;
use DateTimeInterface;
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
    private ?string $signatureBase64,
    private string $secretQuestion,
    private string $secretAnswer,
    private ?DateTimeInterface $deletedDate
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

  function getSignatureUrl(): ?string
  {
    return "data:image/jpg;base64,$this->signatureBase64";
  }

  function getRole(): string
  {
    return $this->role->value;
  }

  function getSecretQuestion(): string
  {
    return $this->secretQuestion;
  }

  function hasSignature(): bool
  {
    return $this->signatureBase64 !== null;
  }

  function isDeleted(): bool
  {
    return $this->deletedDate !== null;
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
    ?string $signatureBase64,
    string $secretQuestion,
    ?string $secretAnswer
  ): self {
    $this->name = mb_convert_case($name, MB_CASE_TITLE);
    $this->idCard = $idCard;
    $this->secretQuestion = $secretQuestion;

    if ($signatureBase64) {
      $this->signatureBase64 = $signatureBase64;
    }

    if ($secretAnswer) {
      $this->secretAnswer = password_hash($secretAnswer, PASSWORD_DEFAULT);
    }

    try {
      $stmt = App::db()->prepare('
        UPDATE users SET name = :name, idCard = :idCard,
        signature = :signature, secretQuestion = :secretQuestion,
        secretAnswer = :secretAnswer
        WHERE id = :id
      ');

      $stmt->execute([
        ':id' => $this->id,
        ':name' => $this->name,
        ':idCard' => $this->idCard,
        ':signature' => $this->signatureBase64,
        ':secretQuestion' => $this->secretQuestion,
        ':secretAnswer' => $this->secretAnswer
      ]);
    } catch (PDOException $exception) {
      dd($exception);
    }

    return $this;
  }

  function delete(): void
  {
    $this->deletedDate = new DateTimeImmutable;

    $stmt = App::db()->prepare('
      UPDATE users SET deletedDate = :deletedDate
      WHERE id = :id
    ');

    $stmt->execute([
      ':id' => $this->id,
      ':deletedDate' => $this->deletedDate->format('Y-m-d')
    ]);
  }

  static function create(
    string $name,
    int $idCard,
    string $password,
    string $role,
    string $secretQuestion,
    string $secretAnswer
  ): self {
    $signatureBase64 = null;
    $deletedDate = null;

    $userModel = new self(
      uniqid(),
      $name,
      $idCard,
      password_hash($password, PASSWORD_DEFAULT),
      Role::from($role),
      $signatureBase64,
      $secretQuestion,
      password_hash($secretAnswer, PASSWORD_DEFAULT),
      $deletedDate
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
      ? 'SELECT * FROM users WHERE role = ? AND deletedDate IS NULL'
      : 'SELECT * FROM users WHERE deletedDate IS NULL';

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
        $userData->signature,
        $userData->secretQuestion,
        $userData->secretAnswer,
        $userData->deletedDate
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
    ?string $signature,
    string $secretQuestion,
    string $secretAnswer,
    ?string $deletedDate
  ): self {
    return new self(
      $id,
      $name,
      $idCard,
      $password,
      Role::from($role),
      $signature,
      $secretQuestion,
      $secretAnswer,
      $deletedDate ? new DateTimeImmutable($deletedDate) : null
    );
  }

  function __toString(): string
  {
    return $this->name;
  }
}
