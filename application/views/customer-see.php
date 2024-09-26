<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-customers">
        <div class="title"><i class="ph ph-user-circle-plus"></i> Cliente</div>
        <div class="functions-tab tab-row">
          <a href="<?php echo base_url('customer/' . $this->uri->segment(2) . '?edit=T'); ?>"
            class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $this->uri->segment(2)); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($isperson, 'isperson', 'tipo', FALSE, $customer[0]->isperson, TRUE); ?>
            <?php echo get_input('text', 'document', 'cnpj', FALSE, $customer[0]->document, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'name', 'nome', FALSE, $customer[0]->name, TRUE); ?>
            <?php echo get_input('text', 'legalname', 'razão social', FALSE, $customer[0]->legalname, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $customer[0]->comments, TRUE); ?>
          </div>
        </div>
        <div class="group-title">informações comerciais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($preferredvoltages, 'preferredvoltage', 'voltagem preferencial', FALSE, $customer[0]->preferredvoltage, TRUE); ?>
            <?php echo get_select($salesreps, 'salesrep', 'represantante de vendas', FALSE, $customer[0]->salesrep, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'factor', 'fator', FAlSE, $customer[0]->factor, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($groups, 'group', 'grupo', FALSE, $customer[0]->group, TRUE); ?>
            <?php echo get_select($subgroups, 'subgroup', 'sub grupo', FALSE, $customer[0]->subgroup, TRUE); ?>
          </div>
        </div>
        <div class="group-title">informações fiscais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'im', 'inscrição municipal', FALSE, $customer[0]->im, TRUE); ?>
            <?php echo get_input('text', 'ie', 'inscrição estadual', FALSE, $customer[0]->ie, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'cnae', 'cnae', FALSE, $customer[0]->cnae, TRUE); ?>
            <?php echo get_input('text', 'cnaedescription', 'descrição do cnae', FALSE, $customer[0]->cnaedescription, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($activitysectors, 'activitysector', 'setor de atividade', FALSE, $customer[0]->activitysector, TRUE); ?>
            <?php echo get_select($freighttypes, 'freighttype', 'tipo de frete', FALSE, $customer[0]->freighttype, TRUE); ?>
            <?php echo get_input('text', 'carrier', 'transportadora padrão', FALSE, $customer[0]->carriername, TRUE); ?>
            <?php echo get_input('hidden', 'carrierid', 'carrier id', FALSE, $customer[0]->carrierid, TRUE); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('ieexempt', 'IE isento', TRUE, $customer[0]->ieexempt); ?>
            <?php echo get_checkbox('ieimmune', 'IE imune', TRUE, $customer[0]->ieimmune); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('icmstaxpayer', 'contribuinte de ICMS', TRUE, $customer[0]->icmstaxpayer); ?>
            <?php echo get_checkbox('simplesnacional', 'simples nacional', TRUE, $customer[0]->simplesnacional); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('mei', 'empreendedor individual', TRUE, $customer[0]->mei); ?>
            <?php echo get_checkbox('publicentityexempticms', 'orgão público isento de ICMS', TRUE, $customer[0]->publicentityexempticms); ?>
          </div>
        </div>
        <div class="group-title">informações secundárias</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'phone', 'telefone', FALSE, $customer[0]->phone, TRUE); ?>
            <?php echo get_input('text', 'email', 'email', FALSE, $customer[0]->email, TRUE); ?>
            <?php echo get_input('text', 'url', 'site', FALSE, $customer[0]->url, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'founded', 'fundação', FALSE, $customer[0]->founded ? date('d/m/Y', $customer[0]->founded) : FALSE, TRUE); ?>
            <?php echo get_input('text', 'entitystatusdate', 'data do status da empresa', FALSE, $customer[0]->entitystatusdate ? date('d/m/Y', $customer[0]->entitystatusdate) : FALSE, TRUE); ?>
            <?php echo get_input('text', 'entitystatus', 'status da empresa', FALSE, $customer[0]->entitystatus, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('defaultaddress', 6, 'endereço padrão', $customer[0]->defaultaddress, TRUE); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="address">endereço</label> |
          <label class="tab-btn" data-toggle="relationship">relacionamentos</label> |
          <label class="tab-btn" data-toggle="financial">financeiro</label> |
          <label class="tab-btn" data-toggle="licensecontrol">controle de licenças</label> |
          <label class="tab-btn" data-toggle="paymentinstallment">pagamento e parcelamento</label> |
          <label class="tab-btn" data-toggle="delivery">entrega</label> |
          <label class="tab-btn" data-toggle="systeminformation">informações do sistema</label>
        </div>
        <div class="tab-wrapper">
          <div id="address" class="tab-wrapper-content" style="display: flex">
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 500px; max-width: 100%">
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
                    <div class="column align-right" style="min-width: 0px; padding-right: 1rem;">
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="relationship" class="tab-wrapper-content" style="display: none">
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1200px; max-width: 100%">
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
                    style="min-width: 1200px; max-width: 100%">
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
          <div id="financial" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'minimumturnover', 'faturamento mínimo', FALSE, $customer[0]->minimumturnover, TRUE); ?>
                <?php echo get_input('text', 'creditlimit', 'limite de crédito', FALSE, $customer[0]->creditlimit, TRUE); ?>
              </div>
              <div class="column-33">
                <?php echo get_input('text', 'applybalance', 'saldo a aplicar', FALSE, $customer[0]->applybalance, TRUE); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
          </div>
          <div id="licensecontrol" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'federalpolicelicense', 'licença de polícia federal', FALSE, $customer[0]->federalpolicelicense, TRUE); ?>
                <?php echo get_input('text', 'datefederalpolicelicense', 'data expiração da licença da política federal', FALSE, $customer[0]->datefederalpolicelicense ? date('d/m/Y', $customer[0]->datefederalpolicelicense) : FALSE, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'civilpolicelicense', 'licença de polícia civil', FALSE, $customer[0]->civilpolicelicense, TRUE); ?>
                <?php echo get_input('text', 'datecivilpolicelicense', 'data expiração da licença da política civil', FALSE, $customer[0]->datecivilpolicelicense ? date('d/m/Y', $customer[0]->datecivilpolicelicense) : FALSE, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'armylicense', 'licença do exército', FALSE, $customer[0]->armylicense, TRUE); ?>
                <?php echo get_input('text', 'datearmylicense', 'data expiração da licença do exército', FALSE, $customer[0]->datearmylicense ? date('d/m/Y', $customer[0]->datearmylicense) : FALSE, TRUE); ?>
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
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 1800px; max-width: 100%">
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $license->ncm; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;" >
                      <?php echo $license->description; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;" >
                      <?php echo $license->iscontrolledcivilpolice == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;" >
                      <?php echo $license->iscontrolledfederalpolice == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;" >

                      <?php if ($license->permissionsfederalpolice): ?>
                        <?php $permissionsfederalpolice = json_decode($license->permissionsfederalpolice); ?>
                        <?php foreach ($permissionsfederalpolice as $row): ?>
                          <?php echo $licenseactivitiesfederalpolice[get_position_array($row, $licenseactivitiesfederalpolice)]->title . ', '; ?>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;" >
                      <?php echo $license->iscontrolledarmy == 'T' ? 'Sim' : 'Não'; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;" >
                      <?php if ($license->permissionsarmy): ?>
                        <?php $permissionsarmy = json_decode($license->permissionsarmy); ?>
                        <?php foreach ($permissionsarmy as $row): ?>
                          <?php echo $licenseactivitiesarmy[get_position_array($row, $licenseactivitiesarmy)]->title . ', '; ?>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </div>
                    <div class="column column-10">
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
          <div id="paymentinstallment" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <div class="form-input-content">
                  <label for="">Dias da semana que é permitido o pagamento</label>
                  <div class="btn-checkbox">
                    <?php echo get_checkbox_button('paymentweek[]', 'segunda', TRUE, $customer[0]->paymentweek ? $customer[0]->paymentweek : FALSE); ?>
                    <?php echo get_checkbox_button('paymentweek[]', 'terça', TRUE, $customer[0]->paymentweek ? $customer[0]->paymentweek : FALSE); ?>
                    <?php echo get_checkbox_button('paymentweek[]', 'quarta', TRUE, $customer[0]->paymentweek ? $customer[0]->paymentweek : FALSE); ?>
                    <?php echo get_checkbox_button('paymentweek[]', 'quinta', TRUE, $customer[0]->paymentweek ? $customer[0]->paymentweek : FALSE); ?>
                    <?php echo get_checkbox_button('paymentweek[]', 'sexta', TRUE, $customer[0]->paymentweek ? $customer[0]->paymentweek : FALSE); ?>
                  </div>
                </div>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <div class="form-input-content">
                  <label for="">Dias do mês que é permitido o pagamento</label>
                  <div class="btn-checkbox">
                    <?php echo get_checkbox_button('paymentmonth[]', '01', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '02', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '03', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '04', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '05', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '06', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '07', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '08', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '09', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '10', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '11', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '12', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '13', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '14', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '15', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '16', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '17', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '18', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '19', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '20', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '21', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '22', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '23', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '24', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '25', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '26', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '27', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '28', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '29', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '30', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                    <?php echo get_checkbox_button('paymentmonth[]', '31', TRUE, $customer[0]->paymentmonth ? $customer[0]->paymentmonth : FALSE); ?>
                  </div>
                </div>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <div class="form-input-content">
                  <label for="">Dias do mês que é permitido o faturamento</label>
                  <div class="btn-checkbox">
                    <?php echo get_checkbox_button('invoicingmonth[]', '01', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '02', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '03', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '04', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '05', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '06', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '07', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '08', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '09', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '10', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '11', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '12', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '13', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '14', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '15', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '16', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '17', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '18', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '19', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '20', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '21', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '22', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '23', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '24', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '25', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '26', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '27', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '28', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '29', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '30', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                    <?php echo get_checkbox_button('invoicingmonth[]', '31', TRUE, $customer[0]->invoicingmonth ? $customer[0]->invoicingmonth : FALSE); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="delivery" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33">
              </div>
              <div class="column-33">
              </div>
              <div class="column-33">
              </div>
            </div>
          </div>
          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('isinactive', 'inativo', TRUE, $customer[0]->isinactive); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('iscustomer', 'cliente', TRUE, $customer[0]->iscustomer); ?>
                <?php echo get_checkbox('issupplier', 'fornecedor', TRUE, $customer[0]->issupplier); ?>
                <?php echo get_checkbox('iscarrier', 'transportadora', TRUE, $customer[0]->iscarrier); ?>
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
          <div class="form-input-content">
            <div class="error-message error-input"></div>
          </div>
          <div class="functions-tab tab-row">
            <a href="<?php echo base_url('customer/' . $this->uri->segment(2) . '?edit=T'); ?>"
              class="btn-purple">editar</a>
            <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
          </div>
        </div>
      </div>
    </div>
  </div>