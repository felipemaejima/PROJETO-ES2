<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos">
        <div class="title"><i class="ph ph-call-bell"></i>
          Recebimento
          <?php echo $returnreceipt[0]->tranid; ?>
        </div>
        <?php echo form_open('returnreceipt', array('id' => 'returnreceipt-edit')); ?>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-returnreceipt-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $returnreceipt[0]->id); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33">
            <?php echo get_input('text', 'customer', 'cliente', FALSE, $returnreceipt[0]->customername, TRUE); ?>
            <?php echo get_input('hidden', 'customerid', 'id cliente', FALSE, $returnreceipt[0]->customerid); ?>
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $returnreceipt[0]->subsidiaryid, TRUE); ?>
          </div>
          <div class="column-33">

            <div class="form-input-content">
              <label for="createdfrom">criado de</label>
              <a href="<?php echo base_url('returnauthorization/' . $returnauthorization[0]->id); ?>">devolução
                <?php echo $returnauthorization[0]->tranid; ?></a>
              <div class="error-createdfrom error-input"></div>
            </div>
            <?php echo get_input('hidden', 'createdfrom', 'criado de', FALSE, $returnauthorization[0]->id); ?>
            <?php echo get_input('hidden', 'id', 'ID', FALSE, $returnreceipt[0]->id); ?>
          </div>
          <div class="column-33">
            <?php echo get_textarea('comments', 6, 'anotações', $returnreceipt[0]->comments); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33">
            <?php echo get_input('text', 'fiscaldocnumber', 'nota fiscal', FALSE, $returnreceipt[0]->fiscaldocnumber); ?>
          </div>
          <div class="column-33">
            <?php echo get_input('text', 'fiscaldocnumberdate', 'data da nota fiscal', FALSE, date('d/m/Y', $returnreceipt[0]->fiscaldocnumberdate)); ?>
          </div>
          <div class="column-33">
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="items">itens</label> |
          <label class="tab-btn" data-toggle="taxs">impostos</label>
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
                  <div class="column" style="min-width: 125px; padding-right: 1rem;">recebido</div>
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
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="codigo">
                      <?php echo $item->manufacturercode; ?>
                      <input type="hidden" name="itemmanufacturercode[]" value="<?php echo $item->manufacturercode; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="unidade de medida">
                      <?php echo $item->saleunitname; ?>
                      <input type="hidden" name="itempurchaseunitid[]" value="<?php echo $item->saleunitid; ?>">
                      <input type="hidden" name="itempurchaseunitname[]" value="<?php echo $item->saleunitname; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="recebido">
                      <?php echo $receiveditems[$key]->totalreceived; ?>
                      <input type="hidden" name="itemquantityreceived[]"
                        value="<?php echo $receiveditems[$key]->totalreceived; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="faturado">
                      <?php echo $receiveditems[$key]->totalreceived; ?>
                      <input type="hidden" name="itemquantitybilled[]" value="<?php echo $receiveditems[$key]->totalreceived; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="quantidade">
                      <?php echo $item->linequantity; ?>
                      <input type="hidden" name="itemquantity[]" value="<?php echo $item->linequantity; ?>">
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="recebido">
                      <div class="form-input-box">
                        <input type="text" name="itemreceived[]" placeholder="quantidade recebida"
                          value="<?php echo $item->linereceived; ?>" data-initqty="<?php echo $item->linereceived; ?>">
                      </div>
                    </div>
                    <div class="column" style="min-width: 125px; padding-right: 1rem;" title="cfop">
                      <div class="form-input-box">
                        <input type="text" name="itemcfop[]" placeholder="cfop" value="<?php echo $item->cfopname; ?>">
                        <input type="hidden" name="itemcfopid[]" value="<?php echo $item->cfopid; ?>">
                        <input type="hidden" name="itemcfopdescription[]" value="<?php echo $item->cfopdescription; ?>">
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
          <div id="taxs" class="tab-wrapper-content" style="display: none">
          </div>
          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33">
                <?php echo get_checkbox('isinactive', 'inativo', TRUE, $returnreceipt[0]->isinactive); ?>
              </div>
              <div class="column-33">
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="column">
              <div class="column-100">
                <?php require_once('logs/system-information.php'); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-receipt-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>