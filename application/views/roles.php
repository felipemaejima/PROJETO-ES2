<div class="container">
  <div class="box">
    <div class="box-title">
      Lista de Funções
      <a href="<?php echo base_url('role'); ?>">criar função</a>
    </div>

    <div class="tab-wrapper" style="width: 100%">
      <div class="tab-wrapper-content">
        <div class="overflow">
          <div class="table">
            <div class="table-head" style="min-width: 470px; max-width: 100%;">
              <div class="column" style="min-width: 200px; padding-right: 1rem;">Função</div>
              <div class="column" style="min-width: 100px; padding-right: 1rem;">Ativo</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;"></div>
            </div>
            <?php foreach ($roles as $key => $role): ?>
              <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 470px; max-width: 100%;">
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <i class="ph-fill ph-circle <?php echo $role->isinactive == 'F' ? 'active' : ''; ?>"></i>
                  <?php echo $role->name; ?>
                </div>
                <div class="column" style="min-width: 100px; padding-right: 1rem;">
                  <?php echo $role->isinactive == 'F' ? 'ativo' : 'inativo'; ?>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <a class="btn-blue" href="<?php echo base_url('role/' . $role->id); ?>">ver</a>
                  <a href="<?php echo base_url('role/' . $role->id . '?edit=T'); ?>">editar</a>
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