<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-items">
        <div class="title"><i class="ph ph-package"></i> Item</div>
        <?php echo form_open('item', array('id' => 'item-edit')); ?>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-item-edit">salvar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo get_input('hidden', 'id', 'ID', FALSE, $item[0]->id); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'name', 'nome', FALSE, $item[0]->name); ?>
            <?php echo get_input('text', 'upccode', 'código upc', FALSE, $item[0]->upccode); ?>
            <?php echo get_select($brands, 'brand', 'marca', FALSE, $item[0]->brand); ?>
            <?php echo get_input('text', 'salescode', 'código de venda', FALSE, $item[0]->salescode); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações', $item[0]->comments); ?>
            <?php echo get_file('image', 'imagem do produto', '.jpg, .jpeg, .png'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <div class="form-input-content">
              <div class="thumb-image">
                <?php if ($item[0]->image): ?>
                  <img src="<?php echo strpos($item[0]->image, 'http') !== FALSE? $item[0]->image : base_url($item[0]->image); ?>">
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="group-title">subsidiarias de venda</div>
        <div class="column">
          <div class="btn-checkbox">
            <?php foreach ($subsidiaries as $subsidiary): ?>
              <?php echo get_checkbox_button('subsidiaries[]', $subsidiary->title, FALSE, $item[0]->subsidiaries ? $item[0]->subsidiaries : FALSE); ?>
            <?php endforeach; ?>
            <div class="error-subsidiaries error-input"></div>
          </div>
        </div>
        <div class="group-title">produtos químicos</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('ischemical', 'produto químico', FALSE, $item[0]->ischemical); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_checkbox('iscontrolledcivilpolice', 'polícia civil', FALSE, $item[0]->iscontrolledcivilpolice); ?>
            <?php echo get_checkbox('iscontrolledfederalpolice', 'política federal', FALSE, $item[0]->iscontrolledfederalpolice); ?>
            <?php echo get_checkbox('iscontrolledarmy', 'exército', FALSE, $item[0]->iscontrolledarmy); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'concentration', 'concentração %', FALSE, $item[0]->concentration); ?>
            <?php echo get_input('text', 'density', 'densidade', FALSE, $item[0]->density); ?>
          </div>
        </div>
        <div class="group-title">código onu</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'onucode', 'onu', FALSE, $item[0]->onucode); ?>
            <?php echo get_textarea('onudescription', 6, 'descrição do onu', $item[0]->onudescription, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'riskclass', 'classe de risco', FALSE, $item[0]->riskclass, TRUE); ?>
            <?php echo get_textarea('riskclassdescription', 6, 'descrição da classe de risco', FALSE, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'risknumber', 'número do risco', FALSE, $item[0]->risknumber, TRUE); ?>
            <?php echo get_input('text', 'subsidiaryrisk', 'risco subsidiário', FALSE, $item[0]->subsidiaryrisk, TRUE); ?>
            <?php echo get_input('text', 'packinggroup', 'código da embalagem', FALSE, $item[0]->packinggroup, TRUE); ?>
            <?php echo get_input('text', 'transportquantity', 'quantidade de transporte', FALSE, $item[0]->transportquantity, TRUE); ?>
          </div>
        </div>
        <div class="group-title">classificação</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($groups, 'group', 'grupo', FALSE, $item[0]->group); ?>
            <?php echo get_select($subgroups, 'subgroup', 'sub grupo', FALSE, $item[0]->subgroup); ?>
            <?php echo get_checkbox('unitwarning', 'aviso de unidade de medida', FALSE, $item[0]->unitwarning == 'T' ? TRUE : FALSE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($units, 'saleunit', 'unidade de medida de venda', FALSE, $item[0]->saleunit); ?>
            <?php echo get_select($voltages, 'voltage', 'voltagem', FALSE, $item[0]->voltage); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($warranties, 'warranty', 'garantia', FALSE, $item[0]->warranty); ?>
            <?php echo get_input('text', 'deadline', 'prazo de entrega (dias)', FALSE, $item[0]->deadline); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="description">descrição</label> |
          <label class="tab-btn" data-toggle="price">nível de preço</label> |
          <label class="tab-btn" data-toggle="stock">estoque</label> |
          <label class="tab-btn" data-toggle="shipping">expedição</label> |
          <label class="tab-btn" data-toggle="supplier">fornecedores</label> |
          <label class="tab-btn" data-toggle="tax">impostos</label> |
          <label class="tab-btn" data-toggle="systeminformation">informações do sistema</label>
        </div>
        <div class="tab-wrapper">
          <div id="description" class="tab-wrapper-content" style="display: flex">
            <div class="column">
              <div class="column-50 c-large c-medium c-small">
                <div id="editor">
                  <?php echo json_decode($item[0]->itemdescription); ?>
                </div>
              </div>
            </div>
          </div>
          <div id="price" class="tab-wrapper-content" style="display: none">
            <div class="group-title">origem do item</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select($currencies, 'currency', 'moeda', FALSE, $item[0]->currency); ?>
                <?php echo get_input('text', 'conversionfactor', 'fator de conversão', FALSE, $item[0]->conversionfactor); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'expense', 'custo', FALSE, $item[0]->expense); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'convertedexpense', 'custo convertido', FALSE, $item[0]->convertedexpense, TRUE); ?>
              </div>
            </div>
            <div class="group-title">promocional</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'promotionalprice', 'preço promocional', FALSE, $item[0]->promotionalprice); ?>
              </div>
              <div class="column-33">
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="group-title">regime normal de apuração</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'minimumregimenormalprice', 'preço mínimo regime normal', FALSE, $item[0]->minimumregimenormalprice); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'regimenormalsuggestedprice', 'preço sugerido regime normal', FALSE, $item[0]->regimenormalsuggestedprice); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="group-title">simples nacional</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'minimumsimplesnacionalprice', 'preço mínimo simples nacional', FALSE, $item[0]->minimumsimplesnacionalprice); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'simplesnacionalsuggestedprice', 'preço sugerido simples nacional', FALSE, $item[0]->simplesnacionalsuggestedprice); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="group-title">revenda</div>
            <div class="column">
              <div class="column-33">
                <?php echo get_input('text', 'minimumresaleprice', 'preço mínimo revenda', FALSE, $item[0]->minimumresaleprice); ?>
              </div>
              <div class="column-33">
                <?php echo get_input('text', 'resalesuggestedprice', 'preço sugerido revenda', FALSE, $item[0]->resalesuggestedprice); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
          </div>
          <div id="stock" class="tab-wrapper-content" style="display: none">
          <?php echo get_checkbox('finalstock', 'estoque final', FALSE, $item[0]->finalstock == 'T' ? TRUE : FALSE); ?>
            <div class="group-title">níveis preferenciais</div>
            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 1050px; max-width: 100%;">
                  <div class="column" style="min-width: 300px; padding-right: 1rem;">localidade</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">ponto de renovação</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">quantidade em estoque</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">quantidade encomendada</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">quantidade comprometida</div>
                  <div class="column" style="min-width: 150px; padding-right: 1rem;">quantidade disponível</div>
                </div>
                <?php foreach ($inventory as $key => $row): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                    style="min-width: 1050px; max-width: 100%;">
                    <div class="column">
                      <?php echo $row->subsidiary; ?>
                    </div>
                    <div class="column" style="min-width: 300px; padding-right: 1rem;">
                      <?php echo $row->renewalpoint; ?>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;">
                      <?php echo $row->quantityonhand; ?>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;">
                      <?php echo $row->quantityonorder; ?>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;">
                      <?php echo $row->quantitycommitted; ?>
                    </div>
                    <div class="column" style="min-width: 150px; padding-right: 1rem;">
                      <?php echo $row->quantityavailable; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="group-title">ponto de renovação</div>
            <div class="column">
              <?php foreach ($subsidiaries as $key => $subsidiary): ?>
                <div class="column-33">
                  <?php echo get_input('text','renewalpoint[]', 'ponto de renovação ' . $subsidiary->title, FALSE, $inventory[$key]->renewalpoint, !strpos($item[0]->subsidiaries, $subsidiary->title) !== FALSE ? TRUE : FALSE); ?>
                </div>  
              <?php endforeach; ?>
            </div>
            <div class="group-title">endereço</div>
            <div class="column">
              <div class="column-25">
                <div class="form-input-content">
                  <label for="">pavilhão</label>
                  <div class="btn-checkbox">
                    <?php echo get_checkbox_button('pavilion[]', 'amarelo', FALSE, $item[0]->pavilion); ?>
                    <?php echo get_checkbox_button('pavilion[]', 'azul', FALSE, $item[0]->pavilion); ?>
                    <?php echo get_checkbox_button('pavilion[]', 'laranja', FALSE, $item[0]->pavilion); ?>
                    <?php echo get_checkbox_button('pavilion[]', 'preto', FALSE, $item[0]->pavilion); ?>
                    <?php echo get_checkbox_button('pavilion[]', 'rosa', FALSE, $item[0]->pavilion); ?>
                    <?php echo get_checkbox_button('pavilion[]', 'verde', FALSE, $item[0]->pavilion); ?>
                    <?php echo get_checkbox_button('pavilion[]', 'vermelho', FALSE, $item[0]->pavilion); ?>
                    <div class="error-pavilion error-input"></div>
                  </div>
                </div>
              </div>
              <div class="column-25">
                <div class="form-input-content">
                  <label for="">palete</label>
                  <div class="btn-checkbox">
                    <?php echo get_checkbox_button('pallet[]', '01', FALSE, $item[0]->pallet); ?>
                    <?php echo get_checkbox_button('pallet[]', '02', FALSE, $item[0]->pallet); ?>
                    <?php echo get_checkbox_button('pallet[]', '03', FALSE, $item[0]->pallet); ?>
                    <?php echo get_checkbox_button('pallet[]', '04', FALSE, $item[0]->pallet); ?>
                    <?php echo get_checkbox_button('pallet[]', '05', FALSE, $item[0]->pallet); ?>
                    <?php echo get_checkbox_button('pallet[]', '06', FALSE, $item[0]->pallet); ?>
                    <?php echo get_checkbox_button('pallet[]', '07', FALSE, $item[0]->pallet); ?>
                    <?php echo get_checkbox_button('pallet[]', '08', FALSE, $item[0]->pallet); ?>
                    <?php echo get_checkbox_button('pallet[]', '09', FALSE, $item[0]->pallet); ?>
                    <?php echo get_checkbox_button('pallet[]', '10', FALSE, $item[0]->pallet); ?>
                    <div class="error-pallet error-input"></div>
                  </div>
                </div>
              </div>
              <div class="column-25">
                <div class="form-input-content">
                  <label for="">corredor</label>
                  <div class="btn-checkbox">
                    <?php echo get_checkbox_button('hall[]', '01', FALSE, $item[0]->hall); ?>
                    <?php echo get_checkbox_button('hall[]', '02', FALSE, $item[0]->hall); ?>
                    <?php echo get_checkbox_button('hall[]', '03', FALSE, $item[0]->hall); ?>
                    <?php echo get_checkbox_button('hall[]', '04', FALSE, $item[0]->hall); ?>
                    <?php echo get_checkbox_button('hall[]', '05', FALSE, $item[0]->hall); ?>
                    <?php echo get_checkbox_button('hall[]', '06', FALSE, $item[0]->hall); ?>
                    <?php echo get_checkbox_button('hall[]', '07', FALSE, $item[0]->hall); ?>
                    <?php echo get_checkbox_button('hall[]', '08', FALSE, $item[0]->hall); ?>
                    <?php echo get_checkbox_button('hall[]', '09', FALSE, $item[0]->hall); ?>
                    <?php echo get_checkbox_button('hall[]', '10', FALSE, $item[0]->hall); ?>
                    <div class="error-hall error-input"></div>
                  </div>
                </div>
              </div>
              <div class="column-25">
                <div class="form-input-content">
                  <label for="">rua</label>
                  <div class="btn-checkbox">
                    <?php echo get_checkbox_button('street[]', '01', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '02', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '03', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '04', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '05', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '06', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '07', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '08', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '09', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '10', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '11', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '12', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '13', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '14', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '15', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '16', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '17', FALSE, $item[0]->street); ?>
                    <?php echo get_checkbox_button('street[]', '18', FALSE, $item[0]->street); ?>
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
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '01', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '02', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '03', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '04', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '05', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '06', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '07', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '08', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '09', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '10', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '11', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '12', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '13', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '14', FALSE, $item[0]->{'shelf' . $value}); ?>
                      <?php echo get_checkbox_button('shelf' . $value . '[]', '15', FALSE, $item[0]->{'shelf' . $value}); ?>
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
                <?php echo get_input('text', 'grossweight', 'peso bruto kg', FALSE, $item[0]->grossweight); ?>
                <?php echo get_input('text', 'netweight', 'peso liquido kg', FALSE, $item[0]->netweight); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'length', 'comprimento cm', FALSE, $item[0]->length); ?>
                <?php echo get_input('text', 'width', 'largura cm', FALSE, $item[0]->width); ?>
                <?php echo get_input('text', 'height', 'altura cm', FALSE, $item[0]->height); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
          </div>
          <div id="supplier" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'manufacturercode', 'código do fabricante', FALSE, $item[0]->manufacturercode); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select($units, 'purchaseunit', 'unidade de medida de compra', FALSE, $item[0]->purchaseunit); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="tab-wrapper-buttons">
              <a href="" class="add-supplier">add fornecedor</a>
            </div>

            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 600px max-width: 100%;">
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">fornecedor</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;">preferencial</div>
                  <div class="column" style="min-width: 200px; padding-right: 1rem;"></div>
                </div>
                <?php foreach ($suppliers as $key => $supplier): ?>
                  <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 600px; max-width: 100%;">
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <a href="<?php echo base_url('supplier/' . $supplier->supplier); ?>" target="_blank"
                        class="btn-link">
                        <?php echo $supplier->name; ?>
                      </a>
                    </div>
                    <div class="column" style="min-width: 200px; padding-right: 1rem;">
                      <?php echo $supplier->ispreferred == 'T' ? 'Sim' : 'Não'; ?>
                      <input type="hidden" name="supplieritemid[]" value="<?php echo $supplier->id; ?>">
                      <input type="hidden" name="supplierid[]" value="<?php echo $supplier->supplier; ?>">
                      <input type="hidden" name="suppliername[]" value="<?php echo $supplier->name; ?>">
                      <input type="hidden" name="supplierispreferred[]" value="<?php echo $supplier->ispreferred; ?>">
                    </div>
                    <div class="column align-right" style="min-width: 200px; padding-right: 1rem;">
                      <a href="" class="btn-blue btn-edit-supplier">editar</a>
                      <a href="" class="btn-red btn-remove-supplier">remover</a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div id="tax" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'ncm', 'ncm', FALSE, $item[0]->ncm); ?>
                <?php echo get_textarea('ncmdescription', 6, 'descrição do ncm', $item[0]->ncmdescription, TRUE); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'icmsentry', 'alíquota icms de entrada', FALSE, $item[0]->icmsentry); ?>
                <?php echo get_input('text', 'ipi', 'alíquota ipi', FALSE, $item[0]->ipi); ?>
                <?php echo get_input('text', 'stfactor', 'fator de st', FALSE, $item[0]->stfactor); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_input('text', 'cest', 'cest', FALSE, $item[0]->cest); ?>
                <?php echo get_input('text', 'icmstaxincentive', 'incentivo fiscal de icms', FALSE, $item[0]->icmstaxincentive); ?>
                <?php echo get_select($itemorigintypes, 'itemorigin', 'origem do item', FALSE, $item[0]->itemorigin); ?>
              </div>
            </div>
          </div>
          <div id="systeminformation" class="tab-wrapper-content" style="display: none">
            <div class="column">
              <div class="column-33">
                <?php echo get_checkbox('isinactive', 'inativo', FALSE, $item[0]->isinactive); ?>
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
          <button type="submit" class="btn-purple" id="submit-item-edit">salvar</button>
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
            <?php echo get_input('hidden', 'link', 'link'); ?>
            <?php echo get_input('hidden', 'supplier', 'supplier'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-50 c-large">
            <?php echo get_checkbox('ispreferredcreate', 'preferencial'); ?>
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
<div id="modal-edit-supplier" class="modal">
  <div class="modal-large">
    <div class="modal-header">
      <div class="close">
        <i class="ph ph-x"></i>
      </div>
    </div>
    <div class="modal-content">
      <div class="box-infos">
        <?php echo form_open('edit-supplier', array('id' => 'edit-supplier')); ?>
        <div class="form-input-content">
          <div class="success-message"></div>
        </div>
        <div class="column">
          <div class="column-100">
            <?php echo get_input('text', 'name', 'fornecedor'); ?>
            <?php echo get_input('hidden', 'id', 'ID'); ?>
            <?php echo get_input('hidden', 'link', 'link'); ?>
            <?php echo get_input('hidden', 'supplier', 'supplier'); ?>
          </div>
        </div>
        <div class="column">
          <div class="column-50">
            <?php echo get_checkbox('ispreferred', 'preferencial'); ?>
          </div>
        </div>
        <button type="submit" class="btn-blue" id="submit-edit-supplier">inserir</button>
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