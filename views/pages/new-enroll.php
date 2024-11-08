<form method="post" class="card card-body">
  <header>
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
    <legend>1.- Datos del estudiante</legend>
    <div>
      <label for="student[idCard]">CI o pasaporte:</label>
      <label>
        V<input type="radio" name="student[nationality]" required value="V" />
      </label>
      <label>
        E<input type="radio" name="student[nationality]" required value="E" />
      </label>
      <input type="number" name="student[idCard]" id="student[idCard]" required />
      <label>
        Nombres: <input name="student[names]" required />
      </label>
      <label>
        Apellidos: <input name="student[lastNames]" required />
      </label>
    </div>
    <div>
      <label>
        Fecha de nacimiento: <input type="date" name="student[birth][date]" required />
      </label>
      <label>
        Lugar de nacimiento:
        <textarea name="student[birth][place]" required rows="1"></textarea>
      </label>
      <label>
        Entidad federal:
        <select name="student[birth][federalEntity]" required>
          <option value=""></option>
          <option>Amazonas</option>
          <option>Anzoátegui</option>
          <option>Apure</option>
          <option>Aragua</option>
          <option>Barinas</option>
          <option>Bolívar</option>
          <option>Carabobo</option>
          <option>Cojedes</option>
          <option>Delta Amacuro</option>
          <option>Distrito Capital</option>
          <option>Falcón</option>
          <option>Guárico</option>
          <option>Lara</option>
          <option>Mérida</option>
          <option>Miranda</option>
          <option>Monagas</option>
          <option>Nueva Esparta</option>
          <option>Portuguesa</option>
          <option>Sucre</option>
          <option>Táchira</option>
          <option>Trujillo</option>
          <option>Vargas</option>
          <option>Yaracuy</option>
          <option>Zulia</option>
          <option>Dependencias Federales</option>
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
          <option>Arawacos</option>
          <option>Caribes</option>
          <option>Guajiros</option>
          <option>Pemones</option>
          <option>Timotocuicas</option>
          <option>Yanomamis</option>
          <option>Wayúus</option>
          <option>Waraos</option>
          <option>Yukpas</option>
          <option>Piaroas</option>
          <option>Barís</option>
          <option>Kari'ñas</option>
          <option>Panares</option>
          <option>Pumés</option>
          <option>Makiritares</option>
        </select>
      </label>
    </div>
    <div>
      <label>
        Estatura (cm):
        <input type="number" step=".1" name="student[sizes][stature]" required />
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
          <option>S</option>
          <option>M</option>
          <option>L</option>
          <option>XL</option>
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
          <option>Diestro</option>
          <option>Zurdo</option>
          <option>Ambidiestro</option>
        </select>
      </label>
      <label>
        Género:
        <select name="student[genre]" required>
          <option value=""></option>
          <option>Masculino</option>
          <option>Femenino</option>
          <option value="">No busques más porque no hay más :v</option>
        </select>
      </label>
    </div>

    <fieldset>
      <legend>1.a.- Aspectos pedagógicos</legend>
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
          <option value=""></option>
          <option>Inglés</option>
          <option>Matemática</option>
          <option>Física</option>
          <option>Química</option>
          <option>Educación Física</option>
          <option>Biología</option>
        </select>
      </label>
    </fieldset>
    <fieldset>
      <legend>1.b.- Datos de salud</legend>
      <div>
        ¿Tiene alguna discapacidad?
        <label>
          <input
            type="checkbox"
            name="student[disabilities][]"
            value="Auditiva" />
          Auditiva
        </label>
        <label>
          <input
            type="checkbox"
            name="student[disabilities][]"
            value="Mental-psicológica" />
          Mental-psicológica
        </label>
        <label>
          <input
            type="checkbox"
            name="student[disabilities][]"
            value="Cardiovascular" />
          Cardiovascular
        </label>
        <label>
          <input
            type="checkbox"
            name="student[disabilities][]"
            value="Músculo esquelética" />
          Músculo esquelética
        </label>
        <label>
          <input
            type="checkbox"
            name="student[disabilities][]"
            value="Mental" />
          Mental
        </label>
        <label>
          <input
            type="checkbox"
            name="student[disabilities][]"
            value="Intelectual" />
          Intelectual
        </label>
        <label>
          <input
            type="checkbox"
            name="student[disabilities][]"
            value="Respiratoria" />
          Respiratoria
        </label>
        <label>
          <input
            type="checkbox"
            name="student[disabilities][]"
            value="Visual" />
          Visual
        </label>
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
        <label>
          <input
            onchange="document.querySelector(`[name='student[otherDisabilityAssistance]']`).removeAttribute('required')"
            type="checkbox"
            name="student[disabilityAssistance][]"
            value="Asistencia médica" />
          Asistencia médica
        </label>
        <label>
          <input
            onchange="document.querySelector(`[name='student[otherDisabilityAssistance]']`).removeAttribute('required')"
            type="checkbox"
            name="student[disabilityAssistance][]"
            value="Medicamentos" />
          Medicamentos
        </label>
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
  <button>Inscribir</button>
</form>
