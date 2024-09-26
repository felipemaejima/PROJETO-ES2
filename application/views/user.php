<div class="container">
  <div class="box box-user">
    <div class="box-content">
      <div class="box-infos">
        <div class="title"><i class="ph ph-user"></i>Minha conta</div>
        <?php echo form_open('me', array('id' => 'me')); ?>

        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-me">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $user->id); ?>
        <div class="group-title">informações pessoais</div>

        <div class="column">

          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'name', 'nome', FALSE, $userData->name); ?>
            <?php echo get_input('text', 'dateofbirth', 'data de nascimento', FALSE, $userData->dateofbirth ? date('d/m/Y', $userData->dateofbirth) : ''); ?>
            <?php echo get_input('text', 'mobilephone', 'celular', FALSE, $userData->mobilephone); ?>
          </div>

          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'email', 'email', FALSE, $userData->email); ?>
            <?php echo get_input('text', 'document', 'cpf', FALSE, $userData->document); ?>
            <?php echo get_input('text', 'phone', 'telefone', FALSE, $userData->phone); ?>
          </div>

          <div class="column-33 c-large c-medium c-small data-bottom">
            <?php echo get_textarea('defaultaddress', 6, 'endereço padrão', $userData->defaultaddress, TRUE); ?>
            <br>
            <br>
            <?php echo get_checkbox('defaulttheme', 'tema escuro padrão', FALSE, $userData->defaulttheme == 'dark' ? TRUE : FALSE); ?>
          </div>
          <div class="column-33">
          </div>
          <div class="column-33">
          </div>

        </div>

        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>

        <br>

        <div class="tab-container">
          <label class="tab-btn active" data-toggle="address">endereço</label> |
          <label class="tab-btn " data-toggle="access-logs">informações do sistema</label>
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

          <div id="access-logs" class="tab-wrapper-content" style="display: none">
            <?php require_once('logs/system-information.php'); ?>
          </div>

        </div>
        <br>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-me">salvar</button>
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