<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-roles">
        <div class="title"><i class="ph ph-user-switch"></i> Função</div>
        <div class="functions-tab tab-row">
          <a href="<?php echo base_url('role/' . $this->uri->segment(2) . '?edit=T'); ?>" class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $this->uri->segment(2)); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'name', 'nome', FALSE, $role[0]->name, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">

          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('isinactive', 'inativo', TRUE, $role[0]->isinactive); ?>
          </div>
        </div>

        <div class="tab-container">
          <label class="tab-btn active" data-toggle="permissions">permissões</label> |
          <label class="tab-btn" data-toggle="users">usuários</label> |
          <label class="tab-btn" data-toggle="systeminformation">informações do sistema</label>
        </div>
        <div class="tab-wrapper">
          <div id="permissions" class="tab-wrapper-content" style="display: flex">
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 500px; max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">permissões</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">nível</div>
                  <div class="column" style="min-width: 0px; padding-right: 1rem;"></div>
                </div>
                <?php if ($role[0]->permissions): ?>
                  <?php $rows = json_decode($role[0]->permissions); ?>
                  <?php foreach ($rows as $key => $row): ?>
                    <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                      style="min-width: 500px; max-width: 100%;">
                      <div class="column" style="min-width: 200px; padding-right: 1rem;">
                        <?php echo $row->name; ?>
                      </div>
                      <div class="column" style="min-width: 200px; padding-right: 1rem;">
                        <div class="form-input-box">
                          <select name="level[]" disabled>
                            <option value="visualizar" <?php echo $row->level == 'visualizar' ? 'selected' : ''; ?>>Visualizar
                            </option>
                            <option value="criar" <?php echo $row->level == 'criar' ? 'selected' : ''; ?>>Criar</option>
                            <option value="editar" <?php echo $row->level == 'editar' ? 'selected' : ''; ?>>Editar</option>
                            <option value="total" <?php echo $row->level == 'total' ? 'selected' : ''; ?>>Total</option>
                          </select>
                        </div>
                      </div>
                      <div class="column align-right" style="min-width: 0px; padding-right: 1rem;">
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div id="users" class="tab-wrapper-content" style="display: none">
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 500px; max-width: 100%;">
                  <div class="column" style="min-width: 400px; padding-right: 1rem;">usuário</div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">acesso</div>
                  <div class="column" style="min-width: 0px; padding-right: 1rem;"></div>
                </div>
                <?php if ($users): ?>
                  <?php foreach ($users as $key => $row): ?>
                    <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 500px; max-width: 100%;">
                      <div class="column" style="min-width: 400px; padding-right: 1rem;">
                        <a class="btn-link"
                          href="<?php echo base_url('employee/' . $row->id); ?>"><?php echo $row->name; ?></a>
                      </div>
                      <div class="column" style="min-width: 100px; padding-right: 1rem;">
                        <?php echo $row->giveaccess == 'T' ? 'sim' : 'não'; ?>
                      </div>
                      <div class="column align-right" style="min-width: 0px; padding-right: 1rem;">
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
            <div id="systeminformation" class="tab-wrapper-content" style="display: none">
              <?php require_once ('logs/system-information.php'); ?>
            </div>
          </div>
          <div class="form-input-content">
            <div class="error-message error-input"></div>
          </div>
          <div class="functions-tab tab-row">
            <a href="<?php echo base_url('role/' . $this->uri->segment(2) . '?edit=T'); ?>"
              class="btn-purple">editar</a>
            <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
          </div>
        </div>
      </div>
    </div>
  </div>