<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-employees">
        <div class="title"><i class="ph ph-identification-card"></i> Funcionário</div>
        <?php echo form_open('employee/' . $this->uri->segment(2), array('id' => 'employee-edit')); ?>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-employee-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <div class="functions-tab">
          <div class="legal-infos">
            Criado em:
            <?php echo date('d/m/Y H:i', $employee[0]->created); ?><br />
            <?php if ($employee[0]->updated): ?>
              Editado em:
              <?php echo date('d/m/Y H:i', $employee[0]->updated); ?>
            <?php endif; ?>
          </div>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $this->uri->segment(2)); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($salutations, 'salutation', 'tratamento', FALSE, $employee[0]->salutation); ?>
            <?php echo get_input('text', 'name', 'nome', FALSE, $employee[0]->name); ?>
            <?php echo get_input('text', 'initials', 'iniciais', FALSE, $employee[0]->initials); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($titles, 'title', 'cargo', FALSE, $employee[0]->title); ?>
            <?php echo get_select($supervisor, 'supervisor', 'supervisor', FALSE, $employee[0]->supervisor); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $employee[0]->comments); ?>
          </div>
        </div>
        <div class="group-title">informações pessoais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'email', 'email', FALSE, $employee[0]->email); ?>
            <?php echo get_input('text', 'document', 'documento', FALSE, $employee[0]->document); ?>
            <?php echo get_input('text', 'dateofbirth', 'data de nascimento', FALSE, $employee[0]->dateofbirth ? date('d/m/Y', $employee[0]->dateofbirth) : FALSE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'phone', 'telefone', FALSE, $employee[0]->phone); ?>
            <?php echo get_input('text', 'mobilephone', 'celular', FALSE, $employee[0]->mobilephone); ?>
            <?php echo get_input('text', 'dateofhire', 'data de contratação', FALSE, $employee[0]->dateofhire ? date('d/m/Y', $employee[0]->dateofhire) : FALSE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('defaultaddress', 6, 'endereço padrão', $employee[0]->defaultaddress, TRUE); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiária', FALSE, $employee[0]->subsidiary); ?>
            <?php echo get_select($immediateapprover, 'immediateapprover', 'aprovador imediato', FALSE, $employee[0]->immediateapprover); ?>
            <?php echo get_select($topapprover, 'topapprover', 'aprovador superior', FALSE, $employee[0]->topapprover); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'emailprefix', 'prefixo do email', FALSE, $employee[0]->emailprefix); ?>
            <div class="email-list">
              <?php foreach ($subsidiaries as $key => $value): ?>
                <?php if ($value->emailsuffix): ?>
                  <p>
                    <?php echo $employee[0]->emailprefix . $value->emailsuffix; ?>
                  </p>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('commercialspecialist', 'especialista comercial', FALSE, $employee[0]->commercialspecialist); ?>
            <?php echo get_checkbox('salesrepresentative', 'representante de vendas', FALSE, $employee[0]->salesrepresentative); ?>
            <?php echo get_checkbox('supportrepresentative', 'representante de suporte', FALSE, $employee[0]->supportrepresentative); ?>
            <?php echo get_checkbox('eligibleforcommission', 'aprovado para comissão', FALSE, $employee[0]->eligibleforcommission); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="address">endereço</label> |
          <label class="tab-btn" data-toggle="access">acesso</label> |
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
                    style="min-width: 750px; max-width: 100%;">
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
          <div id="access" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('giveaccess', 'fornecer acesso', FALSE, $employee[0]->giveaccess); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('sendemail', 'enviar email de notificação de acesso'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('isinactive', 'inativo', FALSE, $employee[0]->isinactive); ?>
              </div>
            </div>
            <div class="tab-wrapper-buttons">
              <div class="column">
                <div class="column-33 c-large c-medium c-small">
                  <?php echo get_select($roles, 'roles', 'funções', FALSE, FALSE, FALSE, json_decode($employee[0]->roles)); ?>
                </div>
              </div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 500px; max-width: 100%;">
                  <div class="column" style="min-width: 250px; max-width: 100%;">função</div>
                  <div class="column" style="min-width: 250px; max-width: 100%;"></div>
                </div>
                <?php if (!!$employee[0]->roles): ?>
                  <?php foreach (json_decode($employee[0]->roles) as $key => $role): ?>
                    <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                      style="min-width: 500px; max-width: 100%;">
                      <div class="column" style="min-width: 250px; max-width: 100%;">
                        <?php $index = get_position_array($role, $roles); ?>
                        <?php echo $roles[$index]->title; ?>
                        <input type="hidden" name="roleid[]" value="<?php echo $roles[$index]->id; ?>">
                        <input type="hidden" name="rolename[]" value="<?php echo $roles[$index]->title; ?>">
                      </div>
                      <div class="column" style="min-width: 250px; max-width: 100%;">
                        <a href="" class="btn-red btn-remove-role">remover</a>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div id="account" class="tab-wrapper-content" style="display: none">
            <div class="tab-wrapper-buttons">
              <a href="" class="add-account">add conta</a>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1150px; max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">numero da conta</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">agencia</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">banco</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">pix</div>
                  <div class="column" style="min-width: 120px; padding-right: 1rem;">preferencial</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($accounts as $key => $account): ?>
                  <div style="overflow-wrap: break-word"
                    class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 1150px; max-width: 100%;">
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
                    <div class="column" style="min-width: 120px; padding-right: 1rem;">
                      <?php echo $account->priority == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column align-right" style="min-width: 200px; padding-right: 1rem;">
                      <a href="" class="btn-blue btn-edit-account">editar</a>
                      <a href="" class="btn-red btn-remove-account">remover</a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <?php require_once('logs/system-information.php'); ?>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-employee-edit">salvar</button>
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
        <?php echo get_input('hidden', 'link', 'funcionário', FALSE, $this->uri->segment(2)); ?>
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
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'agency', 'agência'); ?>
            <?php echo get_input('text', 'agencydv', 'dv agência'); ?>
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
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'agency', 'agência'); ?>
            <?php echo get_input('text', 'agencydv', 'dv agência'); ?>
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
          <div class="column-50">
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
<script type="text/javascript">
  <?php $email_suffix = array(); ?>
  <?php foreach ($subsidiaries as $key => $value): ?>
    <?php if ($value->emailsuffix): ?>
      <?php array_push($email_suffix, $value->emailsuffix); ?>
    <?php endif; ?>
  <?php endforeach; ?>
  const emailSuffix = <?php echo json_encode($email_suffix); ?>
</script>
