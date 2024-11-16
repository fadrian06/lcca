<?php

namespace LCCA\Models;

use DateTimeImmutable;
use DateTimeInterface;
use LCCA\App;
use LCCA\Enums\Section;
use LCCA\Enums\StudyYear;
use PDOException;

final readonly class EnrollmentModel
{
  public string $teacher;

  private function __construct(
    public string $id,
    public StudentModel $student,
    private StudyYear $studyYear,
    private Section $section,
    string $teacher,
    private DateTimeInterface $date
  ) {
    $this->teacher = mb_convert_case($teacher, MB_CASE_TITLE);
  }

  static function create(
    StudentModel $student,
    int $studyYear,
    string $section,
    string $teacher,
    string $date
  ): self {
    $enrollmentModel = new self(
      uniqid(),
      $student,
      StudyYear::from($studyYear),
      Section::from($section),
      $teacher,
      new DateTimeImmutable($date)
    );

    try {
      $stmt = App::db()->prepare('
        INSERT INTO enrollments (id, student_id, studyYear, section, teacher,
        enrollmentDate) VALUES (:id, :student_id, :studyYear, :section,
        :teacher, :enrollmentDate)
      ');

      $stmt->execute([
        ':id' => $enrollmentModel->id,
        ':student_id' => $enrollmentModel->student->id,
        ':studyYear' => $enrollmentModel->studyYear->value,
        ':section' => $enrollmentModel->section->value,
        ':teacher' => $enrollmentModel->teacher,
        ':enrollmentDate' => $enrollmentModel->date->format('Y-m-d')
      ]);
    } catch (PDOException $exception) {
      dd($exception);
    }

    return $enrollmentModel;
  }
}
