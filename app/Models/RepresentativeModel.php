<?php

namespace LCCA\Models;

use LCCA\App;
use LCCA\Enums\EducationLevel;
use LCCA\Enums\Nationality;
use PDOException;

final class RepresentativeModel
{
  public readonly string $names;
  public readonly string $lastNames;

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
    public readonly string $bankAccountNumber,
    public readonly string $occupation,
    public readonly bool $isFamilyBoss,
    public readonly bool $works,
    public readonly ?string $jobRole,
    public readonly ?string $companyOrInstitutionName,
    public readonly float $monthlyFamilyIncome
  ) {
    $this->names = mb_convert_case($names, MB_CASE_TITLE);
    $this->lastNames = mb_convert_case($lastNames, MB_CASE_TITLE);
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
    string $bankAccountNumber,
    string $occupation,
    bool $isFamilyBoss,
    bool $works,
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
      $bankAccountNumber,
      $occupation,
      $isFamilyBoss,
      $works,
      $jobRole ?: null,
      $companyOrInstitutionName ?: null,
      $monthlyFamilyIncome
    );

    try {
      $stmt = App::db()->prepare('
        INSERT INTO representatives (id, nationality, idCard, names, lastNames,
        educationLevel, job, phone, email, bankAccountNumber, occupation,
        isFamilyBoss, works, jobRole, companyOrInstitutionName,
        monthlyFamilyIncome) VALUES (:id, :nationality, :idCard, :names,
        :lastNames, :educationLevel, :job, :phone, :email, :bankAccountNumber,
        :occupation, :isFamilyBoss, :works, :jobRole, :companyOrInstitutionName,
        :monthlyFamilyIncome)
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
        ':bankAccountNumber' => $representativeModel->bankAccountNumber,
        ':occupation' => $representativeModel->occupation,
        ':isFamilyBoss' => $representativeModel->isFamilyBoss,
        ':works' => $representativeModel->works,
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
}
