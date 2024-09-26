<?php if ($args['map'] == 'army' && $args['type'] == 1): ?>
  <table class="map-army-detailed">
    <tr>
      <td>
        <p>
          <strong>EXMO.SR.<br />
            GENERAL COMANDANTE DA 2° REGIÃO MILITAR - S.F.P.C./2.</strong>
        </p>
        <p>
          A firma <strong>MOGIGLASS ARTIGOS PARA LABORATORIOS LTDA</strong> estabelecida à <strong>RUA FRANCISCO FRANCO,
            511 - CENTRO - MOGI DAS CRUZES - SP CEP: 08710590</strong> do Certificado de Registro No
          <strong><?php echo $args['certificate']; ?></strong>, válido até
          <strong><?php echo $args['certificateduedate']; ?></strong>, apresenta a V. EXA.
          o mapa trimestral de estocagem de produtos controlados referente ao
          <strong><?php echo $args['quarter'] . '° trim ' . $args['year']; ?></strong> , de
          acordo com o Regulamento aprovado pelo decreto N" 3.665 de 20 de novembro de 2000, para Fiscalização de Produtos
          Controlados (R-105).
        </p>
      </td>
    </tr>
  </table>

  <table class="map-army-detailed">
    <tr>
      <td style="width: 35%;"><strong>Produtos</strong></td>
      <td style="width: 15%;"><strong>Guia</strong></td>
      <td style="width: 5%;"><strong>Entrada</strong></td>
      <td style="width: 5%;"><strong>Estoque Trimestral Anterior</strong></td>
      <td style="width: 5%;"><strong>Consumo ou Venda</strong></td>
      <td style="width: 5%;"><strong>Estoque Trimestral Seguinte</strong></td>
      <td style="width: 30%;"><strong>Procedência</strong></td>
    </tr>
    <?php foreach ($map as $key => $value): ?>
      <tr>
        <td style="width: 35%;"><?php echo $value->itemid . ' | ' . $value->itemname; ?></td>
        <td style="width: 15%;"><?php echo $value->trafficguide; ?></td>
        <td style="width: 5%;"><?php echo $value->in ?? 0; ?></td>
        <td style="width: 5%;"><?php echo $value->before; ?></td>
        <td style="width: 5%;"><?php echo $value->out ?? 0; ?></td>
        <td style="width: 5%;"><?php echo $value->after; ?></td>
        <td style="width: 30%;">
          <?php echo $value->entitydocument . ' ' . mb_strtoupper($value->entitylegalname, 'UTF-8') . '<br/>' . mb_strtoupper($value->entityaddress, 'UTF-8'); ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>

  <table class="map-army-detailed" style="width: 100%;">
    <tr>
      <td style="width: 50%;" rowspan="6"></td>
      <td style="width: 30%;"><strong>Local de Emissão</strong></td>
      <td style="width: 20%;"><strong>Data de Emissão</strong></td>
    </tr>
    <tr>
      <td style="width: 50%; height: 50px;" colspan="2"></td>
    </tr>
    <tr>
      <td style="width: 50%;" colspan="2"><strong>Assinatura do Responsável</strong></td>
    </tr>
    <tr>
      <td style="width: 50%;  height: 50px;" colspan="2"></td>
    </tr>
    <tr>
      <td style="width: 50%;" colspan="2"><strong>Nome do Responsável</strong></td>
    </tr>
    <tr>
      <td style="width: 50%;  height: 50px;" colspan="2"></td>
    </tr>
  </table>
<?php endif; ?>

<?php if ($args['map'] == 'army' && $args['type'] == 2): ?>
  <table class="map-army-concise">
    <tr>
      <td>
        <p>
          <strong>EXMO.SR.<br />
            GENERAL COMANDANTE DA 2° REGIÃO MILITAR - S.F.P.C./2.</strong>
        </p>
        <p>
          A firma <strong>MOGIGLASS ARTIGOS PARA LABORATORIOS LTDA</strong> estabelecida à <strong>RUA FRANCISCO FRANCO,
            511 - CENTRO - MOGI DAS CRUZES - SP CEP: 08710590</strong> do Certificado de Registro No
          <strong><?php echo $args['certificate']; ?></strong>, válido até
          <strong><?php echo $args['certificateduedate']; ?></strong>, apresenta a V. EXA.
          o mapa trimestral de estocagem de produtos controlados referente ao
          <strong><?php echo $args['quarter'] . '° trim ' . $args['year']; ?></strong> , de
          acordo com o Regulamento aprovado pelo decreto N" 3.665 de 20 de novembro de 2000, para Fiscalização de Produtos
          Controlados (R-105).
        </p>
      </td>
    </tr>
  </table>

  <table class="map-army-concise">
    <tr>
      <td><strong>Produto Controlado</strong></td>
      <td><strong>Entrada</strong></td>
      <td><strong>Estoque Trimestral Anterior</strong></td>
      <td><strong>Consumo ou Venda</strong></td>
      <td><strong>Estoque Trimestral Seguinte</strong></td>
      <td><strong>Unidade de Medida</strong></td>
    </tr>
    <?php foreach ($map as $key => $value): ?>
      <tr>
        <td><?php echo $value->itemname; ?></td>
        <td><?php echo $value->in ?? 0; ?></td>
        <td><?php echo $value->before; ?></td>
        <td><?php echo $value->out ?? 0; ?></td>
        <td><?php echo $value->after; ?></td>
        <td><?php echo 'UNID'; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

