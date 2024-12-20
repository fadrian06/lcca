<?php

use LCCA\Enums\Disability;
use LCCA\Enums\DisabilityAssistance;
use LCCA\Enums\EducationLevel;
use LCCA\Enums\FederalEntity;
use LCCA\Enums\Genre;
use LCCA\Enums\IndigenousPeople;
use LCCA\Enums\Laterality;
use LCCA\Enums\Nationality;
use LCCA\Enums\Section;
use LCCA\Enums\ShirtSize;
use LCCA\Enums\StudyYear;
use LCCA\Models\StudentModel;
use LCCA\Models\SubjectModel;

/**
 * @var StudentModel $student
 * @var SubjectModel[] $subjects
 */

?>

<form method="post" class="card card-body">
  <header class="text-center">
    <p class="h5">
      República Bolivariana de Venezuela<br />
      Ministerio del Poder Popular para la Educación<br />
      Liceo "Cinta Cervera Audi"<br />
      El Pinar, Estado Mérida<br />
      Año escolar <?= date('Y') ?>-<?= date('Y') + 1 ?>
    </p>
    <h1>FICHA DE REINSCRIPCIÓN</h1>
    <label>
      <select name="studyYear" required class="form-select">
        <option value="">Año</option>
        <?php foreach (StudyYear::cases() as $studyYear): ?>
          <?php if ($student->isRetired): ?>
            <option
              <?= $student->studyYear->isGreaterThan($studyYear) ? 'disabled' : '' ?>
              value="<?= $studyYear->value ?>">
              <?= $studyYear->value ?>°
            </option>
          <?php else: ?>
            <option
              <?= $student->studyYear->isGreaterOrEqualThan($studyYear) ? 'disabled' : '' ?>
              value="<?= $studyYear->value ?>">
              <?= $studyYear->value ?>°
            </option>
          <?php endif ?>
        <?php endforeach ?>
      </select>
    </label>
    <label>
      <select name="section" required class="form-select">
        <option value="">Sección</option>
        <?php foreach (Section::cases() as $section): ?>
          <option><?= $section->value ?></option>
        <?php endforeach ?>
      </select>
    </label>
  </header>

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
  <fieldset class="my-3">
    <legend>2.- DATOS PERSONALES DEL PADRE Y/O REPRESENTANTE</legend>
    <div class="row">
      <div class="col-md-12">
        <div class="input-group mb-3">
          <label class="input-group-text" for="representative[idCard]">
            CI o<br />pasaporte:
          </label>
          <div class="input-group-text d-grid">
            <?php foreach (Nationality::cases() as $nationality): ?>
              <label class="form-check">
                <span class="form-check-label"><?= $nationality->value ?></span>
                <input
                  class="form-check-input"
                  type="radio"
                  name="representative[nationality]"
                  required
                  value="<?= $nationality->value ?>"
                  <?= $student->currentRepresentative->isFromNationality($nationality) ? 'checked' : '' ?> />
              </label>
            <?php endforeach ?>
          </div>
          <input
            class="form-control"
            type="number"
            name="representative[idCard]"
            id="representative[idCard]"
            required
            value="<?= $student->currentRepresentative->idCard ?>" />
        </div>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Nombres:</span>
          <input
            class="form-control"
            name="representative[names]"
            required
            value="<?= $student->currentRepresentative->names ?>" />
        </label>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Apellidos:</span>
          <input
            class="form-control"
            name="representative[lastNames]"
            required
            value="<?= $student->currentRepresentative->lastNames ?>" />
        </label>
      </div>
      <div class="col-md-7">
        <div class="input-group mb-3">
          <span class="input-group-text">Nivel de<br />instrucción:</span>
          <div class="form-control">
            <?php foreach (EducationLevel::cases() as $educationLevel): ?>
              <label class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="radio"
                  name="representative[educationLevel]"
                  required
                  value="<?= $educationLevel->value ?>"
                  <?= $student->currentRepresentative->hasEducationLevel($educationLevel) ? 'checked' : '' ?> />
                <span class="form-check-label">
                  <?= $educationLevel->value ?>
                </span>
              </label>
            <?php endforeach ?>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <label class="input-group mb-3">
          <span class="input-group-text">Arte o<br />oficio:</span>
          <input
            class="form-control"
            name="representative[job]"
            required
            value="<?= $student->currentRepresentative->job ?>" />
        </label>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Teléfono de<br />contacto:</span>
          <input
            class="form-control"
            type="tel"
            name="representative[phone]"
            required
            minlength="11"
            maxlength="11"
            pattern="[0-9]{11}"
            title="El teléfono debe tener 11 dígitos (Ej: 04165335826)"
            value="<?= $student->currentRepresentative->phone ?>" />
        </label>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Correo<br />electrónico:</span>
          <input
            class="form-control"
            type="email"
            name="representative[email]"
            required
            value="<?= $student->currentRepresentative->email ?>" />
        </label>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Dirección:</span>
          <textarea
            class="form-control"
            name="representative[address]"
            required
            rows="2"><?= $student->currentRepresentative->address ?></textarea>
        </label>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Nro. de<br />cuenta:</span>
          <input
            class="form-control"
            type="tel"
            name="representative[bankAccountNumber]"
            required
            minlength="20"
            maxlength="20"
            pattern="[0-9]{20}"
            title="El número de cuenta debe tener al menos 20 dígitos (Ej: 01020859940000533182)"
            value="<?= $student->currentRepresentative->bankAccountNumber ?>" />
        </label>
      </div>
    </div>
    <fieldset class="my-3">
      <legend>2.1.- DATOS SOCIOECONÓMICOS</legend>
      <div class="row">
        <div class="col-md-6">
          <label class="input-group mb-3">
            <span class="input-group-text">Ocupación:</span>
            <textarea
              class="form-control"
              name="representative[occupation]"
              required
              rows="1"><?= $student->currentRepresentative->occupation ?></textarea>
          </label>
        </div>
        <div class="col-md-6">
          <div class="input-group mb-3">
            <span class="input-group-text">¿Es jefe de familia?</span>
            <div class="form-control">
              <label class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="radio"
                  name="representative[isFamilyBoss]"
                  required
                  value="Sí"
                  <?= $student->currentRepresentative->isFamilyBoss ? 'checked' : '' ?> />
                <span class="form-check-label">Sí</span>
              </label>
              <label class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="radio"
                  name="representative[isFamilyBoss]"
                  required
                  value="No"
                  <?= !$student->currentRepresentative->isFamilyBoss ? 'checked' : '' ?> />
                <span class="form-check-label">No</span>
              </label>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="input-group mb-3">
            <span class="input-group-text">¿Trabaja<br />actualmente?</span>
            <div class="input-group-text d-grid">
              <label class="form-check">
                <input
                  class="form-check-input"
                  onchange="document.querySelector(`[name='representative[jobRole]']`).setAttribute('required', true); document.querySelector(`[name='representative[companyOrInstitutionName]']`).setAttribute('required', true)"
                  type="radio"
                  name="representative[works]"
                  value="Sí"
                  required
                  <?= $student->currentRepresentative->works ? 'checked' : '' ?> />
                <span class="form-check-label">Sí</span>
              </label>
              <label class="form-check">
                <input
                  class="form-check-input"
                  onchange="document.querySelector(`[name='representative[jobRole]']`).removeAttribute('required'); document.querySelector(`[name='representative[companyOrInstitutionName]']`).removeAttribute('required')"
                  type="radio"
                  name="representative[works]"
                  value="No"
                  required
                  <?= !$student->currentRepresentative->works ? 'checked' : '' ?> />
                <span class="form-check-label">No</span>
              </label>
            </div>
            <input
              class="form-control"
              placeholder="Cargo y funciones"
              name="representative[jobRole]"
              value="<?= $student->currentRepresentative->jobRole ?>" />
          </div>
        </div>
        <div class="col-md-6">
          <label class="input-group mb-3">
            <span class="input-group-text">
              Nombre de la<br />empresa/institución
            </span>
            <input
              class="form-control"
              name="representative[companyOrInstitutionName]"
              value="<?= $student->currentRepresentative->companyOrInstitutionName ?>" />
          </label>
        </div>
        <div class="col-md-6">
          <label class="input-group mb-3">
            <span class="input-group-text">Ingreso familiar<br />mensual</span>
            <input
              class="form-control"
              type="number"
              step=".01"
              name="representative[monthlyFamilyIncome]"
              required
              value="<?= $student->currentRepresentative->monthlyFamilyIncome ?>" />
            <span class="input-group-text">Bs.</span>
          </label>
        </div>
      </div>
    </fieldset>
  </fieldset>
  <footer>
    <h2>ACTA DE COMPROMISO</h2>
    <h3>Del Representante:</h3>
    <ul>
      <li>
        Garantizar que sus hijos cumplan con la obligatoria asistencia a clases
        y con el horario escolar establecido.
      </li>
      <li>
        Evitar que su representado traiga al Colegio objetos ajenos a la
        actividad escolar.
      </li>
      <li>
        Cuidar que su representado asista a clases con el traje escolar
        reglamentario y que éste cumpla con las normas de presentación
        e higiene.
      </li>
      <li>
        Contribuir al desarrollo de las actividades escolares, científicas,
        sociales, religiosas, culturales y deportivas que contribuyan a la
        formación integral del educando.
      </li>
      <li>
        Asistir en forma activa y comprometida a todas las reuniones y
        asambleas por el plantel.
      </li>
      <li>
        Conversar directamente con el Profesor Guía en caso de que se presente
        algún problema con su representado.
      </li>
      <li>
        Ser responsable por los daños que ocasione su representado a los
        bienes, muebles, inmuebles u otros del plantel, en caso de ser
        comprobado tal situación deberá repararlo en conjunto con
        su representado.
      </li>
    </ul>
    <h3>Del Estudiante:</h3>
    <ul>
      <li>Cumplimiento en el horario de clase establecido</li>
      <li>Honrar y Respetar los símbolos patrios.</li>
      <li>Asistir diaria y puntualmente a las actividades escolares.</li>
      <li>
        Está prohibido el uso de teléfonos celulares, o cualquier dispositivo
        electrónico que interfiera el desarrollo de las actividades académicas.
      </li>
      <li>
        Se prohíbe el uso de vehículos (motos) a todos los estudiantes dentro
        de las instalaciones del Plantel.
      </li>
      <li>
        El traje escolar debe usarse sin ningún tipo de accesorios. No está
        permitido el uso de piercings, tatuajes La franela debe llevarse por
        dentro del pantalón o de la falda en horas de clases y receso, El
        pantalón debe ser: azul marino, de algodón, poliéster o gabardina, de
        corte recto y sin adornos, Los zapatos de uso diario deben ser negros
        y cerrados
      </li>
      <li>
        El cabello debe llevarse de un modo ajustado a la presentación general,
        lo suficientemente corto, natural, peinado y limpio.
      </li>
    </ul>
    <div class="row">
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Fecha:</span>
          <input
            class="form-control"
            type="date"
            name="date"
            value="<?= date('Y-m-d') ?>"
            required />
        </label>
      </div>
    </div>
  </footer>
  <button class="btn btn-primary w-100 btn-lg">Reinscribir</button>
</form>
