<?php

use LCCA\App;

static $listRendered = false;
$secretQuestionListId = uniqid();

if (!$listRendered) {
  App::renderComponent('secret-questions', ['id' => $secretQuestionListId]);
  $listRendered = true;
}

?>

<div x-data="{ secretQuestion: `<?= $secretQuestion ?? '' ?>` }">
  <div class="mb-3">
    <label class="form-label">Pregunta de seguridad</label>
    <input
      name="pregunta_secreta"
      required
      class="form-control"
      placeholder="Introduce tu pregunta"
      value="<?= $secretQuestion ?? '' ?>"
      x-model="secretQuestion"
      list="<?= $secretQuestionListId ?>" />
  </div>
  <div class="mb-3">
    <?php App::renderComponent('input-password', [
      'label' => 'Respuesta de seguridad',
      'name' => 'respuesta_secreta',
      'required' => true,
      ':placeholder' => '`Introduce tu respuesta a: ${secretQuestion}`',
      'value' => $secretAnswer ?? ''
    ]) ?>
  </div>
</div>
