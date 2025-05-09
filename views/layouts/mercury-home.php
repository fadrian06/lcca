<?php

use LCCA\App;
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
  <link rel="stylesheet" href="./assets/fonts/bootstrap/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./assets/vendor/fontawesome/css/all.min.css" />
  <link rel="stylesheet" href="./assets/css/main.min.css" />
  <link rel="stylesheet" href="./assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />
  <style>
    th,
    td {
      white-space: nowrap;
      vertical-align: middle;
    }

    [x-cloak] {
      display: none;
    }
  </style>
</head>

<body>
  <div class="page-wrapper">
    <div class="main-container">
      <?php App::renderComponent('sidebar') ?>
      <div class="app-container">
        <?php App::renderComponent('header') ?>
        <div class="app-body overflow-y-scroll"><?= $page ?></div>
        <?php App::renderComponent('footer') ?>
      </div>
    </div>
  </div>
  <script src="./assets/js/jquery.min.js"></script>
  <script src="./assets/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
  <script src="./assets/vendor/overlay-scroll/custom-scrollbar.js"></script>
  <script src="./assets/js/custom.js"></script>
  <script defer src="./assets/js/alpinejs.min.js"></script>
  <?php App::renderComponent('toasts') ?>
</body>

</html>
