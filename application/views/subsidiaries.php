<div class="container">
  <div class="box">
    <div class="box-title">
      Subsidiárias
      <div>
        <a href="<?php echo base_url('subsidiary'); ?>">nova subsidiária</a>
      </div>
    </div>
    <div class="group-title search-tab"><i class="ph ph-minus-circle"></i> filtros</div>
    <div class="box-search search-subsidiaries">
      <div class="box-content">
        <div class="box-infos">
          <?php echo form_open(base_url($this->uri->segment(1) . '/1'), array('id' => 'search', 'method' => 'get')); ?>
          <div class="column">
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'name', 'nome', FALSE, $this->input->get('name')); ?>
              <?php echo get_input('hidden', 'search', 'search', FALSE, uuidv4()); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_select($taxregimes, 'taxregime', 'regime tributário', FALSE, $this->input->get('taxregime')); ?>
            </div>
            <div class="column-25 c-large c-medium c-small c-hidden">

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
              <div class="column" style="min-width: 300px; padding-right: 1rem;">nome</div>
              <div class="column" style="min-width: 300px; padding-right: 1rem;">regime</div>
              <div class="column" style="min-width: 300px; padding-right: 1rem;">alíquota de aproveitamento</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">ativa</div>
              <div class="column" style="min-width: 300px; padding-right: 1rem;"></div>
            </div>
            <?php foreach ($subsidiaries as $key => $subsidiary): ?>
              <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 1400px; max-width: 100%;">
                <div class="column" style="min-width: 300px; padding-right: 1rem;">
                  <i
                    class="ph-fill ph-circle <?php echo $subsidiary->confirmed == 'T' ? $subsidiary->isinactive == 'F' ? 'active' : 'invalid' : ''; ?>"></i>
                  <div>
                    <strong>
                      <?php echo $subsidiary->title; ?>
                    </strong>
                    </br>
                    <small>
                      <?php echo $subsidiary->cnpj; ?>
                    </small>
                  </div>
                </div>
                <div class="column" style="min-width: 300px; padding-right: 1rem;">
                  <?php echo $subsidiary->taxregime; ?>
                </div>
                <div class="column" style="min-width: 300px; padding-right: 1rem;">
                  <?php echo $subsidiary->utilizationrate; ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $subsidiary->isinactive == 'F' ? 'sim' : 'não'; ?>
                </div>
                <div class="column" style="min-width: 300px; padding-right: 1rem;">
                  <a class="btn-blue" href="<?php echo base_url('subsidiary/' . $subsidiary->id); ?>">ver</a>
                  <a href="<?php echo base_url('subsidiary/' . $subsidiary->id . '?edit=T'); ?>">editar</a>
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