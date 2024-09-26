<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-installments">
        <?php echo form_open('installment', array('id' => 'purchaseorderinstallment-edit')); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title">
              <i class="ph ph-receipt"></i> 
              Parcela
              <?php echo $installment[0]->installment; ?>
            </div>
            <div class="functions-tab tab-row">
              <a href="<?php echo base_url('purchaseorderinstallment/' . $this->uri->segment(2) . '?edit=T'); ?>"
              class="btn-purple">editar</a>
              <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
            </div>
          </div>
        </div>
        <div class="column-33 c-large c-medium c-small">
          <div class="form-input-content">
            <label for="createdfrom">criado de</label>
            <a href="<?php echo base_url('purchaseorder/' . $installment[0]->link); ?>">
              pedido de compra
              <?php echo $installment[0]->tranid; ?></a>
            <div class="error-createdfrom error-input"></div>
          </div>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $installment[0]->id); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'suppliername', 'fornecedor', FALSE, $installment[0]->suppliername, TRUE); ?>
            <?php echo get_input('hidden', 'supplierid', 'fornecedor id', FALSE, $installment[0]->supplierid, TRUE); ?>
            <?php echo get_input('text', 'total', 'total', FALSE, $installment[0]->total, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'subsidiaryname', 'subsidiaria', FALSE, $installment[0]->subsidiaryname, TRUE); ?>
            <?php echo get_input('hidden', 'subsidiaryid', 'id subsidiaria', FALSE, $installment[0]->subsidiaryid, TRUE); ?>
            <?php echo get_input('text', 'duevalue', 'valor devido', FALSE, $installment[0]->duevalue, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'deadline', 'data de vencimento', FALSE, $installment[0]->deadline != 0 ? date('d/m/Y', $installment[0]->deadline) : FALSE, TRUE); ?>
            <?php echo get_input('text', 'percentage', 'percentual', FALSE, $installment[0]->percentage, TRUE); ?>
          </div>
        </div>
        <div class="group-title">boleto</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'billingdocsituation', 'situação do boleto', FALSE, $installment[0]->billingdocsituation, TRUE); ?>
            <?php echo get_checkbox('billingdocsended', 'boleto enviado', TRUE, $installment[0]->billingdocsended == 'T' ? TRUE : FALSE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'billingdocid', 'id boleto', FALSE, $installment[0]->billingdocid, TRUE); ?>
            <?php echo get_checkbox('billingdoccreated', 'boleto gerado', TRUE, $installment[0]->billingdoccreated == 'T' ? TRUE : FALSE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'billingdocbarcode', 'codigo de barra do boleto', FALSE, $installment[0]->billingdocbarcode, TRUE); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="payments">pagamentos</label>
        </div>
        <div class="tab-wrapper">
        <div id="payments" class="tab-wrapper-content" style="display: flex"><div class="overflow">
            <div class="table">
              <div class="table-head" style="min-width: 600px; max-width: 100%;">
                <div class="column" style="min-width: 100px; padding-right: 1rem;">subsidiaria</div>
                <div class="column" style="min-width: 100px; padding-right: 1rem;">data</div>
                <div class="column" style="min-width: 100px; padding-right: 1rem;">valor</div>
                <div class="column" style="min-width: 100px; padding-right: 1rem;">desconto</div>
                <div class="column" style="min-width: 100px; padding-right: 1rem;">juros</div>
                <div class="column" style="min-width: 100px; padding-right: 1rem;">multa</div>
              </div>
              <?php $count = 1; ?>
              <?php foreach($payments as $payment): ?>
                <div class="table-content <?php echo $count % 2 == 0 ? 'table-content-color' : ''; ?>"
                  style="min-width: 600px; max-width: 100%">
                  <div class="column" style="min-width: 100px; padding-right: 1rem;" title="linha">
                    <?php echo $payment->subsidiaryname; ?>
                  </div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;" title="data">
                    <?php echo date('d/m/Y', $payment->trandate); ?>
                  </div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;" title="valor">
                    <?php echo $payment->total; ?>
                  </div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;" title="desconto">
                    <?php echo $payment->discount; ?>
                  </div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;" title="juros">
                    <?php echo $payment->interest; ?>
                  </div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;" title="multa">
                    <?php echo $payment->fine; ?>
                  </div>
                </div>
                <?php $count++; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <a href="<?php echo base_url('purchaseorderinstallment/' . $this->uri->segment(2) . '?edit=T'); ?>"
          class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>