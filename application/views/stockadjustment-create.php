<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-stock-adjustments">
        <div class="title"><i class="ph ph-stack"></i> Ajuste de estoque</div>
        <?php echo form_open('stockadjustment', array('id' => 'stockadjustment-create')); ?>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-stockadjustment-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'item', 'item'); ?>
            <?php echo get_input('hidden', 'itemid', 'ID do item'); ?>
          </div>
          <div class="column-33">
          </div>
          <div class="column-33">
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="adjustment">ajustes</label>
        </div>
        <div class="tab-wrapper">
          <div id="adjustment" class="tab-wrapper-content" style="display: flex">
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1000px; max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">subsidiaria</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">qtd atual</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">qtd ajustada</div>
                  <div class="column" style="min-width: 300px; padding-right: 1rem;">justificativa</div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-stockadjustment-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
