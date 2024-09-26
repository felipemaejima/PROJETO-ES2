<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-separations">
        <div class="title"><i class="ph ph-call-bell"></i> Separação</div>
        <?php echo form_open('separation', array('id' => 'separation-create')); ?>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-separation-create">criar</button>
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
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $saleorder[0]->id); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customer', 'cliente', FALSE, $saleorder[0]->customername, TRUE); ?>
            <?php echo get_input('hidden', 'customername', 'cliente', FALSE, $saleorder[0]->customername); ?>
            <?php echo get_input('hidden', 'customerid', 'cliente id', FALSE, $saleorder[0]->customerid); ?>
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $saleorder[0]->subsidiary, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações'); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="items">itens</label> |
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
                <div class="table-head" style="min-width: 1375px; max-width: 100%;">
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">linha</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">item</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">quantidade</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">estoque</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">atendido</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">encomendado</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">separado</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">preço</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">custo</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">ncm</div>
                </div>
                <?php $count = 0; ?>
                <?php foreach ($items as $key => $item): ?>
                  <div
                    class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?> <?php echo $item->isinactive == 'T' ? 'disabled' : ''; ?>"
                    style="min-width: 1375px; max-width: 100%; <?php echo $item->isinactive == 'T' ? 'display: none;' : ''; ?>">
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="linha">
                      <?php echo $item->itemline; ?>
                      <input type="hidden" name="itemline[]" value="<?php echo $item->itemline; ?>">
                      <input type="hidden" name="itemlineid[]" value="<?php echo $item->id; ?>">
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="item">
                      <a href="<?php echo site_url('item/' . $item->itemid); ?>" target="_blank" class="btn-link">
                        <?php echo $item->itemname; ?>
                      </a>
                      <input type="hidden" name="itemid[]" value="<?php echo $item->itemid; ?>">
                      <input type="hidden" name="itemname[]" value="<?php echo $item->itemname; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="quantidade">
                      <?php echo $item->itemquantity; ?>
                      <input type="hidden" name="itemquantity[]" value="<?php echo $item->itemquantity; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="estoque">
                      <?php echo $item->stockquantity; ?>
                      <input type="hidden" name="itemstockquantity[]" value="<?php echo $item->stockquantity; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="atendido">
                      0
                      <input type="hidden" name="itemquantityserved[]" value="0">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="encomendado">
                      <?php echo $item->onorder; ?>
                      <input type="hidden" name="itemquantityonorder[]" value="<?php echo $item->onorder; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="separado">
                      <div class="form-input-box">
                        <input type="text" name="itemquantitycommitted[]" placeholder="0" value="">
                      </div>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="preço">
                      <?php echo $item->itemprice; ?>
                      <input type="hidden" name="itemprice[]" value="<?php echo $item->itemprice; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="custo">
                      <?php echo $item->convertedexpense ? $item->convertedexpense : '0.00'; ?>
                      <input type="hidden" name="itemexpense[]" value="<?php echo $item->convertedexpense ? $item->convertedexpense : '0.00'; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="ncm">
                      <?php echo $item->ncm; ?>
                      <input type="hidden" name="itemncm[]" value="<?php echo $item->ncm; ?>">
                      <input type="hidden" name="itemncmdescription[]" value="<?php echo $item->ncmdescription; ?>">
                    </div>
                  </div>
                  <?php $count++; ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('isinactive', 'inativo', TRUE, $saleorder[0]->isinactive); ?>
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
          <button type="submit" class="btn-purple" id="submit-separation-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
