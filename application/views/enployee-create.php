<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-employees">
        <div class="title"><i class="ph ph-identification-card"></i> Funcionário</div>
        <?php echo form_open('employee', array('id' => 'employee-create')); ?>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-employee-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($salutations, 'salutation', 'tratamento'); ?>
            <?php echo get_input('text', 'name', 'nome'); ?>
            <?php echo get_input('text', 'initials', 'iniciais'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($titles, 'title', 'cargo'); ?>
            <?php echo get_select($supervisor, 'supervisor', 'supervisor'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações'); ?>
          </div>
        </div>
        <div class="group-title">informações pessoais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'email', 'email'); ?>
            <?php echo get_input('text', 'document', 'cpf'); ?>
            <?php echo get_input('text', 'dateofbirth', 'data de nascimento'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'phone', 'telefone'); ?>
            <?php echo get_input('text', 'mobilephone', 'celular'); ?>
            <?php echo get_input('text', 'dateofhire', 'data de contratação'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('defaultaddress', 6, 'endereço padrão', FALSE, TRUE); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiária'); ?>
            <?php echo get_select($immediateapprover, 'immediateapprover', 'aprovador imediato'); ?>
            <?php echo get_select($topapprover, 'topapprover', 'aprovador superior'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'emailprefix', 'prefixo do email'); ?>
            <div class="email-list">
            </div>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('commercialspecialist', 'especialista comercial'); ?>
            <?php echo get_checkbox('salesrepresentative', 'representante de vendas'); ?>
            <?php echo get_checkbox('supportrepresentative', 'representante de suporte'); ?>
            <?php echo get_checkbox('eligibleforcommission', 'aprovado para comissão'); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="address">endereço</label> |
          <label class="tab-btn" data-toggle="access">acesso</label> |
          <label class="tab-btn" data-toggle="account">contas</label>
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
              </div>
            </div>
          </div>
          <div id="account" class="tab-wrapper-content" style="display: none">
            <div class="tab-wrapper-buttons">
              <a href="" class="add-account">add conta</a>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1200px; max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">numero da conta</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">agencia</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">banco</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">pix</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">preferencial</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
                </div>
              </div>
            </div>
          </div>
          <div id="access" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('giveaccess', 'fornecer acesso'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('sendemail', 'enviar email de notificação de acesso'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('isinactive', 'inativo'); ?>
              </div>
            </div>
            <div class="tab-wrapper-buttons">
              <div class="column">
                <div class="column-33 c-large c-medium c-small">
                  <?php echo get_select($roles, 'roles', 'funções'); ?>
                </div>
              </div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 500px; max-width: 100%;">
                  <div class="column" style="min-width: 250px; max-width: 100%;">função</div>
                  <div class="column" style="min-width: 250px; max-width: 100%;"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-employee-create">criar</button>
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
        <?php echo get_input('hidden', 'bankcode', 'código	do	banco', FALSE, '') ?>
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
<script type="text/javascript">
  <?php $email_suffix = array(); ?>
  <?php foreach ($subsidiaries as $key => $value): ?>
    <?php if ($value->emailsuffix): ?>
      <?php array_push($email_suffix, $value->emailsuffix); ?>
    <?php endif; ?>
  <?php endforeach; ?>
  const emailSuffix = <?php echo json_encode($email_suffix); ?>
</script>
