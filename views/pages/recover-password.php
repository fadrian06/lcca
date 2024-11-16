<?php

use LCCA\Models\UserModel;

/** @var UserModel $userFound */

?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
      <form
        method="post"
        action="./perfil/recuperar/<?= $userFound->idCard ?>/cambiar-clave"
        class="my-5">
        <div class="border border-dark rounded-2 p-4 mt-5">
          <div class="login-form">
            <a href="./" class="mb-4 d-flex">
              <img src="./assets/images/logo-sm.svg" height="48" />
            </a>
            <h5 class="fw-light mb-5 lh-2">
              Con el fin de acceder a tu cuenta, por favor introduce una nueva
              contraseña.
            </h5>
            <div class="mb-3">
              <label class="form-label">Tu contraseña</label>
              <input
                type="password"
                name="password"
                required
                minlength="8"
                class="form-control"
                placeholder="Introduce tu contraseña" />
            </div>
            <div class="d-grid py-3 mt-4">
              <button class="btn btn-lg btn-primary">
                Cambiar contraseña
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
