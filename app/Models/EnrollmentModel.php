<?php

namespace LCCA\Models;

use LCCA\App;
use LCCA\Enums\Section;
use LCCA\Enums\StudyYear;
use PDOException;

final readonly class EnrollmentModel
{
  private function __construct(
    public string $id,
    public StudentModel $student,
    private StudyYear $studyYear,
    private Section $section
  ) {}

  static function create(
    StudentModel $student,
    int $studyYear,
    string $section
  ): self {
    $enrollmentModel = new self(
      uniqid(),
      $student,
      StudyYear::from($studyYear),
      Section::from($section)
    );

    try {
      $stmt = App::db()->prepare('
        INSERT INTO enrollments (id, student_id, studyYear, section) VALUES (
        :id, :student_id, :studyYear, :section)
      ');

      $stmt->execute([
        ':id' => $enrollmentModel->id,
        ':student_id' => $enrollmentModel->student->id,
        ':studyYear' => $enrollmentModel->studyYear->value,
        ':section' => $enrollmentModel->section->value
      ]);
    } catch (PDOException $exception) {
      dd($exception);
    }

    return $enrollmentModel;
  }
}
