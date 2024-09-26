<?php if ($estimate[0]->validity < stringtotimestamp(date('d/m/Y'))) : ?>
<div class="disclaimer disclaimer-alert disclaimer-validity">
  <i class="ph ph-warning-circle"></i>
  Este orçamento já passou do período de validade, revalide o orçamento.
</div>
<?php endif; ?>
<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-estimates">
        <?php echo form_open('estimate', array('id' => 'estimate-edit')); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title"><i class="ph ph-receipt"></i> Orçamento <?php echo $estimate[0]->tranid; ?>
            <div class="status"><?php echo $estimate[0]->status; ?></div>
          </div>

            <div class="functions-tab tab-row">
              <div class="column-buttons-tab">
                <div class="tab-row">
                  <button type="submit" class="btn-purple" id="submit-estimate-edit">salvar</button>
                  <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
                </div>
              </div>
            </div>

            <div class="functions-tab">
              <div class="legal-infos">
                Criado por:
                <?php echo $employee[0]->name; ?><br />
                Criado em:
                <?php echo date('d/m/Y H:i', $estimate[0]->created); ?><br />
                <?php if ($estimate[0]->updated): ?>
                    Editado em:
                    <?php echo date('d/m/Y H:i', $estimate[0]->updated); ?>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="resume">
            <div class="resume-head">
              <div class="title">Resumo</div>
            </div>
            <div class="resume-content" style="display: none">
              <div class="row">
                <div class="title">subtotal</div>
                <div class="subtotal"><?php echo $resumesubtotal[0]->value  ? number_format($resumesubtotal[0]->value , 2, '.', '') : '0.00'; ?></div>
              </div>
              <div class="row">
                <div class="title">desconto</div>
                <div class="discount"><?php echo $estimate[0]->discount ? number_format($estimate[0]->discount, 2, '.', '') : '0.00'; ?></div>
              </div>
              <div class="row">
                <div class="title">frete</div>
                <div class="freight"><?php echo $estimate[0]->freight ? number_format($estimate[0]->freight, 2, '.', '') : '0.00'; ?></div>
              </div>
              <div class="row">
                <hr />
              </div>
            </div>
            <div class="resume-footer">
              <div class="row">
                <div class="title">total</div>
                <div class="total"><?php echo $resumesubtotal[0]->value  ? number_format((float) $resumesubtotal[0]->value + (float) $estimate[0]->freight - (float) $estimate[0]->discount, 2, '.', '') : '0.00'; ?></div>
              </div>
              <i class="ph ph-equals"></i>
            </div>
          </div>

        </div>

        <?php echo get_input('hidden', 'id', 'ID', FALSE, $estimate[0]->id); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customer', 'cliente', '<i class="ph ph-share"></i>', $estimate[0]->customername, FALSE, base_url('customer/' . $estimate[0]->customerid)); ?>
            <?php echo get_input('hidden', 'customerid', 'cliente id', FALSE, $estimate[0]->customerid); ?>
            <?php echo get_input('hidden', 'customerfactor', 'cliente factor'); ?>
            <?php echo get_select($relationships, 'contact', 'contato', FALSE, $estimate[0]->contactid); ?>
            <?php echo get_input('text', 'salesman', 'vendedor', FALSE, $estimate[0]->salesmanname); ?>
            <?php echo get_input('hidden', 'salesmanid', 'vendedor id', FALSE, $estimate[0]->salesmanid); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customerpurchaseorder', 'pedido de compra', FALSE, $estimate[0]->customerpurchaseorder); ?>
            <?php echo get_input('text', 'deadline', 'prazo de entrega', FALSE, $estimate[0]->deadline != 0 ? date('d/m/Y', $estimate[0]->deadline) : FALSE); ?>
            <?php echo get_input('text', 'validity', 'validade do orçamento', FALSE, $estimate[0]->validity != 0 ? date('d/m/Y', $estimate[0]->validity) : FALSE, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $estimate[0]->comments); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($freighttypes, 'freighttype', 'tipo de frete', FALSE, $estimate[0]->freighttypeid); ?>
            <?php echo get_input('text', 'carrier', 'transportadora', '<i class="ph ph-share"></i>', $estimate[0]->carriername, FALSE, base_url('carrier/' . $estimate[0]->carrierid)); ?>
            <?php echo get_input('hidden', 'carrierid', 'carrier id', FALSE, $estimate[0]->carrierid); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'freight', 'frete', '', $estimate[0]->freight); ?>
            <?php echo get_input('text', 'discount', 'desconto', '', $estimate[0]->discount); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('freightrenegotiation', 'renegociação de frete', $permission ? FALSE : TRUE, $estimate[0]->freightrenegotiation == 'T' ? TRUE : FALSE); ?>
            <?php echo get_checkbox('customerapproval', 'aprovação do cliente', FALSE, $estimate[0]->customerapproval == 'T' ? TRUE : FALSE); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="items">itens</label> |
          <label class="tab-btn" data-toggle="billing">faturamento</label> |
          <label class="tab-btn" data-toggle="sharedlinks">registros relacionados</label> |
          <label class="tab-btn" data-toggle="taxs">impostos</label> |
          <label class="tab-btn" data-toggle="systeminformation">informações do sistema</label>
        </div>
        <div class="tab-wrapper">
          <div id="items" class="tab-wrapper-content" style="display: flex">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'item', 'inserir item'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'contractitem', 'inserir item de contrato'); ?>
              </div>
              <div class="column-33"></div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 2700px; max-width: 100%;">
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">linha</div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">foto / descrição</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">item</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">nome alternativo</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">subsidiaria sugerida</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">subsidiaria escolhida</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">código</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">unidade de medida</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">marca</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">preço</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">quantidade orçada</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">total orçado</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">quantidade fechada</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">total fechado</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">prazo de entrega</div>
                  <div class="column" style="min-width: 130px; padding-right: 1rem;">descrição</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;"></div>
                </div>
                <?php $count = 1; ?>
                <?php foreach ($items as $key => $item): ?>

                    <?php
                    $sugestedsubsidiary = "<option value='" . $item->sugestedsubsidiaries->id . "'>" . $item->sugestedsubsidiaries->title . "</option>";
                    $chosensubsidiaries = '';
                    foreach ($item->chosensubsidiaries as $key => $value) {
                      $chosensubsidiaries .= "<option value='" . $value->id . "'" . ($value->id == $item->chosedsubsidiaryid ? "selected" : "") . ">" . $value->title . "</option>";
                    }
                    $minprice = 0;
                    foreach ($item->minprice as $key => $value) {
                      $v = (object) $value;
                      if (!!$v->choice){
                        $minprice = $v->price;
                      }
                    }
                    ?>
                    <div class="table-content <?php echo $count % 2 == 0 ? 'table-content-color' : ''; ?>" style="min-width: 2700px; max-width: 100%;">
                      <div class="column" style="min-width: 100px; padding-right: 1rem;" title="linha">
                          <div class="form-input-box">
                            <input type="text" name="itemline[]" placeholder="linha" value="<?php echo $item->itemline; ?>">
                          </div>
                          <input type="hidden" name="itemlineid[]" value="<?php echo $item->itemlineid; ?>">
                      </div>
                      <div class="column" style="min-width: 100px; padding-right: 1rem;" title="foto / descrição">
                        <div class="form-input-box no-background checkbox">
                          <input type="checkbox" id="chkbx<?php echo $count; ?>" name="itemprintdescription[]" <?php echo ($item->itemprintdescription == 'T' ? 'checked' : ''); ?>>
                          <label for="chkbx<?php echo $count; ?>"></label>
                        </div>
                      </div>
                      <div class="column" style="min-width: 250px; padding-right: 1rem;" title="item">
                        <a href="<?php echo base_url("item/" . $item->itemid); ?>" target="_blank" class="btn-link"><?php echo $item->itemname; ?></a>
                      </div>
                      <div class="column" style="min-width: 200px; padding-right: 1rem;" title="nome alternativo">
                          <div class="form-input-box">
                              <input type="text" name="itemalternativename[]" placeholder="nome alternativo" value="<?php echo $item->itemalternativename; ?>">
                          </div>
                      </div>
                      <div class="column" style="min-width: 200px; padding-right: 1rem;" title="subsidiária sugerida">
                          <div class="form-input-box">
                              <select name="itemsuggestedsubsidiary[]" disabled>
                                  <?php echo $sugestedsubsidiary; ?>
                              </select>
                          </div>
                      </div>
                      <div class="column" style="min-width: 200px; padding-right: 1rem;" title="subsidiária escolhida">
                          <div class="form-input-box">
                              <select name="itemchosensubsidiary[]">
                                <?php echo $chosensubsidiaries; ?>
                              </select>
                          </div>
                      </div>
                      <div class="column" style="min-width: 150px; padding-right: 1rem;" title="código">
                        <?php echo $item->salescode; ?>
                      </div>
                      <div class="column" style="min-width: 150px; padding-right: 1rem;" title="unidade de medida">
                        <?php echo $item->saleunitname; ?>
                      </div>
                      <div class="column" style="min-width: 200px; padding-right: 1rem;" title="marca">
                        <?php echo $item->brandname; ?>
                      </div>
                      <div class="column" style="min-width: 150px; padding-right: 1rem;" title="preço">
                          <div class="form-input-box">
                              <input type="text" name="itemprice[]" placeholder="preço"
                               value="<?php echo $item->itemprice; ?>"
                               data-minprice="<?php echo $item->minimumprice; ?>"
                              >
                          </div>
                      </div>
                      <div class="column" style="min-width: 150px; padding-right: 1rem;" title="quantidade orçada">
                          <div class="form-input-box">
                              <input type="text" name="itemquantitybudgeted[]" placeholder="quantidade orçada" value="<?php echo $item->itemquantitybudgeted; ?>">
                          </div>
                      </div>
                      <div class="column" style="min-width: 150px; padding-right: 1rem;" title="total orçado">
                          <div class="form-input-box">
                              <input type="text" name="itemtotal[]" placeholder="preço orçado" value="<?php echo $item->itemtotal; ?>" disabled>
                          </div>
                      </div>
                      <div class="column" style="min-width: 150px; padding-right: 1rem;" title="quantidade fechada">
                          <div class="form-input-box">
                              <input type="text" name="itemquantityapproved[]" placeholder="quantidade fechada" value="<?php echo $item->itemquantityapproved; ?>">
                          </div>
                      </div>
                      <div class="column" style="min-width: 150px; padding-right: 1rem;" title="total fechado">
                          <div class="form-input-box">
                              <input type="text" name="itemtotalapprovedamount[]" placeholder="total fechado" value="<?php echo $item->itemtotalapprovedamount; ?>" disabled>
                          </div>
                      </div>
                      <div class="column" style="min-width: 150px; padding-right: 1rem;" title="prazo de entrega">
                          <div class="form-input-box">
                              <input type="text" name="itemdeadline[]" placeholder="prazo de entrega" value="<?php echo $item->itemdeadline; ?>">
                          </div>
                      </div>
                      <div class="column" style="min-width: 130px; padding-right: 1rem;" title="descrição">
                          <a href="" class="btn-purple btn-description-item">descrição</a>
                          <div style="display: none" name="itemdescription[]" data-referer="<?php echo $item->itemlineid; ?>"><?php echo json_decode($item->estimateitemdescription); ?></div>
                      </div>
                      <input type="hidden" name="itemid[]" value="<?php echo $item->itemid; ?>">
                      <input type="hidden" name="itemname[]" value="<?php echo $item->itemname; ?>">
                      <input type="hidden" name="itemtotalquantityavailable[]" value="<?php echo $item->itemtotalquantityavailable; ?>">
                      <input type="hidden" name="itempurchaseunitid[]" value="<?php echo $item->purchaseunitid; ?>">
                      <input type="hidden" name="itempurchaseunitname[]" value="<?php echo $item->purchaseunitname; ?>">
                      <input type="hidden" name="itemmanufacturercode[]" value="<?php echo $item->manufacturercode; ?>">
                      <div class="column align-right" style="width: 150px; padding-right: 1rem;" title="remover">
                          <a href="" class="btn-red btn-remove-item">remover</a>
                      </div>
                    </div>
                    <?php $count++; ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="billing" class="tab-wrapper-content" style="display: none">
            <div class="group-title">endereço</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <div class="form-input-content">
                  <label for="selectshippingaddress">endereço de entrega</label>
                  <div class="form-input-box">
                    <select name="selectshippingaddress">
                      <option value="">Escolha um(a) endereço</option>
                      <?php foreach ($addresses as $key => $address): ?>
                          <option value="<?php echo $address->id; ?>" data-address="<?php echo $address->title; ?>"
                            <?php echo !empty($estimate[0]->shippingaddressid) && $address->id == $estimate[0]->shippingaddressid ? 'selected="selected"' : ''; ?>>
                            <?php echo preg_split('/\r\n|\r|\n/', $address->title)[0]; ?>
                          </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-selectshippingaddress error-input"></div>
                </div>
                <?php echo get_textarea('shippingaddress', 6, 'endereço de entrega', $estimate[0]->shippingaddress, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
              <div class="form-input-content">
                  <label for="selectbilladdress">endereço de fatura</label>
                  <div class="form-input-box">
                    <select name="selectbilladdress">
                      <option value="">Escolha um(a) endereço</option>
                      <?php foreach ($addresses as $key => $address): ?>
                          <option value="<?php echo $address->id; ?>" data-address="<?php echo $address->title; ?>"
                            <?php echo !empty($estimate[0]->billaddressid) && $address->id == $estimate[0]->billaddressid ? 'selected="selected"' : ''; ?>>
                            <?php echo preg_split('/\r\n|\r|\n/', $address->title)[0]; ?>
                          </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-selectbilladdress error-input"></div>
                </div>
                <?php echo get_textarea('billaddress', 6, 'endereço da fatura', $estimate[0]->billaddress, TRUE); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="group-title">prestações</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <div class="form-input-content">
                  <label for="terms">condições</label>
                  <div class="form-input-box">
                    <select name="terms">
                      <option value="">Escolha um(a) condições</option>
                      <?php foreach ($terms as $term): ?>
                          <option value="<?php echo $term->id; ?>" data-installments="<?php echo $term->installments; ?>"
                            data-timeqty="<?php echo $term->timeqty; ?>" data-leadtime="<?php echo $term->leadtime; ?>"
                            <?php echo $term->id == $estimate[0]->termsid ? 'selected="selected"' : ''; ?>>
                            <?php echo $term->title; ?>
                          </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-terms error-input"></div>
                </div>
              </div>
              <div class="column-33">
              </div>
              <div class="column-33">
              </div>
            </div>
          </div>
          <div id="sharedlinks" class="tab-wrapper-content" style="display: none">
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 800px; max-width: 100%;">
                  <div class="column" style="min-width:200px; padding-right:1rem;">data</div>
                  <div class="column" style="min-width:200px; padding-right:1rem;">tipo</div>
                  <div class="column" style="min-width:200px; padding-right:1rem;">numero</div>
                  <div class="column" style="min-width:200px; padding-right:1rem;">editado</div>
                </div>
                <?php foreach ($sharedlinks as $key => $sharedlink): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 800px; max-width: 100%;">
                    <div class="column" style="min-width:200px; padding-right:1rem;">
                      <?php echo date('d/m/Y', $sharedlink['created']); ?>
                    </div>
                    <div class="column" style="min-width:200px; padding-right:1rem;">
                      <a href="<?php echo $sharedlink['link']; ?>" target="_blank" class="btn-link">
                        <?php echo $sharedlink['name']; ?>
                      </a>
                    </div>
                    <div class="column" style="min-width:200px; padding-right:1rem;">
                      <?php echo $sharedlink['tranid']; ?>
                    </div>
                    <div class="column" style="min-width:200px; padding-right:1rem;">
                      <?php echo $sharedlink['updated'] ? date('d/m/Y', $sharedlink['updated']) : ''; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="taxs" class="tab-wrapper-content" style="display: none">
          </div>
          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('isinactive', 'inativo', TRUE, $estimate[0]->isinactive); ?>
              </div>
              <div class="column-33">
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
          <button type="submit" class="btn-purple" id="submit-estimate-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<div id="modal-description" class="modal">
  <div class="modal-header">
    <div id="close-modal-description" class="close">
      <i class="ph ph-x"></i>
    </div>
  </div>
  <div class="modal-content">
    <div id="editor" style="max-width: 370px; min-height: 250px; z-index: 10;">
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn-purple" id="alter-description">Alterar</button>
  </div>
</div>
