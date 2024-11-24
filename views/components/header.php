<?php

use LCCA\App;

$urlSections = array_filter(explode('/', App::request()->url));

?>

<div class="app-header d-flex align-items-center">
  <div class="d-flex">
    <button class="btn btn-outline-primary me-2 toggle-sidebar" id="toggle-sidebar">
      <i class="bi bi-chevron-left fs-5"></i>
    </button>
    <button class="btn btn-outline-primary me-2 pin-sidebar" id="pin-sidebar">
      <i class="bi bi-chevron-left fs-5"></i>
    </button>
  </div>
  <div class="app-brand-sm d-md-none d-sm-block">
    <a href="./">
      <img src="./assets/images/logo-sm.svg" class="logo" />
    </a>
  </div>
  <div class="header-actions">
    <div class="me-2">
      <?php App::renderComponent('search-student') ?>
    </div>
    <div class="dropdown ms-3">
      <a
        class="dropdown-toggle d-flex py-2 align-items-center text-decoration-none"
        href="javascript:"
        data-bs-toggle="dropdown">
        <span class="d-none d-md-block me-2"><?= $loggedUser ?></span>
        <img
          src="./assets/images/User_icon_2.svg.png"
          class="rounded-circle img-3x" />
      </a>
      <div class="dropdown-menu dropdown-menu-end shadow">
        <a
          class="dropdown-item d-flex align-items-center"
          href="./perfil/configurar">
          <i class="bi bi-gear fs-4 me-2"></i>
          Configuraciones de la cuenta
        </a>
        <a class="dropdown-item d-flex align-items-center" href="./salir">
          <i class="bi bi-escape fs-4 me-2"></i>
          Salir
        </a>
      </div>
    </div>
  </div>
</div>
<div class="app-hero-header">
  <h5 class="fw-light">Hola <?= $loggedUser ?>,</h5>
  <h3 class="fw-light mb-5">
    <?php if ($urlSections): ?>
      <a href="./">Inicio</a>
      <?php foreach ($urlSections as $section): ?>
        &nbsp;/
        <a>
          <?= mb_convert_case($section, MB_CASE_TITLE) ?>
        </a>
      <?php endforeach ?>
    <?php elseif (date('H') <= 12): ?>
      Que tengas un buen día 😊
    <?php else: ?>
      Espero hayas tenido un buen día 😊
    <?php endif ?>
  </h3>
</div>
