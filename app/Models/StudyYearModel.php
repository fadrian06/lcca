<?php

namespace LCCA\Models;

use Exception;
use LCCA\App;
use PDO;
use PDOException;
use Stringable;
use Throwable;

final class StudyYearModel implements Stringable
{
  private string $name;

  /** @param StudySectionModel[] $sections */
  private function __construct(
    public readonly string $id,
    private array $sections,
    string $name,
    private int $ordinal,
    private bool $disabled
  ) {
    $this->__set('name', $name);

    foreach ($this->sections as $section) {
      $section->assignStudyYear($this);
    }
  }

  function delete(): self
  {
    $stmt = App::db()->prepare('DELETE FROM studyYears WHERE id = ?');
    $stmt->execute([$this->id]);

    return $this;
  }

  /** @throws Exception */
  function update(string $name, ?int $ordinal): self
  {
    $this->__set('name', $name);

    if ($ordinal) {
      $this->ordinal = $ordinal;
    }

    try {
      $stmt = App::db()->prepare('
        UPDATE studyYears SET name = :name, ordinal = :ordinal
        WHERE id = :id
      ');

      $stmt->execute([
        ':id' => $this->id,
        ':name' => $this->name,
        ':ordinal' => $this->ordinal
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
    $stmt = App::db()->prepare("SELECT * FROM studyYears WHERE $field = ?");
    $stmt->execute([$value]);
    $studyYearData = $stmt->fetch() ?: null;

    if ($studyYearData) {
      return self::mapper(
        $studyYearData->id,
        $studyYearData->name,
        $studyYearData->ordinal,
        $studyYearData->disabled
      );
    }

    return $studyYearData;
  }

  /** @return self[] */
  static function all(): array
  {
    $stmt = App::db()->query('SELECT * FROM studyYears');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_FUNC, [__CLASS__, 'mapper']);
  }

  /** @param array{letter: string, capacity: int}[] $sections */
  static function create(string $name, int $ordinal, array $sections): self
  {
    $studyYearModel = new self(uniqid(), [], $name, $ordinal, false);

    try {
      App::db()->beginTransaction();

      $stmt = App::db()->prepare('
        INSERT INTO studyYears (id, name, ordinal)
        VALUES (:id, :name, :ordinal)
      ');

      $stmt->execute([
        ':id' => $studyYearModel->id,
        ':name' => $studyYearModel->name,
        ':ordinal' => $studyYearModel->ordinal
      ]);

      $sectionsModels = array_map(
        static fn(array $section): StudySectionModel => StudySectionModel::create(
          $section['letter'],
          $section['capacity'],
          $studyYearModel
        ),
        $sections
      );

      $studyYearModel->sections = $sectionsModels;

      App::db()->commit();
    } catch (PDOException $exception) {
      App::db()->rollBack();

      throw self::handleError($exception);
    }

    return $studyYearModel;
  }

  private static function mapper(
    string $id,
    string $name,
    int $ordinal,
    bool $disabled
  ): self {
    $stmt = App::db()->query('SELECT id FROM studySections WHERE studyYear_id = ?');
    $stmt->execute([$id]);

    $sections = array_map(
      static fn(object $studySection): StudySectionModel => StudySectionModel::searchById($studySection->id),
      $stmt->fetchAll()
    );

    return new self($id, $sections, $name, $ordinal, $disabled);
  }

  private static function handleError(Throwable $throwable): Throwable
  {
    return new Exception(match (true) {
      str_contains($throwable->getMessage(), 'name') => 'El nombre ya está en uso.',
      str_contains($throwable->getMessage(), 'ordinal') => 'El ordinal ya está en uso.',
      default => $throwable->getMessage()
    });
  }

  function __set(string $name, mixed $value): void
  {
    switch ($name) {
      case 'name':
        [$this->name] = explode(' ', mb_ucfirst($value));
        break;
    }
  }

  function __toString(): string
  {
    return "{$this->ordinal}° año";
  }
}
