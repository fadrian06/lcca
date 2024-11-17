<?php

namespace LCCA\Models;

use DateTimeImmutable;
use DateTimeInterface;
use LCCA\App;
use LCCA\Enums\Section;
use LCCA\Enums\StudentStatus;
use LCCA\Enums\StudyYear;
use PDO;
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

  /** @return self[] */
  static function allActives(): array
  {
    $stmt = App::db()->prepare('
      SELECT DISTINCT e.student_id as studentId, e.id as enrollmentId,
      e.studyYear, e.section, e.teacher, e.enrollmentDate FROM enrollments e
      JOIN students s ON e.student_id = s.id AND s.status = ?
    ');

    $stmt->execute([StudentStatus::Active->value]);

    return $stmt->fetchAll(PDO::FETCH_FUNC, [__CLASS__, 'mapper']);
  }

  private static function mapper(
    string $studentId,
    string $enrollmentId,
    int $studyYear,
    string $section,
    string $teacher,
    string $enrollmentDate
  ): self {
    return new self(
      $enrollmentId,
      StudentModel::searchById($studentId),
      StudyYear::from($studyYear),
      Section::from($section),
      $teacher,
      new DateTimeImmutable($enrollmentDate)
    );
  }
}
