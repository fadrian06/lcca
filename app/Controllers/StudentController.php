<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Models\StudentModel;

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
}
