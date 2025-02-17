<?php

namespace LCCA\Controllers;

use LCCA\App;
use LCCA\Models\StudySectionModel;
use LCCA\Models\StudyYearModel;

final readonly class StudyYearController extends Controller
{
  private const ORDINAL = [
    1 => 'Primero',
    2 => 'Segundo',
    3 => 'Tercero',
    4 => 'Cuarto',
    5 => 'Quinto',
    6 => 'Sexto',
    7 => 'Séptimo',
    8 => 'Octavo',
    9 => 'Noveno',
    10 => 'Décimo',
    11 => 'Undécimo',
    12 => 'Duodécimo'
  ];

  static function showStudyYears(): void
  {
    $studyYears = StudyYearModel::all();

    App::renderPage(
      'study-years-list',
      'Años y secciones',
      'mercury-home',
      compact('studyYears')
    );
  }

  static function deleteSection(string $sectionId): void
  {
    $section = StudySectionModel::searchById($sectionId);
    $section?->delete();

    flash()->set('Sección eliminada exitósamente', 'success');
    App::redirect('/años');
  }

  function handleOpenSection(string $studyYearId): void
  {
    $sectionData = $this->getValidatedData([
      'sección' => ['textonly', 'min:1', 'max:1'],
      'capacidad' => ['number', 'min:1', 'max:99']
    ]);

    $studyYear = StudyYearModel::searchById($studyYearId);
    $studyYear->openSection($sectionData->sección, $sectionData->capacidad);

    flash()->set('Sección aperturada exitósamente', 'success');
    App::redirect('/años');
  }

  function handleUpdateSection(string $studySectionId): void
  {
    $section = StudySectionModel::searchById($studySectionId);

    $sectionData = $this->getValidatedData([
      'sección' => ['textonly', 'min:1', 'max:1'],
      'capacidad' => ['number', 'min:1', 'max:99'],
      'activo' => ['optional', 'boolean']
    ]);

    $section->update(
      $sectionData->sección,
      $sectionData->capacidad,
      $sectionData->activo ?? true
    );

    flash()->set('Sección actualizada exitósamente', 'success');
    App::redirect('/años');
  }

  function handleUpdateStudyYear(string $studyYearId): void
  {
    $studyYear = StudyYearModel::searchById($studyYearId);

    $studyYearData = $this->getValidatedData([
      'año' => ['number', 'min:1', 'max:12'],
      'activo' => ['optional', 'boolean']
    ]);

    $studyYear->update(
      self::ORDINAL[$studyYearData->año],
      (int) $studyYearData->año,
      $studyYearData->activo ?? true
    );

    flash()->set('Año actualizado exitósamente', 'success');
    App::redirect('/años');
  }
}
