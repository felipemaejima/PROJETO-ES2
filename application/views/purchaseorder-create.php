<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-purchaseorders">
        <?php echo form_open('purchaseorder', array('id' => 'purchaseorder-create')); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title"><i class="ph ph-receipt"></i> Pedido de Compra</div>

            <div class="functions-tab tab-row">
              <button type="submit" class="btn-purple" id="submit-purchaseorder-create">criar</button>
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
                <div class="title">icms</div>
                <div class="icms">0.00</div>
              </div>
              <div class="row">
                <div class="title">ipi</div>
                <div class="ipi">0.00</div>
              </div>
              <div class="row">
                <div class="title">st</div>
                <div class="st">0.00</div>
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
            <?php echo get_input('text', 'supplier', 'fornecedor', '<i class="ph ph-share"></i>'); ?>
            <?php echo get_input('hidden', 'supplierid', 'supplier id'); ?>
            <?php echo get_input('hidden', 'suppliersimplesnacional', 'supplier simples nacional'); ?>
            <?php echo get_select(FALSE, 'contact', 'contato'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria'); ?>
            <?php echo get_input('text', 'deadline', 'entregar até'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações'); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($freighttypes, 'freighttype', 'tipo de frete'); ?>
            <?php echo get_input('text', 'carrier', 'transportadora', '<i class="ph ph-share"></i>'); ?>
            <?php echo get_input('hidden', 'carrierid', 'carrier id'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'freight', 'frete', '<i class="ph ph-arrows-clockwise calculate-freight"></i>'); ?>
            <?php echo get_input('text', 'discount', 'desconto', '<i class="ph ph-arrows-clockwise calculate-discount"></i>'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <br>
            <?php echo get_checkbox('externalfreight', 'frete externo'); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="items">itens</label> |
          <label class="tab-btn" data-toggle="billing">faturamento</label>
        </div>
        <div class="tab-wrapper">
          <div id="items" class="tab-wrapper-content" style="display: flex">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'item', 'inserir item'); ?>
              </div>
              <div class="column-33"></div>
              <div class="column-33"></div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 2850px; max-width: 100%;">
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
              </div>
            </div>
          </div>
          <div id="billing" class="tab-wrapper-content" style="display: none">
            <div class="group-title">endereço</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select(FALSE, 'selectbilladdress', 'endereço'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
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
              </div>
              <div class="column-33">
              </div>
            </div>

            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 600px; max-width: 100%;">
                  <div class="column" style="min-width:200px; padding-right: 1rem;">prestação</div>
                  <div class="column" style="min-width:200px; padding-right: 1rem;">data</div>
                  <div class="column" style="min-width:0px; padding-right: 1rem;"></div>
                  <div class="column" style="min-width:200px; padding-right: 1rem;">porcentagem</div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-purchaseorder-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
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

        <div class="column">
          <div class="column-100">
            <?php echo get_input('text', 'saleorder', 'pedido de venda'); ?>
          </div>
        </div>
        <button type="submit" class="btn-blue" id="submit-add-saleorder">salvar</button>
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