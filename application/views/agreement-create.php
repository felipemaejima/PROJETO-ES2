<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-agreements">
        <div class="title"><i class="ph ph-handshake"></i></i> Convênio</div>
        <?php echo form_open('agreement', array('id' => 'agreement-create')); ?>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-agreement-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'link', 'link', FALSE, !empty($account[0]->id) ? $account[0]->id : ''); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'agreementnumber', 'número do convênio'); ?>
            <?php echo get_input('text', 'agreementwallet', 'carteira'); ?>
            <?php echo get_input('text', 'walletcode', 'código da carteira'); ?>
            <?php echo get_input('text', 'agreementws', 'convênio webservice'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'agreementdescription', 'descricão do convênio', FALSE, !empty($account[0]->bankname) ? $account[0]->bankname : FALSE); ?>
            <?php echo get_input('text', 'agreementshippingnumber', 'número da remessa'); ?>
            <?php echo get_input('text', 'walletvariation', 'variação da carteira'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'agreementdefaultcnab', 'padrão CNAB'); ?>
            <?php echo get_select($currencies, 'agreementcurrency', 'moeda', FALSE, FALSE, FALSE, array('GBP', 'EUR')); ?>
            <?php echo get_input('text', 'accountws', 'conta webservice', FALSE, !empty($account[0]->accountws) ? $account[0]->accountws : FALSE); ?>
          </div>
        </div>
        <div class="group-title">informações adicionais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('agreementdailyrestart', 'reinicialização diária'); ?>
            <?php echo get_checkbox('agreementinstantregistration', 'registro instantâneo'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('agreementconsultationwebservice', 'consulta webservice'); ?>
            <?php echo get_checkbox('agreementwebservicechange', 'alteração webservice'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            </div>
          </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-agreement-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>