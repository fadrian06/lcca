<?php

use Leaf\Flash;

$errors = (array) Flash::display('errors');
$success = Flash::display('success');

?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <?php foreach ($errors as $error): ?>
    <div class="toast">
      <div class="toast-header text-danger">
        <i class="bi bi-x-circle-fill me-2"></i>
        <strong class="me-auto"><?= $error ?></strong>
        <button class="btn-close" data-bs-dismiss="toast"></button>
      </div>
    </div>
  <?php endforeach ?>
  <?php if ($success): ?>
    <div class="toast">
      <div class="toast-header text-success">
        <i class="bi bi-check-circle me-2"></i>
        <strong class="me-auto"><?= $success ?></strong>
        <button class="btn-close" data-bs-dismiss="toast"></button>
      </div>
    </div>
  <?php endif ?>

  <script>
    for (const element of document.querySelectorAll('.toast')) {
      const toast = new bootstrap.Toast(element)

      toast.show()
    }
  </script>
</div>
