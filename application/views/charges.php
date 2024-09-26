<div class="container">
  <div class="box">
    <div class="box-title">
      Cobranças
      <div>
        <a href="<?php echo base_url('charge'); ?>">nova cobrança</a>
      </div>
    </div>
    <div class="group-title search-tab"><i class="ph ph-minus-circle"></i> filtros</div>
    <div class="box-search search-charges">
      
    </div>

    <div class="tab-wrapper" style="width: 100%;">
      <div class="tab-wrapper-content">
        <div class="overflow">
          <div class="table">
            <div class="table-head" style="min-width: 1350px; max-width: 100%;">
              <div class="column" style="min-width: 100px; padding-right: 1rem;">cobrança</div>
              <div class="column" style="min-width: 250px; padding-right: 1rem;">fornecedor</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">criado</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">subsidiária</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">total</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">status</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
            </div>

            <?php foreach ($charges as $key => $charge): ?>
              <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                style="min-width: 1350px; max-width: 100%;">
                <div class="column" style="min-width: 100px; padding-right: 1rem;">
                  <i
                    class="ph-fill ph-circle <?php echo $charge->confirmed == 'T' ? $charge->isinactive == 'F' ? 'active' : 'invalid' : ''; ?>"></i>
                  <strong>
                    <?php echo $charge->tranid; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 250px; padding-right: 1rem;">
                  <strong>
                    <?php echo $charge->suppliername; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo date('d/m/Y', $charge->created); ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $charge->subsidiaryname; ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $charge->total; ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $charge->status; ?>
                </div>
                <div class="column" style="min-width: 200px;">
                  <a class="btn-blue" href="<?php echo base_url('charge/' . $charge->id); ?>">ver</a>
                  <a href="<?php echo base_url('charge/' . $charge->id . '?edit=T'); ?>">editar</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
    <?php require_once ('pagination/pagination.php'); ?>
  </div>
</div>
