<?php

namespace LCCA\Models;

use LCCA\App;
use LCCA\Enums\EducationLevel;
use LCCA\Enums\Nationality;
use PDOException;
use Stringable;

/**
 * @property-read string $names
 * @property-read string $lastNames
 * @property-read string $address
 * @property-read StudentModel[] $students
 * @property-read Nationality $nationality
 * @property-read int $idCard
 * @property-read EducationLevel $educationLevel
 * @property-read string $job
 * @property-read string $phone
 * @property-read string $email
 * @property-read string $bankAccountNumber
 * @property-read string $occupation
 * @property-read string $isFamilyBoss
 * @property-read ?string $jobRole
 * @property-read ?string $companyOrInstitutionName
 * @property-read float $monthlyFamilyIncome
 * @property-read bool $works
 */
final class RepresentativeModel implements Stringable
{
  private string $names;
  private string $lastNames;
  private string $address;
  private array $students = [];

  private function __construct(
    public readonly string $id,
    private Nationality $nationality,
    private int $idCard,
    string $names,
    string $lastNames,
    private EducationLevel $educationLevel,
    private string $job,
    private string $phone,
    private string $email,
    string $address,
    private string $bankAccountNumber,
    private string $occupation,
    private bool $isFamilyBoss,
    private ?string $jobRole,
    private ?string $companyOrInstitutionName,
    private float $monthlyFamilyIncome
  ) {
    $this->__set('names', $names);
    $this->__set('lastNames', $lastNames);
    $this->__set('address', $address);
  }

  function isFromNationality(Nationality $nationality): bool
  {
    return $this->nationality === $nationality;
  }

  function hasEducationLevel(EducationLevel $educationLevel): bool
  {
    return $this->educationLevel === $educationLevel;
  }

