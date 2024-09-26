<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-accounts">
        <div class="title"><i class="ph ph-bank"></i> Conta</div>
        <?php echo form_open('account', array('id' => 'account-create')); ?>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-account-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'link', 'link', FALSE, $this->input->get('referer')); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'accountnumber', 'numero da conta'); ?>
            <?php echo get_input('text', 'accountnumberdv', 'dv numero'); ?>
            <?php echo get_input('text', 'pix', 'chave pix'); ?>
            <?php echo get_input('text', 'bankname', 'nome do banco'); ?>
            <?php echo get_input('hidden', 'bankcode', 'código	do	banco', FALSE) ?>
            <?php echo get_input('text', 'accountws', 'conta webservice'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'agency', 'agência'); ?>
            <?php echo get_input('text', 'agencydv', 'dv agência'); ?>
            <?php echo get_input('text', 'beneficiarycode', 'código do beneficiário'); ?>
            <br>
            <?php echo get_checkbox('paymentagreement', 'convênio para pagamentos'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($accounttypes, 'accounttype', 'tipo da conta'); ?>
            <?php echo get_input('text', 'paymentid', 'id pagamento'); ?>
            <?php echo get_input('text', 'companycode', 'código da empresa'); ?>
            <br>
            <?php echo get_checkbox('priority', 'preferencial'); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="charge">cobrança</label> |
        </div>
        <div class="tab-wrapper">
          <div id="charge" class="tab-wrapper-content" style="display: none">
            <div class="group-title">juros</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'interestrate', 'taxa de juros'); ?> 
                <?php echo get_select($interestcodes, 'interestcode', 'código de juros'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'interestvalue', 'valor de juros'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'interestdate', 'dias após o vencimento'); ?>
              </div>
            </div>
            <div class="group-title">multa</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'penaltyrate', 'taxa de multa'); ?> 
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'penaltyvalue', 'valor de multa'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'penaltydate', 'dias após o vencimento'); ?>
              </div>
            </div>
            <div class="group-title">instruções</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_textarea('instructionsfirst', 6, 'instruções 1'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_textarea('instructionsecond', 6, 'instruções 2'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
              </div>
            </div>
            <div class="group-title">local de pagamento</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_textarea('paymentlocation', 1, 'local do pagamento'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
              </div>
              <div class="column-33 c-large c-medium c-small">
              </div>
            </div>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-account-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>