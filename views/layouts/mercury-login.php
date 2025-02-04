<?php

use LCCA\App;

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
  <link rel="stylesheet" href="./assets/css/main.min.css" />
  <style>
    body {
      background: radial-gradient(#c33764, #1d2671) no-repeat fixed;
    }
  </style>
</head>

<body>
  <?= $page ?>

  <script defer src="./assets/js/alpinejs.min.js"></script>
  <script src="./assets/js/bootstrap.bundle.min.js"></script>
  <?php App::renderComponent('toasts') ?>
</body>

</html>
