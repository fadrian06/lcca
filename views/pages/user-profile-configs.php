<?php

use LCCA\App;
use LCCA\Models\UserModel;

/** @var UserModel $loggedUser */

?>

<div class="row">
  <div class="col-xxl-12">
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="row justify-content-between">
          <form
            method="post"
            enctype="multipart/form-data"
            class="col-sm-8 col-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h5 class="card-title">Detalles personales</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Tu nombre</label>
                    <input
                      name="nombre"
                      required
                      class="form-control"
                      placeholder="Introduce tu nombre"
                      pattern="[a-zA-ZáéíóúñÁÉÍÓÚÑ]{3,}"
                      title="El nombre sólo puede tener mínimo 3 letras"
                      value="<?= $loggedUser ?>" />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Tu cédula</label>
                    <input
                      type="number"
                      name="cédula"
                      required
                      class="form-control"
                      placeholder="Introduce tu cédula"
                      min="0"
                      value="<?= $loggedUser->getIdCard() ?>" />
                  </div>
                  <?php App::renderComponent('inputs-secret-question-answer', [
                    'secretQuestion' => $lastData['pregunta_secreta'] ?? $loggedUser->getSecretQuestion(),
                    'secretAnswer' => $lastData['respuesta_secreta'] ?? ''
                  ]) ?>
                  <div class="mb-3 col-md-12">
                    <label class="form-label">Firma</label>
                    <input
                      capture="user"
                      type="file"
                      name="signature"
                      class="form-control"
                      accept="image/*"
                      <?= $loggedUser->hasSignature() ? '' : 'required' ?> />
                  </div>
                  <?php if ($loggedUser->hasSignature()): ?>
                    <div class="mb-3 col-3">
                      <img
                        src="<?= $loggedUser->getSignatureUrl() ?>"
                        class="img-fluid" />
                    </div>
                  <?php endif ?>
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
      <div class="card-footer text-end">
        <a href="./perfil/desactivar" class="btn btn-danger">
          Desactivar cuenta
        </a>
      </div>
    </div>
  </div>
</div>
