<?php

use LCCA\Models\UserModel;

/** @var UserModel $loggedUser */

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <base href="<?= str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) ?>" />
  <title><?= $title ?> - LCCA</title>
  <link rel="icon" href="./assets/images/favicon.ico" />
  <link rel="stylesheet" href="./assets/fonts/bootstrap/bootstrap-icons.css" />
  <link rel="stylesheet" href="./assets/css/main.min.css" />
  <link rel="stylesheet" href="./assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />
</head>

<body>
  <div class="page-wrapper">
    <div class="main-container">
      <nav id="sidebar" class="sidebar-wrapper">
        <div class="app-brand px-3 py-3 d-flex align-items-center">
          <a href="./">
            <img src="./assets/images/logo-sm.svg" class="logo" />
          </a>
        </div>
        <div class="sidebar-user-profile">
          <img
            src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png"
            class="profile-thumb rounded-circle p-2 d-lg-flex d-none" />
          <h5 class="profile-name lh-lg mt-2 text-truncate"><?= $loggedUser ?></h5>
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
              <a href="./inscribir">
                <i class="bi bi-stickies"></i>
                <span class="menu-text">Inscribir estudiante</span>
              </a>
            </li>

            <!-- <li>
              <a href="widgets.html">
                <i class="bi bi-box"></i>
                <span class="menu-text">Widgets</span>
              </a>
            </li>
            <li class="treeview active">
              <a href="#!">
                <i class="bi bi-stickies"></i>
                <span class="menu-text">Components</span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="accordions.html">Accordions</a>
                </li>
                <li>
                  <a href="alerts.html" class="active-sub">Alerts</a>
                </li>
                <li>
                  <a href="buttons.html">Buttons</a>
                </li>
                <li>
                  <a href="badges.html">Badges</a>
                </li>
                <li>
                  <a href="carousel.html">Carousel</a>
                </li>
                <li>
                  <a href="list-items.html">List Items</a>
                </li>
                <li>
                  <a href="progress.html">Progress Bars</a>
                </li>
                <li>
                  <a href="popovers.html">Popovers</a>
                </li>
                <li>
                  <a href="tooltips.html">Tooltips</a>
                </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#!">
                <i class="bi bi-ui-checks-grid"></i>
                <span class="menu-text">Forms</span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="form-inputs.html">Form Inputs</a>
                </li>
                <li>
                  <a href="form-checkbox-radio.html">Checkbox &amp; Radio</a>
                </li>
                <li>
                  <a href="form-file-input.html">File Input</a>
                </li>
                <li>
                  <a href="form-validations.html">Validations</a>
                </li>
                <li>
                  <a href="date-time-pickers.html">Date Time Pickers</a>
                </li>
                <li>
                  <a href="form-layouts.html">Form Layouts</a>
                </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#!">
                <i class="bi bi-window-sidebar"></i>
                <span class="menu-text">Invoices</span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="create-invoice.html">Create Invoice</a>
                </li>
                <li>
                  <a href="view-invoice.html">View Invoice</a>
                </li>
                <li>
                  <a href="invoice-list.html">Invoice List</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="tables.html">
                <i class="bi bi-border-all"></i>
                <span class="menu-text">Tables</span>
              </a>
            </li>
            <li>
              <a href="subscribers.html">
                <i class="bi bi-check-circle"></i>
                <span class="menu-text">Subscribers</span>
              </a>
            </li>
            <li>
              <a href="contacts.html">
                <i class="bi bi-wallet2"></i>
                <span class="menu-text">Contacts</span>
              </a>
            </li>
            <li>
              <a href="settings.html">
                <i class="bi bi-gear"></i>
                <span class="menu-text">Settings</span>
              </a>
            </li>
            <li>
              <a href="profile.html">
                <i class="bi bi-person-square"></i>
                <span class="menu-text">Profile</span>
              </a>
            </li>
            <li class="treeview">
              <a href="#!">
                <i class="bi bi-code-square"></i>
                <span class="menu-text">Cards</span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="cards.html">Cards</a>
                </li>
                <li>
                  <a href="advanced-cards.html">Advanced Cards</a>
                </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#!">
                <i class="bi bi-pie-chart"></i>
                <span class="menu-text">Graphs</span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="apex.html">Apex</a>
                </li>
                <li>
                  <a href="morris.html">Morris</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="maps.html">
                <i class="bi bi-pin-map"></i>
                <span class="menu-text">Maps</span>
              </a>
            </li>
            <li>
              <a href="tabs.html">
                <i class="bi bi-slash-square"></i>
                <span class="menu-text">Tabs</span>
              </a>
            </li>
            <li>
              <a href="modals.html">
                <i class="bi bi-terminal"></i>
                <span class="menu-text">Modals</span>
              </a>
            </li>
            <li>
              <a href="icons.html">
                <i class="bi bi-textarea"></i>
                <span class="menu-text">Icons</span>
              </a>
            </li>
            <li>
              <a href="typography.html">
                <i class="bi bi-explicit"></i>
                <span class="menu-text">Typography</span>
              </a>
            </li>
            <li class="treeview">
              <a href="#!">
                <i class="bi bi-upc-scan"></i>
                <span class="menu-text">Login/Signup</span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="login.html">Login</a>
                </li>
                <li>
                  <a href="signup.html">Signup</a>
                </li>
                <li>
                  <a href="forgot-password.html">Forgot Password</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="page-not-found.html">
                <i class="bi bi-exclamation-diamond"></i>
                <span class="menu-text">Page Not Found</span>
              </a>
            </li>
            <li>
              <a href="maintenance.html">
                <i class="bi bi-exclamation-octagon"></i>
                <span class="menu-text">Maintenance</span>
              </a>
            </li>
            <li class="treeview">
              <a href="#!">
                <i class="bi bi-code-square"></i>
                <span class="menu-text">Multi Level</span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="#!">Level One Link</a>
                </li>
                <li>
                  <a href="#!">
                    Level One Menu
                    <i class="bi bi-chevron-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li>
                      <a href="#!">Level Two Link</a>
                    </li>
                    <li>
                      <a href="#!">Level Two Menu
                        <i class="bi bi-chevron-right"></i>
                      </a>
                      <ul class="treeview-menu">
                        <li>
                          <a href="#!">Level Three Link</a>
                        </li>
                        <li>
                          <a href="#!">Level Three Link</a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="#!">Level One Link</a>
                </li>
              </ul>
            </li> -->
          </ul>
        </div>
      </nav>
      <div class="app-container">
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
            <a href="index.html">
              <img src="./assets/images/logo-sm.svg" class="logo" alt="Bootstrap Gallery">
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
          <!-- <h3 class="fw-light mb-5">
            <span>Inicio</span> / <span>Components</span> /
            <span>Alerts</span>
          </h3> -->
        </div>
        <div class="app-body"><?= $page ?></div>
        <div class="app-footer">
          <span>© UPTM <?= date('Y') ?></span>
        </div>
      </div>
    </div>
  </div>
  <script src="./assets/js/jquery.min.js"></script>
  <script src="./assets/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
  <script src="./assets/vendor/overlay-scroll/custom-scrollbar.js"></script>
  <script src="./assets/js/custom.js"></script>
</body>

</html>
