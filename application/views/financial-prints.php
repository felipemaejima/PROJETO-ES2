<div class="prints">
    <div class="container">
        <div class="box">
            <div class="box-content">
                <div class="box-infos">
                    <div class="column print-header-top">
                        <div class="column-20">
                            <div class="logo-subsidiary">
                                <?php if ($query[0]->logo): ?>
                                    <img src="<?php echo base_url($query[0]->logo); ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="column-60">
                            <div class="print-subsidiary">
                                <h4><?php echo $query[0]->legalname ? $query[0]->legalname : ''; ?></h4>
                            </div>
                            <p><?php echo $query[0]->subsidiary_address ? $query[0]->subsidiary_address : ''; ?></p>
                            <div class="print-legaldata">
                                <h4>CNPJ</h4>
                                <p><?php echo $query[0]->cnpj ? $query[0]->cnpj : ''; ?></p>
                                <h4>IE</h4>
                                <p><?php echo $query[0]->ie ? $query[0]->ie : ''; ?></p>
                            </div>
                        </div>
                        <div class="column-20 ">
                            <div class="print-salesman">
                                <p><?php echo $query[0]->salesmanname ? $query[0]->salesmanname : ''; ?></p>
                            </div>
                            <div class="print-emails">
                                <h4><?php echo $query[0]->emailprefix . $query[0]->emailsuffix?>
                                </h4>
                                <h4>www.mogiglass.com.br</h4>
                            </div>
                            <h4>11 4723-4110</h4>
                        </div>
                    </div>
                    <div class="column print-header-content">
                        <div class="column-80">
                            <div>
                                <h3 class="print-title">
                                    <?php echo $query[0]->tranid ? $query[0]->tranid : ''; ?>
                                </h3>
                            </div>
                        </div>
                        <div class="column-20">
                            <div class="print-date">
                                <h3>Data</h3>
                            </div>
                        </div>
                    </div>

                    <div class="column print-header-bottom">
                        <div class="column-60">
                            <div class="print-customer">
                                <h3> <?php echo $query[0]->customername ? $query[0]->customername : ''; ?></h3>
                            </div>

                            <div class="document">
                                <h3><?php echo $query[0]->entity_document ? $query[0]->entity_document : ''; ?>
                                    <?php echo $query[0]->entity_legalname ? $query[0]->entity_legalname : ''; ?>
                                </h3>
                            </div>

                            <div class="service"></div>
                            <h5>Endereço de Entrega:</h5>
                            <p><?php echo $query[0]->shippingaddress ? $query[0]->shippingaddress : ''; ?></p>

                            <div class="column-70"
                                style="display:flex; justify-content: space-between; flex-direction: row;">
                                <div class="column-35">
                                    <h5>Transportadora:</h5>
                                    <p><?php echo $query[0]->carriername ? $query[0]->carriername : ''; ?></p>
                                </div>
                                <div class="column-35">
                                    <h5>Tipo de Frete:</h5>
                                    <p><?php echo $query[0]->freighttypename ? $query[0]->freighttypename : ''; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="column-30 print-more-info">
                            <div class="payment-condition">
                                <h5>Condição de Pagamento:</h5>
                                <p><?php echo $query[0]->termsname ? $query[0]->termsname : ''; ?></p>
                            </div>
                            <div class="delivery-time">
                                <h5>Prazo de entrega:</h5>
                                <p>Informação descrita abaixo</p>
                            </div>

                            <div class="invoicing-minimum">
                                <h5>Faturamento Mínimo:</h5>

                                <p><?php echo 'R$' . $query[0]->minimumturnover ? 'R$' . $query[0]->minimumturnover : ''; ?>
                                </p>
                            </div>

                            <div class="proposed-validity">
                                <h5>Validade da proposta:</h5>
                                <p>
                                    <?php echo date('d/m/Y', $query[0]->validity); ?>
                                </p>
                            </div>

                            <div class="customer-request">
                                <h5>Pedido do Cliente:</h5>
                                <p><?php echo $query[0]->customerpurchaseorder; ?></p>
                            </div>

                            <div class="sales-order">
                                <h5>Pedido de Venda:</h5>
                                <p><?php echo '#' . $query[0]->tranid ? '#' . $query[0]->tranid : ''; ?></p>
                            </div>
                        </div>
                    </div>
                    <br>

                    <?php if ($page == 'estimate'): ?>
                        <div class="column">
                            <div class="column-100">
                                <p><strong>Sua cobrança só será realizada no momento da emissão da Nota Fiscal e poderão ser
                                        emitidas mais de uma cobrança caso haja necessidade de quebra de faturamento do
                                        pedido.</strong></p>
                                <p>Poderá haver quebra de faturamento e cobrança em caso de Entregas parciais por itens sem
                                    estoque, produtos controlados, serviços etc.</p>
                            </div>
                        </div>
                        <div class="column">
                            <div class="overflow">
                                <div class="table table-prints table-estimate">
                                    <div class="table-head" style="min-width: 1020px; max-width: 100%;">
                                        <div class="column" style="min-width: 70px; padding-right: 1rem;"></div>
                                        <div class="column" style="min-width: 500px; padding-right: 1rem;">produto</div>
                                        <div class="column" style="min-width: 100px; padding-right: 1rem;">qtde</div>
                                        <div class="column" style="min-width: 100px; padding-right: 1rem;">uni</div>
                                        <div class="column" style="min-width: 125px; padding-right: 1rem;">valor</div>
                                        <div class="column" style="min-width: 125px; padding-right: 1rem;">total</div>
                                    </div>

                                    <?php foreach ($estimateitems as $item):?>
                                        <div class="table-content"
                                            style="min-width: 1020px; max-width: 100%; align-items: start;">
                                            <div class="column" style="min-width: 70px; padding-right: 1rem;" title="linha">
                                                <input type="hidden" name="itemid[]" value="">
                                                <p><strong><?php echo $item->itemline; ?></strong></p>
                                            </div>
                                            <div class="column product"
                                                style="min-width: 500px; padding-right: 1rem; display: flex; flex-direction: column; align-items: start;"
                                                title="produto">
                                                <input type="hidden" name="productname[]" value="">
                                                <h4><?php echo $item->itemname; ?></h4>

                                                <div class="items-data">
                                                    <div class="top-itemdata">
                                                        <?php if ($item->brandname): ?>
                                                            <p><strong>MARCA:</strong> <?php echo $item->brandname; ?></p>
                                                        <?php endif; ?>

                                                        <?php if ($item->salescode): ?>
                                                            <p><strong>CÓDIGO:</strong>: <?php echo $item->salescode; ?></p>
                                                        <?php endif; ?>

                                                        <?php if ($item->manufacturercode): ?>
                                                            <p><strong>REFERÊNCIA:</strong> <?php echo $item->manufacturercode; ?>
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                    <div class="top-itemdata">
                                                        <?php if ($item->ncm): ?>
                                                            <p><strong>NCM:</strong> <?php echo $item->ncm; ?></p>
                                                        <?php endif; ?>
                                                        <?php if ($item->brandname): ?>
                                                            <p><strong>ICMS:</strong> <?php echo $item->brandname; ?></p>
                                                        <?php endif; ?>
                                                        <?php if ($item->onucode): ?>
                                                            <p><strong>ONU:</strong> <?php echo $item->onucode; ?></p>
                                                        <?php endif; ?>
                                                        <?php if ($item->riskclass): ?>
                                                            <p><strong>CLASSE DE RISCO:</strong> <?php echo $item->riskclass; ?></p>
                                                        <?php endif; ?>
                                                        <?php if ($item->packinggroup): ?>
                                                            <p><strong>GE:</strong> <?php echo $item->packinggroup; ?></p>
                                                        <?php endif; ?>
                                                        <?php if ($item->risknumber): ?>
                                                            <p><strong>RISCO:</strong> <?php echo $item->risknumber; ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <?php if ($item->ischemical == 'T'): ?>
                                                    <div class="column-100 item-iscontrolled">
                                                        <input type="hidden" name="civilpolice"
                                                            value="<?php echo $item->iscontrolledcivilpolice; ?>">
                                                        <label for="" class="civilpolice">Polícia civil</label>

                                                        <input type="hidden" name="army"
                                                            value="<?php echo $item->iscontrolledarmy; ?>">
                                                        <label for="" class="army">Exército</label>

                                                        <input type="hidden" name="federalpolice"
                                                            value="<?php echo $item->iscontrolledfederalpolice; ?>">
                                                        <label for="" class="federalpolice">Polícia federal</label>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="bottom-itemdata">
                                                    <?php if ($item->image): ?>
                                                        <img style="max-width: 10rem; max-height: 8rem;"
                                                            src="<?php echo strpos($item->image, 'http') !== FALSE ? $item->image : base_url($item->image); ?>">
                                                    <?php endif; ?>

                                                    <?php if ($item->itemdescription != '""'): ?>
                                                        <p><?php echo $item->itemdescription; ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="column" style="min-width: 100px; padding-right: 1rem;"
                                                title="quantidade">
                                                <input type="hidden" name="quantity[]" value="">
                                                <p><strong><?php echo $item->itemquantitybudgeted; ?></strong></p>
                                            </div>
                                            <div class="column" style="min-width: 100px; padding-right: 1rem;" title="unidade">
                                                <input type="hidden" name="unit[]" value="">
                                                <p><strong><?php echo $item->saleunitname; ?></strong></p>
                                            </div>
                                            <div class="column" style="min-width: 125px; padding-right: 1rem;" title="valor">
                                                <input type="hidden" name="value[]" value="">
                                                <p><strong><?php echo 'R$' . $item->itemprice; ?></strong></p>
                                            </div>
                                            <div class="column" style="min-width: 125px; padding-right: 1rem;" title="total">
                                                <input type="hidden" name="total[]" value="">
                                                <p><strong><?php echo 'R$' . $item->itemtotal; ?></strong></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <div class="column-100 print-footer">
                                        <div class="resume-data">
                                            <div class="column-80 resume-top">
                                                <textarea name="observations" style="min-width: 100%; min-height: 5rem;"
                                                    readonly>OBSERVAÇÕES</textarea>
                                            </div>
                                            <div class="column-20">
                                                <p>Total dos itens: <?php echo $itemstotal ? 'R$' . $itemstotal : 'R$0,00'; ?>
                                                </p>
                                                <p>Desconto:
                                                    <?php echo $query[0]->discount ? 'R$' . $query[0]->discount : 'R$0,00'; ?>
                                                </p>
                                                </p>
                                                <p>Valor do Frete:
                                                    <?php echo $query[0]->freight ? 'R$' . $query[0]->freight : 'R$0,00'; ?>
                                                </p>
                                                </p>
                                                <p><strong>Total do pedido: <?php echo 'R$' . $estimatetotal; ?></strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($page == 'internalsaleorder'): ?>
                        <div class="overflow">
                            <div class="table table-prints table-internalsaleorder">
                                <div class="table-head" style="min-width: 1020px; max-width: 100%;">
                                    <div class="column" style="min-width: 70px; padding-right: 1rem;"></div>
                                    <div class="column" style="min-width: 500px; padding-right: 1rem;">produto</div>
                                    <div class="column" style="min-width: 100px; padding-right: 1rem;">qtde</div>
                                    <div class="column" style="min-width: 100px; padding-right: 1rem;">uni</div>
                                    <div class="column" style="min-width: 125px; padding-right: 1rem;">valor</div>
                                    <div class="column" style="min-width: 125px; padding-right: 1rem;">total</div>
                                </div>

                                <?php foreach ($saleorderitems as $item): ?>
                                    <div class="table-content" style="min-width: 1020px; max-width: 100%; align-items: start;">
                                        <div class="column" style="min-width: 70px; padding-right: 1rem;" title="linha">
                                            <input type="hidden" name="itemid[]" value="">
                                            <p><strong><?php echo $item->itemline; ?></strong></p>
                                        </div>
                                        <div class="column product"
                                            style="min-width: 500px; padding-right: 1rem; display: flex; flex-direction: column; align-items: start;"
                                            title="produto">
                                            <input type="hidden" name="productname[]" value="">
                                            <h4><?php echo $item->itemname; ?></h4>

                                            <div class="items-data">
                                                <div class="top-itemdata">
                                                    <?php if ($item->brandname): ?>
                                                        <p><strong>MARCA:</strong> <?php echo $item->brandname; ?></p>
                                                    <?php endif; ?>

                                                    <?php if ($item->salescode): ?>
                                                        <p><strong>CÓDIGO:</strong>: <?php echo $item->salescode; ?></p>
                                                    <?php endif; ?>

                                                    <?php if ($item->manufacturercode): ?>
                                                        <p><strong>REFERÊNCIA:</strong> <?php echo $item->manufacturercode; ?>
                                                        </p>
                                                    <?php endif; ?>

                                                    <p><strong>FORNECEDOR:</strong> <?php echo $item->name; ?></p>
                                                    <br>
                                                    <div class="column storage"
                                                        style="display: flex; flex-direction: row; gap: 1rem; white-space: nowrap;">
                                                        <?php if ($item->pavilion): ?>
                                                            <p><strong>PAVILHÃO:
                                                                </strong><?php echo str_replace(array('[', ']', "'", '"'), '', $item->pavilion) ?>
                                                            </p>
                                                        <?php endif; ?>

                                                        <?php if ($item->street): ?>
                                                            <p><strong>RUA:
                                                                </strong><?php echo str_replace(array('[', ']', "'", '"'), '', $item->street); ?>
                                                            </p>
                                                        <?php endif; ?>

                                                        <?php if ($item->pallet): ?>
                                                            <p><strong>PALETE:
                                                                </strong><?php echo str_replace(array('[', ']', "'", '"'), '', $item->pallet); ?>
                                                            </p>
                                                        <?php endif; ?>

                                                        <?php if ($item->hall): ?>
                                                            <p><strong>CORREDOR:
                                                                </strong><?php echo str_replace(array('[', ']', "'", '"'), '', $item->hall); ?>
                                                            </p>
                                                        <?php endif; ?>


                                                        <p><strong>PRATELEIRA: </strong>
                                                            <?php
                                                            $found_shelf = false;
                                                            foreach ($shelfs as $shelf) {
                                                                if (!empty($item->$shelf)) {
                                                                    echo str_replace(array('[', ']', "'", '"'), '', $item->$shelf);
                                                                    $found_shelf = true;
                                                                    break;
                                                                }
                                                            }
                                                            if (!$found_shelf) {
                                                                echo ',,,,,,';
                                                            }
                                                            ?>
                                                        </p>

                                                    </div>
                                                </div>
                                                <div class="top-itemdata">
                                                    <?php if ($item->ncm): ?>
                                                        <p><strong>NCM:</strong> <?php echo $item->ncm; ?></p>
                                                    <?php endif; ?>
                                                    <?php if ($item->onucode): ?>
                                                        <p><strong>ONU:</strong> <?php echo $item->onucode; ?></p>
                                                    <?php endif; ?>
                                                    <?php if ($item->riskclass): ?>
                                                        <p><strong>CLASSE DE RISCO:</strong> <?php echo $item->riskclass; ?></p>
                                                    <?php endif; ?>
                                                    <?php if ($item->packinggroup): ?>
                                                        <p><strong>GE:</strong> <?php echo $item->packinggroup; ?></p>
                                                    <?php endif; ?>
                                                    <?php if ($item->risknumber): ?>
                                                        <p><strong>RISCO:</strong> <?php echo $item->risknumber; ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <?php if ($item->ischemical == 'T'): ?>
                                                <div class="column-100 item-iscontrolled">
                                                    <input type="hidden" name="civilpolice"
                                                        value="<?php echo $item->iscontrolledcivilpolice; ?>">
                                                    <label for="" class="civilpolice">Polícia civil</label>

                                                    <input type="hidden" name="army" value="<?php echo $item->iscontrolledarmy; ?>">
                                                    <label for="" class="army">Exército</label>

                                                    <input type="hidden" name="federalpolice"
                                                        value="<?php echo $item->iscontrolledfederalpolice; ?>">
                                                    <label for="" class="federalpolice">Polícia federal</label>
                                                </div>
                                            <?php endif; ?>

                                            <div class="bottom-itemdata">
                                                <?php if ($item->image): ?>
                                                    <img style="max-width: 10rem; max-height: 8rem;"
                                                        src="<?php echo strpos($item->image, 'http') !== FALSE ? $item->image : base_url($item->image); ?>">
                                                <?php endif; ?>

                                                <?php if ($item->itemdescription != '""'): ?>
                                                    <p><?php echo $item->itemdescription; ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="column" style="min-width: 100px; padding-right: 1rem;" title="quantidade">
                                            <input type="hidden" name="quantity[]" value="">
                                            <p><strong><?php echo $item->itemquantity; ?></strong></p>
                                        </div>
                                        <div class="column"
                                            style="min-width: 100px; padding-right: 1rem; display :flex; flex-direction: column; justify-content: start;"
                                            title="unidade">
                                            <input type="hidden" name="unit[]" value="">
                                            <p><strong><?php echo $item->saleunitname; ?></strong></p>
                                        </div>
                                        <div class="column"
                                            style="min-width: 125px; padding-right: 1rem; display :flex; flex-direction: column; justify-content: start"
                                            title="valor">
                                            <input type="hidden" name="value[]" value="">
                                            <p><strong><?php echo 'R$' . $item->itemprice; ?></strong></p>
                                            <p>n° série/lote:</p>
                                            <p>fab:</p>
                                            <p>val:</p>
                                        </div>
                                        <div class="column" style="min-width: 125px; padding-right: 1rem;" title="total">
                                            <input type="hidden" name="total[]" value="">
                                            <p><strong><?php echo 'R$' . $item->itemtotal; ?></strong></p>
                                            <p>_______________________</p>
                                            <p>_______________________</p>
                                            <p>_______________________</p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <div class="column-100 print-footer">
                                    <div class="column-100 resume-data">
                                        <div class="column-80 resume-top">
                                            <textarea name="observations" readonly>OBSERVAÇÕES:</textarea>
                                        </div>
                                        <div class="column-20">
                                            <p>Total dos itens: <?php echo $itemstotal ? 'R$' . $itemstotal : 'R$0,00'; ?>
                                            </p>
                                            <p>Desconto:
                                                <?php echo $query[0]->discount ? 'R$' . $query[0]->discount : 'R$0,00'; ?>
                                            </p>
                                            <p>Valor do Frete:
                                                <?php echo $query[0]->freight ? 'R$' . $query[0]->freight : 'R$0,00'; ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="column-100 resume-data">
                                        <div class="column-80 resume-top">
                                            <textarea name="notes" readonly>NOTAS:</textarea>
                                        </div>
                                        <div class="column-20">
                                            <p><strong>Total do pedido:
                                                    <?php echo $saleordertotal ? 'R$' . $saleordertotal : 'R$0,00'; ?></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="column-100 additional-information"
                            style="display: flex; justify-content: space-between; flex-direction: row;">
                            <div class="overflow">
                                <div class="table">
                                    <div class="table-head" style="min-width: 375px; max-width: 100%;">
                                        <div class="column" style="min-width: 125px; padding-right: 1rem;">
                                            quantidade</div>
                                        <div class="column" style="min-width: 125px; padding-right: 1rem; text-align: center;">peso bruto</div>
                                        <div class="column" style="min-width: 125px; padding-right: 1rem;">peso líquido</div>
                                    </div>

                                    <?php for ($i = 0; $i < 3; $i++) { ?>
                                        <div class="table-content" style="min-width: 375px; max-width: 100%;">
                                        </div>
                                        <hr>
                                    <?php }
                                    ; ?>
                                </div>
                            </div>
                            <div class="column" style="display: flex; flex-direction: column;">
                                <div class="overflow">
                                    <div class="table">
                                        <div class="table-head" style="min-width: 400px; max-width: 100%;">
                                            <div class="column" style="min-width: 200px; padding-right: 1rem;">
                                                motorista
                                            </div>
                                            <div class="column"
                                                style="min-width: 200px; padding-right: 1rem; justify-content: end;">carro
                                            </div>
                                        </div>

                                        <div class="table-content" style="min-width: 400px; max-width: 100%;">
                                        </div>
                                    </div>
                                </div>

                                <div class="overflow">
                                    <div class="table">
                                        <div class="table-head" style="min-width: 400px; max-width: 100%;">
                                            <div class="column" style="min-width: 200px; padding-right: 1rem;">
                                                entregue
                                            </div>
                                            <div class="column"
                                                style="min-width: 200px; padding-right: 1rem; justify-content: end;">__sim
                                                __não
                                            </div>
                                        </div>

                                        <div class="table-content" style="min-width: 400px; max-width: 100%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>