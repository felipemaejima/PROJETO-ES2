<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-creditmemos">
        <?php echo form_open('creditmemo', array('id' => 'creditmemo-edit')); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title">
              <i class="ph ph-receipt"></i>
              Memorando de crédito 
              <?php echo $creditmemo[0]->tranid; ?>
            </div>
            <div class="functions-tab tab-row">
              <a href="<?php echo base_url('creditmemo/' . $this->uri->segment(2) . '?edit=T'); ?>" 
              class="btn-purple">editar</a>
              <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
            </div>
          </div>
          <div class="resume">
            <div class="resume-head">
              <div class="title">Resumo</div>
            </div>
            <div class="resume-content" style="display: none">
              <div class="row">
                <div class="title">subtotal</div>
                <div class="subtotal">
                  0.00
                </div>
              </div>
              <div class="row">
                <div class="title">desconto</div>
                <div class="discount">
                  0.00
                </div>
              </div>
              <div class="row">
                <div class="title">frete</div>
                <div class="freight">
                  0.00
                </div>
              </div>
              <div class="row">
                <hr />
              </div>
            </div>
            <div class="resume-footer">
              <div class="row">
                <div class="title">total</div>
                <div class="total">
                  0.00
                </div>
              </div>
              <i class="ph ph-equals"></i>
            </div>
          </div>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $creditmemo[0]->id ); ?>
        <?php echo get_input('hidden', 'createdfrom', 'criado de', FALSE, $creditmemo[0]->createdfrom ); ?>

        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customer', 'cliente', FALSE, $creditmemo[0]->customername, TRUE ); ?>
            <?php echo get_input('hidden', 'customerid', 'customer id', FALSE, $creditmemo[0]->customerid); ?>
            <?php //  echo get_select(FALSE, 'contact', 'contato'); ?>
            <?php echo get_input('text', 'customerpurchaseorder', 'pedido de compra do cliente', FALSE, $creditmemo[0]->customerpurchaseorder, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $creditmemo[0]->subsidiaryid, TRUE); ?>
            <?php // echo get_input('text', 'deadline', 'entregar até', FALSE, $creditmemo[0]->deadline); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $creditmemo[0]->comments, TRUE); ?>
          </div>
        </div>
        <div class="group-title">informações de venda</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'salesman', 'vendedor', FALSE, $creditmemo[0]->salesmanname, TRUE); ?>
            <?php echo get_input('hidden', 'salesmanid', 'vendedor id', FALSE, $creditmemo[0]->salesmanid); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'saledate', 'data da venda', FALSE, date('d/m/Y', $creditmemo[0]->saledate), TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <br>
            <?php echo get_checkbox('excludecommission', 'excluir comissão', TRUE, $creditmemo[0]->excludecommission == 'T' ? TRUE : FALSE); ?>
          </div>
        </div>
        <div class="group-title">envio</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'volumetype', 'tipo de volume', FALSE, $creditmemo[0]->volumetype, TRUE); ?>
            <?php echo get_input('text', 'volumesquantity', 'volumes', FALSE, $creditmemo[0]->volumesquantity, TRUE); ?>

          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'netweight', 'peso liquido kg', FALSE, $creditmemo[0]->netweight, TRUE); ?>
            <?php echo get_input('text', 'grossweight', 'peso bruto kg', FALSE, $creditmemo[0]->grossweight, TRUE); ?>
          </div>
          <div class="column-33">
            <?php echo get_textarea('receiptcomments', 6, 'anotações do recebimento', $creditmemo[0]->receiptcomments, TRUE); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($freighttypes, 'freighttype', 'tipo de frete', FALSE, $creditmemo[0]->freighttypeid); ?>
            <?php echo get_input('text', 'carrier', 'transportadora', FALSE, $creditmemo[0]->carriername); ?>
            <?php echo get_input('hidden', 'carrierid', 'carrier id', FALSE, $creditmemo[0]->carrierid); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'freight', 'frete', '<i class="ph ph-arrows-clockwise calculate-freight"></i>', $creditmemo[0]->freight, TRUE); ?>
            <?php echo get_input('text', 'discount', 'desconto', '<i class="ph ph-arrows-clockwise calculate-discount"></i>', $creditmemo[0]->discount, TRUE); ?>
          </div>
          <div class="column-33">
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="nfe">nota fiscal</label> |
          <label class="tab-btn" data-toggle="items">itens</label> |
          <label class="tab-btn" data-toggle="billing">faturamento</label> |
          <label class="tab-btn" data-toggle="taxs">impostos</label> |
          <label class="tab-btn" data-toggle="sharedlinks">registros relacionados</label> |
          <label class="tab-btn" data-toggle="systeminformation">informações do sistema</label> |
        </div>
        <div class="tab-wrapper">
          <div id="nfe" class="tab-wrapper-content" style="display: flex">
            <div class="group-title">informações da fatura</div>
            <!-- adicionar campos carta de correção e aliquota -->
             <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select($operationtypes, 'operationtype', 'tipo de operação', FALSE, $creditmemo[0]->operationtypeid, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <!-- este campo deve ser obrigatório após gerar NF -->
                <?php echo get_input('text', 'trafficguide', 'guia de tráfego', FALSE, $creditmemo[0]->trafficguide, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_textarea('additionalinformation', 6, 'informações adicionais da nota', $creditmemo[0]->additionalinformation, TRUE); ?>
              </div>
            </div>
            <div class="group-title">informações NF-e</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'fiscaldocnumber', 'número da NF-e', FALSE, $creditmemo[0]->fiscaldocnumber, TRUE ); ?>
                <?php echo get_input('text', 'fiscaldocdate', 'data de autorizacão', FALSE, $creditmemo[0]->fiscaldocdate ? date('d/m/Y H:i:s', $creditmemo[0]->fiscaldocdate) : '', TRUE); ?>
                <?php echo get_input('text', 'fiscaldocsenddate', 'data de envio', FALSE, $creditmemo[0]->fiscaldocsenddate ? date('d/m/Y H:i:s', $creditmemo[0]->fiscaldocsenddate) : '', TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'fiscaldocaccesskey', 'chave de acesso', FALSE, $creditmemo[0]->fiscaldocaccesskey, TRUE); ?>
                <?php echo get_input('text', 'fiscaldocstatus', 'status da NF-e', FALSE, $creditmemo[0]->fiscaldocstatus, TRUE); ?>
                <?php echo get_input('text', 'fiscaldocrefaccesskey', 'chave da NF-e referente', FALSE, $creditmemo[0]->fiscaldocrefaccesskey, TRUE); ?>
              </div>
              <div class="column-33">
                <?php echo get_input('text', 'fiscaldoccancellationdate', 'data de cancelamento', FALSE, $creditmemo[0]->fiscaldoccancellationdate ? date('d/m/Y H:i:s', $creditmemo[0]->fiscaldoccancellationdate) : '', TRUE); ?>
                <?php echo get_input('text', 'fiscaldocreturnmessage', 'mensagem de retorno', FALSE, $creditmemo[0]->fiscaldocreturnmessage, TRUE); ?>
              </div>
            </div>
          </div>
          <div id="items" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'item', 'inserir item', FALSE, FALSE, TRUE); ?>
              </div>
              <div class="column-33"></div>
              <div class="column-33"></div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 2100px; max-width: 100%;">
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">linha</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">item</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">nome alternativo</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">unidade de medida</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">quantidade</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">valor</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">total bruto</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">desconto</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">frete</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">total</div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">ncm</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">informações adicionais NFe</div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;"></div>
                </div>
                <?php $count = 1; ?>
                <?php foreach ($items as $key => $item): ?>
                  <div class="table-content <?php echo $count % 2 == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 2100px; max-width: 100%">
                    <div class="column" style="min-width: 100px; padding-right: 1rem;" title="linha">
                      <div class="form-input-box">
                        <input type="text" name="itemline[]" placeholder="linha" value="<?php echo $item->itemline; ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="item">
                      <a href="<?php echo base_url("item/" . $item->itemid); ?>" target="_blank"
                      class="btn-link"><?php echo $item->itemname; ?></a>
                      <input type="hidden" name="itemid[]" value="<?php echo $item->itemid; ?>">
                      <input type="hidden" name="itemname[]" value="<?php echo $item->itemname; ?>">
                      <input type="hidden" name="creditmemolineitem[]" value="<?php echo $item->id ?? ''; ?>">
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;" title="nome alternativo">
                      <div class="form-input-box">
                        <input type="text" name="itemalternativename[]" placeholder="nome alternativo"
                          value="<?php echo $item->itemalternativename; ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="unidade de medida">
                      <?php echo $item->saleunitname; ?>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="quantidade">
                      <div class="form-input-box">
                        <input type="text" name="itemquantity[]" placeholder="quantidade"
                          value="<?php echo $item->itemquantity; ?>" data-maxqty="<?php echo $item->itemquantity; ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="valor">
                      <div class="form-input-box">
                        <input type="text" name="itemprice[]" placeholder="valor" value="<?php echo $item->itemprice; ?>" 
                        data-minprice="<?php echo $item->minimumprice; ?>" disabled>
                        <input type="hidden" name="minprice[]" value="<?php echo $item->minimumprice; ?>">
                        <input type="hidden" name="suggestedprice[]" value="<?php echo $item->suggestedprice; ?>">
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="total bruto">
                      <div class="form-input-box">
                        <input type="text" name="itemgrossvalue[]" placeholder="total bruto"
                          value="<?php echo $item->itemgrossvalue; ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="desconto">
                      <div class="form-input-box">
                        <input type="text" name="itemdiscount[]" placeholder="desconto"
                          value="<?php echo $item->itemdiscount; ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="frete">
                      <div class="form-input-box">
                        <input type="text" name="itemfreight[]" placeholder="frete"
                          value="<?php echo $item->itemfreight; ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="total">
                      <div class="form-input-box">
                        <input type="text" name="itemtotal[]" placeholder="total" value="<?php echo $item->itemtotal; ?>"
                          disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 100px; padding-right: 1rem;" title="ncm">
                      <?php echo $item->ncm; ?>
                      <input type="hidden" name="ncm[]" value="<?php echo $item->ncm; ?>">
                      <input type="hidden" name="ncmid[]" value="<?php echo $item->ncmid; ?>">
                      <input type="hidden" name="ncmdescription[]" value="<?php echo $item->ncmdescription; ?>">

                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="informações adicionais do item">
                      <div class="form-input-box">
                        <input type="text" name="itemadditionalinformation[]" placeholder="informações adicionais do item"
                          value="<?php echo $item->additionalinformation; ?>" disabled>
                      </div>
                    </div>
                    <div class="column align-right" style="min-width: 100px;" title="remover">
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
                  <label for="shippingaddressid">endereço de entrega</label>
                  <div class="form-input-box">
                    <select name="shippingaddressid" disabled>
                      <option value="">Escolha um(a) endereço</option>
                      <?php foreach($addresses as $key => $address): ?>
                        <option value="<?php echo $address->id; ?>" data-address="<?php echo $address->title; ?>"
                          <?php echo !empty($creditmemo[0]->shippingaddressid) && $address->id == $creditmemo[0]->shippingaddressid ? 'selected="selected"' : ''; ?>>
                          <?php echo preg_split('/\r\n|\r|\n/', $address->title)[0]; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-selectshippingaddress error-input"></div>
                </div>
                <?php echo get_textarea('shippingaddress', 6, 'endereço de entrega', $creditmemo[0]->shippingaddress, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
              <div class="form-input-content">
                  <label for="billaddressid">endereço de fatura</label>
                  <div class="form-input-box">
                    <select name="billaddressid" disabled>
                      <option value="">Escolha um(a) endereço</option>
                      <?php foreach($addresses as $key => $address): ?>
                        <option value="<?php echo $address->id; ?>" data-address="<?php echo $address->title; ?>"
                          <?php echo !empty($creditmemo[0]->billaddressid) && $address->id == $creditmemo[0]->billaddressid ? 'selected="selected"' : ''; ?>>
                          <?php echo preg_split('/\r\n|\r|\n/', $address->title)[0]; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-selectbilladdress error-input"></div>
                </div>
                <?php echo get_textarea('billaddress', 6, 'endereço da fatura', $creditmemo[0]->billaddress, TRUE); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="group-title">prestações</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select($terms, 'terms', 'condições', FALSE, $creditmemo[0]->termsid, TRUE); ?>
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
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 800px; max-width: 100%;">
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
          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33">
                <?php echo get_checkbox('isinactive', 'inativo', TRUE, $creditmemo[0]->isinactive); ?>
              </div>
              <div class="column-33">
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
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <a href="<?php echo base_url('creditmemo/' . $this->uri->segment(2) . '?edit=T'); ?>" 
          class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>