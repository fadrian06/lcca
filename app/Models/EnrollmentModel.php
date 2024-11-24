<?php

namespace LCCA\Models;

use DateTimeImmutable;
use DateTimeInterface;
use LCCA\App;
use LCCA\Enums\Section;
use LCCA\Enums\StudyYear;
use PDO;
use PDOException;

final readonly class EnrollmentModel
{
  private function __construct(
    public string $id,
    public StudentModel $student,
    public UserModel $teacher,
    public StudyYear $studyYear,
    public Section $section,
    private DateTimeInterface $date
  ) {}

  static function create(
    StudentModel $student,
    int $studyYear,
    string $section,
    string $teacherId,
    string $date
  ): self {
    $enrollmentModel = new self(
      uniqid(),
      $student,
      UserModel::searchById($teacherId),
      StudyYear::from($studyYear),
      Section::from($section),
      new DateTimeImmutable($date)
    );

    try {
      $stmt = App::db()->prepare('
        INSERT INTO enrollments (id, student_id, studyYear, section, teacher_id,
        enrollmentDate) VALUES (:id, :student_id, :studyYear, :section,
        :teacherId, :enrollmentDate)
      ');

      $stmt->execute([
        ':id' => $enrollmentModel->id,
        ':student_id' => $enrollmentModel->student->id,
        ':studyYear' => $enrollmentModel->studyYear->value,
        ':section' => $enrollmentModel->section->value,
        ':teacherId' => $enrollmentModel->teacher->id,
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
      e.studyYear, e.section, e.teacher_id as teacherId,
      e.enrollmentDate FROM enrollments e
      JOIN students s ON e.student_id = s.id AND s.graduatedDate IS NULL
      AND s.retiredDate IS NULL
    ');

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_FUNC, [__CLASS__, 'mapper']);
  }

  /** @return self[] */
  static function allByStudent(StudentModel $student): array
  {
    $stmt = App::db()->prepare('SELECT * FROM enrollments WHERE student_id = ?');
    $stmt->execute([$student->id]);

    return $stmt->fetchAll(PDO::FETCH_FUNC, fn(
      string $id,
      string $student_id,
      string $teacher_id,
      string $studyYear,
      string $section,
      string $enrollmentDate
    ): self => new self(
      $id,
      $student,
      UserModel::searchById($teacher_id),
      StudyYear::from($studyYear),
      Section::from($section),
      new DateTimeImmutable($enrollmentDate)
    ));
  }

  private static function mapper(
    string $studentId,
    string $enrollmentId,
    int $studyYear,
    string $section,
    string $teacherId,
    string $enrollmentDate
  ): self {
    return new self(
      $enrollmentId,
      StudentModel::searchById($studentId),
      UserModel::searchById($teacherId),
      StudyYear::from($studyYear),
      Section::from($section),
      new DateTimeImmutable($enrollmentDate)
    );
  }
}
