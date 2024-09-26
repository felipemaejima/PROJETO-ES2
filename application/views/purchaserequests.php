<div class="container">
  <div class="box">
    <div class="box-title">
      Requisições de compra
    </div>
    <div class="group-title search-tab"><i class="ph ph-minus-circle"></i> filtros</div>
    <div class="box-search search-purchaserequests">
      <div class="box-content">
        <div class="box-infos">
          <?php echo form_open(base_url($this->uri->segment(1) . '/1'), array('id' => 'search', 'method' => 'get')); ?>
          <?php echo get_input('hidden', $this->security->get_csrf_token_name(), $this->security->get_csrf_token_name(), FALSE, $this->security->get_csrf_hash()); ?>
          <div class="column">
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'saleorder', 'pedido de venda', FALSE, $this->input->get('saleorder')); ?>
              <?php echo get_input('hidden', 'search', 'search', FALSE, uuidv4()); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'supplier', 'fornecedor', FALSE, $this->input->get('supplier')); ?>
              <?php echo get_input('hidden', 'supplierid', 'id fornecedor', FALSE, $this->input->get('supplierid')); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'item', 'item', FALSE, $this->input->get('item')); ?>
              <?php echo get_input('hidden', 'itemid', 'id item', FALSE, $this->input->get('itemid')); ?>
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
              <div class="column" style="min-width: 220px; padding-right: 1rem;">fornecedor</div>
              <div class="column" style="min-width: 220px; padding-right: 1rem;">número de itens</div>
              <div class="column" style="min-width: 220px; padding-right: 1rem;">quantidade de itens</div>
              <div class="column" style="min-width: 220px; padding-right: 1rem;">quantidade de pedidos</div>
              <div class="column" style="min-width: 220px; padding-right: 1rem;">dias em espera</div>
              <div class="column" style="min-width: 220px; padding-right: 1rem;">custo total</div>
              <div class="column" style="min-width: 100px; padding-right: 1rem;"></div>
            </div>
            <?php $count = 0; ?>
            <?php foreach ($purchaserequests as $key => $purchaserequest): ?>
              <div class="table-content <?php echo (($count + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 1420px; max-width: 100%;">
                <div class="column" style="min-width: 220px; padding-right: 1rem;">
                  <strong>
                    <?php echo $purchaserequest->suppliername ? $purchaserequest->suppliername : 'SEM FORNECEDOR'; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 220px; padding-right: 1rem;">
                  <?php echo $purchaserequest->itemscount; ?>
                </div>
                <div class="column" style="min-width: 220px; padding-right: 1rem;">
                  <?php echo $purchaserequest->itemgrossquantity; ?>
                </div>
                <div class="column" style="min-width: 220px; padding-right: 1rem;">
                  <?php echo $purchaserequest->saleordercount; ?>
                </div>
                <div class="column" style="min-width: 220px; padding-right: 1rem;">
                  <?php echo get_days_difference($purchaserequest->created); ?>
                </div>
                <div class="column" style="min-width: 220px; padding-right: 1rem;">
                  <?php echo $purchaserequest->totalitemsconvertedexpense; ?>
                </div>
                <div class="column" style="min-width: 100px; padding-right: 1rem;">
                  <?php $referer = $purchaserequest->supplierid ?  $purchaserequest->supplierid : 'none'; ?>
                  <a class="btn-blue" href="<?php echo base_url("purchaserequest?referer=$referer"); ?>">ver</a>
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