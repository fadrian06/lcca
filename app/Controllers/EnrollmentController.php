<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Models\RepresentativeModel;
use LCCA\Models\StudentModel;

final readonly class EnrollmentController
{
  static function showEnrollmentForm(): void
  {
    App::renderPage('new-enroll', 'Inscribir estudiante', 'mercury-home');
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
      $inscription->representative['bankAccountNumber'],
      $inscription->representative['occupation'],
      $inscription->representative['isFamilyBoss'] === 'Sí',
      $inscription->representative['works'] === 'Sí',
      $inscription->representative['jobRole'],
      $inscription->representative['companyOrInstitutionName'],
      $inscription->representative['monthlyFamilyIncome']
    );

    // TODO: Validate empty data
    // TODO: Validate duplicates
    $enrollmentModel = StudentModel::create(
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
      $inscription->student['haveBicentennialCollection'],
      $inscription->student['haveCanaima'],
      $inscription->student['pendingSubjects'] ?? [],
      $inscription->student['disabilities'] ?: [],
      $inscription->student['otherDisabilityAssistance'] === ''
        ? ($inscription->student['disabilityAssistance'] ?: [])
        : [$inscription->student['otherDisabilityAssistance']]
        + ($inscription->student['disabilityAssistance'] ?: [])
    )->enroll(
      $inscription->studyYear,
      $inscription->section,
      $inscription->teacher,
      $inscription->date
    );

    // TODO: Send success message
    App::redirect('/');
  }
}
