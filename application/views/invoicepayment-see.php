<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-payments">
        <?php echo form_open('payment', array('id' => 'invoicepayment-edit')); ?>
        <?php echo get_input('hidden', 'installmentid', 'parcela id', FALSE, $payment[0]->installmentid, TRUE); ?>
        <?php echo get_input('hidden', 'installmenttotal', 'total parcela', FALSE, $payment[0]->installmenttotal, TRUE); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title">
              <i class="ph ph-receipt"></i>
              Pagamento
              <?php echo $payment[0]->tranid; ?>
            </div>
            <div class="functions-tab tab-row">
              <a href="<?php echo base_url('invoicepayment/' . $this->uri->segment(2) . '?edit=T'); ?>"
                class="btn-purple">editar</a>
              <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
            </div>
          </div>
        </div>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customername', 'cliente', FALSE, $payment[0]->customername, TRUE); ?>
            <?php echo get_input('hidden', 'customerid', 'cliente id', FALSE, $payment[0]->customerid, TRUE); ?>
            <?php echo get_input('text', 'accountname', 'conta', FALSE, $payment[0]->accountname, TRUE); ?>
            <?php echo get_input('hidden', 'accountid', 'id conta', FALSE, $payment[0]->accountid, TRUE); ?>
            <?php echo get_input('text', 'total', 'valor', FALSE, $payment[0]->total, TRUE); ?>
            <?php echo get_input('text', 'discount', 'desconto', FALSE, $payment[0]->discount, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'subsidiaryname', 'subsidiaria', FALSE, $payment[0]->subsidiaryname, TRUE); ?>
            <?php echo get_input('hidden', 'subsidiaryid', 'id subsidiaria', FALSE, $payment[0]->subsidiaryid, TRUE); ?>
            <?php echo get_input('text', 'trandate', 'data', FALSE, date('d/m/Y', $payment[0]->trandate), TRUE); ?>
            <?php echo get_input('text', 'fine', 'multa', FALSE, $payment[0]->fine, TRUE); ?>
            <?php echo get_input('text', 'interest', 'juros', FALSE, $payment[0]->interest, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $payment[0]->comments); ?>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <a href="<?php echo base_url('invoicepayment/' . $this->uri->segment(2) . '?edit=T'); ?>"
            class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>