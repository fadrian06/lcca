<?php

use LCCA\App;

?>

<div class="row">
  <div class="col-xxl-12">
    <form method="post" class="card shadow mb-4">
      <div class="card-header">
        <h5 class="card-title">Registrar docente</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-4 col-12 mb-3">
            <label class="form-label">Nombre</label>
            <input
              name="name"
              required
              class="form-control"
              placeholder="Introduce el nombre"
              pattern="[a-zA-ZáéíóúñÁÉÍÓÚÑ]{3,}"
              title="El nombre sólo puede tener mínimo 3 letras" />
          </div>
          <div class="col-sm-4 col-12 mb-3">
            <label class="form-label">Cédula</label>
            <input
              type="number"
              name="idCard"
              required
              class="form-control"
              placeholder="Introduce tu cédula"
              min="0" />
          </div>
          <div class="col-sm-4 col-12 mb-3">
            <label class="form-label">Crear contraseña</label>
            <input
              type="password"
              name="password"
              required
              minlength="8"
              class="form-control"
              placeholder="Introduce la contraseña" />
          </div>
          <div class="col-sm-4 col-12 mb-3">
            <label class="form-label">Establecer pregunta de seguridad</label>
            <input
              onchange="document.querySelector('[name=secretAnswer]').setAttribute('placeholder', `Respuesta a: ${this.value}`)"
              name="secretQuestion"
              required
              class="form-control"
              placeholder="Introduce la pregunta" />
          </div>
          <div class="col-sm-4 col-12 mb-3">
            <label class="form-label">Establecer respuesta de seguridad</label>
            <input
              type="password"
              name="secretAnswer"
              required
              class="form-control"
              placeholder="Introduce la respuesta" />
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="d-flex gap-2 justify-content-end">
          <a
            href="<?= App::request()->referrer ?>"
            class="btn btn-outline-secondary">
            Cancelar
          </a>
          <button class="btn btn-primary">Registrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
