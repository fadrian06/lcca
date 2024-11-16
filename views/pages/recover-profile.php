<?php

use LCCA\Models\UserModel;

/** @var ?UserModel $userFound */

?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
      <?php if ($userFound): ?>
        <form class="my-5" method="post">
          <div class="border border-dark rounded-2 p-4 mt-5">
            <div class="login-form">
              <a href="./" class="mb-4 d-flex">
                <img src="./assets/images/logo-sm.svg" height="48" />
              </a>
              <h5 class="fw-light mb-5 lh-2">
                Con el fin de acceder a tu cuenta, por favor introduce la
                respuesta secreta que has proporcionado durante el proceso de
                registro.
              </h5>
              <div class="mb-3">
                <label class="form-label">Tu pregunta</label>
                <input
                  readonly
                  disabled
                  class="form-control"
                  value="<?= $userFound->secretQuestion ?>" />
              </div>
              <div class="mb-3">
                <label class="form-label">Tu respuesta</label>
                <input
                  type="password"
                  name="secretAnswer"
                  required
                  class="form-control"
                  placeholder="Introduce tu respuesta" />
              </div>
              <div class="d-grid py-3 mt-4">
                <button class="btn btn-lg btn-primary">
                  Cambiar contraseña
                </button>
              </div>
            </div>
          </div>
        </form>
      <?php else: ?>
        <form class="my-5">
          <div class="border border-dark rounded-2 p-4 mt-5">
            <div class="login-form">
              <a href="./" class="mb-4 d-flex">
                <img src="./assets/images/logo-sm.svg" height="48" />
              </a>
              <h5 class="fw-light mb-5 lh-2">
                Con el fin de acceder a tu cuenta, por favor introduce la cédula
                que has proporcionado durante el proceso de registro.
              </h5>
              <div class="mb-3">
                <label class="form-label">Tu cédula</label>
                <input
                  type="number"
                  name="cedula"
                  required
                  min="0"
                  class="form-control"
                  placeholder="Introduce tu cédula" />
              </div>
              <div class="d-grid py-3 mt-4">
                <button class="btn btn-lg btn-primary">
                  Solicitar pregunta secreta
                </button>
              </div>
            </div>
          </div>
        </form>
      <?php endif ?>
    </div>
  </div>
</div>
