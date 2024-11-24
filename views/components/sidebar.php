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
    <h5 class="profile-name lh-lg mt-2 text-truncate"><?= $loggedUser->getRole() ?></h5>
    <ul class="profile-actions d-flex m-0 p-0">
      <li class="opacity-0 disabled">
        <a href="javascript:void(0)">
          <i class="bi bi-skype fs-4"></i>
          <span class="count-label"></span>
        </a>
      </li>
      <li class="opacity-0 disabled">
        <a href="javascript:void(0)">
          <i class="bi bi-dribbble fs-4"></i>
        </a>
      </li>
      <li class="opacity-0 disabled">
        <a href="javascript:void(0)">
          <i class="bi bi-twitter fs-4"></i>
        </a>
      </li>
    </ul>
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
    </ul>
  </div>
</nav>
