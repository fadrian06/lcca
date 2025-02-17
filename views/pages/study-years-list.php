<?php

use LCCA\Models\StudyYearModel;

/** @var StudyYearModel[] $studyYears */

?>

<div class="table-responsive">
  <table class="table table-hover text-center">
    <thead>
      <tr>
        <th></th>
        <th>Año</th>
        <th>Estado</th>
        <th>Secciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($studyYears as $studyYear): ?>
        <tr x-data="{ edit: false }">
          <form action="./años/<?= $studyYear->id ?>" method="post">
            <td>
              <div class="btn-group">
                <button
                  type="button"
                  x-show="!edit"
                  @click="edit = true"
                  class="btn btn-primary"
                  data-bs-toggle="tooltip"
                  title="Editar año">
                  <i class="bi bi-pencil"></i>
                </button>
                <button
                  type="button"
                  x-cloak
                  x-show="edit"
                  @click="edit = false"
                  class="btn btn-secondary"
                  data-bs-toggle="tooltip"
                  title="Cancelar edición">
                  <i class="bi bi-x"></i>
                </button>
                <button
                  x-cloak
                  x-show="edit"
                  class="btn btn-success"
                  data-bs-toggle="tooltip"
                  title="Actualizar año">
                  <i class="bi bi-check"></i>
                </button>
              </div>
            </td>
            <td>
              <div x-cloak x-show="edit" class="input-group">
                <input
                  class="form-control text-center"
                  name="año"
                  value="<?= (int) $studyYear->__toString() ?>"
                  required
                  min="1"
                  type="number" />
                <span class="input-group-text">° año</span>
              </div>
              <span
                x-show="!edit"
                class="form-control form-control-plaintext">
                <?= $studyYear ?>
              </span>
            </td>
            <td>
              <div x-show="!edit" x-cloak>
                <?php if ($studyYear->isActive()): ?>
                  <span class="badge border border-success text-success">
                    Activo
                  </span>
                <?php else: ?>
                  <span class="badge border border-danger text-danger">
                    Inactivo
                  </span>
                <?php endif ?>
              </div>
              <div
                x-cloak
                x-show="edit"
                :class="`form-check form-switch ${edit && 'd-flex' } justify-content-center`">
                <input
                  type="checkbox"
                  class="form-check-input"
                  name="activo"
                  <?= $studyYear->isActive() ? 'checked' : '' ?> />
              </div>
            </td>
            <td class="p-0">
              <table class="table table-hover m-0">
                <thead>
                  <tr>
                    <th>Sección</th>
                    <th>Capacidad</th>
                    <th>Estado</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($studyYear->getSections() as $section): ?>
                    <tr x-data="{ edit: false }">
                      <form
                        action="./secciones/<?= $section->id ?>"
                        method="post">
                        <td>
                          <span
                            x-show="!edit"
                            class="form-control form-control-plaintext">
                            <?= $section ?>
                          </span>
                          <input
                            x-show="edit"
                            class="form-control text-center"
                            name="sección"
                            value="<?= $section ?>"
                            list="letters"
                            required
                            minlength="1"
                            maxlength="1"
                            pattern="[A-Z]{1}"
                            title="Solo una letra mayúscula" />
                        </td>
                        <td>
                          <span
                            class="form-control form-control-plaintext"
                            x-show="!edit">
                            <?= $section->getCapacity() ?>
                          </span>
                          <input
                            x-show="edit"
                            type="number"
                            class="form-control text-center"
                            name="capacidad"
                            value="<?= $section->getCapacity() ?>"
                            required
                            min="1"
                            max="99" />
                        </td>
                        <td>
                          <div x-show="!edit">
                            <?php if ($section->isActive()): ?>
                              <span class="badge border border-success text-success">
                                Activo
                              </span>
                            <?php else: ?>
                              <span class="badge border border-danger text-danger">
                                Inactivo
                              </span>
                            <?php endif ?>
                          </div>
                          <div x-cloak x-show="edit" :class="`form-check form-switch ${edit && 'd-flex' } justify-content-center`">
                            <input
                              type="checkbox"
                              class="form-check-input"
                              name="activo"
                              <?= $section->isActive() ? 'checked' : '' ?> />
                          </div>
                        </td>
                        <td class="p-0">
                          <div class="btn-group">
                            <button
                              type="button"
                              x-show="!edit"
                              @click="edit = true"
                              data-bs-toggle="tooltip"
                              title="Editar sección"
                              class="btn btn-primary">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button
                              x-cloak
                              x-show="edit"
                              type="button"
                              @click="edit = false"
                              data-bs-toggle="tooltip"
                              title="Cancelar edición"
                              class="btn btn-secondary">
                              <i class="bi bi-x"></i>
                            </button>
                            <button
                              x-cloak
                              x-show="edit"
                              data-bs-toggle="tooltip"
                              title="Actualizar sección"
                              class="btn btn-success">
                              <i class="bi bi-check"></i>
                            </button>
                            <a
                              href="./secciones/<?= $section->id ?>/eliminar"
                              data-bs-toggle="tooltip"
                              title="Eliminar sección"
                              class="btn btn-danger">
                              <i class="bi bi-trash"></i>
                            </a>
                          </div>
                        </td>
                      </form>
                    </tr>
                  <?php endforeach ?>
                </tbody>
                <tfoot>
                  <form
                    method="post"
                    action="./años/<?= $studyYear->id ?>/secciones">
                    <tr>
                      <td>
                        <input
                          list="letters"
                          class="form-control text-center"
                          placeholder="A, B o C"
                          required
                          name="sección"
                          minlength="1"
                          maxlength="1"
                          pattern="[A-Z]{1}"
                          title="Solo una letra mayúscula" />
                      </td>
                      <td>
                        <input
                          type="number"
                          class="form-control text-center"
                          placeholder="Capacidad"
                          required
                          name="capacidad"
                          min="1"
                          max="99" />
                      </td>
                      <td></td>
                      <td>
                        <button
                          class="btn btn-primary"
                          data-bs-toggle="tooltip"
                          title="Aperturar sección">
                          <i class="bi bi-plus-lg"></i>
                        </button>
                      </td>
                    </tr>
                  </form>
                </tfoot>
              </table>
            </td>
          </form>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

<datalist id="letters">
  <option value="A"></option>
  <option value="B"></option>
  <option value="C"></option>
  <option value="D"></option>
  <option value="E"></option>
  <option value="F"></option>
  <option value="G"></option>
</datalist>
