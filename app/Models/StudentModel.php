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

/**
 * @property-read string $fullName
 * @property-read bool $isGraduated
 * @property-read bool $isRetired
 * @property-read StudyYear $studyYear
 * @property-read Section $studySection
 * @property-read RepresentativeModel $currentRepresentative
 * @property-read string $fullIdCard
 * @property-read DateTimeInterface $birthDate
 * @property-read ?string $otherDisabilityAssistance
 * @property-read ?DateTimeInterface $graduatedDate
 * @property-read bool $canGraduate
 * @property-read int $progressPercent
 * @property-read ?DateTimeInterface $retiredDate
 * @property-read RepresentativeModel[] $representatives
 * @property-read int $age
 * @property-read (Disability|string)[] $disabilities
 * @property-read (DisabilityAssistance|string)[] $disabilityAssistance
 * @property-read string $fullBirthPlace
 * @property-read ?IndigenousPeople $indigenousPeople
 * @property-read float $stature
 * @property-read float $weight
 * @property-read int $shoeSize
 * @property-read ShirtSize $shirtSize
 * @property-read int $pantsSize
 * @property-read Laterality $laterality
 * @property-read Genre $genre
 * @property-read bool $hasBicentennialCollection
 * @property-read bool $hasCanaima
 * @property-read SubjectModel[] $pendingSubjects
 * @property-read bool $isMale
 * @property-read bool $isFemale
 * @property-read int $idCard
 * @property-read string $names
 * @property-read string $lastNames
 * @property-read string $birthPlace
 */
final class StudentModel implements Stringable
{
  private string $names;
  private string $lastNames;
  private string $birthPlace;
  private array $disabilities;
  private array $disabilityAssistance;

  /** @var EnrollmentModel[] */
  private array $enrollments;

  /**
   * @param RepresentativeModel[] $representatives
   * @param SubjectModel[] $pendingSubjects
   */
  private function __construct(
    public readonly string $id,
    private array $representatives,
    private Nationality $nationality,
    private int $idCard,
    string $names,
    string $lastNames,
    private DateTimeInterface $birthDate,
    string $birthPlace,
    private FederalEntity $federalEntity,
    private ?IndigenousPeople $indigenousPeople,
    private float $stature,
    private float $weight,
    private int $shoeSize,
    private ShirtSize $shirtSize,
    private int $pantsSize,
    private Laterality $laterality,
    private Genre $genre,
    private bool $hasBicentennialCollection,
    private bool $hasCanaima,
    private array $pendingSubjects,
    array $disabilities,
    array $disabilityAssistance,
    private ?DateTimeInterface $graduatedDate,
    private ?DateTimeInterface $retiredDate
  ) {
    $this->__set('names', $names);
    $this->__set('lastNames', $lastNames);
    $this->__set('birthPlace', $birthPlace);
    $this->__set('disabilities', $disabilities);
    $this->__set('disabilityAssistance', $disabilityAssistance);
    $this->enrollments = EnrollmentModel::allByStudent($this);

    foreach ($this->representatives as $representative) {
      $representative->represent($this);
    }
  }

  function isFromNationality(Nationality $nationality): bool
  {
    return $this->nationality === $nationality;
  }

  function isFromFederalEntity(FederalEntity $federalEntity): bool
  {
    return $this->federalEntity === $federalEntity;
  }

  function isAGenre(Genre $genre): bool
  {
    return $this->genre === $genre;
  }

  function hasPendingSubject(SubjectModel $subject): bool
  {
    return array_any(
      $this->pendingSubjects,
      fn(SubjectModel $pendingSubject): bool => $pendingSubject->id === $subject->id
    );
  }

  function hasDisability(Disability $disability): bool
  {
    return array_any(
      $this->disabilities,
      fn(Disability|string $studentDisability): bool => $studentDisability === $disability
    );
  }

  function hasDisabilityAssistance(null|string|DisabilityAssistance $assistance = null): bool
  {
    if ($assistance) {
      return array_any(
        $this->disabilityAssistance,
        fn(string|DisabilityAssistance $studentDisabilityAssistance): bool => $studentDisabilityAssistance === $assistance
      );
    }

    return $this->disabilityAssistance !== [];
  }

  function isIndigenous(null|string|IndigenousPeople $indigenousPeople = null): bool
  {
    if (is_string($indigenousPeople)) {
      $indigenousPeople = IndigenousPeople::from($indigenousPeople);
    }

    if ($indigenousPeople instanceof IndigenousPeople) {
      return $this->indigenousPeople === $indigenousPeople;
    }

    return $this->indigenousPeople !== null;
  }

  function isShirtSize(ShirtSize $shirtSize): bool
  {
    return $this->shirtSize === $shirtSize;
  }

