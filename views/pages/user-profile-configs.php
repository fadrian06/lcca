<?php

use LCCA\Models\UserModel;

/** @var UserModel $loggedUser */

?>

<div class="row">
  <div class="col-xxl-12">
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="row justify-content-between">
          <form method="post" class="col-sm-8 col-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h5 class="card-title">Detalles personales</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Tu nombre</label>
                    <input
                      name="name"
                      required
                      class="form-control"
                      placeholder="Introduce tu nombre"
                      pattern="[a-zA-ZáéíóúñÁÉÍÓÚÑ]{3,}"
                      title="El nombre sólo puede tener mínimo 3 letras"
                      value="<?= $loggedUser->name ?>" />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Tu cédula</label>
                    <input
                      type="number"
                      name="idCard"
                      required
                      class="form-control"
                      placeholder="Introduce tu cédula"
                      min="0"
                      value="<?= $loggedUser->idCard ?>" />
                  </div>
                  <div class="mb-3 col-md-12">
                    <label class="form-label">Firma</label>
                    <input
                      capture="user"
                      type="file"
                      name="signature"
                      class="form-control"
                      accept="image/*"
                      required
                    />
                  </div>
                </div>
              </div>
              <button class="card-footer btn btn-primary">Actualizar</button>
            </div>
          </form>
          <form
            method="post"
            action="./perfil/cambiar-clave"
            class="col-sm-4 col-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h5 class="card-title">Cambiar contraseña</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <div class="mb-3">
                      <label class="form-label">Tu contraseña actual</label>
                      <input
                        type="password"
                        name="oldPassword"
                        required
                        minlength="8"
                        class="form-control"
                        placeholder="Introduce tu contraseña actual" />
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Tu nueva contraseña</label>
                      <input
                        type="password"
                        name="newPassword"
                        required
                        minlength="8"
                        class="form-control"
                        placeholder="Introduce tu nueva contraseña" />
                    </div>
                  </div>
                </div>
              </div>
              <button class="card-footer btn btn-primary">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
