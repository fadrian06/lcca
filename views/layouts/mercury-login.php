<?php

use Leaf\Flash;

$errors = (array) Flash::display('errors');

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

  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <?php foreach ($errors as $error): ?>
      <div class="toast">
        <div class="toast-header text-danger">
          <i class="bi bi-x-circle-fill text-danger me-2"></i>
          <strong class="me-auto"><?= $error ?></strong>
          <button class="btn-close" data-bs-dismiss="toast"></button>
        </div>
      </div>
    <?php endforeach ?>

    <script>
      for (const element of document.querySelectorAll('.toast')) {
        const toast = new bootstrap.Toast(element)

        toast.show()
      }
    </script>
  </div>
</body>

</html>
