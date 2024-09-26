<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos">
        <div class="title"><i class="ph ph-stack"></i> Ajuste de estoque</div>
        <div class="functions-tab">
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33">
          </div>
          <div class="column-33">
          </div>
          <div class="column-33">
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="adjustment">ajustes</label> |
          <label class="tab-btn" data-toggle="systeminformation">informações do sistema</label>
        </div>
        <div class="tab-wrapper">
          <div id="adjustment" class="tab-wrapper-content" style="display: flex">
            <div class="table">
              <div class="table-head">
                <div class="column column-15">subsidiaria</div>
                <div class="column column-15">item</div>
                <div class="column column-15">qtd anterior</div>
                <div class="column column-15">qtd ajustada</div>
                <div class="column column-30">justificativa</div>
                <div class="column column-10">data</div>
              </div>
              <?php foreach ($itemstockadjustments as $key => $adjustment): ?>
                <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>">
                  <div class="column column-15">
                    <a href="<?php echo base_url('subsidiary/' . $adjustment->subsidiaryid); ?>" target="_blank"
                      class="btn-link">
                      <?php echo $adjustment->subsidiaryname; ?>
                    </a>
                  </div>
                  <div class="column column-15">
                    <a href="<?php echo base_url('item/' . $adjustment->itemid); ?>" target="_blank" class="btn-link">
                      <?php echo $adjustment->itemname; ?>
                    </a>
                  </div>
                  <div class="column column-15">
                    <?php echo $adjustment->quantityonhandold; ?>
                  </div>
                  <div class="column column-15">
                    <?php echo $adjustment->quantityonhandnew; ?>
                  </div>
                  <div class="column column-30">
                    <?php echo $adjustment->justification; ?>
                  </div>
                  <div class="column column-10">
                    <?php echo date('d/m/Y H:i', $adjustment->created); ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-100">
                <?php require_once ('logs/system-information.php'); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab">
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
      </div>
    </div>
  </div>
</div>
