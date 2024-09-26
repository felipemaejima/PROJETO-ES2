<div class="container">
  <div class="box">
    <div class="box-title">
      Ajustes de estoque
      <div>
        <a href="<?php echo base_url('stock-adjustment'); ?>">novo ajuste</a>
      </div>
    </div>
    <div class="group-title search-tab"><i class="ph ph-minus-circle"></i> filtros</div>
    <div class="box-search search-inventory">
      <div class="box-content">
        <div class="box-infos">
          <?php echo form_open(base_url($this->uri->segment(1) . '/1'), array('id' => 'search', 'method' => 'get')); ?>
          <?php echo get_input('hidden', $this->security->get_csrf_token_name(), $this->security->get_csrf_token_name(), FALSE, $this->security->get_csrf_hash()); ?>
          <div class="column">
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'item', 'item', FALSE, $this->input->get('item')); ?>
              <?php echo get_input('hidden', 'search', 'search', FALSE, uuidv4()); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
            </div>
            <div class="column-25 c-large c-medium c-small">
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
            <div class="table-head" style="min-width: 1400px; max-width: 100%;">
              <div class="column" style="min-width: 200px; padding-right: 1rem;">subsidiária</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">item</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">estoque anterior</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">estoque alterado</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">justificativa</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">data</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
            </div>
            <?php foreach ($itemsstockadjustments as $key => $adjustment): ?>
              <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 1400px; max-width: 100%;">
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <i class="ph-fill ph-circle active"></i>
                  <div>
                    <strong>
                      <?php echo $adjustment->subsidiaryname; ?>
                    </strong>
                    </br>
                  </div>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $adjustment->itemname; ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $adjustment->quantityonhandold; ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $adjustment->quantityonhandnew; ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $adjustment->justification; ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo date('d/m/Y H:i', $adjustment->created); ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <a class="btn-blue" href="<?php echo base_url('stock-adjustment/' . $adjustment->id); ?>">ver</a>
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