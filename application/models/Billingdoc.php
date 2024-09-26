<?php
defined('BASEPATH') or exit('No direct script access allowed');

class billingdoc extends CI_Model
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

  public function sending($invoice)
  {

    $invoice = $this->db->select('
      invoices.id,
      invoices.customerid,
      invoices.subsidiaryid,
      invoices.billaddressid,
      invoices.paymentmethodid,
      invoices.accountid,
      invoices.fiscaldocnumber,
      accounts.accountws as accountws,
      agreements.agreementws as agreementws
    ')
      ->join('accounts', 'accounts.id = invoices.accountid', 'LEFT')
      ->join('agreements', 'agreements.link = invoices.accountid', 'LEFT')
      ->where('invoices.id', $invoice)
      ->get('invoices')
      ->result();

    $subsidiary = $this->db->select('subsidiaries.id, subsidiaries.title, subsidiaries.name, subsidiaries.legalname, subsidiaries.phone, subsidiaries.cnpj, subsidiaries.ie, subsidiaries.taxregime, taxregimes.title as taxregimetitle, taxregimes.code as taxregimecode, subsidiaries.hassimplesnacionalicms, subsidiaries.emailsuffix, addresses.street, addresses.number, addresses.zip, addresses.neighborhood, addresses.complement, addresses.city, addresses.state, addresses.country, addresses.standardbilling, addresses.standardshipping')
      ->join('taxregimes', 'taxregimes.id = subsidiaries.taxregime', 'LEFT')
      ->join('addresses', 'addresses.link = subsidiaries.id', 'LEFT')
      ->where('subsidiaries.id', $invoice[0]->subsidiaryid)
      ->where('addresses.standardbilling', 'T')
      ->get('subsidiaries')
      ->result();

    $customer = $this->db->select('entities.id, entities.isperson, types.title as persontype, entities.legalname, entities.document, entities.email, entities.phone')
      ->where('entities.id', $invoice[0]->customerid)
      ->join('types', 'entities.isperson = types.id', 'LEFT')
      ->get('entities')
      ->result();

    $customerbilladdress = $this->db->select('addresses.id, addresses.address, addresses.zip, addresses.street, addresses.number, addresses.complement, addresses.neighborhood, addresses.city, addresses.state, addresses.country, addresses.standardbilling, addresses.standardshipping')
      ->where('addresses.id', $invoice[0]->billaddressid)
      ->get('addresses')
      ->result();

    $installments = $this->db->select('
      invoiceinstallments.id,
      invoiceinstallments.tranid,
      invoiceinstallments.installment,
      invoiceinstallments.deadline,
      invoiceinstallments.percentage,
      invoiceinstallments.total
    ')
      ->where('invoiceinstallments.link', $invoice[0]->id)
      ->get('invoiceinstallments')
      ->result();

    $account = $this->getaccount(array('id' => $invoice[0]->accountws), preg_replace('/\D/', '', $subsidiary[0]->cnpj));

    $agreement = $this->getagreement(array('id' => $invoice[0]->agreementws), preg_replace('/\D/', '', $subsidiary[0]->cnpj));

    $billingdocs = $this->getjsonbillingdoc($subsidiary, $customer, $customerbilladdress, $installments, json_decode($account, true), json_decode($agreement, true), $invoice[0]->fiscaldocnumber);

    $registration = json_decode($this->createbillingdoc(json_encode($billingdocs), preg_replace('/\D/', '', $subsidiary[0]->cnpj)), true);

    // return json_encode($registration);

    /*
     *
     * RETORNO DE FALHA
     *
     */
    if (isset($registration['_dados']['_falha']) && count($registration['_dados']['_falha']) > 0) {
      $message = '';
      $errors = array();
      foreach ($registration['_dados']['_falha'] as $error) {
        // ERRO NOS CAMPOS ENVIADOS
        $errors = $error['_erro']['erros'];
        if (!empty($error['_erros'])) {
          $errors = [];
          foreach (array_column($error['_erros'], '_erro', '_campo') as $key => $val) {

            /*
             *
             * CASO SEJA ERRO NO ENVIO DOS CAMPOS, ELE CONCATENA O CAMPO COM O ERRO
             *
             */
            $errors[] = "$key: $val.";
          }
        }
        $message = implode('<br /> ', $errors);
      }

      return json_encode(
        array(
          'error' => true,
          'message' => $message,
          'errors' => (object) $errors,
          'wsresponse' => $registration
        )
      );
    }

    /*
     *
     * RETORNO DE SUCESSO
     *
     */
    foreach ($registration['_dados']['_sucesso'] as $billingdoc) {

      /*
       *
       * CONSULTA PELO NUMERO DA PARCELA E PELO ID DA FATURA
       *
       */
      $this->db->where(
        [
          // 'tranid' => (int) $billingdoc['TituloNossoNumero'],
          'installment' => (int) $billingdoc['TituloNossoNumero'],
          'link' => $invoice[0]->id
        ]
      )
        ->update('invoiceinstallments', [
          'documentnumber' => $billingdoc['TituloNumeroDocumento'],
          'billingdocournumber' => $billingdoc['TituloNossoNumero'],
          'integrationid' => $billingdoc['idintegracao'],
          'billingdocsituation' => $billingdoc['situacao'],
          'billingdoccreated' => 'T',
          'updated' => time()
        ]);
    }

    return json_encode([
      'error' => false,
      'message' => 'Os boletos foram registrados com sucesso.',
      'wsresponse' => $registration
    ]);
  }

  public function get($invoice)
  {

    $invoice = $this->db->select('
      invoices.id,
      invoices.customerid,
      invoices.subsidiaryid,
      invoices.billaddressid,
      invoices.paymentmethodid,
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

    $installments = $this->db->select('
      invoiceinstallments.id,
      invoiceinstallments.installment,
      invoiceinstallments.tranid,
      invoiceinstallments.integrationid,
      invoiceinstallments.documentnumber
    ')
      ->where('invoiceinstallments.link', $invoice[0]->id)
      ->get('invoiceinstallments')
      ->result();

    $consults = [];
    $wsresponse = [];

    foreach ($installments as $key => $installment) {

      $consults[$key] = [
        'error' => false, 
        'message' => '', 
        'installmentid' => $installment->id, 
        'installment' => $installment->installment, 
      ];

      $data = array(
        'idintegracao' => $installment->integrationid,
        'TituloNumeroDocumento' => $installment->documentnumber,
      );

      $billingdoc = json_decode($this->getbillingdoc($data, preg_replace('/\D/', '', $subsidiary[0]->cnpj)), true);
      $wsresponse[] = $billingdoc; 

      /*
       *
       * CASO O REGISTRO NÃO SEJA ENCONTRADO
       *   
       */
      if (empty($billingdoc['_dados'])) {
        $consults[$key]['error'] =  true;
        $consults[$key]['message'] = 'O boleto da parcela ' . $installment->installment . ' não foi encontrado.';
        continue;
      }

      $this->db->where(
        array(
          'id' => $installment->id
        )
      )
        ->update('invoiceinstallments', array(
          'billingdocbarcode' => $billingdoc['_dados'][0]['TituloLinhaDigitavel'],
          'billingdocsituation' => $billingdoc['_dados'][0]['situacao'],
          'billingdoccreated' => $billingdoc['_dados'][0]['situacao'] == 'REGISTRADO' ? 'T' : 'F',
          'updated' => time()
        ));

      $dir = FCPATH . 'uploads/boletos/NFe_' . substr($invoice[0]->fiscaldocaccesskey, 25, 9) . '/';
      $filename = 'NFe_' . substr($invoice[0]->fiscaldocaccesskey, 25, 9) . '_boleto_' . $installment->installment . '.pdf';
      $filepath = $dir . $filename;

      if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
      }

      $path = NULL;
      $billingdoc = file_get_contents($billingdoc['_dados'][0]['UrlBoleto']);
      $upload = file_put_contents($filepath, $billingdoc);

      // FALHA NO DOWNLOAD
      if (!$upload || !file_exists($filepath)) {
        $consults[$key]['error'] = true;
        $consults[$key]['message'] = 'Erro ao baixar o boleto da parcela ' . $installment->installment . '.';
        continue;
      }

      /*
       *
       * CASO EM AMBIENTE LOCAL, SOBE OS ARQUIVOS NA PASTA UPLOADS, E DEFINE O PATH COM BASE_URL
       *
       */
      if (in_array(ENVIRONMENT, array('development', 'dev'))) {
        $path = BASE_URL . '/uploads/boletos/NFe_' . substr($invoice[0]->fiscaldocaccesskey, 25, 9) . '/' . $filename;
        if (!$upload) {
          $consults[$key]['error'] = true;
          $consults[$key]['message'] = 'Erro ao baixar o boleto da parcela ' . $installment->installment . '.';
          continue;
        }
      }

      /*
       *
       * CASO EM AMBIENTE DE TESTE OU PRODUCAO, SOBE OS ARQUIVOS NO WASABI, E ARMAZENA O PATH RELATIVO
       *
       */
      if (in_array(ENVIRONMENT, array('production', 'testing'))) {
        $upload = upload_w3("invoices/boletos/NFe_" . substr($invoice[0]->fiscaldocaccesskey, 25, 9));
        $upload = upload_w3("invoices/boletos/NFe_" . substr($invoice[0]->fiscaldocaccesskey, 25, 9), $filepath, $filename);

        $path = "invoices/boletos/NFe_" . substr($invoice[0]->fiscaldocaccesskey, 25, 9) . '/' . $filename;

        if (!empty($upload['error'])) {
          $consults[$key]['error'] = true;
          $consults[$key]['message'] = 'Erro ao baixar o boleto da parcela ' . $installment->installment . '.';
          continue;
        }

        unlink($filepath);
      }

      if (file_exists($filepath) || empty($upload['error'])) {

        $billingdocsaved = $this->db->select('
            id,
            link,
            type,
            path
          ')
          ->where('link', $invoice[0]->id)
          ->where('path', $path)
          ->get('invoicedocs')
          ->result();

        if (count($billingdocsaved) == 0) {

          $id = uuidv4();
          $doc = [
            'id' => $id,
            'link' => $invoice[0]->id,
            'message' => NULL,
            'type' => 'BOLETO',
            'path' => $path,
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

        $consults[$key]['message'] = 'Boleto baixado com sucesso.';

      }

    }

    if (in_array(true, array_column($consults, 'error'))) {
      $message = implode('<br>', array_column($consults, 'message'));
      return json_encode(
        array(
          'error' => true,
          'message' => $message,
          'consult' => (object) $consults,
          'wsresponse' => (object) $wsresponse
        )
      );
    }

    return json_encode(
      array(
        'error' => false,
        'message' => 'Sucesso ao fazer o download dos boletos',
        'consult' => (object) $consults, 
        'wsresponse' => (object) $wsresponse
      )
    );
  }

  public function discard($invoice, $installment)
  {

    $invoice = $this->db->select('invoices.id, invoices.customerid, invoices.subsidiaryid, invoices.billaddressid, invoices.paymentmethodid, invoices.fiscaldocaccesskey')
      ->where('invoices.id', $invoice)
      ->get('invoices')
      ->result();

    $subsidiary = $this->db->select('subsidiaries.id, subsidiaries.title, subsidiaries.name, subsidiaries.legalname, subsidiaries.phone, subsidiaries.cnpj, subsidiaries.ie, subsidiaries.taxregime, taxregimes.title as taxregimetitle, taxregimes.code as taxregimecode, subsidiaries.hassimplesnacionalicms, subsidiaries.emailsuffix, addresses.street, addresses.number, addresses.zip, addresses.neighborhood, addresses.complement, addresses.city, addresses.state, addresses.country, addresses.standardbilling, addresses.standardshipping')
      ->join('taxregimes', 'taxregimes.id = subsidiaries.taxregime', 'LEFT')
      ->join('addresses', 'addresses.link = subsidiaries.id', 'LEFT')
      ->where('subsidiaries.id', $invoice[0]->subsidiaryid)
      ->where('addresses.standardbilling', 'T')
      ->get('subsidiaries')
      ->result();

    //TODO: pegar o numero de idintegracao e numero do documentodo boleto
    $installment = $this->db->select('invoiceinstallments.id, invoiceinstallments.tranid, invoiceinstallments.installment, invoiceinstallments.deadline, invoiceinstallments.percentage, invoiceinstallments.total')
      ->where('invoiceinstallments.id', $installment)
      ->get('invoiceinstallments')
      ->result();

    // $installment = array(
    //   (object) array(
    //     'integrationid' => 'UM4QPNJZK',
    //     'documentnumber' => '66c4947c9d5d2',
    //   ),
    //   (object) array(
    //     'integrationid' => '1IU93V57R',
    //     'documentnumber' => '66c4947c9d761',
    //   ),
    //   (object) array(
    //     'integrationid' => 'M8XIGUVH5',
    //     'documentnumber' => '66c4947c9d76b',
    //   ),
    // );

    foreach ($installment as $key => $value) {

      $data = array(
        'idintegracao' => $value->integrationid,
        'TituloNumeroDocumento' => $value->documentnumber,
      );

      $billingdoc = json_decode($this->getbillingdoc($data, preg_replace('/\D/', '', $subsidiary[0]->cnpj)), true);

      if (!!$billingdoc['_dados'] && in_array($billingdoc['_dados'][0]['situacao'], array('EMITIDO', 'FALHA', 'REJEITADO'))) {

        $integrationid = array($value->integrationid);

        $billingdoc = json_decode($this->discardbillingdoc(json_encode($integrationid), preg_replace('/\D/', '', $subsidiary[0]->cnpj)), true);

        if ($billingdoc['_dados']['_falha']) {
          return json_encode(
            array(
              'error' => true,
              'message' => 'Boleto ' . $value->integrationid . ' não encontrado.'
            )
          );
        }

        //TODO: ajustar mensagem de retorno do boleto descartado
        return json_encode(
          array(
            'error' => false,
            'message' => 'Boleto ' . $value->integrationid . ' descartado.'
          )
        );

      }

      return json_encode(
        array(
          'error' => true,
          'message' => 'Boleto ' . $value->integrationid . ' não encontrado.'
        )
      );

    }
  }

  public function update($invoice, $installment)
  {
    /*
     * ------------------------------------------------------------
     * UPDATE DE BOLETO
     * só funciona um tipo de alteracao de cada vez
     * nao é possível alterar o boleto via webservice no bradesco
     * ------------------------------------------------------------
     */


    $invoice = $this->db->select('invoices.id, invoices.customerid, invoices.subsidiaryid, invoices.billaddressid, invoices.paymentmethodid, invoices.fiscaldocaccesskey')
      ->where('invoices.id', $invoice)
      ->get('invoices')
      ->result();

    $subsidiary = $this->db->select('subsidiaries.id, subsidiaries.title, subsidiaries.name, subsidiaries.legalname, subsidiaries.phone, subsidiaries.cnpj, subsidiaries.ie, subsidiaries.taxregime, taxregimes.title as taxregimetitle, taxregimes.code as taxregimecode, subsidiaries.hassimplesnacionalicms, subsidiaries.emailsuffix, addresses.street, addresses.number, addresses.zip, addresses.neighborhood, addresses.complement, addresses.city, addresses.state, addresses.country, addresses.standardbilling, addresses.standardshipping')
      ->join('taxregimes', 'taxregimes.id = subsidiaries.taxregime', 'LEFT')
      ->join('addresses', 'addresses.link = subsidiaries.id', 'LEFT')
      ->where('subsidiaries.id', $invoice[0]->subsidiaryid)
      ->where('addresses.standardbilling', 'T')
      ->get('subsidiaries')
      ->result();

    // $installment = array(
    //   (object) array(
    //     'integrationid' => 'XTKKE6IC4',
    //     'updateprotocol' => 'Z094TEA69',
    //     'documentnumber' => '66bbc5c27e5a7',
    //     'deadline' => 1726316490,
    //     'total' => 100.00
    //   )
    // );

    // $installment = array(
    //   (object) array(
    //     'integrationid' => 'M8XIGUVH5',
    //     'documentnumber' => '66c4947c9d76b',
    //     'updateprotocol' => 'ENMIVC09X',
    //     'deadline' => 1732110212,
    //     'total' => 25.57
    //   ),
    // );

    foreach ($installment as $key => $value) {

      $billingdoc = array(
        /*
         * ------------------------------------------------------------
         * Tipo
         * Tipo da alteração que deseja gerar:
         * 0 - Alteração na data de vencimento. (TituloDataVencimento)
         * 1 - Alteração no valor do título. (TituloValor)
         * 2 - Conceder abatimento. (TituloValorAbatimento)
         * 3 - Cancelar abatimento concedido. (Nenhum campo)
         * 4 - Pedido protesto. (Nenhum campo)
         * 5 - Sustar protesto e baixar boleto. (Nenhum campo)
         * 6 - Sustar protesto e manter em carteira. (Nenhum campo)
         * 7 - Alteração de carteira. (TituloCarteira)
         * 8 - Incluir negativação.
         * 9 - Excluir negativação e manter carteira.
         * 10 - Excluir negativação e baixar titulo.
         * ------------------------------------------------------------
         */
        'Tipo' => '0',
        'Boletos' => array(
          array(
            /*
             * ------------------------------------------------------------
             * IdIntegracao
             * id de integração do boleto
             * ------------------------------------------------------------
             */
            'IdIntegracao' => $value->integrationid,
            /*
             * ------------------------------------------------------------
             * TituloDataVencimento
             * Deve ser informado uma data posterior a data de vencimento atual,
             * Nova data não deve ser maior que 5 anos que a data atual.
             * Deve ser informada no formato (DD/MM/YYYY).
             * ------------------------------------------------------------
             */
            'TituloDataVencimento' => date('d/m/Y', $value->deadline),
            /*
             * ------------------------------------------------------------
             * TituloValor
             * Campo onde deve ser informado um valor monetário para o boleto
             * Em homologação o valor deste campo fica limitado a R$ 100,00.
             * Em produção, esta limitação não ocorrerá.
             * ------------------------------------------------------------
             */
            'TituloValor' => in_array(ENVIRONMENT, array('development', 'dev', 'testing')) ? number_format(25, 2, ',', '') : number_format($value->total, 2, ',', ''),
          )
        )
      );

      $billingdocupdated = json_decode($this->updatebillingdoc(json_encode($billingdoc), preg_replace('/\D/', '', $subsidiary[0]->cnpj)), true);

      if (in_array($billingdocupdated['_status'], array('erro'))) {
        return json_encode(
          array(
            'error' => true,
            'message' => 'Boleto ' . $value->integrationid . ' ' . $billingdocupdated['_mensagem'],
            'data' => $billingdocupdated['_dados']
          )
        );
      }

      // TODO: inserir no banco o numero de protocolo de alteracao que a api devolveu para este boleto

      // TODO: fazer as devidas atualizacoes de valor e data de vencimento do boleto e tambem sobre o status da requisicao de alteracao
      // esta rota verifica o status da solicitacao pra saber e o boleto foi alterado ou nao
      // $this->getupdatedbillingdoc($value->updateprotocol, preg_replace('/\D/', '', $subsidiary[0]->cnpj));

      return json_encode(
        array(
          'error' => false,
          'message' => 'Boleto ' . $value->integrationid . ' ' . $billingdocupdated['_mensagem'],
          'data' => $billingdocupdated['_dados']
        )
      );
    }
  }

  public function drop($invoice, $installment)
  {
    $invoice = $this->db->select('invoices.id, invoices.customerid, invoices.subsidiaryid, invoices.billaddressid, invoices.paymentmethodid, invoices.fiscaldocaccesskey')
      ->where('invoices.id', $invoice)
      ->get('invoices')
      ->result();

    $subsidiary = $this->db->select('subsidiaries.id, subsidiaries.title, subsidiaries.name, subsidiaries.legalname, subsidiaries.phone, subsidiaries.cnpj, subsidiaries.ie, subsidiaries.taxregime, taxregimes.title as taxregimetitle, taxregimes.code as taxregimecode, subsidiaries.hassimplesnacionalicms, subsidiaries.emailsuffix, addresses.street, addresses.number, addresses.zip, addresses.neighborhood, addresses.complement, addresses.city, addresses.state, addresses.country, addresses.standardbilling, addresses.standardshipping')
      ->join('taxregimes', 'taxregimes.id = subsidiaries.taxregime', 'LEFT')
      ->join('addresses', 'addresses.link = subsidiaries.id', 'LEFT')
      ->where('subsidiaries.id', $invoice[0]->subsidiaryid)
      ->where('addresses.standardbilling', 'T')
      ->get('subsidiaries')
      ->result();

    //TODO: pegar o numero de idintegracao e numero do documentodo boleto
    $installment = $this->db->select('invoiceinstallments.id, invoiceinstallments.tranid, invoiceinstallments.installment, invoiceinstallments.deadline, invoiceinstallments.percentage, invoiceinstallments.total')
      ->where('invoiceinstallments.id', $installment)
      ->get('invoiceinstallments')
      ->result();

    // $installment = array(
    //   (object) array(
    //     'integrationid' => 'UM4QPNJZK',
    //     'documentnumber' => '66c4947c9d5d2',
    //   ),
    //   (object) array(
    //     'integrationid' => '1IU93V57R',
    //     'documentnumber' => '66c4947c9d761',
    //   ),
    //   (object) array(
    //     'integrationid' => 'M8XIGUVH5',
    //     'documentnumber' => '66c4947c9d76b',
    //     'protocolnumber' => '9EKOMWBXS',
    //   ),
    // );

    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'boletos/baixa/lote/' . $installment[0]->protocolnumber);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'cnpj-sh: ' . PLUGBOLETOS_CNPJ,
        'token-sh: ' . PLUGBOLETOS_TOKEN,
        'cnpj-cedente: ' . preg_replace('/\D/', '', $subsidiary[0]->cnpj),
      )
    );

    $response = curl_exec($ch);

    return $response;

    foreach ($installment as $key => $value) {

      $integrationid = array($value->integrationid);

      $billingdoc = json_decode($this->dropbillingdoc(json_encode($integrationid), preg_replace('/\D/', '', $subsidiary[0]->cnpj)), true);

      if (isset($billingdoc['_dados']['_erro'])) {
        return json_encode(
          array(
            'error' => true,
            'message' => 'Boleto ' . $value->integrationid . ' processamento não concluído.',
            'data' => $billingdoc['_dados']
          )
        );
      }

      // TODO: inserir no banco o numero de protocolo de baixa que a api devolveu para este boleto

      // TODO: fazer as devidas atualizacoes de baixa no boleto e tambem sobre o status da requisicao de baixa
      // esta rota verifica o status da solicitacao pra saber e o boleto foi alterado ou nao
      // $this->getdropedbillingdoc($value->dropprotocol, preg_replace('/\D/', '', $subsidiary[0]->cnpj));

      return json_encode(
        array(
          'error' => false,
          'message' => 'Boleto ' . $value->integrationid . ' processando a baixa.',
          'data' => $billingdoc['_dados']
        )
      );
    }
  }

  private function getjsonbillingdoc($subsidiary, $customer, $customerbilladdress, $installments, $account, $agreement, $fiscaldocnumber)
  {

    $SacadoNome = $customer[0]->legalname;

    if ($customer[0]->persontype == 'Física') {
      $SacadoNome = $customer[0]->name;
    }

    $billingdocs = array();

    foreach ($installments as $key => $installment) {

      $documentnumber = substr(uniqid(), 0, 15);

      $this->db->where('id', $installment->id)
        ->update('invoiceinstallments', array(
          'documentnumber' => $documentnumber,
          'updated' => time()
        ));

      // Campos referentes ao Sacado (responsável pelo pagamento do boleto)
      $json = array(
        /*
         * ------------------------------------------------------------
         * Campos referentes ao Sacado (responsável pelo pagamento do boleto)
         * ------------------------------------------------------------
         */


        /*
         * ------------------------------------------------------------
         * SacadoCPFCNPJ
         * Campo onde pode ser informado o CPF ou CNPJ do Sacado
         * Campo deve ser informado sem máscara
         * ------------------------------------------------------------
         */
        'SacadoCPFCNPJ' => preg_replace('/\D/', '', $customer[0]->document),
        /*
         * ------------------------------------------------------------
         * SacadoNome
         * Campo onde pode ser informado o nome do Sacado
         * ------------------------------------------------------------
         */
        'SacadoNome' => substr($SacadoNome, 0, 200),
        /*
         * ------------------------------------------------------------
         * SacadoEnderecoLogradouro
         * Campo onde pode ser informado o logradouro do Sacado
         * ------------------------------------------------------------
         */
        'SacadoEnderecoLogradouro' => substr($customerbilladdress[0]->street, 0, 200),
        /*
         * ------------------------------------------------------------
         * SacadoEnderecoNumero
         * Campo onde pode ser informada o numero da residência do Sacado
         * ------------------------------------------------------------
         */
        'SacadoEnderecoNumero' => substr($customerbilladdress[0]->number, 0, 20),
        /*
         * ------------------------------------------------------------
         * SacadoEnderecoBairro
         * Campo onde pode ser informado o bairro do Sacado
         * ------------------------------------------------------------
         */
        'SacadoEnderecoBairro' => substr($customerbilladdress[0]->neighborhood, 0, 100),
        /*
         * ------------------------------------------------------------
         * SacadoEnderecoCep
         * Campo onde pode ser informado o CEP do Sacado
         * ------------------------------------------------------------
         */
        'SacadoEnderecoCep' => substr(preg_replace('/\D/', '', $customerbilladdress[0]->zip), 0, 8),
        /*
         * ------------------------------------------------------------
         * SacadoEnderecoCidade
         * Campo onde pode ser informada a cidade do Sacado
         * ------------------------------------------------------------
         */
        'SacadoEnderecoCidade' => substr($customerbilladdress[0]->city, 0, 50),
        /*
         * ------------------------------------------------------------
         * SacadoEnderecoComplemento
         * Campo onde pode ser informado o complemento do endereço do Sacado
         * ------------------------------------------------------------
         */
        'SacadoEnderecoComplemento' => substr($customerbilladdress[0]->complement, 0, 100),
        /*
         * ------------------------------------------------------------
         * SacadoEnderecoPais
         * Campo onde pode ser informado o complemento do endereço do Sacado
         * ------------------------------------------------------------
         */
        'SacadoEnderecoPais' => substr($customerbilladdress[0]->country, 0, 50),
        /*
         * ------------------------------------------------------------
         * SacadoEnderecoUf
         * Campo onde pode ser informada a sigla do estado onde reside o Sacado
         * ------------------------------------------------------------
         */
        'SacadoEnderecoUf' => substr($customerbilladdress[0]->state, 0, 2),
        /*
         * ------------------------------------------------------------
         * SacadoEmail
         * Campo onde pode ser informado o e-mail do Sacado, para informar mais de um e-mail basta utilizar o ponto e virgula (;).
         * ------------------------------------------------------------
         */
        'SacadoEmail' => substr($customer[0]->email, 0, 500),
        /*
         * ------------------------------------------------------------
         * SacadoTelefone
         * Campo onde pode ser informado o e-mail do Sacado, para informar mais de um e-mail basta utilizar o ponto e virgula (;).
         * ------------------------------------------------------------
         */
        'SacadoTelefone' => substr(preg_replace('/\D/', '', $customer[0]->phone), 0, 20),
        /*
         * ------------------------------------------------------------
         * SacadoCelular
         * Campo onde pode ser informado o celular Sacado
         * ------------------------------------------------------------
         */
        'SacadoCelular' => substr('', 0, 20),

        /*
         * ------------------------------------------------------------
         * Campos para referenciar a conta/convênio do Cedente (responsável pela emissão do boleto)
         * ------------------------------------------------------------
         */

        /*
         * ------------------------------------------------------------
         * CedenteContaCodigoBanco
         * Campo onde deve ser informado o código  do banco (de acordo com a FEBRABAN) responsável pela cobrança
         * Campo deve ser cadastrado antes da inclusão
         * ------------------------------------------------------------
         */
        'CedenteContaCodigoBanco' => substr($account['_dados'][0]['codigo_banco'], 0, 10),
        /*
         * ------------------------------------------------------------
         * CedenteContaNumero
         * Campo onde deve ser informado o numero da conta do Cedente
         * Campo deve ser cadastrado antes da inclusão
         * ------------------------------------------------------------
         */
        'CedenteContaNumero' => substr($account['_dados'][0]['conta'], 0, 20),
        /*
         * ------------------------------------------------------------
         * CedenteContaNumeroDV
         * Campo onde deve ser informado o DV da conta do Cedente
         * Campo deve ser cadastrado antes da inclusão
         * ------------------------------------------------------------
         */
        'CedenteContaNumeroDV' => substr($account['_dados'][0]['conta_dv'], 0, 10),
        /*
         * ------------------------------------------------------------
         * CedenteConvenioNumero
         * Campo onde deve ser informado o número do convenio da Conta do Cedente
         * Campo deve ser cadastrado antes da inclusão
         * ------------------------------------------------------------
         */
        'CedenteConvenioNumero' => substr($agreement['_dados'][0]['numero_convenio'], 0, 20),
        /*
         * ------------------------------------------------------------
         * CedenteConvenioCarteira
         * Campo onde deve ser informado a carteira do convenio da Conta do Cedente (Esse campo é opcional)
         * Campo deve ser cadastrado antes da inclusão
         * ------------------------------------------------------------
         */
        'CedenteConvenioCarteira' => substr($agreement['_dados'][0]['carteira'], 0, 20),

        /*
         * ------------------------------------------------------------
         * Campos básicos de Inclusão
         * ------------------------------------------------------------
         */

        /*
         * ------------------------------------------------------------
         * TituloNossoNumero
         * Campo onde deve ser informado um valor (preferencialmente sequencial) único.
         * Deve ser informado apenas o sequencial, o valor para o banco será calculado automaticamente.
         * Alguns bancos exigem que seja sequencial, verifique com o gerente da conta qual o último nosso número emitido e continue a sequencia.
         * ------------------------------------------------------------
         */
        'TituloNossoNumero' => !!$agreement['_dados'][0]['nossonumero_controle_banco'] ? null : $fiscaldocnumber . $installment->installment,
        /*
         * ------------------------------------------------------------
         * TituloValor
         * Campo onde deve ser informado um valor monetário para o boleto
         * Em homologação o valor deste campo fica limitado a R$ 100,00.
         * Em produção, esta limitação não ocorrerá.
         * ------------------------------------------------------------
         */
        'TituloValor' => in_array(ENVIRONMENT, array('development', 'dev', 'testing')) ? number_format(10, 2, ',', '') : number_format($installment->total, 2, ',', ''),
        /*
         * ------------------------------------------------------------
         * TituloNumeroDocumento
         * Campo onde pode ser informado um valor para controle interno.
         * TODO: salvar no banco de dados este valor para futura verificação de pagamento
         * ------------------------------------------------------------
         */
        'TituloNumeroDocumento' => $documentnumber,
        /*
         * ------------------------------------------------------------
         * TituloDataEmissao
         * Campo onde deve ser informado a data da emissão do boleto. Formato DD/MM/YYYY
         * ------------------------------------------------------------
         */
        'TituloDataEmissao' => date('d/m/Y'),
        /*
         * ------------------------------------------------------------
         * TituloDataVencimento
         * Campo onde deve ser informado a data de vencimento do boleto. Formato DD/MM/YYYY
         * ------------------------------------------------------------
         */
        'TituloDataVencimento' => date('d/m/Y', $installment->deadline),
        /*
         * ------------------------------------------------------------
         * TituloAceite
         * Indica se o pagador (quem recebeu o boleto) aceitou o boleto, ou seja, se ele autorizou, assinou o documento de cobrança que originou o boleto.
         * Valores aceitos:
         * N - Não aceito
         * S - Aceito.
         * Para o banco Itaú (v1), informar N ou não enviar o TituloAceite caracteriza o título como Boleto Proposta.
         * ------------------------------------------------------------
         */
        'TituloAceite' => 'N',
        /*
         * ------------------------------------------------------------
         * TituloDocEspecie
         * Valores aceitos:
         * 01	DM	Duplicata Mercantil
         * 02	NP	Nota promissória
         * 03	NS	Nota de seguro
         * 04	DS	Duplicata de Serviço
         * 05	REC	Recibo
         * 06	LC	Letra de Câmbio (Apenas para a caixa)
         * 07	ND	Nota de Débito
         * 08	BDP	Boleto de Proposta
         * 09	LC	Letra de Câmbio
         * 10	WR	Warrant
         * 11	CH	Cheque
         * 12	CS	Cobrança Seriada
         * 13	ME	Mensalidade escolar
         * 14	AS	Apólice de Seguro
         * 15	DD	Documento de Dívida
         * 16	EC	Encargos Condominiais
         * 17	CPS	Conta de prestação de serviço
         * 18	CT	Contrato
         * 19	CS	Cosseguro
         * 20	DR	Duplicata Rural
         * 21	NPR	Nota Promissória Rural
         * 22	--	Dívida Ativa da União
         * 23	--	Dívida Ativa de Estado
         * 24	--	Dívida Ativa de Município
         * 25	DMI	Duplicata Mercantil por Indicação
         * 26	DSI	Duplicata de Serviço por Indicação
         * 27	NCC	Nota de Crédito Comercial
         * 28	NCE	Nota de Crédito para Exportação
         * 29	NCI	Nota de Crédito Industrial
         * 30	NCR	Nota de Crédito Rural
         * 32	TM	Triplicata Mercantil
         * 33	TS	Triplicata de Serviço
         * 34	FAT	Fatura
         * 35	PC	Parcela de Consórcio
         * 36	NF	Nota Fiscal
         * 37	CPR	Cédula de Produto Rural
         * 38	CC	Cartão de crédito
         * 39	AD	Títulos de Terceiros
         * 40	BDA	Boleto de Depósito e Aporte
         * 41	CBI	Cédula de Crédito Bancário por Indicação
         * 42	CC	Contrato de Câmbio
         * 43	CCB	Cédula de Crédito Bancário
         * 44	CD	Confissão de Dívida
         * 45	CM	Contrato de Mútuo
         * 46	RA	Recibo de Aluguel (PJ)
         * 47	TA	Termo de acordo
         * 99	DV	Outros
         * ------------------------------------------------------------
         */
        'TituloDocEspecie' => '01',
        /*
         * ------------------------------------------------------------
         * TituloLocalPagamento
         * Informar o local do pagamento.
         * TODO: Implementar o módulo de local de pagamento
         * ------------------------------------------------------------
         */
        'TituloLocalPagamento' => substr('PAGÁVEL EM QUALQUER BANCO ATÉ O VENCIMENTO', 0, 200),

        /*
         * ------------------------------------------------------------
         * Campos de Desconto
         * TODO: Implementar o módulo de descontos
         * ------------------------------------------------------------
         */

        /*
         * ------------------------------------------------------------
         * TituloCodDesconto
         * Campo onde pode ser informado o código para aplicar um determinado desconto.
         * Códigos disponíveis:
         * 0 - Sem instrução de desconto.
         * 1 - Valor Fixo Até a Data Informada.
         * 2 - Percentual Até a Data Informada.
         * 3 - Valor por Antecipação Dia Corrido.
         * 4 - Valor por Antecipação Dia Útil.
         * 5 - Percentual Sobre o Valor Nominal Dia Corrido.
         * 6 - Percentual Sobre o Valor Nominal Dia Útil.
         * 7 - Cancelamento de Desconto.
         * ------------------------------------------------------------
         */
        // 'TituloCodDesconto' => ,
        /*
         * ------------------------------------------------------------
         * TituloDataDesconto
         * Campo onde pode ser informada a data limite para conceder um determinado desconto. Formato DD/MM/YYYY
         * ------------------------------------------------------------
         */
        // 'TituloDataDesconto' => ,
        /*
         * ------------------------------------------------------------
         * TituloValorDescontoTaxa
         * Campo onde pode ser informado o valor de um determinado desconto
         * Valor irá sair na remessa, para ser descontado automaticamente.
         * ------------------------------------------------------------
         */
        // 'TituloValorDescontoTaxa' => ,
        /*
         * ------------------------------------------------------------
         * TituloValorDesconto
         * Informe o mesmo valor do TituloValorDescontoTaxa, apenas se desejar visualizá-lo o campo de desconto no boleto em PDF.
         * Valor irá sair na remessa, para ser descontado automaticamente.
         * ------------------------------------------------------------
         */
        // 'TituloValorDesconto' => ,
        /*
         * ------------------------------------------------------------
         * TituloCodDesconto2
         * Campo onde pode ser informado o código para aplicar no segundo desconto.
         * Informar o mesmo valor informado no campo TituloCodDesconto
         * ------------------------------------------------------------
         */
        // 'TituloCodDesconto2' => ,
        /*
         * ------------------------------------------------------------
         * TituloDataDesconto2
         * Campo onde pode ser informada a data limite para conceder o segundo desconto. Formato DD/MM/YYYY
         * ------------------------------------------------------------
         */
        // 'TituloDataDesconto2' => ,
        /*
         * ------------------------------------------------------------
         * TituloValorDescontoTaxa2
         * Campo onde pode ser informado o valor do segundo desconto
         * Valor irá sair na remessa, para ser descontado automaticamente
         * ------------------------------------------------------------
         */
        // 'TituloValorDescontoTaxa2' => ,

        /*
         * ------------------------------------------------------------
         * Campos de Juros
         * TODO: Implementar o módulo de juros
         * ------------------------------------------------------------
         */

        /*
         * ------------------------------------------------------------
         * TituloCodigoJuros
         * Campo onde pode ser informado o código para aplicar um determinado juros.
         * Códigos disponíveis:
         * 1 - Valor por dia.
         * 2 - Taxa mensal.
         * 3 - Isento.
         * Alguns bancos possuem instruções específicas, antes de prosseguir verifique as particularidades do seu banco.
         * Exceto para o banco Sicredi CNAB400 onde é cobrado uma porcentagem diária.
         * ------------------------------------------------------------
         */
        'TituloCodigoJuros' => 2,
        /*
         * ------------------------------------------------------------
         * TituloDataJuros
         * Campo onde pode ser informada a data de inicio para cobrar um determinado valor de juros/mora. Formato DD/MM/YYYY
         * ------------------------------------------------------------
         */
        'TituloDataJuros' => date('d/m/Y', ($installment->deadline + 86400)),
        /*
         * ------------------------------------------------------------
         * TituloValorJuros
         * Campo onde pode ser informado o valor/taxa de um determinado juros/mora.
         * Valor irá sair na remessa, para ser calculado automaticamente, quando for pago.
         * Para o banco ABC, ao informar TituloCodigoJuros= 2, preencher com 4 casas decimais
         * ------------------------------------------------------------
         */
        'TituloValorJuros' => number_format(5, 2, ',', ''),

        /*
         * ------------------------------------------------------------
         * Campos de Multa
         * TODO: Implementar o módulo de multa
         * ------------------------------------------------------------
         */

        /*
         * ------------------------------------------------------------
         * TituloCodigoMulta
         * Campo onde pode ser informado o código para aplicar uma determinada Multa.
         * Códigos disponíveis:
         * 0 - Não registra a multa.
         * 1 - Valor em Reais (Fixo).
         * 2 - Valor em percentual com duas casas decimais.
         * ------------------------------------------------------------
         */
        // 'TituloCodigoMulta' => ,
        /*
         * ------------------------------------------------------------
         * TituloDataMulta
         * Campo onde pode ser informada a data que deve ser cobrada uma determinada Multa. Formato DD/MM/YYYY
         * ------------------------------------------------------------
         */
        // 'TituloDataMulta' => ,
        /*
         * ------------------------------------------------------------
         * TituloValorMultaTaxa
         * Campo onde pode ser informado o valor/taxa de uma determinada multa.
         * Valor irá sair na remessa, para ser calculado automaticamente, quando for pago.
         * Para o banco ABC, ao informar TituloCodigoMulta = 2, preencher com 4 casas decimais (Ex: 2,0000).
         * Para o banco C6, informar números inteiros de tamanho 1-2 posições (Ex: 2 ou 02 para representar 2%).
         * ------------------------------------------------------------
         */
        // 'TituloValorMultaTaxa' => ,

        /*
         * ------------------------------------------------------------
         * Campos de Protesto Automático
         * TODO: Implementar o módulo de protesto automático
         * ------------------------------------------------------------
         */

        /*
         * ------------------------------------------------------------
         * TituloCodProtesto
         * Campo onde pode ser informado o código para aplicar um determinado protesto.
         * Códigos disponíveis:
         * 1 - Protestar Dias Corridos.
         * 2 - Protestar Dias Úteis.
         * 3 - Não Protestar.
         * 4 - Protestar Fim Falimentar - Dias Úteis.
         * 5 - Protestar Fim Falimentar - Dias Corridos.
         * 8 - Negativação sem Protesto.
         * 9 - Cancelamento Protesto Automático (somente válido p/ Código Movimento Remessa = 31).
         * ------------------------------------------------------------
         */
        // 'TituloCodProtesto' => ,
        /*
         * ------------------------------------------------------------
         * TituloPrazoProtesto
         * Campo onde pode ser informada a quantidade de dias após o vencimento para realizar o protesto automático.
         * ------------------------------------------------------------
         */
        // 'TituloPrazoProtesto' => ,

        /*
         * ------------------------------------------------------------
         * Campos de Baixa Automática
         * TODO: Implementar o módulo de baixa automática
         * ------------------------------------------------------------
         */

        /*
         * ------------------------------------------------------------
         * TituloCodBaixaDevolucao
         * Campo onde pode ser informado o código para aplicar uma determinada baixa.
         * Códigos disponíveis:
         * 1 - Baixar/Devolver.
         * 2 - Não baixar / Não devolver.
         * 3 - Cancelar prazo para baixa / Devolução.
         * ------------------------------------------------------------
         */
        // 'TituloCodBaixaDevolucao' => ,
        /*
         * ------------------------------------------------------------
         * TituloPrazoBaixa
         * Campo onde pode ser informada a quantidade de dias após o vencimento para realizar a baixa automática.
         * ------------------------------------------------------------
         */
        // 'TituloPrazoBaixa' => ,

        /*
         * ------------------------------------------------------------
         * Campos de Mensagens
         * TODO: Implementar o módulo de mensagens
         * ------------------------------------------------------------
         */

        /*
         * ------------------------------------------------------------
         * TituloMensagem01
         * Campo onde pode ser informada uma mensagem para ser adicionada ao boleto.
         * ------------------------------------------------------------
         */
        'TituloMensagem01' => substr('TÍTULO SUJEITO A PROTESTO APÓS 3 DIAS DO VENCIMENTO', 0, 80),
        /*
         * ------------------------------------------------------------
         * TituloMensagem02
         * Campo onde pode ser informada uma mensagem para ser adicionada ao boleto.
         * ------------------------------------------------------------
         */
        // 'TituloMensagem02' => substr('', 0, 80),
      );

      array_push($billingdocs, $json);

    }
    return $billingdocs;
  }

  private function getdropedbillingdoc($billingdocprotocol, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'boletos/baixa/lote/' . $billingdocprotocol);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'cnpj-sh: ' . PLUGBOLETOS_CNPJ,
        'token-sh: ' . PLUGBOLETOS_TOKEN,
        'cnpj-cedente: ' . $cnpj,
      )
    );

    $response = curl_exec($ch);

    return $response;
  }

  private function dropbillingdoc($billingdoc, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'boletos/baixa/lote');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'cnpj-sh: ' . PLUGBOLETOS_CNPJ,
        'token-sh: ' . PLUGBOLETOS_TOKEN,
        'cnpj-cedente: ' . $cnpj,
      )
    );

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $billingdoc);

    $response = curl_exec($ch);

    return $response;
  }

  private function getupdatedbillingdoc($billingdocprotocol, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'boletos/altera/lote/' . $billingdocprotocol);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'cnpj-sh: ' . PLUGBOLETOS_CNPJ,
        'token-sh: ' . PLUGBOLETOS_TOKEN,
        'cnpj-cedente: ' . $cnpj,
      )
    );

    $response = curl_exec($ch);

    return $response;
  }

  private function updatebillingdoc($billingdoc, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'boletos/altera/lote');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'cnpj-sh: ' . PLUGBOLETOS_CNPJ,
        'token-sh: ' . PLUGBOLETOS_TOKEN,
        'cnpj-cedente: ' . $cnpj,
      )
    );

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $billingdoc);

    $response = curl_exec($ch);

    return $response;
  }

  private function discardbillingdoc($billingdocid, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'boletos/descarta/lote');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'cnpj-sh: ' . PLUGBOLETOS_CNPJ,
        'token-sh: ' . PLUGBOLETOS_TOKEN,
        'cnpj-cedente: ' . $cnpj,
      )
    );

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $billingdocid);

    $response = curl_exec($ch);

    return $response;
  }

  private function getbillingdoc($billingdoc, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'boletos?' . http_build_query($billingdoc));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'cnpj-sh: ' . PLUGBOLETOS_CNPJ,
        'token-sh: ' . PLUGBOLETOS_TOKEN,
        'cnpj-cedente: ' . $cnpj,
      )
    );

    $response = curl_exec($ch);

    return $response;
  }

  private function createbillingdoc($billingdocs, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'boletos/lote');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'cnpj-sh: ' . PLUGBOLETOS_CNPJ,
        'token-sh: ' . PLUGBOLETOS_TOKEN,
        'cnpj-cedente: ' . $cnpj,
      )
    );

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $billingdocs);

    $response = curl_exec($ch);

    return $response;
  }

  private function getaccount($account, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'cedentes/contas?' . http_build_query($account));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'cnpj-sh: ' . PLUGBOLETOS_CNPJ,
        'token-sh: ' . PLUGBOLETOS_TOKEN,
        'cnpj-cedente: ' . $cnpj,
      )
    );

    $response = curl_exec($ch);

    return $response;
  }

  private function getagreement($agreement, $cnpj)
  {

    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'cedentes/contas/convenios?' . http_build_query($agreement));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'cnpj-sh: ' . PLUGBOLETOS_CNPJ,
        'token-sh: ' . PLUGBOLETOS_TOKEN,
        'cnpj-cedente: ' . $cnpj,
      )
    );

    $response = curl_exec($ch);

    return $response;
  }

}
