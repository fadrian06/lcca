<?php

use LCCA\App;

?>

<nav id="sidebar" class="sidebar-wrapper">
  <div class="app-brand px-3 py-3 d-flex align-items-center">
    <a href="./">
      <img src="./assets/images/logo-sm.svg" class="logo" />
    </a>
  </div>
  <div class="sidebar-user-profile">
    <img
      src="./assets/images/User_icon_2.svg.png"
      class="profile-thumb rounded-circle p-2 d-lg-flex d-none" />
    <h5 class="profile-name lh-lg mt-2 text-truncate">
      <?= $loggedUser->getRole() ?>
    </h5>
  </div>
  <div class="sidebarMenuScroll">
    <ul class="sidebar-menu">
      <li>
        <a href="./">
          <i class="bi bi-pie-chart"></i>
          <span class="menu-text">Inicio</span>
        </a>
      </li>
      <li>
        <a href="./estudiantes">
          <i class="bi bi-people"></i>
          <span class="menu-text">Estudiantes</span>
        </a>
      </li>
      <li class="treeview">
        <a href="javascript:void">
          <i class="bi bi-stickies"></i>
          <span class="menu-text">Inscripciones</span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="./inscribir">Nuevo ingreso</a>
          </li>
          <li>
            <a href="#reinscribir" data-bs-toggle="modal">
              Reinscribir
            </a>
          </li>
        </ul>
      </li>
      <li class="treeview">
        <a href="javascript:void">
          <i class="bi bi-person-video3"></i>
          <span class="menu-text">Docentes</span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="./docentes">Listado</a>
          </li>
          <li>
            <a href="./docentes/registrar">Registrar</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="./areas">
          <i class="bi bi-book-half"></i>
          <span class="menu-text">Áreas de Formación</span>
        </a>
      </li>
      <?php if ($loggedUser->isCoordinator()): ?>
        <li>
          <a href="./años">
            <i class="bi bi-bar-chart"></i>
            <span class="menu-text">Años y secciones</span>
          </a>
        </li>
      <?php endif ?>

      <li class="treeview">
        <a href="javascript:void">
          <i class="bi bi-database-fill-gear"></i>
          <span class="menu-text">Respaldo y restauración</span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="./respaldar">Respaldar</a>
          </li>
          <li>
            <a href="./restaurar">Restaurar</a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<div class="modal fade" id="reinscribir">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Reinscribir estudiante</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php App::renderComponent('search-student', [
          'hrefFormat' => './estudiantes/${student.id}/reinscribir'
        ]) ?>
      </div>
    </div>
  </div>
</div>
