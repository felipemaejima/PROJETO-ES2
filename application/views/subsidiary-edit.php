<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-subsidiaries">
        <div class="title"><i class="ph ph-buildings"></i> Subsidiária</div>
        <?php echo form_open('subsidiary/' . $this->uri->segment(2), array('id' => 'subsidiary-edit')); ?>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-subsidiary-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $this->uri->segment(2)); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'title', 'nome', FALSE, $subsidiary[0]->title); ?>
            <?php echo get_input('text', 'phone', 'telefone', FALSE, $subsidiary[0]->phone); ?>
            <?php echo get_input('text', 'url', 'site', FALSE, $subsidiary[0]->url); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'email', 'email', FALSE, $subsidiary[0]->email); ?>
            <?php echo get_input('text', 'emailsuffix', 'sufixo do email', FALSE, $subsidiary[0]->emailsuffix); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_file('logo', 'logotipo da subsidiária', '.jpg, .jpeg, .png'); ?>
            <div class="form-input-content">
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
            <?php echo get_input('text', 'cnpj', 'cnpj', FALSE, $subsidiary[0]->cnpj); ?>
            <?php echo get_input('text', 'legalname', 'razão social', FALSE, $subsidiary[0]->legalname); ?>
            <?php echo get_input('text', 'ie', 'IE', FALSE, $subsidiary[0]->ie); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'utilizationrate', 'alíquota de aproveitamento', FALSE, $subsidiary[0]->utilizationrate); ?>
            <?php echo get_select($taxregimes, 'taxregime', 'regime de tributação', FALSE, $subsidiary[0]->taxregime); ?>
          </div>
          <div class="column-33"></div>
        </div>

        <div class="tab-container">
          <label class="tab-btn active" data-toggle="address">endereço</label> |
          <label class="tab-btn" data-toggle="account">contas</label> |
          <label class="tab-btn" data-toggle="systeminformation">informações do sistema</label>
        </div>
        <div class="tab-wrapper">
          <div id="address" class="tab-wrapper-content" style="display: flex">
            <div class="tab-wrapper-buttons">
              <a href="" class="add-address">add endereço</a>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 750px; max-width: 100%;">
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">expedição padrão</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">faturamento padrão</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">endereço</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($addresses as $key => $address): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 750px; max-width: 100%">
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
                    <div class="column align-right" style="min-width: 200px; padding-right: 1rem;">
                      <a href="" class="btn-blue btn-edit-address">editar</a>
                      <a href="" class="btn-red btn-remove-address">remover</a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

          </div>
          <div id="account" class="tab-wrapper-content" style="display: none">
            <div class="tab-wrapper-buttons">
              <a href="<?php echo base_url("/account?referer=" . $this->uri->segment(2)); ?>" target="_blank">add
                conta</a>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1250px; max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">numero da conta</div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">agencia</div>
                  <div class="column" style="min-width: 400px; padding-right: 1rem;">banco</div>
                  <div class="column" style="min-width: 300px; padding-right: 1rem;">pix</div>
                  <div class="column" style="min-width: 50px; padding-right: 1rem;">preferencial</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($accounts as $key => $account): ?>
                  <div style="overflow-wrap: break-word"
                    class="table-content <?php echo (($key + 1) % 2) == 0 ? ' table-content-color' : ''; ?>"
                    style="min-width: 1250px; max-width: 100%;">
                    <input type="hidden" name="id[]" value="<?php echo $account->id; ?>">
                    <input type="hidden" name="bankname[]" value="<?php echo $account->bankname; ?>">
                    <input type="hidden" name="bankcode[]" value="<?php echo $account->bankcode; ?>">
                    <input type="hidden" name="accountnumber[]" value="<?php echo $account->accountnumber; ?>">
                    <input type="hidden" name="accountnumberdv[]" value="<?php echo $account->accountnumberdv; ?>">
                    <input type="hidden" name="accounttypeid[]" value="<?php echo $account->accounttypeid; ?>">
                    <input type="hidden" name="accounttypename[]" value="<?php echo $account->accounttypename; ?>">
                    <input type="hidden" name="agency[]" value="<?php echo $account->agency; ?>">
                    <input type="hidden" name="agencydv[]" value="<?php echo $account->agencydv; ?>">
                    <input type="hidden" name="pix[]" value="<?php echo $account->pix; ?>">
                    <input type="hidden" name="priority[]" value="<?php echo $account->priority; ?>">
                    <input type="hidden" name="beneficiarycode[]" value="<?php echo $account->beneficiarycode; ?>">
                    <input type="hidden" name="companycode[]" value="<?php echo $account->companycode; ?>">
                    <input type="hidden" name="paymentagreement[]" value="<?php echo $account->paymentagreement; ?>">
                    <input type="hidden" name="accountws[]" value="<?php echo $account->accountws; ?>">
                    <input type="hidden" name="paymentid[]" value="<?php echo $account->paymentid; ?>">
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $account->accountnumber; ?>
                    </div>
                    <div class="column" style="min-width: 100px; padding-right: 1rem;">
                      <?php echo $account->agency; ?>
                    </div>
                    <div class="column" style="min-width: 400px; padding-right: 1rem;">
                      <?php echo $account->bankcode . ' - ' . $account->bankname; ?>
                    </div>
                    <div class="column" style="min-width: 300px; padding-right: 1rem;">
                      <span style="max-width: 100%;">
                        <?php echo $account->pix; ?>
                      </span>
                    </div>
                    <div class="column" style="min-width: 50px; padding-right: 1rem;">
                      <?php echo $account->priority == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column align-right" style="min-width: 200px; padding-right: 1rem;">
                      <a href="<?php echo base_url("/account/" . $account->id . '?edit=T'); ?>" class="btn-blue"
                        target="_blank">editar</a>
                      <a href="" class="btn-red btn-remove-account">remover</a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('isinactive', 'inativo', FALSE, $subsidiary[0]->isinactive); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('issugested', 'sugerida', FALSE, $subsidiary[0]->issugested); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">

              </div>
            </div>
            <?php require_once('logs/system-information.php'); ?>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-subsidiary-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<div id="modal-add-address" class="modal">
  <div class="modal-large">
    <div class="modal-header">
      <div class="close">
        <i class="ph ph-x"></i>
      </div>
    </div>
    <div class="modal-content">
      <div class="box-infos">
        <?php echo form_open('add-address', array('id' => 'add-address')); ?>
        <?php echo get_input('hidden', 'link', 'subsidiária', FALSE, $this->uri->segment(2)); ?>
        <div class="form-input-content">
          <div class="success-message"></div>
        </div>
        <div class="column">
          <div class="column-50 c-large">
            <?php echo get_input('text', 'zip', 'cep'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'country', 'país'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'street', 'rua'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'complement', 'complemento'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'city', 'cidade'); ?>
            <?php echo get_input('hidden', 'citycode', 'código da cidade ibge'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'number', 'número'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'neighborhood', 'bairro'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'state', 'estado'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_checkbox('standardshippingcreate', 'expedição padrão'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_checkbox('standardbillingcreate', 'faturamento padrão'); ?>
          </div>
        </div>
        <button type="submit" class="btn-blue" id="submit-add-address">inserir</button>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
    <div class="modal-footer">
    </div>
  </div>
</div>
<div id="modal-edit-address" class="modal">
  <div class="modal-large">
    <div class="modal-header">
      <div class="close">
        <i class="ph ph-x"></i>
      </div>
    </div>
    <div class="modal-content">
      <div class="box-infos">
        <?php echo form_open('edit-address', array('id' => 'edit-address')); ?>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, ''); ?>
        <div class="form-input-content">
          <div class="success-message"></div>
        </div>
        <div class="column">
          <div class="column-50 c-large">
            <?php echo get_input('text', 'zip', 'cep'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'country', 'país'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'street', 'rua'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'complement', 'complemento'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'city', 'cidade'); ?>
            <?php echo get_input('hidden', 'citycode', 'código da cidade ibge'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'number', 'número'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'neighborhood', 'bairro'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'state', 'estado'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_checkbox('standardshippingcreate', 'expedição padrão'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_checkbox('standardbillingcreate', 'faturamento padrão'); ?>
          </div>
        </div>
        <button type="submit" class="btn-blue" id="submit-edit-address">inserir</button>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
    <div class="modal-footer">
    </div>
  </div>
</div>
<div id="modal-add-account" class="modal">
  <div class="modal-large">
    <div class="modal-header">
      <div class="close">
        <i class="ph ph-x"></i>
      </div>
    </div>
    <div class="modal-content">
      <div class="box-infos">
        <?php echo form_open('add-account', array('id' => 'add-account')); ?>
        <?php echo get_input('hidden', 'link', 'funcionário', FALSE, $this->uri->segment(2)); ?>
        <?php echo get_input('hidden', 'bankcode', 'código	do	banco', FALSE) ?>
        <div class="form-input-content">
          <div class="success-message"></div>
        </div>
        <div class="column">
          <div class="column-50 c-large">
            <?php echo get_input('text', 'accountnumber', 'numero da conta'); ?>
            <?php echo get_input('text', 'accountnumberdv', 'dv numero'); ?>
            <?php echo get_input('text', 'beneficiarycode', 'código do beneficiário'); ?>
            <?php echo get_input('text', 'accountws', 'conta webservice'); ?>
            <?php echo get_input('text', 'paymentagreement', 'convênio para pagamentos'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'agency', 'agência'); ?>
            <?php echo get_input('text', 'agencydv', 'dv agência'); ?>
            <?php echo get_input('text', 'companycode', 'código da empresa'); ?>
            <?php echo get_input('text', 'paymentid', 'id pagamento'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-100">
            <?php echo get_input('text', 'bankname', 'nome do banco'); ?>
            <?php echo get_input('text', 'pix', 'chave pix'); ?>
            <?php echo get_select($accounttypes, 'accounttype', 'tipo da conta'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-50 c-large">
            <?php echo get_checkbox('prioritycreate', 'preferencial'); ?>
          </div>
        </div>
        <button type="submit" class="btn-blue" id="submit-add-account">inserir</button>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
    <div class="modal-footer">
    </div>
  </div>
</div>
<div id="modal-edit-account" class="modal">
  <div class="modal-large">
    <div class="modal-header">
      <div class="close">
        <i class="ph ph-x"></i>
      </div>
    </div>
    <div class="modal-content">
      <div class="box-infos">
        <?php echo form_open('edit-account', array('id' => 'edit-account')); ?>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, ''); ?>
        <?php echo get_input('hidden', 'bankcode', 'código	do	banco', FALSE) ?>
        <div class="form-input-content">
          <div class="success-message"></div>
        </div>
        <div class="column">
          <div class="column-50 c-large">
            <?php echo get_input('text', 'accountnumber', 'numero da conta'); ?>
            <?php echo get_input('text', 'accountnumberdv', 'dv numero'); ?>
            <?php echo get_input('text', 'beneficiarycode', 'código do beneficiário'); ?>
            <?php echo get_input('text', 'accountws', 'conta webservice'); ?>
            <?php echo get_input('text', 'paymentagreement', 'convênio para pagamentos'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'agency', 'agência'); ?>
            <?php echo get_input('text', 'agencydv', 'dv agência'); ?>
            <?php echo get_input('text', 'companycode', 'código da empresa'); ?>
            <?php echo get_input('text', 'paymentid', 'id pagamento'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-100">
            <?php echo get_input('text', 'bankname', 'nome do banco'); ?>
            <?php echo get_input('text', 'pix', 'chave pix'); ?>
            <?php echo get_select($accounttypes, 'accounttype', 'tipo da conta'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-50 c-large">
            <?php echo get_checkbox('priority', 'preferencial'); ?>
          </div>
        </div>
        <button type="submit" class="btn-blue" id="submit-edit-account">inserir</button>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
    <div class="modal-footer">
    </div>
  </div>
</div>