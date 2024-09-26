<div class="container">
  <div class="box">
    <div class="box-title">
      Pedidos de compra
      <div>
        <a href="<?php echo base_url('purchaseorder'); ?>">nova compra</a>
      </div>
    </div>
    <div class="group-title search-tab"><i class="ph ph-minus-circle"></i> filtros</div>
    <div class="box-search search-purchaseorders">
      <div class="box-content">
        <div class="box-infos">
          <?php echo form_open(base_url($this->uri->segment(1) . '/1'), array('id' => 'search', 'method' => 'get')); ?>
          <?php echo get_input('hidden', $this->security->get_csrf_token_name(), $this->security->get_csrf_token_name(), FALSE, $this->security->get_csrf_hash()); ?>
          <div class="column">
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'purchaseorder', 'pedido de compra', FALSE, $this->input->get('purchaseorder')); ?>
              <?php echo get_input('hidden', 'search', 'search', FALSE, uuidv4()); ?>
              <?php echo get_input('text', 'initialdate', 'data inicial', FALSE, $this->input->get('initialdate')); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'supplier', 'fornecedor', FALSE, $this->input->get('supplier')); ?>
              <?php echo get_input('text', 'finaldate', 'data final', FALSE, $this->input->get('finaldate')); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $this->input->get('subsidiary')); ?>
            </div>

            <div class="column-15 c-large c-medium c-small c-button">
              <div class="form-input-content">
                <div class="form-input-box">
                  <button type="submit" class="btn-blue">pesquisar</button>
                </div>
                <div class="error-submit error-input"></div>
              </div>
            </div>
            <div class="column-10 c-large c-medium c-small c-button">
              <div class="form-input-content">
                <div class="form-input-box">
                  <button type="button" class="btn-gray"
                    onclick="window.location.href='<?php echo base_url($this->uri->segment(1) . '/1'); ?>'">limpar</button>
                </div>
                <div class="error-clear error-input"></div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>

    <div class="tab-wrapper" style="width: 100%">
      <div class="tab-wrapper-content">
        <div class="overflow">
          <div class="table">
            <div class="table-head" style="min-width: 1250px; max-width: 100%;">
              <div class="column" style="min-width: 125px; padding-right: 1rem;">compra</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">fornecedor</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;">criado</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;">previsão de entrega</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;">subsidiaria</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">status</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;"></div>
            </div>
            <?php foreach ($purchaseorders as $key => $purchaseorder): ?>
              <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 1250px; max-width: 100%;">
                <div class="column" style="min-width: 125px; padding-right: 1rem;">
                  <i
                    class="ph-fill ph-circle <?php echo $purchaseorder->confirmed == 'T' ? $purchaseorder->isinactive == 'F' ? 'active' : 'invalid' : ''; ?>"></i>
                  <strong>
                    <?php echo $purchaseorder->tranid; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <strong>
                    <?php echo $purchaseorder->suppliername; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <?php echo date('d/m/Y', $purchaseorder->created); ?>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <?php echo date('d/m/Y', $purchaseorder->deadline); ?>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <?php echo $purchaseorder->subsidiaryname; ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $purchaseorder->status; ?>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <a class="btn-blue" href="<?php echo base_url('purchaseorder/' . $purchaseorder->id); ?>">ver</a>
                  <a href="<?php echo base_url('purchaseorder/' . $purchaseorder->id . '?edit=T'); ?>">editar</a>
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