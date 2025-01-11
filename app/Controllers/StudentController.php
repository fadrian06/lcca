<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Models\StudentModel;
use LCCA\Models\SubjectModel;
use PDO;

final readonly class StudentController
{
  static function showStudents(): void
  {
    $students = StudentModel::all();

    App::renderPage(
      'students-list',
      'Estudiantes',
      'mercury-home',
      compact('students')
    );
  }

  static function showStudentProfile(string $studentId): void
  {
    $student = StudentModel::searchById($studentId) ?? App::redirect(App::request()->referrer);

    App::renderPage(
      'student-profile',
      $student,
      'mercury-home',
      compact('student')
    );
  }

  static function handleGraduation(string $studentId): void
  {
    $student = StudentModel::searchById($studentId) ?? App::redirect(App::request()->referrer);

    $student->graduate();

    // TODO: Show success message
    App::redirect('/estudiantes');
  }

  static function handleRetirement(string $studentId): void
  {
    $student = StudentModel::searchById($studentId) ?? App::redirect(App::request()->referrer);

    $student->retire();

    // TODO: Show success message
    App::redirect('/estudiantes');
  }

  static function showEditStudent(string $studentId): void
  {
    $student = StudentModel::searchById($studentId) ?? App::redirect(App::request()->referrer);
    $subjects = SubjectModel::all();

    App::renderPage(
      'student-edition',
      'Editar estudiante',
      'mercury-home',
      compact('student', 'subjects')
    );
  }

  static function handleStudentUpdate(string $studentId): void
  {
    $student = StudentModel::searchById($studentId) ?? App::redirect(App::request()->referrer);
    $newStudentData = App::request()->data->student;

    $student->update(
      $student->currentRepresentative,
      $newStudentData['nationality'],
      $newStudentData['idCard'],
      $newStudentData['names'],
      $newStudentData['lastNames'],
      $newStudentData['birth']['date'],
      $newStudentData['birth']['place'],
      $newStudentData['birth']['federalEntity'],
      $newStudentData['indigenousPeople'] ?: null,
      $newStudentData['sizes']['stature'],
      $newStudentData['sizes']['weight'],
      $newStudentData['sizes']['shoe'],
      $newStudentData['sizes']['shirt'],
      $newStudentData['sizes']['pants'],
      $newStudentData['laterality'],
      $newStudentData['genre'],
      $newStudentData['hasBicentennialCollection'],
      $newStudentData['hasCanaima'],
      array_filter($newStudentData['pendingSubjects'] ?? []),
      array_filter($newStudentData['disabilities'] ?? []),
      $newStudentData['otherDisabilityAssistance'] === ''
        ? ($newStudentData['disabilityAssistance'] ?: [])
        : [$newStudentData['otherDisabilityAssistance']]
        + ($newStudentData['disabilityAssistance'] ?: [])
    );

    App::redirect("/estudiantes/$student->id");
  }

  static function removeRepresentative(
    string $studentId,
    string $representativeId
  ): void {
    $student = StudentModel::searchById($studentId) ?? App::redirect(App::request()->referrer);
    $student->removeRepresentativeById($representativeId);

    App::redirect(App::request()->referrer);
  }

  static function searchStudentByIdCard(int $idCard): void {
    $stmt = App::db()->query("
      SELECT id, nationality, idCard, names, lastNames FROM students
      WHERE idCard LIKE '$idCard%' OR idCard = $idCard
    ");

    $stmt->execute();

    App::json($stmt->fetchAll(PDO::FETCH_ASSOC));
  }

  static function searchStudentByNames(string $names): void {
    $stmt = App::db()->query("
      SELECT id, nationality, idCard, names, lastNames FROM students
      WHERE names LIKE '$names%' OR lastNames LIKE '$names%'
      OR names = ? OR lastNames = ?
    ");

    $stmt->execute([$names]);

    App::json($stmt->fetchAll(PDO::FETCH_ASSOC));
  }
}
