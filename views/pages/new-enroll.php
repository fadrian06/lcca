<?php

use LCCA\Enums\Disability;
use LCCA\Enums\DisabilityAssistance;
use LCCA\Enums\EducationLevel;
use LCCA\Enums\FederalEntity;
use LCCA\Enums\Genre;
use LCCA\Enums\IndigenousPeople;
use LCCA\Enums\Laterality;
use LCCA\Enums\Nationality;
use LCCA\Enums\ShirtSize;
use LCCA\Enums\Subject;

?>

<form method="post" class="card card-body">
  <header class="text-center">
    <p>
      República Bolivariana de Venezuela<br />
      Ministerio del Poder Popular para la Educación<br />
      Liceo "Cinta Cervera Audi"<br />
      El Pinar, Estado Mérida<br />
      Año escolar <?= date('Y') ?>-<?= date('Y') + 1 ?>
    </p>
    <h1>FICHA DE INSCRIPCIÓN</h1>
    <label>
      Año
      <select name="studyYear" required>
        <option value=""></option>
        <?php foreach (range(1, 5) as $year): ?>
          <option value="<?= $year ?>"><?= $year ?>°</option>
        <?php endforeach ?>
      </select>
    </label>
    <label>
      Sección
      <select name="section" required>
        <option value=""></option>
        <option>A</option>
        <option>B</option>
      </select>
    </label>
  </header>

  <fieldset>
    <legend>1.- DATOS DEL ESTUDIANTE</legend>
    <div>
      <label for="student[idCard]">CI o pasaporte:</label>
      <?php foreach (Nationality::cases() as $nationality): ?>
        <label>
          <?= $nationality->value ?>
          <input
            type="radio"
            name="student[nationality]"
            required
            value="<?= $nationality->value ?>" />
        </label>
      <?php endforeach ?>
      <input
        type="number"
        name="student[idCard]"
        id="student[idCard]"
        required />
      <label>
        Nombres: <input name="student[names]" required />
      </label>
      <label>
        Apellidos: <input name="student[lastNames]" required />
      </label>
    </div>
    <div>
      <label>
        Fecha de nacimiento:
        <input type="date" name="student[birth][date]" required />
      </label>
      <label>
        Lugar de nacimiento:
        <textarea name="student[birth][place]" required rows="1"></textarea>
      </label>
      <label>
        Entidad federal:
        <select name="student[birth][federalEntity]" required>
          <option value=""></option>
          <?php foreach (FederalEntity::cases() as $federalEntity): ?>
            <option><?= $federalEntity->value ?></option>
          <?php endforeach ?>
        </select>
      </label>
    </div>
    <div>
      ¿Pertenece a un pueblo indígena?
      <label>
        <input
          onchange="document.querySelector(`[name='student[indigenousPeople]']`).setAttribute('required', true)"
          type="radio"
          required
          name="student[isIndigenous]"
          value="Sí" />
        Sí
      </label>
      <label>
        <input
          onchange="document.querySelector(`[name='student[indigenousPeople]']`).removeAttribute('required')"
          type="radio"
          required
          name="student[isIndigenous]"
          value="No" />
        No
      </label>
      <label>
        ¿Cuál?
        <select name="student[indigenousPeople]">
          <option value=""></option>
          <?php foreach (IndigenousPeople::cases() as $indigenousPeople): ?>
            <option><?= $indigenousPeople->value ?></option>
          <?php endforeach ?>
        </select>
      </label>
    </div>
    <div>
      <label>
        Estatura (cm):
        <input
          type="number"
          step=".1"
          name="student[sizes][stature]"
          required />
      </label>
      <label>
        Peso (kg):
        <input type="number" step=".1" name="student[sizes][weight]" required />
      </label>
      TALLAS:
      <label>
        Zapato:
        <input type="number" name="student[sizes][shoe]" required />
      </label>
      <label>
        Camisa:
        <select name="student[sizes][shirt]" required>
          <option value=""></option>
          <?php foreach (ShirtSize::cases() as $shirtSize): ?>
            <option><?= $shirtSize->value ?></option>
          <?php endforeach ?>
        </select>
      </label>
      <label>
        Pantalón:
        <input type="number" name="student[sizes][pants]" required />
      </label>
      <label>
        Lateralidad:
        <select name="student[laterality]" required>
          <option value=""></option>
          <?php foreach (Laterality::cases() as $laterality): ?>
            <option><?= $laterality->value ?></option>
          <?php endforeach ?>
        </select>
      </label>
      <label>
        Género:
        <select name="student[genre]" required>
          <option value=""></option>
          <?php foreach (Genre::cases() as $genre): ?>
            <option><?= $genre->value ?></option>
          <?php endforeach ?>
        </select>
      </label>
    </div>

    <fieldset>
      <legend>1.a.- ASPECTOS PEDAGÓGICOS</legend>
      Posee Colección Bicentenario
      <label>
        (Sí)
        <input
          type="radio"
          name="student[haveBicentennialCollection]"
          required
          value="Sí" />
      </label>
      <label>
        (No)
        <input
          type="radio"
          name="student[haveBicentennialCollection]"
          required
          value="No" />
      </label>
      Canaima
      <label>
        (Sí)
        <input
          type="radio"
          name="student[haveCanaima]"
          required
          value="Sí" />
      </label>
      <label>
        (No)
        <input
          type="radio"
          name="student[haveCanaima]"
          required
          value="No" />
      </label>
      <label>
        Materias pendientes:
        <select name="student[pendingSubjects][]" multiple>
          <?php foreach (Subject::cases() as $subject): ?>
            <option><?= $subject->value ?></option>
          <?php endforeach ?>
        </select>
      </label>
    </fieldset>
    <fieldset>
      <legend>1.b.- Datos de salud</legend>
      <div>
        ¿Tiene alguna discapacidad?
        <?php foreach (Disability::cases() as $disability): ?>
          <label>
            <input
              type="checkbox"
              name="student[disabilities][]"
              value="<?= $disability->value ?>" />
            <?= $disability->value ?>
          </label>
        <?php endforeach ?>
      </div>
      <div>
        ¿Recibe ayuda por discapacidad?
        <label>
          <input
            type="radio"
            name="student[haveDisabilityAssistance]"
            required
            value="Sí" />
          Sí
        </label>
        <label>
          (No)
          <input
            type="radio"
            name="student[haveDisabilityAssistance]"
            required
            value="No" />
        </label>
        ¿Cuál?
        <?php foreach (DisabilityAssistance::cases() as $assistance): ?>
          <label>
            <input
              onchange="document.querySelector(`[name='student[otherDisabilityAssistance]']`).removeAttribute('required')"
              type="checkbox"
              name="student[disabilityAssistance][]"
              value="<?= $assistance->value ?>" />
            <?= $assistance->value ?>
          </label>
        <?php endforeach ?>
        <label>
          <input
            onchange="document.querySelector(`[name='student[otherDisabilityAssistance]']`).setAttribute('required', true)"
            type="checkbox"
            name="student[disabilityAssistance][]"
            value="Otra" />
          Otra
        </label>
        <label>
          ¿Cuál?
          <input name="student[otherDisabilityAssistance]" />
        </label>
      </div>
    </fieldset>
  </fieldset>
  <fieldset>
    <legend>2.- DATOS PERSONALES DEL PADRE Y/O REPRESENTANTE</legend>
    <div>
      <label for="representative[idCard]">CI o pasaporte:</label>
      <?php foreach (Nationality::cases() as $nationality): ?>
        <label>
          <?= $nationality->value ?>
          <input
            type="radio"
            name="representative[nationality]"
            required
            value="<?= $nationality->value ?>" />
        </label>
      <?php endforeach ?>
      <input
        type="number"
        name="representative[idCard]"
        id="representative[idCard]"
        required />
      <label>
        Nombres: <input name="representative[names]" required />
      </label>
      <label>
        Apellidos: <input name="representative[lastNames]" required />
      </label>
    </div>
    <div>
      Nivel de instrucción:
      <?php foreach (EducationLevel::cases() as $educationLevel): ?>
        <label>
          <input
            type="radio"
            name="representative[educationLevel]"
            required
            value="<?= $educationLevel->value ?>" />
          <?= $educationLevel->value ?>
        </label>
      <?php endforeach ?>
    </div>
    <div>
      <label>
        Arte o oficio:
        <input name="representative[job]" required />
      </label>
      <label>
        Teléfono de contacto:
        <input
          type="tel"
          name="representative[phone]"
          required
          minlength="11"
          maxlength="11"
          pattern="[0-9]{11}"
          title="El teléfono debe tener 11 dígitos (Ej: 04165335826)" />
      </label>
      <label>
        Correo: <input type="email" name="representative[email]" required />
      </label>
      <label>
        Dirección:
        <textarea name="representative[address]" required rows="1"></textarea>
      </label>
      <label>
        Nro. de cuenta:
        <input
          type="tel"
          name="representative[bankAccountNumber]"
          required
          minlength="20"
          maxlength="20"
          pattern="[0-9]{20}"
          title="El número de cuenta debe tener al menos 20 dígitos (Ej: 01020859940000533182)" />
      </label>
    </div>
    <fieldset>
      <legend>2.1.- DATOS SOCIOECONÓMICOS</legend>
      <div>
        <label>
          Ocupación: <input name="representative[occupation]" required />
        </label>
        ¿Es jefe de familia?
        <label>
          <input
            type="radio"
            name="representative[isFamilyBoss]"
            required
            value="Sí" />
          Sí
        </label>
        <label>
          <input
            type="radio"
            name="representative[isFamilyBoss]"
            required
            value="No" />
          No
        </label>
      </div>
      <div>
        ¿Trabaja actualmente?
        <label>
          <input
            onchange="document.querySelector(`[name='representative[jobRole]']`).setAttribute('required', true); document.querySelector(`[name='representative[companyOrInstitutionName]']`).setAttribute('required', true)"
            type="radio"
            name="representative[works]"
            value="Sí"
            required />
          Sí
        </label>
        <label>
          <input
            onchange="document.querySelector(`[name='representative[jobRole]']`).removeAttribute('required'); document.querySelector(`[name='representative[companyOrInstitutionName]']`).removeAttribute('required')"
            type="radio"
            name="representative[works]"
            value="No"
            required />
          No
        </label>
        <label>
          Cargo y funciones:
          <input name="representative[jobRole]" />
        </label>
        <label>
          Nombre de la empresa/institución:
          <input name="representative[companyOrInstitutionName]" />
        </label>
        <label>
          Ingreso familiar mensual:
          <input
            type="number"
            step=".01"
            name="representative[monthlyFamilyIncome]"
            required />
          Bs.
        </label>
      </div>
    </fieldset>
  </fieldset>
  <footer>
    <h2>ACTA DE COMPROMISO</h2>
    Del Representante:
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

    Del Estudiante:
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
    <div>
      <label>
        Docente:
        <input name="teacher" required />
      </label>
      <!-- <label>
        REPRESENTANTE:
        <input name="representative[signature]" required />
      </label> -->
    </div>
    <div>
      <label>
        Fecha:
        <input type="date" name="date" value="<?= date('Y-m-d') ?>" required />
      </label>
      <!-- <label>
        ESTUDIANTE:
        <input name="student[signature]" required />
      </label> -->
    </div>
  </footer>
  <button>Inscribir</button>
</form>
