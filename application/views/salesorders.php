<div class="container">
  <div class="box">
    <div class="box-title">
      Pedidos de Venda
      <div>
        <a href="<?php echo base_url('saleorder'); ?>">novo pedido de venda</a>
      </div>
    </div>
    <div class="group-title search-tab"><i class="ph ph-minus-circle"></i> filtros</div>
    <div class="box-search search-estimates search-salesorders">
      <div class="box-content">
        <div class="box-infos">
          <?php echo form_open(base_url($this->uri->segment(1) . '/1'), array('id' => 'search', 'method' => 'get')); ?>
          <?php echo get_input('hidden', $this->security->get_csrf_token_name(), $this->security->get_csrf_token_name(), FALSE, $this->security->get_csrf_hash()); ?>
          <div class="column">
            <div class="column-20 c-large c-medium c-small">
              <?php echo get_input('text', 'saleorder', 'pedido de venda', FALSE, $this->input->get('saleorder')); ?>
              <?php echo get_input('hidden', 'search', 'search', FALSE, uuidv4()); ?>
              <?php echo get_input('text', 'initialdate', 'data inicial', FALSE, $this->input->get('initialdate')); ?>
            </div>
            <div class="column-20 c-large c-medium c-small">
              <?php echo get_input('text', 'customer', 'cliente', FALSE, $this->input->get('customer')); ?>
              <?php echo get_input('text', 'finaldate', 'data final', FALSE, $this->input->get('finaldate')); ?>
            </div>
            <div class="column-20 c-large c-medium c-small">
              <?php echo get_input('text', 'salesman', 'vendedor', FALSE, $this->input->get('salesman')); ?>
            </div>
            <div class="column-20 c-large c-medium c-small">
              <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $this->input->get('subsidiary')); ?>
            </div>
            <div class="column-10 c-large c-medium c-small c-button">
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

    <div class="tab-wrapper" style="width: 100%;">
      <div class="tab-wrapper-content">
        <div class="overflow">
          <div class="table">
            <div class="table-head" style="min-width: 1250px; max-width: 100%;">
              <div class="column" style="min-width: 135px; padding-right: 1rem;">pedido de venda</div>
              <div class="column" style="min-width: 250px; padding-right: 1rem;">cliente</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;">criado</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;">subsidiária</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;">total</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">status</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;"></div>
            </div>

            <?php foreach ($salesorders as $key => $saleorder): ?>
              <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                style="min-width: 1250px; max-width: 100%;">
                <div class="column" style="min-width: 135px; padding-right: 1rem;">
                  <i
                    class="ph-fill ph-circle <?php echo $saleorder->confirmed == 'T' ? $saleorder->isinactive == 'F' ? 'active' : 'invalid' : ''; ?>"></i>
                  <strong>
                    <?php echo $saleorder->tranid; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 250px; padding-right: 1rem;">
                  <strong>
                    <?php echo $saleorder->customername; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <?php echo date('d/m/Y', $saleorder->created); ?>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <?php echo $saleorder->subsidiarytitle; ?>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <?php echo number_format($saleorder->itemtotal, 2, '.', ''); ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $saleorder->status; ?>
                </div>
                <div class="column" style="min-width: 150px;">
                  <a class="btn-blue" href="<?php echo base_url('saleorder/' . $saleorder->id); ?>">ver</a>
                  <a href="<?php echo base_url('saleorder/' . $saleorder->id . '?edit=T'); ?>">editar</a>
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
