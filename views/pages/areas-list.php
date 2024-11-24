<?php

use LCCA\App;
use LCCA\Models\SubjectModel;

/** @var SubjectModel[] $subjects */

?>

<div class="row">
  <div class="col-xxl-12">
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="custom-tabs-container">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a
                class="nav-link active"
                data-bs-toggle="tab"
                href="#listado">
                <i class="bi bi-card-list"></i>
                Listado
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                data-bs-toggle="tab"
                href="#aperturar">
                <i class="bi bi-plus-circle"></i>
                Aperturar
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade active show" id="listado">
              <div class="row row-cols-md-3 g-4">
                <?php foreach ($subjects as $subject): ?>
                  <div class="col">
                    <div class="card h-100">
                      <div class="card-img text-center pt-2 px-2">
                        <img
                          src="<?= $subject->getImageUrl() ?>"
                          height="100" />
                      </div>
                      <div class="card-body text-center">
                        <h5 class="fw-light"><?= $subject ?></h5>
                      </div>
                      <div class="card-footer d-flex justify-content-between">
                        <a
                          href="./areas/<?= $subject->id ?>/editar"
                          class="btn btn-primary">
                          Editar
                        </a>
                        <a
                          href="./areas/<?= $subject->id ?>/eliminar"
                          class="btn btn-outline-danger">
                          Eliminar
                        </a>
                      </div>
                    </div>
                  </div>
                <?php endforeach ?>
              </div>
            </div>
            <div class="tab-pane fade" id="aperturar">
              <form
                enctype="multipart/form-data"
                method="post"
                class="card mb-4">
                <div class="card-header">
                  <h5 class="card-title">Aperturar área de formación</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 mb-3">
                      <label class="form-label">Nombre</label>
                      <input
                        name="name"
                        required
                        class="form-control" />
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
                    <button class="btn btn-primary">Registrar</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
