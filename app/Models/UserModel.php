<?php

namespace LCCA\Models;

use Exception;
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
    private bool $active
  ) {
    $this->name = mb_convert_case($name, MB_CASE_TITLE);
  }

  function isCoordinator(): bool
  {
    return $this->role === Role::Coordinator;
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

  function disable(): self
  {
    $this->active = false;

    try {
      $stmt = App::db()->prepare('
        UPDATE users SET active = :active WHERE id = :id
      ');

      $stmt->execute([':id' => $this->id, ':active' => $this->active]);
    } catch (PDOException $exception) {
      dd($exception);
    }

    return $this;
  }

  function isActive(): bool
  {
    return $this->active;
  }

  /** @throws Exception */
  static function create(
    string $name,
    int $idCard,
    string $password,
    string $role,
    string $secretQuestion,
    string $secretAnswer
  ): self {
    $signatureBase64 = null;

    $userModel = new self(
      uniqid(),
      $name,
      $idCard,
      password_hash($password, PASSWORD_DEFAULT),
      Role::from($role),
      $signatureBase64,
      $secretQuestion,
      password_hash($secretAnswer, PASSWORD_DEFAULT),
      true
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
      throw new Exception(match (true) {
        str_contains($exception->getMessage(), 'UNIQUE') && str_contains($exception->getMessage(), 'idCard') => 'La cédula ya está registrada',
        default => $exception->getMessage()
      });
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
  static function all(): array
  {
    $stmt = App::db()->query('SELECT * FROM users');

    return $stmt->fetchAll(PDO::FETCH_FUNC, [__CLASS__, 'mapper']);
  }

  static function allByRole(Role $role): array
  {
    $stmt = App::db()->prepare('SELECT * FROM users WHERE role = ?');
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
        $userData->active
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
    bool $active
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
      $active
    );
  }

  function __toString(): string
  {
    return $this->name;
  }
}
