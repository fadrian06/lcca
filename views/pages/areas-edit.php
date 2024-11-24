<?php

use LCCA\App;
use LCCA\Models\SubjectModel;

/** @var SubjectModel $subject */

?>

<div class="row">
  <div class="col-xxl-12">
    <form
      enctype="multipart/form-data"
      method="post"
      class="card mb-4">
      <div class="card-header">
        <h5 class="card-title">Editar área de formación</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-10 mb-3">
            <label class="form-label">Nombre</label>
            <input
              name="name"
              required
              class="form-control"
              placeholder="Introduce el nombre"
              value="<?= $subject ?>" />
          </div>
          <div class="col-sm-2 mb-3">
            <img src="<?= $subject->getImageUrl() ?>" class="img-fluid" />
          </div>
          <div class="col-sm-6 mb-3">
            <label class="form-label">Imagen</label>
            <input
              type="file"
              name="image"
              class="form-control"
              accept="image/*" />
          </div>
          <div class="col-sm-1 h3 text-center">o</div>
          <div class="col-sm-5 mb-3">
            <label class="form-label">URL de la imagen</label>
            <input
              type="url"
              name="imageUrl"
              class="form-control" />
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
          <button class="btn btn-primary">Actualizar</button>
        </div>
      </div>
    </form>
  </div>
</div>
