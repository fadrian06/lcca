<?php

namespace LCCA\Models;

use Exception;
use LCCA\App;
use PDO;
use PDOException;
use Stringable;
use Throwable;

final class StudySectionModel implements Stringable
{
  private string $letter;
  private int $capacity;
  private StudyYearModel $studyYear;

  function __construct(
    public readonly string $id,
    string $letter,
    int $capacity,
    private bool $disabled,
  ) {
    $this->__set('letter', $letter);
    $this->capacity = $capacity;
  }

  function assignStudyYear(StudyYearModel $studyYear): self
  {
    $this->studyYear = $studyYear;

    return $this;
  }

  function getCapacity(): int
  {
    return $this->capacity;
  }

  function isActive(): bool
  {
    return !$this->disabled;
  }

  function canBeDeleted(): bool
  {
    return true;
  }

  function delete(): self
  {
    $stmt = App::db()->prepare('DELETE FROM studySections WHERE id = ?');
    $stmt->execute([$this->id]);

    return $this;
  }

  /** @throws Exception */
  function update(string $name, ?int $capacity, bool $disabled): self
  {
    $this->__set('name', $name);

    if ($capacity) {
      $this->capacity = $capacity;
    }

    $this->disabled = $disabled;

    try {
      $stmt = App::db()->prepare('
        UPDATE studySections SET letter = :letter,
        capacity = :capacity, disabled = :disabled
        WHERE id = :id
      ');

      $stmt->execute([
        ':id' => $this->id,
        ':letter' => $this->letter,
        ':capacity' => $this->capacity,
        ':disabled' => $this->disabled,
      ]);
    } catch (PDOException $exception) {
      throw self::handleError($exception);
    }

    return $this;
  }

  static function searchById(string $id): ?self
  {
    return self::searchByField('id', $id);
  }

  private static function searchByField(string $field, string $value): ?self
  {
    $stmt = App::db()->prepare("SELECT * FROM studySections WHERE $field = ?");
    $stmt->execute([$value]);
    $studySectionsData = $stmt->fetch() ?: null;

    if ($studySectionsData) {
      return self::mapper(
        $studySectionsData->id,
        $studySectionsData->letter,
        $studySectionsData->capacity,
        $studySectionsData->disabled
      );
    }

    return $studySectionsData;
  }

  /** @return self[] */
  static function all(): array
  {
    $stmt = App::db()->query('SELECT * FROM studySections');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_FUNC, [__CLASS__, 'mapper']);
  }

  static function create(string $letter, int $capacity, StudyYearModel $studyYear): self
  {
    $studySectionModel = new self(uniqid(), $letter, $capacity, false);
    $studySectionModel->assignStudyYear($studyYear);

    try {
      $stmt = App::db()->prepare('
        INSERT INTO studySections (id, letter, capacity, studyYear_id)
        VALUES (:id, :letter, :capacity, :studyYearId)
      ');

      $stmt->execute([
        ':id' => $studySectionModel->id,
        ':letter' => $studySectionModel->letter,
        ':capacity' => $studySectionModel->capacity,
        ':studyYearId' => $studySectionModel->studyYear->id
      ]);
    } catch (PDOException $exception) {
      throw self::handleError($exception);
    }

    return $studySectionModel;
  }

  private static function mapper(
    string $id,
    string $letter,
    int $capacity,
    bool $disabled
  ): self {
    return new self($id, $letter, $capacity, $disabled);
  }

  private static function handleError(Throwable $throwable): Throwable
  {
    return new Exception(match (true) {
      str_contains($throwable->getMessage(), 'letter') => 'Este año escolar ya tiene esta sección asignada',
      str_contains($throwable->getMessage(), 'capacity') => 'La capacidad no puede ser negativa',
      default => $throwable->getMessage()
    });
  }

  function __set(string $name, mixed $value): void
  {
    switch ($name) {
      case 'letter':
        [$this->letter] = mb_split('', mb_strtoupper($value));
        break;
    }
  }

  function __toString(): string
  {
    return $this->letter;
  }
}
