<?php

namespace LCCA\Controllers;

use Error;
use LCCA\App;
use LCCA\Models\SubjectModel;

final readonly class SubjectController extends Controller
{
  static function showSubjects(): void
  {
    $subjects = SubjectModel::all();

    App::renderPage(
      'areas-list',
      'Áreas de Formación',
      'mercury-home',
      compact('subjects')
    );
  }

  static function addSubject(): void
  {
    $subjectData = App::request()->data;

    try {
      $imageUrl = './' . self::ensureThatFileIsSaved(
        'image',
        'imageUrl',
        $subjectData->name,
        'subjects/opened',
        'La imagen es requerida'
      );
    } catch (Error) {
      $imageUrl = null;
    }

    SubjectModel::create($subjectData->name, $imageUrl);

    App::redirect(App::request()->referrer);
  }

  static function deleteSubject(string $id): void
  {
    $subjectFound = SubjectModel::searchById($id);
    $subjectFound->delete();

    App::redirect(App::request()->referrer);
  }

  static function showEditPage(string $id): void
  {
    $subject = SubjectModel::searchById($id) ?? App::redirect(App::request()->referrer);

    App::renderPage(
      'areas-edit',
      'Editar área de formación',
      'mercury-home',
      compact('subject')
    );
  }

  static function handleEditSubject(string $id): void
  {
    $subjectData = App::request()->data;
    $subject = SubjectModel::searchById($id) ?? App::redirect(App::request()->referrer);

    try {
      $imageUrl = './' . self::ensureThatFileIsSaved(
        'image',
        'imageUrl',
        $subjectData->name,
        'subjects/opened',
        'La imagen es requerida'
      );
    } catch (Error) {
      $imageUrl = null;
    }

    $subject->update(
      $subjectData->name,
      $imageUrl
    );

    App::redirect('./areas');
  }
}
