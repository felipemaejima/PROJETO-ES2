<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-creditmemos">
        <?php echo form_open('creditmemo', array('id' => 'creditmemo-create')); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title">
              <i class="ph ph-receipt"></i>
              Memorando de crédito
            </div>
            <div class="functions-tab tab-row">
              <button type="submit" class="btn-purple" id="submit-creditmemo-create">criar</button>
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
        <?php echo get_input('hidden', 'createdfrom', 'criado de', FALSE, $returnreceipt[0]->id ); ?>

        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customer', 'cliente', FALSE, $returnreceipt[0]->customername, TRUE ); ?>
            <?php echo get_input('hidden', 'customerid', 'customer id', FALSE, $returnreceipt[0]->customerid); ?>
            <?php //  echo get_select(FALSE, 'contact', 'contato'); ?>
            <?php echo get_input('text', 'customerpurchaseorder', 'pedido de compra do cliente', FALSE, $invoice[0]->customerpurchaseorder); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $returnreceipt[0]->subsidiaryid, TRUE); ?>
            <?php // echo get_input('text', 'deadline', 'entregar até', FALSE, $invoice[0]->deadline); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações'); ?>
          </div>
        </div>
        <div class="group-title">informações de venda</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'salesman', 'vendedor', FALSE, $invoice[0]->salesmanname, TRUE); ?>
            <?php echo get_input('hidden', 'salesmanid', 'vendedor id', FALSE, $invoice[0]->salesmanid); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'saledate', 'data da venda', FALSE, date('d/m/Y', $invoice[0]->saledate), TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <br>
            <?php echo get_checkbox('excludecommission', 'excluir comissão', FALSE, $invoice[0]->excludecommission == 'T' ? TRUE : FALSE); ?>
          </div>
        </div>
        <div class="group-title">envio</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'volumetype', 'tipo de volume', FALSE, $invoice[0]->volumetype); ?>
            <?php echo get_input('text', 'volumesquantity', 'volumes', FALSE, $invoice[0]->volumesquantity); ?>

          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'netweight', 'peso liquido kg', FALSE, $invoice[0]->netweight); ?>
            <?php echo get_input('text', 'grossweight', 'peso bruto kg', FALSE, $invoice[0]->grossweight); ?>
          </div>
          <div class="column-33">
            <?php echo get_textarea('receiptcomments', 6, 'anotações do recebimento', $returnreceipt[0]->comments, TRUE); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($freighttypes, 'freighttype', 'tipo de frete', FALSE, $invoice[0]->freighttypeid); ?>
            <?php echo get_input('text', 'carrier', 'transportadora', FALSE, $invoice[0]->carriername); ?>
            <?php echo get_input('hidden', 'carrierid', 'carrier id', FALSE, $invoice[0]->carrierid); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'freight', 'frete', '<i class="ph ph-arrows-clockwise calculate-freight"></i>', $invoice[0]->freight); ?>
            <?php echo get_input('text', 'discount', 'desconto', '<i class="ph ph-arrows-clockwise calculate-discount"></i>', $invoice[0]->discount); ?>
          </div>
          <div class="column-33">
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="nfe">nota fiscal</label> |
          <label class="tab-btn" data-toggle="items">itens</label> |
          <label class="tab-btn" data-toggle="billing">faturamento</label> |
        </div>
        <div class="tab-wrapper">
          <div id="nfe" class="tab-wrapper-content" style="display: flex">
              <div class="group-title">informações da fatura</div>
              <!-- adicionar campos carta de correção e aliquota -->
              <div class="column">
                <div class="column-33 c-large c-medium c-small">
                  <?php echo get_select($operationtypes, 'operationtype', 'tipo de operação', FALSE, '60a626d0-950e-6351-f23b-4839b83f1c63'); ?>
                </div>
                <div class="column-33 c-large c-medium c-small">
                  <!-- este campo deve ser obrigatório após gerar NF -->
                  <?php echo get_input('text', 'trafficguide', 'guia de tráfego'); ?>
                </div>
                <div class="column-33 c-large c-medium c-small">
                  <?php echo get_textarea('additionalinformation', 6, 'informações adicionais da nota', $invoice[0]->additionalinformation); ?>
                </div>
              </div>
              <div class="group-title">informações NF-e</div>
              <div class="column">
                <div class="column-33 c-large c-medium c-small">
                  <?php echo get_input('text', 'fiscaldocnumber', 'número da NF-e'); ?>
                  <?php echo get_input('text', 'fiscaldocdate', 'data de autorização'); ?>
                  <?php echo get_input('text', 'fiscaldocsenddate', 'data de envio'); ?>
                </div>
                <div class="column-33 c-large c-medium c-small">

                  <?php echo get_input('text', 'fiscaldocaccesskey', 'chave de acesso'); ?>
                  <?php echo get_input('text', 'fiscaldocstatus', 'status da NF-e'); ?>
                  <?php echo get_input('text', 'fiscaldocrefaccesskey', 'chave da NF-e referente', FALSE, $invoice[0]->fiscaldocaccesskey); ?>
                </div>
                <div class="column-33">
                  <?php echo get_input('text', 'fiscaldoccancellationdate', 'data de cancelamento'); ?>
                  <?php echo get_input('text', 'fiscaldocreturnmessage', 'mensagem de retorno'); ?>
                </div>
              </div>
            </div>
          <!-- </div> -->
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
                        <input type="text" name="itemline[]" placeholder="linha" value="<?php echo $item->itemline; ?>">
                      </div>
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="item">
                      <a href="<?php echo base_url("item/" . $item->itemid); ?>" target="_blank"
                      class="btn-link"><?php echo $item->itemname; ?></a>
                      <input type="hidden" name="itemid[]" value="<?php echo $item->itemid; ?>">
                      <input type="hidden" name="itemname[]" value="<?php echo $item->itemname; ?>">
                      <input type="hidden" name="invoicelineitem[]" value="<?php echo $item->id ?? ''; ?>">
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;" title="nome alternativo">
                      <div class="form-input-box">
                        <input type="text" name="itemalternativename[]" placeholder="nome alternativo"
                          value="<?php echo $item->itemalternativename; ?>">
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="unidade de medida">
                      <?php echo $item->saleunitname; ?>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="quantidade">
                      <div class="form-input-box">
                        <input type="text" name="itemquantity[]" placeholder="quantidade"
                          value="<?php echo $item->itemquantity; ?>" data-maxqty="<?php echo $item->itemquantity; ?>">
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="valor">
                      <div class="form-input-box">
                        <input type="text" name="itemprice[]" placeholder="valor" value="<?php echo $item->itemprice; ?>" data-minprice="<?php echo $item->minimumprice; ?>">
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
                          value="<?php echo $item->itemdiscount; ?>">
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="frete">
                      <div class="form-input-box">
                        <input type="text" name="itemfreight[]" placeholder="frete"
                          value="<?php echo $item->itemfreight; ?>">
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
                          value="<?php echo $item->additionalinformation; ?>">
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
                    <select name="shippingaddressid">
                      <option value="">Escolha um(a) endereço</option>
                      <?php foreach($addresses as $key => $address): ?>
                        <option value="<?php echo $address->id; ?>" data-address="<?php echo $address->title; ?>"
                          <?php echo !empty($invoice[0]->shippingaddressid) && $address->id == $invoice[0]->shippingaddressid ? 'selected="selected"' : ''; ?>>
                          <?php echo preg_split('/\r\n|\r|\n/', $address->title)[0]; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-selectshippingaddress error-input"></div>
                </div>
                <?php echo get_textarea('shippingaddress', 6, 'endereço de entrega', $invoice[0]->shippingaddress, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
              <div class="form-input-content">
                  <label for="billaddressid">endereço de fatura</label>
                  <div class="form-input-box">
                    <select name="billaddressid">
                      <option value="">Escolha um(a) endereço</option>
                      <?php foreach($addresses as $key => $address): ?>
                        <option value="<?php echo $address->id; ?>" data-address="<?php echo $address->title; ?>"
                          <?php echo !empty($invoice[0]->billaddressid) && $address->id == $invoice[0]->billaddressid ? 'selected="selected"' : ''; ?>>
                          <?php echo preg_split('/\r\n|\r|\n/', $address->title)[0]; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-selectbilladdress error-input"></div>
                </div>
                <?php echo get_textarea('billaddress', 6, 'endereço da fatura', $invoice[0]->billaddress, TRUE); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="group-title">prestações</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select($terms, 'terms', 'condições', FALSE, $invoice[0]->termsid, TRUE); ?>
              </div>
              <div class="column-33">
              </div>
              <div class="column-33">
              </div>
            </div>
          </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-creditmemo-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>