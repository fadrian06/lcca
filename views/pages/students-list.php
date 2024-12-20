<?php

use Jenssegers\Date\Date;
use LCCA\Enums\Section;
use LCCA\Enums\StudyYear;
use LCCA\Models\StudentModel;

/** @var StudentModel[] $students */

$studentsByStudyYear = [];
$graduatedStudents = [];
$retiredStudents = [];

foreach (StudyYear::cases() as $studyYear) {
  $studentsByStudyYear[$studyYear->value] = [];

  foreach (Section::cases() as $section) {
    $studentsByStudyYear[$studyYear->value][$section->value] = [];
  }
}

foreach ($students as $student) {
  if ($student->isGraduated()) {
    $graduatedStudents[] = $student;
  } elseif ($student->isRetired()) {
    $retiredStudents[] = $student;
  } else {
    $studentsByStudyYear[$student->getStudyYear()->value][$student->getSection()->value][] = $student;
  }
}

/**
 * @var array<1|2|3|4|5, array<'A'|'B', StudentModel[]>> $studentsByStudyYear
 * @var StudentModel[] $graduatedStudents
 * @var StudentModel[] $retiredStudents
 */

?>

<div class="row">
  <div class="col-xxl-12">
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="custom-tabs-container">
          <ul class="nav nav-tabs justify-content-center px-2">
            <?php foreach (StudyYear::cases() as $studyYear): ?>
              <li class="nav-item">
                <a
                  class="nav-link <?= $studyYear->isFirstYear() ? 'active' : '' ?>"
                  data-bs-toggle="tab"
                  href="#<?= $studyYear->value ?>"
                  style="border-bottom-width: 3px">
                  <i class="bi bi-people"></i>
                  <?= $studyYear->ordinalValue() ?>
                </a>
              </li>
            <?php endforeach ?>
            <li class="nav-item">
              <a
                class="nav-link"
                data-bs-toggle="tab"
                href="#graduados"
                style="border-bottom-width: 3px">
                <i class="bi bi-mortarboard-fill"></i>
                Graduados
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                data-bs-toggle="tab"
                href="#retirados"
                style="border-bottom-width: 3px">
                <i class="bi bi-emoji-frown-fill"></i>
                Retirados
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <?php foreach (StudyYear::cases() as $studyYear): ?>
              <div
                class="tab-pane fade <?= $studyYear->isFirstYear() ? 'show active' : '' ?>"
                id="<?= $studyYear->value ?>">
                <div class="custom-tabs-container">
                  <ul class="nav nav-tabs justify-content-center">
                    <?php foreach (Section::cases() as $index => $section): ?>
                      <li class="nav-item">
                        <a
                          class="nav-link <?= $index === 0 ? 'active' : '' ?>"
                          data-bs-toggle="tab"
                          href="#<?= $studyYear->value . $section->value ?>">
                          <?= $section->value ?>
                        </a>
                      </li>
                    <?php endforeach ?>
                  </ul>
                  <div class="tab-content">
                    <?php foreach (Section::cases() as $index => $section): ?>
                      <div
                        class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>"
                        id="<?= $studyYear->value . $section->value ?>">
                        <div class="table-responsive">
                          <table class="table align-middle table-hover m-0">
                            <thead>
                              <tr>
                                <th>Estudiante</th>
                                <th>Representante</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($studentsByStudyYear[$studyYear->value][$section->value] as $student): ?>
                                <tr>
                                  <td><?= $student ?></td>
                                  <td><?= $student->currentRepresentative() ?></td>
                                  <td>
                                    <form method="post">
                                      <?php if ($student->canGraduate()): ?>
                                        <button
                                          formaction="./estudiantes/<?= $student->id ?>/graduar"
                                          class="btn btn-sm btn-outline-success">
                                          Graduar
                                        </button>
                                      <?php else: ?>
                                        <a
                                          href="./estudiantes/<?= $student->id ?>/reinscribir"
                                          class="btn btn-sm btn-outline-primary">
                                          Promover
                                        </a>
                                      <?php endif ?>
                                      <button
                                        formaction="./estudiantes/<?= $student->id ?>/retirar"
                                        class="btn btn-sm btn-outline-danger">
                                        Retirar
                                      </button>
                                    </form>
                                  </td>
                                </tr>
                              <?php endforeach ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    <?php endforeach ?>
                  </div>
                </div>
              </div>
            <?php endforeach ?>
            <div
              class="tab-pane fade"
              id="graduados">
              <div class="tab-content">
                <div class="table-responsive">
                  <table class="table align-middle table-hover m-0">
                    <thead>
                      <tr>
                        <th>Fecha</th>
                        <th>Estudiante</th>
                        <th>Representante</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($graduatedStudents as $student): ?>
                        <tr>
                          <td>
                            <?= mb_ucfirst((new Date($student->getGraduatedDate()))->diffForHumans()) ?>
                          </td>
                          <td><?= $student ?></td>
                          <td><?= $student->currentRepresentative() ?></td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="retirados">
              <div class="tab-content">
                <div class="table-responsive">
                  <table class="table align-middle table-hover m-0">
                    <thead>
                      <tr>
                        <th>Fecha</th>
                        <th>Estudiante</th>
                        <th>Representante</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($retiredStudents as $student): ?>
                        <tr>
                          <td>
                            <?= mb_ucfirst((new Date($student->getRetiredDate()))->diffForHumans()) ?>
                          </td>
                          <td><?= $student ?></td>
                          <td><?= $student->currentRepresentative() ?></td>
                          <td>
                            <a
                              href="./estudiantes/<?= $student->id ?>/reinscribir"
                              class="btn btn-sm btn-outline-success">
                              Reinscribir
                            </a>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
