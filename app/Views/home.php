<?php $this->extend('layout') ?>

<?php $this->section('content') ?>
<!-- Three columns of text below the carousel -->
<div class="row featurette">
  <div class="col-md-12">
    <h2 class="featurette-heading fw-normal lh-1">Prefeitos
      <!-- <span class="text-body-secondary">It’ll blow your mind.</span> -->
    </h2>
    <!-- <p class="lead">Some great placeholder content for the first featurette here. Imagine some exciting prose here.</p> -->
  </div>
</div>

<div class="row">

  <?php foreach ($prefeitos as $item) { ?>
    <div class="col-lg-3 col-md-4 col-sm-12 col-12">
      <img src="..." class="rounded mx-auto d-block" alt="...">
      <h2 class="fw-normal"><?= $item['nome_urna'] ?></h2>
      <p>Qtd. Votos: XXXX</p>
      <p>Percentual: XXXX</p>
      <!-- <p><a class="btn btn-secondary" href="#">View details &raquo;</a></p> -->
    </div><!-- /.col-lg-4 -->,
  <?php } ?>
</div><!-- /.row -->

<hr class="featurette-divider">

<div class="row featurette">
  <div class="col-md-7">
    <h2 class="featurette-heading fw-normal lh-1">Vereadores
      <!-- <span class="text-body-secondary">It’ll blow your mind.</span> -->
    </h2>
    <!-- <p class="lead">Some great placeholder content for the first featurette here. Imagine some exciting prose here.</p> -->
  </div>
  <div class="col-md-12">
    <!-- Filtro por partido aqui -->

    <div class="table-responsive">
      <table class="table table-striped-columns" id="table" data-url="<?= base_url('Home/req_ajax_datatable_vereadores') ?>" data-search="true"
        data-pagination="true" data-loading-template="loadingTemplate"
        data-query-params="queryParamsInput">
        <thead>
          <tr>
            <th data-field="partido">Partido</th>
            <th data-field="num_cand">Num. Cand.</th>
            <th data-field="nome">Nome</th>
            <th data-field="qtd_votos">Qtd. Votos</th>
            <th data-field="percentual">Percentual</th>
          </tr>
        <tbody>
        </tbody>
        </thead>
      </table>
    </div>
  </div>

</div>
<?php $this->endSection('content') ?>

<?php $this->section('scripts') ?>

<script>
</script>
<?php include("datatable.php") ?>
<?php $this->endSection('scripts') ?>