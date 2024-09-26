<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-subsidiaries">
        <div class="title"><i class="ph ph-buildings"></i> Subsidiária</div>
        <div class="functions-tab tab-row">
          <a href="<?php echo base_url('subsidiary/' . $this->uri->segment(2) . '?edit=T'); ?>"
            class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $this->uri->segment(2)); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'title', 'nome', FALSE, $subsidiary[0]->title, TRUE); ?>
            <?php echo get_input('text', 'phone', 'telefone', FALSE, $subsidiary[0]->phone, TRUE); ?>
            <?php echo get_input('text', 'url', 'site', FALSE, $subsidiary[0]->url, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'email', 'email', FALSE, $subsidiary[0]->email, TRUE); ?>
            <?php echo get_input('text', 'emailsuffix', 'sufixo do email', FALSE, $subsidiary[0]->emailsuffix, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <div class="form-input-content">
              <label for="logo">logotipo da subsidiária</label>
              <div class="thumb">
                <?php if ($subsidiary[0]->logo): ?>
                  <img src="<?php echo base_url($subsidiary[0]->logo); ?>">
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="group-title">informações empresariais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'cnpj', 'cnpj', FALSE, $subsidiary[0]->cnpj, TRUE); ?>
            <?php echo get_input('text', 'legalname', 'razão social', FALSE, $subsidiary[0]->legalname, TRUE); ?>
            <?php echo get_input('text', 'ie', 'IE', FALSE, $subsidiary[0]->ie, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'utilizationrate', 'alíquota de aproveitamento', FALSE, $subsidiary[0]->utilizationrate, TRUE); ?>
            <?php echo get_select($taxregimes, 'taxregime', 'regime de tributação', FALSE, $subsidiary[0]->taxregime, TRUE); ?>
          </div>
          <div class="column-33">
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="address">endereço</label> |
          <label class="tab-btn" data-toggle="accounts">contas</label> |
          <label class="tab-btn" data-toggle="systeminformation">informações do sistema</label>
        </div>
        <div class="tab-wrapper">
          <div id="address" class="tab-wrapper-content" style="display: flex">
            <div class="tab-wrapper-buttons">
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 500px; max-width: 100%">
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">expedição padrão</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">faturamento padrão</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">endereço</div>
                  <div class="column" style="min-width: 0px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($addresses as $key => $address): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 500px; max-width: 100%">
                    <div class="column" style="min-width: 125px; padding-right: 1rem;">
                      <?php echo $address->standardshipping == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;">
                      <?php echo $address->standardbilling == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;">
                      <?php echo $address->street . ', ' . $address->number; ?>
                      <br>
                      <?php echo $address->neighborhood . ' - ' . $address->city . ' - ' . $address->state; ?>
                      <br>
                      <?php echo 'CEP: ' . $address->zip; ?>
                      <input type="hidden" name="id[]" value="<?php echo $address->id; ?>">
                      <input type="hidden" name="street[]" value="<?php echo $address->street; ?>">
                      <input type="hidden" name="number[]" value="<?php echo $address->number; ?>">
                      <input type="hidden" name="complement[]" value="<?php echo $address->complement; ?>">
                      <input type="hidden" name="neighborhood[]" value="<?php echo $address->neighborhood; ?>">
                      <input type="hidden" name="city[]" value="<?php echo $address->city; ?>">
                      <input type="hidden" name="citycode[]" value="<?php echo $address->citycode; ?>">
                      <input type="hidden" name="state[]" value="<?php echo $address->state; ?>">
                      <input type="hidden" name="zip[]" value="<?php echo $address->zip; ?>">
                      <input type="hidden" name="country[]" value="<?php echo $address->country; ?>">
                      <input type="hidden" name="standardshipping[]" value="<?php echo $address->standardshipping; ?>">
                      <input type="hidden" name="standardbilling[]" value="<?php echo $address->standardbilling; ?>">
                    </div>
                    <div class="column align-right" style="min-width: 0px; padding-right: 1rem;">
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="accounts" class="tab-wrapper-content" style="display: none">
    
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 900px; max-width: 100%">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">numero da conta</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">agencia</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">banco</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">pix</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">preferencial</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($accounts as $key => $account): ?>
                  <div style="overflow-wrap: break-word"
                    class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 900px; max-width: 100%">
                    <input type="hidden" name="accountnumber[]" value="<?php echo $account->accountnumber; ?>">
                    <input type="hidden" name="agency[]" value="<?php echo $account->agency; ?>">
                    <input type="hidden" name="bankname[]" value="<?php echo $account->bankname; ?>">
                    <input type="hidden" name="bankcode[]" value="<?php echo $account->bankcode; ?>">
                    <input type="hidden" name="pix[]" value="<?php echo $account->pix; ?>">
                    <input type="hidden" name="priority[]" value="<?php echo $account->priority; ?>">
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $account->accountnumber; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $account->agency; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $account->bankcode . ' - ' . $account->bankname; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <span style="max-width: 100%;">
                        <?php echo $account->pix; ?>
                      </span>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $account->priority == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column align-right" style="min-width: 200px; padding-right: 1rem;">
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('isinactive', 'inativo', TRUE, $subsidiary[0]->isinactive); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('issugested', 'sugerida', TRUE, $subsidiary[0]->issugested); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">

              </div>
            </div>
            <?php require_once ('logs/system-information.php'); ?>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <a href="<?php echo base_url('subsidiary/' . $this->uri->segment(2) . '?edit=T'); ?>"
            class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
      </div>
    </div>
  </div>
</div>