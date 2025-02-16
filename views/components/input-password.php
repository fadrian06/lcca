<?php

$id = uniqid();
$attributes = [];
$excludedAttributes = ['label', 'type', 'id', 'class'];

foreach ($data as $attributeName => $attributeValue) {
  if (in_array($attributeName, $excludedAttributes, true)) {
    continue;
  }

  $attributes[] = "$attributeName=\"$attributeValue\"";
}

?>

<label for="<?= $id ?>" class="form-label"><?= $label ?? '$label' ?></label>
<div class="input-group" x-data="{ showPassword: false }">
  <input
    id="<?= $id ?>"
    :type="showPassword ? 'text' : 'password'"
    <?= join(' ', $attributes) ?>
    required
    class="form-control"
    placeholder="Introduce tu contraseña"
    pattern="(?=.*\d)(?=.*[A-ZÑ])(?=.*\W).{8,}"
    title="La contraseña debe tener al menos 8 caracteres, un número, un símbolo y una mayúscula"
    value="<?= $lastData['contraseña'] ?? '' ?>" />
  <button
    tabindex="-1"
    type="button"
    @click="showPassword = !showPassword"
    class="input-group-text btn btn-outline-primary">
    <i :class="`bi ${showPassword ? 'bi-eye-slash' : 'bi-eye'}`"></i>
  </button>
</div>
