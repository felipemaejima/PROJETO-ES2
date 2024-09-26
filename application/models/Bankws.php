<?php
defined('BASEPATH') or exit('No direct script access allowed');

// referencias 
// $account = array(
//       (object) array(
//         'id' => 'teste',
//         'link' => $subsidiary[0]->id,
//         'bankname' => 'Banco Bradesco S.A.',
//         'bankcode' => '237',
//         'accounttypeid' => 'teste',
//         'accounttypename' => 'CORRENTE',
//         'accountnumber' => '109',
//         'accountnumberdv' => '0',
//         'agency' => '2770',
//         'agencydv' => '',
//         'pix' => '',
//         'beneficiarycode' => '109',
//         'companycode' => '5767154',
//         'paymentagreement' => '',
//         // 'accountws' => '24651',
//         'accountws' => '',
//         'paymentid' => 'i1GqEqBZg6',
//       )
//     );

//     $account = array(
//       (object) array(
//         'id' => 'teste',
//         'link' => $subsidiary[0]->id,
//         'bankname' => 'Banco Bradesco S.A.',
//         'bankcode' => '237',
//         'accounttypeid' => 'teste',
//         'accounttypename' => 'CORRENTE',
//         'accountnumber' => '109',
//         'accountnumberdv' => '0',
//         'agency' => '2770',
//         'agencydv' => '',
//         'pix' => '',
//         'beneficiarycode' => '109',
//         'companycode' => '5767154',
//         'paymentagreement' => '',
//         'accountws' => '24651',
//         'paymentid' => 'i1GqEqBZg6',
//       )
//     );


    // $agreement = array(
    //   'id' => 'teste',
    //   'link' => $account[0]->id,
    //   'agreementintegrationid' => '',
    //   'agreementnumber' => '110',
    //   'agreementdescription' => 'Banco Bradesco S.A.',
    //   'agreementwallet' => '09',
    //   'walletcode' => null,
    //   'agreementcurrency' => 'R$',
    //   'agreementdefaultcnab' => '400',
    //   'agreementdailyrestart' => 'F',
    //   'agreementshippingnumber' => '9',
    //   'accountws' => $account[0]->accountws,
    //   'agreementdensityshipping' => null,
    //   'agreementinstantregistration' => 'F',
    //   'agreementapiid' => null,
    //   'agreementapikey' => null,
    //   'agreementapisecret' => null,
    //   'agreementstation' => null,
    //   'agreementourbanknumber' => null,
    //   'agreementourbankreconciliationnumber' => null,
    //   'agreementwebservicetype' => null,
    //   'agreementconsultationwebservice' => 'T',
    //   'agreementcontractnumber' => null,
    //   'agreementfilelayoutversion' => null,
    //   'agreementwebservicechange' => 'F',
    // );

// id mogiglass
// $assignor = 'b740d052-d1b6-5515-8973-329c40d87185';
// id TESTE
// $assignor = '0107851b-30e1-f1bb-0992-ddeed956ea04';

class Bankws extends CI_Model
{

