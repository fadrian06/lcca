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
use LCCA\Enums\ShirtSize;
use LCCA\Enums\StudentStatus;
use LCCA\Enums\Subject;
use PDOException;

final readonly class StudentModel
{
  public string $names;
  public string $lastNames;
  public string $birthPlace;

  /** @var Subject[] */
  private array $pendingSubjects;

  /** @var (Disability|string)[] */
  private array $disabilities;

  /** @var (DisabilityAssistance|string)[] */
  private array $disabilityAssistance;

  private function __construct(
    public string $id,
    public RepresentativeModel $representative,
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
    public bool $haveBicentennialCollection,
    public bool $haveCanaima,
    array $pendingSubjects,
    array $disabilities,
    array $disabilityAssistance,
    private StudentStatus $status
  ) {
    $this->names = mb_convert_case($names, MB_CASE_TITLE);
    $this->lastNames = mb_convert_case($lastNames, MB_CASE_TITLE);
    $this->birthPlace = mb_convert_case($birthPlace, MB_CASE_TITLE);

    foreach ($pendingSubjects as &$subject) {
      if (!is_null(Subject::tryFrom($subject))) {
        $subject = Subject::from($subject);
      }
    }

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

    $this->pendingSubjects = $pendingSubjects;
    $this->disabilities = $disabilities;
    $this->disabilityAssistance = $disabilityAssistance;
    $representative->represent($this);
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
    bool $haveBicentennialCollection,
    bool $haveCanaima,
    array $pendingSubjects,
    array $disabilities,
    array $disabilityAssistance
  ): self {
    $studentModel = new self(
      uniqid(),
      $representative,
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
      $haveBicentennialCollection,
      $haveCanaima,
      $pendingSubjects,
      $disabilities,
      $disabilityAssistance,
      StudentStatus::Active
    );

    try {
      $stmt = App::db()->prepare('
        INSERT INTO students(id, nationality, idCard, names, lastNames,
        birthDate, birthPlace, federalEntity, indigenousPeople, stature, weight,
        shoeSize, shirtSize, pantsSize, laterality, genre,
        haveBicentennialCollection, haveCanaima, pendingSubjects, disabilities,
        disabilityAssistance, status, representative_id) VALUES (:id,
        :nationality, :idCard, :names, :lastNames, :birthDate, :birthPlace,
        :federalEntity, :indigenousPeople, :stature, :weight, :shoeSize,
        :shirtSize, :pantsSize, :laterality, :genre,
        :haveBicentennialCollection, :haveCanaima, :pendingSubjects,
        :disabilities, :disabilityAssistance, :status, :representative_id)
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
        ':haveBicentennialCollection' => $studentModel->haveBicentennialCollection,
        ':haveCanaima' => $studentModel->haveCanaima,
        ':pendingSubjects' => json_encode(array_map(static fn(Subject $subject): string => $subject->value, $studentModel->pendingSubjects)),
        ':disabilities' => json_encode(array_map(static fn(Disability|string $disability): string => is_string($disability) ? $disability : $disability->value, $studentModel->disabilities)),
        ':disabilityAssistance' => json_encode(array_map(static fn(DisabilityAssistance|string $assistance): string => is_string($assistance) ? $assistance : $assistance->value, $studentModel->disabilityAssistance)),
        ':status' => $studentModel->status->value,
        ':representative_id' => $studentModel->representative->id
      ]);
    } catch (PDOException $exception) {
      dd($exception);
    }

    return $studentModel;
  }

  function enroll(
    int $studyYear,
    string $section,
    string $teacher,
    string $date
  ): EnrollmentModel {
    return EnrollmentModel::create(
      $this,
      $studyYear,
      $section,
      $teacher,
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
        $studentData->representative_id,
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
        $studentData->haveBicentennialCollection,
        $studentData->haveCanaima,
        $studentData->pendingSubjects,
        $studentData->disabilities,
        $studentData->disabilityAssistance,
        $studentData->status
      );
    }

    return $studentData;
  }

  private static function mapper(
    string $id,
    string $representativeId,
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
    bool $haveBicentennialCollection,
    bool $haveCanaima,
    string $pendingSubjects,
    string $disabilities,
    string $disabilityAssistance,
    string $status
  ): self {
    return new self(
      $id,
      RepresentativeModel::searchById($representativeId),
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
      $haveBicentennialCollection,
      $haveCanaima,
      json_decode($pendingSubjects, true),
      json_decode($disabilities, true),
      json_decode($disabilityAssistance, true),
      StudentStatus::from($status)
    );
  }
}