  function hasLaterality(Laterality $laterality): bool
  {
    return $this->laterality === $laterality;
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

  function update(
    RepresentativeModel $newOrUpdatedRepresentative,
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
    $this->__set('nationality', $nationality);
    $this->idCard = $idCard;
    $this->__set('names', $names);
    $this->__set('lastNames', $lastNames);
    $this->__set('birthDate', $birthDate);
    $this->__set('birthPlace', $birthPlace);
    $this->__set('federalEntity', $federalEntity);
    $this->__set('indigenousPeople', $indigenousPeople);
    $this->stature = $stature;
    $this->weight = $weight;
    $this->shoeSize = $shoeSize;
    $this->__set('shirtSize', $shirtSize);
    $this->pantsSize = $pantsSize;
    $this->__set('laterality', $laterality);
    $this->__set('genre', $genre);
    $this->hasBicentennialCollection = $hasBicentennialCollection;
    $this->hasCanaima = $hasCanaima;
    $this->__set('pendingSubjects', $pendingSubjectsIds);
    $this->__set('disabilities', $disabilities);
    $this->__set('disabilityAssistance', $disabilityAssistance);

    App::db()->beginTransaction();

    try {
      $stmt = App::db()->prepare('
        UPDATE students SET nationality = :nationality, idCard = :idCard,
        names = :names, lastNames = :lastNames, birthDate = :birthDate,
        birthPlace = :birthPlace, federalEntity = :federalEntity,
        indigenousPeople = :indigenousPeople, stature = :stature,
        weight = :weight, shoeSize = :shoeSize, shirtSize = :shirtSize,
        pantsSize = :pantsSize, laterality = :laterality, genre = :genre,
        hasBicentennialCollection = :hasBicentennialCollection,
        hasCanaima = :hasCanaima, disabilities = :disabilities,
        disabilityAssistance = :disabilityAssistance WHERE id = :id
      ');

      $stmt->execute([
        ':nationality' => $this->nationality->value,
        ':idCard' => $this->idCard,
        ':names' => $this->names,
        ':lastNames' => $this->lastNames,
        ':birthDate' => $this->birthDate->format('Y-m-d'),
        ':birthPlace' => $this->birthPlace,
        ':federalEntity' => $this->federalEntity->value,
        ':indigenousPeople' => $this->indigenousPeople?->value,
        ':stature' => $this->stature,
        ':weight' => $this->weight,
        ':shoeSize' => $this->shoeSize,
        ':shirtSize' => $this->shirtSize->value,
        ':pantsSize' => $this->pantsSize,
        ':laterality' => $this->laterality->value,
        ':genre' => $this->genre->value,
        ':hasBicentennialCollection' => $this->hasBicentennialCollection,
        ':hasCanaima' => $this->hasCanaima,
        ':disabilities' => json_encode(array_map(static fn(Disability|string $disability): string => is_string($disability) ? $disability : $disability->value, $this->disabilities)),
        ':disabilityAssistance' => json_encode(array_map(static fn(DisabilityAssistance|string $assistance): string => is_string($assistance) ? $assistance : $assistance->value, $this->disabilityAssistance)),
        ':id' => $this->id
      ]);

      if ($this->pendingSubjects !== []) {
        $pendingSubjectsValues = array_map(
          fn(SubjectModel $subjectModel): string => "('$this->id', '$subjectModel->id')",
          $this->pendingSubjects
        );

        $shortQuery = 'INSERT INTO pendingSubjects VALUES %s';
        $fullQuery = sprintf($shortQuery, join(',', $pendingSubjectsValues));
        $stmt = App::db()->prepare($fullQuery);
        $stmt->execute();
      }

      // Check if $newOrUpdatedRepresentative is already in $this->representatives to create another row in representativeHistory
      if (!array_any(
        $this->representatives,
        fn(RepresentativeModel $representative): bool => $representative->id === $newOrUpdatedRepresentative->id
      )) {
        $stmt = App::db()->prepare('
          INSERT INTO representativeHistory (student_id, representative_id)
          VALUES (:studentId, :representativeId)
        ');

        $stmt->execute([
          ':studentId' => $this->id,
          ':representativeId' => $newOrUpdatedRepresentative->id
        ]);
      }

      $newOrUpdatedRepresentative->represent($this);

      App::db()->commit();
    } catch (PDOException $exception) {
      App::db()->rollBack();

      dd($exception);
    }

    return $this;
  }

  function enroll(
    int $studyYear,
    string $section,
    string $teacherId,
    string $date
  ): EnrollmentModel {
    $this->graduatedDate = null;
    $this->retiredDate = null;

    $stmt = App::db()->prepare('
      UPDATE students
      SET graduatedDate = NULL, retiredDate = NULL
      WHERE id = ?
    ');

    $stmt->execute([$this->id]);

    return EnrollmentModel::create(
      $this,
      $studyYear,
      $section,
      $teacherId,
      $date
    );
  }

  function graduate(): self
  {
    $this->graduatedDate = new DateTimeImmutable();

    $stmt = App::db()->prepare('
      UPDATE students
      SET graduatedDate = :graduatedDate
      WHERE id = :id
    ');

    $stmt->execute([
      ':id' => $this->id,
      ':graduatedDate' => $this->graduatedDate->format('Y-m-d')
    ]);

    return $this;
  }

  function retire(): self
  {
    $this->retiredDate = new DateTimeImmutable();

    $stmt = App::db()->prepare('
      UPDATE students
      SET retiredDate = :retiredDate
      WHERE id = :id
    ');

    $stmt->execute([
      ':id' => $this->id,
      ':retiredDate' => $this->retiredDate->format('Y-m-d')
    ]);

    return $this;
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

  function __get(string $name): mixed
  {
    return match ($name) {
      'fullName' => "$this->names $this->lastNames",
      'address' => $this->currentRepresentative->address,
      'isGraduated' => $this->graduatedDate !== null,
      'isRetired' => $this->retiredDate !== null,
      'studyYear' => $this->enrollments[count($this->enrollments) - 1]->studyYear,
      'studySection' => $this->enrollments[count($this->enrollments) - 1]->section,
      'currentRepresentative' => $this->representatives[0],
      'fullIdCard' => strtoupper($this->nationality->value . $this->idCard),
      'birthDate' => $this->birthDate,
      'otherDisabilityAssistance' => array_filter(
        $this->disabilityAssistance,
        fn(string|DisabilityAssistance $studentDisabilityAssistance): bool => is_string($studentDisabilityAssistance)
      )[0] ?? null,
      'graduatedDate' => $this->graduatedDate,
      'canGraduate' => $this->studyYear->isFifthYear()
        && !$this->isGraduated
        && !$this->isRetired,
      'progressPercent' => $this->isGraduated ? 100 : $this->studyYear->getProgressPercent(),
      'retiredDate' => $this->retiredDate,
      'representatives' => $this->representatives,
      'age' => $this->birthDate->diff(new DateTimeImmutable())->y,
      'disabilities' => $this->disabilities,
      'disabilityAssistance' => $this->disabilityAssistance,
      'fullBirthPlace' => "$this->birthPlace, {$this->federalEntity->fullValue()}",
      'indigenousPeople' => $this->indigenousPeople,
      'stature' => $this->stature,
      'weight' => $this->weight,
      'shoeSize' => $this->shoeSize,
      'shirtSize' => $this->shirtSize,
      'pantsSize' => $this->pantsSize,
      'laterality' => $this->laterality,
      'genre' => $this->genre,
      'hasBicentennialCollection' => $this->hasBicentennialCollection,
      'hasCanaima' => $this->hasCanaima,
      'pendingSubjects' => $this->pendingSubjects,
      'isMale' => $this->genre->isMale(),
      'isFemale' => $this->genre->isFemale(),
      'idCard' => $this->idCard,
      'names' => $this->names,
      'lastNames' => $this->lastNames,
      'birthPlace' => $this->birthPlace,
      default => null,
    };
  }

  function __set(string $name, mixed $value): void
  {
    switch ($name) {
      case 'nationality':
        $this->nationality = Nationality::from($value);
        break;
      case 'names':
      case 'lastNames':
      case 'birthPlace':
        $this->$name = mb_convert_case($value, MB_CASE_TITLE);
        break;
      case 'birthDate':
        $this->birthDate = new DateTimeImmutable($value);
        break;
      case 'federalEntity':
        $this->federalEntity = FederalEntity::from($value);
        break;
      case 'disabilities':
        foreach ($value as &$disability) {
          if (!is_null(Disability::tryFrom($disability))) {
            $disability = Disability::from($disability);
          }
        }

        $this->disabilities = $value;
        break;
      case 'disabilityAssistance':
        foreach ($value as &$assistance) {
          if (!is_null(DisabilityAssistance::tryFrom($assistance))) {
            $assistance = DisabilityAssistance::from($assistance);
          }
        }

        $this->disabilityAssistance = $value;
        break;
      case 'indigenousPeople':
        $this->indigenousPeople = IndigenousPeople::tryFrom($value ?: '');
        break;
      case 'shirtSize':
        $this->shirtSize = ShirtSize::from($value);
        break;
      case 'laterality':
        $this->laterality = Laterality::from($value);
        break;
      case 'genre':
        $this->genre = Genre::from($value);
        break;
      case 'pendingSubjects':
        $this->pendingSubjects = array_map(
          fn(string $subjectId): SubjectModel => SubjectModel::searchById($subjectId),
          $value
        );
    }
  }
}
