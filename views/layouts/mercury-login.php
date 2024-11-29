<?php

$messages = $_SESSION['messages'];

$_SESSION['messages'] = ['error' => null, 'success' => null];

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
</head>

<body>
  <?= $page ?>

  <script>
    <?php if ($messages['error']): ?>
      alert('<?= $messages['error'] ?>')
    <?php elseif ($messages['success']): ?>
      alert('✅ <?= $messages['success'] ?>')
    <?php endif ?>
  </script>
</body>

</html>
