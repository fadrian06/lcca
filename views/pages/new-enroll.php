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
use LCCA\Models\SubjectModel;
use LCCA\Models\UserModel;

/**
 * @var SubjectModel[] $subjects
 * @var UserModel[] $teachers
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
    <h1>FICHA DE INSCRIPCIÓN</h1>
    <label>
      <select name="studyYear" required class="form-select">
        <option value="">Año</option>
        <?php foreach (StudyYear::cases() as $studyYear): ?>
          <option value="<?= $studyYear->value ?>"><?= $studyYear->value ?>°</option>
        <?php endforeach ?>
      </select>
    </label>
    <label>
      <select name="section" required class="form-select">
        <option value="">Sección</option>
        <?php foreach (Section::cases() as $section) ?>
        <option><?= $section->value ?></option>
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
                  value="<?= $nationality->value ?>" />
              </div>
            <?php endforeach ?>
          </div>
          <input
            class="form-control"
            type="number"
            name="student[idCard]"
            id="student[idCard]"
            required />
        </div>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Nombres:</span>
          <input class="form-control" name="student[names]" required />
        </label>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Apellidos:</span>
          <input class="form-control" name="student[lastNames]" required />
        </label>
      </div>
      <div class="col-md-5">
        <label class="input-group mb-3">
          <span class="input-group-text">Fecha de<br />nacimiento:</span>
          <input
            class="form-control"
            type="date"
            name="student[birth][date]"
            required />
        </label>
      </div>
      <div class="col-md-7">
        <label class="input-group mb-3">
          <span class="input-group-text">Lugar de<br />nacimiento:</span>
          <textarea
            class="form-control"
            name="student[birth][place]"
            required
            rows="1"></textarea>
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
                  <option><?= $federalEntity->value ?></option>
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
                value="Sí" />
              <span class="form-check-label">Sí</span>
            </label>
            <label class="form-check">
              <input
                class="form-check-input"
                onchange="document.querySelector(`[name='student[indigenousPeople]']`).removeAttribute('required')"
                type="radio"
                required
                name="student[isIndigenous]"
                value="No" />
              <span class="form-check-label">No</span>
            </label>
          </div>
          <select name="student[indigenousPeople]" class="form-control">
            <option value="" selected>¿Cuál?</option>
            <optgroup>
              <?php foreach (IndigenousPeople::valuesSorted() as $indigenousPeople): ?>
                <option><?= $indigenousPeople ?></option>
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
            required />
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
            required />
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
            placeholder="Zapato" />
          <select class="form-select" name="student[sizes][shirt]" required>
            <option value="">Camisa</option>
            <optgroup>
              <?php foreach (ShirtSize::cases() as $shirtSize): ?>
                <option><?= $shirtSize->value ?></option>
              <?php endforeach ?>
            </optgroup>
          </select>
          <input
            class="form-control"
            placeholder="Pantalón"
            type="number"
            name="student[sizes][pants]"
            required />
        </div>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Lateralidad:</span>
          <select class="form-select" name="student[laterality]" required>
            <option value=""></option>
            <?php foreach (Laterality::cases() as $laterality): ?>
              <option><?= $laterality->value ?></option>
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
              <option><?= $genre->value ?></option>
            <?php endforeach ?>
          </select>
        </label>
      </div>
    </div>

    <fieldset class="my-3">
      <legend>1.a.- ASPECTOS PEDAGÓGICOS</legend>
      <div class="row">
        <div class="col-md-4">
          <div class="input-group mb-3">
            <span class="input-group-text">
              ¿Posee<br />Colección<br />Bicentenario?
            </span>
            <div class="form-control">
              <label class="form-check">
                <span class="form-check-label">(Sí)</span>
                <input
                  class="form-check-input"
                  type="radio"
                  name="student[hasBicentennialCollection]"
                  required
                  value="Sí" />
              </label>
              <label class="form-check">
                <span class="form-check-label">(No)</span>
                <input
                  class="form-check-input"
                  type="radio"
                  name="student[hasBicentennialCollection]"
                  required
                  value="No" />
              </label>
            </div>
          </div>
        </div>
        <div class="col-md-3">
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
                  value="Sí" />
              </label>
              <label class="form-check">
                <span class="form-check-label">(No)</span>
                <input
                  class="form-check-input"
                  type="radio"
                  name="student[hasCanaima]"
                  required
                  value="No" />
              </label>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <label class="input-group mb-3">
            <span class="input-group-text">Materias<br />pendientes:</span>
            <select
              class="form-select"
              name="student[pendingSubjects][]"
              multiple>
              <?php foreach ($subjects as $subject): ?>
                <option value="<?= $subject->id ?>"><?= $subject ?></option>
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
                <option><?= $disability->value ?></option>
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
                  value="Sí" />
              </label>
              <label class="form-check form-check-inline">
                <span class="form-check-label">(No)</span>
                <input
                  class="form-check-input"
                  type="radio"
                  name="student[hasDisabilityAssistance]"
                  required
                  value="No" />
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
                    value="<?= $assistance->value ?>" />
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
                  value="Otra" />
                <span class="form-check-label">Otra</span>
              </label>
              <input
                class="form-control mt-3"
                placeholder="¿Cuál?"
                name="student[otherDisabilityAssistance]" />
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
                  value="<?= $nationality->value ?>" />
              </label>
            <?php endforeach ?>
          </div>
          <input
            class="form-control"
            type="number"
            name="representative[idCard]"
            id="representative[idCard]"
            required />
        </div>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Nombres:</span>
          <input
            class="form-control"
            name="representative[names]"
            required />
        </label>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Apellidos:</span>
          <input
            class="form-control"
            name="representative[lastNames]"
            required />
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
                  value="<?= $educationLevel->value ?>" />
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
          <input class="form-control" name="representative[job]" required />
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
            title="El teléfono debe tener 11 dígitos (Ej: 04165335826)" />
        </label>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Correo<br />electrónico:</span>
          <input
            class="form-control"
            type="email"
            name="representative[email]"
            required />
        </label>
      </div>
      <div class="col-md-6">
        <label class="input-group mb-3">
          <span class="input-group-text">Dirección:</span>
          <textarea
            class="form-control"
            name="representative[address]"
            required
            rows="2"></textarea>
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
            title="El número de cuenta debe tener al menos 20 dígitos (Ej: 01020859940000533182)" />
        </label>
      </div>
    </div>
    <fieldset class="my-3">
      <legend>2.1.- DATOS SOCIOECONÓMICOS</legend>
      <div class="row">
        <div class="col-md-4">
          <label class="input-group mb-3">
            <span class="input-group-text">Ocupación:</span>
            <textarea
              class="form-control"
              name="representative[occupation]"
              required
              rows="2"></textarea>
          </label>
        </div>
        <div class="col-md-3">
          <div class="input-group mb-3">
            <span class="input-group-text">¿Es jefe de<br />familia?</span>
            <div class="form-control">
              <label class="form-check">
                <input
                  class="form-check-input"
                  type="radio"
                  name="representative[isFamilyBoss]"
                  required
                  value="Sí" />
                <span class="form-check-label">Sí</span>
              </label>
              <label class="form-check">
                <input
                  class="form-check-input"
                  type="radio"
                  name="representative[isFamilyBoss]"
                  required
                  value="No" />
                <span class="form-check-label">No</span>
              </label>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <label class="input-group mb-3">
            <input
              class="form-control"
              placeholder="Ingreso familiar mensual"
              type="number"
              step=".01"
              name="representative[monthlyFamilyIncome]"
              required />
            <span class="input-group-text">En<br />Bs.</span>
          </label>
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
                required />
              <span class="form-check-label">Sí</span>
            </label>
            <label class="form-check">
              <input
                class="form-check-input"
                onchange="document.querySelector(`[name='representative[jobRole]']`).removeAttribute('required'); document.querySelector(`[name='representative[companyOrInstitutionName]']`).removeAttribute('required')"
                type="radio"
                name="representative[works]"
                value="No"
                required />
              <span class="form-check-label">No</span>
            </label>
          </div>
          <input
            class="form-control"
            placeholder="Cargo y funciones"
            name="representative[jobRole]" />
        </div>
        <label class="input-group mb-3">
          <span class="input-group-text">Nombre de la empresa/institución</span>
          <input
            class="form-control"
            name="representative[companyOrInstitutionName]" />
        </label>
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
          <span class="input-group-text">Docente:</span>
          <select name="teacherId" required class="form-select">
            <option value=""></option>
            <?php foreach ($teachers as $teacher): ?>
              <option value="<?= $teacher->id ?>">
                <?= $teacher ?>
              </option>
            <?php endforeach ?>
          </select>
        </label>
      </div>
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
  <button class="btn btn-primary w-100 btn-lg">Inscribir</button>
</form>
