<?php

namespace LCCA\Models;

use DateTimeImmutable;
use DateTimeInterface;
use LCCA\App;
use LCCA\Enums\Disability;
use LCCA\Enums\DisabilityAssistance;
use LCCA\Enums\FederalEntity;
use LCCA\Enums\Genre;
use LCCA\Enums\IndigenousPeople;
use LCCA\Enums\Laterality;
use LCCA\Enums\Nationality;
use LCCA\Enums\Section;
use LCCA\Enums\ShirtSize;
use LCCA\Enums\StudyYear;
use PDO;
use PDOException;
use Stringable;

final readonly class StudentModel implements Stringable
{
  public string $names;
  public string $lastNames;
  public string $birthPlace;

  /** @var (Disability|string)[] */
  private array $disabilities;

  /** @var (DisabilityAssistance|string)[] */
  private array $disabilityAssistance;

  /** @var EnrollmentModel[] */
  private array $enrollments;

  /**
   * @param RepresentativeModel[] $representatives
   * @param SubjectModel[] $pendingSubjects
   */
  private function __construct(
    public string $id,
    private array $representatives,
    private Nationality $nationality,
    public int $idCard,
    string $names,
    string $lastNames,
    private DateTimeInterface $birthDate,
    string $birthPlace,
    private FederalEntity $federalEntity,
    private ?IndigenousPeople $indigenousPeople,
    public float $stature,
    public float $weight,
    public int $shoeSize,
    private ShirtSize $shirtSize,
    public int $pantsSize,
    private Laterality $laterality,
    private Genre $genre,
    public bool $hasBicentennialCollection,
    public bool $hasCanaima,
    private array $pendingSubjects,
    array $disabilities,
    array $disabilityAssistance,
    private ?DateTimeInterface $graduatedDate,
    private ?DateTimeInterface $retiredDate
  ) {
    $this->names = mb_convert_case($names, MB_CASE_TITLE);
    $this->lastNames = mb_convert_case($lastNames, MB_CASE_TITLE);
    $this->birthPlace = mb_convert_case($birthPlace, MB_CASE_TITLE);

    foreach ($disabilities as &$disability) {
      if (!is_null(Disability::tryFrom($disability))) {
        $disability = Disability::from($disability);
      }
    }

    foreach ($disabilityAssistance as &$assistance) {
      if (!is_null(DisabilityAssistance::tryFrom($assistance))) {
        $assistance = DisabilityAssistance::from($assistance);
      }
    }

    $this->disabilities = $disabilities;
    $this->disabilityAssistance = $disabilityAssistance;
    $this->enrollments = EnrollmentModel::allByStudent($this);

    foreach ($this->representatives as $representative) {
      $representative->represent($this);
    }
  }

  function currentRepresentative(): RepresentativeModel
  {
    return $this->representatives[0];
  }

  function isGraduated(): bool
  {
    return $this->graduatedDate !== null;
  }

  function isRetired(): bool
  {
    return $this->retiredDate !== null;
  }

  function getStudyYear(): StudyYear
  {
    return $this->enrollments[0]->studyYear;
  }

  function getSection(): Section
  {
    return $this->enrollments[0]->section;
  }

  /** @return self[] */
  static function all(): array
  {
    $stmt = App::db()->query('
      SELECT id, nationality, idCard, names, lastNames, birthDate, birthPlace,
      federalEntity, indigenousPeople, stature, weight, shoeSize, shirtSize,
      pantsSize, laterality, genre, hasBicentennialCollection, hasCanaima,
      disabilities, disabilityAssistance, graduatedDate, retiredDate
      FROM students
    ');

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_FUNC, [__CLASS__, 'mapper']);
  }

  static function create(
    RepresentativeModel $representative,
    string $nationality,
    int $idCard,
    string $names,
    string $lastNames,
    string $birthDate,
    string $birthPlace,
    string $federalEntity,
    ?string $indigenousPeople,
    float $stature,
    float $weight,
    int $shoeSize,
    string $shirtSize,
    int $pantsSize,
    string $laterality,
    string $genre,
    bool $hasBicentennialCollection,
    bool $hasCanaima,
    array $pendingSubjectsIds,
    array $disabilities,
    array $disabilityAssistance
  ): self {
    $graduatedDate = null;
    $retiredDate = null;

    $pendingSubjects = array_map(
      fn(string $subjectId): SubjectModel => SubjectModel::searchById($subjectId),
      $pendingSubjectsIds
    );

    $studentModel = new self(
      uniqid(),
      [$representative],
      Nationality::from($nationality),
      $idCard,
      $names,
      $lastNames,
      new DateTimeImmutable($birthDate),
      $birthPlace,
      FederalEntity::from($federalEntity),
      IndigenousPeople::tryFrom($indigenousPeople ?: ''),
      $stature,
      $weight,
      $shoeSize,
      ShirtSize::from($shirtSize),
      $pantsSize,
      Laterality::from($laterality),
      Genre::from($genre),
      $hasBicentennialCollection,
      $hasCanaima,
      $pendingSubjects,
      $disabilities,
      $disabilityAssistance,
      $graduatedDate,
      $retiredDate
    );

    App::db()->beginTransaction();

    try {
      $stmt = App::db()->prepare('
        INSERT INTO students(id, nationality, idCard, names, lastNames,
        birthDate, birthPlace, federalEntity, indigenousPeople, stature, weight,
        shoeSize, shirtSize, pantsSize, laterality, genre,
        hasBicentennialCollection, hasCanaima, disabilities,
        disabilityAssistance) VALUES (:id, :nationality, :idCard, :names,
        :lastNames, :birthDate, :birthPlace, :federalEntity, :indigenousPeople,
        :stature, :weight, :shoeSize, :shirtSize, :pantsSize, :laterality,
        :genre, :hasBicentennialCollection, :hasCanaima, :disabilities,
        :disabilityAssistance)
      ');

      $stmt->execute([
        ':id' => $studentModel->id,
        ':nationality' => $studentModel->nationality->value,
        ':idCard' => $studentModel->idCard,
        ':names' => $studentModel->names,
        ':lastNames' => $studentModel->lastNames,
        ':birthDate' => $studentModel->birthDate->format('Y-m-d'),
        ':birthPlace' => $studentModel->birthPlace,
        ':federalEntity' => $studentModel->federalEntity->value,
        ':indigenousPeople' => $studentModel->indigenousPeople?->value,
        ':stature' => $studentModel->stature,
        ':weight' => $studentModel->weight,
        ':shoeSize' => $studentModel->shoeSize,
        ':shirtSize' => $studentModel->shirtSize->value,
        ':pantsSize' => $studentModel->pantsSize,
        ':laterality' => $studentModel->laterality->value,
        ':genre' => $studentModel->genre->value,
        ':hasBicentennialCollection' => $studentModel->hasBicentennialCollection,
        ':hasCanaima' => $studentModel->hasCanaima,
        ':disabilities' => json_encode(array_map(static fn(Disability|string $disability): string => is_string($disability) ? $disability : $disability->value, $studentModel->disabilities)),
        ':disabilityAssistance' => json_encode(array_map(static fn(DisabilityAssistance|string $assistance): string => is_string($assistance) ? $assistance : $assistance->value, $studentModel->disabilityAssistance)),
      ]);

      if ($studentModel->pendingSubjects !== []) {
        $pendingSubjectsValues = array_map(
          fn(SubjectModel $subjectModel): string => "('$studentModel->id', '$subjectModel->id')",
          $studentModel->pendingSubjects
        );

        $shortQuery = 'INSERT INTO pendingSubjects VALUES %s';
        $fullQuery = sprintf($shortQuery, join(',', $pendingSubjectsValues));
        $stmt = App::db()->prepare($fullQuery);
        $stmt->execute();
      }

      $stmt = App::db()->prepare('
        INSERT INTO representativeHistory (student_id, representative_id)
        VALUES (:studentId, :representativeId)
      ');

      $stmt->execute([
        ':studentId' => $studentModel->id,
        ':representativeId' => $representative->id
      ]);

      App::db()->commit();
    } catch (PDOException $exception) {
      App::db()->rollBack();

      dd($exception);
    }

    return $studentModel;
  }

  function enroll(
    int $studyYear,
    string $section,
    string $teacherId,
    string $date
  ): EnrollmentModel {
    return EnrollmentModel::create(
      $this,
      $studyYear,
      $section,
      $teacherId,
      $date
    );
  }

  static function searchById(string $id): ?self
  {
    return self::searchByField('id', $id);
  }

  private static function searchByField(string $field, string $value): ?self
  {
    $stmt = App::db()->prepare("SELECT * FROM students WHERE $field = ?");
    $stmt->execute([$value]);
    $studentData = $stmt->fetch() ?: null;

    if ($studentData) {
      return self::mapper(
        $studentData->id,
        $studentData->nationality,
        $studentData->idCard,
        $studentData->names,
        $studentData->lastNames,
        $studentData->birthDate,
        $studentData->birthPlace,
        $studentData->federalEntity,
        $studentData->indigenousPeople,
        $studentData->stature,
        $studentData->weight,
        $studentData->shoeSize,
        $studentData->shirtSize,
        $studentData->pantsSize,
        $studentData->laterality,
        $studentData->genre,
        $studentData->hasBicentennialCollection,
        $studentData->hasCanaima,
        $studentData->disabilities,
        $studentData->disabilityAssistance,
        $studentData->graduatedDate,
        $studentData->retiredDate
      );
    }

    return $studentData;
  }

  private static function mapper(
    string $id,
    string $nationality,
    int $idCard,
    string $names,
    string $lastNames,
    string $birthDate,
    string $birthPlace,
    string $federalEntity,
    ?string $indigenousPeople,
    float $stature,
    float $weight,
    int $shoeSize,
    string $shirtSize,
    int $pantsSize,
    string $laterality,
    string $genre,
    bool $hasBicentennialCollection,
    bool $hasCanaima,
    string $disabilities,
    string $disabilityAssistance,
    ?string $graduatedDate,
    ?string $retiredDate
  ): self {
    $stmt = App::db()->query('SELECT subject_id FROM pendingSubjects');

    $pendingSubjects = $stmt->fetchAll(
      PDO::FETCH_FUNC,
      fn(string $subjectId): SubjectModel => SubjectModel::searchById($subjectId)
    );

    $stmt = App::db()->prepare('
      SELECT representative_id FROM representativeHistory
      WHERE student_id = ? ORDER BY id DESC
    ');

    $stmt->execute([$id]);

    $representatives = $stmt->fetchAll(
      PDO::FETCH_FUNC,
      fn(string $representativeId): RepresentativeModel => RepresentativeModel::searchById($representativeId)
    );

    return new self(
      $id,
      $representatives,
      Nationality::from($nationality),
      $idCard,
      $names,
      $lastNames,
      new DateTimeImmutable($birthDate),
      $birthPlace,
      FederalEntity::from($federalEntity),
      IndigenousPeople::tryFrom($indigenousPeople ?: ''),
      $stature,
      $weight,
      $shoeSize,
      ShirtSize::from($shirtSize),
      $pantsSize,
      Laterality::from($laterality),
      Genre::from($genre),
      $hasBicentennialCollection,
      $hasCanaima,
      $pendingSubjects,
      json_decode($disabilities, true),
      json_decode($disabilityAssistance, true),
      $graduatedDate ? new DateTimeImmutable($graduatedDate) : null,
      $retiredDate ? new DateTimeImmutable($retiredDate) : null
    );
  }

  function __toString(): string
  {
    [$firstName] = explode(' ', $this->names);
    [$firstLastName] = explode(' ', $this->lastNames);

    return "$firstName $firstLastName";
  }
}
