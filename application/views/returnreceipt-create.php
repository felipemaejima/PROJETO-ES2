<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos">
        <div class="title"><i class="ph ph-call-bell"></i> Recebimento
        </div>
        <?php echo form_open('returnreceipt', array('id' => 'returnreceipt-create')); ?>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-returnreceipt-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $returnauthorization[0]->id); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33">
            <?php echo get_input('text', 'customer', 'cliente', FALSE, $returnauthorization[0]->customername, TRUE); ?>
            <?php echo get_input('hidden', 'customerid', 'id cliente', FALSE, $returnauthorization[0]->customerid); ?>
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $returnauthorization[0]->subsidiaryid, TRUE); ?>
          </div>
          <div class="column-33">

            <div class="form-input-content">
              <label for="createdfrom">criado de</label>
              <a href="<?php echo base_url('returnauthorization/' . $returnauthorization[0]->id); ?>">devolução <?php echo $returnauthorization[0]->tranid; ?></a>
              <div class="error-createdfrom error-input"></div>
            </div>
            <?php echo get_input('hidden', 'createdfrom', 'criado de', FALSE, $returnauthorization[0]->id); ?>
          </div>
          <div class="column-33">
            <?php echo get_textarea('comments', 6, 'anotações'); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33">
          <?php echo get_input('text', 'fiscaldocnumber', 'nota fiscal'); ?>
          </div>
          <div class="column-33">
            <?php echo get_input('text', 'fiscaldocnumberdate', 'data da nota fiscal'); ?>
          </div>
          <div class="column-33">
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="items">itens</label> |
        </div>
        <div class="tab-wrapper">
          <div id="items" class="tab-wrapper-content" style="display: flex">
            <div class="column">
              <div class="column-33">
              </div>
              <div class="column-33"></div>
              <div class="column-33">
              </div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1375px">
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">linha</div>
                  <div class="column" style="min-width: 250px; padding-right: 1rem;">item</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">código</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">unidade de medida</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">total recebido</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">faturado</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">quantidade</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">recebido</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">cfop</div>
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">ncm</div>
                </div>
                <?php foreach ($items as $key => $item): ?>
                  <div
                    class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?> <?php echo $item->isinactive == 'T' ? 'disabled' : ''; ?>"
                    style="min-width: 1375px; <?php echo $item->isinactive == 'T' ? 'display: none;' : ''; ?>">
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="linha">
                      <?php echo $item->itemline; ?>
                      <input type="hidden" name="itemline[]" value="<?php echo $item->itemline; ?>">
                      <input type="hidden" name="returnlineitem[]" value="<?php echo $item->id; ?>">
                    </div>
                    <div class="column" style="min-width: 250px; padding-right: 1rem;" title="item">
                      <a href="<?php echo site_url('item/' . $item->itemid); ?>" target="_blank" class="btn-link">
                        <?php echo $item->itemname; ?>
                      </a>
                      <input type="hidden" name="itemid[]" value="<?php echo $item->itemid; ?>">
                      <input type="hidden" name="itemname[]" value="<?php echo $item->itemname; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="codigo">
                      <?php echo $item->manufacturercode; ?>
                      <input type="hidden" name="itemmanufacturercode[]" value="<?php echo $item->manufacturercode; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="unidade de medida">
                      <?php echo $item->saleunitname; ?>
                      <input type="hidden" name="itemsaleunitid[]" value="<?php echo $item->saleunitid; ?>">
                      <input type="hidden" name="itemsaleunitname[]" value="<?php echo $item->saleunitname; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="total recebido">
                      <?php echo $item->linequantityreceived; ?>
                      <input type="hidden" name="itemquantityreceived[]"
                        value="<?php echo $item->linequantityreceived; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="faturado">
                      <?php echo $item->linequantitybilled; ?>
                      <input type="hidden" name="itemquantitybilled[]" value="<?php echo $item->linequantitybilled; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="quantidade">
                      <?php echo $item->itemreturned; ?>
                      <input type="hidden" name="itemquantity[]" value="<?php echo $item->itemreturned; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="recebido">
                      <div class="form-input-box">
                        <input type="text" name="itemreceived[]" placeholder="quantidade recebida"
                          value="">
                      </div>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="cfop">
                      <div class="form-input-box">
                        <input type="text" name="itemcfop[]" placeholder="cfop"
                          value="">
                          <input type="hidden" name="itemcfopid[]" value="">
                          <input type="hidden" name="itemcfopdescription[]" value="">
                      </div>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="ncm">
                      <?php echo $item->ncm; ?>
                      <input type="hidden" name="itemncm[]" value="<?php echo $item->ncm; ?>">
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
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-receipt-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
