<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-employees">
        <div class="title"><i class="ph ph-identification-card"></i> Funcionário</div>
        <div class="functions-tab tab-row">
          <a href="<?php echo base_url('employee/' . $this->uri->segment(2) . '?edit=T'); ?>"
            class="btn-purple">editar</a>
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
        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($salutations, 'salutation', 'tratamento', FALSE, $employee[0]->salutation, TRUE); ?>
            <?php echo get_input('text', 'name', 'nome', FALSE, $employee[0]->name, TRUE); ?>
            <?php echo get_input('text', 'initials', 'iniciais', FALSE, $employee[0]->initials, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($titles, 'title', 'cargo', FALSE, $employee[0]->title, TRUE); ?>
            <?php echo get_select($supervisor, 'supervisor', 'supervisor', FALSE, $employee[0]->supervisor, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $employee[0]->comments, TRUE); ?>
          </div>
        </div>
        <div class="group-title">informações pessoais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'email', 'email', FALSE, $employee[0]->email, TRUE); ?>
            <?php echo get_input('text', 'document', 'documento', FALSE, $employee[0]->document, TRUE); ?>
            <?php echo get_input('text', 'dateofbirth', 'data de nascimento', FALSE, date('d/m/Y', $employee[0]->dateofbirth), TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'phone', 'telefone', FALSE, $employee[0]->phone, TRUE); ?>
            <?php echo get_input('text', 'mobilephone', 'celular', FALSE, $employee[0]->mobilephone, TRUE); ?>
            <?php echo get_input('text', 'dateofhire', 'data de contratação', FALSE, $employee[0]->dateofhire ? date('d/m/Y', $employee[0]->dateofhire) : FALSE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('defaultaddress', 6, 'endereço padrão', $employee[0]->defaultaddress, TRUE); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiária', FALSE, $employee[0]->subsidiary, TRUE); ?>
            <?php echo get_select($immediateapprover, 'immediateapprover', 'aprovador imediato', FALSE, $employee[0]->immediateapprover, TRUE); ?>
            <?php echo get_select($topapprover, 'topapprover', 'aprovador superior', FALSE, $employee[0]->topapprover, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'emailprefix', 'prefixo do email', FALSE, $employee[0]->emailprefix, TRUE); ?>
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
            <?php echo get_checkbox('commercialspecialist', 'especialista comercial', TRUE, $employee[0]->commercialspecialist); ?>
            <?php echo get_checkbox('salesrepresentative', 'representante de vendas', TRUE, $employee[0]->salesrepresentative); ?>
            <?php echo get_checkbox('supportrepresentative', 'representante de suporte', TRUE, $employee[0]->supportrepresentative); ?>
            <?php echo get_checkbox('eligibleforcommission', 'aprovado para comissão', TRUE, $employee[0]->eligibleforcommission); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="address">endereço</label> |
          <label class="tab-btn" data-toggle="access">acesso</label> |
          <label class="tab-btn" data-toggle="accounts">contas</label> |
          <label class="tab-btn" data-toggle="systeminformation">informações do sistema</label>
        </div>
        <div class="tab-wrapper">
          <div id="address" class="tab-wrapper-content" style="display: flex">
            <div class="tab-wrapper-buttons">
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 550px; max-width: 100%;">
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">expedição padrão</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">faturamento padrão</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">endereço</div>
                  <div class="column" style="min-width: 0px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($addresses as $key => $address): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 550px; max-width: 100%">
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
          <div id="access" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('giveaccess', 'fornecer acesso', TRUE, $employee[0]->giveaccess); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('sendemail', 'enviar email de notificação de acesso', TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('isinactive', 'inativo', TRUE, $employee[0]->isinactive); ?>
              </div>
            </div>
            <div class="tab-wrapper-buttons">
              <div class="column">
                <div class="column-33 c-large c-medium c-small">
                  <?php echo get_select($roles, 'roles', 'funções', FALSE, FALSE, TRUE); ?>
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
              <?php if (!is_null($employee[0]->roles)): ?>
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
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
          <div id="accounts" class="tab-wrapper-content" style="display: none">
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 910px; max-width: 100%">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">numero da conta</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">agencia</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">banco</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">pix</div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">preferencial</div>
                  <div class="column" style="min-width: 0px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($accounts as $key => $account): ?>
                  <div style="overflow-wrap: break-word"
                    class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 910px; max-width: 100%">
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
                    <div class="column" style="min-width: 100px; padding-right: 1rem;">
                      <?php echo $account->priority == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column align-right" style="min-width: 0px; padding-right: 1rem;">
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
          <a href="<?php echo base_url('employee/' . $this->uri->segment(2) . '?edit=T'); ?>"
            class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
      </div>
    </div>
  </div>
</div>
