<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-roles">
        <div class="title"><i class="ph ph-user-switch"></i> Função</div>
        <?php echo form_open('role', array('id' => 'role-create')); ?>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-role-create">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'name', 'nome'); ?>
          </div>
          <div class="column-33">

          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('isinactive', 'inativo'); ?>
          </div>
        </div>

        <div class="tab-container">
          <label class="tab-btn active" data-toggle="permissions">permissões</label>
        </div>
        <div class="tab-wrapper">
          <div id="permissions" class="tab-wrapper-content" style="display: flex">
            <div class="tab-wrapper-buttons">
              <div class="column">
                <div class="column-33 c-large c-medium c-small">
                  <?php echo get_select($functions, 'permissions', 'permissão'); ?>
                </div>
              </div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 600px; max-width: 100%;">
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">permissões</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">nível</div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-input-content">
            <div class="error-message error-input"></div>
          </div>
          <div class="functions-tab">
            <button type="submit" class="btn-purple" id="submit-role-create">salvar</button>
            <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>