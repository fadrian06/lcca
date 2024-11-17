<?php

use LCCA\Models\UserModel;

/** @var UserModel[] $teachers */

?>

<div class="row">
  <?php foreach ($teachers as $teacher): ?>
    <div class="col-sm-4 col-12">
      <a class="card shadow mb-4 text-decoration-none">
        <div class="card-img">
          <img src="assets/images/teacher.png" class="card-img-top img-fluid" />
        </div>
        <div class="card-body text-center">
          <h3 class="mb-3"><?= $teacher ?></h3>
          <!-- <h5 class="mb-3 fw-light">Lead Designer</h5> -->
          <!-- <p class="lh-base mb-4">
            Some quick example text to build on the card title and
            make up the bulk of the card's content.
          </p> -->
          <!-- <ul class="list-unstyled">
            <li>
              <i class="bi bi-globe-americas fs-1 text-primary"></i>
              <p>San Francisco, CA 94126, USA</p>
            </li>

            <li>
              <i class="bi bi-telephone mt-4 fs-1 text-primary"></i>
              <p>+ 01 234 567 89</p>
            </li>

            <li>
              <i class="bi bi-envelope-open mt-4 fs-1 text-primary"></i>
              <p>contact@mdbootstrap.com</p>
            </li>
          </ul> -->
          <form action="./docentes/<?= $teacher->id ?>/eliminar" method="post">
            <button class="btn btn-outline-secondary">Eliminar</button>
          </form>
        </div>
      </a>
    </div>
  <?php endforeach ?>
</div>