  static function create(
    string $nationality,
    int $idCard,
    string $names,
    string $lastNames,
    string $educationLevel,
    string $job,
    string $phone,
    string $email,
    string $address,
    string $bankAccountNumber,
    string $occupation,
    bool $isFamilyBoss,
    ?string $jobRole,
    ?string $companyOrInstitutionName,
    float $monthlyFamilyIncome
  ): self {
    $representativeModel = new self(
      uniqid(),
      Nationality::from($nationality),
      $idCard,
      $names,
      $lastNames,
      EducationLevel::from($educationLevel),
      $job,
      $phone,
      $email,
      $address,
      $bankAccountNumber,
      $occupation,
      $isFamilyBoss,
      $jobRole ?: null,
      $companyOrInstitutionName ?: null,
      $monthlyFamilyIncome
    );

    try {
      $stmt = App::db()->prepare('
        INSERT INTO representatives (id, nationality, idCard, names, lastNames,
        educationLevel, job, phone, email, address, bankAccountNumber,
        occupation, isFamilyBoss, jobRole, companyOrInstitutionName,
        monthlyFamilyIncome) VALUES (:id, :nationality, :idCard, :names,
        :lastNames, :educationLevel, :job, :phone, :email, :address,
        :bankAccountNumber, :occupation, :isFamilyBoss, :jobRole,
        :companyOrInstitutionName, :monthlyFamilyIncome)
      ');

      $stmt->execute([
        ':id' => $representativeModel->id,
        ':nationality' => $representativeModel->nationality->value,
        ':idCard' => $representativeModel->idCard,
        ':names' => $representativeModel->names,
        ':lastNames' => $representativeModel->lastNames,
        ':educationLevel' => $representativeModel->educationLevel->value,
        ':job' => $representativeModel->job,
        ':phone' => $representativeModel->phone,
        ':email' => $representativeModel->email,
        ':address' => $representativeModel->address,
        ':bankAccountNumber' => $representativeModel->bankAccountNumber,
        ':occupation' => $representativeModel->occupation,
        ':isFamilyBoss' => (int) $representativeModel->isFamilyBoss,
        ':jobRole' => $representativeModel->jobRole,
        ':companyOrInstitutionName' => $representativeModel->companyOrInstitutionName,
        ':monthlyFamilyIncome' => $representativeModel->monthlyFamilyIncome,
      ]);
    } catch (PDOException $exception) {
      dd($exception);
    }

    return $representativeModel;
  }

  function represent(StudentModel ...$students): self
  {
    foreach ($students as $candidate) {
      foreach ($this->students as $represented) {
        if ($candidate->id === $represented->id) {
          continue 2;
        }
      }

      $this->students[] = $candidate;
    }

    return $this;
  }

  function updateOrCreate(
    string $nationality,
    int $idCard,
    string $names,
    string $lastNames,
    string $educationLevel,
    string $job,
    string $phone,
    string $email,
    string $address,
    string $bankAccountNumber,
    string $occupation,
    bool $isFamilyBoss,
    ?string $jobRole,
    ?string $companyOrInstitutionName,
    float $monthlyFamilyIncome
  ): self {
    if ($idCard !== $this->idCard) {
      return self::create(
        $nationality,
        $idCard,
        $names,
        $lastNames,
        $educationLevel,
        $job,
        $phone,
        $email,
        $address,
        $bankAccountNumber,
        $occupation,
        $isFamilyBoss,
        $jobRole,
        $companyOrInstitutionName,
        $monthlyFamilyIncome
      );
    }

    $this->__set('nationality', $nationality);
    $this->__set('names', $names);
    $this->__set('lastNames', $lastNames);
    $this->__set('educationLevel', $educationLevel);
    $this->job = $job;
    $this->phone = $phone;
    $this->email = $email;
    $this->address = $address;
    $this->bankAccountNumber = $bankAccountNumber;
    $this->occupation = $occupation;
    $this->isFamilyBoss = $isFamilyBoss;
    $this->jobRole = $jobRole;
    $this->companyOrInstitutionName = $companyOrInstitutionName;
    $this->monthlyFamilyIncome = $monthlyFamilyIncome;

    $stmt = App::db()->prepare('
      UPDATE representatives SET nationality = :nationality, names = :names,
      lastNames = :lastNames, educationLevel = :educationLevel, job = :job,
      phone = :phone, email = :email, address = :address,
      bankAccountNumber = :bankAccountNumber, occupation = :occupation,
      isFamilyBoss = :isFamilyBoss, jobRole = :jobRole,
      companyOrInstitutionName = :companyOrInstitutionName,
      monthlyFamilyIncome = :monthlyFamilyIncome WHERE id = :id
    ');

    $stmt->execute([
      ':nationality' => $this->nationality->value,
      ':names' => $this->names,
      ':lastNames' => $this->lastNames,
      ':educationLevel' => $this->educationLevel->value,
      ':job' => $this->job,
      ':phone' => $this->phone,
      ':email' => $this->email,
      ':address' => $this->address,
      ':bankAccountNumber' => $this->bankAccountNumber,
      ':occupation' => $this->occupation,
      ':isFamilyBoss' => (int) $this->isFamilyBoss,
      ':jobRole' => $this->jobRole,
      ':companyOrInstitutionName' => $this->companyOrInstitutionName,
      ':monthlyFamilyIncome' => $this->monthlyFamilyIncome,
      ':id' => $this->id
    ]);

    return $this;
  }

  static function searchById(string $id): ?self
  {
    return self::searchByField('id', $id);
  }

  private static function searchByField(string $field, string $value): ?self
  {
    $stmt = App::db()->prepare("SELECT * FROM representatives WHERE $field = ?");
    $stmt->execute([$value]);
    $representativeData = $stmt->fetch() ?: null;

    if ($representativeData) {
      return self::mapper(
        $representativeData->id,
        $representativeData->nationality,
        $representativeData->idCard,
        $representativeData->names,
        $representativeData->lastNames,
        $representativeData->educationLevel,
        $representativeData->job,
        $representativeData->phone,
        $representativeData->email,
        $representativeData->address,
        $representativeData->bankAccountNumber,
        $representativeData->occupation,
        $representativeData->isFamilyBoss,
        $representativeData->jobRole,
        $representativeData->companyOrInstitutionName,
        $representativeData->monthlyFamilyIncome
      );
    }

    return $representativeData;
  }

  private static function mapper(
    string $id,
    string $nationality,
    int $idCard,
    string $names,
    string $lastNames,
    string $educationLevel,
    string $job,
    string $phone,
    string $email,
    string $address,
    string $bankAccountNumber,
    string $occupation,
    bool $isFamilyBoss,
    ?string $jobRole,
    ?string $companyOrInstitutionName,
    float $monthlyFamilyIncome
  ): self {
    return new self(
      $id,
      Nationality::from($nationality),
      $idCard,
      $names,
      $lastNames,
      EducationLevel::from($educationLevel),
      $job,
      $phone,
      $email,
      $address,
      $bankAccountNumber,
      $occupation,
      $isFamilyBoss,
      $jobRole,
      $companyOrInstitutionName,
      $monthlyFamilyIncome
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
    if (property_exists($this, $name)) {
      return $this->$name;
    }

    return match ($name) {
      'works' => $this->jobRole !== null,
      default => null
    };
  }

  function __set(string $name, mixed $value): void
  {
    switch ($name) {
      case 'names':
      case 'lastNames':
      case 'address':
        $this->$name = mb_convert_case($value, MB_CASE_TITLE);
        break;
      case 'nationality':
        $this->nationality = Nationality::from($value);
        break;
      case 'educationLevel':
        $this->educationLevel = EducationLevel::from($value);
        break;
    }
  }
}
