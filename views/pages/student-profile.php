<?php

use LCCA\Models\StudentModel;

/** @var StudentModel $student */

?>

<div class="row justify-content-center">
  <div class="col-xxl-12">
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <img
              src="./assets/images/istockphoto-1268716253-612x612.png"
              class="img-5xx rounded-circle" />
          </div>
          <div class="col">
            <h6 class="text-primary"><?= $student->getFullIdCard() ?></h6>
            <h4 class="m-0"><?= $student ?></h4>
          </div>
          <div class="col-12 col-md-auto">
            <a href="javascript:" class="btn btn-outline-primary btn-lg">
              Editar
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xxl-3 col-sm-6 col-12 order-xxl-1 order-sm-2">
    <div class="card shadow mb-4">
      <div class="card-header">
        <h5 class="card-title">Acerca de</h5>
      </div>
      <div class="card-body">
        <h6 class="d-flex align-items-center mb-3">
          <i class="bi bi-house fs-2 me-2"></i>
          Vive en&nbsp;
          <span><?= $student->getAddress() ?></span>
        </h6>
      </div>
    </div>
    <!-- <div class="card shadow mb-4">
      <div class="card-header">
        <h5 class="card-title">Skills</h5>
      </div>
      <div class="card-body">
        <div class="d-inline-flex gap-2 flex-wrap">
          <span class="badge bg-danger">HTML</span>
          <span class="badge bg-info">Javascript</span>
          <span class="badge bg-success">React</span>
          <span class="badge bg-warning">Scss</span>
          <span class="badge bg-primary">Angular</span>
          <span class="badge bg-secondary">CSS</span>
        </div>
      </div>
    </div> -->
    <!-- <div class="card shadow mb-4">
      <div class="card-header">
        <h5 class="card-title">Earnings</h5>
      </div>
      <div class="card-body">
        <div id="weekly-sales"></div>
        <div class="text-center my-4">
          <h1 class="fw-bold">
            950
            <i class="bi bi-arrow-up-right-circle-fill text-success"></i>
          </h1>
          <p class="fw-light m-0">21% higher than last month</p>
        </div>
      </div>
    </div> -->
    <!-- <div class="card shadow mb-4">
      <div class="card-header">
        <h5 class="card-title">Activity</h5>
      </div>
      <div class="card-body">
        <div class="scroll350 os-host os-theme-dark os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
          <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
          </div>
          <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
          </div>
          <div class="os-content-glue" style="margin: 0px; width: 369px; height: 349px;"></div>
          <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
              <div class="os-content" style="padding: 0px; height: 100%; width: 100%;">
                <div class="my-2">
                  <div class="activity-block d-flex position-relative">
                    <img src="assets/images/user2.png" class="img-5x me-3 rounded-circle activity-user" alt="Admin Dashboard">
                    <div class="mb-3">
                      <h5>Sophie Michiels</h5>
                      <p class="m-0">3 day ago</p>
                      <p>Paid invoice ref. #26788</p>
                      <span class="badge bg-info">Sent</span>
                    </div>
                  </div>
                  <div class="activity-block d-flex position-relative">
                    <img src="assets/images/user4.png" class="img-5x me-3 rounded-circle activity-user" alt="Admin Dashboard">
                    <div class="mb-3">
                      <h5>Sunny Desmet</h5>
                      <p class="m-0">3 hours ago</p>
                      <p>Sent invoice ref. #23457</p>
                      <span class="badge bg-primary">Sent</span>
                    </div>
                  </div>
                  <div class="activity-block d-flex position-relative">
                    <img src="assets/images/user1.png" class="img-5x me-3 rounded-circle activity-user" alt="Admin Dashboard">
                    <div class="mb-3">
                      <h5>Ilyana Maes</h5>
                      <p class="m-0">One week ago</p>
                      <p>Paid invoice ref. #34546</p>
                      <span class="badge bg-primary">Invoice</span>
                    </div>
                  </div>
                  <div class="activity-block d-flex position-relative">
                    <img src="assets/images/user5.png" class="img-5x me-3 rounded-circle activity-user" alt="Admin Dashboard">
                    <div class="mb-3">
                      <h5>Remssy Wilson</h5>
                      <p class="m-0">7 hours ago</p>
                      <p>Paid invoice ref. #23459</p>
                      <span class="badge bg-primary">Payments</span>
                    </div>
                  </div>
                  <div class="activity-block d-flex position-relative">
                    <img src="assets/images/user3.png" class="img-5x me-3 rounded-circle activity-user" alt="Admin Dashboard">
                    <div class="mb-3">
                      <h5>Elliott Hermans</h5>
                      <p class="m-0">1 day ago</p>
                      <p>Paid invoice ref. #23473</p>
                      <span class="badge bg-primary">Paid</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-auto-hidden os-scrollbar-unusable">
            <div class="os-scrollbar-track os-scrollbar-track-off">
              <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track os-scrollbar-track-off">
              <div class="os-scrollbar-handle" style="height: 53.5168%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar-corner"></div>
        </div>
      </div>
    </div> -->
  </div>
  <!-- <div class="col-xxl-6 col-sm-12 col-12 order-xxl-2 order-sm-1">
    <div class="card shadow mb-4">
      <div class="card-img">
        <img src="assets/images/flowers/img1.jpg" class="card-img-top img-fluid" alt="Bootstrap Dashboards">
      </div>
      <div class="card-body">
        <h4 class="card-title mb-3">Bootstrap Gallery</h4>
        <p class="mb-3">
          Best Bootstrap Admin Dashboards available at best price.
          Bootstrap Gallery specialized in designing and developing
          Admin Dashboards, Admin Panels, CRM Dashboards, and
          Bootstrap themes.
        </p>
        <div class="d-flex align-items-center">
          <img src="assets/images/user.png" class="rounded-circle me-3 img-4x" alt="Bootstrap Admin">
          <h6 class="m-0">Ilyana Maesi</h6>
        </div>
      </div>
    </div>
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="d-flex">
          <img src="assets/images/user5.png" class="rounded-circle me-3 img-4x" alt="Bootstrap Themes">
          <div class="flex-grow-1">
            <p class="float-end text-info">7 hrs ago</p>
            <h6 class="fw-bold">Elliott Hermans</h6>
            <p class="text-muted">Today 2:45pm</p>
            <p>
              A dashboard, in website administration, is typically
              the index page of the control panel for a website's
              content management system. Bootstrap Gallery Admin
              Dashboards are fully responsive built on Bootstrap 5
              framework.
            </p>
            <div class="row">
              <div class="col-12">
                <p class="fw-bold">Media Files (3)</p>
              </div>
              <div class="col-4">
                <img src="assets/images/flowers/img3.jpg" alt="Bootstrap Gallery" class="img-fluid rounded">
              </div>
              <div class="col-4">
                <img src="assets/images/flowers/img5.jpg" alt="Bootstrap Gallery" class="img-fluid rounded">
              </div>
              <div class="col-4">
                <img src="assets/images/flowers/img8.jpg" alt="Bootstrap Gallery" class="img-fluid rounded">
              </div>
            </div>
            <button class="btn btn-primary mt-2">
              <i class="bi bi-heart-fill"></i> Like
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="d-flex">
          <img src="assets/images/user2.png" class="rounded-circle me-3 img-4x" alt="Bootstrap Dashboards">
          <div class="flex-grow-1">
            <p class="float-end text-info">5 mins ago</p>
            <h6 class="fw-bold">
              Willa Henrys started following Oriel Row
            </h6>
            <p class="text-muted">Today 7:50pm</p>
            <div class="mb-2">
              <textarea name="" rows="5" class="form-control"></textarea>
            </div>
            <button class="btn btn-danger">Message</button>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <div class="col-xxl-3 col-sm-6 col-12 order-sm-3">
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <span>Progreso</span>
          <span class="text-primary">
            <?= $student->getProgressPercent() ?>%
          </span>
        </div>
        <div class="progress small">
          <div
            class="progress-bar bg-primary"
            style="width: <?= $student->getProgressPercent() ?>%">
          </div>
        </div>
      </div>
    </div>
    <div class="card shadow mb-4">
      <div class="card-header">
        <h5 class="card-title">Representantes</h5>
      </div>
      <div class="card-body">
        <div class="row g-2 row-cols-3">
          <?php foreach ($student->getAllRepresentatives() as $representative): ?>
            <div class="col text-center">
              <img
                src="assets/images/146579-200.png"
                class="img-fluid rounded-2" />
                <strong><?= $representative ?></strong>
                <?php if ($representative === $student->currentRepresentative()): ?>
                  <span class="badge border border-success text-success">
                    Actual
                  </span>
                <?php endif ?>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
    <!-- <div class="card shadow mb-4">
      <div class="card-header">
        <h5 class="card-title">Projects</h5>
      </div>
      <div class="card-body">
        <ul class="m-0 p-0">
          <li class="activity-list d-flex">
            <div class="activity-time pt-2 pe-3 me-3">
              <p class="date m-0">10:30 am</p>
              <span class="badge bg-danger">75%</span>
            </div>
            <div class="d-flex flex-column py-2">
              <h5>Bootstrap Admin</h5>
              <p class="m-0">by Elnathan Lois</p>
            </div>
          </li>
          <li class="activity-list d-flex">
            <div class="activity-time pt-2 pe-3 me-3">
              <p class="date m-0">11:30 am</p>
              <span class="badge bg-info">50%</span>
            </div>
            <div class="d-flex flex-column py-2">
              <h5>Admin Theme</h5>
              <p class="m-0">by Patrobus Nicole</p>
            </div>
          </li>
          <li class="activity-list d-flex">
            <div class="activity-time pt-2 pe-3 me-3">
              <p class="date m-0">12:50 pm</p>
              <span class="badge bg-warning">90%</span>
            </div>
            <div class="d-flex flex-column py-2">
              <h5>UI Kit</h5>
              <p class="m-0">by Abilene Omega</p>
            </div>
          </li>
          <li class="activity-list d-flex">
            <div class="activity-time pt-2 pe-3 me-3">
              <p class="date m-0">02:30 pm</p>
              <span class="badge bg-success">50%</span>
            </div>
            <div class="d-flex flex-column py-2">
              <h5>Invoice Design</h5>
              <p class="m-0">by Shelomi Sarah</p>
            </div>
          </li>
        </ul>
      </div>
    </div> -->
    <!-- <div class="card shadow mb-4">
      <div class="card-header">
        <h5 class="card-title">Bookmarks</h5>
      </div>
      <div class="card-body">
        <ul class="list-group">
          <li class="list-group-item">
            <a href="javascript:void(0)" class="text-info">
              <i class="bi bi-lightning-charge"></i> Bootstrap 5
              Admin Dashboard
            </a>
          </li>
          <li class="list-group-item">
            <a href="javascript:void(0)" class="text-info">
              <i class="bi bi-lightning-charge"></i> Best Bootstrap
              Themes
            </a>
          </li>
          <li class="list-group-item">
            <a href="javascript:void(0)" class="text-info">
              <i class="bi bi-lightning-charge"></i> Quality
              Bootstrap Themes
            </a>
          </li>
          <li class="list-group-item">
            <a href="javascript:void(0)" class="text-info">
              <i class="bi bi-lightning-charge"></i> Best Bootstrap
              5 Admin Templates
            </a>
          </li>
          <li class="list-group-item">
            <a href="javascript:void(0)" class="text-info">
              <i class="bi bi-lightning-charge"></i> Premium
              Bootstrap 5 Admin Dashboards
            </a>
          </li>
          <li class="list-group-item">
            <a href="javascript:void(0)" class="text-info">
              <i class="bi bi-lightning-charge"></i> Quality
              Bootstrap Admin Dashboards
            </a>
          </li>
          <li class="list-group-item">
            <a href="javascript:void(0)" class="text-info">
              <i class="bi bi-lightning-charge"></i> Free Bootstrap
              Admin Dashboards
            </a>
          </li>
          <li class="list-group-item">
            <a href="javascript:void(0)" class="text-info">
              <i class="bi bi-lightning-charge"></i> Best Bootstrap
              Dashboards
            </a>
          </li>
        </ul>
      </div>
    </div> -->
  </div>
</div>
