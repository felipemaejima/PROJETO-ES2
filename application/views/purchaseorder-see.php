<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-purchaseorders">
        <?php echo form_open('purchaseorder', array('id' => 'purchaseorder-edit')); ?>
        <div class="align-items">

          <div class="tab-column-title">
            <div class="title"><i class="ph ph-receipt"></i> Pedido de Compra
              <?php echo $purchaseorder[0]->tranid; ?>
              <div class="status"><?php echo $purchaseorder[0]->status; ?></div>
            </div>

            <div class="functions-tab">
              <div class="top-functions-tab">
                <a href="<?php echo base_url('purchaseorder/' . $this->uri->segment(2) . '?edit=T'); ?>"
                  class="btn-purple">editar</a>
                <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
              </div>

              <div class="bottom-functions-tab">
                <?php foreach ($currentstatus as $key => $value): ?>
                  <?php if ($key == 'receber'): ?>
                    <a href="<?php echo base_url('receipt?referer=' . $this->uri->segment(2)); ?>"
                      class="btn-gray">receber</a>
                  <?php else: ?>
                    <button data-status="<?php echo $key; ?>" class="btn-gray edit-status"><?php echo $value; ?></button>
                  <?php endif; ?>
                <?php endforeach; ?>

                <a href="<?php echo base_url('purchaseorder/duplicate?duplicate=T&referer=' . $this->uri->segment(2)); ?>"
                  target="_blank" rel="noopener noreferrer" class="btn-gray">duplicar</a>
              </div>
            </div>

            <div class="functions-tab">
              <div class="legal-infos">
                <?php if(!!$employee) : ?>
                  Criado por:
                  <?php echo $employee[0]->name; ?><br />
                <?php endif; ?>
                <?php if(array_key_exists('created', (array)$purchaseorder[0])) : ?>
                  Criado em:
                  <?php echo date('d/m/Y H:i', $purchaseorder[0]->created); ?><br />
                <?php endif; ?>
                <?php if ($purchaseorder[0]->updated): ?>
                  Editado em:
                  <?php echo date('d/m/Y H:i', $purchaseorder[0]->updated); ?>
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
                <div class="subtotal">
                  <?php echo $resumesubtotal[0]->linegrossvalue ? number_format($resumesubtotal[0]->linegrossvalue, 2, '.', '') : '0.00'; ?>
                </div>
              </div>
              <div class="row">
                <div class="title">desconto</div>
                <div class="discount">
                  <?php echo $purchaseorder[0]->discount ? number_format($purchaseorder[0]->discount, 2, '.', '') : '0.00'; ?>
                </div>
              </div>
              <div class="row">
                <div class="title">frete</div>
                <div class="freight">
                  <?php echo $purchaseorder[0]->freight ? number_format($purchaseorder[0]->freight, 2, '.', '') : '0.00'; ?>
                </div>
              </div>
              <div class="row">
                <div class="title">icms</div>
                <div class="icms">
                  <?php
                  $sum = 0;
                  foreach ($taxes as $key => $tax) {
                    if ($tax->taxname == "ICMS") {
                      $sum += $tax->taxvalue;
                    }
                  }
                  echo number_format($sum, 2, '.', '');
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="title">ipi</div>
                <div class="ipi">
                  <?php
                  $sum = 0;
                  foreach ($taxes as $key => $tax) {
                    if ($tax->taxname == "IPI") {
                      $sum += $tax->taxvalue;
                    }
                  }
                  echo number_format($sum, 2, '.', '');
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="title">st</div>
                <div class="st">
                  <?php
                  $sum = 0;
                  foreach ($taxes as $key => $tax) {
                    if ($tax->taxname == "ST") {
                      $sum += $tax->taxvalue;
                    }
                  }
                  echo number_format($sum, 2, '.', '');
                  ?>
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
                  <?php echo $resumetotal[0]->itemtotal ? number_format($resumetotal[0]->itemtotal, 2, '.', '') : '0.00'; ?>
                </div>
              </div>
              <i class="ph ph-equals"></i>
            </div>
          </div>
        </div>

        <?php echo get_input('hidden', 'id', 'ID', FALSE, $purchaseorder[0]->id); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'supplier', 'fornecedor', '<i class="ph ph-share"></i>', $purchaseorder[0]->suppliername, TRUE); ?>
            <?php echo get_input('hidden', 'supplierid', 'supplier id', FALSE, $purchaseorder[0]->supplierid); ?>
            <?php echo get_input('hidden', 'suppliersimplesnacional', 'supplier simples nacional'); ?>
            <div class="form-input-content">
              <label for="contact">contato</label>
              <div class="form-input-box">
                <select name="contact" disabled>
                  <option value="">Escolha um(a) contato</option>
                  <?php foreach ($relationships as $key => $contact): ?>
                    <option value="<?php echo $contact->id; ?>" data-title="<?php echo $contact->title; ?>"
                      data-email="<?php echo $contact->email; ?>" data-phone="<?php echo $contact->phone; ?>" <?php echo $purchaseorder[0]->contactid == $contact->id ? 'selected' : ''; ?>>
                      <?php echo $contact->name; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="error-contact error-input"></div>
              <?php if ($purchaseorder[0]->contactid): ?>
                <div class="contact-info">
                  <strong>Cargo:</strong>
                  <?php echo $purchaseorder[0]->contacttitle; ?><br />
                  <strong>E-mail:</strong>
                  <?php echo $purchaseorder[0]->contactemail; ?><br />
                  <strong>Telefone:</strong>
                  <?php echo $purchaseorder[0]->contactphone; ?><br />
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $purchaseorder[0]->subsidiaryid, TRUE); ?>
            <?php echo get_input('text', 'deadline', 'entregar até', FALSE, date('d/m/Y', $purchaseorder[0]->deadline), TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $purchaseorder[0]->comments, TRUE); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($freighttypes, 'freighttype', 'tipo de frete', FALSE, $purchaseorder[0]->freighttypeid, TRUE); ?>
            <?php echo get_input('text', 'carrier', 'transportadora', '<i class="ph ph-share"></i>', $purchaseorder[0]->carriername, TRUE); ?>
            <?php echo get_input('hidden', 'carrierid', 'carrier id', FALSE, $purchaseorder[0]->carrierid, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'freight', 'frete', FALSE, $purchaseorder[0]->freight, TRUE); ?>
            <?php echo get_input('text', 'discount', 'desconto', FALSE, $purchaseorder[0]->discount, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <br>
            <?php echo get_checkbox('externalfreight', 'frete externo', TRUE, !!($purchaseorder[0]->externalfreight == 'T') ? TRUE : FALSE); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="items">itens</label> |
          <label class="tab-btn" data-toggle="billing">faturamento</label> |
          <label class="tab-btn" data-toggle="taxs">impostos</label> |
          <label class="tab-btn" data-toggle="sharedlinks">registros relacionados</label> |
          <label class="tab-btn" data-toggle="systeminformation">informações do sistema</label>
        </div>
        <div class="tab-wrapper">
          <div id="items" class="tab-wrapper-content" style="display: flex">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
              </div>
              <div class="column-33 c-large c-medium c-small"></div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('isvisible', 'ver itens removidos'); ?>
              </div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 2750px; max-width: 100%;">
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">linha</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">item</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">código</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">unidade de medida</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">estoque atual</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">recebido</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">faturado</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">ultimo custo</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">quantidade</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">custo</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">valor bruto</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">desconto</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">frete</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">total</div>
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">ncm</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">pedido de venda</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">prazo de entrega</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">nota fiscal</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($items as $key => $item): ?>
                  <div
                    class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?> <?php echo $item->isinactive == 'T' ? 'disabled' : ''; ?>"
                    style="min-width: 2750px; max-width: 100%; <?php echo $item->isinactive == 'T' ? 'display: none;' : ''; ?>">
                    <div class="column" style="min-width: 100px; padding-right: 1rem;" title="linha">
                      <?php echo $item->line; ?>
                      <input type="hidden" name="itemline[]" value="<?php echo $item->line; ?>">
                      <input type="hidden" name="itemlineid[]" value="<?php echo $item->id; ?>">
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="item">
                      <a href="<?php echo site_url('item/' . $item->itemid); ?>" target="_blank" class="btn-link">
                        <?php echo $item->itemname; ?>
                      </a>
                      <input type="hidden" name="itemid[]" value="<?php echo $item->itemid; ?>">
                      <input type="hidden" name="itemname[]" value="<?php echo $item->itemname; ?>">
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="codigo">
                      <?php echo $item->manufacturercode; ?>
                      <input type="hidden" name="itemmanufacturercode[]" value="<?php echo $item->manufacturercode; ?>">
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="unidade de medida">
                      <?php echo $item->purchaseunitname; ?>
                      <input type="hidden" name="itempurchaseunitid[]" value="<?php echo $item->purchaseunitid; ?>">
                      <input type="hidden" name="itempurchaseunitname[]" value="<?php echo $item->purchaseunitname; ?>">
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="estoque atual">
                      <?php echo $item->linequantityonhand; ?>
                      <input type="hidden" name="itemquantityonhand[]" value="<?php echo $item->linequantityonhand; ?>">
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="recebido">
                      <?php echo $item->linequantityreceived; ?>
                      <input type="hidden" name="itemquantityreceived[]"
                        value="<?php echo $item->linequantityreceived; ?>">
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="faturado">
                      <?php echo $item->linequantitybilled; ?>
                      <input type="hidden" name="itemquantitybilled[]" value="<?php echo $item->linequantitybilled; ?>">
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="ultimo custo">
                      <?php echo $item->lastitemexpense; ?>
                      <input type="hidden" name="itemquantitybilled[]" value="<?php echo $item->lastitemexpense; ?>">
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="quantidade">
                      <div class="form-input-box">
                        <input type="text" name="itemquantity[]" placeholder="quantidade"
                          value="<?php echo $item->linequantity; ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="custo">
                      <div class="form-input-box">
                        <input type="text" name="itemexpense[]" placeholder="custo"
                          value="<?php echo $item->lineexpense; ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="valor bruto">
                      <div class="form-input-box">
                        <input type="text" name="itemgrossvalue[]" placeholder="valor bruto"
                          value="<?php echo $item->linegrossvalue; ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="desconto">
                      <div class="form-input-box">
                        <input type="text" name="itemdiscount[]" placeholder="desconto"
                          value="<?php echo $item->linediscount; ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="frete">
                      <div class="form-input-box">
                        <input type="text" name="itemfreight[]" placeholder="frete"
                          value="<?php echo $item->linefreight; ?>" disabled>
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
                      <input type="hidden" name="itemncm[]" value="<?php echo $item->ncm; ?>">
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="pedido de venda">
                      <a href="" class="btn-purple add-saleorder">ver pedidos</a>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="prazo de entrega">
                      <div class="form-input-box">
                        <input type="text" name="itemdeadline[]" placeholder="prazo de entrega"
                          value="<?php echo $item->deadline ? date('d/m/Y', $item->deadline) : ''; ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="nota fiscal">
                      <?php echo $item->fiscaldocnumber ?? ''; ?>
                    </div>
                    <div class="column align-right" style="min-width: 150px; padding-right: 1rem;" title="remover">
                    </div>
                    <?php if (!!$item->salesorders): ?>
                      <?php foreach (json_decode($item->salesorders) as $i => $value): ?>
                        <?php $salesorder = (object) $value; ?>
                        <input type="hidden" name="salesordersid[]" value="<?php echo $salesorder->referer; ?>"
                          <?php echo $i == 0 ? 'class="inventory-quantities"' : ''; ?>
                          data-line="<?php echo ($i + 1) . '-' . $item->line ; ?>">
                        <input type="hidden" name="salesorderstranid[]" value="<?php echo $salesorder->tranid; ?>"
                          <?php echo $i == 0 ? 'class="inventory-quantities"' : ''; ?>
                          data-line="<?php echo ($i + 1) . '-' . $item->line ; ?>">
                        <input type="hidden" name="salesordersquantities[]" value="<?php echo $salesorder->quantity; ?>"
                          <?php echo $i == 0 ? 'class="inventory-quantities" id="inventory-quantity-' . $item->line . '"' : ''; ?>
                          data-line="<?php echo ($i + 1) . '-' . $item->line ; ?>">
                        <input type="hidden" name="salesorderstitles[]" value="<?php echo $salesorder->title; ?>"
                          <?php echo $i == 0 ? 'class="inventory-quantities"' : ''; ?>
                          data-line="<?php echo ($i + 1) . '-' . $item->line ; ?>">
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="billing" class="tab-wrapper-content" style="display: none">
            <div class="group-title">endereço</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <div class="form-input-content">
                  <label for="selectbilladdress">endereço</label>
                  <div class="form-input-box">
                    <select name="selectbilladdress" disabled>
                      <option value="">Escolha um(a) endereço</option>
                      <?php foreach ($addresses as $key => $address): ?>
                        <option value="<?php echo $address->id; ?>" data-address="<?php echo $address->address; ?>" <?php echo $purchaseorder[0]->selectbilladdress == $address->id ? 'selected' : ''; ?>>
                          <?php echo $address->street . ', ' . $address->number; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-selectbilladdress error-input"></div>
                </div>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_textarea('billaddress', 6, 'endereço da fatura', $purchaseorder[0]->billaddress, TRUE); ?>
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
                          <?php echo $term->id == $purchaseorder[0]->termsid ? 'selected' : ''; ?>>
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

            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 800px; max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">prestação</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">data</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">porcentagem</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">valor da parcela</div>
                </div>
                <?php foreach ($installments as $key => $installment): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 800px; max-width: 100%;">
                    <div class="column " style="min-width: 200px; padding-right: 1rem;">
                      <a href="<?php echo base_url('purchaseorderinstallment/' . $installment->id) ?>"  target="_blank" class="btn-link">
                        Parcela <?php echo $installment->installment; ?>
                      </a>
                      <input type="hidden" name="installment[]" value="<?php echo $installment->installment; ?>">
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <div class="form-input-box">
                        <input type="text" name="installmentdeadline[]" placeholder="data da parcela"
                          value="<?php echo date('d/m/Y', $installment->deadline); ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <div class="form-input-box">
                        <input type="text" name="installmentpercentage[]" placeholder="porcentagem da parcela"
                          value="<?php echo $installment->percentage; ?>" disabled>
                      </div>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <div class="form-input-box">
                        <input type="text" name="installmentpercentage[]" placeholder="valor da parcela"
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
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1400px; max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">item</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">linha</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">imposto</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">valor liquido</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">base de calculo</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">aliquota</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">valor do imposto</div>
                </div>
                <?php foreach ($taxes as $key => $tax): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 1400px; max-width: 100%;">
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $tax->itemname; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $tax->line; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $tax->taxname; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $tax->linenetvalue; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $tax->calculationbase; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $tax->taxname == 'ST' ? $tax->aliquot : $tax->aliquot . '%'; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $tax->taxvalue; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <div id="sharedlinks" class="tab-wrapper-content" style="display: none">
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 800px; max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">data</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">tipo</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">editado</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($sharedlinks as $key => $sharedlink): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 800px; max-width: 100%;">
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo date('d/m/Y', $sharedlink['created']); ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <a href="<?php echo $sharedlink['link']; ?>" target="_blank" class="btn-link">
                        <?php echo $sharedlink['name']; ?>
                      </a>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $sharedlink['updated'] ? date('d/m/Y', $sharedlink['updated']) : ''; ?>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33">
                <?php echo get_checkbox('isinactive', 'inativo', TRUE, $purchaseorder[0]->isinactive); ?>
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

        <div class="functions-tab">
          <div class="top-functions-tab">
            <a href="<?php echo base_url('purchaseorder/' . $this->uri->segment(2) . '?edit=T'); ?>"
              class="btn-purple">editar</a>
            <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
          </div>

          <div class="bottom-functions-tab">
            <?php foreach ($currentstatus as $key => $value): ?>
              <?php if ($key == 'receber'): ?>
                <a href="<?php echo base_url('receipt?referer=' . $this->uri->segment(2)); ?>"
                  class="btn-gray">receber</a>
              <?php else: ?>
                <button data-status="<?php echo $key; ?>" class="btn-gray edit-status"><?php echo $value; ?></button>
              <?php endif; ?>
            <?php endforeach; ?>

            <a href="<?php echo base_url('purchaseorder/duplicate?duplicate=T&referer=' . $this->uri->segment(2)); ?>"
              target="_blank" rel="noopener noreferrer" class="btn-gray">duplicar</a>
          </div>
        </div>

        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<div id="modal-add-saleorder" class="modal">
  <div class="modal-large" style="min-width: 900px">
    <div class="modal-header">
      <div class="close">
        <i class="ph ph-x"></i>
      </div>
    </div>
    <div class="modal-content">
      <div class="box-infos">
        <?php echo form_open('modal-add-saleorder', array('id' => 'modal-add-saleorder')); ?>
        <div class="form-input-content">
          <div class="success-message"></div>
        </div>

        <?php echo get_input('hidden', 'max-quantity', 'quantidade maxima'); ?>
        <?php echo get_input('hidden', 'linereferer', 'linha do item'); ?>

        <div id="salesorders-quantities" class="table">
          <div class="table-head" style="min-width: 800px; max-width: 100%;">
            <div class="column" style="min-width: 50px; padding-right: 1rem;"> </div>
            <div class="column" style="min-width: 500px; padding-right: 1rem;">referente a</div>
            <div class="column" style="min-width: 300px; padding-right: 1rem;">quantidade</div>
          </div>
        </div>

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
