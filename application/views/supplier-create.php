<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-suppliers">
        <div class="title"><i class="ph ph-user-circle-plus"></i> Fornecedor</div>
        <?php echo form_open('supplier', array('id' => 'supplier-create')); ?>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-supplier-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($isperson, 'isperson', 'tipo', FALSE, '0818c95f-fbc6-de7b-9f5c-6cead82742ee'); ?>
            <?php echo get_input('text', 'document', 'cnpj'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'name', 'nome'); ?>
            <?php echo get_input('text', 'legalname', 'razão social'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações'); ?>
          </div>
        </div>
        <div class="group-title">informações fiscais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'im', 'inscrição municipal'); ?>
            <?php echo get_input('text', 'ie', 'inscrição estadual'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'cnae', 'cnae'); ?>
            <?php echo get_input('text', 'cnaedescription', 'descrição do cnae'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($activitysectors, 'activitysector', 'setor de atividade'); ?>
            <?php echo get_select($freighttypes, 'freighttype', 'tipo de frete', FALSE, 'a1df3875-ce20-f00d-545b-4022a0f30614'); ?>
            <?php echo get_input('text', 'carrier', 'transportadora padrão'); ?>
            <?php echo get_input('hidden', 'carrierid', 'carrier id'); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('ieexempt', 'IE isento'); ?>
            <?php echo get_checkbox('ieimmune', 'IE imune'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('icmstaxpayer', 'contribuinte de ICMS'); ?>
            <?php echo get_checkbox('simplesnacional', 'simples nacional'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('mei', 'empreendedor individual'); ?>
            <?php echo get_checkbox('publicentityexempticms', 'orgão público isento de ICMS'); ?>
          </div>
        </div>
        <div class="group-title">informações secundárias</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'phone', 'telefone'); ?>
            <?php echo get_input('text', 'email', 'email'); ?>
            <?php echo get_input('text', 'url', 'site'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'founded', 'fundação'); ?>
            <?php echo get_input('text', 'entitystatusdate', 'data do status da empresa'); ?>
            <?php echo get_input('text', 'entitystatus', 'status da empresa'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('defaultaddress', 6, 'endereço padrão', FALSE, TRUE); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="address">endereço</label> |
          <label class="tab-btn" data-toggle="relationship">relacionamentos</label> |
          <label class="tab-btn" data-toggle="licensecontrol">controle de licenças</label> |
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
          <div id="relationship" class="tab-wrapper-content" style="display: none">
            <div class="tab-wrapper-buttons">
              <a href="" class="add-relationship">add relacionamento</a>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1450px; max-width: 100%">
                  <div class="column" style="min-width: 300px; padding-right: 1rem;">nome</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">cargo</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">telefone</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">email</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">enviar NF</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">enviar boleto</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
                </div>
              </div>
            </div>
          </div>
          <div id="licensecontrol" class="tab-wrapper-content" style="display: none">
            <div class="tab-wrapper-buttons">
              <a href="" class="add-licensecontrol">add licença</a>
            </div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'checklicense', 'verificar licenças da polícia federal', '<i class="ph ph-arrows-clockwise check-federal-license"></i>', FALSE, TRUE); ?>
              </div>
              <div class="column-33"></div>
              <div class="column-33"></div>
            </div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'federalpolicelicense', 'licença de polícia federal'); ?>
                <?php echo get_input('text', 'datefederalpolicelicense', 'data expiração da licença da política federal'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'civilpolicelicense', 'licença de polícia civil'); ?>
                <?php echo get_input('text', 'datecivilpolicelicense', 'data expiração da licença da política civil'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'armylicense', 'licença do exército'); ?>
                <?php echo get_input('text', 'datearmylicense', 'data expiração da licença do exército'); ?>
              </div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1800px; max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">ncm</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">descrição</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">polícia civil</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">polícia federal</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">permissões fed</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">exército</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">permissões ex</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">qtd exército</div>
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
          <button type="submit" class="btn-purple" id="submit-supplier-create">criar</button>
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
<div id="modal-add-relationship" class="modal">
  <div class="modal-large">
    <div class="modal-header">
      <div class="close">
        <i class="ph ph-x"></i>
      </div>
    </div>
    <div class="modal-content">
      <div class="box-infos">
        <?php echo form_open('add-relationship', array('id' => 'add-relationship')); ?>
        <div class="form-input-content">
          <div class="success-message"></div>
        </div>
        <div class="column">
          <div class="column-50 c-large">
            <?php echo get_input('text', 'name', 'nome'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'email', 'email'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-50 c-large">
            <?php echo get_input('text', 'phone', 'telefone'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_input('text', 'title', 'cargo'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-50 c-large">
            <?php echo get_checkbox('sendinvoice', 'enviar nota fiscal'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_checkbox('sendbilling', 'enviar boleto'); ?>
          </div>
        </div>
        <button type="submit" class="btn-blue" id="submit-add-relationship">inserir</button>
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
<div id="modal-add-licensecontrol" class="modal">
  <div class="modal-large">
    <div class="modal-header">
      <div class="close">
        <i class="ph ph-x"></i>
      </div>
    </div>
    <div class="modal-content">
      <div class="box-infos">
        <?php echo form_open('add-licensecontrol', array('id' => 'add-licensecontrol')); ?>
        <div class="form-input-content">
          <div class="success-message"></div>
        </div>
        <div class="column">
          <div class="column-100">
            <?php echo get_input('text', 'ncm', 'ncm'); ?>
            <?php echo get_input('hidden', 'id', 'id'); ?>
            <?php echo get_input('hidden', 'description', 'descrição'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('iscontrolledcivilpolice', 'polícia civil'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('iscontrolledfederalpolice', 'polícia federal'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('iscontrolledarmy', 'exército'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-100">
            <div class="form-input-content">
              <label for="">permissões da polícia federal</label>
              <div class="btn-checkbox">
                <?php foreach ($licenseactivitiesfederalpolice as $key => $value): ?>
                  <?php echo get_checkbox_button('licenseactivitiesfederalpolice[]', $value); ?>
                <?php endforeach; ?>
                <div class="error-licenseactivitiesfederalpolice error-input"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="column-100">
            <div class="form-input-content">
              <label for="">permissões do exército</label>
              <div class="btn-checkbox">
                <?php foreach ($licenseactivitiesarmy as $key => $value): ?>
                  <?php echo get_checkbox_button('licenseactivitiesarmy[]', $value); ?>
                <?php endforeach; ?>
                <div class="error-licenseactivitiesarmy error-input"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="column-100">
            <?php echo get_input('text', 'allowedquantityarmy', 'quantidade permitida pelo exército'); ?>
          </div>
        </div>
        <button type="submit" class="btn-blue" id="submit-add-licensecontrol">inserir</button>
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