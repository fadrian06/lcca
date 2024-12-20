<?php

namespace LCCA\Models;

use LCCA\App;
use LCCA\Enums\EducationLevel;
use LCCA\Enums\Nationality;
use PDOException;
use Stringable;

final class RepresentativeModel implements Stringable
{
  public readonly string $names;
  public readonly string $lastNames;
  public readonly string $address;

  /** @var StudentModel[] */
  private array $students = [];

  private function __construct(
    public readonly string $id,
    private readonly Nationality $nationality,
    public readonly int $idCard,
    string $names,
    string $lastNames,
    private readonly EducationLevel $educationLevel,
    public readonly string $job,
    public readonly string $phone,
    public readonly string $email,
    string $address,
    public readonly string $bankAccountNumber,
    public readonly string $occupation,
    public readonly bool $isFamilyBoss,
    public readonly ?string $jobRole,
    public readonly ?string $companyOrInstitutionName,
    public readonly float $monthlyFamilyIncome
  ) {
    $this->names = mb_convert_case($names, MB_CASE_TITLE);
    $this->lastNames = mb_convert_case($lastNames, MB_CASE_TITLE);
    $this->address = mb_convert_case($address, MB_CASE_TITLE);
  }

  function isFromNationality(Nationality $nationality): bool
  {
    return $this->nationality === $nationality;
  }

  function hasEducationLevel(EducationLevel $educationLevel): bool
  {
    return $this->educationLevel === $educationLevel;
  }

  function works(): bool
  {
    return $this->jobRole !== null;
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
}
