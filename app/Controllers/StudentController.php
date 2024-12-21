<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Models\StudentModel;
use LCCA\Models\SubjectModel;

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

  static function showStudentProfile(string $id): void
  {
    $student = StudentModel::searchById($id) ?? App::redirect(App::request()->referrer);

    App::renderPage(
      'student-profile',
      $student,
      'mercury-home',
      compact('student')
    );
  }

  static function handleGraduation(string $id): void
  {
    $student = StudentModel::searchById($id) ?? App::redirect(App::request()->referrer);

    $student->graduate();

    // TODO: Show success message
    App::redirect('/estudiantes');
  }

  static function handleRetirement(string $id): void
  {
    $student = StudentModel::searchById($id) ?? App::redirect(App::request()->referrer);

    $student->retire();

    // TODO: Show success message
    App::redirect('/estudiantes');
  }

  static function showEditStudent(string $id): void
  {
    $student = StudentModel::searchById($id) ?? App::redirect(App::request()->referrer);
    $subjects = SubjectModel::all();

    App::renderPage(
      'student-edition',
      'Editar estudiante',
      'mercury-home',
      compact('student', 'subjects')
    );
  }

  static function handleStudentUpdate(string $id): void
  {
    $student = StudentModel::searchById($id) ?? App::redirect(App::request()->referrer);
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
}
