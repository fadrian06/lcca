<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Enums\Role;
use LCCA\Models\UserModel;

final readonly class TeacherController extends Controller
{
  static function showTeachers(): void
  {
    $teachers = UserModel::all(Role::Teacher);

    App::renderPage(
      'teachers-list',
      'Docentes',
      'mercury-home',
      compact('teachers')
    );
  }

  static function addTeacher(): void
  {
    App::renderPage('teacher-registration', 'Registrar docente', 'mercury-home');
  }

  static function handleTeacherRegistration(): void {
    $teacherData = App::request()->data;

    // TODO: Validate empty data
    // TODO: Validate duplicates
    UserModel::create(
      $teacherData->name,
      $teacherData->idCard,
      $teacherData->password,
      Role::Teacher->value,
      $teacherData->secretQuestion,
      $teacherData->secretAnswer
    );

    // TODO: Send success message
    App::redirect('/docentes');
  }

  static function deleteTeacher(string $id): void {
    $foundTeacher = UserModel::searchById($id);
    $foundTeacher->delete();

    // TODO: Send success message
    App::redirect('/docentes');
  }
}
