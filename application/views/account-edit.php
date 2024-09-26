<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-accounts">
        <div class="title"><i class="ph ph-bank"></i> Conta</div>
        <?php echo form_open('account', array('id' => 'account-edit')); ?>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-account-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $account[0]->id); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'accountnumber', 'numero da conta', FALSE, $account[0]->accountnumber); ?>
            <?php echo get_input('text', 'accountnumberdv', 'dv numero', FALSE, $account[0]->accountnumberdv); ?>
            <?php echo get_input('text', 'pix', 'chave pix', FALSE, $account[0]->pix); ?>
            <?php echo get_input('text', 'bankname', 'nome do banco', FALSE, $account[0]->bankname); ?>
            <?php echo get_input('hidden', 'bankcode', 'código	do	banco', FALSE, $account[0]->bankcode) ?>
            <?php echo get_input('text', 'accountws', 'conta webservice', FALSE, $account[0]->accountws); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'agency', 'agência', FALSE, $account[0]->agency); ?>
            <?php echo get_input('text', 'agencydv', 'dv agência', FALSE, $account[0]->agencydv); ?>
            <?php echo get_input('text', 'beneficiarycode', 'código do beneficiário', FALSE, $account[0]->beneficiarycode ); ?>
            <br>
            <?php echo get_checkbox('paymentagreement', 'convênio para pagamentos', FALSE, $account[0]->paymentagreement == 'T' ? TRUE : FALSE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($accounttypes, 'accounttype', 'tipo da conta', FALSE, $account[0]->accounttypeid); ?>
            <?php echo get_input('text', 'paymentid', 'id pagamento', FALSE, $account[0]->paymentid); ?>
            <?php echo get_input('text', 'companycode', 'código da empresa', FALSE, $account[0]->companycode); ?>
            <br>
            <?php echo get_checkbox('priority', 'preferencial', FALSE, $account[0]->priority == 'T' ? TRUE : FALSE  ); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="agreement">convênios</label> |
          <label class="tab-btn" data-toggle="charge">cobrança</label> |
        </div>
        <div class="tab-wrapper">
          <div id="agreement" class="tab-wrapper-content" style="display: flex">
            <div class="tab-wrapper-buttons">
              <a href="<?php echo base_url("/agreement?referer=" . $this->uri->segment(2)) ; ?>" target="_blank">add convênio</a>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1250px; max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">numero do convênio</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">carteira</div>
                  <div class="column" style="min-width: 400px; padding-right: 1rem;">descricao</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($agreements as $key => $agreement): ?>
                  <div style="overflow-wrap: break-word"
                  class="table-content <?php echo (($key + 1) % 2) == 0 ? ' table-content-color' : ''; ?>"
                  style="min-width: 1250px; max-width: 100%;">
                  <?php echo get_input('hidden', 'agreementid[]', 'agreementid', FALSE, $agreement->id); ?>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $agreement->agreementnumber; ?>
                    </div>
                    <div class="column" style="min-width: 100px; padding-right: 1rem;">
                      <?php echo $agreement->agreementwallet; ?>
                    </div>
                    <div class="column" style="min-width: 400px; padding-right: 1rem;">
                      <?php echo $agreement->agreementdescription; ?>
                    </div>

                    <div class="column align-right" style="min-width: 200px; padding-right: 1rem;">
                      <a href="<?php echo base_url("/agreement/" . $agreement->id . '?edit=T'); ?>" class="btn-blue" target="_blank">editar</a>
                      <a href="" class="btn-red btn-remove-agreement">remover</a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="charge" class="tab-wrapper-content" style="display: none">
            <div class="group-title">juros</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'interestrate', 'taxa de juros', FALSE, $account[0]->interestrate); ?> 
                <?php echo get_select($interestcodes, 'interestcode', 'código de juros', FALSE, $account[0]->interestcodeid); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'interestvalue', 'valor de juros', FALSE, $account[0]->interestvalue); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'interestdate', 'dias após o vencimento', FALSE, $account[0]->interestdate); ?>
              </div>
            </div>
            <div class="group-title">multa</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'penaltyrate', 'taxa de multa', FALSE, $account[0]->penaltyrate); ?> 
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'penaltyvalue', 'valor de multa', FALSE, $account[0]->penaltyvalue); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'penaltydate', 'dias após o vencimento', FALSE, $account[0]->penaltydate); ?>
              </div>
            </div>
            <div class="group-title">instruções</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_textarea('instructionsfirst', 6, 'instruções 1', $account[0]->instructionsfirst); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_textarea('instructionsecond', 6, 'instruções 2', $account[0]->instructionsecond); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
              </div>
            </div>
            <div class="group-title">local de pagamento</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_textarea('paymentlocation', 1, 'local do pagamento', $account[0]->paymentlocation); ?>
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
          <button type="submit" class="btn-purple" id="submit-account-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>