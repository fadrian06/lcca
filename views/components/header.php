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
    <!-- <div class="d-lg-block d-none me-2">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" />
        <button class="btn btn-outline-primary" type="button">
          <i class="bi bi-search fs-5"></i>
        </button>
      </div>
    </div> -->
    <!-- <div class="dropdown ms-3">
      <a class="dropdown-toggle d-flex p-2 py-3" href="#!" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        <i class="bi bi-grid fs-2 lh-1"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-end shadow">
        <div class="d-flex gap-2 m-2">
          <a href="javascript:void(0)" class="g-col-4 p-2 border rounded-2">
            <img src="./assets/images/brand-behance.svg" class="img-3x" alt="Admin Themes" />
          </a>
          <a href="javascript:void(0)" class="g-col-4 p-2 border rounded-2">
            <img src="./assets/images/brand-gatsby.svg" class="img-3x" alt="Admin Themes" />
          </a>
          <a href="javascript:void(0)" class="g-col-4 p-2 border rounded-2">
            <img src="./assets/images/brand-google.svg" class="img-3x" alt="Admin Themes" />
          </a>
          <a href="javascript:void(0)" class="g-col-4 p-2 border rounded-2">
            <img src="./assets/images/brand-bitcoin.svg" class="img-3x" alt="Admin Themes" />
          </a>
          <a href="javascript:void(0)" class="g-col-4 p-2 border rounded-2">
            <img src="./assets/images/brand-dribbble.svg" class="img-3x" alt="Admin Themes" />
          </a>
        </div>
      </div>
    </div> -->
    <!-- <div class="dropdown ms-3">
      <a class="dropdown-toggle d-flex p-2 py-3" href="#!" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        <i class="bi bi-bell fs-2 lh-1"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-end shadow">
        <div class="dropdown-item">
          <div class="d-flex py-2 border-bottom">
            <img src="./assets/images/user.png" class="img-4x me-3 rounded-3" alt="Admin Theme" />
            <div class="m-0">
              <h5 class="mb-1 fw-semibold">Sophie Michiels</h5>
              <p class="mb-1">Membership has been ended.</p>
              <p class="small m-0 text-primary">Today, 07:30pm</p>
            </div>
          </div>
        </div>
        <div class="dropdown-item">
          <div class="d-flex py-2 border-bottom">
            <img src="./assets/images/user2.png" class="img-4x me-3 rounded-3" alt="Admin Theme" />
            <div class="m-0">
              <h5 class="mb-1 fw-semibold">Sophie Michiels</h5>
              <p class="mb-1">Congratulate, James for new job.</p>
              <p class="small m-0 text-primary">Today, 08:00pm</p>
            </div>
          </div>
        </div>
        <div class="dropdown-item">
          <div class="d-flex py-2">
            <img src="./assets/images/user1.png" class="img-4x me-3 rounded-3" alt="Admin Theme" />
            <div class="m-0">
              <h5 class="mb-1 fw-semibold">Sophie Michiels</h5>
              <p class="mb-2">Lewis added new schedule release.</p>
              <p class="small m-0 text-primary">Today, 09:30pm</p>
            </div>
          </div>
        </div>
        <div class="border-top py-2 px-3 text-end">
          <a href="javascript:void(0)">View all</a>
        </div>
      </div>
    </div> -->
    <div class="dropdown ms-3">
      <a id="userSettings" class="dropdown-toggle d-flex py-2 align-items-center text-decoration-none"
        href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="d-none d-md-block me-2"><?= $loggedUser ?></span>
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png" class="rounded-circle img-3x" alt="Bootstrap Gallery" />
      </a>
      <div class="dropdown-menu dropdown-menu-end shadow">
        <!-- <a class="dropdown-item d-flex align-items-center" href="profile.html"><i
            class="bi bi-person fs-4 me-2"></i>Profile</a>
        <a class="dropdown-item d-flex align-items-center" href="settings.html"><i
            class="bi bi-gear fs-4 me-2"></i>Account Settings</a> -->
        <a class="dropdown-item d-flex align-items-center" href="./salir"><i
            class="bi bi-escape fs-4 me-2"></i>Salir</a>
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
        <a href="./<?= $section ?>">
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
