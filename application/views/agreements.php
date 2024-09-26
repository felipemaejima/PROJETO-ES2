<div class="container">
  <div class="box">
    <div class="box-title">
      Convênios
      <div>
        <a href="<?php echo base_url('agreement?referer=' . $this->input->get('referer')); ?>">novo convênio</a>
      </div>
    </div>
    <div class="group-title search-tab"><i class="ph ph-minus-circle"></i> filtros</div>
    <div class="box-search search-agreements">
      <div class="box-content">
        <div class="box-infos">
          <?php echo form_open(base_url($this->uri->segment(1) . '/1'), array('id' => 'search', 'method' => 'get')); ?>
          <?php echo get_input('hidden', $this->security->get_csrf_token_name(), $this->security->get_csrf_token_name(), FALSE, $this->security->get_csrf_hash()); ?>
          <div class="column">
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'agreementnumber', 'convênio', FALSE, $this->input->get('agreementnumber')); ?>
              <?php echo get_input('hidden', 'search', 'search', FALSE, uuidv4()); ?>
            </div>
            <div class="column-50 c-large c-medium c-small">
              <?php echo get_input('text', 'agreementdescription', 'descricão', FALSE, $this->input->get('agreementdescription')); ?>
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
            <div class="table-head" style="min-width: 1420px; max-width: 100%;">
              <div class="column" style="min-width: 220px; padding-right: 1rem;">numero do convênio</div>
              <div class="column" style="min-width: 220px; padding-right: 1rem;">descrição do convênio</div>
              <div class="column" style="min-width: 100px; padding-right: 1rem;"></div>
            </div>
            <?php $count = 0; ?>
            <?php foreach ($agreements as $key => $agreement): ?>
              <div class="table-content <?php echo (($count + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 1420px; max-width: 100%;">
                <div class="column" style="min-width: 220px; padding-right: 1rem;">
                  <strong>
                    <?php echo $agreement->agreementnumber; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 220px; padding-right: 1rem;">
                  <?php echo $agreement->agreementdescription; ?>
                </div>
                <div class="column" style="min-width: 100px; padding-right: 1rem;">
                  <a class="btn-blue" href="<?php echo base_url('agreement/' . $agreement->id); ?>">ver</a>
                  <a href="<?php echo base_url('agreement/' . $agreement->id . '?edit=T'); ?>">editar</a>
                </div>
              </div>
              <?php $count++; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
    <?php require_once ('pagination/pagination.php'); ?>
  </div>
</div>