<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Models\StudentModel;

final readonly class EnrollmentController {
  static function showEnrollmentForm(): void {
    App::renderPage('new-enroll', 'Inscribir estudiante', 'mercury-home');
  }

  static function handleNewEnrollment(): void {
    $inscription = App::request()->data;

    // TODO: Validate empty data
    // TODO: Validate duplicates
    StudentModel::create(
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
      $inscription->student['pendingSubjects'] ?: [],
      $inscription->student['disabilities'] ?: [],
      $inscription->student['otherDisabilityAssistance'] === ''
        ? ($inscription->student['disabilityAssistance'] ?: [])
        : [$inscription->student['otherDisabilityAssistance']]
          + ($inscription->student['disabilityAssistance'] ?: [])
    )->enroll($inscription->studyYear, $inscription->section);

    // TODO: Send success message
    App::redirect('/');
  }
}
