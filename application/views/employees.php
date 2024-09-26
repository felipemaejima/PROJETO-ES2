<div class="container">
  <div class="box">
    <div class="box-title">
      Funcionários
      <div>
        <a href="<?php echo base_url('employee'); ?>">novo funcionário</a>
      </div>
    </div>
    <div class="group-title search-tab"><i class="ph ph-minus-circle"></i> filtros</div>
    <div class="box-search search-employees">
      <div class="box-content">
        <div class="box-infos">
          <?php echo form_open(base_url($this->uri->segment(1) . '/1'), array('id' => 'search', 'method' => 'get')); ?>
          <div class="column">
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'name', 'nome', FALSE, $this->input->get('name')); ?>
              <?php echo get_input('hidden', 'search', 'search', FALSE, uuidv4()); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'subsidiary', 'subsidiaria', FALSE, $this->input->get('subsidiary')); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_select($titles, 'title', 'cargo', FALSE, $this->input->get('title')); ?>
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
              <div class="column" style="min-width: 200px; padding-right: 1rem;">cargo</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">subsidiária</div>
              <div class="column" style="min-width: 300px; padding-right: 1rem;">infos</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;">acesso</div>
              <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
            </div>
            <?php foreach ($users as $key => $user): ?>
              <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 1400px; max-width: 100%;">
                <div class="column" style="min-width: 300px; padding-right: 1rem;">
                  <i
                    class="ph-fill ph-circle <?php echo $user->confirmed == 'T' ? $user->giveaccess == 'T' ? 'active' : 'invalid' : ''; ?>"></i>
                    <strong style="width: 45px;"><?php echo $user->externalid; ?></strong>
                  <div>
                    <strong>
                      <?php echo $user->name; ?>
                    </strong>
                    </br>
                    <small>
                      <?php echo $user->email; ?>
                    </small>
                  </div>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $user->title; ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $user->subsidiary; ?>
                </div>
                <div class="column" style="min-width: 300px; padding-right: 1rem;">
                  <small>
                    <?php echo nl2br($user->defaultaddress); ?>
                  </small>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <?php echo $user->giveaccess == 'T' ? 'sim' : 'não'; ?>
                </div>
                <div class="column" style="min-width: 200px; padding-right: 1rem;">
                  <a class="btn-blue" href="<?php echo base_url('employee/' . $user->id); ?>">ver</a>
                  <a href="<?php echo base_url('employee/' . $user->id . '?edit=T'); ?>">editar</a>
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
