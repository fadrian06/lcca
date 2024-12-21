<?php

use LCCA\Enums\Disability;
use LCCA\Enums\DisabilityAssistance;
use LCCA\Enums\FederalEntity;
use LCCA\Enums\Genre;
use LCCA\Enums\IndigenousPeople;
use LCCA\Enums\Laterality;
use LCCA\Enums\Nationality;
use LCCA\Enums\ShirtSize;
use LCCA\Models\StudentModel;
use LCCA\Models\SubjectModel;

/**
 * @var StudentModel $student
 * @var SubjectModel[] $subjects
 */

?>

<form method="post" action="./estudiantes/<?= $student->id ?>" class="card card-body">
  <fieldset class="my-3">
    <legend>1.- DATOS DEL ESTUDIANTE</legend>
    <div class="row">
      <div class="col-md-12">
        <div class="input-group mb-3">
          <label class="input-group-text" for="student[idCard]">
            CI o<br />pasaporte:
          </label>
          <div class="input-group-text d-grid">
            <?php foreach (Nationality::cases() as $nationality): ?>
              <div class="ms-2 form-check">
                <label
                  for="student[nationality][<?= $nationality->value ?>]"
                  class="form-check-label">
                  <?= $nationality->value ?>
                </label>
                <input
                  id="student[nationality][<?= $nationality->value ?>]"
                  class="form-check-input"
                  type="radio"
                  name="student[nationality]"
                  required
                  value="<?= $nationality->value ?>"
                  <?= $student->isFromNationality($nationality) ? 'checked' : '' ?> />
              </div>
            <?php endforeach ?>
          </div>
          <input
            class="form-control"
            type="number"
            name="student[idCard]"
            id="student[idCard]"
            required
            value="<?= $student->idCard ?>" />
        </div>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Nombres:</span>
          <input
            class="form-control"
            name="student[names]"
            required
            value="<?= $student->names ?>" />
        </label>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Apellidos:</span>
          <input
            class="form-control"
            name="student[lastNames]"
            required
            value="<?= $student->lastNames ?>" />
        </label>
      </div>
      <div class="col-md-5">
        <label class="input-group mb-3">
          <span class="input-group-text">Fecha de<br />nacimiento:</span>
          <input
            class="form-control"
            type="date"
            name="student[birth][date]"
            required
            value="<?= $student->birthDate->format('Y-m-d') ?>" />
        </label>
      </div>
      <div class="col-md-7">
        <label class="input-group mb-3">
          <span class="input-group-text">Lugar de<br />nacimiento:</span>
          <textarea
            class="form-control"
            name="student[birth][place]"
            required
            rows="1"><?= $student->birthPlace ?></textarea>
        </label>
      </div>
      <div class="col-md-12">
        <label class="input-group mb-3">
          <span class="input-group-text">Entidad federal:</span>
          <select
            class="form-select"
            name="student[birth][federalEntity]"
            required>
            <option value="">Seleccione una opción</option>
            <?php foreach (FederalEntity::casesByInitial() as $initial => $federalEntities): ?>
              <optgroup label="<?= $initial ?>">
                <?php foreach ($federalEntities as $federalEntity): ?>
                  <option <?= $student->isFromFederalEntity($federalEntity) ? 'selected' : '' ?>>
                    <?= $federalEntity->value ?>
                  </option>
                <?php endforeach ?>
              </optgroup>
            <?php endforeach ?>
          </select>
        </label>
      </div>
      <div class="col-md-12">
        <div class="input-group mb-3">
          <label class="input-group-text">
            ¿Pertenece<br />a un pueblo<br />indígena?
          </label>
          <div class="input-group-text d-grid">
            <label class="form-check">
              <input
                class="form-check-input"
                onchange="document.querySelector(`[name='student[indigenousPeople]']`).setAttribute('required', true)"
                type="radio"
                required
                name="student[isIndigenous]"
                value="Sí"
                <?= $student->isIndigenous() ? 'checked' : '' ?> />
              <span class="form-check-label">Sí</span>
            </label>
            <label class="form-check">
              <input
                class="form-check-input"
                onchange="document.querySelector(`[name='student[indigenousPeople]']`).removeAttribute('required')"
                type="radio"
                required
                name="student[isIndigenous]"
                value="No"
                <?= !$student->isIndigenous() ? 'checked' : '' ?> />
              <span class="form-check-label">No</span>
            </label>
          </div>
          <select name="student[indigenousPeople]" class="form-control">
            <option value="" selected>¿Cuál?</option>
            <optgroup>
              <?php foreach (IndigenousPeople::valuesSorted() as $indigenousPeople): ?>
                <option <?= $student->isIndigenous($indigenousPeople) ? 'selected' : '' ?>>
                  <?= $indigenousPeople ?>
                </option>
              <?php endforeach ?>
            </optgroup>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Estatura (cm):</span>
          <input
            class="form-control"
            type="number"
            step=".1"
            name="student[sizes][stature]"
            required
            value="<?= $student->stature ?>" />
        </label>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Peso (kg):</span>
          <input
            class="form-control"
            type="number"
            step=".1"
            name="student[sizes][weight]"
            required
            value="<?= $student->weight ?>" />
        </label>
      </div>
      <div class="col-md-12">
        <div class="input-group mb-3">
          <span class="input-group-text">TALLAS:</span>
          <input
            class="form-control"
            type="number"
            name="student[sizes][shoe]"
            required
            placeholder="Zapato"
            value="<?= $student->shoeSize ?>" />
          <select class="form-select" name="student[sizes][shirt]" required>
            <option value="">Camisa</option>
            <optgroup>
              <?php foreach (ShirtSize::cases() as $shirtSize): ?>
                <option <?= $student->isShirtSize($shirtSize) ? 'selected' : '' ?>>
                  <?= $shirtSize->value ?>
                </option>
              <?php endforeach ?>
            </optgroup>
          </select>
          <input
            class="form-control"
            placeholder="Pantalón"
            type="number"
            name="student[sizes][pants]"
            required
            value="<?= $student->pantsSize ?>" />
        </div>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Lateralidad:</span>
          <select class="form-select" name="student[laterality]" required>
            <option value=""></option>
            <?php foreach (Laterality::cases() as $laterality): ?>
              <option <?= $student->hasLaterality($laterality) ? 'selected' : '' ?>>
                <?= $laterality->value ?>
              </option>
            <?php endforeach ?>
          </select>
        </label>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Género:</span>
          <select class="form-select" name="student[genre]" required>
            <option value=""></option>
            <?php foreach (Genre::cases() as $genre): ?>
              <option <?= $student->isAGenre($genre) ? 'selected' : '' ?>>
                <?= $genre->value ?>
              </option>
            <?php endforeach ?>
          </select>
        </label>
      </div>
    </div>

    <fieldset class="my-3">
      <legend>1.a.- ASPECTOS PEDAGÓGICOS</legend>
      <div class="row">
        <div class="col-md-6">
          <div class="input-group mb-3">
            <span class="input-group-text">
              ¿Posee Colección<br />Bicentenario?
            </span>
            <div class="form-control">
              <label class="form-check">
                <span class="form-check-label">(Sí)</span>
                <input
                  class="form-check-input"
                  type="radio"
                  name="student[hasBicentennialCollection]"
                  required
                  value="Sí"
                  <?= $student->hasBicentennialCollection ? 'checked' : '' ?> />
              </label>
              <label class="form-check">
                <span class="form-check-label">(No)</span>
                <input
                  class="form-check-input"
                  type="radio"
                  name="student[hasBicentennialCollection]"
                  required
                  value="No"
                  <?= !$student->hasBicentennialCollection ? 'checked' : '' ?> />
              </label>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group mb-3">
            <span class="input-group-text">¿Posee<br />Canaima?</span>
            <div class="form-control">
              <label class="form-check">
                <span class="form-check-label">(Sí)</span>
                <input
                  class="form-check-input"
                  type="radio"
                  name="student[hasCanaima]"
                  required
                  value="Sí"
                  <?= $student->hasCanaima ? 'checked' : '' ?> />
              </label>
              <label class="form-check">
                <span class="form-check-label">(No)</span>
                <input
                  class="form-check-input"
                  type="radio"
                  name="student[hasCanaima]"
                  required
                  value="No"
                  <?= !$student->hasCanaima ? 'checked' : '' ?> />
              </label>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <label class="input-group mb-3">
            <span class="input-group-text">Materias<br />pendientes:</span>
            <select
              class="form-select"
              name="student[pendingSubjects][]"
              multiple>
              <option value="">Ninguna</option>
              <?php foreach ($subjects as $subject): ?>
                <option
                  value="<?= $subject->id ?>"
                  <?= $student->hasPendingSubject($subject) ? 'selected' : '' ?>>
                  <?= $subject ?>
                </option>
              <?php endforeach ?>
            </select>
          </label>
        </div>
      </div>
    </fieldset>
    <fieldset class="my-3">
      <legend>1.b.- Datos de salud</legend>
      <div class="row">
        <div class="col-md-6 mb-3">
          <div class="input-group h-100">
            <span class="input-group-text">¿Tiene alguna<br />discapacidad?</span>
            <select name="student[disabilities][]" multiple class="form-select">
              <option value="">Ninguna</option>
              <?php foreach (Disability::cases() as $disability): ?>
                <option <?= $student->hasDisability($disability) ? 'selected' : '' ?>>
                  <?= $disability->value ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group mb-3">
            <span class="input-group-text">
              ¿Recibe ayuda por discapacidad?
            </span>
            <div class="form-control">
              <label class="form-check form-check-inline">
                <span class="form-check-label">(Sí)</span>
                <input
                  class="form-check-input"
                  type="radio"
                  name="student[hasDisabilityAssistance]"
                  required
                  value="Sí"
                  <?= $student->hasDisabilityAssistance() ? 'checked' : '' ?> />
              </label>
              <label class="form-check form-check-inline">
                <span class="form-check-label">(No)</span>
                <input
                  class="form-check-input"
                  type="radio"
                  name="student[hasDisabilityAssistance]"
                  required
                  value="No"
                  <?= !$student->hasDisabilityAssistance() ? 'checked' : '' ?> />
              </label>
            </div>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">¿Cuál?</span>
            <div class="form-control">
              <?php foreach (DisabilityAssistance::cases() as $assistance): ?>
                <label class="form-check form-check-inline">
                  <input
                    class="form-check-input"
                    onchange="document.querySelector(`[name='student[otherDisabilityAssistance]']`).removeAttribute('required')"
                    type="checkbox"
                    name="student[disabilityAssistance][]"
                    value="<?= $assistance->value ?>"
                    <?= $student->hasDisabilityAssistance($assistance) ? 'checked' : '' ?> />
                  <span class="form-check-label">
                    <?= $assistance->value ?>
                  </span>
                </label>
              <?php endforeach ?>
              <label class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  onchange="document.querySelector(`[name='student[otherDisabilityAssistance]']`).setAttribute('required', true)"
                  type="checkbox"
                  name="student[disabilityAssistance][]"
                  value="Otra"
                  <?= $student->otherDisabilityAssistance ? 'checked' : '' ?> />
                <span class="form-check-label">Otra</span>
              </label>
              <input
                class="form-control mt-3"
                placeholder="¿Cuál?"
                name="student[otherDisabilityAssistance]"
                value="<?= $student->otherDisabilityAssistance ?>" />
            </div>
          </div>
        </div>
      </div>
    </fieldset>
  </fieldset>
  <button class="btn btn-primary w-100 btn-lg">Actualizar</button>
</form>