  public function assignor(string $assignorid)
  {
    $subsidiary = $this->db->select('subsidiaries.id, subsidiaries.title, subsidiaries.name, subsidiaries.legalname, subsidiaries.phone, subsidiaries.cnpj, subsidiaries.ie, subsidiaries.taxregime, taxregimes.title as taxregimetitle, taxregimes.code as taxregimecode, subsidiaries.hassimplesnacionalicms, subsidiaries.emailsuffix, addresses.street, addresses.number, addresses.zip, addresses.neighborhood, addresses.complement, addresses.city, addresses.citycode, addresses.state, addresses.country, addresses.standardbilling, addresses.standardshipping')
      ->join('taxregimes', 'taxregimes.id = subsidiaries.taxregime', 'LEFT')
      ->join('addresses', 'addresses.link = subsidiaries.id', 'LEFT')
      ->where('subsidiaries.id', $assignorid)
      ->where('addresses.standardbilling', 'T')
      ->get('subsidiaries')
      ->result();

    if (count($subsidiary) == 0) {
      return json_encode([
        'error' => TRUE,
        'message' => 'Subsidiária não encontrada.',
      ]);
    } 

    $data = array(
      'cpf_cnpj' => clear_string($subsidiary[0]->cnpj),
    );

    $assignor = json_decode($this->getassignor($data), true);

    $assignorid = !empty($assignor['_dados'][0]['id']) ? $assignor['_dados'][0]['id'] : NULL;

    if (!$subsidiary[0]->citycode){
      $city = $this->db->select('id, code')
      ->where('state', strtoupper($subsidiary[0]->state))
      ->where('name', mb_strtolower($subsidiary[0]->city))
      ->or_where('title', mb_strtoupper($subsidiary[0]->city))
      ->get('cities')
      ->result()[0] ?? '3530607';
  
      $subsidiary[0]->citycode = $city->code;
    }

    $data = array(
      'CedenteRazaoSocial' => $subsidiary[0]->legalname,
      'CedenteNomeFantasia' => $subsidiary[0]->title,
      'CedenteEnderecoLogradouro' => mb_strtoupper($subsidiary[0]->street),
      'CedenteEnderecoNumero' => $subsidiary[0]->number,
      'CedenteEnderecoComplemento' => mb_strtoupper($subsidiary[0]->complement),
      'CedenteEnderecoBairro' => mb_strtoupper($subsidiary[0]->neighborhood),
      'CedenteEnderecoCEP' => clear_string($subsidiary[0]->zip),
      'CedenteEnderecoCidadeIBGE' => $subsidiary[0]->citycode,
      'CedenteTelefone' => clear_string($subsidiary[0]->phone),
      'CedenteEmail' => 'martinho' . $subsidiary[0]->emailsuffix,
    );
    $cnpj = clear_string($subsidiary[0]->cnpj);

    if (!$assignorid) {
      $data['CedenteCPFCNPJ'] = $cnpj;
      return $this->createassignor(json_encode($data));
    }

    return $this->editassignor($assignorid, json_encode($data), $cnpj);
  }

  public function account(string $assignorid, object $account)
  {

    $subsidiary = $this->db->select('id, cnpj')
      ->where('subsidiaries.id', $assignorid)
      ->get('subsidiaries')
      ->result();

      if (count($subsidiary) == 0) { 
        return json_encode([
          'error' => TRUE,
          'message' => 'Subsidiária não encontrada.',
        ]);
      } 

      $data = array(
        'ContaCodigoBanco' => $account->bankcode,
        'ContaAgencia' => $account->agency,
        'ContaAgenciaDV' => $account->agencydv,
        'ContaNumero' => $account->accountnumber,
        'ContaNumeroDV' => $account->accountnumberdv,
        'ContaTipo' => $account->accounttypename,
        'ContaCodigoBeneficiario' => $account->beneficiarycode,
        'ContaCodigoEmpresa' => $account->companycode,
        // campos adicionais (por enquanto, não utilizados)
        // 'ContaValidacaoAtiva' => '', // boolean
        // 'ContaImpressaoAtualizada' => '', // boolean
        // 'ContaImpressaoAtualizadaAlteracao' => '', // boolean
        // 'ContaImpressaoAtualizadaLiquidado' => '', // boolean
      );

      $cnpj = clear_string($subsidiary[0]->cnpj);

      if (!$account->accountws) {
        $account = $this->createaccount(json_encode($data), $cnpj);

        // TODO: cadastrar em nosso banco de dados o paymentid código alfanumerico de 10 digitos para identificar o pagamento EX: i1GqEqBZg6

        return $account;
    }

    $account = $this->editaccount($account->accountws, json_encode($data), $cnpj);

    return $account;

  }

