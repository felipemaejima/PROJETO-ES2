<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-returnauthorization">
        <div class="title"><i class="ph ph-call-bell"></i>
          Devolução
          <?php echo $returnauthorization[0]->tranid; ?>
          <div class="status"><?php echo $returnauthorization[0]->status; ?></div>
        </div>
        <?php echo form_open('returnauthorization', array('id' => 'returnauthorization-edit')); ?>
        <div class="functions-tab tab-row">
          <a href="<?php echo site_url('returnauthorization/' . $this->uri->segment(2) . '?edit=T'); ?>"
            class="btn-purple" id="submit-returnauthorization-edit">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
          <?php // todo condiçionais ?>
          <a href="<?php echo base_url('returnreceipt?referer=' . $this->uri->segment(2)); ?>" class="btn-gray"
            target="_blank">receber</a>
        </div>
        <div class="column-33 c-large c-medium c-small">
          <div class="form-input-content">
            <label for="createdfrom">criado de</label>
            <a href="<?php echo base_url('invoice/' . $invoice[0]->id); ?>">fatura
              <?php echo $invoice[0]->tranid; ?></a>
            <div class="error-createdfrom error-input"></div>
          </div>
          <?php echo get_input('hidden', 'createdfrom', 'criado de', FALSE, $returnauthorization[0]->id); ?>
          <?php echo get_input('hidden', 'id', 'ID', FALSE, $returnauthorization[0]->id); ?>
        </div>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'customer', 'cliente', FALSE, $returnauthorization[0]->customername, TRUE); ?>
            <?php echo get_input('hidden', 'customername', 'cliente', FALSE, $returnauthorization[0]->customername); ?>
            <?php echo get_input('hidden', 'customerid', 'cliente id', FALSE, $returnauthorization[0]->customerid); ?>
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria', FALSE, $returnauthorization[0]->subsidiaryid, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'salesman', 'nome do vendedor', FALSE, $invoice[0]->salesmanname, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $returnauthorization[0]->comments, TRUE); ?>
          </div>
        </div>
        <!-- <div class="group-title">informações adicionais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php // echo get_input('text', 'returndate', 'data da devolução', FALSE, date('d/m/Y')); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
          </div>
          <div class="column-33 c-large c-medium c-small">
          </div>
        </div> -->
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="items">itens</label> |
          <label class="tab-btn" data-toggle="sharedlinks">registros relacionados</label>
        </div>
        <div class="tab-wrapper">
          <div id="items" class="tab-wrapper-content" style="display: flex">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php //  echo get_checkbox('checkall', 'selecionar todos'); ?>
              </div>
              <div class="column-33"></div>
              <div class="column-33">
              </div>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1750px; max-width: 100%;">
                  <div class="column" style="min-width: 100px; padding-right: 1rem;">linha</div>
                  <div class="column" style="min-width: 350px; padding-right: 1rem;">item</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">unidade de medida</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">quantidade</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">preço</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">frete</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">desconto</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">total</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">total devolvido</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">devolvido</div>
                </div>
                <?php $count = 0; ?>
                <?php foreach ($items as $key => $item): ?>
                  <div
                    class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?> <?php echo $item->isinactive == 'T' ? 'disabled' : ''; ?>"
                    style="min-width: 1750px; max-width: 100%; <?php echo $item->isinactive == 'T' ? 'display: none;' : ''; ?>">
                    <div class="column" style="min-width: 100px; padding-right: 1rem;" title="linha">
                      <?php echo $item->itemline; ?>
                      <input type="hidden" name="itemlineid[]" value="<?php echo $item->id; ?>">
                    </div>
                    <div class="column" style="min-width: 350px; padding-right: 1rem;" title="item">
                      <a href="<?php echo site_url('item/' . $item->itemid); ?>" target="_blank" class="btn-link">
                        <?php echo $item->itemname; ?>
                      </a>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="unidade de medida">
                      <?php echo $item->itemsaleunitname; ?>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="quantidade">
                      <?php echo $item->itemquantity; ?>
                      <input type="hidden" name="itemquantity[]" value="<?php echo $item->itemquantity; ?>">
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="preço">
                      <?php echo $item->itemprice; ?>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="frete">
                      <?php echo $item->itemfreight; ?>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="desconto">
                      <?php echo $item->itemdiscount; ?>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="total">
                      <?php echo $item->itemtotal; ?>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="total devolvido">
                      <?php echo $returneditems[$key]->totalreturned; ?>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;" title="devolvido">
                      <div class="form-input-box">
                        <input type="text" name="itemreturned[]" placeholder="quantidade devolvida"
                          value="<?php echo $item->itemreturned; ?>" disabled>
                      </div>
                    </div>
                  </div>
                  <?php $count++; ?>
                <?php endforeach; ?>
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
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 800px; max-width: 100%;">
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
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <a href="<?php echo site_url('returnauthorization/' . $this->uri->segment(2) . '?edit=T'); ?>"
            class="btn-purple" id="submit-returnauthorization-edit">editar</a>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>