<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-services">
        <div class="title"><i class="ph ph-call-bell"></i> Atendimento</div>
        <?php echo form_open('service', array('id' => 'service-edit')); ?>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-service-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <div class="column-33 c-large c-medium c-small">
          <div class="form-input-content">
            <label for="createdfrom">criado de</label>
            <a href="<?php echo base_url('saleorder/' . $saleorder[0]->id); ?>">pedido de venda
              <?php echo $saleorder[0]->tranid; ?></a>
            <div class="error-createdfrom error-input"></div>
          </div>
          <?php echo get_input('hidden', 'createdfrom', 'criado de', FALSE, $saleorder[0]->id); ?>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $service[0]->id); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customer', 'cliente', FALSE, $service[0]->customername, TRUE); ?>
            <?php echo get_input('hidden', 'customername', 'cliente', FALSE, $service[0]->customername); ?>
            <?php echo get_input('hidden', 'customerid', 'cliente id', FALSE, $service[0]->customerid); ?>
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $service[0]->subsidiaryid, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'salesman', 'nome do vendedor', FALSE, $service[0]->salesmanname, TRUE); ?>
            <?php echo get_input('hidden', 'salesmanid', 'vendedor', FALSE, $service[0]->salesmanid); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $service[0]->comments); ?>
          </div>
        </div>
        <div class="group-title">informações adicionais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'servicedate', 'data do atendimento', FALSE,  date('d/m/Y', $service[0]->servicedate)); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php // echo get_select($servicestatus, 'status', 'status', FALSE, $service[0]->status); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
          </div>
        </div>
        <div class="group-title">envio</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'volumetype', 'tipo de volume', FALSE, $service[0]->volumetype); ?>
            <?php echo get_input('text', 'volumesquantity', 'volumes', FALSE, $service[0]->volumesquantity); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'netweight', 'peso liquido kg', FALSE, $service[0]->netweight); ?>
            <?php echo get_input('text', 'grossweight', 'peso bruto kg', FALSE, $service[0]->grossweight); ?>
          </div>
          <div class="column-33">
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($freighttypes, 'freighttype', 'tipo de frete', FALSE, $service[0]->freighttypeid); ?>
            <?php echo get_input('text', 'carrier', 'nome da transportadora', FALSE, $service[0]->carriername); ?>
            <?php echo get_input('hidden', 'carrier', 'transportadora', FALSE, $service[0]->carriername); ?>
            <?php echo get_input('hidden', 'carrierid', 'id transportadora', FALSE, $service[0]->carrierid); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'freight', 'frete', '', $service[0]->freight, TRUE); ?>
            <?php echo get_input('text', 'discount', 'desconto', '', $service[0]->discount, TRUE); ?>
          </div>
          <div class="column-33">
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="items">itens</label> |
          <label class="tab-btn" data-toggle="billing">faturamento</label> |
          <label class="tab-btn" data-toggle="systeminformation">informações do sistema</label>
        </div>
        <div class="tab-wrapper">
          <div id="items" class="tab-wrapper-content" style="display: flex">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
              </div>
              <div class="column-33"></div>
              <div class="column-33">
              </div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1250px; max-width: 100%;">
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">linha</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">item</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">unidade de medida</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">quantidade</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">estoque</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">atendimento pendente</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">separado</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">total atendido</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">atendido</div>
                </div>
                <?php $count = 0; ?>
                <?php foreach ($items as $key => $item): ?>
                  <div
                    class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?> <?php echo $item->isinactive == 'T' ? 'disabled' : ''; ?>"
                    style="min-width: 1250px; max-width: 100%; <?php echo $item->isinactive == 'T' ? 'display: none;' : ''; ?>">
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="linha">
                      <?php echo $item->itemline; ?>
                      <input type="hidden" name="itemline[]" value="<?php echo $item->itemline; ?>">
                      <input type="hidden" name="itemlineid[]" value="<?php echo $item->id; ?>">
                      <input type="hidden" name="itemncm[]" value="<?php echo $item->ncm; ?>">
                      <input type="hidden" name="itemncmdescription[]" value="<?php echo $item->ncmdescription; ?>">
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="item">
                      <a href="<?php echo site_url('item/' . $item->itemid); ?>" target="_blank" class="btn-link">
                        <?php echo $item->itemname; ?>
                      </a>
                      <input type="hidden" name="itemid[]" value="<?php echo $item->itemid; ?>">
                      <input type="hidden" name="itemname[]" value="<?php echo $item->itemname; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="unidade de medida">
                      <?php echo $item->saleunitname; ?>
                      <input type="hidden" name="itemsaleunitid[]" value="<?php echo $item->saleunitid; ?>">
                      <input type="hidden" name="itemsaleunitname[]" value="<?php echo $item->saleunitname; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="quantidade">
                      <?php echo $item->itemquantity; ?>
                      <input type="hidden" name="itemquantity[]" value="<?php echo $item->itemquantity; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="estoque">
                      <?php echo $item->stockquantity; ?>
                      <input type="hidden" name="itemstockquantity[]" value="<?php echo $item->stockquantity; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="atendimento pendente">
                      <?php echo $serviceitems[$key]->pendingserved; ?>
                      <input type="hidden" name="itempendingserved[]" value="<?php echo $serviceitems[$key]->pendingserved; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="separado">
                      <?php echo $item->committed; ?>
                      <input type="hidden" name="itemquantitycommitted[]" value="<?php echo $item->committed; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="total atendido">
                      <?php echo $serviceitems[$key]->servedtotal; ?>
                      <input type="hidden" name="itemtotalserved[]" value="<?php echo $serviceitems[$key]->servedtotal; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="atendido">
                      <div class="form-input-box">
                        <input type="text" name="itemquantityserved[]" placeholder="quantidade atendida" value="<?php echo $item->served; ?>">
                        <input type="hidden" name="possibleitemquantityserved[]" value="<?php echo $item->served; ?>">
                      </div>
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
                      <?php foreach($addresses as $key => $address): ?>
                        <option value="<?php echo $address->id; ?>" data-address="<?php echo $address->title; ?>"
                          <?php echo !!$service[0]->shippingaddressid && $address->id == $service[0]->shippingaddressid ? 'selected="selected"' : ''; ?>>
                          <?php echo preg_split('/\r\n|\r|\n/', $address->title)[0]; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-selectshippingaddress error-input"></div>
                </div>
                <?php echo get_textarea('shippingaddress', 6, 'endereço de entrega', $service[0]->shippingaddress, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
              <div class="form-input-content">
                  <label for="selectbilladdress">endereço de fatura</label>
                  <div class="form-input-box">
                    <select name="selectbilladdress">
                      <option value="">Escolha um(a) endereço</option>
                      <?php foreach($addresses as $key => $address): ?>
                        <option value="<?php echo $address->id; ?>" data-address="<?php echo $address->title; ?>"
                          <?php echo !!$service[0]->billaddressid && $address->id == $service[0]->billaddressid ? 'selected="selected"' : ''; ?>>
                          <?php echo preg_split('/\r\n|\r|\n/', $address->title)[0]; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-selectbilladdress error-input"></div>
                </div>
                <?php echo get_textarea('billaddress', 6, 'endereço da fatura', $service[0]->billaddress, TRUE); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
          </div>
          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('isinactive', 'inativo', TRUE, $service[0]->isinactive); ?>
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
          <button type="submit" class="btn-purple" id="submit-service-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>