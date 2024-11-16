<?php

$counters = [
  /*[
    'detailsHref' => './estudiantes',
    'iconClass' => 'bi bi-pie-chart',
    'label' => 'Products',
    'amount' => 250
  ],*/
];

?>

<div class="row">
  <?php foreach ($counters as $counter): ?>
    <div class="col-xl-3 col-sm-6 col-12">
      <a
        href="<?= $counter['detailsHref'] ?>"
        class="card shadow mb-4 p-2 rounded-4 text-decoration-none">
        <div class="card-body d-flex align-items-center">
          <div class="icon-box lg shadow-solid-rb border border-dark p-4 rounded-4 me-3">
            <i class="<?= $counter['iconClass'] ?> fs-1 lh-1 text-primary"></i>
          </div>
          <div class="m-0">
            <h5 class="fw-light mb-1"><?= $counter['label'] ?></h5>
            <h2 class="m-0 text-primary"><?= $counter['amount'] ?></h2>
          </div>
        </div>
      </a>
    </div>
  <?php endforeach ?>
</div>
