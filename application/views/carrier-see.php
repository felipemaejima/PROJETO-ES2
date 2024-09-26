<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-carriers">
        <div class="title"><i class="ph ph-truck"></i> Transportadora</div>
        <div class="functions-tab tab-row">
          <a href="<?php echo base_url('carrier/' . $this->uri->segment(2) . '?edit=T'); ?>"
            class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $this->uri->segment(2)); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($isperson, 'isperson', 'tipo', FALSE, $carrier[0]->isperson, TRUE); ?>
            <?php echo get_input('text', 'document', 'cnpj', FALSE, $carrier[0]->document, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'name', 'nome', FALSE, $carrier[0]->name, TRUE); ?>
            <?php echo get_input('text', 'legalname', 'razão social', FALSE, $carrier[0]->legalname, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $carrier[0]->comments, TRUE); ?>
          </div>
        </div>
        <div class="group-title">informações fiscais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'im', 'inscrição municipal', FALSE, $carrier[0]->im, TRUE); ?>
            <?php echo get_input('text', 'ie', 'inscrição estadual', FALSE, $carrier[0]->ie, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'cnae', 'cnae', FALSE, $carrier[0]->cnae, TRUE); ?>
            <?php echo get_input('text', 'cnaedescription', 'descrição do cnae', FALSE, $carrier[0]->cnaedescription, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($activitysectors, 'activitysector', 'setor de atividade', FALSE, $carrier[0]->activitysector, TRUE); ?>
            <?php echo get_select($freighttypes, 'freighttype', 'tipo de frete', FALSE, $carrier[0]->freighttype, TRUE); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('ieexempt', 'IE isento', TRUE, $carrier[0]->ieexempt); ?>
            <?php echo get_checkbox('ieimmune', 'IE imune', TRUE, $carrier[0]->ieimmune); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('icmstaxpayer', 'contribuinte de ICMS', TRUE, $carrier[0]->icmstaxpayer); ?>
            <?php echo get_checkbox('simplesnacional', 'simples nacional', TRUE, $carrier[0]->simplesnacional); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('mei', 'empreendedor individual', TRUE, $carrier[0]->mei); ?>
            <?php echo get_checkbox('publicentityexempticms', 'orgão público isento de ICMS', TRUE, $carrier[0]->publicentityexempticms); ?>
          </div>
        </div>
        <div class="group-title">informações secundárias</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'phone', 'telefone', FALSE, $carrier[0]->phone, TRUE); ?>
            <?php echo get_input('text', 'email', 'email', FALSE, $carrier[0]->email, TRUE); ?>
            <?php echo get_input('text', 'url', 'site', FALSE, $carrier[0]->url, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'founded', 'fundação', FALSE, $carrier[0]->founded ? date('d/m/Y', $carrier[0]->founded) : FALSE, TRUE); ?>
            <?php echo get_input('text', 'entitystatusdate', 'data do status da empresa', FALSE, $carrier[0]->entitystatusdate ? date('d/m/Y', $carrier[0]->entitystatusdate) : FALSE, TRUE); ?>
            <?php echo get_input('text', 'entitystatus', 'status da empresa', FALSE, $carrier[0]->entitystatus, TRUE); ?>
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
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 500px; max-width: 100%;">
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">expedição padrão</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">faturamento padrão</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">endereço</div>
                  <div class="column" style="min-width: 0px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($addresses as $key => $address): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 500px; max-width: 100%;">
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
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="relationship" class="tab-wrapper-content" style="display: none">
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1200px; max-width: 100%;">
                  <div class="column" style="min-width: 300px; padding-right: 1rem;">nome</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">cargo</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">telefone</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">email</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">enviar NF</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">enviar boleto</div>
                  <div class="column" style="min-width: 0px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($relationships as $key => $relationship): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 1200px; max-width: 100%;">
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
                    <div class="column align-right" style="min-width: 0px; padding-right: 1rem;">
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="licensecontrol" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'federalpolicelicense', 'licença de polícia federal', FALSE, $carrier[0]->federalpolicelicense, TRUE); ?>
                <?php echo get_input('text', 'datefederalpolicelicense', 'data expiração da licença da política federal', FALSE, $carrier[0]->datefederalpolicelicense ? date('d/m/Y', $carrier[0]->datefederalpolicelicense) : FALSE, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'civilpolicelicense', 'licença de polícia civil', FALSE, $carrier[0]->civilpolicelicense, TRUE); ?>
                <?php echo get_input('text', 'datecivilpolicelicense', 'data expiração da licença da política civil', FALSE, $carrier[0]->datecivilpolicelicense ? date('d/m/Y', $carrier[0]->datecivilpolicelicense) : FALSE, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'armylicense', 'licença do exército', FALSE, $carrier[0]->armylicense, TRUE); ?>
                <?php echo get_input('text', 'datearmylicense', 'data expiração da licença do exército', FALSE, $carrier[0]->datearmylicense ? date('d/m/Y', $carrier[0]->datearmylicense) : FALSE, TRUE); ?>
              </div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1800px; max-width: 100%">
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
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 1800px; max-width: 100%x">
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
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
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
                <?php echo get_checkbox('iscustomer', 'cliente', TRUE, $carrier[0]->iscustomer); ?>
                <?php echo get_checkbox('issupplier', 'fornecedor', TRUE, $carrier[0]->issupplier); ?>
                <?php echo get_checkbox('iscarrier', 'transportadora', TRUE, $carrier[0]->iscarrier); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="column">
              <div class="column-100">
                <?php require_once ('logs/system-information.php'); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <a href="<?php echo base_url('carrier/' . $this->uri->segment(2) . '?edit=T'); ?>"
            class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
      </div>
    </div>
  </div>
</div>