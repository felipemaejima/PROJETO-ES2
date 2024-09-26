<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-subsidiaries">
        <div class="title"><i class="ph ph-buildings"></i> Subsidiária</div>
        <?php echo form_open('subsidiary', array('id' => 'subsidiary-create')); ?>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-subsidiary-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'title', 'nome'); ?>
            <?php echo get_input('text', 'phone', 'telefone'); ?>
            <?php echo get_input('text', 'url', 'site', FALSE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'email', 'email', FALSE); ?>
            <?php echo get_input('text', 'emailsuffix', 'sufixo do email'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_file('logo', 'logotipo da subsidiária', '.jpg, .jpeg, .png'); ?>
            <div class="form-input-content">
              <div class="thumb">
              </div>
            </div>
          </div>
        </div>
        <div class="group-title">informações empresariais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'cnpj', 'cnpj'); ?>
            <?php echo get_input('text', 'legalname', 'razão social'); ?>
            <?php echo get_input('text', 'ie', 'IE'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'utilizationrate', 'alíquota de aproveitamento'); ?>
            <?php echo get_select($taxregimes, 'taxregime', 'regime de tributação'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('isinactive', 'inativo'); ?>
          </div>
        </div>

        <div class="tab-container">
          <label class="tab-btn active" data-toggle="address">endereço</label> |
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
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-subsidiary-create">criar</button>
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