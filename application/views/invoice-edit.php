<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-invoices">
        <?php echo form_open('invoice', array('id' => 'invoice-edit')); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title">
              <i class="ph ph-receipt"></i> Fatura
              <?php echo $invoice[0]->tranid; ?>
              <div class="status"><?php echo $invoice[0]->status; ?></div>
            </div>
            <div class="functions-tab tab-row">
              <button type="submit" class="btn-purple" id="submit-invoice-edit">salvar</button>
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
                  <?php echo $invoice[0]->itemtotal ? $invoice[0]->itemtotal : '0.00'; ?>
                </div>
              </div>
              <div class="row">
                <div class="title">desconto</div>
                <div class="discount">
                  <?php echo $invoice[0]->discount ? $invoice[0]->discount : '0.00'; ?>
                </div>
              </div>
              <div class="row">
                <div class="title">frete</div>
                <div class="freight">
                  <?php echo $invoice[0]->freight ? $invoice[0]->freight : '0.00'; ?>
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
                  <?php echo $invoice[0]->itemtotal ? number_format((float) $invoice[0]->itemtotal + (float) $invoice[0]->freight - (float) $invoice[0]->discount, 2, '.', '') : '0.00'; ?>
                </div>
              </div>
              <i class="ph ph-equals"></i>
            </div>
          </div>
        </div>

        <?php if (!!$invoice[0]->createdfrom) : ?>
        <div class="column-33 c-large c-medium c-small">
          <div class="form-input-content">
            <label for="createdfrom">criado de</label>
            <a href="<?php echo base_url('saleorder/' . $invoice[0]->createdfrom); ?>">pedido de venda
              <?php echo $saleorder[0]->tranid; ?></a>
            <div class="error-createdfrom error-input"></div>
          </div>
          <?php echo get_input('hidden', 'createdfrom', 'criado de', FALSE, $invoice[0]->createdfrom); ?>
        </div>
        <?php endif; ?>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $invoice[0]->id); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customer', 'cliente', FALSE, $invoice[0]->customername, TRUE); ?>
            <?php echo get_input('hidden', 'customername', 'customer', FALSE, $invoice[0]->customername); ?>
            <?php echo get_input('hidden', 'customerid', 'customer id', FALSE, $invoice[0]->customerid); ?>
            <?php echo get_select($relationships, 'contact', 'contato', FALSE, $invoice[0]->contactid); ?>
            <?php echo get_input('text', 'customerpurchaseorder', 'pedido de compra do cliente', FALSE, $invoice[0]->customerpurchaseorder); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $invoice[0]->subsidiaryid, TRUE); ?>
            <?php echo get_input('hidden', 'subsidiaryid', 'id subsidiaria', FALSE, $invoice[0]->subsidiaryid); ?>
            <?php echo get_input('hidden', 'subsidiaryname', 'subsidiaria', FALSE, $invoice[0]->subsidiaryname); ?>
            <?php echo get_input('text', 'deadline', 'entregar até', FALSE, $invoice[0]->deadline != 0 ? date('d/m/Y', $invoice[0]->deadline) : FALSE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações do pedido', $invoice[0]->comments); ?>
          </div>
        </div>
        <div class="group-title">informações de venda</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'salesman', 'vendedor', FALSE, $invoice[0]->salesmanname); ?>
            <?php echo get_input('hidden', 'salesmanid', 'vendedor id', FALSE, $invoice[0]->salesmanid); ?>
            <?php echo get_input('text', 'saledate', 'data da venda', FALSE, $invoice[0]->saledate != 0 ? date('d/m/Y', $invoice[0]->saledate) : FALSE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('paymentcomments', 6, 'anotações do pagamento', $invoice[0]->paymentcomments); ?>
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
            <?php echo get_textarea('servicecomments', 6, 'anotações do atendimento', $invoice[0]->comments); ?>
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
          <label class="tab-btn" data-toggle="taxs">impostos</label>
        </div>
        <div class="tab-wrapper">
          <div id="nfe" class="tab-wrapper-content" style="display: flex">
            <div class="group-title">informações da fatura</div>
            <!-- adicionar campos carta de correção e aliquota -->
             <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select($operationtypes, 'operationtype', 'tipo de operação', FALSE, $invoice[0]->operationtypeid); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <!-- este campo deve ser obrigatório após gerar NF -->
                <?php echo get_input('text', 'trafficguide', 'guia de tráfego', FALSE, $invoice[0]->trafficguide); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_textarea('additionalinformation', 6, 'informações adicionais da nota', $invoice[0]->additionalinformation); ?>
              </div>
            </div>
            <div class="group-title">informações NF-e</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'fiscaldocnumber', 'número da NF-e', FALSE, $invoice[0]->fiscaldocnumber ); ?>
                <?php echo get_input('text', 'fiscaldocdate', 'data de autorizacão', FALSE, $invoice[0]->fiscaldocdate ? date('d/m/Y H:i:s', $invoice[0]->fiscaldocdate) : ''); ?>
                <?php echo get_input('text', 'fiscaldocsenddate', 'data de envio', FALSE, $invoice[0]->fiscaldocsenddate ? date('d/m/Y H:i:s', $invoice[0]->fiscaldocsenddate) : ''); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'fiscaldocaccesskey', 'chave de acesso', FALSE, $invoice[0]->fiscaldocaccesskey); ?>
                <?php echo get_input('text', 'fiscaldocstatus', 'status da NF-e', FALSE, $invoice[0]->fiscaldocstatus); ?>
                <?php echo get_input('text', 'fiscaldocrefaccesskey', 'chave da NF-e referente', FALSE, $invoice[0]->fiscaldocrefaccesskey); ?>
              </div>
              <div class="column-33">
                <?php echo get_input('text', 'fiscaldoccancellationdate', 'data de cancelamento', FALSE, $invoice[0]->fiscaldoccancellationdate ? date('d/m/Y H:i:s', $invoice[0]->fiscaldoccancellationdate) : ''); ?>
                <?php echo get_input('text', 'fiscaldocreturnmessage', 'mensagem de retorno', FALSE, $invoice[0]->fiscaldocreturnmessage); ?>
              </div>
            </div>
          </div>
          <div id="items" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'item', 'inserir item'); ?>
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
                      <input type="hidden" name="itemlineid[]" value="<?php echo $item->id; ?>">
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
                          value="<?php echo $item->itemquantity; ?>">
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
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="informações adicionais do item">
                      <div class="form-input-box">
                        <input type="text" name="itemadditionalinformation[]" placeholder="informações adicionais do item"
                          value="<?php echo $item->additionalinformation; ?>">
                      </div>
                    </div>
                    <input type="hidden" name="saleorderlineitem[]" value="<?php echo $item->saleorderlineitem ?? ''; ?>">
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
                <div class="form-input-content">
                  <label for="terms">condições</label>
                  <div class="form-input-box">
                    <!-- <select name="terms"> -->
                    <select name="terms" disabled>
                      <option value="">Escolha um(a) condições</option>
                      <?php foreach ($terms as $term): ?>
                        <option value="<?php echo $term->id; ?>" data-installments="<?php echo $term->installments; ?>"
                          data-timeqty="<?php echo $term->timeqty; ?>" data-leadtime="<?php echo $term->leadtime; ?>"
                          <?php echo $term->id == $invoice[0]->termsid ? 'selected' : ''; ?>>
                          <?php echo $term->title; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-terms error-input"></div>
                </div>
              </div>
              <div class="column-33">
                <?php echo get_select($paymentmethods, 'paymentmethod', 'meio de pagamento', FALSE, $invoice[0]->paymentmethodid); ?>
              </div>
              <div class="column-33">
                <?php echo get_select($accounts, 'account', 'conta', FALSE, $invoice[0]->accountid); ?>
              </div>
            </div>

            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 600px; max-width: 100%;">
                  <div class="column" style="min-width:200px; padding-right: 1rem;">prestação</div>
                  <div class="column" style="min-width:200px; padding-right: 1rem;">data</div>
                  <div class="column" style="min-width:200px; padding-right: 1rem;">porcentagem</div>
                  <div class="column" style="min-width:200px; padding-right: 1rem;">valor da parcela</div>
                </div>
                <?php
                if (isset($validpayment->days)) {
                  foreach ($validpayment->days as $key => $day) {
                    echo get_input('hidden', 'validpaymentday[]', 'validpaymentday', FALSE, $day ?? '');
                  }
                }
                ?>
                <?php foreach ($installments as $key => $installment): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 800px; max-width: 100%;">
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <a href="<?php echo base_url('invoiceinstallment/' . $installment->id) ?>"  target="_blank" class="btn-link">
                        Parcela <?php echo $installment->installment; ?>
                      </a>
                      <input type="hidden" name="installment[]" value="<?php echo $installment->installment; ?>">
                    </div>
                    <div class="column " style="min-width: 200px; padding-right: 1rem;">
                      <div class="form-input-box">
                        <input type="text" name="installmentdeadline[]" placeholder="data da parcela"
                          value="<?php echo date('d/m/Y', $installment->deadline); ?>" <?php echo $caneditinstallments ? '' : 'disabled'; ?>>
                      </div>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <div class="form-input-box">
                        <input type="text" name="installmentpercentage[]" placeholder="porcentagem da parcela"
                          value="<?php echo $installment->percentage; ?>" <?php echo $caneditinstallments ? '' : 'disabled'; ?>>
                      </div>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <div class="form-input-box">
                        <input type="text" name="installmenttotal[]" placeholder="valor da parcela"
                        value="<?php echo $installment->total; ?>" disabled>
                      </div>
                    </div>
                    <input type="hidden" name="installmentid[]" value="<?php echo $installment->id; ?>">
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="taxs" class="tab-wrapper-content" style="display: none">
            <div class="column column-20 c-large c-medium c-small">
              <?php echo get_input('text', '', 'calcular impostos', '<i class="ph ph-arrows-clockwise calculate-tax"></i>', NULL, TRUE); ?>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1400px; max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">item</div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">linha</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">imposto</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">valor liquido</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">base de calculo</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">aliquota</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">valor do imposto</div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">cst</div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">cfop</div>
                </div>
                <?php foreach ($taxes as $key => $tax): ?>
                  <?php $taxclass = strtolower(str_replace(' ', '', $tax->taxname)); ?>
                  <div
                    class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?> <?php echo 'tax-' . $taxclass; ?> "
                    data-line="<?php echo $tax->line ?>" style="min-width: 1400px; max-width: 100%;">
                    <div class="column taxitemname" style="min-width: 200px; padding-right: 1rem;">
                      <span><?php echo $tax->itemname; ?></span>
                    </div>
                    <div class="column taxitemline" style="min-width: 100px; padding-right: 1rem;">
                      <span><?php echo $tax->line; ?></span>
                    </div>
                    <div class="column taxname" style="min-width: 150px; padding-right: 1rem;">
                      <span><?php echo $tax->taxname; ?></span>
                    </div>
                    <div class="column taxlinenetvalue" style="min-width: 200px; padding-right: 1rem;">
                      <span><?php echo $tax->linenetvalue; ?></span>
                    </div>
                    <div class="column taxcalculationbase" style="min-width: 200px; padding-right: 1rem;">
                      <span><?php echo $tax->calculationbase; ?></span>
                    </div>
                    <div class="column taxaliquot" style="min-width: 150px; padding-right: 1rem;">
                      <span><?php echo $tax->aliquot; ?></span>
                    </div>
                    <div class="column column-15 taxvalue" style="min-width: 200px; padding-right: 1rem;">
                      <span><?php echo $tax->taxvalue; ?></span>
                    </div>
                    <div class="column column-15 cst" style="min-width: 100px; padding-right: 1rem;">
                      <span><?php echo $tax->cst; ?></span>
                    </div>
                    <div class="column column-15 cfop" style="min-width: 100px; padding-right: 1rem;">
                      <span><?php echo $tax->cfop; ?></span>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-invoice-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
