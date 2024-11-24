<?php

use LCCA\Models\UserModel;

/** @var UserModel[] $teachers */

?>

<div class="row">
  <?php foreach ($teachers as $teacher): ?>
    <div class="col-sm-3 col-12">
      <a class="card shadow mb-4 text-decoration-none h-100">
        <div class="card-img text-center pt-2">
          <img
            src="./assets/images/teacher.png" height="100" />
        </div>
        <div class="card-body text-center">
          <h3><?= $teacher ?></h3>
        </div>
        <form
          class="card-footer text-center"
          action="./docentes/<?= $teacher->id ?>/eliminar"
          method="post">
          <button class="btn btn-outline-secondary">Eliminar</button>
        </form>
      </a>
    </div>
  <?php endforeach ?>
</div>
