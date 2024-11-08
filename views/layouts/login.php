<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <base href="<?= str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) ?>" />
  <title><?= $title ?> - LCCA</title>
  <link rel="icon" href="./assets/images/favicon.ico" />
</head>

<body>
  <?= $page ?>

  <script>
    <?php if ($_SESSION['messages']['error']): ?>
      alert('❌ <?= $_SESSION['messages']['error'] ?>')
    <?php elseif ($_SESSION['messages']['success']): ?>
      alert('✅ <?= $_SESSION['messages']['success'] ?>')
    <?php endif ?>
  </script>
</body>

</html>
