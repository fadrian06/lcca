<?php

namespace LCCA\Models;

use LCCA\App;
use PDO;
use PDOException;
use Stringable;

final class SubjectModel implements Stringable
{
  private string $name;

  private function __construct(
    public readonly string $id,
    string $name,
    private ?string $imageUrl,
  ) {
    $this->name = mb_convert_case($name, MB_CASE_TITLE);
  }

  function getImageUrl(): ?string
  {
    return $this->imageUrl ?? './assets/images/subjects/no-image.png';
  }

  function delete(): self
  {
    $stmt = App::db()->prepare('DELETE FROM subjects WHERE id = ?');
    $stmt->execute([$this->id]);

    return $this;
  }

  function update(string $name, ?string $imageUrl): self
  {
    $this->name = mb_convert_case($name, MB_CASE_TITLE);

    if ($imageUrl) {
      $this->imageUrl = $imageUrl;
    }

    try {
      $stmt = App::db()->prepare('
        UPDATE subjects SET name = :newName, imageUrl = :newImageUrl
        WHERE id = :id
      ');

      $stmt->execute([
        ':id' => $this->id,
        ':newName' => $this->name,
        ':newImageUrl' => $this->imageUrl
      ]);
    } catch (PDOException $exception) {
      dd($exception);
    }

    return $this;
  }

  static function searchById(string $id): ?self
  {
    return self::searchByField('id', $id);
  }

  private static function searchByField(string $field, string $value): ?self
  {
    $stmt = App::db()->prepare("SELECT * FROM subjects WHERE $field = ?");
    $stmt->execute([$value]);
    $subjectData = $stmt->fetch() ?: null;

    if ($subjectData) {
      return self::mapper(
        $subjectData->id,
        $subjectData->name,
        $subjectData->imageUrl,
      );
    }

    return $subjectData;
  }

  /** @return self[] */
  static function all(): array
  {
    $stmt = App::db()->query('SELECT * FROM subjects');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_FUNC, [__CLASS__, 'mapper']);
  }

  static function create(
    string $name,
    ?string $imageUrl
  ): self {
    $subjectModel = new self(uniqid(), $name, $imageUrl ?: null);

    try {
      $stmt = App::db()->prepare('
        INSERT INTO subjects (id, name, imageUrl)
        VALUES (:id, :name, :imageUrl)
      ');

      $stmt->execute([
        ':id' => $subjectModel->id,
        ':name' => $subjectModel->name,
        ':imageUrl' => $subjectModel->imageUrl
      ]);
    } catch (PDOException $exception) {
      dd($exception);
    }

    return $subjectModel;
  }

  private static function mapper(
    string $id,
    string $name,
    ?string $imageUrl,
  ): self {
    return new self($id, $name, $imageUrl);
  }

  function __toString(): string
  {
    return $this->name;
  }
}
