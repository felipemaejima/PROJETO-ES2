<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-agreements">
        <div class="title"><i class="ph ph-handshake"></i></i> Convênio</div>
        <?php echo form_open('agreement', array('id' => 'agreement-edit')); ?>
        <div class="functions-tab">
          <a href="<?php echo base_url('agreement/' . $agreement[0]->id . '?edit=T'); ?>" class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $agreement[0]->id); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'agreementnumber', 'número do convênio', FALSE, $agreement[0]->agreementnumber, TRUE); ?>
            <?php echo get_input('text', 'agreementwallet', 'carteira', FALSE, $agreement[0]->agreementwallet, TRUE); ?>
            <?php echo get_input('text', 'walletcode', 'código da carteira', FALSE, $agreement[0]->walletcode, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'agreementdescription', 'descricão do convênio', FALSE, $agreement[0]->agreementdescription, TRUE); ?>
            <?php echo get_input('text', 'agreementshippingnumber', 'número da remessa', FALSE, $agreement[0]->agreementshippingnumber, TRUE); ?>
            <?php echo get_input('text', 'walletvariation', 'variação da carteira', FALSE, $agreement[0]->walletvariation); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'agreementdefaultcnab', 'padrão CNAB', FALSE, $agreement[0]->agreementdefaultcnab, TRUE); ?>
            <?php echo get_select($currencies, 'agreementcurrency', 'moeda', FALSE, $agreement[0]->agreementcurrencyid, TRUE, array('GBP', 'EUR')); ?>
            <?php echo get_input('text', 'accountws', 'conta webservice', FALSE, $agreement[0]->accountws, TRUE); ?>
          </div>
        </div>
        <div class="group-title">informações adicionais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('agreementdailyrestart', 'reinicialização diária', TRUE, $agreement[0]->agreementdailyrestart == 'T' ? TRUE : FALSE); ?>
            <?php echo get_checkbox('agreementinstantregistration', 'registro instantâneo', TRUE, $agreement[0]->agreementinstantregistration == 'T' ? TRUE : FALSE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('agreementconsultationwebservice', 'consulta webservice', TRUE, $agreement[0]->agreementconsultationwebservice == 'T' ? TRUE : FALSE); ?>
            <?php echo get_checkbox('agreementwebservicechange', 'alteração webservice', TRUE, $agreement[0]->agreementwebservicechange == 'T' ? TRUE : FALSE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            </div>
          </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab">
          <a href="<?php echo base_url('agreement/' . $agreement[0]->id . '?edit=T'); ?>" class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>