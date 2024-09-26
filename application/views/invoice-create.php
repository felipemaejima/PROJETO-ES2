<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-invoices">
        <?php echo form_open('invoice', array('id' => 'invoice-create')); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title">
              <i class="ph ph-receipt"></i>
              Faturamento
            </div>
            <div class="functions-tab tab-row">
              <button type="submit" class="btn-purple" id="submit-invoice-create">criar</button>
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

        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customer', 'cliente'); ?>
            <?php echo get_input('hidden', 'customername', 'customer'); ?>
            <?php echo get_input('hidden', 'customerid', 'customer id'); ?>
            <?php echo get_select(FALSE, 'contact', 'contato'); ?>
            <?php echo get_input('text', 'customerpurchaseorder', 'pedido de compra do cliente'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria'); ?>
            <?php echo get_input('text', 'deadline', 'entregar até'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações do pedido'); ?>
          </div>
        </div>
        <div class="group-title">informações de venda</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'salesman', 'vendedor'); ?>
            <?php echo get_input('hidden', 'salesmanid', 'vendedor id'); ?>
            <?php echo get_input('text', 'saledate', 'data da venda'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('paymentcomments', 6, 'anotações do pagamento'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <br>
            <?php echo get_checkbox('excludecommission', 'excluir comissão'); ?>
          </div>
        </div>
        <div class="group-title">envio</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'volumetype', 'tipo de volume'); ?>
            <?php echo get_input('text', 'volumesquantity', 'volumes'); ?>

          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'netweight', 'peso liquido kg'); ?>
            <?php echo get_input('text', 'grossweight', 'peso bruto kg'); ?>
          </div>
          <div class="column-33">
            <?php echo get_textarea('servicecomments', 6, 'anotações do atendimento'); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($freighttypes, 'freighttype', 'tipo de frete'); ?>
            <?php echo get_input('text', 'carrier', 'transportadora'); ?>
            <?php echo get_input('hidden', 'carrierid', 'carrier id'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'freight', 'frete', '<i class="ph ph-arrows-clockwise calculate-freight"></i>'); ?>
            <?php echo get_input('text', 'discount', 'desconto', '<i class="ph ph-arrows-clockwise calculate-discount"></i>'); ?>
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
                  <?php echo get_select($operationtypes, 'operationtype', 'tipo de operação'); ?>
                </div>
                <div class="column-33 c-large c-medium c-small">
                  <!-- este campo deve ser obrigatório após gerar NF -->
                  <?php echo get_input('text', 'trafficguide', 'guia de tráfego'); ?>
                </div>
                <div class="column-33 c-large c-medium c-small">
                  <?php echo get_textarea('additionalinformation', 6, 'informações adicionais da nota'); ?>
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
                  <?php echo get_input('text', 'fiscaldocrefaccesskey', 'chave da NF-e referente'); ?>
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
                  <div class="column" style="min-width: 150px; padding-right: 1rem;"></div>
                </div>
              </div>
            </div>
          </div>
          <div id="billing" class="tab-wrapper-content" style="display: none">
            <div class="group-title">endereço</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select(FALSE, 'shippingaddressid', 'endereço'); ?>
                <?php echo get_textarea('shippingaddress', 6, 'endereço de entrega', FALSE, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select(FALSE, 'billaddressid', 'endereço'); ?>
                <?php echo get_textarea('billaddress', 6, 'endereço da fatura', FALSE, TRUE); ?>
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
                          data-timeqty="<?php echo $term->timeqty; ?>" data-leadtime="<?php echo $term->leadtime; ?>">
                          <?php echo $term->title; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-terms error-input"></div>
                </div>
              </div>
              <div class="column-33">
                <?php echo get_select($paymentmethods, 'paymentmethod', 'meio de pagamento'); ?>
              </div>
              <div class="column-33">
                <?php echo get_select(FALSE, 'account', 'conta'); ?>
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
              </div>
            </div>
          </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-invoice-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>