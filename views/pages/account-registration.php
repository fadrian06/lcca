<?php

use LCCA\App;
use Leaf\Flash;

App::renderComponent('secret-questions', ['id' => 'secretQuestions']);
$lastData = (array) Flash::display('lastData');

?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
      <form
        method="post"
        class="my-5"
        x-data="{ secretQuestion: '' }">
        <div class="border border-dark rounded-2 p-4 mt-5 card">
          <div class="login-form">
            <a href="./" class="mb-4 d-flex">
              <img
                src="./assets/images/logo-sm.svg"
                height="48" />
            </a>
            <h5 class="fw-light mb-5">Crea tu cuenta de coordinador.</h5>
            <div class="mb-3">
              <label class="form-label">Tu nombre</label>
              <input
                name="nombre"
                required
                class="form-control"
                placeholder="Introduce tu nombre"
                pattern="[a-zA-ZáéíóúñÁÉÍÓÚÑ]{3,}"
                title="El nombre sólo puede tener mínimo 3 letras"
                value="<?= $lastData['nombre'] ?? '' ?>" />
            </div>
            <div class="mb-3">
              <label class="form-label">Tu cédula</label>
              <input
                type="number"
                name="cédula"
                required
                class="form-control"
                placeholder="Introduce tu cédula"
                min="0"
                value="<?= $lastData['cédula'] ?? '' ?>" />
            </div>
            <div class="mb-3">
              <label class="form-label">Tu contraseña</label>
              <input
                type="password"
                name="contraseña"
                required
                class="form-control"
                placeholder="Introduce tu contraseña"
                pattern="(?=.*\d)(?=.*[A-ZÑ])(?=.*\W).{8,}"
                title="La contraseña debe tener al menos 8 caracteres, un número, un símbolo y una mayúscula"
                value="<?= $lastData['contraseña'] ?? '' ?>" />
            </div>
            <div class="mb-3">
              <label class="form-label">Pregunta de seguridad</label>
              <input
                name="pregunta_secreta"
                required
                class="form-control"
                placeholder="Introduce tu pregunta"
                value="<?= $lastData['pregunta_secreta'] ?? '' ?>"
                x-model="secretQuestion"
                list="secretQuestions" />
            </div>
            <div class="mb-3">
              <label class="form-label">Respuesta de seguridad</label>
              <input
                type="password"
                name="respuesta_secreta"
                required
                class="form-control"
                :placeholder="`Introduce tu respuesta a: ${secretQuestion}`"
                value="<?= $lastData['respuesta_secreta'] ?? '' ?>" />
            </div>
            <div class="d-grid py-3 mt-4">
              <button type="submit" class="btn btn-lg btn-primary">
                Crear cuenta
              </button>
            </div>
            <div class="text-center pt-4">
              <span>¿Ya tienes una cuenta?</span>
              <a href="./ingresar" class="text-blue text-decoration-underline ms-2">
                Ingresa
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
