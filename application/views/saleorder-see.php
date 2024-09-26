<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-saleorders">
      <?php echo form_open('saleorder', array('id' => 'saleorder-edit')); ?>

      <div class="align-items">
        <div class="tab-column-title">
          <div class="title">
            <i class="ph ph-receipt"></i> Pedido de Venda
            <?php echo $saleorder[0]->tranid; ?>
            <div class="status"><?php echo $saleorder[0]->status; ?></div>
          </div>
            <div class="functions-tab tab-row" style="flex-wrap: wrap;">
              <a href="<?php echo base_url('saleorder/' . $this->uri->segment(2) . '?edit=T'); ?>"
              class="btn-purple">editar</a>

              <button class="btn-purple print-saleorder" id="print-saleorder">imprimir</button>
              <button class="btn-purple internalprint-saleorder" id="internalprint-saleorder">imprimir interno</button>

              <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>

              <?php if (!in_array($saleorder[0]->status, ['aprovação pendente', 'cancelado', 'fechado'])): ?>
                <a href="<?php echo base_url('separation?referer=' . $this->uri->segment(2)); ?>"
                class="btn-gray">separar</a>
                <a href="<?php echo base_url('service?referer=' . $this->uri->segment(2)); ?>"
                class="btn-gray">atender</a>
              <?php endif; ?>

              <?php foreach($status as $statusname => $action): ?>
                <button data-status="<?php echo $statusname; ?>" class="btn-gray edit-status"><?php echo $action; ?></button>
              <?php endforeach; ?>

            </div>

            <div class="functions-tab">
              <div class="legal-infos">
                Criado por:
                <?php echo $employee[0]->name; ?><br />
                Criado em:
                <?php echo date('d/m/Y H:i', $saleorder[0]->created); ?><br />
                <?php if ($saleorder[0]->updated): ?>
                  Editado em:
                  <?php echo date('d/m/Y H:i', $saleorder[0]->updated); ?>
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
                <div class="subtotal"><?php echo $saleorder[0]->itemtotal ? number_format($saleorder[0]->itemtotal, 2, '.', '') : '0.00'; ?></div>
              </div>
              <div class="row">
                <div class="title">desconto</div>
                <div class="discount"><?php echo $saleorder[0]->discount ? number_format($saleorder[0]->discount, 2, '.', '') : '0.00'; ?></div>
              </div>
              <div class="row">
                <div class="title">frete</div>
                <div class="freight"><?php echo $saleorder[0]->freight ? number_format($saleorder[0]->freight, 2, '.', '') : '0.00'; ?></div>
              </div>
              <div class="row">
                <hr />
              </div>
            </div>
            <div class="resume-footer">
              <div class="row">
                <div class="title">total</div>
                <div class="total"><?php echo $saleorder[0]->itemtotal ? number_format((float)$saleorder[0]->itemtotal + (float)$saleorder[0]->freight - (float)$saleorder[0]->discount, 2, '.', '') : '0.00'; ?></div>
              </div>
              <i class="ph ph-equals"></i>
            </div>
          </div>
        </div>

        <?php echo get_input('hidden', 'id', 'ID', FALSE, $saleorder[0]->id, TRUE); ?>
        <input type="hidden" name="page" value="internalsaleorder">

        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customer', 'cliente', '<i class="ph ph-share"></i>', $saleorder[0]->customername, TRUE, base_url('customer/' . $saleorder[0]->customerid)); ?>
            <?php echo get_input('hidden', 'customerid', 'customer id', FALSE, $saleorder[0]->customerid, TRUE); ?>
            <?php echo get_select($relationships, 'contact', 'contato', FALSE, $saleorder[0]->contactid, TRUE); ?>
            <?php echo get_input('text', 'customerpurchaseorder', 'pedido de compra', FALSE, $saleorder[0]->customerpurchaseorder, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $saleorder[0]->subsidiary, TRUE); ?>
            <?php echo get_input('text', 'deadline', 'entregar até', FALSE, $saleorder[0]->deadline != 0 ? date('d/m/Y', $saleorder[0]->deadline) : FALSE, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $saleorder[0]->comments, TRUE); ?>
          </div>
        </div>
        <div class="group-title">informações de venda</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'salesman', 'vendedor', FALSE, $saleorder[0]->salesmanname, TRUE); ?>
            <?php echo get_input('hidden', 'salesmanid', 'vendedor id', FALSE, $saleorder[0]->salesmanid, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'saledate', 'data da venda', FALSE, $saleorder[0]->saledate != 0 ? date('d/m/Y', $saleorder[0]->saledate) : FALSE, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('excludecommission', 'excluir comissão', TRUE, $saleorder[0]->excludecommission == 'T' ? TRUE : FALSE); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($freighttypes, 'freighttype', 'tipo de frete', FALSE, $saleorder[0]->freighttypeid, TRUE); ?>
            <?php echo get_input('text', 'carrier', 'transportadora', '<i class="ph ph-share"></i>', $saleorder[0]->carriername, TRUE, base_url('carrier/' . $saleorder[0]->carrierid)); ?>
            <?php echo get_input('hidden', 'carrierid', 'carrier id', FALSE, $saleorder[0]->carrierid, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'freight', 'frete', '<i class="ph ph-arrows-clockwise calculate-freight"></i>', $saleorder[0]->freight, TRUE); ?>
            <?php echo get_input('text', 'discount', 'desconto', '<i class="ph ph-arrows-clockwise calculate-discount"></i>', $saleorder[0]->discount, TRUE); ?>
          </div>
          <div class="column-33">

          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="items">itens</label> |
          <label class="tab-btn" data-toggle="billing">faturamento</label> |
          <label class="tab-btn" data-toggle="sharedlinks">registros relacionados</label> |
          <label class="tab-btn" data-toggle="taxs">impostos</label> |
        </div>
        <div class="tab-wrapper">
        <div id="items" class="tab-wrapper-content" style="display: flex">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'item', 'inserir item', FALSE, FALSE, TRUE); ?>
              </div>
              <div class="column-33"></div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('isvisible', 'ver itens removidos'); ?>
              </div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 2170px; max-width: 100%;">
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
                  <div class="column" style="min-width: 220px; padding-right: 1rem;"></div>
                </div>
                <?php
                 $count = 1;
                ?>
                <?php foreach ($items as $key => $item): ?>
                  <?php $isreplace = in_array($item->id, array_column((array) $itemsreplace, 'replacedby')); ?>
                  <div class="table-content <?php echo $count % 2 == 0  ? 'table-content-color' : ''; ?>
                   <?php echo $item->isinactive == 'T' ? 'disabled' : ''; ?>
                   <?php echo $item->isinactive == 'T' && $item->replacedby ? 'table-content-replaced' : ''  ?>"
                    style="min-width: 2170px; max-width: 100%; <?php echo $item->isinactive == 'T' && !$item->replacedby ? 'display: none;' : ''; ?>"
                    >
                    <?php if ($isreplace): ?>
                      <div class="column" style="min-width: 40px;">
                        <i class="ph ph-arrow-elbow-down-right"></i>
                      </div>
                    <?php endif; ?>
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
                          value="<?php echo $item->itemquantity; ?>" disabled>
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
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="informações adicionais">
                      <div class="form-input-box">
                        <input type="text" name="additionalinformation[]" placeholder="informações adicionais"
                          value="<?php echo $item->additionalinformation; ?>" disabled>
                      </div>
                    </div>
                    <input type="hidden" name="itemlineid[]" value="<?php echo $item->id; ?>">
                    <div class="column align-right" style="min-width: 150px;" title="remover">
                    </div>
                  </div>
                  <?php if (!$item->replacedby && $item->isinactive == 'F') $count++; ?>
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
                    <select name="selectshippingaddress" disabled>
                      <option value="">Escolha um(a) endereço</option>
                      <?php foreach($addresses as $key => $address): ?>
                        <option value="<?php echo $address->id; ?>" data-address="<?php echo $address->title; ?>"
                          <?php echo !!$saleorder[0]->shippingaddressid && $address->id == $saleorder[0]->shippingaddressid ? 'selected="selected"' : ''; ?>>
                          <?php echo preg_split('/\r\n|\r|\n/', $address->title)[0]; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-selectshippingaddress error-input"></div>
                </div>
                <?php echo get_textarea('shippingaddress', 6, 'endereço de entrega', $saleorder[0]->shippingaddress, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
              <div class="form-input-content">
                  <label for="selectbilladdress">endereço de fatura</label>
                  <div class="form-input-box">
                    <select name="selectbilladdress" disabled>
                      <option value="">Escolha um(a) endereço</option>
                      <?php foreach($addresses as $key => $address): ?>
                        <option value="<?php echo $address->id; ?>" data-address="<?php echo $address->title; ?>"
                          <?php echo !!$saleorder[0]->billaddressid && $address->id == $saleorder[0]->billaddressid ? 'selected="selected"' : ''; ?>>
                          <?php echo preg_split('/\r\n|\r|\n/', $address->title)[0]; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-selectbilladdress error-input"></div>
                </div>
                <?php echo get_textarea('billaddress', 6, 'endereço da fatura', $saleorder[0]->billaddress, TRUE); ?>
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
                    <select name="terms" disabled>
                      <option value="">Escolha um(a) condições</option>
                      <?php foreach ($terms as $term): ?>
                        <option value="<?php echo $term->id; ?>" data-installments="<?php echo $term->installments; ?>"
                          data-timeqty="<?php echo $term->timeqty; ?>" data-leadtime="<?php echo $term->leadtime; ?>"
                          <?php echo !!$saleorder[0]->termsid && $term->id == $saleorder[0]->termsid ? 'selected="selected"' : ''; ?>>
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
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1400px; max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">item</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">linha</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">imposto</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">valor líquido</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">base de cálculo</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">alíquota</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">valor do imposto</div>
                </div>
                <?php foreach ($taxes as $key => $tax): ?>
                  <?php $taxclass = strtolower(str_replace(' ', '', $tax->taxname)); ?>
                  <div
                    class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?> <?php echo 'tax-' . $taxclass; ?> "
                    data-line="<?php echo $tax->line ?>" style="min-width: 1400px; max-width: 100%;">
                    <div class="column taxitemname" style="min-width: 200px; padding-right: 1rem;">
                      <span><?php echo $tax->itemname; ?></span>
                    </div>
                    <div class="column taxitemline" style="min-width: 200px; padding-right: 1rem;">
                      <span><?php echo $tax->line; ?></span>
                    </div>
                    <div class="column taxname" style="min-width: 200px; padding-right: 1rem;">
                      <span><?php echo $tax->taxname; ?></span>
                    </div>
                    <div class="column taxlinenetvalue" style="min-width: 200px; padding-right: 1rem;">
                      <span><?php echo $tax->linenetvalue; ?></span>
                    </div>
                    <div class="column taxcalculationbase" style="min-width: 200px; padding-right: 1rem;">
                      <span><?php echo $tax->calculationbase; ?></span>
                    </div>
                    <div class="column taxaliquot" style="min-width: 200px; padding-right: 1rem;">
                      <span><?php echo $tax->aliquot; ?></span>
                    </div>
                    <div class="column column-15 taxvalue" style="min-width: 200px; padding-right: 1rem;">
                      <span><?php echo $tax->taxvalue; ?></span>
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
        <a href="<?php echo base_url('saleorder/' . $this->uri->segment(2) . '?edit=T'); ?>"
        class="btn-purple">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
