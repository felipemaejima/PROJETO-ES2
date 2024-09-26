<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-purchaserequests">
        <div class="title"><i class="ph ph-call-bell"></i> Requisição de compra</div>
        <?php echo form_open('purchaserequest', array('id' => 'purchaserequest-create')); ?>
        <div class="functions-tab tab-row">
          <button class="btn-purple create-purchaseorder">gerar compra</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'supplierid', 'ID', FALSE, $purchaserequest->supplierid); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'supplier', 'fornecedor', '<i class="ph ph-share"></i>', $purchaserequest->suppliername, !!$purchaserequest->suppliername); ?>
            <?php echo get_input('hidden', 'supplierid', 'fornecedor id', FALSE, $purchaserequest->supplierid); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="items">itens</label> |
        </div>
        <div class="tab-wrapper">
          <div id="items" class="tab-wrapper-content" style="display: flex">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_checkbox('checkall', 'selecionar todos'); ?>
              </div>
              <div class="column-33"></div>
              <div class="column-33">
              </div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 3050px; max-width: 100%;">
                  <div class="column" style="min-width: 100px; padding-right: 1rem;"></div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">dias em espera</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">data</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">n° requisição</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">n° pedido</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">imagem</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">item</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">subsidiária</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">quantidade</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">custo</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">fator</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">custo convertido</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">total convertido</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">preço de referência</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">código do fabricante</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">moeda</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">anotações da requisição</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">anotações do orçamento</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">responsável</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">status</div>
                </div>
                <?php $count = 0; ?>
                <?php foreach ($purchaserequest->items as $key => $item):
                  $chosensubsidiaries = '';
                  foreach ($subsidiaries as $subsidiary) {
                    $chosensubsidiaries .= "<option value='" . $subsidiary->id . "'" . ($subsidiary->id == $item->subsidiaryid ? "selected" : "") . ">" . $subsidiary->title . "</option>";
                  }
                  ?>
                  <div
                    class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 3050px; max-width: 100%;">
                    <div class="column" style="min-width: 100px; padding-right: 1rem;" title="itens selecionados">
                      <div class="form-input-box no-background checkbox">
                        <input type="checkbox" id="chkbx<?php echo $count; ?>" name="selecteditems[]">
                        <label for="chkbx<?php echo $count; ?>"></label>
                      </div>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="dias em espera">
                      <?php echo get_days_difference($item->separationcreated); ?>
                    </div>
                    
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="data">
                      <?php echo date('d/m/Y H:i', $item->separationcreated); ?>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="n° requisição">
                      <?php if ($item->separationtranid) : ?>
                        <a href="<?php echo site_url('separation/' . $item->separationid); ?>" target="_blank" class="btn-link">
                          separação <?php echo $item->separationtranid; ?>
                        </a>
                      <?php else : ?>
                        ponto de renovação atingido
                      <?php endif; ?>  
                      <input type="hidden" name="separationlineitem[]" value="<?php echo $item->separationitemid;?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="n° pedido">
                      <?php if ($item->separationtranid) : ?>
                        <a href="<?php echo site_url('saleorder/' . $item->saleorderid); ?>" target="_blank" class="btn-link">
                          pedido de venda <?php echo $item->saleordertranid; ?>
                        </a>
                        <input type="hidden" name="saleorderid[]" value="<?php echo $item->saleorderid;?>">
                        <input type="hidden" name="saleordertranid[]" value="<?php echo $item->saleordertranid;?>">
                      <?php else : ?>
                        ponto de renovação atingido
                      <?php endif; ?>  
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="imagem">
                      <div class="thumb">
                      <?php if ($item->image): ?>
                        <img src="<?php echo strpos($item->image, 'http') !== FALSE? $item->image : base_url($item->image); ?>" alt="<?php echo $item->itemname; ?>">
                      <?php else: ?>
                        <i class="ph ph-image"></i>
                      <?php endif; ?>
                      </div>
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="item">
                      <a href="<?php echo site_url('item/' . $item->itemid); ?>" target="_blank" class="btn-link">
                        <?php echo $item->itemname; ?>
                      </a>
                      <input type="hidden" name="itemid[]" value="<?php echo $item->itemid;?>">
                      <input type="hidden" name="itemname[]" value="<?php echo $item->itemname;?>">
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;" title="subsidiária">
                      <div class="form-input-box">
                        <select name="itemchosedsubsidiary[]">
                          <?php echo $chosensubsidiaries; ?>
                        </select>
                      </div>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="quantidade">
                      <?php echo $item->itemrequested; ?>
                      <input type="hidden" name="itemquantity[]" value="<?php echo $item->itemrequested;?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="custo">
                      <?php echo $item->expense; ?>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="fator">
                      <?php echo $item->conversionfactor; ?>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="custo convertido">
                      <?php echo $item->convertedexpense; ?>
                      <input type="hidden" name="itemexpense[]" value="<?php echo $item->convertedexpense;?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="total convertido">
                      <?php echo $item->totalconvertedexpense; ?>
                      <input type="hidden" name="itemgrossvalue[]" value="<?php echo $item->totalconvertedexpense;?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="preço de referência">
                      <?php echo $item->refererprice; ?>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="código do fabricante">
                      <?php echo $item->manufacturercode; ?>
                      <input type="hidden" name="itemmanufacturercode[]" value="<?php echo $item->manufacturercode;?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="moeda">
                     <?php echo $item->currency; ?>
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="anotações da requisição">
                      <?php echo $item->separationcomments; ?>
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="anotações do orçamento">
                      <?php echo $item->estimatecomments; ?>
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="responsável">
                      <?php echo $item->responsible; ?>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="status">
                      <?php echo $item->status; ?>
                    </div>
                  </div>
                  <?php $count++; ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button class="btn-purple create-purchaseorder">gerar compra</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
