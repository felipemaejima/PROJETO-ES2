<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-estimates">
        <?php echo form_open('estimate', array('id' => 'estimate-create')); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title"><i class="ph ph-receipt"></i> Orçamento</div>

            <div class="functions-tab tab-row">
              <button type="submit" class="btn-purple" id="submit-estimate-create">criar</button>
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
                <div class="subtotal">0.00</div>
              </div>
              <div class="row">
                <div class="title">desconto</div>
                <div class="discount">0.00</div>
              </div>
              <div class="row">
                <div class="title">frete</div>
                <div class="freight">0.00</div>
              </div>
              <div class="row">
                <hr />
              </div>
            </div>
            <div class="resume-footer">
              <div class="row">
                <div class="title">total</div>
                <div class="total">0.00</div>
              </div>
              <i class="ph ph-equals"></i>
            </div>
          </div>
        </div>

        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customer', 'cliente'); ?>
            <?php echo get_input('hidden', 'customerid', 'cliente id'); ?>
            <?php echo get_input('hidden', 'customerfactor', 'cliente factor'); ?>
            <?php echo get_select(FALSE, 'contact', 'contato'); ?>
            <?php echo get_input('text', 'salesman', 'vendedor', FALSE, $salesman); ?>
            <?php echo get_input('hidden', 'salesmanid', 'vendedor id', FALSE, $salesmanid); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customerpurchaseorder', 'pedido de compra', FALSE, FALSE); ?>
            <?php echo get_input('text', 'deadline', 'prazo de entrega'); ?>
            <?php echo get_input('text', 'validity', 'validade do orçamento', FALSE, date('d/m/Y', strtotime('+15 days')), TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações'); ?>
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
            <?php echo get_input('text', 'freight', 'frete', ''); ?>
            <?php echo get_input('text', 'discount', 'desconto', ''); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php
            if ($permission) {
              echo get_checkbox('freightrenegotiation', 'renegociação de frete');
            } else {
              echo get_input('hidden', 'freightrenegotiation', 'renegociação de frete');
            }
            ?>
            <?php echo get_checkbox('customerapproval', 'aprovação do cliente'); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="items">itens</label> |
          <label class="tab-btn" data-toggle="billing">faturamento</label> |
        </div>
        <div class="tab-wrapper" style="width: 100%">
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
                <div class="table-head" style="min-width: 2730px; max-width: 100%;">
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
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">descrição</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;"></div>
                </div>
              </div>
            </div>
          </div>
          <div id="billing" class="tab-wrapper-content" style="display: none">
            <div class="group-title">endereço</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select(FALSE, 'selectshippingaddress', 'endereço'); ?>
                <?php echo get_textarea('shippingaddress', 6, 'endereço de entrega', FALSE, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select(FALSE, 'selectbilladdress', 'endereço'); ?>
                <?php echo get_textarea('billaddress', 6, 'endereço da fatura', FALSE, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
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
              </div>
              <div class="column-33">
              </div>
            </div>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-estimate-create">criar</button>
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
    <div id="editor" style="min-height: 250px; z-index: 10">
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn-purple" id="alter-description">Alterar</button>
  </div>
</div>
