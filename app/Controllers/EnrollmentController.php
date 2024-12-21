<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Enums\Role;
use LCCA\Models\RepresentativeModel;
use LCCA\Models\StudentModel;
use LCCA\Models\SubjectModel;
use LCCA\Models\UserModel;

final readonly class EnrollmentController
{
  static function showEnrollmentForm(): void
  {
    $subjects = SubjectModel::all();
    $teachers = UserModel::all(Role::Teacher);

    App::renderPage(
      'new-enroll',
      'Inscribir estudiante',
      'mercury-home',
      compact('subjects', 'teachers')
    );
  }

  static function handleNewEnrollment(): void
  {
    $inscription = App::request()->data;

    // TODO: Validate empty data
    // TODO: Validate duplicates
    $representativeModel = RepresentativeModel::create(
      $inscription->representative['nationality'],
      $inscription->representative['idCard'],
      $inscription->representative['names'],
      $inscription->representative['lastNames'],
      $inscription->representative['educationLevel'],
      $inscription->representative['job'],
      $inscription->representative['phone'],
      $inscription->representative['email'],
      $inscription->representative['address'],
      $inscription->representative['bankAccountNumber'],
      $inscription->representative['occupation'],
      $inscription->representative['isFamilyBoss'] === 'Sí',
      $inscription->representative['jobRole'],
      $inscription->representative['companyOrInstitutionName'],
      $inscription->representative['monthlyFamilyIncome']
    );

    // TODO: Validate empty data
    // TODO: Validate duplicates
    StudentModel::create(
      $representativeModel,
      $inscription->student['nationality'],
      $inscription->student['idCard'],
      $inscription->student['names'],
      $inscription->student['lastNames'],
      $inscription->student['birth']['date'],
      $inscription->student['birth']['place'],
      $inscription->student['birth']['federalEntity'],
      $inscription->student['indigenousPeople'] ?: null,
      $inscription->student['sizes']['stature'],
      $inscription->student['sizes']['weight'],
      $inscription->student['sizes']['shoe'],
      $inscription->student['sizes']['shirt'],
      $inscription->student['sizes']['pants'],
      $inscription->student['laterality'],
      $inscription->student['genre'],
      $inscription->student['hasBicentennialCollection'],
      $inscription->student['hasCanaima'],
      array_filter($inscription->student['pendingSubjects'] ?? []),
      array_filter($inscription->student['disabilities'] ?? []),
      $inscription->student['otherDisabilityAssistance'] === ''
        ? ($inscription->student['disabilityAssistance'] ?: [])
        : [$inscription->student['otherDisabilityAssistance']]
        + ($inscription->student['disabilityAssistance'] ?: [])
    )->enroll(
      $inscription->studyYear,
      $inscription->section,
      App::loggedUser()->id,
      $inscription->date
    );

    // TODO: Send success message
    App::redirect('/');
  }

  static function showReEnrollForm(string $studentId): void
  {
    $student = StudentModel::searchById($studentId) ?? App::redirect(App::request()->referrer);
    $subjects = SubjectModel::all();

    App::renderPage(
      're-enroll',
      'Reinscripción',
      'mercury-home',
      compact('student', 'subjects')
    );
  }

  static function handleReEnrollment(string $studentId): void
  {
    $student = StudentModel::searchById($studentId) ?? App::redirect(App::request()->referrer);
    $inscription = App::request()->data;

    // TODO: Validate empty data
    $newOrUpdatedRepresentative = $student->currentRepresentative->updateOrCreate(
      $inscription->representative['nationality'],
      $inscription->representative['idCard'],
      $inscription->representative['names'],
      $inscription->representative['lastNames'],
      $inscription->representative['educationLevel'],
      $inscription->representative['job'],
      $inscription->representative['phone'],
      $inscription->representative['email'],
      $inscription->representative['address'],
      $inscription->representative['bankAccountNumber'],
      $inscription->representative['occupation'],
      $inscription->representative['isFamilyBoss'] === 'Sí',
      $inscription->representative['jobRole'],
      $inscription->representative['companyOrInstitutionName'],
      $inscription->representative['monthlyFamilyIncome']
    );

    $student->update(
      $newOrUpdatedRepresentative,
      $inscription->student['nationality'],
      $inscription->student['idCard'],
      $inscription->student['names'],
      $inscription->student['lastNames'],
      $inscription->student['birth']['date'],
      $inscription->student['birth']['place'],
      $inscription->student['birth']['federalEntity'],
      $inscription->student['indigenousPeople'] ?: null,
      $inscription->student['sizes']['stature'],
      $inscription->student['sizes']['weight'],
      $inscription->student['sizes']['shoe'],
      $inscription->student['sizes']['shirt'],
      $inscription->student['sizes']['pants'],
      $inscription->student['laterality'],
      $inscription->student['genre'],
      $inscription->student['hasBicentennialCollection'],
      $inscription->student['hasCanaima'],
      array_filter($inscription->student['pendingSubjects'] ?? []),
      array_filter($inscription->student['disabilities'] ?? []),
      $inscription->student['otherDisabilityAssistance'] === ''
        ? ($inscription->student['disabilityAssistance'] ?: [])
        : [$inscription->student['otherDisabilityAssistance']]
        + ($inscription->student['disabilityAssistance'] ?: [])
    )->enroll(
      $inscription->studyYear,
      $inscription->section,
      App::loggedUser()->id,
      $inscription->date
    );

    // TODO: Send success message
    App::redirect('/');
  }
}
