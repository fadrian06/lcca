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
<div class="input-group" x-data="{ show: false }">
  <input
    id="<?= $id ?>"
    :type="show ? 'text' : 'password'"
    <?= join(' ', $attributes) ?>
    required
    class="form-control" />
  <button
    tabindex="-1"
    type="button"
    @click="show = !show"
    class="input-group-text btn btn-outline-primary">
    <i :class="`bi ${show ? 'bi-eye-slash' : 'bi-eye'}`"></i>
  </button>
</div>