<?php if ($args['map'] == 'civilpolice'): ?>
  <table class="map-civil-police" style="width: 100%;">
    <tr>
      <td style="width: 50%;">
        <p>
          SECRETARIA DE SEGURANÇA PÚBLICA<br />
          DEPARTAMENTO ESTADUAL DE POLÍCIA ADMINISTRATIVA<br />
          DIVISÃO DE PRODUTOS CONTROLADOS<br />
          DELEGACIA SECCIONAL DE POLÍCIA DE MOGI DAS CRUZES<br />
          <strong>"SETOR DE PRODUTOS CONTROLADOS"</strong>
        </p>
      </td>
      <td style="width: 50%;">
        <p>
          <strong>"RELAÇÃO DE COMPRAS / VENDAS / ESTOQUES"</strong>
        </p>
      </td>
    </tr>
    <tr>
      <td style="text-align: center;" colspan="2">
        <p>
          <strong>MOGIGLASS ARTIGOS PARA LABORATORIOS LTDA | 66.886.052/0001-15 | RUA FRANCISCO FRANCO, 511 - CENTRO -
            MOGI DAS CRUZES - SP CEP: 08710590</strong>
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <p>
          MÊS DE <?php echo $args['month']; ?> | ANO <?php echo $args['year']; ?> | LICENÇA
          <?php echo $args['certificate']; ?>
        </p>
      </td>
    </tr>
  </table>

  <table class="map-civil-police">
    <tr style="text-align: left;" class="dark">
      <td><strong>PRODUTO</strong></td>
      <td><strong>DATA</strong></td>
      <td><strong>NFe</strong></td>
      <td><strong>CNPJ | RAZÃO SOCIAL</strong></td>
      <td><strong>ENDEREÇO</strong></td>
      <td><strong>ENTR</strong></td>
      <td><strong>SAÍDA</strong></td>
    </tr>
    <?php $i = 1; ?>
    <?php foreach ($map as $key => $value): ?>
      <tr class="<?php echo $i % 2 == 0 ? 'dark' : null; ?>">
        <td style="width: 40%;"><?php echo $value->itemid . ' | ' . $value->itemname; ?></td>
        <td style="width: 7%;"><?php echo $value->fiscaldocdate; ?></td>
        <td style="width: 7%;"><?php echo $value->fiscaldocnumber; ?></td>
        <td style="width: 20%;">
          <?php echo $value->entitydocument . ' | ' . mb_strtoupper($value->entitylegalname, 'UTF-8'); ?>
        </td>
        <td style="width: 20%;"><?php echo mb_strtoupper($value->entityaddress, 'UTF-8'); ?></td>
        <td style="width: 3%;" style="text-align: right;"><?php echo $value->in; ?></td>
        <td style="width: 3%;" style="text-align: right;"><?php echo $value->out; ?></td>
      </tr>
      <?php $i++; ?>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

<?php if ($args['map'] == 'federalpolice'): ?>
  <?php $i = 1; ?>
  <?php foreach ($map as $key => $value): ?>
    <table class="map-federal-police <?php echo $i % 2 == 0 ? 'dark' : null; ?>" style="width: 100%;">
      <tr>
        <td style="width: 5%;">
          <p><strong>CFOP</strong></p>
        </td>
        <td style="width: 20%;">
          <p><strong>CNPJ | RAZÃO SOCIAL</strong></p>
        </td>
        <td style="width: 5%;">
          <p><strong>NFe</strong></p>
        </td>
        <td style="width: 10%;">
          <p><strong>DATA</strong></p>
        </td>
        <td style="width: 10%;">
          <p><strong>NCM</strong></p>
        </td>
        <td style="width: 30%;">
          <p><strong>DESCRIÇÃO DO PRODUTO</strong></p>
        </td>
        <td style="width: 5%;">
          <p><strong>CONC</strong></p>
        </td>
        <td style="width: 5%;">
          <p><strong>DENS</strong></p>
        </td>
        <td style="width: 5%;">
          <p><strong>QTD</strong></p>
        </td>
        <td style="width: 5%;">
          <p><strong>UN</strong></p>
        </td>
      </tr>
      <tr>
        <td><?php echo $value->cfop; ?></td>
        <td><?php echo $value->entitydocument . ' | ' . mb_strtoupper($value->entitylegalname, 'UTF-8'); ?></td>
        <td><?php echo $value->fiscaldocnumber; ?></td>
        <td><?php echo $value->fiscaldocdate; ?></td>
        <td><?php echo $value->ncm; ?></td>
        <td><?php echo $value->itemexternalid . ' | ' . $value->itemname; ?></td>
        <td><?php echo $value->concentration; ?></td>
        <td><?php echo $value->density; ?></td>
        <td><?php echo $value->in . $value->out; ?></td>
        <td><?php echo $value->conversionunit; ?></td>
      </tr>
      <tr>
        <td colspan="2">
          <p><strong>TIPO DE FRETE</strong></p>
        </td>
        <td colspan="3">
          <p><strong>CNPJ | RAZÃO SOCIAL - TRANSPORTADORA</strong></p>
        </td>
        <td colspan="5">
          <p><strong>ENDEREÇO DE ENTREGA</strong></p>
        </td>
      </tr>
      <tr>
        <td colspan="2"><?php echo mb_strtoupper($value->freighttypename, 'UTF-8'); ?></td>
        <td colspan="3"><?php echo $value->carrierdocument . ' | ' . mb_strtoupper($value->carriername, 'UTF-8'); ?></td>
        <td colspan="5"><?php echo mb_strtoupper($value->shippingaddress, 'UTF-8'); ?></td>
      </tr>
    </table>
    <?php $i++; ?>
  <?php endforeach; ?>
<?php endif; ?>
