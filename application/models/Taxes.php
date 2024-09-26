<?php
defined('BASEPATH') or exit('No direct script access allowed');

// referencias
$items = array(
  (object) array(
    'id' => 'teste',
    'link' => 'refererid',
    'itemid' => '41625',
    'itemline' => '1',
    'itemname' => "BOMBA DE VACUO DE ALTO VACUO E400",
    'ncm' => '84148019',
    'ncmid' => '08f8c4e5-6ea2-fc96-04ec-481b83cfba63',
    'ncmdescription' => 'Outras',
    'ncmaliquotfiscalincentive' => '',
    'ncmdescriptionfiscalincentive' => '',
    'ncmbasereduction' => '',
    'ncmdescriptionbasereduction' => '',
    'itemoriginid' => 'c9ee280f-1cc6-57e6-3b88-3e5077cf29d4',
    'itemoriginname' => '2 - estrangeira - adquirida no mercado interno, exceto a indicada no código 7',
    'itemorigincode' => '2',
    'cest' => null,
    'stfactor' => null,
    'icmstaxincentive' => null,
    'cfop' => '6.912',
    'saleunitname' => 'PÇ',
    'itemquantity' => 1,
    'itemprice' => 2630,
    'itemgrossvalue' => 2630,
    'itemdiscount' => 0,
    'itemfreight' => 0,
    'itemtotal' => 2630,
    'additionalinformation' => null,
    'taxes' => (object) array(
      'pis' => (object) array(
        'link' => 'saleorderid',
        'line' => '1',
        'itemid' => '41008',
        'itemname' => 'PEDESTAL MOTORIZADO P/PLATAFORMA C/MOVIMENTO NA VERTICAL',
        'ncm' => '73269090',
        'ncmdescription' => 'Outras',
        'itemoriginid' => 'a44a3637-5de4-5dcc-0270-7cea7cf07f83',
        'itemoriginname' => '1 - estrangeira - importação direta, exceto a indicada no código 6',
        'linenetvalue' => 11806,
        'calculationbase' => 0,
        'taxname' => 'PIS',
        'aliquot' => 0,
        'taxvalue' => 0,
        'cst' => '49'
      ),
      'cofins' => (object) array(
        'link' => 'saleorderid',
        'line' => '1',
        'itemid' => '41008',
        'itemname' => 'PEDESTAL MOTORIZADO P/PLATAFORMA C/MOVIMENTO NA VERTICAL',
        'ncm' => '73269090',
        'ncmdescription' => 'Outras',
        'itemoriginid' => 'a44a3637-5de4-5dcc-0270-7cea7cf07f83',
        'itemoriginname' => '1 - estrangeira - importação direta, exceto a indicada no código 6',
        'linenetvalue' => 11806,
        'calculationbase' => 0,
        'taxname' => 'COFINS',
        'aliquot' => 0,
        'taxvalue' => 0,
        'cst' => '49'
      ),
      'icms' => (object) array(
        'link' => 'saleorderid',
        'line' => '1',
        'itemid' => '41008',
        'itemname' => 'PEDESTAL MOTORIZADO P/PLATAFORMA C/MOVIMENTO NA VERTICAL',
        'ncm' => '73269090',
        'ncmdescription' => 'Outras',
        'itemoriginid' => 'a44a3637-5de4-5dcc-0270-7cea7cf07f83',
        'itemoriginname' => '1 - estrangeira - importação direta, exceto a indicada no código 6',
        'linenetvalue' => 11806,
        'calculationbase' => 11806,
        'taxname' => 'ICMS',
        'aliquot' => 0,
        'taxvalue' => 0,
        'cst' => '41'
      )
    )
  )
);

$client = (object) array(
  'legalname' => 'SOFTYS BRASIL LTDA',
  'isperson' => '0818c95f-fbc6-de7b-9f5c-6cead82742ee',
  'persontype' => 'Jurídica',
  'document' => '44145845001112',
  'ie' => '239015473111',
  'ieexempt' => 'F',
  'ieimmune' => 'F',
  'icmstaxpayer' => 'T',
  'simplesnacional' => 'F',
  'mei' => 'F',
  'publicentityexempticms' => 'F',
  'activitysector' => '415d28a3-1962-9af7-ac80-09221524e598',
);

$clientaddresses = array(
  (object) array(
    'street' => 'Rodovia Presidente Tancredo de Almeida Neves',
    'city' => 'CAIEIRAS',
    'citycode' => '3509007',
    'zip' => '07705000',
    'number' => 'S/N',
    'state' => 'SP',
    'country' => 'Brasil',
    'countrycode' => '1058',
    'neighborhood' => 'ZONA RURAL',
    'complement' => null,
    'standardbilling' => 'T',
    'standardshipping' => 'T'
  )
);

class Taxes extends CI_Model
{

