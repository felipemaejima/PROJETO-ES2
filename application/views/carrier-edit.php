<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-carriers">
        <div class="title"><i class="ph ph-truck"></i> Transportadora</div>
        <?php echo form_open('carrier/' . $this->uri->segment(2), array('id' => 'carrier-edit')); ?>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-carrier-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $this->uri->segment(2)); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($isperson, 'isperson', 'tipo', FALSE, $carrier[0]->isperson); ?>
            <?php echo get_input('text', 'document', 'cnpj', FALSE, $carrier[0]->document); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'name', 'nome', FALSE, $carrier[0]->name); ?>
            <?php echo get_input('text', 'legalname', 'razão social', FALSE, $carrier[0]->legalname); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $carrier[0]->comments); ?>
          </div>
        </div>
        <div class="group-title">informações fiscais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'im', 'inscrição municipal', FALSE, $carrier[0]->im); ?>
            <?php echo get_input('text', 'ie', 'inscrição estadual', FALSE, $carrier[0]->ie, $customer[0]->isperson == 'b48e880d-c9a6-df7e-d749-54b30c93c12f' ? TRUE : FALSE ); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'cnae', 'cnae', FALSE, $carrier[0]->cnae); ?>
            <?php echo get_input('text', 'cnaedescription', 'descrição do cnae', FALSE, $carrier[0]->cnaedescription); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($activitysectors, 'activitysector', 'setor de atividade', FALSE, $carrier[0]->activitysector); ?>
            <?php echo get_select($freighttypes, 'freighttype', 'tipo de frete', FALSE, $carrier[0]->freighttype); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('ieexempt', 'IE isento', FALSE, $carrier[0]->ieexempt); ?>
            <?php echo get_checkbox('ieimmune', 'IE imune', FALSE, $carrier[0]->ieimmune); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('icmstaxpayer', 'contribuinte de ICMS', FALSE, $carrier[0]->icmstaxpayer); ?>
            <?php echo get_checkbox('simplesnacional', 'simples nacional', FALSE, $carrier[0]->simplesnacional); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('mei', 'empreendedor individual', FALSE, $carrier[0]->mei); ?>
            <?php echo get_checkbox('publicentityexempticms', 'orgão público isento de ICMS', FALSE, $carrier[0]->publicentityexempticms); ?>
          </div>
        </div>
        <div class="group-title">informações secundárias</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'phone', 'telefone', FALSE, $carrier[0]->phone); ?>
            <?php echo get_input('text', 'email', 'email', FALSE, $carrier[0]->email); ?>
            <?php echo get_input('text', 'url', 'site', FALSE, $carrier[0]->url); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'founded', 'fundação', FALSE, $carrier[0]->founded ? date('d/m/Y', $carrier[0]->founded) : FALSE); ?>
            <?php echo get_input('text', 'entitystatusdate', 'data do status da empresa', FALSE, $carrier[0]->entitystatusdate ? date('d/m/Y', $carrier[0]->entitystatusdate) : FALSE); ?>
            <?php echo get_input('text', 'entitystatus', 'status da empresa', FALSE, $carrier[0]->entitystatus); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('defaultaddress', 6, 'endereço padrão', $carrier[0]->defaultaddress, TRUE); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="address">endereço</label> |
          <label class="tab-btn" data-toggle="relationship">relacionamentos</label> |
          <label class="tab-btn" data-toggle="licensecontrol">controle de licenças</label> |
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
          <div id="relationship" class="tab-wrapper-content" style="display: none">
            <div class="tab-wrapper-buttons">
              <a href="" class="add-relationship">add relacionamento</a>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1450px; max-width: 100%;">
                  <div class="column" style="min-width: 300px; padding-right: 1rem;">nome</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">cargo</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">telefone</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">email</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">enviar NF</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">enviar boleto</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($relationships as $key => $relationship): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 1450px; max-width: 100%;">
                    <div class="column" style="min-width: 300px; padding-right: 1rem;">
                      <?php echo $relationship->name; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $relationship->title; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $relationship->phone; ?>
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;">
                      <?php echo $relationship->email; ?>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;">
                      <?php echo $relationship->sendinvoice == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;">
                      <?php echo $relationship->sendbilling == 'T' ? 'Sim' : 'Não'; ?>
                      <input type="hidden" name="relationshipid[]" value="<?php echo $relationship->id; ?>">
                      <input type="hidden" name="relationshipname[]" value="<?php echo $relationship->name; ?>">
                      <input type="hidden" name="relationshiptitle[]" value="<?php echo $relationship->title; ?>">
                      <input type="hidden" name="relationshipphone[]" value="<?php echo $relationship->phone; ?>">
                      <input type="hidden" name="relationshipemail[]" value="<?php echo $relationship->email; ?>">
                      <input type="hidden" name="relationshipsendinvoice[]"
                        value="<?php echo $relationship->sendinvoice; ?>">
                      <input type="hidden" name="relationshipsendbilling[]"
                        value="<?php echo $relationship->sendbilling; ?>">
                    </div>
                    <div class="column align-right" style="min-width: 200px; padding-right: 1rem;">
                      <a href="" class="btn-blue btn-edit-relationship">editar</a>
                      <a href="" class="btn-red btn-remove-relationship">remover</a>
                    </div>
                  </div>
                <?php endforeach; ?>
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
                <?php echo get_input('text', 'federalpolicelicense', 'licença de polícia federal', FALSE, $carrier[0]->federalpolicelicense); ?>
                <?php echo get_input('text', 'datefederalpolicelicense', 'data expiração da licença da política federal', FALSE, $carrier[0]->datefederalpolicelicense ? date('d/m/Y', $carrier[0]->datefederalpolicelicense) : FALSE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'civilpolicelicense', 'licença de polícia civil', FALSE, $carrier[0]->civilpolicelicense); ?>
                <?php echo get_input('text', 'datecivilpolicelicense', 'data expiração da licença da política civil', FALSE, $carrier[0]->datecivilpolicelicense ? date('d/m/Y', $carrier[0]->datecivilpolicelicense) : FALSE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'armylicense', 'licença do exército', FALSE, $carrier[0]->armylicense); ?>
                <?php echo get_input('text', 'datearmylicense', 'data expiração da licença do exército', FALSE, $carrier[0]->datearmylicense ? date('d/m/Y', $carrier[0]->datearmylicense) : FALSE); ?>
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
                <?php foreach ($licenses as $key => $license): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 1800px; max-width: 100%">
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $license->ncm; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $license->description; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $license->iscontrolledcivilpolice == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $license->iscontrolledfederalpolice == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php if ($license->permissionsfederalpolice): ?>
                        <?php $permissionsfederalpolice = json_decode($license->permissionsfederalpolice); ?>
                        <?php foreach ($permissionsfederalpolice as $row): ?>
                          <?php echo $licenseactivitiesfederalpolice[get_position_array($row, $licenseactivitiesfederalpolice)]->title . ', '; ?>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $license->iscontrolledarmy == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php if ($license->permissionsarmy): ?>
                        <?php $permissionsarmy = json_decode($license->permissionsarmy); ?>
                        <?php foreach ($permissionsarmy as $row): ?>
                          <?php echo $licenseactivitiesarmy[get_position_array($row, $licenseactivitiesarmy)]->title . ', '; ?>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </div>
                    <div class="column" style="width: 200px; padding-right: 1rem;">
                      <?php echo $license->allowedquantityarmy; ?>
                      <input type="hidden" name="licensecontrolid[]" value="<?php echo $license->id; ?>">
                      <input type="hidden" name="licensecontrolncmreferer[]" value="<?php echo $license->ncmreferer; ?>">
                      <input type="hidden" name="licensecontrolncm[]" value="<?php echo $license->ncm; ?>">
                      <input type="hidden" name="licensecontroldescription[]"
                        value="<?php echo $license->description; ?>">
                      <input type="hidden" name="licensecontroliscontrolledcivilpolice[]"
                        value="<?php echo $license->iscontrolledcivilpolice; ?>">
                      <input type="hidden" name="licensecontroliscontrolledfederalpolice[]"
                        value="<?php echo $license->iscontrolledfederalpolice; ?>">
                      <input type="hidden" name="licensecontroliscontrolledarmy[]"
                        value="<?php echo $license->iscontrolledarmy; ?>">
                      <input type="hidden" name="licensecontrolallowedquantityarmy[]"
                        value="<?php echo $license->allowedquantityarmy; ?>">
                      <input type="hidden" name="licensecontrolpermissionsfederalpolice[]"
                        value="<?php echo $license->permissionsfederalpolice ? implode(', ', json_decode($license->permissionsfederalpolice)) : ''; ?>">
                      <input type="hidden" name="licensecontrolpermissionsarmy[]"
                        value="<?php echo $license->permissionsarmy ? implode(', ', json_decode($license->permissionsarmy)) : ''; ?>">
                    </div>
                    <div class="column align-right" style="min-width: 200px; padding-right: 1rem;">
                      <a href="" class="btn-blue btn-edit-licensecontrol">editar</a>
                      <a href="" class="btn-red btn-remove-licensecontrol">remover</a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('isinactive', 'inativo', TRUE, $carrier[0]->isinactive); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('iscustomer', 'cliente', FALSE, $carrier[0]->iscustomer); ?>
                <?php echo get_checkbox('issupplier', 'fornecedor', FALSE, $carrier[0]->issupplier); ?>
                <?php echo get_checkbox('iscarrier', 'transportadora', FALSE, $carrier[0]->iscarrier); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="column">
              <div class="column-100">
                <?php require_once('logs/system-information.php'); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-carrier-edit">salvar</button>
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
        <?php echo get_input('hidden', 'link', 'cliente', FALSE, $this->uri->segment(2)); ?>
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
        <?php echo get_input('hidden', 'link', 'cliente', FALSE, $this->uri->segment(2)); ?>
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
            <?php echo get_checkbox('sendinvoicecreate', 'enviar nota fiscal'); ?>
          </div>
          <div class="column-50 c-large">
            <?php echo get_checkbox('sendbillingcreate', 'enviar boleto'); ?>
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
<div id="modal-edit-relationship" class="modal">
  <div class="modal-large">
    <div class="modal-header">
      <div class="close">
        <i class="ph ph-x"></i>
      </div>
    </div>
    <div class="modal-content">
      <div class="box-infos">
        <?php echo form_open('edit-relationship', array('id' => 'edit-relationship')); ?>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, ''); ?>
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
        <button type="submit" class="btn-blue" id="submit-edit-relationship">inserir</button>
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
        <?php echo get_input('hidden', 'link', 'cliente', FALSE, $this->uri->segment(2)); ?>
        <div class="form-input-content">
          <div class="success-message"></div>
        </div>
        <div class="column">
          <div class="column-100">
            <?php echo get_input('hidden', 'ncmreferer', 'ncmreferer'); ?>
            <?php echo get_input('text', 'ncm', 'ncm'); ?>
            <?php echo get_input('hidden', 'id', 'id'); ?>
            <?php echo get_input('hidden', 'description', 'descrição'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-33 c-large">
            <?php echo get_checkbox('iscontrolledcivilpolicecreate', 'polícia civil'); ?>
          </div>
          <div class="column-33 c-large">
            <?php echo get_checkbox('iscontrolledfederalpolicecreate', 'polícia federal'); ?>
          </div>
          <div class="column-33 c-large">
            <?php echo get_checkbox('iscontrolledarmycreate', 'exército'); ?>
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
<div id="modal-edit-licensecontrol" class="modal">
  <div class="modal-large">
    <div class="modal-header">
      <div class="close">
        <i class="ph ph-x"></i>
      </div>
    </div>
    <div class="modal-content">
      <div class="box-infos">
        <?php echo form_open('edit-licensecontrol', array('id' => 'edit-licensecontrol')); ?>
        <?php echo get_input('hidden', 'link', 'cliente', FALSE, $this->uri->segment(2)); ?>
        <div class="form-input-content">
          <div class="success-message"></div>
        </div>
        <div class="column">
          <div class="column-100">
            <?php echo get_input('hidden', 'ncmreferer', 'ncmreferer'); ?>
            <?php echo get_input('text', 'ncm', 'ncm'); ?>
            <?php echo get_input('hidden', 'id', 'id'); ?>
            <?php echo get_input('hidden', 'description', 'descrição'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-33 c-large">
            <?php echo get_checkbox('iscontrolledcivilpolice', 'polícia civil'); ?>
          </div>
          <div class="column-33 c-large">
            <?php echo get_checkbox('iscontrolledfederalpolice', 'polícia federal'); ?>
          </div>
          <div class="column-33 c-large">
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