<?php
defined('BASEPATH') or exit('No direct script access allowed');

class nfe extends CI_Model
{

  protected $user_id;
  protected $user;

  public function __construct()
  {
    $this->load->model('data_persistence');

    if (check_session('session_token')) {
      $this->user_id = get_session_data(check_session('session_token'));

      $this->user = $this->db->select('id as id, roles, name as name, CONCAT(UPPER(LEFT(SUBSTRING_INDEX(name, " ", 1), 1)), "", UPPER(LEFT(SUBSTRING_INDEX(name, " ", -1), 1))) as short_name, CONCAT(SUBSTRING_INDEX(name, " ", 1), " ", SUBSTRING_INDEX(name, " ", -1)) as first_last_name, email as email, defaulttheme')
        ->where('id', $this->user_id)
        ->get('users')
        ->result();
    }
  }

  public function send($invoice)
  {

    $invoice = $this->db->select('
      invoices.id,
      invoices.tranid,
      invoices.customerid,
      invoices.billaddressid,
      invoices.shippingaddressid,
      invoices.subsidiaryid,
      invoices.operationtypeid,
      invoices.termsid,
      invoices.customerpurchaseorder,
      invoices.carrierid,
      invoices.freighttypeid,
      freighttypes.title as freighttypename,
      freighttypes.code as freighttypecode,
      invoices.volumesquantity,
      invoices.volumetype,
      invoices.grossweight,
      invoices.netweight,
      invoices.paymentmethodid,
      paymentmethods.title as paymentmethodname,
      paymentmethods.code as paymentmethodcode,
      invoices.paymentcomments,
      invoices.fiscaldocrefaccesskey,
      invoices.additionalinformation
    ')
      ->join('freighttypes', 'freighttypes.id = invoices.freighttypeid', 'LEFT')
      ->join('paymentmethods', 'paymentmethods.id = invoices.paymentmethodid', 'LEFT')
      ->where('invoices.id', $invoice)
      ->get('invoices')
      ->result();

    $subsidiary = $this->db->select('
      subsidiaries.id,
      subsidiaries.title,
      subsidiaries.name,
      subsidiaries.legalname,
      subsidiaries.phone,
      subsidiaries.cnpj,
      subsidiaries.ie,
      subsidiaries.taxregime,
      taxregimes.title as taxregimetitle,
      taxregimes.code as taxregimecode,
      subsidiaries.utilizationrate,
      subsidiaries.hassimplesnacionalicms
    ')
      ->join('taxregimes', 'taxregimes.id = subsidiaries.taxregime', 'LEFT')
      ->where('subsidiaries.id', $invoice[0]->subsidiaryid)
      ->get('subsidiaries')
      ->result();

    $subsidiarybilladdress = $this->db->select('street, number, zip, neighborhood, complement, city, citycode, state, country, standardbilling, standardshipping')
      ->where('link', $invoice[0]->subsidiaryid)
      ->where('standardbilling', 'T')
      ->get('addresses')
      ->result();

    $operationtype = $this->db->select('operationtypes.id, operationtypes.title, operationtypes.code, operationtypes.naturetypeid, operationtypes.naturetype, operationtypes.transactiontypeid, operationtypes.transactiontype')
      ->where('operationtypes.id', $invoice[0]->operationtypeid)
      ->get('operationtypes')
      ->result();

    $carrier = $this->db->select('entities.isperson, types.title as persontype, entities.document, entities.name, entities.legalname, entities.ie, entities.mei, entities.simplesnacional, entities.ieexempt, entities.icmstaxpayer, entities.ieimmune, entities.publicentityexempticms')
      ->join('types', 'entities.isperson = types.id', 'LEFT')
      ->where('entities.id', $invoice[0]->carrierid)
      ->where('entities.iscarrier', 'T')
      ->get('entities')
      ->result();

    $carrierbilladdress = $this->db->select('street, number, zip, neighborhood, complement, city, citycode, state, country, standardbilling, standardshipping')
      ->where('link', $invoice[0]->carrierid)
      ->where('standardbilling', 'T')
      ->get('addresses')
      ->result();

    $client = $this->db->select('
      entities.id,
      entities.isperson,
      types.title as persontype,
      entities.name,
      entities.legalname,
      entities.activitysector,
      activitysectors.title as activitysectorname,
      entities.document,
      entities.ie,
      entities.ieexempt,
      entities.ieimmune,
      entities.icmstaxpayer,
      entities.simplesnacional,
      entities.mei,
      entities.publicentityexempticms
    ')
      ->join('types', 'types.id = entities.isperson', 'LEFT')
      ->join('activitysectors', 'activitysectors.id = entities.activitysector', 'LEFT')
      ->where('entities.id', $invoice[0]->customerid)
      ->get('entities')
      ->result();

    $clientbilladdress = $this->db->select('address, street, number, zip, neighborhood, complement, citycode, city, state, countrycode, country, standardbilling, standardshipping')
      ->where('id', $invoice[0]->billaddressid)
      ->get('addresses')
      ->result();

    $clientshippingaddress = $this->db->select('address, street, number, zip, neighborhood, complement, citycode, city, state, countrycode, country, standardbilling, standardshipping')
      ->where('id', $invoice[0]->shippingaddressid)
      ->get('addresses')
      ->result();

    $installments = $this->db->select('
      id,
      tranid,
      installment,
      deadline,
      percentage,
      total
    ')
      ->where('link', $invoice[0]->id)
      ->where('isinactive', 'F')
      ->order_by('installment', 'ASC')
      ->get('invoiceinstallments')
      ->result();

    // TODO adicionar campo tranid na consulta quando for adicionado na tabela de itens
    $items = $this->db->select('
      invoiceitems.id,
      items.externalid,
      invoiceitems.link,
      invoiceitems.itemid,
      invoiceitems.itemname,
      invoiceitems.itemalternativename,
      invoiceitems.itemline,
      ncms.id as ncmid,
      invoiceitems.ncm,
      ncms.description as ncmdescription,
      ncms.aliquotfiscalincentive as ncmaliquotfiscalincentive,
      ncms.descriptionfiscalincentive as ncmdescriptionfiscalincentive,
      ncms.basereduction as ncmbasereduction,
      ncms.descriptionbasereduction as ncmdescriptionbasereduction,
      invoiceitems.itemoriginid,
      itemorigintypes.title as itemoriginname,
      itemorigintypes.code as itemorigincode,
      invoiceitems.cest,
      invoiceitems.stfactor,
      invoiceitems.icmstaxincentive,
      invoiceitems.cfop,
      invoiceitems.saleunitid,
      units.name as saleunitname,
      units.title as saleunitdescription,
      invoiceitems.cfop,
      invoiceitems.itemquantity,
      invoiceitems.itemprice,
      invoiceitems.itemgrossvalue,
      invoiceitems.itemdiscount,
      invoiceitems.itemfreight,
      invoiceitems.itemtotal,
      invoiceitems.additionalinformation,
      invoiceitems.ischemical,
      invoiceitems.iscontrolledcivilpolice,
      invoiceitems.iscontrolledfederalpolice,
      invoiceitems.iscontrolledarmy,
      invoiceitems.concentration,
      invoiceitems.density,
      invoiceitems.onuid,
      invoiceitems.onucode,
      invoiceitems.onudescription,
      invoiceitems.riskclass,
      invoiceitems.riskclassdescription,
      invoiceitems.risknumber,
      invoiceitems.subsidiaryrisk,
      invoiceitems.risknumber,
      invoiceitems.packinggroup,
      invoiceitems.transportquantity
    ')
      ->join('items', 'items.id = invoiceitems.itemid', 'LEFT')
      ->join('ncms', 'ncms.title = invoiceitems.ncm', 'LEFT')
      ->join('itemorigintypes', 'itemorigintypes.id = invoiceitems.itemoriginid', 'LEFT')
      ->join('units', 'units.id = invoiceitems.saleunitid', 'LEFT')
      ->where('invoiceitems.link', $invoice[0]->id)
      ->where('invoiceitems.isinactive', 'F')
      ->order_by('invoiceitems.itemline', 'ASC')
      ->get('invoiceitems')
      ->result();

    foreach ($items as $key => $item) {
      $taxes = $this->db->select('
        id,
        link,
        invoiceid,
        line,
        itemid,
        itemname,
        ncm,
        ncmdescription,
        itemoriginid,
        itemoriginname,
        linenetvalue,
        linegrossvalue,
        calculationbase,
        taxname,
        aliquot,
        aliquotsender,
        aliquotdestination,
        taxvalue,
        cst
      ')
        ->where('invoiceid', $invoice[0]->id)
        ->where('link', $item->id)
        ->get('invoicetax')
        ->result();

      $item->taxes = new stdClass();

      foreach ($taxes as $tax) {
        $item->taxes->{strtolower($tax->taxname)} = $tax;
      }
    }

    /*
     * ------------------------------------------------------------
     * Informações Complementares de interesse do Contribuinte
     * ------------------------------------------------------------
     */
    $infCpl_Z03 = '';

    if ($invoice[0]->customerpurchaseorder) {
      $infCpl_Z03 .= 'ORDEM DE COMPRA: ' . $invoice[0]->customerpurchaseorder . PHP_EOL;
    }

    if ($subsidiary[0]->taxregimecode == 1) {
      $infCpl_Z03 .= 'EMPRESA OPTANTE PELO SIMPLES NACIONAL' . PHP_EOL;
      /*
       * ------------------------------------------------------------
       * Se o cliente for contribuinte de ICMS
       * ------------------------------------------------------------
       */
      if ($client[0]->icmstaxpayer == 'T') {
        $infCpl_Z03 .= 'PERMITE O APROVEITAMENTO DE CREDITO DE ICMS ALIQ. ' . $subsidiary[0]->utilizationrate . PHP_EOL;
      }
    }

    /*
     * ------------------------------------------------------------
     * Se o tipo de operação não é:
     * 3 - VENDA ENTREGA FUTURA (MOGIGLASS)
     * 13 - VENDA ENTREGA FUTURA SIMPLES NACIONAL
     * ------------------------------------------------------------
     */
    if (!in_array($operationtype[0]->code, array('3', '13'))) {
      /*
       * ------------------------------------------------------------
       * Se o produto for químico
       * ------------------------------------------------------------
       */
      foreach ($items as $key => $item) {
        if ($item->ischemical == 'T') {
          $infCpl_Z03 .= 'DECLARO QUE OS PRODUTOS PERIGOSOS ESTÃO ADEQUADAMENTE CLASSIFICADOS, EMBALADOS, IDENTIFICADOS, E ESTIVADOS PARA SUPORTAR OS RISCOS DAS OPERAÇÕES DE TRANSPORTE E QUE ATENDEM ÀS EXIGÊNCIAS DA REGULAMENTAÇÃO' . PHP_EOL;
          break;
        }
      }
      $infCpl_Z03 .= 'INFORMAÇÕES DA TRANSPORTADORA: PESO BRUTO: ' . $invoice[0]->grossweight . ' KG PESO LIQUIDO: ' . $invoice[0]->netweight . ' KG' . PHP_EOL;
      $infCpl_Z03 .= 'ENDEREÇO DE ENTREGA: ' . $clientshippingaddress[0]->address . PHP_EOL;
    }

    $invoice[0]->additionalinformation = mb_strtoupper(implode('|', preg_split('/\r\n|\r|\n/', $infCpl_Z03 . $invoice[0]->additionalinformation)), 'UTF-8');

    /*
     * ------------------------------------------------------------
     * Se o tipo de operação é:
     * 1 - VENDA DE PRODUTOS NF-E
     * 2 - VENDA CLIENTE INSCRIÇÃO ESTADUAL IMUNE
     * 10 - VENDA SIMPLES NACIONAL
     * ------------------------------------------------------------
     */
    if (in_array($operationtype[0]->code, array('1', '2', '10'))) {
      $tx2 = $this->getheadertx2($invoice, $subsidiary, $subsidiarybilladdress, $client, $clientbilladdress, $items);
      $tx2 .= $this->getsendertx2($invoice, $subsidiary, $subsidiarybilladdress, $clientbilladdress);
      $tx2 .= $this->getdestinationtx2($invoice, $client, $clientbilladdress);
      $tx2 .= $this->getitemstx2($invoice, $items, $subsidiary, $operationtype);
      $tx2 .= $this->getbilltx2($invoice, $items);
      $tx2 .= $this->getinstallmentstx2($invoice, $installments);
      $tx2 .= $this->getcarriertx2($invoice, $carrier, $carrierbilladdress);
      $tx2 .= $this->getbulktx2($invoice);
      $tx2 .= $this->getbilldetailtx2($invoice, $installments, $items);
      $tx2 .= $this->getfootertx2($invoice, $items);
    }

    /*
     * ------------------------------------------------------------
     * Se o tipo de operação é:
     * 3 - VENDA ENTREGA FUTURA (MOGIGLASS)
     * 13 - VENDA ENTREGA FUTURA SIMPLES NACIONAL
     * ------------------------------------------------------------
     */
    if (in_array($operationtype[0]->code, array('3', '13'))) {
      $tx2 = $this->getheadertx2($invoice, $subsidiary, $subsidiarybilladdress, $client, $clientbilladdress, $items);
      $tx2 .= $this->getsendertx2($invoice, $subsidiary, $subsidiarybilladdress, $clientbilladdress);
      $tx2 .= $this->getdestinationtx2($invoice, $client, $clientbilladdress);
      $tx2 .= $this->getitemstx2($invoice, $items, $subsidiary, $operationtype);
      $tx2 .= $this->getbilltx2($invoice, $items);
      $tx2 .= $this->getinstallmentstx2($invoice, $installments);
      $tx2 .= $this->getcarriertx2($invoice, false, false);
      $tx2 .= $this->getbilldetailtx2($invoice, $installments, $items);
      $tx2 .= $this->getfootertx2($invoice, $items);
    }

    /*
     * ------------------------------------------------------------
     * Se o tipo de operação é:
     * 4 - REMESSA PARA CONSERTO
     * 6 - RETORNO DE DEMONSTRAÇÃO (ENTRADA)
     * 7 - REMESSA PARA CONSERTO (ENTRADA)
     * 8 - REMESSA VENDA ENTREGA FUTURA C/IMPOSTO
     * 9 - RETORNO DE CONSERTO
     * 11 - REMESSA SIMPLES - SEM IMPOSTO
     * 12 - REMESSA PARA DEMONSTRAÇÃO
     * 14 - DEVOLUÇÃO DE VENDA (ENTRADA)
     * 17 - REMESSA PARA DOAÇÃO
     * 19 - SIMPLES REMESSA (ENTRADA)
     * 20 - REMESSA PARA EXPOSIÇÃO/FEIRA
     * 22 - RETORNO DE EXPOSIÇÃO/FEIRA (ENTRADA)
     * 24 - RETORNO DE CONSERTO (ENTRADA)
     * 25 - REMESSA PARA TROCA
     * ------------------------------------------------------------
     */
    if (in_array($operationtype[0]->code, array('4', '6', '7', '8', '9', '11', '12', '14', '17', '19', '20', '22', '24', '25'))) {
      $tx2 = $this->getheadertx2($invoice, $subsidiary, $subsidiarybilladdress, $client, $clientbilladdress, $items);
      $tx2 .= $this->getsendertx2($invoice, $subsidiary, $subsidiarybilladdress, $clientbilladdress);
      $tx2 .= $this->getdestinationtx2($invoice, $client, $clientbilladdress);
      $tx2 .= $this->getitemstx2($invoice, $items, $subsidiary, $operationtype);
      $tx2 .= $this->getcarriertx2($invoice, $carrier, $carrierbilladdress);
      $tx2 .= $this->getbilldetailtx2($invoice, $installments, $items);
      $tx2 .= $this->getfootertx2($invoice, $items);
    }

    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'Arquivo' => $tx2,
    );

    $nfetest = explode(',', $this->validatenfe($data));

    // caso tx2 seja invalido
    if (!in_array($nfetest[2], array('XML Válido'))) {

      // CASO DE NFE INVALIDA

      $nfetest = array_map(function ($item) {
        return trim($item);
      }, $nfetest);

      $nfetest = array_filter($nfetest, function ($item) {
        return !empty($item);
      });

      return json_encode(
        array(
          'error' => true,
          'message' => $nfetest[2],
          'ws-response' => $nfetest,
          'tx2' => $tx2
        )
      );
    }

    $serverstats = $this->stats($subsidiary);

    if (!$serverstats) {
      return json_encode(
        array(
          'error' => true,
          'message' => 'Servidor NF-e fora de operação',
        )
      );
    }

    $nfe = explode(',', $this->sendnfe($data));

    if ($nfe[2] != '100') {

      // RETORNO DE NFE REJEITADA

      $data = array(
        'fiscaldocnumber' => (int) substr($nfe[1], 25, 9),
        'fiscaldocaccesskey' => $nfe[1],
        'fiscaldocstatus' => 'REJEITADA',
        'fiscaldocreturnmessage' => $nfe[3],
        'ip' => $this->input->ip_address(),
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
        'updated' => time(),
      );

      $this->db->where('id', $invoice[0]->id)
        ->update('invoices', $data);

      $previus_data = $this->db->select('
        fiscaldocnumber,
        fiscaldocaccesskey,
        fiscaldocstatus,
        fiscaldocreturnmessage
      ')
        ->where('id', $invoice[0]->id)
        ->get('invoices')
        ->result();

      $this->data_persistence->log(
        [
          'table' => 'invoice',
          'action' => 'edit invoice',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $invoice[0]->id,
          'data' => [
            'message' => 'Fatura editada com sucesso.',
            'process' => edited_data($data, $previus_data[0])
          ]
        ],
      );

      $response = array(
        'error' => true,
        'message' => $nfe[3],
        'ws-response' => $nfe,
      );

      $upload = [
        'upload' => [
          'error' => false,
          'message' => 'Upload concluído com sucesso.'
        ]
      ];

      // UPLOAD DO XML
      $xml = json_decode($this->xml($invoice[0]->id));

      if (!empty($xml->error)) {
        $upload['upload']['xml'] = $xml->message;
      }

      if (isset($xml->error) && !$xml->error && isset($xml->filepath)) {
        $id = uuidv4();
        $doc = [
          'id' => $id,
          'link' => $invoice[0]->id,
          'message' => NULL,
          'type' => 'XML NFE REJEITADA',
          'path' => $xml->filepath,
          'isinactive' => 'F',
          'confirmed' => 'T',
          'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
          'platform' => $this->agent->platform(),
          'referer' => $this->agent->referrer(),
          'created' => time(),
        ];

        $this->db->insert('invoicedocs', $doc);

        $this->data_persistence->log(
          [
            'table' => 'invoicedocs',
            'action' => 'create invoicedoc',
            'user_id' => $this->user[0]->id,
            'user_role' => $this->user[0]->roles,
            'defined' => $id,
            'data' => [
              'message' => 'Documento de fatura criado com sucesso.',
            ]
          ],
        );
      }

      if (isset($upload['upload']['xml'])) {
        $upload['upload']['error'] = true;
        unset($upload['upload']['message']);
      }

      $response = array_merge($response, $upload);

      return json_encode($response);

    }

    // RETORNO NFE AUTORIZADA

    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'PluginName' => 'NFe',
      'Campos' => 'chave,situacao,nnf,motivo,dtautorizacao,dtemissao',
      'Filtro' => 'chave=' . $nfe[1],
      'Encode' => true,
      'Origem' => 4,
    );

    $consult_nfe = $this->consultnfe($data);

    if ($consult_nfe == 'Nenhum registro encontrado.') {

      $data = array(
        'fiscaldocnumber' => (int) substr($nfe[1], 25, 9),
        'fiscaldocaccesskey' => $nfe[1],
        'ip' => $this->input->ip_address(),
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
        'updated' => time(),
      );

      $this->db->where('id', $invoice[0]->id)
        ->update('invoices', $data);

      $previus_data = $this->db->select('
        fiscaldocnumber,
        fiscaldocaccesskey,
      ')
        ->where('id', $invoice[0]->id)
        ->get('invoices')
        ->result();

      $this->data_persistence->log(
        [
          'table' => 'invoice',
          'action' => 'edit invoice',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $invoice[0]->id,
          'data' => [
            'message' => 'Fatura editada com sucesso.',
            'process' => edited_data($data, $previus_data[0])
          ]
        ],
      );

      return json_encode(
        array(
          'error' => true,
          'message' => 'Não foi possível encontrar a NF-e ' . $nfe[1],
          'ws-response' => $nfe,
        )
      );
    }

    /*
     * ------------------------------------------------------------
     * As possíveis situações para a situação de uma NF-e no Manager SaaS são:
     * Autorizada: Nota autorizada pela SEFAZ.
     * Cancelada: Cancelamento autorizado pela SEFAZ.
     * Enviada: Nota fiscal enviada para SEFAZ, mas sem retorno da requisição de envio (Nesse caso não sabemos se a nota foi autorizada ou rejeitada).
     * Registrada: Nota fiscal gravada na base de dados do Manager SaaS, mas por alguma falha a nota não foi enviada a SEFAZ até o momento. (Normalmente por problemas de conexão).
     * Rejeitada: Nota fiscal rejeitada pela SEFAZ e portanto não autorizada.
     * Inutilizada: Indica que a faixa de numeração da nota fiscal já foi inutilizada.
     * Recebida: Indica que a nota fiscal foi enviada e a SEFAZ retornou que a nota foi recebida e ainda não tem uma situação final (autorizada ou rejeitada).
     * Denegada: Indica que a nota fiscal não foi autorizada devido ao emitente possuir alguma irregularidade em seu cadastro junto a SEFAZ ou alguma pendência.
     * ------------------------------------------------------------
     */

    $consult_nfe = explode(',', $consult_nfe);
    $fiscaldocdate = null;
    $fiscaldocsenddate = null;

    if (!!$consult_nfe[4]) {
      $fiscaldocdate = DateTime::createFromFormat('d/m/Y H:i:s', $consult_nfe[4]);
      $fiscaldocdate = $fiscaldocdate->format('Y-m-d H:i:s');
      $fiscaldocdate = strtotime($fiscaldocdate);
    }

    if (!!$consult_nfe[5]) {
      $fiscaldocsenddate = DateTime::createFromFormat('d/m/Y H:i:s', $consult_nfe[5]);
      $fiscaldocsenddate = $fiscaldocsenddate->format('Y-m-d H:i:s');
      $fiscaldocsenddate = strtotime($fiscaldocsenddate);
    }

    $data = array(
      'fiscaldocnumber' => $consult_nfe[2],
      'fiscaldocaccesskey' => $consult_nfe[0],
      'fiscaldocstatus' => mb_strtoupper($consult_nfe[1], 'UTF-8'),
      'fiscaldocdate' => $fiscaldocdate,
      'fiscaldocsenddate' => $fiscaldocsenddate,
      'fiscaldocreturnmessage' => $consult_nfe[3],
      'ip' => $this->input->ip_address(),
      'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
      'platform' => $this->agent->platform(),
      'referer' => $this->agent->referrer(),
      'updated' => time(),
    );

    $this->db->where('id', $invoice[0]->id)
      ->update('invoices', $data);

    $previus_data = $this->db->select('
        fiscaldocnumber,
        fiscaldocaccesskey,
        fiscaldocstatus,
        fiscaldocdate,
        fiscaldocsenddate,
        fiscaldocreturnmessage
      ')
      ->where('id', $invoice[0]->id)
      ->get('invoices')
      ->result();

    $this->data_persistence->log(
      [
        'table' => 'invoice',
        'action' => 'edit invoice',
        'user_id' => $this->user[0]->id,
        'user_role' => $this->user[0]->roles,
        'defined' => $invoice[0]->id,
        'data' => [
          'message' => 'Fatura editada com sucesso.',
          'process' => edited_data($data, $previus_data[0])
        ]
      ],
    );

    $response = array(
      'error' => false,
      'message' => $consult_nfe[3],
      'ws-response' => $nfe,
    );

    $upload = [
      'upload' => [
        'error' => false,
        'message' => 'Upload(s) concluído(s) com sucesso.'
      ]
    ];

    // UPLOAD DA DANFE
    $danfe = json_decode($this->danfe($invoice[0]->id));

    if (!empty($danfe->error)) {
      $upload['upload']['danfe'] = $danfe->message;
    }

    if (isset($danfe->error) && !$danfe->error && isset($danfe->filepath)) {
      $id = uuidv4();
      $doc = [
        'id' => $id,
        'link' => $invoice[0]->id,
        'message' => NULL,
        'type' => 'DANFE NFE AUTORIZADA',
        'path' => $danfe->filepath,
        'isinactive' => 'F',
        'confirmed' => 'T',
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
        'created' => time(),
      ];

      $this->db->insert('invoicedocs', $doc);

      $this->data_persistence->log(
        [
          'table' => 'invoicedocs',
          'action' => 'create invoicedoc',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $id,
          'data' => [
            'message' => 'Documento de fatura criado com sucesso.',
          ]
        ],
      );
    }

    // UPLOAD DO XML
    $xml = json_decode($this->xml($invoice[0]->id));

    if (!empty($xml->error)) {
      $upload['upload']['xml'] = $xml->message;
    }

    if (isset($xml->error) && !$xml->error && isset($xml->filepath)) {
      $id = uuidv4();
      $doc = [
        'id' => $id,
        'link' => $invoice[0]->id,
        'message' => NULL,
        'type' => 'XML NFE AUTORIZADA',
        'path' => $xml->filepath,
        'isinactive' => 'F',
        'confirmed' => 'T',
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
        'created' => time(),
      ];

      $this->db->insert('invoicedocs', $doc);

      $this->data_persistence->log(
        [
          'table' => 'invoicedocs',
          'action' => 'create invoicedoc',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $id,
          'data' => [
            'message' => 'Documento de fatura criado com sucesso.',
          ]
        ],
      );
    }

    if (isset($upload['upload']['xml']) || isset($upload['upload']['danfe'])) {
      $upload['upload']['error'] = true;
      unset($upload['upload']['message']);
    }

    $response = array_merge($response, $upload);

    return json_encode($response);

  }

  public function import($invoice, $xml)
  {

    $invoice = $this->db->select('
      invoices.id,
      invoices.fiscaldocaccesskey,
      invoices.subsidiaryid
    ')
      ->where('invoices.id', $invoice)
      ->get('invoices')
      ->result();

    $subsidiary = $this->db->select('
      subsidiaries.id,
      subsidiaries.cnpj,
    ')
      ->where('subsidiaries.id', $invoice[0]->subsidiaryid)
      ->get('subsidiaries')
      ->result();

    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'Arquivo' => trim($xml)
    );

    $import_nfe = $this->importnfe($data);

    // A mensagem de retorno para sucesso vem diferente da informada na documentação da TECNOSPEED
    if ($import_nfe != 'OK,Importação realizada com sucesso') {
      /*
       * ERRO NA IMPORTAÇÃO DA NFE
       */
      $import_nfe = explode(',', $import_nfe);

      return json_encode([
        'error' => TRUE,
        'message' => $import_nfe[2],
        'ws-response' => $import_nfe
      ]);
    }

    /*
     * SUCESSO NA IMPORTAÇÃO DA NFE
     */

    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'PluginName' => 'NFe',
      'Campos' => 'chave,situacao,nnf,motivo,dtautorizacao,dtemissao,xjustcancelamento',
      'Ordem' => 'dtcadastro DESC',
      'Limite' => 1,
      'Encode' => true,
      'Origem' => 4,
    );

    $consult_nfe = $this->consultnfe($data);

    if ($consult_nfe == 'Nenhum registro encontrado.') {

      return json_encode(
        array(
          'error' => true,
          'message' => 'Houve um problema na busca da NF-e.',
          'ws-response' => $import_nfe,
        )
      );
    }

    /*
     * ------------------------------------------------------------
     * As possíveis situações para a situação de uma NF-e no Manager SaaS são:
     * Autorizada: Nota autorizada pela SEFAZ.
     * Cancelada: Cancelamento autorizado pela SEFAZ.
     * Enviada: Nota fiscal enviada para SEFAZ, mas sem retorno da requisição de envio (Nesse caso não sabemos se a nota foi autorizada ou rejeitada).
     * Registrada: Nota fiscal gravada na base de dados do Manager SaaS, mas por alguma falha a nota não foi enviada a SEFAZ até o momento. (Normalmente por problemas de conexão).
     * Rejeitada: Nota fiscal rejeitada pela SEFAZ e portanto não autorizada.
     * Inutilizada: Indica que a faixa de numeração da nota fiscal já foi inutilizada.
     * Recebida: Indica que a nota fiscal foi enviada e a SEFAZ retornou que a nota foi recebida e ainda não tem uma situação final (autorizada ou rejeitada).
     * Denegada: Indica que a nota fiscal não foi autorizada devido ao emitente possuir alguma irregularidade em seu cadastro junto a SEFAZ ou alguma pendência.
     * ------------------------------------------------------------
     */

    $consult_nfe = explode(',', $consult_nfe);
    $fiscaldocdate = null;
    $fiscaldocsenddate = null;

    if (!!$consult_nfe[4]) {
      $fiscaldocdate = DateTime::createFromFormat('d/m/Y H:i:s', $consult_nfe[4]);
      $fiscaldocdate = $fiscaldocdate->format('Y-m-d H:i:s');
      $fiscaldocdate = strtotime($fiscaldocdate);
    }

    if (!!$consult_nfe[5]) {
      $fiscaldocsenddate = DateTime::createFromFormat('d/m/Y H:i:s', $consult_nfe[5]);
      $fiscaldocsenddate = $fiscaldocsenddate->format('Y-m-d H:i:s');
      $fiscaldocsenddate = strtotime($fiscaldocsenddate);
    }

    $data = array(
      'fiscaldocnumber' => $consult_nfe[2],
      'fiscaldocaccesskey' => $consult_nfe[0],
      'fiscaldocstatus' => mb_strtoupper($consult_nfe[1], 'UTF-8'),
      'fiscaldocdate' => $fiscaldocdate,
      'fiscaldocsenddate' => $fiscaldocsenddate,
      'fiscaldocreturnmessage' => $consult_nfe[3],
      'ip' => $this->input->ip_address(),
      'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
      'platform' => $this->agent->platform(),
      'referer' => $this->agent->referrer(),
      'updated' => time(),
    );

    $this->db->where('id', $invoice[0]->id)
      ->update('invoices', $data);

    $previus_data = $this->db->select('
        fiscaldocnumber,
        fiscaldocaccesskey,
        fiscaldocstatus,
        fiscaldocdate,
        fiscaldocsenddate,
        fiscaldocreturnmessage
      ')
      ->where('id', $invoice[0]->id)
      ->get('invoices')
      ->result();

    $this->data_persistence->log(
      [
        'table' => 'invoice',
        'action' => 'edit invoice',
        'user_id' => $this->user[0]->id,
        'user_role' => $this->user[0]->roles,
        'defined' => $invoice[0]->id,
        'data' => [
          'message' => 'Fatura editada com sucesso.',
          'process' => edited_data($data, $previus_data[0])
        ]
      ],
    );

    $response = array(
      'error' => false,
      'message' => $consult_nfe[3],
      'ws-response' => $import_nfe,
    );

    $upload = [
      'upload' => [
        'error' => false,
        'message' => 'Upload(s) concluído(s) com sucesso.'
      ]
    ];

    // inativando os registros anteriores

    $data = [
      'isinactive' => 'T',
      'confirmed' => 'F',
      'ip' => $this->input->ip_address(),
      'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
      'platform' => $this->agent->platform(),
      'referer' => $this->agent->referrer(),
    ];

    $this->db->where('link', $invoice[0]->id)
      ->update('invoicedocs', $data);

    $previus_data = $this->db->select('id, isinactive, confirmed')
      ->where('link', $invoice[0]->id)
      ->get('invoicedocs')
      ->result();

    $this->data_persistence->log(
      [
        'table' => 'invoicedocs',
        'action' => 'edit invoicedoc',
        'user_id' => $this->user[0]->id,
        'user_role' => $this->user[0]->roles,
        'defined' => $previus_data[0]->id,
        'data' => [
          'message' => 'Documento de fatura editado com sucesso.',
          'process' => edited_data($data, $previus_data[0])
        ]
      ],
    );

    // UPLOAD DA DANFE
    $danfe = json_decode($this->danfe($invoice[0]->id));

    if (!empty($danfe->error)) {
      $upload['upload']['danfe'] = $danfe->message;
    }

    if (isset($danfe->error) && !$danfe->error && isset($danfe->filepath)) {
      $id = uuidv4();
      $doc = [
        'id' => $id,
        'link' => $invoice[0]->id,
        'message' => NULL,
        'type' => 'DANFE NFE AUTORIZADA',
        'path' => $danfe->filepath,
        'isinactive' => 'F',
        'confirmed' => 'T',
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
        'created' => time(),
      ];

      $this->db->insert('invoicedocs', $doc);

      $this->data_persistence->log(
        [
          'table' => 'invoicedocs',
          'action' => 'create invoicedoc',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $id,
          'data' => [
            'message' => 'Documento de fatura criado com sucesso.',
          ]
        ],
      );
    }

    // UPLOAD DO XML
    $xml = json_decode($this->xml($invoice[0]->id));

    if (!empty($xml->error)) {
      $upload['upload']['xml'] = $xml->message;
    }

    if (isset($xml->error) && !$xml->error && isset($xml->filepath)) {
      $id = uuidv4();
      $doc = [
        'id' => $id,
        'link' => $invoice[0]->id,
        'message' => NULL,
        'type' => 'XML NFE AUTORIZADA',
        'path' => $xml->filepath,
        'isinactive' => 'F',
        'confirmed' => 'T',
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
        'created' => time(),
      ];

      $this->db->insert('invoicedocs', $doc);

      $this->data_persistence->log(
        [
          'table' => 'invoicedocs',
          'action' => 'create invoicedoc',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $id,
          'data' => [
            'message' => 'Documento de fatura criado com sucesso.',
          ]
        ],
      );
    }

    if (isset($upload['upload']['xml']) || isset($upload['upload']['danfe'])) {
      $upload['upload']['error'] = true;
      unset($upload['upload']['message']);
    }

    $response = array_merge($response, $upload);


    /*
     * ZERA A CONTAGEM DE CARTAS DE CORREÇÃO QUANDO A IMPORTAÇÃO FOR FEITA
     */
    $data = [
      'sequencecce' => 0,
      'ip' => $this->input->ip_address(),
      'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
      'platform' => $this->agent->platform(),
      'referer' => $this->agent->referrer(),
      'updated' => time(),
    ];

    $this->db->where('id', $invoice[0]->id)
      ->update('invoices', $data);

    $previus_data = $this->db->select('
      sequencecce
    ')
      ->where('id', $invoice[0]->id)
      ->get('invoices')
      ->result();

    $this->data_persistence->log(
      [
        'table' => 'invoice',
        'action' => 'edit invoice',
        'user_id' => $this->user[0]->id,
        'user_role' => $this->user[0]->roles,
        'defined' => $invoice[0]->id,
        'data' => [
          'message' => 'Fatura editada com sucesso.',
          'process' => edited_data($data, $previus_data[0])
        ]
      ],
    );

    return json_encode($response);
  }

  public function consult($invoice)
  {

    $invoice = $this->db->select('
      invoices.id,
      invoices.fiscaldocaccesskey,
      invoices.subsidiaryid,
      invoices.sequencecce
    ')
      ->where('invoices.id', $invoice)
      ->get('invoices')
      ->result();

    $subsidiary = $this->db->select('
      subsidiaries.id,
      subsidiaries.cnpj,
    ')
      ->where('subsidiaries.id', $invoice[0]->subsidiaryid)
      ->get('subsidiaries')
      ->result();

    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'PluginName' => 'NFe',
      'Campos' => 'chave,situacao,nnf,motivo,dtautorizacao,dtemissao,dtcancelamento,xjustcancelamento',
      'Filtro' => 'chave=' . trim($invoice[0]->fiscaldocaccesskey),
      'Encode' => true,
      'Origem' => 4,
    );

    $consult_nfe = $this->consultnfe($data);

    if ($consult_nfe == 'Nenhum registro encontrado.') {

      $data = array(
        'fiscaldocnumber' => (int) substr($invoice[0]->fiscaldocaccesskey, 25, 9),
        'fiscaldocaccesskey' => $invoice[0]->fiscaldocaccesskey,
        'ip' => $this->input->ip_address(),
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
        'updated' => time(),
      );

      $this->db->where('id', $invoice[0]->id)
        ->update('invoices', $data);

      $previus_data = $this->db->select('
        fiscaldocnumber
        fiscaldocaccesskey,
      ')
        ->where('id', $invoice[0]->id)
        ->get('invoices')
        ->result();

      $this->data_persistence->log(
        [
          'table' => 'invoice',
          'action' => 'edit invoice',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $invoice[0]->id,
          'data' => [
            'message' => 'Fatura editada com sucesso.',
            'process' => edited_data($invoice, $previus_data[0])
          ]
        ],
      );

      return json_encode(
        array(
          'error' => true,
          'message' => 'Não foi possível encontrar a NF-e ' . $invoice[0]->fiscaldocaccesskey,
          'ws-response' => $consult_nfe
        )
      );
    }

    $consult_nfe = explode(',', $consult_nfe);
    $fiscaldocdate = null;
    $fiscaldocsenddate = null;
    $fiscaldoccancellationdate = null;

    if (!!$consult_nfe[4]) {
      $fiscaldocdate = DateTime::createFromFormat('d/m/Y H:i:s', $consult_nfe[4]);
      $fiscaldocdate = $fiscaldocdate->format('Y-m-d H:i:s');
      $fiscaldocdate = strtotime($fiscaldocdate);
    }

    if (!!$consult_nfe[5]) {
      $fiscaldocsenddate = DateTime::createFromFormat('d/m/Y H:i:s', $consult_nfe[5]);
      $fiscaldocsenddate = $fiscaldocsenddate->format('Y-m-d H:i:s');
      $fiscaldocsenddate = strtotime($fiscaldocsenddate);
    }

    if (!!$consult_nfe[6]) {
      $fiscaldoccancellationdate = DateTime::createFromFormat('d/m/Y H:i:s', $consult_nfe[6]);
      $fiscaldoccancellationdate = $fiscaldoccancellationdate->format('Y-m-d H:i:s');
      $fiscaldoccancellationdate = strtotime($fiscaldoccancellationdate);
    }

    $data = array(
      'fiscaldocnumber' => $consult_nfe[2],
      'fiscaldocaccesskey' => $consult_nfe[0],
      'fiscaldocstatus' => mb_strtoupper($consult_nfe[1], 'UTF-8'),
      'fiscaldocdate' => $fiscaldocdate,
      'fiscaldocsenddate' => $fiscaldocsenddate,
      'fiscaldoccancellationdate' => $fiscaldoccancellationdate,
      'fiscaldocreturnmessage' => $consult_nfe[3],
      'ip' => $this->input->ip_address(),
      'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
      'platform' => $this->agent->platform(),
      'referer' => $this->agent->referrer(),
      'updated' => time(),
    );

    $this->db->where('id', $invoice[0]->id)
      ->update('invoices', $data);

    $previus_data = $this->db->select('
      fiscaldocnumber,
      fiscaldocaccesskey,
      fiscaldocstatus,
      fiscaldocdate,
      fiscaldocsenddate,
      fiscaldoccancellationdate,
      fiscaldocreturnmessage
    ')
      ->where('id', $invoice[0]->id)
      ->get('invoices')
      ->result();

    $this->data_persistence->log(
      [
        'table' => 'invoice',
        'action' => 'edit invoice',
        'user_id' => $this->user[0]->id,
        'user_role' => $this->user[0]->roles,
        'defined' => $invoice[0]->id,
        'data' => [
          'message' => 'Fatura editada com sucesso.',
          'process' => edited_data($data, $previus_data[0])
        ]
      ],
    );

    $response = array(
      'error' => false,
      'message' => $consult_nfe[3],
      'ws-response' => $consult_nfe,
    );

    $upload = [
      'upload' => [
        'error' => false,
        'message' => 'Upload(s) concluído(s) com sucesso.'
      ]
    ];

    if ($consult_nfe[1] == 'AUTORIZADA') {

      // inativando os registros antigos no banco quando for autorizado
      $data = [
        'isinactive' => 'T',
        'confirmed' => 'F',
        'ip' => $this->input->ip_address(),
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
      ];

      $this->db->where('link', $invoice[0]->id)
        ->update('invoicedocs', $data);

      $previus_data = $this->db->select('id, isinactive, confirmed')
        ->where('link', $invoice[0]->id)
        ->get('invoicedocs')
        ->result();

      $this->data_persistence->log(
        [
          'table' => 'invoicedocs',
          'action' => 'edit invoicedoc',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $previus_data[0]->id,
          'data' => [
            'message' => 'Documento de fatura editado com sucesso.',
            'process' => edited_data($data, $previus_data[0])
          ]
        ],
      );

      /*
       *
       * UPLOAD DA NFE AUTORIZADA
       *
       */
      // UPLOAD DA DANFE
      $danfe = json_decode($this->danfe($invoice[0]->id));

      if (!empty($danfe->error)) {
        $upload['upload']['danfe'] = $danfe->message;
      }

      if (isset($danfe->error) && !$danfe->error && isset($danfe->filepath)) {
        $id = uuidv4();
        $doc = [
          'id' => $id,
          'link' => $invoice[0]->id,
          'message' => NULL,
          'type' => 'DANFE NFE AUTORIZADA',
          'path' => $danfe->filepath,
          'isinactive' => 'F',
          'confirmed' => 'T',
          'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
          'platform' => $this->agent->platform(),
          'referer' => $this->agent->referrer(),
          'created' => time(),
        ];

        $this->db->insert('invoicedocs', $doc);

        $this->data_persistence->log(
          [
            'table' => 'invoicedocs',
            'action' => 'create invoicedoc',
            'user_id' => $this->user[0]->id,
            'user_role' => $this->user[0]->roles,
            'defined' => $id,
            'data' => [
              'message' => 'Documento de fatura criado com sucesso.',
            ]
          ],
        );
      }

      // UPLOAD DO XML
      $xml = json_decode($this->xml($invoice[0]->id));

      if (!empty($xml->error)) {
        $upload['upload']['xml'] = $xml->message;
      }

      if (isset($xml->error) && !$xml->error && isset($xml->filepath)) {
        $id = uuidv4();
        $doc = [
          'id' => $id,
          'link' => $invoice[0]->id,
          'message' => NULL,
          'type' => 'XML NFE AUTORIZADA',
          'path' => $xml->filepath,
          'isinactive' => 'F',
          'confirmed' => 'T',
          'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
          'platform' => $this->agent->platform(),
          'referer' => $this->agent->referrer(),
          'created' => time(),
        ];

        $this->db->insert('invoicedocs', $doc);

        $this->data_persistence->log(
          [
            'table' => 'invoicedocs',
            'action' => 'create invoicedoc',
            'user_id' => $this->user[0]->id,
            'user_role' => $this->user[0]->roles,
            'defined' => $id,
            'data' => [
              'message' => 'Documento de fatura criado com sucesso.',
            ]
          ],
        );
      }


      /*
       * CASO HAJA CARTAS DE CORREÇÃO DA NF, FAZ UPLOAD DA CCe
       */
      if ($invoice[0]->sequencecce > 0) {

        /*
         *
         * UPLOAD DA CCe
         *
         */

        //todo achar uma forma de buscar a mensagem do cce e inserir no campo message da doc

        $cce = json_decode($this->danfe($invoice[0]->id, 'CCe'));

        if (!empty($cce->error)) {
          $upload['upload']['cce'] = $cce->message;
        }

        if (isset($cce->error) && !$cce->error && isset($cce->filepath)) {
          $id = uuidv4();
          $doc = [
            'id' => $id,
            'link' => $invoice[0]->id,
            'message' => NULL,
            'type' => 'CCE AUTORIZADA',
            'path' => $cce->filepath,
            'isinactive' => 'F',
            'confirmed' => 'T',
            'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
            'platform' => $this->agent->platform(),
            'referer' => $this->agent->referrer(),
            'created' => time(),
          ];

          $this->db->insert('invoicedocs', $doc);

          $this->data_persistence->log(
            [
              'table' => 'invoicedocs',
              'action' => 'create invoicedoc',
              'user_id' => $this->user[0]->id,
              'user_role' => $this->user[0]->roles,
              'defined' => $id,
              'data' => [
                'message' => 'Documento de fatura criado com sucesso.',
              ]
            ],
          );
        }

        // UPLOAD DO XML
        $xml = json_decode($this->xml($invoice[0]->id, 'CCe'));

        if (!empty($xml->error)) {
          $upload['upload']['xml'] = $xml->message;
        }

        if (isset($xml->error) && !$xml->error && isset($xml->filepath)) {
          $id = uuidv4();
          $doc = [
            'id' => $id,
            'link' => $invoice[0]->id,
            'message' => NULL,
            'type' => 'XML CCE AUTORIZADA',
            'path' => $xml->filepath,
            'isinactive' => 'F',
            'confirmed' => 'T',
            'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
            'platform' => $this->agent->platform(),
            'referer' => $this->agent->referrer(),
            'created' => time(),
          ];

          $this->db->insert('invoicedocs', $doc);

          $this->data_persistence->log(
            [
              'table' => 'invoicedocs',
              'action' => 'create invoicedoc',
              'user_id' => $this->user[0]->id,
              'user_role' => $this->user[0]->roles,
              'defined' => $id,
              'data' => [
                'message' => 'Documento de fatura criado com sucesso.',
              ]
            ],
          );
        }
      }
    }

    if ($consult_nfe[1] == 'CANCELADA') {
      // xjustcancelamento	Descrição da justificativa de cancelamento da NF-e.

      /*
       *
       * UPLOAD DO XML DO CANCELAMENTO
       *
       */
      // UPLOAD DO XML
      $xml = json_decode($this->xml($invoice[0]->id, 'Cancelamento'));

      if (!empty($xml->error)) {
        $upload['upload']['xml'] = $xml->message;
      }

      if (isset($xml->error) && !$xml->error && isset($xml->filepath)) {
        $id = uuidv4();
        $doc = [
          'id' => $id,
          'link' => $invoice[0]->id,
          'message' => $consult_nfe[7],
          'type' => 'XML NFE CANCELADA',
          'path' => $xml->filepath,
          'isinactive' => 'F',
          'confirmed' => 'T',
          'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
          'platform' => $this->agent->platform(),
          'referer' => $this->agent->referrer(),
          'created' => time(),
        ];

        $this->db->insert('invoicedocs', $doc);

        $this->data_persistence->log(
          [
            'table' => 'invoicedocs',
            'action' => 'create invoicedoc',
            'user_id' => $this->user[0]->id,
            'user_role' => $this->user[0]->roles,
            'defined' => $id,
            'data' => [
              'message' => 'Documento de fatura criado com sucesso.',
            ]
          ],
        );

      }
    }

    if (isset($upload['upload']['xml']) || isset($upload['upload']['danfe']) || isset($upload['upload']['cce'])) {
      $upload['upload']['error'] = true;
      unset($upload['upload']['message']);
    }

    $response = array_merge($response, $upload);

    return json_encode($response);
  }

  public function stats($subsidiary)
  {

    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj)
    );

    $stats = $this->servernfestats($data);

    if (strpos($stats, 'Servico em operacao') !== false) {
      return true;
    }

    return false;
  }

  public function correction($invoice, $correction)
  {
    $invoice = $this->db->select('
      invoices.id,
      invoices.fiscaldocaccesskey,
      invoices.subsidiaryid,
      invoices.sequencecce
    ')
      ->where('invoices.id', $invoice)
      ->get('invoices')
      ->result();

    $subsidiary = $this->db->select('
      subsidiaries.id,
      subsidiaries.title,
      subsidiaries.name,
      subsidiaries.legalname,
      subsidiaries.phone,
      subsidiaries.cnpj,
      subsidiaries.ie,
      subsidiaries.taxregime,
      taxregimes.title as taxregimetitle,
      taxregimes.code as taxregimecode,
      subsidiaries.utilizationrate,
      subsidiaries.hassimplesnacionalicms
    ')
      ->join('taxregimes', 'taxregimes.id = subsidiaries.taxregime', 'LEFT')
      ->where('subsidiaries.id', $invoice[0]->subsidiaryid)
      ->get('subsidiaries')
      ->result();

    $invoice[0]->correction = $correction;

    /*
     * ------------------------------------------------------------
     * A Carta de Correção é disciplinada pelo parágrafo 1o-A do art. 7o do Convênio S/N, de 15 de dezembro de 1970 e pode ser utilizada para regularização de erro ocorrido na emissão de documento fiscal, desde que o erro nao esteja relacionado com:
     * 1 - as variáveis que determinam o valor do imposto tais como: base de cálculo, alíquota, diferença de preço, quantidade, valor da operação ou da prestação;
     * 2 - a correção de dados cadastrais que implique mudança do remetente ou do destinatário;
     * 3 - a data de emissão ou de saída
     * ------------------------------------------------------------
     */

    $tx2 = $this->getcorrectiontx2($invoice);

    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'Arquivo' => $tx2,
    );

    $serverstats = $this->stats($subsidiary);

    if (!$serverstats) {
      return json_encode(
        array(
          'error' => true,
          'message' => 'Servidor NF-e fora de operação',
        )
      );
    }

    $nfe = $this->sendnfe($data);

    if (strpos($nfe, 'EXCEPTION') !== false) {

      // ERRO NA VALIDAÇÃO DO WEBSERVICE

      $nfe = explode(',', $nfe);
      return json_encode([
        'error' => true,
        'message' => $nfe[2],
        'ws-response' => $nfe
      ]);
    }

    $nfe = explode(',', $nfe);

    $sefazst = NULL;
    $accesskey = NULL;

    foreach ($nfe as $value) {

      if (strlen($value) == 44) {
        $accesskey = $value;
      }

      if (strlen($value) == 3) {
        $sefazst = $value;
      }

    }

    if ($sefazst != '135') {

      // RETORNO ERRO NO ENVIO NA CCe NA SEFAZ

      $data = array(
        // 'fiscaldocnumber' => (int) substr($nfe[1], 25, 9),
        'fiscaldocaccesskey' => $accesskey,
        'fiscaldocstatus' => $nfe[0],
        'fiscaldocreturnmessage' => $nfe[3],
        'ip' => $this->input->ip_address(),
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
        'updated' => time(),
      );

      $this->db->where('id', $invoice[0]->id)
        ->update('invoices', $data);

      $previus_data = $this->db->select('
          fiscaldocaccesskey,
          fiscaldocstatus,
          fiscaldocreturnmessage
        ')
        ->where('id', $invoice[0]->id)
        ->get('invoices')
        ->result();

      $this->data_persistence->log(
        [
          'table' => 'invoice',
          'action' => 'edit invoice',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $invoice[0]->id,
          'data' => [
            'message' => 'Fatura editada com sucesso.',
            'process' => edited_data($data, $previus_data[0])
          ]
        ],
      );

      return json_encode(array(
        'error' => true,
        'message' => $nfe[3],
        'ws-response' => $nfe,
      ));
    }

    // RETORNO CCe AUTORIZADA

    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'PluginName' => 'NFe',
      'Campos' => 'chave,situacao,nnf,motivo,dtautorizacao,dtemissao',
      'Filtro' => 'chave=' . $accesskey,
      'Encode' => true,
      'Origem' => 4,
    );

    $consult_nfe = $this->consultnfe($data);

    if ($consult_nfe == 'Nenhum registro encontrado.') {

      $data = array(
        // 'fiscaldocnumber' => (int) substr($nfe[1], 25, 9),
        'fiscaldocaccesskey' => $accesskey,
        'ip' => $this->input->ip_address(),
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
        'updated' => time(),
      );

      $this->db->where('id', $invoice[0]->id)
        ->update('invoices', $data);

      $previus_data = $this->db->select('
          fiscaldocaccesskey,
        ')
        ->where('id', $invoice[0]->id)
        ->get('invoices')
        ->result();

      $this->data_persistence->log(
        [
          'table' => 'invoice',
          'action' => 'edit invoice',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $invoice[0]->id,
          'data' => [
            'message' => 'Fatura editada com sucesso.',
            'process' => edited_data($data, $previus_data[0])
          ]
        ],
      );

      return json_encode(
        array(
          'error' => true,
          'message' => 'Não foi possível encontrar a NF-e ' . $accesskey,
          'ws-response' => $nfe,
        )
      );
    }

    /*
     * ------------------------------------------------------------
     * As possíveis situações para a situação de uma NF-e no Manager SaaS são:
     * Autorizada: Nota autorizada pela SEFAZ.
     * Cancelada: Cancelamento autorizado pela SEFAZ.
     * Enviada: Nota fiscal enviada para SEFAZ, mas sem retorno da requisição de envio (Nesse caso não sabemos se a nota foi autorizada ou rejeitada).
     * Registrada: Nota fiscal gravada na base de dados do Manager SaaS, mas por alguma falha a nota não foi enviada a SEFAZ até o momento. (Normalmente por problemas de conexão).
     * Rejeitada: Nota fiscal rejeitada pela SEFAZ e portanto não autorizada.
     * Inutilizada: Indica que a faixa de numeração da nota fiscal já foi inutilizada.
     * Recebida: Indica que a nota fiscal foi enviada e a SEFAZ retornou que a nota foi recebida e ainda não tem uma situação final (autorizada ou rejeitada).
     * Denegada: Indica que a nota fiscal não foi autorizada devido ao emitente possuir alguma irregularidade em seu cadastro junto a SEFAZ ou alguma pendência.
     * ------------------------------------------------------------
     */

    $consult_nfe = explode(',', $consult_nfe);
    $fiscaldocdate = null;
    $fiscaldocsenddate = null;

    if (!!$consult_nfe[4]) {
      $fiscaldocdate = DateTime::createFromFormat('d/m/Y H:i:s', $consult_nfe[4]);
      $fiscaldocdate = $fiscaldocdate->format('Y-m-d H:i:s');
      $fiscaldocdate = strtotime($fiscaldocdate);
    }

    if (!!$consult_nfe[5]) {
      $fiscaldocsenddate = DateTime::createFromFormat('d/m/Y H:i:s', $consult_nfe[5]);
      $fiscaldocsenddate = $fiscaldocsenddate->format('Y-m-d H:i:s');
      $fiscaldocsenddate = strtotime($fiscaldocsenddate);
    }

    $data = array(
      'fiscaldocnumber' => $consult_nfe[2],
      'fiscaldocaccesskey' => $consult_nfe[0],
      'fiscaldocstatus' => mb_strtoupper($consult_nfe[1], 'UTF-8'),
      'fiscaldocdate' => $fiscaldocdate,
      'fiscaldocsenddate' => $fiscaldocsenddate,
      'fiscaldocreturnmessage' => $consult_nfe[3],
      'ip' => $this->input->ip_address(),
      'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
      'platform' => $this->agent->platform(),
      'referer' => $this->agent->referrer(),
      'updated' => time(),
    );

    $this->db->where('id', $invoice[0]->id)
      ->update('invoices', $data);

    $previus_data = $this->db->select('
        fiscaldocnumber,
        fiscaldocaccesskey,
        fiscaldocstatus,
        fiscaldocdate,
        fiscaldocsenddate,
        fiscaldocreturnmessage
      ')
      ->where('id', $invoice[0]->id)
      ->get('invoices')
      ->result();

    $this->data_persistence->log(
      [
        'table' => 'invoice',
        'action' => 'edit invoice',
        'user_id' => $this->user[0]->id,
        'user_role' => $this->user[0]->roles,
        'defined' => $invoice[0]->id,
        'data' => [
          'message' => 'Fatura editada com sucesso.',
          'process' => edited_data($data, $previus_data[0])
        ]
      ],
    );

    $response = array(
      'error' => false,
      'message' => $consult_nfe[3],
      'ws-response' => $nfe,
    );

    $upload = [
      'upload' => [
        'error' => false,
        'message' => 'Upload(s) concluído(s) com sucesso.'
      ]
    ];

    // UPLOAD DA DANFE
    $cce = json_decode($this->danfe($invoice[0]->id, 'CCe'));

    if (!empty($cce->error)) {
      $upload['upload']['cce'] = $cce->message;
    }

    if (isset($cce->error) && !$cce->error && isset($cce->filepath)) {
      $id = uuidv4();
      $doc = [
        'id' => $id,
        'link' => $invoice[0]->id,
        'message' => $correction,
        'type' => 'CCE AUTORIZADA',
        'path' => $cce->filepath,
        'isinactive' => 'F',
        'confirmed' => 'T',
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
        'created' => time(),
      ];

      $this->db->insert('invoicedocs', $doc);

      $this->data_persistence->log(
        [
          'table' => 'invoicedocs',
          'action' => 'create invoicedoc',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $id,
          'data' => [
            'message' => 'Documento de fatura criado com sucesso.',
          ]
        ],
      );
    }

    // UPLOAD DO XML
    $xml = json_decode($this->xml($invoice[0]->id, 'CCe'));

    if (!empty($xml->error)) {
      $upload['upload']['xml'] = $xml->message;
    }

    if (isset($xml->error) && !$xml->error && isset($xml->filepath)) {
      $id = uuidv4();
      $doc = [
        'id' => $id,
        'link' => $invoice[0]->id,
        'message' => $correction,
        'type' => 'XML CCE AUTORIZADA',
        'path' => $xml->filepath,
        'isinactive' => 'F',
        'confirmed' => 'T',
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
        'created' => time(),
      ];

      $this->db->insert('invoicedocs', $doc);

      $this->data_persistence->log(
        [
          'table' => 'invoicedocs',
          'action' => 'create invoicedoc',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $id,
          'data' => [
            'message' => 'Documento de fatura criado com sucesso.',
          ]
        ],
      );
    }

    if (isset($upload['upload']['xml']) || isset($upload['upload']['cce'])) {
      $upload['upload']['error'] = true;
      unset($upload['upload']['message']);
    }

    $response = array_merge($response, $upload);

    /*
     * SOMA UM NA CONTAGEM DE CARTAS DE CORREÇÃO QUANDO A CORREÇÃO FOR REGISTRADA
     */
    $data = [
      'sequencecce' => $invoice[0]->sequencecce + 1,
      'ip' => $this->input->ip_address(),
      'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
      'platform' => $this->agent->platform(),
      'referer' => $this->agent->referrer(),
      'updated' => time(),
    ];

    $this->db->where('id', $invoice[0]->id)
      ->update('invoices', $data);

    $previus_data = $this->db->select('
        sequencecce
      ')
      ->where('id', $invoice[0]->id)
      ->get('invoices')
      ->result();

    $this->data_persistence->log(
      [
        'table' => 'invoice',
        'action' => 'edit invoice',
        'user_id' => $this->user[0]->id,
        'user_role' => $this->user[0]->roles,
        'defined' => $invoice[0]->id,
        'data' => [
          'message' => 'Fatura editada com sucesso.',
          'process' => edited_data($data, $previus_data[0])
        ]
      ],
    );

    return json_encode($response);

  }

  public function danfe($invoice, $documenttype = false)
  {

    $invoice = $this->db->select('
      invoices.id,
      invoices.subsidiaryid,
      invoices.fiscaldocaccesskey
    ')
      ->where('invoices.id', $invoice)
      ->get('invoices')
      ->result();

    $subsidiary = $this->db->select('
      subsidiaries.id,
      subsidiaries.cnpj
    ')
      ->where('subsidiaries.id', $invoice[0]->subsidiaryid)
      ->get('subsidiaries')
      ->result();

    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'ChaveNota' => $invoice[0]->fiscaldocaccesskey,
      /*
       * ------------------------------------------------------------
       * Define qual será o formato do retorno da requisição. Valores aceitos:
       * 0 = Conteúdo binário do arquivo PDF
       * 1 = URL para download do PDF
       * ------------------------------------------------------------
       */
      'Url' => 0,
      /*
       * ------------------------------------------------------------
       * Parâmetro opcional. Utilizado quando se deseja informar o modelo de impressão sem a necessidade de reconfigurar o SaaS
       * Valores aceitos:
       * 1 = Retrato
       * 2 = Paisagem
       * 3 = Simplificado-etiqueta
       * Para utilização de etiqueta deverá ser alterado a propriedade ModeloDanfeSimplificado=RetratoSimplificadoEtiqueta.rtm no ini, utilizando a rota modo, somente será possível emitir simplificado ou etiqueta para esse caso
       * Obs 1: O ModeloImpressao informado deve estar previamente configurado.
       * Obs 2: Se não informar o ModeloImpressao ou informar em branco, será utilizado o modelo padrão.
       * ------------------------------------------------------------
       */
      'ModeloImpressao' => 1
    );

    // if (isset($invoice[0]->documenttype)) {
    //   /*
    //    * ------------------------------------------------------------
    //    * Utilizado quando se deseja imprimir a ultima CCe da nota
    //    * CCe
    //    * ------------------------------------------------------------
    //    */
    //   $data['Documento'] = $invoice[0]->documenttype;
    // }

    if ($documenttype) {
      /*
       * ------------------------------------------------------------
       * Utilizado quando se deseja imprimir a ultima CCe da nota
       * CCe
       * ------------------------------------------------------------
       */
      $data['Documento'] = $documenttype;
    }

    $danfe = $this->getdanfe($data);

    if (strpos($danfe, 'EXCEPTION') !== false) {
      $danfe = explode(',', $danfe);

      return json_encode(
        array(
          'error' => true,
          'message' => $danfe[2],
          'ws-response' => $danfe
        )
      );
    }

    $prefix = $documenttype ? $documenttype : 'NFe';

    $dir = FCPATH . 'uploads/notasfiscais/' . date('Y') . '/' . date('m') . '/';
    $filename = $prefix . '_' . substr($invoice[0]->fiscaldocaccesskey, 25, 9) . '.pdf';
    $filepath = $dir . $filename;

    if (!is_dir($dir)) {
      mkdir($dir, 0755, true);
    }

    $path = NULL;
    $upload = file_put_contents($filepath, $danfe);

    /*
     *
     * CASO EM AMBIENTE DE DESENVOLVIMENTO, SOBE OS ARQUIVOS NA PASTA UPLOADS, E ARMAZENA O PATH COM BASE_URL
     *
     */
    if (in_array(ENVIRONMENT, array('development', 'dev'))) {
      $path = BASE_URL . '/uploads/notasfiscais/' . date('Y') . '/' . date('m') . '/' . $filename;
      if (!$upload) {
        return json_encode([
          'error' => true,
          'message' => 'Erro ao salvar o arquivo.'
        ]);
      }
    }

    /*
     *
     * CASO EM AMBIENTE DE TESTE OU PRODUCAO, SOBE OS ARQUIVOS NO WASABI, E ARMAZENA O PATH RELATIVO
     *
     */
    if (in_array(ENVIRONMENT, array('production', 'testing'))) {

      $upload = upload_w3("invoices/notasfiscais/" . date('Y'));
      $upload = upload_w3("invoices/notasfiscais/" . date('Y') . "/" . date('m'));
      $upload = upload_w3("invoices/notasfiscais/" . date('Y') . "/" . date('m'), $filepath, $filename);

      $path = "invoices/notasfiscais/" . date('Y') . "/" . date('m') . '/' . $filename;

      if (!empty($upload['error'])) {
        return json_encode($upload);
      }
      unlink($filepath);
    }

    if (file_exists($filepath) || empty($upload['error'])) {
      return json_encode(
        array(
          'error' => false,
          'message' => 'Arquivo PDF salvo com sucesso.',
          'filepath' => $path,
        )
      );
    }

  }

  public function xml($invoice, $documenttype = false)
  {

    $invoice = $this->db->select('
      invoices.id,
      invoices.subsidiaryid,
      invoices.fiscaldocaccesskey
    ')
      ->where('invoices.id', $invoice)
      ->get('invoices')
      ->result();

    $subsidiary = $this->db->select('
      subsidiaries.id,
      subsidiaries.cnpj
    ')
      ->where('subsidiaries.id', $invoice[0]->subsidiaryid)
      ->get('subsidiaries')
      ->result();

    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'ChaveNota' => $invoice[0]->fiscaldocaccesskey
    );

    // if (isset($invoice[0]->documenttype)) {
    //   /*
    //    * ------------------------------------------------------------
    //    * Define qual será o documento que terá o xml retornado na requisição. Caso desejar obter o XML de autorização, não precisa enviar este parâmetro
    //    * Cancelamento
    //    * CCe
    //    * ------------------------------------------------------------
    //    */
    //   $data['Documento'] = $invoice[0]->documenttype;
    // }

    if ($documenttype) {
      /*
       * ------------------------------------------------------------
       * Define qual será o documento que terá o xml retornado na requisição. Caso desejar obter o XML de autorização, não precisa enviar este parâmetro
       * Cancelamento
       * CCe
       * ------------------------------------------------------------
       */
      $data['Documento'] = $documenttype;
    }
    $xml = $this->getxml($data);

    if (strpos($xml, 'Nenhum registro encontrado.') !== false) {
      $xml = explode(',', $xml);

      return json_encode(
        array(
          'error' => true,
          'message' => 'Arquivo XML não encontrado.',
          'ws-response' => $xml
        )
      );
    }

    $prefix = $documenttype ? $documenttype : 'XML';

    $dir = FCPATH . 'uploads/notasfiscais/' . date('Y') . '/' . date('m') . '/';
    $filename = $prefix . '_' . substr($invoice[0]->fiscaldocaccesskey, 25, 9) . '.xml';
    $filepath = $dir . $filename;

    if (!is_dir($dir)) {
      mkdir($dir, 0755, true);
    }

    $path = NULL;
    $upload = file_put_contents($filepath, $xml);

    /*
     *
     * CASO EM AMBIENTE LOCAL, SOBE OS ARQUIVOS NA PASTA UPLOADS, E DEFINE O PATH COM BASE_URL
     *
     */
    if (in_array(ENVIRONMENT, array('development', 'dev'))) {
      $path = BASE_URL . '/uploads/notasfiscais/' . date('Y') . '/' . date('m') . '/' . $filename;
      if (!$upload) {
        return json_encode([
          'error' => true,
          'message' => 'Erro ao salvar o arquivo.'
        ]);
      }
    }

    /*
     *
     * CASO EM AMBIENTE DE TESTE OU PRODUCAO, SOBE OS ARQUIVOS NO WASABI, E ARMAZENA O PATH RELATIVO
     *
     */
    if (in_array(ENVIRONMENT, array('production', 'testing'))) {
      $upload = upload_w3("invoices/notasfiscais/" . date('Y'));
      $upload = upload_w3("invoices/notasfiscais/" . date('Y') . "/" . date('m'));
      $upload = upload_w3("invoices/notasfiscais/" . date('Y') . "/" . date('m'), $filepath, $filename);

      $path = "invoices/notasfiscais/" . date('Y') . "/" . date('m') . '/' . $filename;

      if (!empty($upload['error'])) {
        return json_encode($upload);
      }

      unlink($filepath);
    }

    if (file_exists($filepath) || empty($upload['error'])) {
      return json_encode(
        array(
          'error' => false,
          'message' => 'Arquivo XML salvo com sucesso.',
          'filepath' => $path,
          'ws-response' => $xml
        )
      );
    }

  }

  public function cancel($invoice, $justification = 'Cancelamento de NF-e')
  {

    $invoice = $this->db->select('
      invoices.id,
      invoices.fiscaldocaccesskey,
      invoices.subsidiaryid
    ')
      ->where('invoices.id', $invoice)
      ->get('invoices')
      ->result();

    $subsidiary = $this->db->select('
      subsidiaries.id,
      subsidiaries.cnpj,
    ')
      ->where('subsidiaries.id', $invoice[0]->subsidiaryid)
      ->get('subsidiaries')
      ->result();

    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'ChaveNota' => $invoice[0]->fiscaldocaccesskey,
      'Justificativa' => $justification,
    );

    $nfe = explode(',', $this->cancelnfe($data));

    // retorno 135 indica que o EVENTO de cancelamento foi registrado
    // quando for homologado com exito na SEFAZ, o status da NF é 101
    // quando for 155, indica que foi cancelado fora de prazo

    if (!in_array($nfe[1], ['135', '101', '155'])) {

      // ERRO NO CANCELAMENTO

      return json_encode(
        array(
          'error' => true,
          'message' => $nfe[2],
          'ws-response' => $nfe
        )
      );

    }

    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'PluginName' => 'NFe',
      'Campos' => 'chave,situacao,nnf,motivo,dtautorizacao,dtemissao,dtcancelamento',
      'Filtro' => 'chave=' . $invoice[0]->fiscaldocaccesskey,
      'Encode' => true,
      'Origem' => 4,
    );

    $consult_nfe = $this->consultnfe($data);

    if ($consult_nfe == 'Nenhum registro encontrado.') {
      return json_encode(
        array(
          'error' => true,
          'message' => 'Não foi possível efetuar o cancelamento da NF-e ' . $invoice[0]->fiscaldocaccesskey,
          'ws-response' => $nfe
        )
      );
    }

    $consult_nfe = explode(',', $consult_nfe);

    /*
     * ------------------------------------------------------------
     * As possíveis situações para a situação de uma NF-e no Manager SaaS são:
     * Autorizada: Nota autorizada pela SEFAZ.
     * Cancelada: Cancelamento autorizado pela SEFAZ.
     * Enviada: Nota fiscal enviada para SEFAZ, mas sem retorno da requisição de envio (Nesse caso não sabemos se a nota foi autorizada ou rejeitada).
     * Registrada: Nota fiscal gravada na base de dados do Manager SaaS, mas por alguma falha a nota não foi enviada a SEFAZ até o momento. (Normalmente por problemas de conexão).
     * Rejeitada: Nota fiscal rejeitada pela SEFAZ e portanto não autorizada.
     * Inutilizada: Indica que a faixa de numeração da nota fiscal já foi inutilizada.
     * Recebida: Indica que a nota fiscal foi enviada e a SEFAZ retornou que a nota foi recebida e ainda não tem uma situação final (autorizada ou rejeitada).
     * Denegada: Indica que a nota fiscal não foi autorizada devido ao emitente possuir alguma irregularidade em seu cadastro junto a SEFAZ ou alguma pendência.
     * ------------------------------------------------------------
     */

    $fiscaldoccancellationdate = null;

    if (!!$consult_nfe[6]) {
      $fiscaldoccancellationdate = DateTime::createFromFormat('d/m/Y H:i:s', $consult_nfe[6]);
      $fiscaldoccancellationdate = $fiscaldoccancellationdate->format('Y-m-d H:i:s');
      $fiscaldoccancellationdate = strtotime($fiscaldoccancellationdate);
    }

    $data = array(
      'fiscaldoccancellationdate' => $fiscaldoccancellationdate,
      'fiscaldocstatus' => mb_strtoupper($consult_nfe[1], 'UTF-8'),
      'fiscaldocreturnmessage' => $consult_nfe[3],
      'ip' => $this->input->ip_address(),
      'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
      'platform' => $this->agent->platform(),
      'referer' => $this->agent->referrer(),
      'updated' => time(),
    );

    $this->db->where('id', $invoice[0]->id)
      ->update('invoices', $data);

    $previus_data = $this->db->select('
        fiscaldoccancellationdate,
        fiscaldocstatus,
        fiscaldocreturnmessage
      ')
      ->where('id', $invoice[0]->id)
      ->get('invoices')
      ->result();

    $this->data_persistence->log(
      [
        'table' => 'invoice',
        'action' => 'edit invoice',
        'user_id' => $this->user[0]->id,
        'user_role' => $this->user[0]->roles,
        'defined' => $invoice[0]->id,
        'data' => [
          'message' => 'Fatura editada com sucesso.',
          'process' => edited_data($data, $previus_data[0])
        ]
      ],
    );

    $response = array(
      'error' => false,
      'message' => $consult_nfe[3],
      'ws-message' => $nfe,
    );

    $upload = [
      'upload' => [
        'error' => false,
        'message' => 'Upload(s) concluído(s) com sucesso.'
      ]
    ];

    // UPLOAD DO XML
    $xml = json_decode($this->xml($invoice[0]->id, 'Cancelamento'));

    if (!empty($xml->error)) {
      $upload['upload']['xml'] = $xml->message;
    }

    if (isset($xml->error) && !$xml->error && isset($xml->filepath)) {
      $id = uuidv4();
      $doc = [
        'id' => $id,
        'link' => $invoice[0]->id,
        'message' => $justification,
        'type' => 'XML NFE CANCELADA',
        'path' => $xml->filepath,
        'isinactive' => 'F',
        'confirmed' => 'T',
        'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
        'platform' => $this->agent->platform(),
        'referer' => $this->agent->referrer(),
        'created' => time(),
      ];

      $this->db->insert('invoicedocs', $doc);

      $this->data_persistence->log(
        [
          'table' => 'invoicedocs',
          'action' => 'create invoicedoc',
          'user_id' => $this->user[0]->id,
          'user_role' => $this->user[0]->roles,
          'defined' => $id,
          'data' => [
            'message' => 'Documento de fatura criado com sucesso.',
          ]
        ],
      );
    }

    if (isset($upload['upload']['xml'])) {
      $upload['upload']['error'] = true;
      unset($upload['upload']['message']);
    }

    $response = array_merge($response, $upload);

    /*
     * ZERA A CONTAGEM DE CARTAS DE CORREÇÃO QUANDO O CANCELAMENTO FOR FEITO
     */
    $data = [
      'sequencecce' => 0,
      'ip' => $this->input->ip_address(),
      'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
      'platform' => $this->agent->platform(),
      'referer' => $this->agent->referrer(),
      'updated' => time(),
    ];

    $this->db->where('id', $invoice[0]->id)
      ->update('invoices', $data);

    $previus_data = $this->db->select('
      sequencecce
    ')
      ->where('id', $invoice[0]->id)
      ->get('invoices')
      ->result();

    $this->data_persistence->log(
      [
        'table' => 'invoice',
        'action' => 'edit invoice',
        'user_id' => $this->user[0]->id,
        'user_role' => $this->user[0]->roles,
        'defined' => $invoice[0]->id,
        'data' => [
          'message' => 'Fatura editada com sucesso.',
          'process' => edited_data($data, $previus_data[0])
        ]
      ],
    );

    return json_encode($response);

  }

  private function getheadertx2($invoice, $subsidiary, $subsidiarybilladdress, $client, $clientaddress, $items)
  {
    // consulta o ultimo numero de uma nfe
    $data = array(
      'Grupo' => TECNOSPEED_GROUP,
      'CNPJ' => preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'PluginName' => 'NFe',
      'Campos' => 'serie,numero',
      'Filtro' => 'cnpj=' . preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      'Encode' => true,
      'Ordem' => 'serie DESC',
      'Visao' => 'TspdNFeProxNum',
    );

    $consult_nfes = $this->consultnfe($data);

    $serie_B07 = 0;
    $nNF_B08 = 1;

    if ($consult_nfes != 'Nenhum registro encontrado.') {
      $consult_nfes = explode(',', $this->consultnfe($data));
      $serie_B07 = $consult_nfes[0];
      $nNF_B08 = $consult_nfes[1] + 1;
    }

    // Código Numérico que compõe a Chave de Acesso
    $cNF_B03 = str_pad($invoice[0]->tranid, 8, '0', STR_PAD_LEFT);

    // Descrição da Natureza da Operação
    $natOp_B04 = $this->db->select('id, name, title, description')
      ->where('name', $items[0]->cfop)
      ->where('confirmed', 'T')
      ->get('cfops')
      ->result();

    $natOp_B04 = substr($natOp_B04[0]->description, 0, 60);

    // Data e hora de emissão do Documento Fiscal
    $timezone = new DateTimeZone('America/Sao_Paulo');
    $date = new DateTime('now', $timezone);
    $dhEmi_B09 = $date->format('Y-m-d\TH:i:sP');

    // Tipo de Operação
    $operationtype = $tpNF_B11 = $this->db->select('id, name, title, code, transactiontypeid')
      ->where('id', $invoice[0]->operationtypeid)
      ->where('confirmed', 'T')
      ->where('isinactive', 'F')
      ->get('operationtypes')
      ->result();

    $tpNF_B11 = $this->db->select('id, name, title, code')
      ->where('id', $operationtype[0]->transactiontypeid)
      ->where('confirmed', 'T')
      ->get('operationtransactiontypes')
      ->result();

    $tpNF_B11 = $tpNF_B11[0]->code;

    // Identificador de local de destino da operação
    $idDest_B11a = 1;

    if ($clientaddress[0]->state != $subsidiarybilladdress[0]->state) {
      $idDest_B11a = 2;
    }

    // Versão do Processo de emissão da NF-e
    $finNFe_B25 = 1;

    /*
     * ------------------------------------------------------------
     * Se a natureza da operação é:
     * 14 - DEVOLUÇÃO DE VENDA (ENTRADA)
     * ------------------------------------------------------------
     */
    if ($operationtype[0]->code == 14) {
      $finNFe_B25 = 4;
    }

    // Indica operação com Consumidor final
    $indFinal_B25a = 0;

    /*
     * ------------------------------------------------------------
     * Se o setor de atividade do cliente é:
     * 0 = Normal
     * 1 = Consumidor Final
     * ------------------------------------------------------------
     */
    $activitysector = $this->db->select('id, name, title')
      ->where('id', $client[0]->activitysector)
      ->where('confirmed', 'T')
      ->get('activitysectors')
      ->result();

    $indFinal_B25a = 0;

    if ($activitysector && $activitysector[0]->name == 'consumidor final') {
      $indFinal_B25a = 1;
    }

    $tx2 =
      'Formato=tx2' . PHP_EOL .
      'numlote=0' . PHP_EOL .
      'INCLUIR' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * versao_A02
       * versão do layout
       * ------------------------------------------------------------
       */
      'versao_A02=4.00' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * id_A03
       * Chave da NFe a ser assinada
       * Campo de preenchimento automático, não é necessário informar
       * ------------------------------------------------------------
       */
      'Id_A03=0' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * cUF_B02
       * Código da UF do emitente do Documento Fiscal
       * 35 = SP
       * ------------------------------------------------------------
       */
      'cUF_B02=35' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * cNF_B03
       * Código Numérico que compõe a Chave de Acesso
       * Campo de preenchimento livre, de controle a critério do desevolvedor
       * ------------------------------------------------------------
       */
      'cNF_B03=' . $cNF_B03 . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * natOp_B04
       * Descrição da Natureza da Operação
       * ------------------------------------------------------------
       */
      'natOp_B04=' . $natOp_B04 . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * mod_B06
       * Código do Modelo do Documento Fiscal
       * Exemplo de preenchimento: 55 para NFe
       * ------------------------------------------------------------
       */
      'mod_B06=55' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * serie_B07
       * Série do Documento Fiscal
       * Informação obtida com o contador do emissor
       * ------------------------------------------------------------
       */
      'serie_B07=' . $serie_B07 . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * nNF_B08
       * Número do documento fiscal
       * Numeração da NFe, deve ser Sequência l e não pode se repetir dentro da mesma série
       * ------------------------------------------------------------
       */
      'nNF_B08=' . $nNF_B08 . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * dhEmi_B09
       * Data e hora de emissão do Documento Fiscal
       * Data e hora no formato UTC (Universal Coordinated Time): AAAA-MM-DDThh:mm:ssTZD
       * ------------------------------------------------------------
       */
      'dhEmi_B09=' . $dhEmi_B09 . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * tpNF_B11
       * Tipo de Operação
       * 0 = Entrada
       * 1 = Saída
       * ------------------------------------------------------------
       */
      'tpNF_B11=' . $tpNF_B11 . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * idDest_B11a
       * Identificador de local de destino da operação
       * 1 = Operação interna
       * 2 = Operação interestadual
       * 3 = Operação com exterior
       * ------------------------------------------------------------
       */
      'idDest_B11a=' . $idDest_B11a . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * cMunFG_B12
       * Código do Município de Ocorrência do Fato Gerador
       * Informar o município de ocorrência do fato gerador do ICMS. Utilizar códigos do IBGE
       * 3530607 = Mogi das Cruzes
       * ------------------------------------------------------------
       */
      'cMunFG_B12=3530607' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * tpImp_B21
       * Formato de Impressão do DANFE
       * 0 = Sem geração de DANFE
       * 1 = DANFE normal, Retrato
       * 2 = DANFE normal, Paisagem
       * 3 = DANFE Simplificado
       * ------------------------------------------------------------
       */
      'tpImp_B21=1' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * tpEmis_B22
       * Tipo de Emissão da NF-e
       * 1 = Emissão normal (não em contingência)
       * 2 = Contingência FS-IA, com impressão do DANFE em formulário de segurança
       * 3 = Contingência SCAN (Sistema de Contingência do Ambiente Nacional)
       * 4 = Contingência DPEC (Declaração Prévia da Emissão em Contingência)
       * 5 = Contingência FS-DA, com impressão do DANFE em formulário de segurança
       * 6 = Contingência SVC-AN (SEFAZ Virtual de Contingência do AN)
       * 7 = Contingência SVC-RS (SEFAZ Virtual de Contingência do RS)
       * ------------------------------------------------------------
       */
      'tpEmis_B22=1' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * cDV_B23
       * Dígito Verificador da Chave de Acesso da NF-e
       * Campo de preenchimento automático, não é necessário informar
       * ------------------------------------------------------------
       */
      'cDV_B23=' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * tpAmb_B24
       * dentificação do Ambiente
       * 1=Produção
       * 2=Homologação
       * ------------------------------------------------------------
       */
      'tpAmb_B24=2' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * finNFe_B25
       * Versão do Processo de emissão da NF-e
       * 1 = NF-e normal
       * 2 = NF-e complementar
       * 3 = NF-e de ajuste
       * 4 = Devolução de mercadoria
       * ------------------------------------------------------------
       */
      'finNFe_B25=' . $finNFe_B25 . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * indFinal_B25a
       * Indica operação com Consumidor final
       * 0 = Normal
       * 1 = Consumidor final
       * ------------------------------------------------------------
       */
      'indFinal_B25a=' . $indFinal_B25a . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * indPres_B25b
       * Indicador de presença do comprador no estabelecimento comercial no momento da operação
       * 0 = Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste)
       * 1 = Operação presencial
       * 2 = Operação não presencial, pela Internet
       * 3 = Operação não presencial, Teleatendimento
       * 4 = NFC-e em operação com entrega a domicílio
       * 5 = Operação presencial, fora do estabelecimento
       * 9 = Operação não presencial, outros
       * ------------------------------------------------------------
       */
      'indPres_B25b=0' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * procEmi_B26
       * Processo de emissão da NF-e
       * 0 = Emissão de NF-e com aplicativo do contribuinte
       * 1 = Emissão de NF-e avulsa pelo Fisco
       * 2 = Emissão de NF-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco
       * 3 = Emissão NF-e pelo contribuinte com aplicativo fornecido pelo Fisco
       * ------------------------------------------------------------
       */
      'procEmi_B26=0' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * verProc_B27
       * Versão do Processo de emissão da NF-e
       * Exemplo de preenchimento: SeuSoftware1.1.2
       * ------------------------------------------------------------
       */
      'verProc_B27=eniacMG1.0.0' . PHP_EOL;

    if (isset($invoice[0]->nfereference)) {
      $tx2 .=
        'IncluirParte=NREF' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * refNFe_BA02
         * Chave de acesso da NF-e referenciada
         * 	Referencia uma NF-e (modelo 55) emitida anteriormente, vinculada a NF-e atual, ou uma NFC-e (modelo 65)
         * ------------------------------------------------------------
         */
        'refNFe_BA02=' . $invoice[0]->nfereference . PHP_EOL .
        'SalvarParte=NREF' . PHP_EOL;
    }

    return $tx2;
  }

  private function getsendertx2($invoice, $subsidiary, $subsidiarybilladdress, $clientaddress)
  {

    /*
     * ------------------------------------------------------------
     * se o estado do cliente não é o mesmo do estado da subsidiaria
     * se a subsidiaria tiver IE no estado do cliente
     * ------------------------------------------------------------
     */
    $IEST_C18 = '';

    if ($clientaddress[0]->state != $subsidiarybilladdress[0]->state) {
      $iest = $this->db->select('id, subsidiaryid, subsidiary, state, ie')
        ->where('id', $subsidiary[0]->id)
        ->where('isinactive', 'F')
        ->where('confirmed', 'T')
        ->get('iest')
        ->result();
      if ($iest) {
        $IEST_C18 = preg_replace('/\D/', '', $iest[0]->ie);
      }
    }

    $tx2 =
      /*
       * ------------------------------------------------------------
       * CNPJ_C02
       * CNPJ do emitente
       * Se informar o CNPJ_C02, não informar CPF_C02a
       * ------------------------------------------------------------
       */
      'CNPJ_C02=' . preg_replace('/\D/', '', $subsidiary[0]->cnpj) . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * xNome_C03
       * Razão social ou nome do emitente
       * ------------------------------------------------------------
       */
      'xNome_C03=' . substr($subsidiary[0]->legalname, 0, 60) . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * xFant_C04
       * Nome fantasia
       * ------------------------------------------------------------
       */
      'xFant_C04=' . strtoupper(substr($subsidiary[0]->name, 0, 60)) . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * xLgr_C06
       * Logradouro
       * ------------------------------------------------------------
       */
      'xLgr_C06=' . $subsidiarybilladdress[0]->street . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * nro_C07
       * Número
       * ------------------------------------------------------------
       */
      'nro_C07=' . $subsidiarybilladdress[0]->number . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * xBairro_C09
       * Bairro
       * ------------------------------------------------------------
       */
      'xBairro_C09=' . $subsidiarybilladdress[0]->neighborhood . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * cMun_C10
       * Código do município
       * Utilizar códigos do IBGE
       * ------------------------------------------------------------
       */
      'cMun_C10=' . '3530607' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * xMun_C11
       * Nome do município
       * ------------------------------------------------------------
       */
      'xMun_C11=' . $subsidiarybilladdress[0]->city . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * UF_C12
       * Sigla da UF
       * ------------------------------------------------------------
       */
      'UF_C12=' . $subsidiarybilladdress[0]->state . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * CEP_C13
       * Código do CEP
       * Informar os zeros não significativos
       * ------------------------------------------------------------
       */
      'CEP_C13=' . str_pad(preg_replace('/\D/', '', $subsidiarybilladdress[0]->zip), 8, '0', STR_PAD_LEFT) . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * cPais_C14
       * Código do País
       * 1058 = Brasil
       * ------------------------------------------------------------
       */
      'cPais_C14=' . '1058' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * xPais_C15
       * Nome do País
       * "Brasil" ou "BRASIL"
       * ------------------------------------------------------------
       */
      'xPais_C15=' . 'BRASIL' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * fone_C16
       * Telefone
       * Preencher com o Código DDD + número do telefone.
       * Nas operações com exterior é permitido informar o código do país + código da localidade + número do telefone
       * ------------------------------------------------------------
       */
      'fone_C16=' . preg_replace('/\D/', '', $subsidiary[0]->phone) . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * IE_C17
       * Inscrição Estadual do Emitente
       * Informar somente os algarismos, sem os caracteres de formatação (ponto, barra, hífen, etc.).
       * Na emissão de NF-e Avulsa pode ser informado o literal “ISENTO” para os contribuintes do ICMS isentos de inscrição no Cadastro de Contribuintes de ICMS.
       * Em caso de nota conjugada, é necessário informar se o cliente tiver IE para ISS.
       * ------------------------------------------------------------
       */
      'IE_C17=' . preg_replace('/\D/', '', $subsidiary[0]->ie) . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * IEST_C18
       * IE do Substituto Tributário
       * IE do Substituto Tributário da UF de destino da mercadoria, quando houver a retenção do ICMS ST para a UF de destino
       * ------------------------------------------------------------
       */
      'IEST_C18=' . $IEST_C18 . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * CRT_C21
       * Código do Regime Tribtário
       * 1 = Simples Nacional
       * 2 = Simples Nacional, excesso sublimite de receita bruta
       * 3 = Regime Normal
       * 4 = MEI
       * ------------------------------------------------------------
       */
      'CRT_C21=' . $subsidiary[0]->taxregimecode . PHP_EOL;

    return $tx2;
  }

  private function getdestinationtx2($invoice, $client, $clientaddress)
  {

    // verifica o tipo de documento do destinatário
    $tx2 =
      /*
       * ------------------------------------------------------------
       * CNPJ_E02
       * CNPJ do destinatário
       * ------------------------------------------------------------
       */
      'CNPJ_E02=' . preg_replace('/\D/', '', $client[0]->document) . PHP_EOL;

    $xNome_E04 = substr($client[0]->legalname, 0, 60);

    if ($client[0]->persontype == 'Física') {
      /*
       * ------------------------------------------------------------
       * CPF_E03
       * CPF do destinatário
       * ------------------------------------------------------------
       */
      $tx2 = 'CPF_E03=' - preg_replace('/\D/', '', $client[0]->document) . PHP_EOL;

      $xNome_E04 = substr($client[0]->name, 0, 60);
    }

    // se estiver em ambiente de homologação
    if (in_array(ENVIRONMENT, array('development', 'dev', 'testing'))) {
      $xNome_E04 = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
    }

    // se o cliente for contribuinte do ICMS
    if ($client[0]->icmstaxpayer == 'T') {
      $indIEDest_E16a = 1;
    }

    // se o cliente for isento ou imune
    if ($client[0]->ieimmune == 'T' || $client[0]->ieexempt == 'T') {
      $indIEDest_E16a = 9;
    }

    $tx2 .=
      /*
       * ------------------------------------------------------------
       * idEstrangeiro_E03a
       * Identificação do destinatário no caso de comprador estrangeiro
       * ------------------------------------------------------------
       */
      'idEstrangeiro_E03a=' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * xNome_E04
       * Razão social ou nome do destinatário
       * ------------------------------------------------------------
       */
      'xNome_E04=' . $xNome_E04 . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * xLgr_E06
       * Logradouro
       * ------------------------------------------------------------
       */
      'xLgr_E06=' . $clientaddress[0]->street . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * nro_E07
       * Número
       * ------------------------------------------------------------
       */
      'nro_E07=' . $clientaddress[0]->number . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * xBairro_E09
       * Bairro
       * ------------------------------------------------------------
       */
      'xBairro_E09=' . $clientaddress[0]->neighborhood . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * cMun_E10
       * Código do município
       * Utilizar códigos do IBGE, informar ‘9999999’ para operações com o exterior
       * ------------------------------------------------------------
       */
      'cMun_E10=' . $clientaddress[0]->citycode . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * xMun_E11
       * Nome do município
       * Informar ‘EXTERIOR’ para operações com o exterior.
       * ------------------------------------------------------------
       */
      'xMun_E11=' . $clientaddress[0]->city . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * UF_E12
       * Sigla da UF
       * Informar ‘EX’ para operações com o exterior.
       * ------------------------------------------------------------
       */
      'UF_E12=' . $clientaddress[0]->state . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * CEP_E13
       * Código do CEP
       * Informar os zeros não significativos
       * ------------------------------------------------------------
       */
      'CEP_E13=' . str_pad(preg_replace('/\D/', '', $clientaddress[0]->zip), 8, '0', STR_PAD_LEFT) . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * cPais_E14
       * Código do País
       * Utilizar a Tabela do BACEN
       * ------------------------------------------------------------
       */
      'cPais_E14=' . $clientaddress[0]->countrycode . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * xPais_E15
       * Nome do País
       * ------------------------------------------------------------
       */
      'xPais_E15=' . $clientaddress[0]->country . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * indIEDest_E16a
       * Indicador da IE do Destinatário
       * 1 - Contribuinte ICMS (informar a IE do destinatário)
       * 2 - Contribuinte isento de Inscrição no cadastro de Contribuintes do ICMS
       * 9 - Não Contribuinte, que pode ou não possuir Inscrição Estadual no Cadastro de Contribuintes do ICMS
       * Nota 1:
       * No caso de NFC-e informar indIEDest=9 e não informar a tag IE do destinatário
       * Nota 2:
       * No caso de operação com o Exterior informar indIEDest=9 e não informar a tag IE do destinatário;
       * Nota 3:
       * No caso de Contribuinte Isento de Inscrição (indIEDest=2), não informar a tag IE do destinatário.
       * ------------------------------------------------------------
       */
      'indIEDest_E16a=' . $indIEDest_E16a . PHP_EOL;

    // se o cliente for contribuinte do ICMS ou imune
    if ($client[0]->icmstaxpayer == 'T' || $client[0]->ieimmune == 'T') {
      $tx2 .=
        /*
         * ------------------------------------------------------------
         * IE_E17
         * Inscrição Estadual do Destinatário
         * Campo opcional. Informar somente os algarismos, sem os caracteres de formatação (ponto, barra, hífen, etc.).
         * ------------------------------------------------------------
         */
        'IE_E17=' . preg_replace('/\D/', '', $client[0]->ie) . PHP_EOL;
    }

    return $tx2;
  }

  private function getitemstx2($invoice, $items, $subsidiary, $operationtype)
  {

    $tx2 = null;

    /*
     * ------------------------------------------------------------
     * se o regime tributario do emissor for igual a:
     * 1 - simples nacional
     * ------------------------------------------------------------
     */
    if ($subsidiary[0]->taxregimecode == 1) {

      $i = 1;
      $vBC_W03 = 0;
      $vICMS_W04 = 0;
      $vFCPUFDest_W04c = 0;
      $vICMSUFDest_W04e = 0;
      $vProd_W07 = 0;
      $vFrete_W08 = 0;
      $vDesc_W10 = 0;
      $vPIS_W13 = 0;
      $vCOFINS_W14 = 0;
      $vNF_W16 = 0;

      foreach ($items as $item) {

        $vProd_W07 += $item->itemgrossvalue;
        $vNF_W16 += $item->itemgrossvalue;

        /*
         * ------------------------------------------------------------
         * Se o item for químico
         * ------------------------------------------------------------
         */
        if ($item->ischemical == 'T') {
          $subsidiaryrisk = !!$item->subsidiaryrisk ? '(R/S ' . $item->subsidiaryrisk . ')' : '';
          $item->additionalinformation = mb_strtoupper('ONU ' . $item->onucode . ', ' . $item->onudescription . ' (QUANTIDADE LIMITADA)|C/R ' . $item->riskclass . ', ' . $subsidiaryrisk . 'GE ' . $item->packinggroup . '| COD MERCOSUL ' . $item->ncm . ' ' . $item->concentration . ' - % CONC ' . $item->density . ' - DENS|' . implode('|', preg_split('/\r\n|\r|\n/', $item->additionalinformation)), 'UTF-8');
        }

        $itemcod = !empty($item->tranid) ? $item->tranid : $item->externalid;

        $tx2 .= 'INCLUIRITEM' . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * nItem_H02
           * Número do Item
           * Número Sequêncial
           * ------------------------------------------------------------
           */
          'nItem_H02=' . $i . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * cProd_I02
           * Código do produto ou serviço
           * Preencher com CFOP, caso se trate de itens não relacionados com mercadorias/produtos e que o contribuinte não possua codificação própria. Formato: ”CFOP9999”
           * ------------------------------------------------------------
           */
          'cProd_I02=' . $itemcod . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * cEAN_I03
           * GTIN (Global Trade Item Number) do produto, antigo código EAN ou código de barras
           * Preencher com o código
           * GTIN-8
           * GTIN-12
           * GTIN-13
           * GTIN-14 (antigos códigos EAN, UPC e DUN-14)
           * informar o conteúdo da TAG com valor
           * SEM GTIN em caso de o produto não possuir este código
           * ------------------------------------------------------------
           */
          'cEAN_I03=SEM GTIN' . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * xProd_I04
           * Descrição do produto ou serviço
           * ------------------------------------------------------------
           */
          'xProd_I04=' . substr($item->itemname, 0, 60) . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * NCM_I05
           * Código NCM com 8 digitos
           * Obrigatória informação do NCM completo (8 dígitos)
           * Nota: Em caso de item de serviço ou item que não tenham produto (ex. transferência de crédito, crédito do ativo imobilizado, etc.), informar o valor 00 (dois zeros)
           * ------------------------------------------------------------
           */
          'NCM_I05=' . preg_replace('/\D/', '', $item->ncm) . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * CEST_I05c
           * Código Especificador da Substituição Tributária – CEST,
           * que estabelece a sistemática de uniformização e identificação das mercadorias e bens passíveis de sujeição aos regimes de substituição tributária e de antecipação de recolhimento do ICMS
           * ------------------------------------------------------------
           */
          'CEST_I05c=' . $item->cest . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * CFOP_I08
           * Código Fiscal de Operações e Prestações
           * Utilizar tabela CFOP (Dado fornecido pelo contador do cliente)
           * ------------------------------------------------------------
           */
          'CFOP_I08=' . preg_replace('/\D/', '', $item->cfop) . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * uCom_I09
           * Unidade Comercial
           * Informar a unidade de comercialização do produto
           * ------------------------------------------------------------
           */
          'uCom_I09=' . $item->saleunitname . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * qCom_I10
           * Quantidade Comercial
           * Informar a quantidade de comercialização do produto
           * ------------------------------------------------------------
           */
          'qCom_I10=' . $item->itemquantity . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * vUnCom_I10a
           * Valor Unitário de Comercialização
           * Informar o valor unitário de comercialização do produto, campo meramente informativo, o contribuinte pode utilizar a precisão desejada (0-10 decimais).
           * Para efeitos de cálculo, o valor unitário será obtido pela divisão do valor do produto pela quantidade comercial.
           * ------------------------------------------------------------
           */
          'vUnCom_I10a=' . number_format($item->itemprice, 2, '.', '') . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * vProd_I11
           * Valor Unitário de Comercialização
           * Informar o valor unitário de comercialização do produto, campo meramente informativo, o contribuinte pode utilizar a precisão desejada (0-10 decimais).
           * Para efeitos de cálculo, o valor unitário será obtido pela divisão do valor do produto pela quantidade comercial.
           * ------------------------------------------------------------
           */
          'vProd_I11=' . number_format($item->itemgrossvalue, 2, '.', '') . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * cEANTrib_I12
           * GTIN (Global Trade Item Number) da unidade tributável, antigo código EAN ou código de barras
           * Preencher com o código
           * GTIN-8
           * GTIN-12
           * GTIN-13
           * GTIN-14 (antigos códigos EAN, UPC e DUN-14)
           * da unidade tributável do produto, não informar o conteúdo da TAG em caso de o produto não possuir este código.
           * ------------------------------------------------------------
           */
          'cEANTrib_I12=SEM GTIN' . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * uTrib_I13
           * Unidade Tributável
           * ------------------------------------------------------------
           */
          'uTrib_I13=' . $item->saleunitname . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * qTrib_I14
           * Quantidade Tributável
           * ------------------------------------------------------------
           */
          'qTrib_I14=' . $item->itemquantity . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * vUnTrib_I14a
           * Valor Unitário de tributação
           * Informar o valor unitário de tributação do produto, campo meramente informativo, o contribuinte pode utilizar a precisão desejada (0-10 decimais).
           * Para efeitos de cálculo, o valor unitário será obtido pela divisão do valor do produto pela quantidade tributável
           * ------------------------------------------------------------
           */
          'vUnTrib_I14a=' . $item->itemprice . PHP_EOL;

        // se o item tiver frete
        if ($item->itemfreight > 0) {

          $vFrete_W08 += number_format($item->itemfreight, 2, '.', '');
          $vNF_W16 += number_format($item->itemfreight, 2, '.', '');

          /*
           * ------------------------------------------------------------
           * vFrete_I15
           * Valor Total do Frete
           * ------------------------------------------------------------
           */
          $tx2 .= 'vFrete_I15=' . number_format($item->itemfreight, 2, '.', '') . PHP_EOL;
        }

        // se o item tiver desconto
        if ($item->itemdiscount > 0) {

          $vDesc_W10 += number_format($item->itemdiscount, 2, '.', '');
          $vNF_W16 -= number_format($item->itemdiscount, 2, '.', '');

          /*
           * ------------------------------------------------------------
           * vDesc_I17
           * Valor Total do Desconto
           * ------------------------------------------------------------
           */
          $tx2 .= 'vDesc_I17=' . number_format($item->itemdiscount, 2, '.', '') . PHP_EOL;
        }

        $tx2 .=
          /*
           * ------------------------------------------------------------
           * indTot_I17b
           * Indica se valor do Item (vProd) entra no valor total da NF-e (vProd)
           * 0 = Valor do item (vProd) não compõe o valor total da NF-e
           * 1 = Valor do item (vProd) compõe o valor total da NF-e
           * ------------------------------------------------------------
           */
          'indTot_I17b=1' . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * xPed_I60
           * Número do Pedido de Compra
           * ------------------------------------------------------------
           */
          'xPed_I60=' . $invoice[0]->customerpurchaseorder . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * nItemPed_I61
           * Item do Pedido de Compra
           * ------------------------------------------------------------
           */
          'nItemPed_I61=' . $item->itemline . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * infAdProd_V01
           * Item do Pedido de Compra
           * ------------------------------------------------------------
           */
          'infAdProd_V01=' . $item->additionalinformation . PHP_EOL;

        // se o item tiver icms
        if (isset($item->taxes->icms)) {

          $vBC_W03 += $item->taxes->icms->calculationbase;
          $vICMS_W04 += $item->taxes->icms->taxvalue;

          /*
           * ------------------------------------------------------------
           * se o CST for
           * 101 = Tributada pelo Simples Nacional com permissão de crédito
           * ------------------------------------------------------------
           */
          if (in_array($item->taxes->icms->cst, array('101'))) {
            $tx2 .=
              /*
               * ------------------------------------------------------------
               * orig_N11
               * Origem da mercadoria
               * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
               * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;
               * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
               * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%;
               * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de quetratam as legislações citadas nos Ajustes;
               * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
               * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;
               * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CAMEX e gás natural.
               * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%;
               * ------------------------------------------------------------
               */
              'orig_N11=' . $item->itemorigincode . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * CSOSN_N12a
               * Código de Situação da Operação – Simples Nacional
               * 101 = Tributada pelo Simples Nacional com permissão de crédito
               * ------------------------------------------------------------
               */
              'CSOSN_N12a=' . $item->taxes->icms->cst . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pCredSN_N29
               * Alíquota aplicável de cálculo do crédito (Simples Nacional)
               * ------------------------------------------------------------
               */
              'pCredSN_N29=' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vCredICMSSN_N30
               * Valor crédito do ICMS que pode ser aproveitado nos termos do art. 23 da LC 123 (Simples Nacional)
               * ------------------------------------------------------------
               */
              'vCredICMSSN_N30=' . PHP_EOL;
          }



          /*
           * ------------------------------------------------------------
           * se o CST for
           * 102 = Tributada pelo Simples Nacional sem permissão de crédito
           * 103 = Isenção do ICMS no Simples Nacional para faixa de receita bruta
           * 300 = Imune
           * 400 = Não tributada pelo Simples Nacional
           * ------------------------------------------------------------
           */
          if (in_array($item->taxes->icms->cst, array('102', '103', '300', '400'))) {

            $vBC_W03 = 0;

            $tx2 .=
              /*
               * ------------------------------------------------------------
               * orig_N11
               * Origem da mercadoria
               * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
               * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;
               * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
               * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%;
               * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de quetratam as legislações citadas nos Ajustes;
               * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
               * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;
               * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CAMEX e gás natural.
               * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%;
               * ------------------------------------------------------------
               */
              'orig_N11=' . $item->itemorigincode . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * CSOSN_N12a
               * Código de Situação da Operação – Simples Nacional
               * 102 = Tributada pelo Simples Nacional sem permissão de crédito
               * 103 = Isenção do ICMS no Simples Nacional para faixa de receita bruta
               * 300 = Imune
               * 400 = Não tributada pelo Simples Nacional
               * ------------------------------------------------------------
               */
              'CSOSN_N12a=' . $item->taxes->icms->cst . PHP_EOL;
          }

          /*
           * ------------------------------------------------------------
           * se o CST for
           * 201 = Tributada pelo Simples Nacional com permissão de crédito e com cobrança do ICMS por Substituição Tributária
           * ------------------------------------------------------------
           */
          if (in_array($item->taxes->icms->cst, array('201'))) {

            $tx2 .=
              /*
               * ------------------------------------------------------------
               * orig_N11
               * Origem da mercadoria
               * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
               * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;
               * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
               * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%;
               * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de quetratam as legislações citadas nos Ajustes;
               * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
               * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;
               * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CAMEX e gás natural.
               * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%;
               * ------------------------------------------------------------
               */
              'orig_N11=' . $item->itemorigincode . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * CSOSN_N12a
               * Código de Situação da Operação – Simples Nacional
               * 201 = Tributada pelo Simples Nacional com permissão de crédito e com cobrança do ICMS por Substituição Tributária
               * ------------------------------------------------------------
               */
              'CSOSN_N12a=' . $item->taxes->icms->cst . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * modBCST_N18
               * Modalidade de determinação da BC do ICMS ST
               * 0 = Preço tabelado ou máximo sugerido
               * 1 = Lista Negativa (valor)
               * 2 = Lista Positiva (valor)
               * 3 = Lista Neutra (valor)
               * 4 = Margem Valor Agregado (%)
               * 5 = Pauta (valor)
               * 6 = Valor da Operação
               * ------------------------------------------------------------
               */
              'modBCST_N18=' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pMVAST_N19
               * Percentual da margem de valor Adicionado do ICMS ST
               * ------------------------------------------------------------
               */
              'pMVAST_N19=' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pRedBCST_N20
               * Percentual da Redução de BC do ICMS ST
               * ------------------------------------------------------------
               */
              'pRedBCST_N20=' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vBCST_N21
               * Valor da BC do ICMS ST
               * ------------------------------------------------------------
               */
              'vBCST_N21=' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pICMSST_N22
               * Alíquota do imposto do ICMS ST
               * Alíquota do ICMS ST sem o FCP. Quando for o caso, informar a alíquota do FCP no campo pFCP
               * ------------------------------------------------------------
               */
              'pICMSST_N22=' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vICMSST_N23
               * Valor do ICMS ST
               * Valor do ICMS ST retido
               * ------------------------------------------------------------
               */
              'vICMSST_N23=' . PHP_EOL;
          }

          /*
           * ------------------------------------------------------------
           * se o CST for
           * 202 = Tributada pelo Simples Nacional sem permissão de crédito e com cobrança do ICMS por Substituição Tributária
           * 203 = Isenção do ICMS nos Simples Nacional para faixa de receita bruta e com cobrança do ICMS por Substituição Tributária
           * ------------------------------------------------------------
           */
          if (in_array($item->taxes->icms->cst, array('202', '203'))) {

            $tx2 .=
              /*
               * ------------------------------------------------------------
               * orig_N11
               * Origem da mercadoria
               * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
               * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;
               * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
               * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%;
               * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de quetratam as legislações citadas nos Ajustes;
               * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
               * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;
               * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CAMEX e gás natural.
               * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%;
               * ------------------------------------------------------------
               */
              'orig_N11=' . $item->itemorigincode . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * CSOSN_N12a
               * Código de Situação da Operação – Simples Nacional
               * 202 = Tributada pelo Simples Nacional sem permissão de crédito e com cobrança do ICMS por Substituição Tributária
               * 203 = Isenção do ICMS nos Simples Nacional para faixa de receita bruta e com cobrança do ICMS por Substituição Tributária
               * ------------------------------------------------------------
               */
              'CSOSN_N12a=' . $item->taxes->icms->cst . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * modBCST_N18
               * Modalidade de determinação da BC do ICMS ST
               * 0 = Preço tabelado ou máximo sugerido
               * 1 = Lista Negativa (valor)
               * 2 = Lista Positiva (valor)
               * 3 = Lista Neutra (valor)
               * 4 = Margem Valor Agregado (%)
               * 5 = Pauta (valor)
               * 6 = Valor da Operação
               * ------------------------------------------------------------
               */
              'modBCST_N18=' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pMVAST_N19
               * Percentual da margem de valor Adicionado do ICMS ST
               * ------------------------------------------------------------
               */
              'pMVAST_N19=' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pRedBCST_N20
               * Percentual da Redução de BC do ICMS ST
               * ------------------------------------------------------------
               */
              'pRedBCST_N20=' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vBCST_N21
               * Valor da BC do ICMS ST
               * ------------------------------------------------------------
               */
              'vBCST_N21=' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pICMSST_N22
               * Alíquota do imposto do ICMS ST
               * Alíquota do ICMS ST sem o FCP. Quando for o caso, informar a alíquota do FCP no campo pFCP
               * ------------------------------------------------------------
               */
              'pICMSST_N22=' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vICMSST_N23
               * Valor do ICMS ST
               * Valor do ICMS ST retido
               * ------------------------------------------------------------
               */
              'vICMSST_N23=' . PHP_EOL;
          }

          /*
           * ------------------------------------------------------------
           * se o CST for
           * 500 = ICMS cobrado anteriormente por substituição tributária (substituído) ou por antecipação.
           * ------------------------------------------------------------
           */
          if (in_array($item->taxes->icms->cst, array('500'))) {

            $tx2 .=
              /*
               * ------------------------------------------------------------
               * orig_N11
               * Origem da mercadoria
               * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
               * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;
               * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
               * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%;
               * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de quetratam as legislações citadas nos Ajustes;
               * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
               * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;
               * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CAMEX e gás natural.
               * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%;
               * ------------------------------------------------------------
               */
              'orig_N11=' . $item->itemorigincode . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * CSOSN_N12a
               * Código de Situação da Operação – Simples Nacional
               * 500 = ICMS cobrado anteriormente por substituição tributária (substituído) ou por antecipação.
               * ------------------------------------------------------------
               */
              'CSOSN_N12a=' . $item->taxes->icms->cst . PHP_EOL;
          }

          /*
           * ------------------------------------------------------------
           * se o CST for
           * 900 = Outros
           * ------------------------------------------------------------
           */
          if (in_array($item->taxes->icms->cst, array('900'))) {

            $vBC_W03 = 0;

            $tx2 .=
              /*
               * ------------------------------------------------------------
               * orig_N11
               * Origem da mercadoria
               * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
               * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;
               * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
               * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%;
               * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de quetratam as legislações citadas nos Ajustes;
               * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
               * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;
               * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CAMEX e gás natural.
               * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%;
               * ------------------------------------------------------------
               */
              'orig_N11=' . $item->itemorigincode . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * CSOSN_N12a
               * Código de Situação da Operação – Simples Nacional
               * 900 = Outros
               * ------------------------------------------------------------
               */
              'CSOSN_N12a=' . $item->taxes->icms->cst . PHP_EOL;
          }

        }

        // se o item tiver difal
        if (isset($item->taxes->icmsdestination) && isset($item->taxes->icmssender)) {

          if (isset($item->taxes->fcp)) {
            $vFCPUFDest_W04c += $item->taxes->fcp->taxvalue;
          } else {
            $vFCPUFDest_W04c += 0;
            $item->taxes->fcp = new stdClass();
            $item->taxes->fcp->calculationbase = 0;
            $item->taxes->fcp->aliquot = 0;
            $item->taxes->fcp->taxvalue = 0;
          }

          $vICMSUFDest_W04e += $item->taxes->icmsdestination->taxvalue;

          $tx2 .=
            /*
             * ------------------------------------------------------------
             * vBCUFDest_NA03
             * Valor da BC do ICMS na UF de destino
             * Valor da Base de Cálculo do ICMS na UF de destino.
             * ------------------------------------------------------------
             */
            'vBCUFDest_NA03=' . number_format($item->taxes->icmsdestination->calculationbase, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vBCFCPUFDest_NA04
             * Valor da BC do FCP na UF de destino
             * ------------------------------------------------------------
             */
            'vBCFCPUFDest_NA04=' . number_format($item->taxes->fcp->calculationbase, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * pFCPUFDest_NA05
             * Percentual do ICMS relativo ao Fundo de Combate à Pobreza (FCP) na UF de destino
             * ------------------------------------------------------------
             */
            'pFCPUFDest_NA05=' . number_format($item->taxes->fcp->aliquot * 100, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * pICMSUFDest_NA07
             * Alíquota interna da UF de destino
             * Alíquota adotada nas operações internas na UF de destino para o produto / mercadoria.
             * A alíquota do Fundo de Combate à Pobreza, se existente para o produto / mercadoria, deve ser informada no campo próprio (pFCPUFDest) não devendo ser somada a essa alíquota interna
             * ------------------------------------------------------------
             */
            'pICMSUFDest_NA07=' . number_format($item->taxes->icmsdestination->aliquotdestination * 100, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * pICMSInter_NA09
             * Alíquota interestadual das UF envolvidas
             * 4% alíquota interestadual para produtos importados
             * 7% para os Estados de origem do Sul e Sudeste (exceto ES), destinado para os Estados do Norte, Nordeste, Centro-Oeste e Espírito Santo
             * 12% para os demais casos
             * ------------------------------------------------------------
             */
            'pICMSInter_NA09=' . number_format($item->taxes->icmssender->aliquot * 100, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * pICMSInterPart_NA11
             * Percentual provisório de partilha do ICMS Interestadual
             * Percentual de ICMS Interestadual para a UF de destino:
             * 100% a partir de 2019
             * ------------------------------------------------------------
             */
            'pICMSInterPart_NA11=100.00' . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vFCPUFDest_NA13
             * Valor do ICMS relativo ao Fundo de Combate à Pobreza (FCP) da UF de destino
             * ------------------------------------------------------------
             */
            'vFCPUFDest_NA13=' . number_format($item->taxes->fcp->taxvalue, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vICMSUFDest_NA15
             * Valor do ICMS Interestadual para a UF de destino (sem o valor do ICMS relativo ao FCP).
             * ------------------------------------------------------------
             */
            'vICMSUFDest_NA15=' . number_format($item->taxes->icmsdestination->taxvalue, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vICMSUFRemet_NA17
             * Valor do ICMS Interestadual para a UF do remetente
             * Nota: A partir de 2019, este valor será zero.
             * ------------------------------------------------------------
             */
            'vICMSUFRemet_NA17=0.00' . PHP_EOL;
        }

        // se o item tiver pis
        if (isset($item->taxes->pis)) {

          $vPIS_W13 += $item->taxes->pis->taxvalue;

          $tx2 .=
            /*
             * ------------------------------------------------------------
             * CST_Q06
             * Código de Situação Tributária do PIS
             * 01 = Operação Tributável (base de cálculo = valor da operação alíquota normal (cumulativo/não cumulativo))
             * 02 = Operação Tributável (base de cálculo = valor da operação (alíquota diferenciada))
             * 03 = Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
             * 04 = Operação Tributável (tributação monofásica (alíquota zero))
             * 05 = Operação Tributável (Substituição Tributária)
             * 06 = Operação Tributável (alíquota zero)
             * 07 = Operação Isenta da Contribuição
             * 08 = Operação Sem Incidência da Contribuição
             * 09 = Operação com Suspensão da Contribuição
             * 49 = Outras Operações de Saída
             * 50 = Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno
             * 51 = Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno
             * 52 = Operação com Direito a Crédito – Vinculada Exclusivamente a Receita de Exportação
             * 53 = Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno
             * 54 = Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação
             * 55 = Operação com Direito a Crédito - Vinculada a Receitas NãoTributadas no Mercado Interno e de Exportação
             * 56 = Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação
             * 60 = Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno
             * 61 = Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno
             * 62 = Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação
             * 63 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno
             * 64 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação
             * 65 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação
             * 66 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação
             * 67 = Crédito Presumido - Outras Operações
             * 70 = Operação de Aquisição sem Direito a Crédito
             * 71 = Operação de Aquisição com Isenção
             * 72 = Operação de Aquisição com Suspensão
             * 73 = Operação de Aquisição a Alíquota Zero
             * 74 = Operação de Aquisição sem Incidência da Contribuição
             * 75 = Operação de Aquisição por Substituição Tributária
             * 98 = Outras Operações de Entrada
             * 99 = Outras Operações
             * ------------------------------------------------------------
             */
            'CST_Q06=' . $item->taxes->pis->cst . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vBC_Q07
             * Valor da Base de Cálculo do PIS
             * ------------------------------------------------------------
             */
            'vBC_Q07=' . number_format($item->taxes->pis->calculationbase, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * pPIS_Q08
             * Alíquota do PIS (em percentual)
             * ------------------------------------------------------------
             */
            'pPIS_Q08=' . number_format($item->taxes->pis->aliquot * 100, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vPIS_Q09
             * Valor do PIS
             * ------------------------------------------------------------
             */
            'vPIS_Q09=' . number_format($item->taxes->pis->taxvalue, 2, '.', '') . PHP_EOL;
        }

        // se o item tiver cofins
        if (isset($item->taxes->cofins)) {

          $vCOFINS_W14 += $item->taxes->cofins->taxvalue;

          $tx2 .=
            /*
             * ------------------------------------------------------------
             * CST_S06
             * Código de Situação Tributária do COFINS
             * 01 = Operação Tributável (base de cálculo = valor da operação alíquota normal (cumulativo/não cumulativo))
             * 02 = Operação Tributável (base de cálculo = valor da operação (alíquota diferenciada))
             * 03 = Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
             * 04 = Operação Tributável (tributação monofásica, alíquota zero)
             * 05 = Operação Tributável (Substituição Tributária)
             * 06 = Operação Tributável (alíquota zero)
             * 07 = Operação Isenta da Contribuição
             * 08 = Operação Sem Incidência da Contribuição
             * 09 = Operação com Suspensão da Contribuição
             * 49 = Outras Operações de Saída
             * 50 = Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno
             * 51 = Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno
             * 52 = Operação com Direito a Crédito – Vinculada Exclusivamente a Receita de Exportação
             * 53 = Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno
             * 54 = Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação
             * 55 = Operação com Direito a Crédito - Vinculada a Receitas NãoTributadas no Mercado Interno e de Exportação
             * 56 = Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação
             * 60 = Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno
             * 61 = Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno
             * 62 = Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação
             * 63 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno
             * 64 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação
             * 65 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação
             * 66 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação
             * 67 = Crédito Presumido - Outras Operações
             * 70 = Operação de Aquisição sem Direito a Crédito
             * 71 = Operação de Aquisição com Isenção
             * 72 = Operação de Aquisição com Suspensão
             * 73 = Operação de Aquisição a Alíquota Zero
             * 74 = Operação de Aquisição sem Incidência da Contribuição
             * 75 = Operação de Aquisição por Substituição Tributária
             * 98 = Outras Operações de Entrada
             * 99 = Outras Operações
             * ------------------------------------------------------------
             */
            'CST_S06=' . $item->taxes->cofins->cst . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vBC_S07
             * Valor da Base de Cálculo do COFINS
             * ------------------------------------------------------------
             */
            'vBC_S07=' . number_format($item->taxes->cofins->calculationbase, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * pCOFINS_S08
             * Alíquota do COFINS (em percentual)
             * ------------------------------------------------------------
             */
            'pCOFINS_S08=' . number_format($item->taxes->cofins->aliquot * 100, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vCOFINS_S11
             * Valor do COFINS
             * ------------------------------------------------------------
             */
            'vCOFINS_S11=' . number_format($item->taxes->cofins->taxvalue, 2, '.', '') . PHP_EOL;
        }

        $tx2 .= 'SALVARITEM' . PHP_EOL;

        $i++;

      }

      $tx2 .=
        /*
         * ------------------------------------------------------------
         * vBC_W03
         * Base de Cálculo do ICMS
         * ------------------------------------------------------------
         */
        'vBC_W03=' . number_format($vBC_W03, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vICMS_W04
         * Valor Total do ICMS
         * ------------------------------------------------------------
         */
        'vICMS_W04=' . number_format($vICMS_W04, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vICMSDeson_W04a
         * Valor Total do ICMS desonerado
         * ------------------------------------------------------------
         */
        'vICMSDeson_W04a=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vFCPUFDest_W04c
         * Valor total do ICMS relativo Fundo de Combate à Pobreza (FCP) da UF de destino
         * ------------------------------------------------------------
         */
        'vFCPUFDest_W04c=' . number_format($vFCPUFDest_W04c, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vICMSUFDest_W04e
         * Valor total do ICMS Interestadual para a UF de destino, sem o valor do ICMS relativo ao FCP
         * ------------------------------------------------------------
         */
        'vICMSUFDest_W04e=' . number_format($vICMSUFDest_W04e, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vICMSUFRemet_W04g
         * Valor total do ICMS Interestadual para a UF do remetente
         * Nota: A partir de 2019, este valor será zero
         * ------------------------------------------------------------
         */
        'vICMSUFRemet_W04g=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vFCP_W04h
         * Valor Total do FCP (Fundo de Combate à Pobreza)
         * Corresponde ao total da soma dos campos id: N17c
         * ------------------------------------------------------------
         */
        'vFCP_W04h=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vBCST_W05
         * Base de Cálculo do ICMS ST
         * ------------------------------------------------------------
         */
        'vBCST_W05=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vST_W06
         * Valor Total do ICMS ST
         * ------------------------------------------------------------
         */
        'vST_W06=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vFCPST_W06a
         * Valor Total do FCP (Fundo de Combate à Pobreza) retido por substituição tributária
         * Corresponde ao total da soma dos campos id: N23d
         * ------------------------------------------------------------
         */
        'vFCPST_W06a=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vFCPSTRet_W06b
         * Valor Total do FCP retido anteriormente por Substituição Tributária
         * Corresponde ao total da soma dos campos id: N27d
         * ------------------------------------------------------------
         */
        'vFCPSTRet_W06b=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vProd_W07
         * Valor Total dos produtos e serviços
         * ------------------------------------------------------------
         */
        'vProd_W07=' . number_format($vProd_W07, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vFrete_W08
         * Valor Total do Frete
         * ------------------------------------------------------------
         */
        'vFrete_W08=' . number_format($vFrete_W08, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vSeg_W09
         * Valor Total do Frete
         * ------------------------------------------------------------
         */
        'vSeg_W09=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vDesc_W10
         * Valor Total do Desconto
         * ------------------------------------------------------------
         */
        'vDesc_W10=' . number_format($vDesc_W10, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vII_W11
         * Valor Total do II
         * ------------------------------------------------------------
         */
        'vII_W11=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vIPI_W12
         * Valor Total do IPI
         * ------------------------------------------------------------
         */
        'vIPI_W12=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vIPIDevol_W12a
         * Valor Total do IPI Devolvido
         * Deve ser informado quando preenchido o Grupo Tributos Devolvidos na emissão de nota finNFe=4 (devolução) nas operações com não contribuintes do IPI.
         * Corresponde ao total da soma dos campos id: UA04.
         * ------------------------------------------------------------
         */
        'vIPIDevol_W12a=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vPIS_W13
         * Valor Total do PIS
         * ------------------------------------------------------------
         */
        'vPIS_W13=' . number_format($vPIS_W13, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vCOFINS_W14
         * Valor Total do COFINS
         * ------------------------------------------------------------
         */
        'vCOFINS_W14=' . number_format($vCOFINS_W14, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vOutro_W15
         * Valor total de Outras despesas
         * ------------------------------------------------------------
         */
        'vOutro_W15=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vNF_W16
         * Valor Total da NF-e
         * ------------------------------------------------------------
         */
        'vNF_W16=' . number_format($vNF_W16, 2, '.', '') . PHP_EOL;

    }

    /*
     * ------------------------------------------------------------
     * se o regime tributario do emissor for igual a:
     * 2 - simples nacional, excesso sublimite de receita
     * 3 - regime normal
     * ------------------------------------------------------------
     */
    if ($subsidiary[0]->taxregimecode == 2 || $subsidiary[0]->taxregimecode == 3) {

      $i = 1;
      $vBC_W03 = 0;
      $vICMS_W04 = 0;
      $vFCPUFDest_W04c = 0;
      $vICMSUFDest_W04e = 0;
      $vProd_W07 = 0;
      $vFrete_W08 = 0;
      $vDesc_W10 = 0;
      $vPIS_W13 = 0;
      $vCOFINS_W14 = 0;
      $vNF_W16 = 0;

      foreach ($items as $item) {

        $vProd_W07 += $item->itemgrossvalue;
        $vNF_W16 += $item->itemgrossvalue;

        /*
         * ------------------------------------------------------------
         * Se o item for químico e controlado pela polícia federal
         * ------------------------------------------------------------
         */
        if ($item->ischemical == 'T') {
          $subsidiaryrisk = !!$item->subsidiaryrisk ? '(R/S ' . $item->subsidiaryrisk . ')' : '';
          $item->additionalinformation = mb_strtoupper('ONU ' . $item->onucode . ', ' . $item->onudescription . ' (QUANTIDADE LIMITADA)|C/R ' . $item->riskclass . ', ' . $subsidiaryrisk . 'GE ' . $item->packinggroup . '| COD MERCOSUL ' . $item->ncm . ' ' . $item->concentration . ' - % CONC ' . $item->density . ' - DENS|' . implode('|', preg_split('/\r\n|\r|\n/', $item->additionalinformation)), 'UTF-8');
        }

        $itemcod = !empty($item->tranid) ? $item->tranid : $item->externalid;

        $tx2 .= 'INCLUIRITEM' . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * nItem_H02
           * Número do Item
           * Número Sequêncial
           * ------------------------------------------------------------
           */
          'nItem_H02=' . $i . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * cProd_I02
           * Código do produto ou serviço
           * Preencher com CFOP, caso se trate de itens não relacionados com mercadorias/produtos e que o contribuinte não possua codificação própria. Formato: ”CFOP9999”
           * ------------------------------------------------------------
           */
          'cProd_I02=' . $itemcod . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * cEAN_I03
           * GTIN (Global Trade Item Number) do produto, antigo código EAN ou código de barras
           * Preencher com o código
           * GTIN-8
           * GTIN-12
           * GTIN-13
           * GTIN-14 (antigos códigos EAN, UPC e DUN-14)
           * informar o conteúdo da TAG com valor
           * SEM GTIN em caso de o produto não possuir este código
           * ------------------------------------------------------------
           */
          'cEAN_I03=SEM GTIN' . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * xProd_I04
           * Descrição do produto ou serviço
           * ------------------------------------------------------------
           */
          'xProd_I04=' . substr($item->itemname, 0, 60) . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * NCM_I05
           * Código NCM com 8 digitos
           * Obrigatória informação do NCM completo (8 dígitos)
           * Nota: Em caso de item de serviço ou item que não tenham produto (ex. transferência de crédito, crédito do ativo imobilizado, etc.), informar o valor 00 (dois zeros)
           * ------------------------------------------------------------
           */
          'NCM_I05=' . preg_replace('/\D/', '', $item->ncm) . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * CEST_I05c
           * Código Especificador da Substituição Tributária – CEST,
           * que estabelece a sistemática de uniformização e identificação das mercadorias e bens passíveis de sujeição aos regimes de substituição tributária e de antecipação de recolhimento do ICMS
           * ------------------------------------------------------------
           */
          'CEST_I05c=' . $item->cest . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * CFOP_I08
           * Código Fiscal de Operações e Prestações
           * Utilizar tabela CFOP (Dado fornecido pelo contador do cliente)
           * ------------------------------------------------------------
           */
          'CFOP_I08=' . preg_replace('/\D/', '', $item->cfop) . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * uCom_I09
           * Unidade Comercial
           * Informar a unidade de comercialização do produto
           * ------------------------------------------------------------
           */
          'uCom_I09=' . $item->saleunitname . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * qCom_I10
           * Quantidade Comercial
           * Informar a quantidade de comercialização do produto
           * ------------------------------------------------------------
           */
          'qCom_I10=' . $item->itemquantity . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * vUnCom_I10a
           * Valor Unitário de Comercialização
           * Informar o valor unitário de comercialização do produto, campo meramente informativo, o contribuinte pode utilizar a precisão desejada (0-10 decimais).
           * Para efeitos de cálculo, o valor unitário será obtido pela divisão do valor do produto pela quantidade comercial.
           * ------------------------------------------------------------
           */
          'vUnCom_I10a=' . number_format($item->itemprice, 2, '.', '') . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * vProd_I11
           * Valor Unitário de Comercialização
           * Informar o valor unitário de comercialização do produto, campo meramente informativo, o contribuinte pode utilizar a precisão desejada (0-10 decimais).
           * Para efeitos de cálculo, o valor unitário será obtido pela divisão do valor do produto pela quantidade comercial.
           * ------------------------------------------------------------
           */
          'vProd_I11=' . number_format($item->itemgrossvalue, 2, '.', '') . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * cEANTrib_I12
           * GTIN (Global Trade Item Number) da unidade tributável, antigo código EAN ou código de barras
           * Preencher com o código
           * GTIN-8
           * GTIN-12
           * GTIN-13
           * GTIN-14 (antigos códigos EAN, UPC e DUN-14)
           * da unidade tributável do produto, não informar o conteúdo da TAG em caso de o produto não possuir este código.
           * ------------------------------------------------------------
           */
          'cEANTrib_I12=SEM GTIN' . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * uTrib_I13
           * Unidade Tributável
           * ------------------------------------------------------------
           */
          'uTrib_I13=' . $item->saleunitname . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * qTrib_I14
           * Quantidade Tributável
           * ------------------------------------------------------------
           */
          'qTrib_I14=' . $item->itemquantity . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * vUnTrib_I14a
           * Valor Unitário de tributação
           * Informar o valor unitário de tributação do produto, campo meramente informativo, o contribuinte pode utilizar a precisão desejada (0-10 decimais).
           * Para efeitos de cálculo, o valor unitário será obtido pela divisão do valor do produto pela quantidade tributável
           * ------------------------------------------------------------
           */
          'vUnTrib_I14a=' . $item->itemprice . PHP_EOL;

        // se o item tiver frete
        if ($item->itemfreight > 0) {

          $vFrete_W08 += number_format($item->itemfreight, 2, '.', '');
          $vNF_W16 += number_format($item->itemfreight, 2, '.', '');

          /*
           * ------------------------------------------------------------
           * vFrete_I15
           * Valor Total do Frete
           * ------------------------------------------------------------
           */
          $tx2 .= 'vFrete_I15=' . number_format($item->itemfreight, 2, '.', '') . PHP_EOL;
        }

        // se o item tiver desconto
        if ($item->itemdiscount > 0) {

          $vDesc_W10 += number_format($item->itemdiscount, 2, '.', '');
          $vNF_W16 -= number_format($item->itemdiscount, 2, '.', '');

          /*
           * ------------------------------------------------------------
           * vDesc_I17
           * Valor Total do Desconto
           * ------------------------------------------------------------
           */
          $tx2 .= 'vDesc_I17=' . number_format($item->itemdiscount, 2, '.', '') . PHP_EOL;
        }

        $tx2 .=
          /*
           * ------------------------------------------------------------
           * indTot_I17b
           * Indica se valor do Item (vProd) entra no valor total da NF-e (vProd)
           * 0 = Valor do item (vProd) não compõe o valor total da NF-e
           * 1 = Valor do item (vProd) compõe o valor total da NF-e
           * ------------------------------------------------------------
           */
          'indTot_I17b=1' . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * xPed_I60
           * Número do Pedido de Compra
           * ------------------------------------------------------------
           */
          'xPed_I60=' . $invoice[0]->customerpurchaseorder . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * nItemPed_I61
           * Item do Pedido de Compra
           * ------------------------------------------------------------
           */
          'nItemPed_I61=' . $item->itemline . PHP_EOL .
          /*
           * ------------------------------------------------------------
           * infAdProd_V01
           * Item do Pedido de Compra
           * ------------------------------------------------------------
           */
          'infAdProd_V01=' . $item->additionalinformation . PHP_EOL;

        // se o item tiver icms
        if (isset($item->taxes->icms)) {

          $vBC_W03 += $item->taxes->icms->calculationbase;
          $vICMS_W04 += $item->taxes->icms->taxvalue;

          // se o CST for 00
          if ($item->taxes->icms->cst == '00') {
            $tx2 .=
              /*
               * ------------------------------------------------------------
               * orig_N11
               * Origem da mercadoria
               * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
               * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;
               * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
               * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%;
               * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de quetratam as legislações citadas nos Ajustes;
               * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
               * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;
               * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CAMEX e gás natural.
               * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%;
               * ------------------------------------------------------------
               */
              'orig_N11=' . $item->itemorigincode . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * CST_N12
               * Tributação do ICMS
               * 00 = Tributada integralmente
               * ------------------------------------------------------------
               */
              'CST_N12=' . $item->taxes->icms->cst . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * modBC_N13
               * Modalidade de determinação da BC do ICMS
               * 0 = Margem Valor Agregado (%);
               * 1 = Pauta (Valor); 2=Preço Tabelado Máx. (valor);
               * 3 = Valor da operação.
               * ------------------------------------------------------------
               */
              'modBC_N13=3' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vBC_N15
               * Valor da BC do ICMS
               * ------------------------------------------------------------
               */
              'vBC_N15=' . number_format($item->taxes->icms->calculationbase, 2, '.', '') . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pICMS_N16
               * Alíquota do imposto
               * Alíquota do ICMS sem o FCP. Quando for o caso, informar a alíquota do FCP no campo pFCP
               * ------------------------------------------------------------
               */
              'pICMS_N16=' . number_format($item->taxes->icms->aliquot * 100, 2, '.', '') . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vICMS_N17
               * Valor do ICMS
               * ------------------------------------------------------------
               */
              'vICMS_N17=' . number_format($item->taxes->icms->taxvalue, 2, '.', '') . PHP_EOL;
          }



          // se o CST for 20
          if ($item->taxes->icms->cst == '20') {

            $pRedBC_N14 = abs(round(((($item->taxes->icms->calculationbase / $item->taxes->icms->linenetvalue) * 100) - 100), 2));

            $tx2 .=
              /*
               * ------------------------------------------------------------
               * orig_N11
               * Origem da mercadoria
               * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
               * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;
               * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
               * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%;
               * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de quetratam as legislações citadas nos Ajustes;
               * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
               * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;
               * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CAMEX e gás natural.
               * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%;
               * ------------------------------------------------------------
               */
              'orig_N11=' . $item->itemorigincode . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * CST_N12
               * Tributação do ICMS
               * 20 = Tributação com redução de base de cálculo
               * ------------------------------------------------------------
               */
              'CST_N12=' . $item->taxes->icms->cst . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * modBC_N13
               * Modalidade de determinação da BC do ICMS
               * 0 = Margem Valor Agregado (%);
               * 1 = Pauta (Valor); 2=Preço Tabelado Máx. (valor);
               * 3 = Valor da operação.
               * ------------------------------------------------------------
               */
              'modBC_N13=3' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pRedBC_N14
               * Percentual da Redução de BC
               * ------------------------------------------------------------
               */
              'pRedBC_N14=' . $pRedBC_N14 . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vBC_N15
               * Valor da BC do ICMS
               * ------------------------------------------------------------
               */
              'vBC_N15=' . number_format($item->taxes->icms->calculationbase, 2, '.', '') . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pICMS_N16
               * Alíquota do imposto
               * Alíquota do ICMS sem o FCP. Quando for o caso, informar a alíquota do FCP no campo pFCP
               * ------------------------------------------------------------
               */
              'pICMS_N16=' . number_format($item->taxes->icms->aliquot * 100, 2, '.', '') . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vICMS_N17
               * Valor do ICMS
               * ------------------------------------------------------------
               */
              'vICMS_N17=' . number_format($item->taxes->icms->taxvalue, 2, '.', '') . PHP_EOL;
          }

          /*
           * ------------------------------------------------------------
           * se o CST for
           * 40 = Isenta
           * 41 = Não tributada
           * 50 = Suspensão
           * ------------------------------------------------------------
           */
          if (in_array($item->taxes->icms->cst, array('40', '41', '50'))) {

            $vBC_W03 = 0;

            $tx2 .=
              /*
               * ------------------------------------------------------------
               * orig_N11
               * Origem da mercadoria
               * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
               * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;
               * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
               * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%;
               * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de quetratam as legislações citadas nos Ajustes;
               * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
               * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;
               * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CAMEX e gás natural.
               * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%;
               * ------------------------------------------------------------
               */
              'orig_N11=' . $item->itemorigincode . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * CST_N12
               * Tributação do ICMS
               * 20 = Tributação com redução de base de cálculo
               * ------------------------------------------------------------
               */
              'CST_N12=' . $item->taxes->icms->cst . PHP_EOL;
          }

          // se o CST for 60
          if ($item->taxes->icms->cst == '60') {

            $vBC_W03 -= $item->taxes->icms->calculationbase;

            $tx2 .=
              /*
               * ------------------------------------------------------------
               * orig_N11
               * Origem da mercadoria
               * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
               * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;
               * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
               * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%;
               * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de quetratam as legislações citadas nos Ajustes;
               * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
               * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;
               * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CAMEX e gás natural.
               * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%;
               * ------------------------------------------------------------
               */
              'orig_N11=' . $item->itemorigincode . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * CST_N12
               * Tributação do ICMS
               * 20 = Tributação com redução de base de cálculo
               * ------------------------------------------------------------
               */
              'CST_N12=' . $item->taxes->icms->cst . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vBCSTRet_N26
               * Valor da BC do ICMS ST retido
               * Valor da BC do ICMS ST cobrado anteriormente por ST. O valor pode ser omitido quando a legislação não exigir a sua informação.
               * ------------------------------------------------------------
               */
              'vBCSTRet_N26=' . number_format($item->taxes->icms->calculationbase, 2, '.', '') . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pST_N26a
               * Alíquota suportada pelo Consumidor Final
               * Deve ser informada a alíquota do cálculo do ICMS-ST, já incluso o FCP caso incida sobre a mercadoria.
               * Exemplo: alíquota da mercadoria na venda ao consumidor final = 18% e 2% de FCP.
               * A alíquota a ser informada no campo pST deve ser 20%
               * ------------------------------------------------------------
               */
              'pST_N26a=' . number_format($item->taxes->icms->aliquot * 100, 2, '.', '') . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vICMSSubstituto_N26b
               * Valor do ICMS próprio do Substituto
               * Valor do ICMS Próprio do Substituto cobrado em operação anterior
               * ------------------------------------------------------------
               */
              'vICMSSubstituto_N26b=' . $item->taxes->icms->taxvalue . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vICMSSTRet_N27
               * Valor do ICMS ST retido
               * Valor do ICMS ST cobrado anteriormente por ST (v2.0). O valor pode ser omitido quando a legislação não exigir a sua informação
               * ------------------------------------------------------------
               */
              'vICMSSTRet_N27=' . number_format($item->taxes->icms->calculationbase, 2, '.', '') . PHP_EOL;
          }

          // se o CST for 90
          if ($item->taxes->icms->cst == '90') {

            $pRedBC_N14 = abs(round(((($item->taxes->icms->calculationbase / $item->taxes->icms->linenetvalue) * 100) - 100), 2));

            $tx2 .=
              /*
               * ------------------------------------------------------------
               * orig_N11
               * Origem da mercadoria
               * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
               * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;
               * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
               * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%;
               * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de quetratam as legislações citadas nos Ajustes;
               * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
               * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;
               * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CAMEX e gás natural.
               * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%;
               * ------------------------------------------------------------
               */
              'orig_N11=' . $item->itemorigincode . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * CST_N12
               * Tributação do ICMS
               * 90 = Outros
               * ------------------------------------------------------------
               */
              'CST_N12=' . $item->taxes->icms->cst . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * modBC_N13
               * Modalidade de determinação da BC do ICMS
               * 0 = Margem Valor Agregado (%);
               * 1 = Pauta (Valor); 2=Preço Tabelado Máx. (valor);
               * 3 = Valor da operação.
               * ------------------------------------------------------------
               */
              'modBC_N13=3' . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pRedBC_N14
               * Percentual da Redução de BC
               * ------------------------------------------------------------
               */
              'pRedBC_N14=' . $pRedBC_N14 . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vBC_N15
               * Valor da BC do ICMS
               * ------------------------------------------------------------
               */
              'vBC_N15=' . number_format($item->taxes->icms->calculationbase, 2, '.', '') . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * pICMS_N16
               * Alíquota do imposto
               * Alíquota do ICMS sem o FCP. Quando for o caso, informar a alíquota do FCP no campo pFCP
               * ------------------------------------------------------------
               */
              'pICMS_N16=' . number_format($item->taxes->icms->aliquot * 100, 2, '.', '') . PHP_EOL .
              /*
               * ------------------------------------------------------------
               * vICMS_N17
               * Valor do ICMS
               * ------------------------------------------------------------
               */
              'vICMS_N17=' . number_format($item->taxes->icms->taxvalue, 2, '.', '') . PHP_EOL;
          }

        }

        // se o item tiver difal
        if (isset($item->taxes->icmsdestination) && isset($item->taxes->icmssender)) {

          if (isset($item->taxes->fcp)) {
            $vFCPUFDest_W04c += $item->taxes->fcp->taxvalue;
          } else {
            $vFCPUFDest_W04c += 0;
            $item->taxes->fcp = new stdClass();
            $item->taxes->fcp->calculationbase = 0;
            $item->taxes->fcp->aliquot = 0;
            $item->taxes->fcp->taxvalue = 0;
          }

          $vICMSUFDest_W04e += $item->taxes->icmsdestination->taxvalue;

          $tx2 .=
            /*
             * ------------------------------------------------------------
             * vBCUFDest_NA03
             * Valor da BC do ICMS na UF de destino
             * Valor da Base de Cálculo do ICMS na UF de destino.
             * ------------------------------------------------------------
             */
            'vBCUFDest_NA03=' . number_format($item->taxes->icmsdestination->calculationbase, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vBCFCPUFDest_NA04
             * Valor da BC do FCP na UF de destino
             * ------------------------------------------------------------
             */
            'vBCFCPUFDest_NA04=' . number_format($item->taxes->fcp->calculationbase, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * pFCPUFDest_NA05
             * Percentual do ICMS relativo ao Fundo de Combate à Pobreza (FCP) na UF de destino
             * ------------------------------------------------------------
             */
            'pFCPUFDest_NA05=' . number_format($item->taxes->fcp->aliquot * 100, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * pICMSUFDest_NA07
             * Alíquota interna da UF de destino
             * Alíquota adotada nas operações internas na UF de destino para o produto / mercadoria.
             * A alíquota do Fundo de Combate à Pobreza, se existente para o produto / mercadoria, deve ser informada no campo próprio (pFCPUFDest) não devendo ser somada a essa alíquota interna
             * ------------------------------------------------------------
             */
            'pICMSUFDest_NA07=' . number_format($item->taxes->icmsdestination->aliquotdestination * 100, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * pICMSInter_NA09
             * Alíquota interestadual das UF envolvidas
             * 4% alíquota interestadual para produtos importados
             * 7% para os Estados de origem do Sul e Sudeste (exceto ES), destinado para os Estados do Norte, Nordeste, Centro-Oeste e Espírito Santo
             * 12% para os demais casos
             * ------------------------------------------------------------
             */
            'pICMSInter_NA09=' . number_format($item->taxes->icmssender->aliquot * 100, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * pICMSInterPart_NA11
             * Percentual provisório de partilha do ICMS Interestadual
             * Percentual de ICMS Interestadual para a UF de destino:
             * 100% a partir de 2019
             * ------------------------------------------------------------
             */
            'pICMSInterPart_NA11=100.00' . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vFCPUFDest_NA13
             * Valor do ICMS relativo ao Fundo de Combate à Pobreza (FCP) da UF de destino
             * ------------------------------------------------------------
             */
            'vFCPUFDest_NA13=' . number_format($item->taxes->fcp->taxvalue, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vICMSUFDest_NA15
             * Valor do ICMS Interestadual para a UF de destino (sem o valor do ICMS relativo ao FCP).
             * ------------------------------------------------------------
             */
            'vICMSUFDest_NA15=' . number_format($item->taxes->icmsdestination->taxvalue, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vICMSUFRemet_NA17
             * Valor do ICMS Interestadual para a UF do remetente
             * Nota: A partir de 2019, este valor será zero.
             * ------------------------------------------------------------
             */
            'vICMSUFRemet_NA17=0.00' . PHP_EOL;
        }

        // se o item tiver pis
        if (isset($item->taxes->pis)) {

          $vPIS_W13 += $item->taxes->pis->taxvalue;

          $tx2 .=
            /*
             * ------------------------------------------------------------
             * CST_Q06
             * Código de Situação Tributária do PIS
             * 01 = Operação Tributável (base de cálculo = valor da operação alíquota normal (cumulativo/não cumulativo))
             * 02 = Operação Tributável (base de cálculo = valor da operação (alíquota diferenciada))
             * 03 = Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
             * 04 = Operação Tributável (tributação monofásica (alíquota zero))
             * 05 = Operação Tributável (Substituição Tributária)
             * 06 = Operação Tributável (alíquota zero)
             * 07 = Operação Isenta da Contribuição
             * 08 = Operação Sem Incidência da Contribuição
             * 09 = Operação com Suspensão da Contribuição
             * 49 = Outras Operações de Saída
             * 50 = Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno
             * 51 = Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno
             * 52 = Operação com Direito a Crédito – Vinculada Exclusivamente a Receita de Exportação
             * 53 = Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno
             * 54 = Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação
             * 55 = Operação com Direito a Crédito - Vinculada a Receitas NãoTributadas no Mercado Interno e de Exportação
             * 56 = Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação
             * 60 = Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno
             * 61 = Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno
             * 62 = Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação
             * 63 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno
             * 64 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação
             * 65 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação
             * 66 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação
             * 67 = Crédito Presumido - Outras Operações
             * 70 = Operação de Aquisição sem Direito a Crédito
             * 71 = Operação de Aquisição com Isenção
             * 72 = Operação de Aquisição com Suspensão
             * 73 = Operação de Aquisição a Alíquota Zero
             * 74 = Operação de Aquisição sem Incidência da Contribuição
             * 75 = Operação de Aquisição por Substituição Tributária
             * 98 = Outras Operações de Entrada
             * 99 = Outras Operações
             * ------------------------------------------------------------
             */
            'CST_Q06=' . $item->taxes->pis->cst . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vBC_Q07
             * Valor da Base de Cálculo do PIS
             * ------------------------------------------------------------
             */
            'vBC_Q07=' . number_format($item->taxes->pis->calculationbase, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * pPIS_Q08
             * Alíquota do PIS (em percentual)
             * ------------------------------------------------------------
             */
            'pPIS_Q08=' . number_format($item->taxes->pis->aliquot * 100, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vPIS_Q09
             * Valor do PIS
             * ------------------------------------------------------------
             */
            'vPIS_Q09=' . number_format($item->taxes->pis->taxvalue, 2, '.', '') . PHP_EOL;
        }

        // se o item tiver cofins
        if (isset($item->taxes->cofins)) {

          $vCOFINS_W14 += $item->taxes->cofins->taxvalue;

          $tx2 .=
            /*
             * ------------------------------------------------------------
             * CST_S06
             * Código de Situação Tributária do COFINS
             * 01 = Operação Tributável (base de cálculo = valor da operação alíquota normal (cumulativo/não cumulativo))
             * 02 = Operação Tributável (base de cálculo = valor da operação (alíquota diferenciada))
             * 03 = Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
             * 04 = Operação Tributável (tributação monofásica, alíquota zero)
             * 05 = Operação Tributável (Substituição Tributária)
             * 06 = Operação Tributável (alíquota zero)
             * 07 = Operação Isenta da Contribuição
             * 08 = Operação Sem Incidência da Contribuição
             * 09 = Operação com Suspensão da Contribuição
             * 49 = Outras Operações de Saída
             * 50 = Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno
             * 51 = Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno
             * 52 = Operação com Direito a Crédito – Vinculada Exclusivamente a Receita de Exportação
             * 53 = Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno
             * 54 = Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação
             * 55 = Operação com Direito a Crédito - Vinculada a Receitas NãoTributadas no Mercado Interno e de Exportação
             * 56 = Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação
             * 60 = Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno
             * 61 = Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno
             * 62 = Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação
             * 63 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno
             * 64 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação
             * 65 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação
             * 66 = Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação
             * 67 = Crédito Presumido - Outras Operações
             * 70 = Operação de Aquisição sem Direito a Crédito
             * 71 = Operação de Aquisição com Isenção
             * 72 = Operação de Aquisição com Suspensão
             * 73 = Operação de Aquisição a Alíquota Zero
             * 74 = Operação de Aquisição sem Incidência da Contribuição
             * 75 = Operação de Aquisição por Substituição Tributária
             * 98 = Outras Operações de Entrada
             * 99 = Outras Operações
             * ------------------------------------------------------------
             */
            'CST_S06=' . $item->taxes->cofins->cst . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vBC_S07
             * Valor da Base de Cálculo do COFINS
             * ------------------------------------------------------------
             */
            'vBC_S07=' . number_format($item->taxes->cofins->calculationbase, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * pCOFINS_S08
             * Alíquota do COFINS (em percentual)
             * ------------------------------------------------------------
             */
            'pCOFINS_S08=' . number_format($item->taxes->cofins->aliquot * 100, 2, '.', '') . PHP_EOL .
            /*
             * ------------------------------------------------------------
             * vCOFINS_S11
             * Valor do COFINS
             * ------------------------------------------------------------
             */
            'vCOFINS_S11=' . number_format($item->taxes->cofins->taxvalue, 2, '.', '') . PHP_EOL;
        }

        $tx2 .= 'SALVARITEM' . PHP_EOL;

        $i++;

      }

      $tx2 .=
        /*
         * ------------------------------------------------------------
         * vBC_W03
         * Base de Cálculo do ICMS
         * ------------------------------------------------------------
         */
        'vBC_W03=' . number_format($vBC_W03, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vICMS_W04
         * Valor Total do ICMS
         * ------------------------------------------------------------
         */
        'vICMS_W04=' . number_format($vICMS_W04, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vICMSDeson_W04a
         * Valor Total do ICMS desonerado
         * ------------------------------------------------------------
         */
        'vICMSDeson_W04a=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vFCPUFDest_W04c
         * Valor total do ICMS relativo Fundo de Combate à Pobreza (FCP) da UF de destino
         * ------------------------------------------------------------
         */
        'vFCPUFDest_W04c=' . number_format($vFCPUFDest_W04c, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vICMSUFDest_W04e
         * Valor total do ICMS Interestadual para a UF de destino, sem o valor do ICMS relativo ao FCP
         * ------------------------------------------------------------
         */
        'vICMSUFDest_W04e=' . number_format($vICMSUFDest_W04e, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vICMSUFRemet_W04g
         * Valor total do ICMS Interestadual para a UF do remetente
         * Nota: A partir de 2019, este valor será zero
         * ------------------------------------------------------------
         */
        'vICMSUFRemet_W04g=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vFCP_W04h
         * Valor Total do FCP (Fundo de Combate à Pobreza)
         * Corresponde ao total da soma dos campos id: N17c
         * ------------------------------------------------------------
         */
        'vFCP_W04h=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vBCST_W05
         * Base de Cálculo do ICMS ST
         * ------------------------------------------------------------
         */
        'vBCST_W05=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vST_W06
         * Valor Total do ICMS ST
         * ------------------------------------------------------------
         */
        'vST_W06=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vFCPST_W06a
         * Valor Total do FCP (Fundo de Combate à Pobreza) retido por substituição tributária
         * Corresponde ao total da soma dos campos id: N23d
         * ------------------------------------------------------------
         */
        'vFCPST_W06a=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vFCPSTRet_W06b
         * Valor Total do FCP retido anteriormente por Substituição Tributária
         * Corresponde ao total da soma dos campos id: N27d
         * ------------------------------------------------------------
         */
        'vFCPSTRet_W06b=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vProd_W07
         * Valor Total dos produtos e serviços
         * ------------------------------------------------------------
         */
        'vProd_W07=' . number_format($vProd_W07, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vFrete_W08
         * Valor Total do Frete
         * ------------------------------------------------------------
         */
        'vFrete_W08=' . number_format($vFrete_W08, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vSeg_W09
         * Valor Total do Frete
         * ------------------------------------------------------------
         */
        'vSeg_W09=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vDesc_W10
         * Valor Total do Desconto
         * ------------------------------------------------------------
         */
        'vDesc_W10=' . number_format($vDesc_W10, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vII_W11
         * Valor Total do II
         * ------------------------------------------------------------
         */
        'vII_W11=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vIPI_W12
         * Valor Total do IPI
         * ------------------------------------------------------------
         */
        'vIPI_W12=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vIPIDevol_W12a
         * Valor Total do IPI Devolvido
         * Deve ser informado quando preenchido o Grupo Tributos Devolvidos na emissão de nota finNFe=4 (devolução) nas operações com não contribuintes do IPI.
         * Corresponde ao total da soma dos campos id: UA04.
         * ------------------------------------------------------------
         */
        'vIPIDevol_W12a=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vPIS_W13
         * Valor Total do PIS
         * ------------------------------------------------------------
         */
        'vPIS_W13=' . number_format($vPIS_W13, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vCOFINS_W14
         * Valor Total do COFINS
         * ------------------------------------------------------------
         */
        'vCOFINS_W14=' . number_format($vCOFINS_W14, 2, '.', '') . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vOutro_W15
         * Valor total de Outras despesas
         * ------------------------------------------------------------
         */
        'vOutro_W15=0.00' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vNF_W16
         * Valor Total da NF-e
         * ------------------------------------------------------------
         */
        'vNF_W16=' . number_format($vNF_W16, 2, '.', '') . PHP_EOL;

    }

    return $tx2;
  }

  private function getbilltx2($invoice, $items)
  {
    $vOrig_Y04 = 0;
    $vDesc_Y05 = 0;
    $vLiq_Y06 = 0;

    foreach ($items as $item) {
      $vOrig_Y04 += $item->itemgrossvalue + $item->itemfreight;
      $vDesc_Y05 += number_format(($item->itemdiscount), 2, '.', '');
      $vLiq_Y06 += number_format((($item->itemgrossvalue + $item->itemfreight) - $item->itemdiscount), 2, '.', '');
    }

    $tx2 =
      /*
       * ------------------------------------------------------------
       * nFat_Y03
       * Número da Fatura
       * ------------------------------------------------------------
       */
      'nFat_Y03=' . $invoice[0]->tranid . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * vOrig_Y04
       * Valor Original da Fatura
       * ------------------------------------------------------------
       */
      'vOrig_Y04=' . number_format($vOrig_Y04, 2, '.', '') . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * vDesc_Y05
       * Valor do desconto
       * ------------------------------------------------------------
       */
      'vDesc_Y05=' . number_format($vDesc_Y05, 2, '.', '') . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * vLiq_Y06
       * Valor Líquido da Fatura
       * ------------------------------------------------------------
       */
      'vLiq_Y06=' . number_format($vLiq_Y06, 2, '.', '') . PHP_EOL;

    return $tx2;
  }

  private function getinstallmentstx2($invoice, $installments)
  {

    $tx2 = '';

    foreach ($installments as $installment) {
      $tx2 .=
        'INCLUIRCOBRANCA' . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * nDup_Y08
         * Número da Parcela
         * Obrigatória informação do número de parcelas com 3 algarismos
         * Sequência é consecutivos. Ex.: “001”,”002”,”003”...
         * ------------------------------------------------------------
         */
        'nDup_Y08=' . str_pad($installment->installment, 3, '0', STR_PAD_LEFT) . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * dVenc_Y09
         * Data de vencimento
         * Formato: “AAAA-MM-DD”.
         * Obrigatória a informação da data de vencimento na ordem crescente das datas.
         * Ex.: “2018-06-01”, ”2018-07-01”, “2018-08-01”...
         * ------------------------------------------------------------
         */
        'dVenc_Y09=' . date('Y-m-d', $installment->deadline) . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * vDup_Y10
         * Valor da Parcela
         * ------------------------------------------------------------
         */
        'vDup_Y10=' . number_format($installment->total, 2, '.', '') . PHP_EOL .
        'SALVARCOBRANCA' . PHP_EOL;
    }

    return $tx2;
  }

  private function getcarriertx2($invoice, $carrier, $carrierbilladdress)
  {

    $tx2 =
      /*
       * ------------------------------------------------------------
       * modFrete_X02
       * Modalidade do frete
       * 0 = Contratação do Frete por conta do Remetente (CIF)
       * 1 = Contratação do Frete por conta do Destinatário (FOB)
       * 2 = Contratação do Frete por conta de Terceiros
       * 3 = Transporte Próprio por conta do Remetente
       * 4 = Transporte Próprio por conta do Destinatário
       * 9 = Sem Ocorrência de Transporte.
       * ------------------------------------------------------------
       */
      'modFrete_X02=' . $invoice[0]->freighttypecode . PHP_EOL;

    if ($invoice[0]->freighttypecode != 9) {
      if ($carrier[0]->persontype == 'Jurídica') {
        /*
         * ------------------------------------------------------------
         * CNPJ_X04
         * CNPJ do Transportador
         * ------------------------------------------------------------
         */
        $tx2 .= 'CNPJ_X04=' . preg_replace('/\D/', '', $carrier[0]->document) . PHP_EOL;

        $xNome_X06 = substr($carrier[0]->legalname, 0, 60);
      }

      if ($carrier[0]->persontype == 'Física') {
        /*
         * ------------------------------------------------------------
         * CPF_X05
         * CPF do Transportador
         * ------------------------------------------------------------
         */
        $tx2 .= 'CPF_X05=' . preg_replace('/\D/', '', $carrier[0]->document) . PHP_EOL;

        $xNome_X06 = substr($carrier[0]->name, 0, 60);
      }

      /*
       * ------------------------------------------------------------
       * xNome_X06
       * Razão Social ou nome
       * ------------------------------------------------------------
       */
      $tx2 .= 'xNome_X06=' . $xNome_X06 . PHP_EOL;

      /*
       * ------------------------------------------------------------
       * IE_X07
       * Inscrição Estadual do Transportador
       * Informar:
       * - Inscrição Estadual do transportador contribuinte do ICMS, sem caracteres de formatação (ponto, barra, hífen, etc.)
       * - Literal “ISENTO” para transportador isento de inscrição no cadastro de contribuintes ICMS
       * - Não informar a tag para não contribuinte do ICMS, A UF deve ser informada se informado uma IE.
       * ------------------------------------------------------------
       */
      if ($carrier[0]->ieexempt == 'T') {
        $tx2 .= 'IE_X07=ISENTO' . PHP_EOL;
      } else {
        $tx2 .= 'IE_X07=' . preg_replace('/\D/', '', $carrier[0]->ie) . PHP_EOL;
      }

      $tx2 .=
        /*
         * ------------------------------------------------------------
         * xEnder_X08
         * Endereço Completo
         * ------------------------------------------------------------
         */
        'xEnder_X08=' . substr(($carrierbilladdress[0]->street . ', ' . $carrierbilladdress[0]->number . ' - ' . $carrierbilladdress[0]->neighborhood), 0, 60) . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * xMun_X09
         * Nome do município
         * ------------------------------------------------------------
         */
        'xMun_X09=' . substr($carrierbilladdress[0]->city, 0, 60) . PHP_EOL .
        /*
         * ------------------------------------------------------------
         * UF_X10
         * Sigla da UF
         * A UF deve ser informada se informado uma IE. Informar "EX" para Exterior.
         * ------------------------------------------------------------
         */
        'UF_X10=' . $carrierbilladdress[0]->state . PHP_EOL;
    }

    return $tx2;
  }

  private function getbulktx2($invoice)
  {

    $tx2 =
      'INCLUIRPARTE=VOL' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * qVol_X27
       * Quantidade de volumes transportados
       * ------------------------------------------------------------
       */
      'qVol_X27=' . $invoice[0]->volumesquantity . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * esp_X28
       * Endereço Completo
       * ------------------------------------------------------------
       */
      'esp_X28=' . substr($invoice[0]->volumetype, 0, 60) . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * pesoL_X31
       * Peso Líquido (em kg)
       * ------------------------------------------------------------
       */
      'pesoL_X31=' . number_format($invoice[0]->netweight, 3, '.', '') . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * pesoB_X32
       * Peso Bruto (em kg)
       * ------------------------------------------------------------
       */
      'pesoB_X32=' . number_format($invoice[0]->grossweight, 3, '.', '') . PHP_EOL .
      'SALVARPARTE=VOL' . PHP_EOL;

    return $tx2;
  }

  private function getbilldetailtx2($invoice, $installments, $items)
  {

    $vPag_YA03 = 0;

    // se a operação for diferente de 90 = Sem pagamento
    if ($invoice[0]->paymentmethodcode != '90') {
      foreach ($items as $item) {
        $vPag_YA03 += $item->itemtotal;
      }
    }

    $indPag_YA01b = count($installments) > 1 ? '1' : '0';

    $tx2 =
      'INCLUIRPARTE=YA' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * indPag_YA01b
       * Indicador da Forma de Pagamento
       * 0 = Pagamento à Vista
       * 1 = Pagamento à Prazo
       * ------------------------------------------------------------
       */
      'indPag_YA01b=' . $indPag_YA01b . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * tPag_YA02
       * Meio de pagamento
       * 01 = Dinheiro
       * 02 = Cheque
       * 03 = Cartão de Crédito
       * 04 = Cartão de Débito
       * 05 = Crédito Loja
       * 10 = Vale Alimentação
       * 11 = Vale Refeição
       * 12 = Vale Presente
       * 13 = Vale Combustível
       * 14 = Duplicata Mercantil
       * 15 = Boleto Bancário
       * 16 = Depósito Bancário
       * 17 = Pagamento Instantâneo (PIX)
       * 18 = Transferência bancária, Carteira Digital
       * 19 = Programa de fidelidade, Cashback, Crédito Virtual
       * 90 = Sem pagamento
       * 99 = Outros
       * ------------------------------------------------------------
       */
      'tPag_YA02=' . $invoice[0]->paymentmethodcode . PHP_EOL;

    if ($invoice[0]->paymentmethodcode == '99') {
      /*
       * ------------------------------------------------------------
       * xPag_YA02a
       * Descrição do Meio de Pagamento
       * Preencher informando o meio de pagamento utilizado quando o código do meio de pagamento for informado como 99 Outros.
       * ------------------------------------------------------------
       */
      $tx2 .= 'xPag_YA02a=' . $invoice[0]->paymentmethoddescription . PHP_EOL;
    }

    $tx2 .=
      /*
       * ------------------------------------------------------------
       * vPag_YA03
       * Valor do Pagamento
       * ------------------------------------------------------------
       */
      'vPag_YA03=' . number_format($vPag_YA03, 2, '.', '') . PHP_EOL .
      'SALVARPARTE=YA' . PHP_EOL;

    return $tx2;
  }

  private function getfootertx2($invoice, $items)
  {
    $infAdFisco_Z02 = '';

    $vFCPUFDest = 0;
    $vICMSUFDest = 0;

    // se o item tiver difal
    foreach ($items as $item) {
      if (isset($item->taxes->icmsdestination) && isset($item->taxes->icmssender)) {
        $vFCPUFDest += $item->taxes->fcp->taxvalue;
        $vICMSUFDest += $item->taxes->icmsdestination->taxvalue;
      }
    }

    if ($vFCPUFDest > 0 || $vICMSUFDest > 0) {
      $infAdFisco_Z02 =
        'Valor total do ICMS relativo ao Fundo de Combate à Pobreza (FCP) para a UF de destino: ' . number_format($vFCPUFDest, 2, ',', '') .
        '|Valor total do ICMS de partilha para a UF do destinatário: ' . number_format($vICMSUFDest, 2, ',', '') .
        '|Valor total do ICMS de partilha para a UF do remetente: R$ 0,00';
    }

    $tx2 =
      /*
       * ------------------------------------------------------------
       * infAdFisco_Z02
       * Informações Adicionais de Interesse do Fisco
       * ------------------------------------------------------------
       */
      'infAdFisco_Z02=' . $infAdFisco_Z02 . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * infCpl_Z03
       * Informações Complementares de interesse do Contribuinte
       * ------------------------------------------------------------
       */
      'infCpl_Z03=' . $invoice[0]->additionalinformation . PHP_EOL .
      'SALVAR' . PHP_EOL;

    return $tx2;
  }

  private function getcorrectiontx2($invoice)
  {

    /*
     * ------------------------------------------------------------
     * OBSERVAÇÃO:
     * Uma carta de correção é cancelada automaticamente após a autorização de um nova CCe para o mesmo documento.
     * Ou seja, a última CCe autorizada anula a anterior.
     * ------------------------------------------------------------
     */

    $timezone = new DateTimeZone('America/Sao_Paulo');
    $date = new DateTime('now', $timezone);
    $dhEvento = $date->format('Y-m-d\TH:i:s');

    $tx2 =
      'Formato=tx2' . PHP_EOL .
      'INCLUIR' . PHP_EOL .
      'Documento=CCE' . PHP_EOL .
      'ChaveNota=' . $invoice[0]->fiscaldocaccesskey . PHP_EOL .
      'dhEvento=' . $dhEvento . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * Orgao
       * Código da UF do emitente do Documento Fiscal
       * 35 = SP
       * ------------------------------------------------------------
       */
      'Orgao=35' . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * SeqEvento
       * Sequência do evento da carta de correção
       * ------------------------------------------------------------
       */
      'SeqEvento=' . ($invoice[0]->sequencecce + 1) . PHP_EOL .
      /*
       * ------------------------------------------------------------
       * Correcao
       * Texto da Carta de Correção
       * ------------------------------------------------------------
       */
      'Correcao=' . $invoice[0]->correction . PHP_EOL .
      'Lote=1' . PHP_EOL .
      'Fuso=' . $date->format('P') . PHP_EOL .
      'SALVAR';

    return $tx2;
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

  private function servernfestats($data)
  {
    $ch = curl_init(TECNOSPEED_ENDPOINT . 'status?' . http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . TECNOSPEED_CREDENTIAL));

    $response = curl_exec($ch);

    return mb_convert_encoding($response, 'UTF-8', 'ISO-8859-1');
  }

  private function importnfe($data)
  {
    $ch = curl_init(TECNOSPEED_ENDPOINT . 'importa');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Authorization: ' . TECNOSPEED_CREDENTIAL));

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);

    return mb_convert_encoding($response, 'UTF-8', 'ISO-8859-1');
  }

  private function consultnfe($data)
  {
    $ch = curl_init(TECNOSPEED_ENDPOINT . 'consulta?' . http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . TECNOSPEED_CREDENTIAL));

    $response = curl_exec($ch);

    return $response;
  }

  private function sendnfe($data)
  {
    $ch = curl_init(TECNOSPEED_ENDPOINT . 'envia');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Authorization: ' . TECNOSPEED_CREDENTIAL));

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);

    return mb_convert_encoding($response, 'UTF-8', 'ISO-8859-1');
  }

  private function validatenfe($data)
  {
    $ch = curl_init(TECNOSPEED_ENDPOINT . 'valida');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Authorization: ' . TECNOSPEED_CREDENTIAL));

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);

    return mb_convert_encoding($response, 'UTF-8', 'ISO-8859-1');
  }

  private function cancelnfe($data)
  {
    $ch = curl_init(TECNOSPEED_ENDPOINT . 'cancela');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Authorization: ' . TECNOSPEED_CREDENTIAL));

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);

    return mb_convert_encoding($response, 'UTF-8', 'ISO-8859-1');
  }

  private function getxml($data)
  {
    $ch = curl_init(TECNOSPEED_ENDPOINT . 'xml?' . http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . TECNOSPEED_CREDENTIAL));

    $response = curl_exec($ch);

    return mb_convert_encoding($response, 'UTF-8', 'ISO-8859-1');
  }

  private function getdanfe($data)
  {
    $ch = curl_init(TECNOSPEED_ENDPOINT . 'imprime?' . http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . TECNOSPEED_CREDENTIAL));

    $response = curl_exec($ch);

    return $response;
  }
}