  /**
   * Calcula os impostos dos itens com base na referer name e referer ID.
   *
   * @param string $referername O nome da funcionalidade. Aceita 'invoice', 'saleorder' ou 'estimate'.
   * @param string $refererid o id do registro que terá os impostos dos itens calculados.
   * @param string $userid o id do usuario para o log dos impostos. Passar usando o atributo do controlador pai.
   * @param string $userroles um json que contém os roles do usuario para o log dos impostos. Passar usando o atributo do controlador pai.
   * @return bool|array faz as devidas operações no banco de dados e retorna um array quando as operações 
   * forem bem sucedidas ou FALSE caso ocorra algum erro.
   */
  public function calculatetaxes(string $referername, string $refererid, string $userid, string $userroles)
  {

    $referertable = NULL;
    $referertableitems = NULL;
    $referertabletaxes = NULL;

    // obtem os dados da referer
    switch ($referername) {
      case 'estimate':
        $referertable = 'estimates';
        $referertableitems = 'estimateitems';
        $referertabletaxes = 'estimatetax';
        break;
      case 'saleorder':
        $referertable = 'salesorders';
        $referertableitems = 'saleorderitems';
        $referertabletaxes = 'saleordertax';
        break;
      case 'invoice':
        $referertable = 'invoices';
        $referertableitems = 'invoiceitems';
        $referertabletaxes = 'invoicetax';
        break;
      default:
        return FALSE;
    }

    if (!$referertable || !$referertableitems || !$referertabletaxes) {
      return FALSE;
    }

    $refererdata = $this->db->where('id', $refererid)->get($referertable)->result()[0];

    // dados do cliente para o cálculo dos impostos
    $client = $this->db->select('
      entities.legalname as legalname,
      entities.isperson as isperson,
      types.title as persontype,
      entities.document as document,
      entities.ie as ie,
      entities.ieexempt as ieexempt,
      entities.ieimmune as ieimmune,
      entities.icmstaxpayer as icmstaxpayer,
      entities.simplesnacional as simplesnacional,
      entities.mei as mei,
      entities.publicentityexempticms as publicentityexempticms,
      entities.activitysector as activitysector
      ')
      ->join('types', 'types.id = entities.isperson', 'LEFT')
      ->where('entities.id', $refererdata->customerid)
      ->get('entities')
      ->result()[0];

    // remove caracteres especiais do documento
    $client->document = clear_string($client->document);

    // verifica o endereço de cobrança padrao do cliente
    $clientbilladdress = $this->db->select('street, number, zip, neighborhood, complement, city, citycode, state, country, standardbilling, standardshipping')
      ->where('addresses.id', $refererdata->billaddressid)
      ->where('addresses.link', $refererdata->customerid)
      ->get('addresses')
      ->result()[0] ?? NULL;

    // caso não haja endereço, busca o endereço padrão do cliente no banco
    if (!$clientbilladdress) {
      $clientaddresses = $this->db->select('street, number, zip, neighborhood, complement, city, citycode, state, country, standardbilling, standardshipping')
        ->where('addresses.link', $refererdata->customerid)
        ->get('addresses')
        ->result();

      $clientbilladdress = $this->getbilladdress($clientaddresses);
    }

    // remove caracteres especiais do CEP
    $clientbilladdress->zip = clear_string($clientbilladdress->zip);

    // código do IBGE para Brasil
    $clientbilladdress->countrycode = '1058';

    // medida provisória para recuperar o código da cidade até o ajuste na tabela de endereços
    if (!$clientbilladdress->citycode) {
      $city = $this->db->select('id, code')
        ->where('state', strtoupper($clientbilladdress->state))
        ->where('name', mb_strtolower($clientbilladdress->city))
        ->or_where('title', mb_strtoupper($clientbilladdress->city))
        ->get('cities')
        ->result()[0];
  
      $clientbilladdress->citycode = $city->code;
    }

    // itens da referer
    $items = $this->db->select("
      $referertableitems.id as id,
      $referertable.id as link,
      $referertableitems.itemid as itemid,
      $referertableitems.itemline as itemline,
      $referertableitems.itemname as itemname,
      $referertableitems.ncm as ncm,
      $referertableitems.ncmid as ncmid,
      $referertableitems.ncmdescription as ncmdescription,
      COALESCE(ncms.aliquotfiscalincentive, '') as ncmaliquotfiscalincentive, 
      COALESCE(ncms.descriptionfiscalincentive, '') as ncmdescriptionfiscalincentive,
      COALESCE(ncms.basereduction, '') as ncmbasereduction,
      COALESCE(ncms.descriptionbasereduction,'') as ncmdescriptionbasereduction,
      $referertableitems.itemoriginid as itemoriginid,
      $referertableitems.itemoriginname as itemoriginname,
      itemorigintypes.code as itemorigincode,
      $referertableitems.cest as cest,
      $referertableitems.stfactor as stfactor,
      $referertableitems.icmstaxincentive as icmstaxincentive,
      $referertableitems.saleunitname as saleunitname,
      $referertableitems.itemquantity as itemquantity,
      $referertableitems.itemprice as itemprice,
      $referertableitems.itemgrossvalue as itemgrossvalue,
      $referertableitems.itemdiscount as itemdiscount,
      $referertableitems.itemfreight as itemfreight,
      $referertableitems.itemtotal as itemtotal,
      $referertableitems.additionalinformation as additionalinformation,

    ")
      ->join($referertable, "$referertable.id = $referertableitems.link", 'LEFT')
      ->join('itemorigintypes', "itemorigintypes.id = $referertableitems.itemoriginid", 'LEFT')
      ->join('ncms', "ncms.id = $referertableitems.ncmid", 'LEFT')
      ->where("$referertableitems.link", $refererid)
      ->where("$referertableitems.isinactive", 'F')
      ->get($referertableitems)
      ->result();

    // verifica se o item tem ncm e busca o incentivo fiscal e a reducao de base de calculo
    foreach ($items as $key => &$itemreference) {
      if (!$itemreference->ncmid) {
        $ncm = $this->db->select('id, name, description, aliquotfiscalincentive, descriptionfiscalincentive, basereduction, descriptionbasereduction')
          ->where('name', $itemreference->ncm)
          ->where('confirmed', 'T')
          ->get('ncms')
          ->result();

        if (!!$ncm) {
          $itemreference->ncmid = $ncm[0]->id;
          $itemreference->ncmdescription = $ncm[0]->description;
          $itemreference->ncmaliquotfiscalincentive = $ncm[0]->aliquotfiscalincentive;
          $itemreference->ncmdescriptionfiscalincentive = $ncm[0]->descriptionfiscalincentive;
          $itemreference->ncmbasereduction = $ncm[0]->basereduction;
          $itemreference->ncmdescriptionbasereduction = $ncm[0]->descriptionbasereduction;
        }
      }
    }

    // dados da subsidiária
    $subsidiary = $this->db->select('subsidiaries.id, subsidiaries.title, subsidiaries.name, subsidiaries.legalname, subsidiaries.cnpj, subsidiaries.ie, subsidiaries.taxregime, taxregimes.title as taxregimetitle, taxregimes.code as taxregimecode, subsidiaries.hassimplesnacionalicms')
      ->join('taxregimes', 'taxregimes.id = subsidiaries.taxregime', 'LEFT')
      ->where('subsidiaries.id', $refererdata->subsidiaryid)
      ->get('subsidiaries')
      ->result();

    $subsidiaryaddresses = $this->db->select('street, number, zip, neighborhood, complement, city, state, country, standardbilling, standardshipping')
      ->where('addresses.link', $refererdata->subsidiaryid)
      ->get('addresses')
      ->result();

    // verifica o endereço de faturamento padrao da subsidiaria
    $subsidiarybilladdress = $this->getbilladdress($subsidiaryaddresses);

    // verifica as aliquotas dos impostos
    $taxesconsult = $this->db->select('id, name, aliquot')
      ->get('taxes')
      ->result();

    $taxes = new stdClass();

    foreach ($taxesconsult as $row) {
      $name = $row->name;
      $taxes->$name = (object) array(
        'aliquot' => $row->aliquot,
      );
    }

    $icmstaxes = $this->db->select('originuf, destinationuf, cst, basevaluepercentage, basevaluereduction, aliquot, interstatealiquot, basevaluemodality, ajustedmva, fcp, hasst')
      ->where('subsidiaryid', $refererdata->subsidiaryid)
      ->where('originuf', $subsidiarybilladdress->state)
      ->where('destinationuf', $clientbilladdress->state)
      ->get('icmstaxes')
      ->result();

    $taxes->icms = $icmstaxes[0];

    // atribuindo tipos de operação default
    if (empty($refererdata->operationtypeid)) {
      if ($subsidiary[0]->taxregimecode == 1) {
        // VENDA SIMPLES NACIONAL
        $refererdata->operationtypeid = $this->config->item('default_operation_types')['venda_simples_nacional'];
      }

      if ($subsidiary[0]->taxregimecode == 2 || $subsidiary[0]->taxregimecode == 3) {
        // VENDA DE PRODUTOS NFE
        $refererdata->operationtypeid = $this->config->item('default_operation_types')['venda_nfe'];
      }
    }

    // verifica o cfop padrao da operação
    $operationtype = $this->db->select('operationtypes.id, operationtypes.title, operationtypes.name, operationtypes.code, operationtypes.cfopinsidestateid, operationtypes.cfopinsidestate, operationtypes.cfopoutsidestateid, operationtypes.cfopoutsidestate, operationtypes.cfopstinsidestateid, operationtypes.cfopstinsidestate, operationtypes.cfopstoutsidestateid, operationtypes.cfopstoutsidestate, operationtypes.naturetypeid, operationtypes.naturetype, operationnaturetypes.code as naturetypecode, operationtypes.transactiontypeid, operationtypes.transactiontype')
      ->join('operationnaturetypes', 'operationnaturetypes.id = operationtypes.naturetypeid', 'LEFT')
      ->where('operationtypes.id', $refererdata->operationtypeid)
      ->get('operationtypes')
      ->result();

    // verifica o cfop padrao de cada item
    $items = $this->getcfopitems($items, $operationtype[0], $client, $clientbilladdress, $subsidiarybilladdress);

    // faz o calculo dos impostos
    $taxes = $this->gettaxes($items, $client, $clientbilladdress, $subsidiary[0], $subsidiarybilladdress, $operationtype[0], $taxes);

    // deleta do banco as linhas do imposto antigas (se houver)
    $this->db->where('invoiceid', $refererdata->id)
      ->delete($referertabletaxes);

    foreach ($taxes as $invoiceitem) {

      foreach ($invoiceitem->taxes as $tax) {
        $idtax = uuidv4();

        $taxinsert = [
          'id' => $idtax,
          'link' => $invoiceitem->id,
          'invoiceid' => $tax->link,
          'line' => $tax->line,
          'itemid' => $tax->itemid,
          'itemname' => $tax->itemname,
          'ncm' => $tax->ncm,
          'ncmdescription' => $tax->ncmdescription,
          'itemoriginid' => $tax->itemoriginid,
          'itemoriginname' => $tax->itemoriginname,
          'linenetvalue' => $tax->linenetvalue,
          'linegrossvalue' => $invoiceitem->itemgrossvalue,
          'calculationbase' => $tax->calculationbase,
          'taxname' => $tax->taxname,
          'aliquot' => $tax->aliquot,
          'aliquotdestination' => !empty($tax->aliquotdestination) ? $tax->aliquotdestination : '',
          'aliquotsender' => !empty($tax->aliquotsender) ? $tax->aliquotsender : '',
          'taxvalue' => $tax->taxvalue,
          'cst' => $tax->cst,
          'isinactive' => 'F',
          'confirmed' => 'T',
          'ip' => $this->input->ip_address(),
          'platform' => $this->agent->platform(),
          'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
          'referer' => $this->agent->referrer(),
          'created' => time()
        ];

        $this->db->insert($referertabletaxes, $taxinsert);

        $this->data_persistence->log(
          [
            'table' => 'invoicetax',
            'action' => "create $referername tax",
            'status' => 'success',
            'user_id' => $userid,
            'user_role' => $userroles,
            'defined' => $idtax,
            'data' => ['message' => 'Imposto inserido com sucesso.']
          ],
        );
      }

      $itemdata = [
        'cfop' => $invoiceitem->cfop,
      ];

      $this->db->where('id', $invoiceitem->id)
        ->update($referertableitems, $itemdata);

    }
    return $taxes;
  }

  private function getbilladdress($addresses)
  {
    $billaddress = false;
    foreach ($addresses as $row) {
      if ($row->standardbilling == 'T') {
        $billaddress = $row;
        break;
      }
    }
    if (!$billaddress) {
      $billaddress = $addresses[0];
    }
    return $billaddress;
  }

  private function getcfop($operationtype, $client, $clientbilladdress, $subsidiaryaddress)
  {
    // verifica se o estado do cliente e da subsidiaria sao iguais
    $cfop = $clientbilladdress->state == $subsidiaryaddress->state ? $operationtype->cfopinsidestate : $operationtype->cfopoutsidestate;

    /*
     * ------------------------------------------------------------
     * verifica se o estado do cliente e da subsidiaria sao diferentes
     * se o cliente é isento ou imune de ie
     * e se o tipo de operacao for diferente de:
     * 3 - VENDA ENTREGA FUTURA
     * 6 - RETORNO DE DEMONSTRAÇÃO (ENTRADA)
     * 7 - REMESSA PARA CONSERTO (ENTRADA)
     * 8 - REMESSA VENDA ENTREGA FUTURA C/IMPOSTO
     * 9 - RETORNO DE CONSERTO
     * 11 - REMESSA SIMPLES - SEM IMPOSTO
     * 12 - REMESSA PARA DEMONSTRAÇÃO
     * 14 - DEVOLUÇÃO DE VENDA (ENTRADA)
     * 17 - REMESSA PARA DOAÇÃO
     * 19 - SIMPLES REMESSA (ENTRADA)
     * ------------------------------------------------------------
     */

    if (
      $clientbilladdress->state != $subsidiaryaddress->state
      && $client->ieexempt == 'T'
      && !in_array($operationtype->code, array('3', '6', '7', '8', '9', '11', '12', '14', '17', '19'))
    ) {
      $cfop = '6.108';
    }
    return $cfop;
  }

  private function getcfopitems($items, $operationtype, $client, $clientbilladdress, $subsidiaryaddress)
  {
    // verifica se o estado do cliente e da subsidiaria sao iguais
    $cfop = $clientbilladdress->state == $subsidiaryaddress->state ? $operationtype->cfopinsidestate : $operationtype->cfopoutsidestate;

    foreach ($items as $item) {

      $item->cfop = $cfop;

      if ($item->cest) {

        $item->cfop = $clientbilladdress->state == $subsidiaryaddress->state ? $operationtype->cfopstinsidestate : $operationtype->cfopstoutsidestate;

        /*
         * ------------------------------------------------------------
         * verifica se o estado do cliente e da subsidiaria sao iguais
         * ------------------------------------------------------------
         */

        if ($clientbilladdress->state == $subsidiaryaddress->state) {
          $item->cfop = '5.405';
        }

        /*
         * ------------------------------------------------------------
         * verifica se o estado do cliente e da subsidiaria sao diferentes
         * se o cliente é contribuinte de icms
         * e se o tipo de operacao for diferente de:
         * 3 - VENDA ENTREGA FUTURA
         * 6 - RETORNO DE DEMONSTRAÇÃO (ENTRADA)
         * 7 - REMESSA PARA CONSERTO (ENTRADA)
         * 8 - REMESSA VENDA ENTREGA FUTURA C/IMPOSTO
         * 9 - RETORNO DE CONSERTO
         * 11 - REMESSA SIMPLES - SEM IMPOSTO
         * 12 - REMESSA PARA DEMONSTRAÇÃO
         * 14 - DEVOLUÇÃO DE VENDA (ENTRADA)
         * 17 - REMESSA PARA DOAÇÃO
         * 19 - SIMPLES REMESSA (ENTRADA)
         * ------------------------------------------------------------
         */

        if (
          $clientbilladdress->state != $subsidiaryaddress->state
          && ($client->ieexempt == 'T' || $client->ieimmune == 'T')
          && !in_array($operationtype->code, array('3', '6', '7', '8', '9', '11', '12', '14', '17', '19'))
        ) {
          $item->cfop = $operationtype->cfopoutsidestate;
        }

      } else {

        /*
         * ------------------------------------------------------------
         * verifica se o estado do cliente e da subsidiaria sao diferentes
         * se o cliente é isento ou imune de ie
         * e se o tipo de operacao for diferente de:
         * 3 - VENDA ENTREGA FUTURA
         * 6 - RETORNO DE DEMONSTRAÇÃO (ENTRADA)
         * 7 - REMESSA PARA CONSERTO (ENTRADA)
         * 8 - REMESSA VENDA ENTREGA FUTURA C/IMPOSTO
         * 9 - RETORNO DE CONSERTO
         * 11 - REMESSA SIMPLES - SEM IMPOSTO
         * 12 - REMESSA PARA DEMONSTRAÇÃO
         * 14 - DEVOLUÇÃO DE VENDA (ENTRADA)
         * 17 - REMESSA PARA DOAÇÃO
         * 19 - SIMPLES REMESSA (ENTRADA)
         * ------------------------------------------------------------
         */

        if (
          $clientbilladdress->state != $subsidiaryaddress->state
          && ($client->ieexempt == 'T' || $client->ieimmune == 'T')
          && !in_array($operationtype->code, array('3', '6', '7', '8', '9', '11', '12', '14', '17', '19'))
        ) {
          $item->cfop = '6.108';
        }
      }
    }

    return $items;
  }

  private function gettaxes($items, $client, $clientbilladdress, $subsidiary, $subsidiarybilladdress, $operationtype, $taxes)
  {

    foreach ($items as $item) {

      $item->taxes = new stdClass();

      /*
       * ------------------------------------------------------------
       * se o regime tributario do emissor for igual a:
       * 1 - simples nacional
       * ------------------------------------------------------------
       */
      if ($subsidiary->taxregimecode == 1) {

        /*
         * ------------------------------------------------------------
         * se a origem da mercadoria for:
         * 1 - estrangeira - importação direta, exceto a indicada no código 6
         * ------------------------------------------------------------
         */
        if ($item->itemorigincode == '1') {
          $item->originid = 'c9ee280f-1cc6-57e6-3b88-3e5077cf29d4';
          $item->itemoriginname = '2 - estrangeira - adquirida no mercado interno, exceto a indicada no código 7';
          $item->itemorigincode = '2';
        }

        /*
         * ------------------------------------------------------------
         * se a natureza da operacao é igual a:
         * 1 - Entrega futura
         * 2 - Remessa para conserto
         * 3 - Remessa industrialização
         * 4 - Retorno de demonstração (entrada)
         * 5 - Remessa conserto (entrada)
         * 6 - Remessa venda entrega futura (mogiglass) c/ imposto
         * 7 - Retorno conserto
         * 8 - Venda simples nacional (não contribuinte)
         * 9 - Remessa para demonstração
         * 10 - Venda entrega futura simples nacional
         * 12 - Remessa simples - Sem imposto
         * 13 - Remessa para doação
         * ------------------------------------------------------------
         */
        if (in_array($operationtype->naturetypecode, array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '12', '13'))) {

          // operacoes nao tributadas nao se aplica incentivos
          $calculationbase = $item->itemtotal;

          // calcula os impostos do pis
          $this->calculatepis($item, $calculationbase, 0, '99');

          // calcula os impostos do cofins
          $this->calculatecofins($item, $calculationbase, 0, '99');

          // calcula os impostos do icms
          $this->calculateicms($item, 0, $calculationbase, 'ICMS', '102');

        }

        /*
         * ------------------------------------------------------------
         * se a natureza da operacao é igual a:
         * 11 - Devolução de venda (entrada)
         * ------------------------------------------------------------
         */
        if (in_array($operationtype->naturetypecode, array('11'))) {

          // operacoes nao tributadas nao se aplica incentivos
          $calculationbase = $item->itemtotal;

          // calcula os impostos do pis
          $this->calculatepis($item, $calculationbase, 0, '98');

          // calcula os impostos do cofins
          $this->calculatecofins($item, $calculationbase, 0, '98');

          // calcula os impostos do icms
          $this->calculateicms($item, 0, $calculationbase, 'ICMS', '900');

        }


      }

      /*
       * ------------------------------------------------------------
       * se o regime tributario do emissor for igual a:
       * 2 - simples nacional, excesso sublimite de receita
       * 3 - regime normal
       * ------------------------------------------------------------
       */

      if ($subsidiary->taxregimecode == 2 || $subsidiary->taxregimecode == 3) {


        // base de calculo
        $calculationbase = $item->itemtotal;

        // informacoes sobre o pis e cofins
        $aliquotpis = (float) number_format((float) $taxes->pis->aliquot / 100, 4, '.', '');
        $aliquotcofins = (float) number_format((float) $taxes->cofins->aliquot / 100, 4, '.', '');

        // informacoes sobre o icms
        $aliquotfcp = (float) number_format((float) $taxes->icms->fcp / 100, 4, '.', '');
        $aliquoticms = (float) number_format((float) $taxes->icms->aliquot / 100, 4, '.', '');
        $aliquotdestination = (float) number_format((float) $taxes->icms->aliquot / 100, 4, '.', '');
        $aliquotinterstate = (float) number_format((float) $taxes->icms->interstatealiquot / 100, 4, '.', '');
        $aliquotbasevaluereduction = (float) number_format((float) $taxes->icms->basevaluereduction / 100, 4, '.', '');
        $hasst = $taxes->icms->hasst == 'T' ? true : false;

        /*
         * ------------------------------------------------------------
         * se a origem do item é extangeira é igual a:
         * 1 - estrangeira - importação direta, exceto a indicada no código 6
         * 2 - estrangeira - adquirida no mercado interno, exceto a indicada no código 7
         * 3 - nacional, mercadoria ou bem com conteúdo de importação superior a 40% e inferior ou igual a 70%
         * 8 - nacional, mercadoria ou bem com conteúdo de importação superior a 70%
         * ------------------------------------------------------------
         */

        if (in_array($item->itemorigincode, array('1', '2', '3', '8'))) {
          $aliquoticms = (float) number_format((float) 4 / 100, 4, '.', '');
          $aliquotinterstate = (float) number_format((float) 4 / 100, 4, '.', '');
        }

        // se o ncm tem reducao de base de calculo
        if ($item->ncmbasereduction == 'T') {
          $calculationbase = (float) number_format((float) (1 - (float) $aliquotbasevaluereduction), 6, '.', '');
          $calculationbase = (float) number_format(((float) $item->itemtotal * $calculationbase), 2, '.', '');

        }

        /*
         * ------------------------------------------------------------
         * se a natureza da operacao é igual a:
         * 1 - Entrega futura
         * ------------------------------------------------------------
         */
        if (in_array($operationtype->naturetypecode, array('1'))) {

          // operacoes nao tributadas nao se aplica incentivos
          $calculationbase = $item->itemtotal;

          // calcula os impostos do pis
          $this->calculatepis($item, $calculationbase, 0, '49');

          // calcula os impostos do cofins
          $this->calculatecofins($item, $calculationbase, 0, '49');

          // calcula os impostos do icms
          $this->calculateicms($item, 0, $calculationbase, 'ICMS', '41');
        }

        /*
         * ------------------------------------------------------------
         * se a natureza da operacao é igual a:
         * 2 - Remessa para conserto
         * ------------------------------------------------------------
         */
        if (in_array($operationtype->naturetypecode, array('2'))) {

          // operacoes nao tributadas nao se aplica incentivos
          $calculationbase = $item->itemtotal;

          // calcula os impostos do pis
          $this->calculatepis($item, $calculationbase, 0, '49');

          // calcula os impostos do cofins
          $this->calculatecofins($item, $calculationbase, 0, '49');

          // calcula os impostos do icms
          $this->calculateicms($item, 0, $calculationbase, 'ICMS', '41');
        }

        /*
         * ------------------------------------------------------------
         * se a natureza da operacao é igual a:
         * 7 - Retorno conserto
         * ------------------------------------------------------------
         */
        if (in_array($operationtype->naturetypecode, array('7'))) {

          // operacoes nao tributadas nao se aplica incentivos
          $calculationbase = $item->itemtotal;

          // calcula os impostos do pis
          $this->calculatepis($item, $calculationbase, 0, '49');

          // calcula os impostos do cofins
          $this->calculatecofins($item, $calculationbase, 0, '49');

          // calcula os impostos do icms
          $this->calculateicms($item, 0, $calculationbase, 'ICMS', '41');
        }

        /*
         * ------------------------------------------------------------
         * se a natureza da operacao é igual a:
         * 9 - Remessa para demonstração
         * 12 - Remessa simples - Sem imposto
         * ------------------------------------------------------------
         */
        if (in_array($operationtype->naturetypecode, array('9', '12'))) {

          // operacoes nao tributadas nao se aplica incentivos
          $calculationbase = $item->itemtotal;

          // calcula os impostos do pis
          $this->calculatepis($item, 0, 0, '49');

          // calcula os impostos do cofins
          $this->calculatecofins($item, 0, 0, '49');

          // calcula os impostos do icms
          $this->calculateicms($item, 0, $calculationbase, 'ICMS', '41');
        }

        /*
         * ------------------------------------------------------------
         * se a natureza da operacao é igual a:
         * nao informado
         * 6 - Remessa venda entrega futura (mogiglass) c/ imposto
         * 11 - Devolução de venda (entrada)
         * 13 - Remessa para doação
         * ------------------------------------------------------------
         */
        if (
          !$operationtype->naturetypecode ||
          in_array($operationtype->naturetypecode, array('6', '11', '13'))
        ) {

          // verifica se o estado do cliente não é o mesmo do estado da subsidiaria
          if ($clientbilladdress->state != $subsidiarybilladdress->state) {

            // verifica se o cliente é contribuinte do icms e se ele nao é imune
            if ($client->icmstaxpayer == 'T' && $client->ieimmune == 'F') {


              /*
               * ------------------------------------------------------------
               * se o tipo da natureza da operacao é igual a:
               * 11 - Devolução de venda (entrada)
               * ------------------------------------------------------------
               */

              if ($operationtype->naturetypecode == 11) {
                // calcula os impostos do pis
                $this->calculatepis($item, $item->itemtotal, $aliquotpis, '98');

                // calcula os impostos do cofins
                $this->calculatecofins($item, $item->itemtotal, $aliquotcofins, '98');
              } else {
                // calcula os impostos do pis
                $this->calculatepis($item, $item->itemtotal, $aliquotpis);

                // calcula os impostos do cofins
                $this->calculatecofins($item, $item->itemtotal, $aliquotcofins);
              }

              // calcula os impostos do icms
              $taxname = 'ICMS';

              $cst = '00';

              // se o ncm tem reducao de base de calculo
              if ($item->ncmbasereduction == 'T') {
                $cst = '20';
              }

              $this->calculateicms($item, $aliquotinterstate, $calculationbase, $taxname, $cst);
            }

            // demais casos
            else {

              /*
               * ------------------------------------------------------------
               * se o tipo da natureza da operacao é igual a:
               * 11 - Devolução de venda (entrada)
               * ------------------------------------------------------------
               */

              if ($operationtype->naturetypecode == 11) {
                // calcula os impostos do pis
                $this->calculatepis($item, $item->itemtotal, $aliquotpis, '98');

                // calcula os impostos do cofins
                $this->calculatecofins($item, $item->itemtotal, $aliquotcofins, '98');
              } else {
                // calcula os impostos do pis
                $this->calculatepis($item, $item->itemtotal, $aliquotpis);

                // calcula os impostos do cofins
                $this->calculatecofins($item, $item->itemtotal, $aliquotcofins);
              }

              // calcula os impostos do icms
              $taxname = 'ICMS';

              $cst = '00';

              // se o ncm tem reducao de base de calculo
              if ($item->ncmbasereduction == 'T') {
                $cst = '20';
              }

              $this->calculateicms($item, $aliquotinterstate, $calculationbase, $taxname, $cst);

              // calcula os impostos do icms do destino
              $difaldestination = (float) number_format(($aliquotdestination - $aliquoticms), 4, '.', '');

              $taxname = 'ICMSDIFALDESTINATION';

              $this->calculateicmsdifaldestination($item, $difaldestination, $calculationbase, $taxname, $aliquotdestination, $cst);

              // calcula os impostos do icms do remetente
              $taxname = 'ICMSDIFALSENDER';

              /*
               * ------------------------------------------------------------
               * se a origem do item é extangeira é igual a:
               * 1 - estrangeira - importação direta, exceto a indicada no código 6
               * 2 - estrangeira - adquirida no mercado interno, exceto a indicada no código 7
               * 3 - nacional, mercadoria ou bem com conteúdo de importação superior a 40% e inferior ou igual a 70%
               * 8 - nacional, mercadoria ou bem com conteúdo de importação superior a 70%
               * ------------------------------------------------------------
               */

              if (in_array($item->itemorigincode, array('1', '2', '3', '8'))) {
                $aliquotinterstate = $aliquoticms;
              }
              $this->calculateicmsdifalsender($item, $aliquotinterstate, $calculationbase, $taxname, $cst);

            }

            // se o cliente for isento de inscricao estadual
            if ($client->ieexempt == 'T') {
              $taxname = 'FCPDESTINATION';

              $this->calculateicmsfcp($item, $aliquotfcp, $calculationbase, $taxname, $cst);

            }
          }

          // verifica se o estado do cliente é o mesmo do estado da subsidiaria
          if ($clientbilladdress->state == $subsidiarybilladdress->state) {

            // a aliquota do icms nao pode ser reduzida se o item for estrangeiro
            $aliquoticms = (float) number_format((float) $taxes->icms->aliquot / 100, 4, '.', '');

            // verifica se tem substituicao tributaria
            if ($hasst) {
            }

            // verifica se o cliente é orgao publico e isento de icms
            else if ($client->publicentityexempticms == 'T') {

              // calcula os impostos do pis
              $this->calculatepis($item, $item->itemtotal, $aliquotpis);

              // calcula os impostos do cofins
              $this->calculatecofins($item, $item->itemtotal, $aliquotcofins);

              $taxname = 'ICMS';
              $cst = '40';

              $this->calculateicms($item, 0, 0, $taxname, $cst);

            }

            // demais casos
            else {
              // calcula os impostos do pis
              $this->calculatepis($item, $item->itemtotal, $aliquotpis);

              // calcula os impostos do cofins
              $this->calculatecofins($item, $item->itemtotal, $aliquotcofins);

              // calcula os impostos do icms
              $calculationbase = $item->itemtotal;

              $taxname = 'ICMS';
              $cst = '00';

              // caso o item tenha cest
              if ($item->cest) {
                $taxname = 'ICMSSTSD';
                $cst = '60';
                $aliquoticms = 0;
              }

              // caso o ncm do item tenha incentivo fiscal
              if ($item->ncmaliquotfiscalincentive) {
                $aliquoticms = (float) number_format((float) $item->ncmaliquotfiscalincentive / 100, 4, '.', '');
              }

              // se o ncm tem reducao de base de calculo
              if ($item->ncmbasereduction == 'T') {
                $calculationbase = (float) number_format((float) (1 - (float) $aliquotbasevaluereduction), 6, '.', '');
                $calculationbase = (float) number_format(((float) $item->itemtotal * $calculationbase), 2, '.', '');
                $cst = '20';
              }

              $this->calculateicms($item, $aliquoticms, $calculationbase, $taxname, $cst);

            }

          }

        }
      }
    }

    return $items;
  }

  private function calculatepis($item, $calculationbase, $aliquotpis, $cst = '01')
  {
    $item->taxes->pis = new stdClass();
    $item->taxes->pis->link = $item->link;
    $item->taxes->pis->line = $item->itemline;
    $item->taxes->pis->itemid = $item->itemid;
    $item->taxes->pis->itemname = $item->itemname;
    $item->taxes->pis->ncm = $item->ncm;
    $item->taxes->pis->ncmdescription = $item->ncmdescription;
    $item->taxes->pis->itemoriginid = $item->itemoriginid;
    $item->taxes->pis->itemoriginname = $item->itemoriginname;
    $item->taxes->pis->linenetvalue = $item->itemtotal;
    $item->taxes->pis->calculationbase = $calculationbase;
    $item->taxes->pis->taxname = 'PIS';
    $item->taxes->pis->aliquot = $aliquotpis;
    $item->taxes->pis->taxvalue = (float) number_format(((float) $item->taxes->pis->calculationbase * (float) $aliquotpis), 2, '.', '');
    $item->taxes->pis->cst = $cst;
  }

  private function calculatecofins($item, $calculationbase, $aliquotcofins, $cst = '01')
  {
    $item->taxes->cofins = new stdClass();
    $item->taxes->cofins->link = $item->link;
    $item->taxes->cofins->line = $item->itemline;
    $item->taxes->cofins->itemid = $item->itemid;
    $item->taxes->cofins->itemname = $item->itemname;
    $item->taxes->cofins->ncm = $item->ncm;
    $item->taxes->cofins->ncmdescription = $item->ncmdescription;
    $item->taxes->cofins->itemoriginid = $item->itemoriginid;
    $item->taxes->cofins->itemoriginname = $item->itemoriginname;
    $item->taxes->cofins->linenetvalue = $item->itemtotal;
    $item->taxes->cofins->calculationbase = $calculationbase;
    $item->taxes->cofins->taxname = 'COFINS';
    $item->taxes->cofins->aliquot = $aliquotcofins;
    $item->taxes->cofins->taxvalue = (float) number_format(((float) $item->taxes->cofins->calculationbase * (float) $aliquotcofins), 2, '.', '');
    $item->taxes->cofins->cst = $cst;
  }

  private function calculateicms($item, $aliquoticms, $calculationbase, $taxname = 'ICMS', $cst = '00')
  {
    $item->taxes->icms = new stdClass();
    $item->taxes->icms->link = $item->link;
    $item->taxes->icms->line = $item->itemline;
    $item->taxes->icms->itemid = $item->itemid;
    $item->taxes->icms->itemname = $item->itemname;
    $item->taxes->icms->ncm = $item->ncm;
    $item->taxes->icms->ncmdescription = $item->ncmdescription;
    $item->taxes->icms->itemoriginid = $item->itemoriginid;
    $item->taxes->icms->itemoriginname = $item->itemoriginname;
    $item->taxes->icms->linenetvalue = $item->itemtotal;
    $item->taxes->icms->calculationbase = $calculationbase;
    $item->taxes->icms->taxname = $taxname;
    $item->taxes->icms->aliquot = $aliquoticms;
    $item->taxes->icms->taxvalue = (float) number_format(((float) $item->taxes->icms->calculationbase * (float) $aliquoticms), 2, '.', '');
    $item->taxes->icms->cst = $cst;
  }

  private function calculateicmsdifaldestination($item, $aliquoticms, $calculationbase, $taxname, $aliquotdestination, $cst = '00')
  {
    $item->taxes->icmsdestination = new stdClass();
    $item->taxes->icmsdestination->link = $item->link;
    $item->taxes->icmsdestination->line = $item->itemline;
    $item->taxes->icmsdestination->itemid = $item->itemid;
    $item->taxes->icmsdestination->itemname = $item->itemname;
    $item->taxes->icmsdestination->ncm = $item->ncm;
    $item->taxes->icmsdestination->ncmdescription = $item->ncmdescription;
    $item->taxes->icmsdestination->itemoriginid = $item->itemoriginid;
    $item->taxes->icmsdestination->itemoriginname = $item->itemoriginname;
    $item->taxes->icmsdestination->linenetvalue = $item->itemtotal;
    $item->taxes->icmsdestination->calculationbase = $calculationbase;
    $item->taxes->icmsdestination->taxname = $taxname;
    $item->taxes->icmsdestination->aliquotdestination = $aliquotdestination;
    $item->taxes->icmsdestination->aliquot = $aliquoticms;
    $item->taxes->icmsdestination->taxvalue = (float) number_format(((float) $item->taxes->icms->calculationbase * (float) $aliquoticms), 2, '.', '');
    $item->taxes->icmsdestination->cst = $cst;
  }

  private function calculateicmsdifalsender($item, $aliquoticms, $calculationbase, $taxname, $cst = '00')
  {
    $item->taxes->icmssender = new stdClass();
    $item->taxes->icmssender->link = $item->link;
    $item->taxes->icmssender->line = $item->itemline;
    $item->taxes->icmssender->itemid = $item->itemid;
    $item->taxes->icmssender->itemname = $item->itemname;
    $item->taxes->icmssender->ncm = $item->ncm;
    $item->taxes->icmssender->ncmdescription = $item->ncmdescription;
    $item->taxes->icmssender->itemoriginid = $item->itemoriginid;
    $item->taxes->icmssender->itemoriginname = $item->itemoriginname;
    $item->taxes->icmssender->linenetvalue = $item->itemtotal;
    $item->taxes->icmssender->calculationbase = $calculationbase;
    $item->taxes->icmssender->taxname = $taxname;
    $item->taxes->icmssender->aliquotsender = $aliquoticms;
    $item->taxes->icmssender->aliquot = $aliquoticms;
    $item->taxes->icmssender->taxvalue = 0;
    // $item->taxes->icmssender->taxvalue = (float) number_format(((float) $item->taxes->icms->calculationbase * (float) $aliquoticms), 2, '.', '');
    $item->taxes->icmssender->cst = $cst;
  }

  private function calculateicmsfcp($item, $aliquoticms, $calculationbase, $taxname, $cst = '00')
  {
    $item->taxes->fcp = new stdClass();
    $item->taxes->fcp->link = $item->link;
    $item->taxes->fcp->line = $item->itemline;
    $item->taxes->fcp->itemid = $item->itemid;
    $item->taxes->fcp->itemname = $item->itemname;
    $item->taxes->fcp->ncm = $item->ncm;
    $item->taxes->fcp->ncmdescription = $item->ncmdescription;
    $item->taxes->fcp->itemoriginid = $item->itemoriginid;
    $item->taxes->fcp->itemoriginname = $item->itemoriginname;
    $item->taxes->fcp->linenetvalue = $item->itemtotal;
    $item->taxes->fcp->calculationbase = $calculationbase;
    $item->taxes->fcp->taxname = $taxname;
    $item->taxes->fcp->aliquotsender = $aliquoticms;
    $item->taxes->fcp->aliquot = $aliquoticms;
    $item->taxes->fcp->taxvalue = (float) number_format(((float) $item->taxes->icms->calculationbase * (float) $aliquoticms), 2, '.', '');
    $item->taxes->fcp->cst = $cst;
  }
}
