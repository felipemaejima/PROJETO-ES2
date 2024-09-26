<div class="container">
  <div class="box">
    <div class="box-title">
      Orçamentos
      <div>
        <a href="<?php echo base_url('estimate'); ?>">novo orçamento</a>
      </div>
    </div>
    <div class="group-title search-tab"><i class="ph ph-minus-circle"></i> filtros</div>
    <div class="box-search search-estimates">
      <div class="box-content">
        <div class="box-infos">
          <?php echo form_open(base_url($this->uri->segment(1) . '/1'), array('id' => 'search', 'method' => 'get')); ?>
          <?php echo get_input('hidden', $this->security->get_csrf_token_name(), $this->security->get_csrf_token_name(), FALSE, $this->security->get_csrf_hash()); ?>
          <div class="column">
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'estimate', 'orçamento', FALSE, $this->input->get('estimate')); ?>
              <?php echo get_input('hidden', 'search', 'search', FALSE, uuidv4()); ?>
              <?php echo get_input('text', 'initialdate', 'data inicial', FALSE, $this->input->get('initialdate')); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'customer', 'cliente', FALSE, $this->input->get('customer')); ?>
              <?php echo get_input('text', 'finaldate', 'data final', FALSE, $this->input->get('finaldate')); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'salesman', 'vendedor', FALSE, $this->input->get('salesman')); ?>
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
            <div class="table-head" style="min-width: 1225px; max-width: 100%;">
              <div class="column" style="min-width: 125px; padding-right: 1rem;">orçamento</div>
              <div class="column" style="min-width: 250px; padding-right: 1rem;">cliente</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;">criado</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;">total orçado</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;">total fechado</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;">status</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;"></div>
            </div>

            <?php foreach ($estimates as $key => $estimate): ?>
              <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 1225px; max-width: 100%;">
                <div class="column" style="min-width: 125px; padding-right: 1rem;">
                  <i class="ph-fill ph-circle <?php echo $estimate->status == 'gerado' || $estimate->status == 'aprovado' ? 'active' : 'invalid'; ?>"></i>
                  <strong>
                    <?php echo $estimate->tranid; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 250px; padding-right: 1rem;">
                  <strong>
                    <?php echo $estimate->customername; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <?php echo date('d/m/Y', $estimate->created); ?>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <?php echo number_format($estimate->itemtotal, 2, '.', ''); ?>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <?php echo number_format($estimate->itemtotalapprovedamount, 2, '.', ''); ?>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <?php echo $estimate->status; ?>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <a class="btn-blue" href="<?php echo base_url('estimate/' . $estimate->id); ?>">ver</a>
                  <a href="<?php echo base_url('estimate/' . $estimate->id . '?edit=T'); ?>">editar</a>
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
