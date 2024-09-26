<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-items">
        <div class="title"><i class="ph ph-package"></i> Item</div>
        <?php echo form_open('item', array('id' => 'item-create')); ?>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-item-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'name', 'nome'); ?>
            <?php echo get_input('text', 'upccode', 'código upc'); ?>
            <?php echo get_select($brands, 'brand', 'marca'); ?>
            <?php echo get_input('text', 'salescode', 'código de venda'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações'); ?>
            <?php echo get_file('image', 'imagem do produto', '.jpg, .jpeg, .png'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <div class="form-input-content">
              <div class="thumb-image">
              </div>
            </div>
          </div>
        </div>
        <div class="group-title">subsidiarias de venda</div>
        <div class="column">
          <div class="btn-checkbox">
            <?php foreach ($subsidiaries as $subsidiary): ?>
              <?php echo get_checkbox_button('subsidiaries[]', $subsidiary->title); ?>
            <?php endforeach; ?>
            <div class="error-subsidiaries error-input"></div>
          </div>
        </div>
        <div class="group-title">produtos químicos</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('ischemical', 'produto químico'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('iscontrolledcivilpolice', 'polícia civil'); ?>
            <?php echo get_checkbox('iscontrolledfederalpolice', 'política federal'); ?>
            <?php echo get_checkbox('iscontrolledarmy', 'exército'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'concentration', 'concentração %'); ?>
            <?php echo get_input('text', 'density', 'densidade'); ?>
          </div>
        </div>
        <div class="group-title">código onu</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'onucode', 'onu'); ?>
            <?php echo get_textarea('onudescription', 6, 'descrição do onu', FALSE, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'riskclass', 'classe de risco', FALSE, FALSE, TRUE); ?>
            <?php echo get_textarea('riskclassdescription', 6, 'descrição da classe de risco', FALSE, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'risknumber', 'número do risco', FALSE, FALSE, TRUE); ?>
            <?php echo get_input('text', 'subsidiaryrisk', 'risco subsidiário', FALSE, FALSE, TRUE); ?>
            <?php echo get_input('text', 'packinggroup', 'código da embalagem', FALSE, FALSE, TRUE); ?>
            <?php echo get_input('text', 'transportquantity', 'quantidade de transporte', FALSE, FALSE, TRUE); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($groups, 'group', 'grupo'); ?>
            <?php echo get_select(FALSE, 'subgroup', 'sub grupo'); ?>
            <?php echo get_checkbox('unitwarning', 'aviso de unidade de medida'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($units, 'saleunit', 'unidade de medida de venda'); ?>
            <?php echo get_select($voltages, 'voltage', 'voltagem'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($warranties, 'warranty', 'garantia'); ?>
            <?php echo get_input('text', 'deadline', 'prazo de entrega (dias)'); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="description">descrição</label> |
          <label class="tab-btn" data-toggle="price">nível de preço</label> |
          <label class="tab-btn" data-toggle="stock">estoque</label> |
          <label class="tab-btn" data-toggle="shipping">expedição</label> |
          <label class="tab-btn" data-toggle="supplier">fornecedores</label> |
          <label class="tab-btn" data-toggle="tax">impostos</label> |
        </div>
        <div class="tab-wrapper">
          <div id="description" class="tab-wrapper-content" style="display: flex">
            <div class="column">
              <div class="column-50 c-large c-medium c-small">
                <div id="editor"></div>
              </div>
            </div>
          </div>
          <div id="price" class="tab-wrapper-content" style="display: none">
            <div class="group-title">origem do item</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select($currencies, 'currency', 'moeda'); ?>
                <?php echo get_input('text', 'conversionfactor', 'fator de conversão', FALSE, '1.00'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'expense', 'custo'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'convertedexpense', 'custo convertido', FALSE, FALSE, TRUE); ?>
              </div>
            </div>
            <div class="group-title">promocional</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'promotionalprice', 'preço promocional'); ?>
              </div>
              <div class="column-33">
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="group-title">regime normal de apuração</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'minimumregimenormalprice', 'preço mínimo regime normal'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'regimenormalsuggestedprice', 'preço sugerido regime normal'); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="group-title">simples nacional</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'minimumsimplesnacionalprice', 'preço mínimo simples nacional'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'simplesnacionalsuggestedprice', 'preço sugerido simples nacional'); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="group-title">revenda</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'minimumresaleprice', 'preço mínimo revenda'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'resalesuggestedprice', 'preço sugerido revenda'); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
          </div>
          <div id="stock" class="tab-wrapper-content" style="display: none">
            <div class="group-title">ponto de renovação</div>
            <div class="column">
              <?php foreach ($subsidiaries as $subsidiary): ?>
                <div class="column-33">
                  <?php echo get_input('text','renewalpoint[]', 'ponto de renovação ' . $subsidiary->title, FALSE, FALSE, TRUE); ?>
                </div>  
              <?php endforeach; ?>
            </div>
            <div class="group-title">endereço</div>
            <div class="column">
              <div class="column-25">
                <div class="form-input-content">
                  <label for="">pavilhão</label>
                  <div class="btn-checkbox">
                    <?php echo get_checkbox_button('pavilion[]', 'amarelo'); ?>
                    <?php echo get_checkbox_button('pavilion[]', 'azul'); ?>
                    <?php echo get_checkbox_button('pavilion[]', 'laranja'); ?>
                    <?php echo get_checkbox_button('pavilion[]', 'preto'); ?>
                    <?php echo get_checkbox_button('pavilion[]', 'rosa'); ?>
                    <?php echo get_checkbox_button('pavilion[]', 'verde'); ?>
                    <?php echo get_checkbox_button('pavilion[]', 'vermelho'); ?>
                    <div class="error-pavilion error-input"></div>
                  </div>
                </div>
              </div>
              <div class="column-25">
                <div class="form-input-content">
                  <label for="">palete</label>
                  <div class="btn-checkbox">
                    <?php echo get_checkbox_button('pallet[]', '01'); ?>
                    <?php echo get_checkbox_button('pallet[]', '02'); ?>
                    <?php echo get_checkbox_button('pallet[]', '03'); ?>
                    <?php echo get_checkbox_button('pallet[]', '04'); ?>
                    <?php echo get_checkbox_button('pallet[]', '05'); ?>
                    <?php echo get_checkbox_button('pallet[]', '06'); ?>
                    <?php echo get_checkbox_button('pallet[]', '07'); ?>
                    <?php echo get_checkbox_button('pallet[]', '08'); ?>
                    <?php echo get_checkbox_button('pallet[]', '09'); ?>
                    <?php echo get_checkbox_button('pallet[]', '10'); ?>
                    <div class="error-pallet error-input"></div>
                  </div>
                </div>
              </div>
              <div class="column-25">
                <div class="form-input-content">
                  <label for="">corredor</label>
                  <div class="btn-checkbox">
                    <?php echo get_checkbox_button('hall[]', '01'); ?>
                    <?php echo get_checkbox_button('hall[]', '02'); ?>
                    <?php echo get_checkbox_button('hall[]', '03'); ?>
                    <?php echo get_checkbox_button('hall[]', '04'); ?>
                    <?php echo get_checkbox_button('hall[]', '05'); ?>
                    <?php echo get_checkbox_button('hall[]', '06'); ?>
                    <?php echo get_checkbox_button('hall[]', '07'); ?>
                    <?php echo get_checkbox_button('hall[]', '08'); ?>
                    <?php echo get_checkbox_button('hall[]', '09'); ?>
                    <?php echo get_checkbox_button('hall[]', '10'); ?>
                    <div class="error-hall error-input"></div>
                  </div>
                </div>
              </div>
              <div class="column-25">
                <div class="form-input-content">
                  <label for="">rua</label>
                  <div class="btn-checkbox">
                    <?php echo get_checkbox_button('street[]', '01'); ?>
                    <?php echo get_checkbox_button('street[]', '02'); ?>
                    <?php echo get_checkbox_button('street[]', '03'); ?>
                    <?php echo get_checkbox_button('street[]', '04'); ?>
                    <?php echo get_checkbox_button('street[]', '05'); ?>
                    <?php echo get_checkbox_button('street[]', '06'); ?>
                    <?php echo get_checkbox_button('street[]', '07'); ?>
                    <?php echo get_checkbox_button('street[]', '08'); ?>
                    <?php echo get_checkbox_button('street[]', '09'); ?>
                    <?php echo get_checkbox_button('street[]', '10'); ?>
                    <?php echo get_checkbox_button('street[]', '11'); ?>
                    <?php echo get_checkbox_button('street[]', '12'); ?>
                    <?php echo get_checkbox_button('street[]', '13'); ?>
                    <?php echo get_checkbox_button('street[]', '14'); ?>
                    <?php echo get_checkbox_button('street[]', '15'); ?>
                    <?php echo get_checkbox_button('street[]', '16'); ?>
                    <?php echo get_checkbox_button('street[]', '17'); ?>
                    <?php echo get_checkbox_button('street[]', '18'); ?>
                    <div class="error-street error-input"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="group-title">posição</div>
            <div class="column">
              <?php $shelf = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q'); ?>
              <?php foreach ($shelf as $key => $value): ?>
                <div class="column-25">
                  <div class="form-input-content">
                    <label for="">prateleira
                      <?php echo $value; ?>
                    </label>
                    <div class="btn-checkbox">
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '01'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '02'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '03'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '04'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '05'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '06'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '07'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '08'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '09'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '10'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '11'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '12'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '13'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '14'); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '15'); ?>
                      <div class="error-shelf<?php echo $value; ?> error-input"></div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div id="shipping" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'grossweight', 'peso bruto kg'); ?>
                <?php echo get_input('text', 'netweight', 'peso liquido kg'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'length', 'comprimento cm'); ?>
                <?php echo get_input('text', 'width', 'largura cm'); ?>
                <?php echo get_input('text', 'height', 'altura cm'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
              </div>
            </div>
          </div>
          <div id="supplier" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'manufacturercode', 'código do fabricante'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select($units, 'purchaseunit', 'unidade de medida de compra'); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="tab-wrapper-buttons">
              <a href="" class="add-supplier">add fornecedor</a>
            </div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 750px; max-width: 100%;">
                  <div class="column" style="min-width: 300px; padding-right: 1rem;">fornecedor</div>
                  <div class="column" style="min-width: 300px; padding-right: 1rem;">preferencial</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;"></div>
                </div>
              </div>
            </div>
          </div>
          <div id="tax" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'ncm', 'ncm'); ?>
                <?php echo get_textarea('ncmdescription', 6, 'descrição do ncm', FALSE, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'icmsentry', 'alíquota icms de entrada'); ?>
                <?php echo get_input('text', 'ipi', 'alíquota ipi'); ?>
                <?php echo get_input('text', 'stfactor', 'fator de st'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'cest', 'cest'); ?>
                <?php echo get_input('text', 'icmstaxincentive', 'incentivo fiscal de icms'); ?>
                <?php echo get_select($itemorigintypes, 'itemorigin', 'origem do item'); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab">
          <button type="submit" class="btn-purple" id="submit-item-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<div id="modal-add-supplier" class="modal">
  <div class="modal-large">
    <div class="modal-header">
      <div class="close">
        <i class="ph ph-x"></i>
      </div>
    </div>
    <div class="modal-content">
      <div class="box-infos">
        <?php echo form_open('add-supplier', array('id' => 'add-supplier')); ?>
        <div class="form-input-content">
          <div class="success-message"></div>
        </div>
        <div class="column">
          <div class="column-100">
            <?php echo get_input('text', 'name', 'fornecedor'); ?>
            <?php echo get_input('hidden', 'id', 'ID'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-50 c-large">
            <?php echo get_checkbox('ispreferred', 'preferencial'); ?>
          </div>
        </div>
        <button type="submit" class="btn-blue" id="submit-add-supplier">inserir</button>
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