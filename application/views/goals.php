<div class="container">
  <div class="box">
    <div class="box-title">
      Metas
      <div>
        <a href="<?php echo base_url('goal'); ?>">nova meta</a>
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
              <?php echo get_input('text', 'year', 'ano', FALSE, $this->input->get('year')); ?>
              <?php echo get_input('hidden', 'search', 'search', FALSE, uuidv4()); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'salesman', 'vendedor', FALSE, $this->input->get('salesman')); ?>
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
            <div class="table-head" style="min-width: 900px; max-width: 100%;">
              <div class="column" style="min-width: 350px; padding-right: 1rem;">vendedor</div>
              <div class="column" style="min-width: 250px; padding-right: 1rem;">ano</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;">meta anual</div>
              <div class="column" style="min-width: 150px; padding-right: 1rem;"></div>
            </div>

            <?php foreach ($goals as $key => $goal): ?>
              <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                style="min-width: 900px; max-width: 100%;">
                <div class="column" style="min-width: 350px; padding-right: 1rem;">
                  <i
                    class="ph-fill ph-circle <?php echo $goal->isinactive == 'F' ? 'active' : 'invalid'; ?>"></i>
                  <strong>
                    <?php echo $goal->salesmanname; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 250px; padding-right: 1rem;">
                  <strong>
                    <?php echo $goal->year; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <?php $goaltotal = $goal->january + $goal->february + $goal->march + $goal->april + $goal->may + $goal->june + $goal->july + $goal->august + $goal->september + $goal->october + $goal->november + $goal->december; ?>
                  <?php echo number_format($goaltotal, 2, '.', ''); ?>
                </div>
                <div class="column" style="min-width: 150px; padding-right: 1rem;">
                  <a class="btn-blue" href="<?php echo base_url('goal/' . $goal->id); ?>">ver</a>
                  <a href="<?php echo base_url('goal/' . $goal->id . '?edit=T'); ?>">editar</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('pagination/pagination.php'); ?>
  </div>
</div>
