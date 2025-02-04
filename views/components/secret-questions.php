<?php

$id ??= uniqid();
static $rendered = false;

?>

<?php if (!$rendered): ?>
  <datalist id="<?= $id ?>">
    <option value="¿Cuál es el nombre de tu primera mascota?"></option>
    <option value="¿Cuál es el nombre de tu escuela primaria?"></option>
    <option value="¿En qué ciudad naciste?"></option>
    <option value="¿Cuál es tu comida favorita?"></option>
    <option value="¿Cuál es el nombre de tu mejor amigo de la infancia?"></option>
    <option value="¿Cuál es el título de tu libro favorito?"></option>
    <option value="¿Cuál fue el modelo de tu primer coche?"></option>
    <option value="¿Cuál es el nombre de tu película favorita?"></option>
    <option value="¿Cuál es el apellido de soltera de tu madre?"></option>
    <option value="¿En qué año te graduaste del colegio?"></option>
  </datalist>

  <?php $rendered = true ?>
<?php endif ?>
