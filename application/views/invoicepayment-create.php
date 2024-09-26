<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-payments">
        <?php echo form_open('payment', array('id' => 'invoicepayment-create')); ?>
        <?php echo get_input('hidden', 'installmentid', 'id parcela', FALSE, $this->input->get('referer')); ?>
        <?php echo get_input('hidden', 'installmenttotal', 'valor total', FALSE, $payment[0]->duevalue); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title">
              <i class="ph ph-receipt"></i>
              Pagamento
            </div>
            <div class="functions-tab tab-row">
              <button type="submit" class="btn-purple" id="submit-invoicepayment-create">criar</button>
              <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
            </div>
          </div>
        </div>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customername', 'cliente', FALSE, $payment[0]->customername, TRUE); ?>
            <?php echo get_input('hidden', 'customerid', 'cliente id', FALSE, $payment[0]->customerid, TRUE); ?>
            <?php echo get_select($accounts, 'account', 'conta', FALSE, $payment[0]->accountid); ?>
            <?php echo get_input('text', 'total', 'valor', FALSE, $payment[0]->duevalue); ?>
            <?php echo get_input('text', 'discount', 'desconto', FALSE, '0.00'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $payment[0]->subsidiaryid); ?>
            <?php echo get_input('text', 'trandate', 'data', FALSE, date('d/m/Y')); ?>
            <?php echo get_input('text', 'fine', 'multa', FALSE, '0.00'); ?>
            <?php echo get_input('text', 'interest', 'juros', FALSE, '0.00'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações'); ?>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-invoicepayment-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>