  public function agreement(string $accountid, object $agreement)
  {
    $account = $this->db->select('*')  
      ->where('id', $accountid)
      ->where('isinactive', 'F')
      ->get('accounts')
      ->result();

    if (count($account) == 0) { 
      return json_encode([
        'error' => TRUE,
        'message' => 'Conta não encontrada.',
      ]);
    }   

    $subsidiary = $this->db->select('id, cnpj')
      ->where('subsidiaries.id', $account[0]->link)
      ->get('subsidiaries')
      ->result();

      if (count($subsidiary) == 0) { 
        return json_encode([
          'error' => TRUE,
          'message' => 'Subsidiária não encontrada.',
        ]);
      } 
    
    $data = array(
      'ConvenioNumero' => $agreement->agreementnumber,
      'ConvenioDescricao' => $agreement->agreementdescription,
      'ConvenioCarteira' => $agreement->agreementwallet,
      'carteira_codigo' => $agreement->walletcode,
      'ConvenioEspecie' => $this->translatecurrency($agreement->agreementcurrency),
      'ConvenioPadraoCNAB' => $agreement->agreementdefaultcnab,
      'ConvenioReiniciarDiariamente' => $agreement->agreementdailyrestart == 'T' ? TRUE : FALSE,
      'ConvenioNumeroRemessa' => $agreement->agreementshippingnumber,
      'Conta' => $agreement->accountws,
      // 'ConvenioDensidaDeRemessa' => $agreement[0]->agreementdensityshipping,
      'ConvenioRegistroInstantaneo' => $agreement->agreementinstantregistration == 'T' ? TRUE : FALSE,

      // os 3 campos abaixo são obrigatórios quando o campo ConvenioRegistroInstantaneo acima for TRUE
      // 'ConvenioApiId' => $agreement[0]->agreementapiid,
      // 'ConvenioApiKey' => $agreement[0]->agreementapikey,
      // 'ConvenioApiSecret' => $agreement[0]->agreementapisecret,
      
      // 'ConvenioEstacao' => $agreement[0]->agreementstation,
      // 'ConvenioNossoNumeroBanco' => $agreement[0]->agreementourbanknumber,
      // 'ConvenioNossoNumeroConciliarBanco' => $agreement[0]->agreementourbankreconciliationnumber,
      // 'Conveniotipowebservice' => $agreement[0]->agreementwebservicetype,
      'ConvenioConsultaws' => $agreement->agreementconsultationwebservice == 'T' ? TRUE : FALSE,
      // 'ConvenioNumeroContrato' => $agreement[0]->agreementcontractnumber,
      // 'ConvenioVersaoLayoutArquivo' => $agreement[0]->agreementfilelayoutversion,
      'ConvenioAlteracaoWebservice' => $agreement->agreementwebservicechange == 'T' ? TRUE : FALSE,
    );

    $cnpj = clear_string($subsidiary[0]->cnpj);
    if (!$agreement->agreementws) {

      $agreement = $this->createagreement(json_encode($data), $cnpj);

      return $agreement;
    }

    $agreement = $this->editagreement($agreement->agreementws, json_encode($data), $cnpj);

    return $agreement;

  }

  private function translatecurrency(string $currency)      
  {
    // converte apenas as moedas aceitas pelo webservice (falta incluir IGPM)
    switch ($currency) {
      case 'BRL':
        return 'R$';
      case 'USD':
        return 'US$';
      default:
        return FALSE;
    }
  }

  private function createagreement($agreement, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'cedentes/contas/convenios');
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
    curl_setopt($ch, CURLOPT_POSTFIELDS, $agreement);

    $response = curl_exec($ch);

    return $response;
  }

  private function editagreement($agreementid, $data, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'cedentes/contas/convenios/' . $agreementid);
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
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

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

  private function createaccount($account, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'cedentes/contas');
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
    curl_setopt($ch, CURLOPT_POSTFIELDS, $account);

    $response = curl_exec($ch);

    return $response;
  }

  private function editaccount($accountid, $data, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'cedentes/contas/' . $accountid);
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
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

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

  private function createassignor($assignor)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'cedentes');
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
        'token-sh: ' . PLUGBOLETOS_TOKEN
      )
    );

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $assignor);

    $response = curl_exec($ch);

    return $response;
  }

  
  private function editassignor($assignorid, $data, $cnpj)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'cedentes/' . $assignorid);
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
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);

    return $response;
  }

  private function getassignor($assignor)
  {
    $ch = curl_init(PLUGBOLETOS_ENDPOINT . 'cedentes?' . http_build_query($assignor));
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
        'token-sh: ' . PLUGBOLETOS_TOKEN
      )
    );

    $response = curl_exec($ch);

    return $response;
  }
}
