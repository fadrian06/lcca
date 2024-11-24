<?php

use LCCA\Enums\Section;
use LCCA\Enums\StudyYear;
use LCCA\Models\StudentModel;

/** @var StudentModel[] $students */

$studentsByStudyYear = [];

foreach (StudyYear::cases() as $studyYear) {
  $studentsByStudyYear[$studyYear->value] = [];

  foreach (Section::cases() as $section) {
    $studentsByStudyYear[$studyYear->value][$section->value] = [];
  }
}

foreach ($students as $student) {
  $studentsByStudyYear[$student->getStudyYear()->value][$student->getSection()->value][] = $student;
}

/** @var array<1|2|3|4|5, array<'A'|'B', StudentModel[]>> $studentsByStudyYear */

?>

<div class="row">
  <div class="col-xxl-12">
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="custom-tabs-container">
          <ul class="nav nav-tabs justify-content-center">
            <?php foreach (StudyYear::cases() as $studyYear): ?>
              <li class="nav-item">
                <a
                  class="nav-link <?= $studyYear->isFirstYear() ? 'active' : '' ?>"
                  data-bs-toggle="tab"
                  href="#<?= $studyYear->value ?>">
                  <?= $studyYear->ordinalValue() ?>
                </a>
              </li>
            <?php endforeach ?>
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
                                <th></th>
                                <th>Estudiante</th>
                                <th>Representante</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($studentsByStudyYear[$studyYear->value][$section->value] as $student): ?>
                                <tr>
                                  <td>
                                    <?php if ($student->isGraduated()): ?>
                                      <span class="badge border border-success text-success">
                                        <i class="bi bi-mortarboard-fill"></i>
                                        Graduado
                                      </span>
                                    <?php elseif ($student->isRetired()): ?>
                                      <span class="badge border border-danger text-danger">
                                        <i class="bi bi-emoji-frown-fill"></i>
                                        Retirado
                                      </span>
                                    <?php endif ?>
                                  </td>
                                  <td><?= $student ?></td>
                                  <td><?= $student->currentRepresentative() ?></td>
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
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
