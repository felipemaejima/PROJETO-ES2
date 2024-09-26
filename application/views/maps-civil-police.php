<div class="container">
  <div class="box">
    <div class="box-title">
      Mapa da Polícia Civil
    </div>
    <div class="group-title search-tab"><i class="ph ph-minus-circle"></i> filtros</div>
    <div class="box-search search-invoices">
      <div class="box-content">
        <div class="box-infos">
          <?php echo form_open(base_url($this->uri->segment(1) . '/' . $this->uri->segment(2)), array('id' => 'maps', 'method' => 'post')); ?>
          <div class="column">
            <div class="column-20 c-large c-medium c-small">
            <?php echo get_input('text', 'certificate', 'licença'); ?>
              <?php echo get_input('text', 'initialdate', 'data inicial'); ?>
            </div>
            <div class="column-20 c-large c-medium c-small">
              <?php echo get_input('text', 'certificateduedate', 'validade da licença'); ?>
              <?php echo get_input('text', 'finaldate', 'data final'); ?>
            </div>
            <div class="column-20 c-large c-medium c-small">

            </div>
            <div class="column-20 c-large c-medium c-small">
            </div>
            <div class="column-10 c-large c-medium c-small c-button">
              <div class="form-input-content">
                <div class="form-input-box">
                  <button type="submit" class="btn-blue" id="submitmap">gerar</button>
                </div>
                <div class="error-submit error-input"></div>
              </div>
            </div>
            <div class="column-10 c-large c-medium c-small c-button">
              <div class="form-input-content">
                <div class="form-input-box">
                  <button type="button" class="btn-gray"
                    onclick="window.location.href='<?php echo base_url($this->uri->segment(1) . '/' . $this->uri->segment(2)); ?>'">limpar</button>
                </div>
                <div class="error-clear error-input"></div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
