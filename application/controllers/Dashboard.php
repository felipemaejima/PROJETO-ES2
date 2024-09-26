<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();

    // Libraries
    $this->load->library('encryption');
    $this->load->library('user_agent');

    // Models
    $this->load->model('billingdoc');

    if (!check_session('session_token')) {
      redirect(base_url('login'), 'refresh');
    }

    set_time_limit(0);
    ini_set('max_execution_time', 0);
    ini_set('memory_limit', '512M');

  }

  public function index()
  {
    // $filepath = FCPATH . 'uploads/clientes.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 1000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);


    // echo '<pre>';
    // foreach ($data as $key => $value) {

    //   $ieexempt = 'F';

    //   if ($value['imune'] == 'F' && ($value['isento'] == 'T' || $value['isentoava'] == 'T')) {
    //     $ieexempt = 'T';
    //   }

    //   $activitysector = $this->db->select('id, name, title')
    //     ->where('title', $value['setordeatividade'])
    //     ->get('activitysectors')
    //     ->result();

    //   if (count($activitysector) == 0) {
    //     $activitysector = $this->db->select('id, name, title')
    //       ->where('title', $value['setoratividadeava'])
    //       ->get('activitysectors')
    //       ->result();
    //   }



    //   $preferredvoltage = null;

    //   if ($value['voltagem'] == '220V') {
    //     $preferredvoltage = 'ca0b87fa-1dba-66f0-eb57-5576f1456448';
    //   }

    //   if ($value['voltagem'] == '127V') {
    //     $preferredvoltage = 'b1f9676d-6a70-4c02-f2a0-90b95ee9d49e';
    //   }


    //   $update = array(
    //     'mei' => ($value['empreendedorindividual'] == 'T' || $value['empreendedorindividualava'] == 'T') ? 'T' : 'F',
    //     'simplesnacional' => ($value['simplesnacional'] == 'T' || $value['simplesnacionalava'] == 'T') ? 'T' : 'F',
    //     'ieexempt' => $ieexempt,
    //     'icmstaxpayer' => ($value['contribuinteicms'] == 'T' || $value['contribuinteicmsava'] == 'T') ? 'T' : 'F',
    //     'ieimmune' => ($value['imune'] == 'T') ? 'T' : 'F',
    //     'publicentityexempticms' => ($value['orgaopublicoisento'] == 'T') ? 'T' : 'F',
    //     'activitysector' => !!$activitysector ? $activitysector[0]->id : '415d28a3-1962-9af7-ac80-09221524e598',
    //     'preferredvoltage' => $preferredvoltage,
    //     'suframa' => $value['suframa'] ? $value['suframa'] : null,
    //   );

    //   $entitie = $this->db->select('id')
    //     ->where('externalid', $value['IDinterno'])
    //     ->get('entities')
    //     ->result();

    //   if (count($entitie) > 0) {
    //     $this->db->where(array('externalid' => $value['IDinterno']))
    //       ->update('entities', $update);
    //   }
    // }
    // return;

    // $entities = $this->db->select('id, paymentweek, comments, defaultaddress')
    //   ->get('entities')
    //   ->result();

    // foreach ($entities as $key => $entity) {

    //   $this->db->where('id', $entity->id)
    //     ->update('entities', array(
    //       'comments' => str_replace('<br>', PHP_EOL, $entity->comments),
    //       'defaultaddress' => str_replace('<br>', PHP_EOL, $entity->defaultaddress)
    //     ));
    // }
    // return;

    // $users = $this->db->select('id, name, salutation, email, comments, document, defaultaddress')
    //   ->get('users')
    //   ->result();

    // foreach ($users as $key => $user) {

    //   $partes = explode(' ', $user->name);
    //   $primeiroNome = $partes[0];
    //   $ultimoNome = end($partes);
    //   $sigla = mb_strtoupper($primeiroNome[0] . $ultimoNome[0], 'UTF-8');

    //   $this->db->where('id', $user->id)
    //     ->update('users', array(
    //       'name' => mb_strtoupper($user->name, 'UTF-8'),
    //       'initials' => $sigla,
    //       'comments' => str_replace('<br>', PHP_EOL, $user->comments),
    //       'defaultaddress' => str_replace('<br>', PHP_EOL, $user->defaultaddress),
    //       'email' => mb_strtolower($user->email, 'UTF-8'),
    //       'document' => preg_replace('/\D/', '', $user->document),
    //       'title' => null
    //     ));
    // }
    // return;

    // $filepath = FCPATH . 'uploads/users.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 1000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);


    // echo '<pre>';
    // foreach ($data as $key => $value) {
    //   print_r($value);

    //   $created = DateTime::createFromFormat('d/m/Y H:i', $value['Data']);
    //   $this->db->where('externalid', $value['IDinterno'])
    //     ->update('users', array(
    //       'created' => $created->getTimestamp(),
    //     ));
    // }
    // return;

    // $filepath = FCPATH . 'uploads/enderecoClientes.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 1000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);


    // echo '<pre>';
    // foreach ($data as $key => $value) {

    //   $link = $this->db->select('id, name, legalname')
    //     ->where('externalid', $value['ID interno'])
    //     ->get('entities')
    //     ->result();

    //   if (count($link) > 0) {
    //     print_r($link);


    //     if (!!$value['cidade'] && !!$value['cep']) {


    //       $addressfield = mb_strtoupper($value['rua'], 'UTF-8') . ', ' . mb_strtoupper($value['numero'], 'UTF-8') . ' ' . mb_strtoupper($value['complemento'], 'UTF-8') . PHP_EOL . mb_strtoupper($value['bairro'], 'UTF-8') . ' - ' . mb_strtoupper($value['cidade'], 'UTF-8') . ' - ' . mb_strtoupper($value['uf'], 'UTF-8') . PHP_EOL . 'CEP: ' . preg_replace('/\D/', '', $value['cep']);

    //       $citycode = $this->db->select('id, title, code, state')
    //         ->where('title', mb_strtoupper($value['cidade'], 'UTF-8'))
    //         ->get('cities')
    //         ->result();

    //       $address = array(
    //         'id' => uuidv4(),
    //         'zip' => preg_replace('/\D/', '', $value['cep']),
    //         'country' => mb_strtoupper($value['pais'], 'UTF-8'),
    //         'countrycode' => $value['pais'] == 'Brasil' ? '1058' : '',
    //         'street' => mb_strtoupper($value['rua'], 'UTF-8'),
    //         'number' => mb_strtoupper($value['numero'], 'UTF-8'),
    //         'complement' => mb_strtoupper($value['complemento'], 'UTF-8'),
    //         'neighborhood' => mb_strtoupper($value['bairro'], 'UTF-8'),
    //         'city' => mb_strtoupper($value['cidade'], 'UTF-8'),
    //         'citycode' => $citycode[0]->code,
    //         'state' => mb_strtoupper($value['uf'], 'UTF-8'),
    //         'standardshipping' => $value['entrega'] == 'T' ? 'T' : 'F',
    //         'standardbilling' => $value['fatura'] == 'T' ? 'T' : 'F',
    //         'address' => $addressfield,
    //         'isinactive' => 'F',
    //         'confirmed' => 'T',
    //         'link' => $link[0]->id,
    //         'ip' => $this->input->ip_address(),
    //         'platform' => $this->agent->platform(),
    //         'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
    //         'referer' => $this->agent->referrer(),
    //         'created' => time()
    //       );

    //       $checkaddress = $this->db->select('id')
    //         ->where(array(
    //           'zip' => preg_replace('/\D/', '', $value['cep']),
    //           'street' => mb_strtoupper($value['rua'], 'UTF-8'),
    //           'number' => mb_strtoupper($value['numero'], 'UTF-8')
    //         ))
    //         ->get('addresses')
    //         ->result();
    //       if(count($checkaddress) == 0) {
    //         $this->db->insert('addresses', $address);
    //       }
    //       print_r($value);
    //       print_r($address);
    //     }
    //   }
    // }
    // return;

    // $entities = $this->db->select('id, defaultaddress')
    //   ->get('entities')
    //   ->result();
    // foreach ($entities as $entity) {
    //   $this->db->where(array('id' => $entity->id))
    //     ->update('entities', array(
    //       'defaultaddress' => mb_strtoupper($entity->defaultaddress, 'UTF-8')
    //     ));
    // }
    // return;

    // $filepath = FCPATH . 'uploads/parcelamento.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 1000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);


    // echo '<pre>';


    // foreach ($data as $key => $value) {

    //   $term = array(
    //     'id' => uuidv4(),
    //     'externalid' => preg_replace('/\D/', '', $value['IDinterno']),
    //     'name' => mb_strtoupper($value['Nome'], 'UTF-8'),
    //     'installments' => preg_replace('/\D/', '', $value['Quantidadedeparcelas']),
    //     'timeqty' => preg_replace('/\D/', '', $value['Quantidadedetempo']),
    //     'leadtime' => preg_replace('/\D/', '', $value['Carencia']),
    //     'isinactive' => 'F',
    //     'confirmed' => 'T',
    //     'ip' => $this->input->ip_address(),
    //     'platform' => $this->agent->platform(),
    //     'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
    //     'referer' => $this->agent->referrer(),
    //     'created' => time()
    //   );

    //   print_r($term);

    //   $this->db->insert('terms', $term);

    // }
    // return;

    // $filepath = FCPATH . 'uploads/contatos.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 1000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);


    // echo '<pre>';
    // foreach ($data as $key => $value) {

    //   $link = $this->db->select('id, name, legalname')
    //     ->where('externalid', $value['idempresa'])
    //     ->get('entities')
    //     ->result();

    //   if (count($link) > 0) {
    //     $realitionship = array(
    //       'id' => uuidv4(),
    //       'externalid' => preg_replace('/\D/', '', $value['idinterno']),
    //       'name' => mb_strtoupper($value['nome'], 'UTF-8'),
    //       'link' => $link[0]->id,
    //       'email' => mb_strtolower($value['email'], 'UTF-8'),
    //       'phone' => preg_replace('/\D/', '', $value['telefone']),
    //       'title' => mb_strtoupper($value['cargo'], 'UTF-8'),
    //       'sendinvoice' => $value['envianf'] == 'Sim' ? 'T' : 'F',
    //       'sendbilling' => $value['enviaboleto'] == 'Sim' ? 'T' : 'F',
    //       'isinactive' => 'F',
    //       'confirmed' => 'T',
    //       'ip' => $this->input->ip_address(),
    //       'platform' => $this->agent->platform(),
    //       'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
    //       'referer' => $this->agent->referrer(),
    //       'created' => time()
    //     );
    //     $this->db->insert('relationships', $realitionship);
    //   }
    // }
    // return;

    // $realitionships = $this->db->select('id, phone')
    //   ->get('relationships')
    //   ->result();

    // foreach ($realitionships as $key => $relationship) {
    //   $phone = preg_replace('/\D/', '', $relationship->phone);

    //   if (strlen($phone) === 10) {
    //     $phone = '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 4) . '-' . substr($phone, 6);
    //   } elseif (strlen($phone) === 11) {
    //     $phone = '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 5) . '-' . substr($phone, 7);
    //   }

    //   $this->db->where(array('id' => $relationship->id))
    //     ->update('relationships', array(
    //       'phone' => $phone
    //     ));
    // }
    // return;

    // $filepath = FCPATH . 'uploads/controlequimicos.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 1000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);


    // echo '<pre>';
    // foreach ($data as $key => $value) {
    //   if ($value['ncm'] && $value['idcliente']) {


    //     $ncm = $this->db->select('id, name, description')
    //       ->where('name', preg_replace('/\D/', '', $value['ncm']))
    //       ->get('ncms')
    //       ->result();

    //     $link = $this->db->select('id, name, legalname')
    //       ->where('externalid', $value['idcliente'])
    //       ->get('entities')
    //       ->result();

    //     $entity = array(
    //       'federalpolicelicense' => $value['licencapf'] ? $value['licencapf'] : null,
    //       'datefederalpolicelicense' => $value['datapf'] ? stringtotimestamp($value['datapf']) : null,
    //       'civilpolicelicense' => $value['licencapc'] ? $value['licencapc'] : null,
    //       'datecivilpolicelicense' => $value['datapc'] ? stringtotimestamp($value['datapc']) : null,
    //       'armylicense' => $value['licencae'] ? $value['licencae'] : null,
    //       'datearmylicense' => $value['datae'] ? stringtotimestamp($value['datae']) : null,
    //     );

    //     $licensecontrol = array(
    //       'id' => uuidv4(),
    //       'ncmreferer' => $ncm[0]->id,
    //       'ncm' => $ncm[0]->name,
    //       'link' => $link[0]->id,
    //       'description' => $ncm[0]->description,
    //       'iscontrolledcivilpolice' => $value['licencapc'] ? 'T' : 'F',
    //       'iscontrolledfederalpolice' => $value['licencapf'] ? 'T' : 'F',
    //       'iscontrolledarmy' => $value['licencae'] ? 'T' : 'F',
    //       'permissionsfederalpolice' => $value['licencapf'] ? '["d6c04b7f-bf80-3e17-7691-3754dfe7ee7e"]' : null,
    //       'permissionsarmy' => $value['licencae'] ? '["d7692c21-53aa-0bb4-1f4d-7c143d7dc688"]' : null,
    //       'isinactive' => 'F',
    //       'confirmed' => 'T',
    //       'ip' => $this->input->ip_address(),
    //       'platform' => $this->agent->platform(),
    //       'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
    //       'referer' => $this->agent->referrer(),
    //       'created' => time()
    //     );

    //     $this->db->insert('licensecontrol', $licensecontrol);

    //     $this->db->where(array('id' => $link[0]->id))
    //       ->update('entities', $entity);

    //     print_r($value);
    //     print_r($licensecontrol);
    //     print_r($entity);
    //   }
    // }
    // return;

    // $items = $this->db->select('id, externalid, name, subsidiaries, conversionfactorunit')
    //   ->where('iscontrolledfederalpolice ', 'T')
    //   ->get('items')
    //   ->result();

    // foreach ($items as $item) {

    // $item->subsidiaries = '["mogiglass"]';

    // if (strpos($item->name, ' 25G') !== false || strpos($item->name, ' 25ML') !== false) {
    //   $item->conversionfactorunit = 0.025;
    // }
    // if (strpos($item->name, ' 50G') !== false || strpos($item->name, ' 50ML') !== false) {
    //   $item->conversionfactorunit = 0.050;
    // }
    // if (strpos($item->name, ' 100G') !== false || strpos($item->name, ' 100ML') !== false) {
    //   $item->conversionfactorunit = 0.1;
    // }
    // if (strpos($item->name, ' 125G') !== false || strpos($item->name, ' 125ML') !== false) {
    //   $item->conversionfactorunit = 0.125;
    // }
    // if (strpos($item->name, ' 250G') !== false || strpos($item->name, ' 250ML') !== false) {
    //   $item->conversionfactorunit = 0.25;
    // }
    // if (strpos($item->name, ' 500G') !== false || strpos($item->name, ' 500ML') !== false) {
    //   $item->conversionfactorunit = 0.5;
    // }
    // if (strpos($item->name, ' 1000G') !== false || strpos($item->name, ' 1000ML') !== false) {
    //   $item->conversionfactorunit = 1;
    // }
    // if (strpos($item->name, ' 2,5LITROS') !== false || strpos($item->name, ' 2,5 LITROS') !== false || strpos($item->name, ' 2500ML') !== false) {
    //   $item->conversionfactorunit = 2.5;
    // }
    // if (strpos($item->name, ' 4000G') !== false || strpos($item->name, ' 4000ML') !== false || strpos($item->name, ' 4,0LITROS') !== false || strpos($item->name, ' 4,0 LITROS') !== false) {
    //   $item->conversionfactorunit = 4;
    // }
    // if (strpos($item->name, ' 5000G') !== false || strpos($item->name, ' 5000ML') !== false) {
    //   $item->conversionfactorunit = 5;
    // }
    // if (strpos($item->name, ' 18000G') !== false || strpos($item->name, ' 18000ML') !== false || strpos($item->name, ' 18KG') !== false || strpos($item->name, ' C/18KG') !== false) {
    //   $item->conversionfactorunit = 18;
    // }
    // if (strpos($item->name, ' 20000G') !== false || strpos($item->name, ' 20000ML') !== false || strpos($item->name, ' 20KG') !== false || strpos($item->name, ' C/20KG') !== false || strpos($item->name, ' 20 LITROS') !== false || strpos($item->name, ' 20 L') !== false) {
    //   $item->conversionfactorunit = 20;
    // }
    // if (strpos($item->name, ' 23000G') !== false || strpos($item->name, ' 23000ML') !== false || strpos($item->name, ' 23 KG') !== false || strpos($item->name, ' C/23KG') !== false || strpos($item->name, ' 23KG') !== false || strpos($item->name, ' 23 L') !== false) {
    //   $item->conversionfactorunit = 23;
    // }
    // if (strpos($item->name, ' 25000G') !== false || strpos($item->name, ' 25000ML') !== false || strpos($item->name, ' 25 KG') !== false || strpos($item->name, ' C/25KG') !== false || strpos($item->name, ' 25KG') !== false || strpos($item->name, ' 25 L') !== false) {
    //   $item->conversionfactorunit = 25;
    // }
    // if (strpos($item->name, ' 30000G') !== false || strpos($item->name, ' 30000ML') !== false || strpos($item->name, ' 30 KG') !== false || strpos($item->name, ' C/30KG') !== false || strpos($item->name, ' 30KG') !== false || strpos($item->name, ' 30 L') !== false) {
    //   $item->conversionfactorunit = 30;
    // }
    // if (strpos($item->name, ' 35000G') !== false || strpos($item->name, ' 35000ML') !== false || strpos($item->name, ' 35 KG') !== false || strpos($item->name, ' C/35KG') !== false || strpos($item->name, ' 35KG') !== false || strpos($item->name, ' 35 L') !== false) {
    //   $item->conversionfactorunit = 35;
    // }
    // if (strpos($item->name, ' 50KG') !== false || strpos($item->name, ' 50000G') !== false || strpos($item->name, ' 50000ML') !== false || strpos($item->name, ' 50LITROS') !== false) {
    //   $item->conversionfactorunit = 50;
    // }
    // if (strpos($item->name, ' 60KG') !== false || strpos($item->name, ' 60000G') !== false || strpos($item->name, ' 60000ML') !== false || strpos($item->name, ' 60 KG') !== false) {
    //   $item->conversionfactorunit = 60;
    // }
    // if (strpos($item->name, ' 70KG') !== false || strpos($item->name, ' 70000G') !== false || strpos($item->name, ' 70000ML') !== false || strpos($item->name, ' 70 KG') !== false) {
    //   $item->conversionfactorunit = 70;
    // }
    // if (strpos($item->name, ' 75KG') !== false || strpos($item->name, ' 75000G') !== false || strpos($item->name, ' 75000ML') !== false || strpos($item->name, ' 75 KG') !== false) {
    //   $item->conversionfactorunit = 75;
    // }
    // if (strpos($item->name, ' 200KG') !== false || strpos($item->name, ' 200000G') !== false || strpos($item->name, ' 200000ML') !== false || strpos($item->name, ' 200 KG') !== false || strpos($item->name, ' 200 LITROS') !== false || strpos($item->name, ' 200 L') !== false) {
    //   $item->conversionfactorunit = 200;
    // }

    //   $itemname = $this->db->select('id, externalid, name')
    //     ->where('externalid', $item->externalid)
    //     ->get('items')
    //     ->result();

    //   $data = array(
    //     'name' => $itemname[0]->name,
    //   );

    //   $this->db->where(array('externalid' => $item->externalid))
    //     ->update('itemscagado', $data);

    // }

    // header('Content-Type: application/json; charset=UTF-8');
    // return;

    // $filepath = FCPATH . 'uploads/faturas-chaves.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 2000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);

    // $freights = array(
    //   '0' => array(
    //     'id' => '3633cb44-9f97-c906-a98c-210c391cd042',
    //     'title' => '0 - Por conta do emitente'
    //   ),
    //   '1' => array(
    //     'id' => 'a1df3875-ce20-f00d-545b-4022a0f30614',
    //     'title' => '1 - Por conta do destinatário'
    //   ),
    //   '2' => array(
    //     'id' => 'f8d056f7-de89-3d93-ea66-71cb6b6f7ed8',
    //     'title' => '2 - Por conta de terceiros'
    //   ),
    //   '3' => array(
    //     'id' => 'e9a4a1ec-300e-0a5d-af15-8e05b98782ca',
    //     'title' => '3 - Transporte próprio por conta do remetente'
    //   ),
    //   '4' => array(
    //     'id' => 'cfae26f8-a6c5-b736-e786-ad6496f900e4',
    //     'title' => '4 - Transporte próprio por conta do destinatário'
    //   ),
    //   '9' => array(
    //     'id' => 'c519ebdf-6ce9-754d-2a70-8dfca9b3b537',
    //     'title' => '9 - Sem Frete'
    //   ),
    // );

    // $operationtypes = array(
    //   '21' => array(
    //     "id" => "323edb9c-8568-e43d-4e33-abae353ce4df",
    //     "title" => "RETORNO DE DEMONSTRAÇÃO",
    //     "name" => "Retorno de Demonstração",
    //     "code" => "21"
    //   ),
    //   '10' => array(
    //     "id" => "3df4b5de-d6d4-5147-9349-00205abecb4a",
    //     "title" => "VENDA SIMPLES NACIONAL",
    //     "name" => "Venda Simples Nacional",
    //     "code" => "10"
    //   ),
    //   '19' => array(
    //     "id" => "4b016e16-b3b9-83a2-4204-ec67906e0090",
    //     "title" => "SIMPLES REMESSA (ENTRADA)",
    //     "name" => "Simples Remessa (Entrada)",
    //     "code" => "19"
    //   ),
    //   '17' => array(
    //     "id" => "4b8d310a-9304-48ec-2cee-5003ee2f2253",
    //     "title" => "REMESSA PARA DOAÇÃO",
    //     "name" => "Remessa para Doação",
    //     "code" => "17"
    //   ),
    //   '16' => array(
    //     "id" => "4c3350f7-afa2-dc47-5feb-0f981677f358",
    //     "title" => "NOTA DE DÉBITO",
    //     "name" => "Nota de Débito",
    //     "code" => "16"
    //   ),
    //   '8' => array(
    //     "id" => "54c2eddb-c57e-f69c-9e54-5c874c5dfd86",
    //     "title" => "REMESSA VENDA ENTREGA FUTURA C\/IMPOSTO",
    //     "name" => "Remessa Venda Entrega Futura C\/Imposto",
    //     "code" => "8"
    //   ),
    //   '4' => array(
    //     "id" => "59c56a72-afce-76c0-7f56-186cc3ae94ba",
    //     "title" => "REMESSA PARA CONSERTO",
    //     "name" => "Remessa para Conserto",
    //     "code" => "4"
    //   ),
    //   '18' => array(
    //     "id" => "5a542b75-7cff-debd-30a6-91292a51a015",
    //     "title" => "NOTA FISCAL DE SERVIÇO",
    //     "name" => "Nota Fiscal de Serviço",
    //     "code" => "18"
    //   ),
    //   '14' => array(
    //     "id" => "60a626d0-950e-6351-f23b-4839b83f1c63",
    //     "title" => "DEVOLUÇÃO DE VENDA (ENTRADA)",
    //     "name" => "Devolução de Venda (Entrada)",
    //     "code" => "14"
    //   ),
    //   '9' => array(
    //     "id" => "6af5c0c7-24a9-c7cf-86c1-1eb08e3ee37f",
    //     "title" => "RETORNO DE CONSERTO",
    //     "name" => "Retorno de Conserto",
    //     "code" => "9"
    //   ),
    //   '15' => array(
    //     "id" => "8555977f-7095-bb4e-840b-39313a55b7bb",
    //     "title" => "VENDA SIMPLES NACIONAL (CLIENTE C\/ IE)",
    //     "name" => "Venda Simples Nacional (Cliente C\/ IE)",
    //     "code" => "15"
    //   ),
    //   '2' => array(
    //     "id" => "8aee8372-bc26-d134-6488-ead225159d06",
    //     "title" => "VENDA CLIENTE INSCRIÇÃO ESTADUAL IMUNE",
    //     "name" => "Venda Cliente Inscrição Estadual Imune",
    //     "code" => "2"
    //   ),
    //   '13' => array(
    //     "id" => "91f122ac-6a8e-5643-6246-9dc3cf893f47",
    //     "title" => "VENDA ENTREGA FUTURA SIMPLES NACIONAL",
    //     "name" => "Venda Entrega Futura Simples Nacional",
    //     "code" => "13"
    //   ),
    //   '1' => array(
    //     "id" => "93d975f3-3f87-3b2b-7e9c-80f25c2aef48",
    //     "title" => "VENDA DE PRODUTOS NF-E",
    //     "name" => "Venda de Produtos NF-e",
    //     "code" => "1"
    //   ),
    //   '3' => array(
    //     "id" => "956fb4cb-1525-cea8-d0a3-c059c096b229",
    //     "title" => "VENDA ENTREGA FUTURA (MOGIGLASS)",
    //     "name" => "Venda Entrega Futura (Mogiglass)",
    //     "code" => "3"
    //   ),
    //   '26' => array(
    //     "id" => "a29139c0-0134-964b-fc83-fbb3ff5f47c3",
    //     "title" => "DEVOLUÇÃO DE COMPRA",
    //     "name" => "Devolução de Compra",
    //     "code" => "26"
    //   ),
    //   '20' => array(
    //     "id" => "b429f9b3-9130-18ff-89b4-1b5dbbf0b7c4",
    //     "title" => "REMESSA PARA EXPOSIÇÃO\/FEIRA",
    //     "name" => "Remessa para Exposição\/Feira",
    //     "code" => "20"
    //   ),
    //   '11' => array(
    //     "id" => "b7c8e270-87a9-4684-0d73-49ef438ce30f",
    //     "title" => "REMESSA SIMPLES - SEM IMPOSTO",
    //     "name" => "Remessa Simples - Sem Imposto",
    //     "code" => "11"
    //   ),
    //   '5' => array(
    //     "id" => "d164a44f-a24a-a2e7-f4e2-b5bb3e17956d",
    //     "title" => "REMESSA PARA INDUSTRIALIZAÇÃO",
    //     "name" => "Remessa para Industrialização",
    //     "code" => "5"
    //   ),
    //   '22' => array(
    //     "id" => "d3955a53-9d8d-289e-90b8-c886ca0facdd",
    //     "title" => "RETORNO DE EXPOSIÇÃO\/FEIRA (ENTRADA)",
    //     "name" => "Retorno de Exposição\/Feira (Entrada)",
    //     "code" => "22"
    //   ),
    //   '24' => array(
    //     "id" => "da89f2b9-37b0-5095-2183-3b7e3ef061b2",
    //     "title" => "RETORNO DE CONSERTO (ENTRADA)",
    //     "name" => "Retorno de Conserto (Entrada)",
    //     "code" => "24"
    //   ),
    //   '7' => array(
    //     "id" => "df921437-3f49-b835-db06-d2f9825837e4",
    //     "title" => "REMESSA PARA CONSERTO (ENTRADA)",
    //     "name" => "Remessa para Conserto (Entrada)",
    //     "code" => "7"
    //   ),
    //   '12' => array(
    //     "id" => "e0683c40-f764-f807-6835-85befb8add51",
    //     "title" => "REMESSA PARA DEMONSTRAÇÃO",
    //     "name" => "Remessa para Demonstração",
    //     "code" => "12"
    //   ),
    //   '23' => array(
    //     "id" => "e5210009-f9bd-413a-ec4e-7b6155d49599",
    //     "title" => "NF COMPLEMENTAR",
    //     "name" => "NF Complementar",
    //     "code" => "23"
    //   ),
    //   '6' => array(
    //     "id" => "ea4cc0ab-2788-f772-a1c5-ad239dd173d8",
    //     "title" => "RETORNO DE DEMONSTRAÇÃO (ENTRADA)",
    //     "name" => "Retorno de Demonstração (Entrada)",
    //     "code" => "6"
    //   ),
    //   '25' => array(
    //     "id" => "ed443582-f9f2-ca4c-a33c-9532de868481",
    //     "title" => "REMESSA PARA TROCA",
    //     "name" => "Remessa para Troca",
    //     "code" => "25"
    //   )
    // );

    // $operationtypesava = array(
    //   'DEVOLUÇAO DE COMPRA (SAIDA)' => 26,
    //   'DEVOLUÇAO DE COMPRA (SAIDA - SIMPLES NACIONAL)' => 26,
    //   'DEVOLUÇÃO DE VENDA' => null,
    //   'DEVOLUÇÃO DE VENDA (ENTRADA)' => 14,
    //   'DEVOLUÇAO (ENTRADA)' => 14,
    //   'DEVOLUÇAO (SAIDA)' => 26,
    //   '(ENTRADA) RETORNO DE CONSERTO' => 9,
    //   '(ENTRADA) SIMPLES REMESSA' => 19,
    //   'NF COMPLEMENTAR DE ICMS' => 23,
    //   'NOTA DE DEBITO' => 16,
    //   'NOTA FISCAL COMPLEMENTAR DE ICMS' => 23,
    //   'REMESSA DE BONIFICAÇÃO, DOAÇÃO, BRINDE' => 17,
    //   'REMESSA EXPOSIÇÃO/FEIRA' => 20,
    //   'REMESSA PARA CONSERTO' => 4,
    //   'REMESSA PARA CONSERTO (ENTRADA)' => 7,
    //   'REMESSA PARA DEMONSTRAÇÃO' => 12,
    //   'REMESSA PARA TROCA (COM IMPOSTO)' => 25,
    //   'REMESSA P/TROCA (COM IMPOSTO) -ENTRADA' => null,
    //   'REMESSA SIMPLES - SEM IMPOSTO' => 11,
    //   'REMESSA VENDA ENTREGA FUTURA (MOGIGLASS) C/IMPOSTO' => 3,
    //   'REMESSA VENDA ENTREGA FUTURA (SIMPLES NACIONAL)' => 13,
    //   'RETORNO DE CONSERTO' => 9,
    //   'RETORNO DE CONSERTO (ENTRADA)' => 24,
    //   'RETORNO DE CONSERTO OU REPARO' => 9,
    //   'RETORNO DE DEMONSTRAÇÃO' => 21,
    //   'RETORNO DE DEMONSTRAÇÃO (ENTRADA)' => 6,
    //   'RETORNO DE DEMONSTRAÇÃO (SAIDA)' => 21,
    //   'RETORNO DE EXPOSIÇAO/FEIRA' => 22,
    //   'SIMPLES REMESSA - SEM IMPOSTO' => 11,
    //   'VENDA DE PRODUTOS' => 1,
    //   'VENDA ENTREGA FUTURA (MOGIGLASS)' => 8,
    //   'VENDA ENTREGA FUTURA (M2W/WEBLABOR/MCIENTIFICA)' => 13,
    //   'VENDA SIMPLES NACIONAL (NAO CONTRIBUINTE)' => 10,
    // );

    // $operationtypescpb = array(
    //   'VENDA DE PRODUTOS NF-e' => 1,
    //   'VENDA CLIENTE INSCRIÇÃO ESTADUAL IMUNE' => 2,
    //   'VENDA ENTREGA FUTURA (MOGIGLASS)' => 3,
    //   'REMESSA PARA CONSERTO' => 4,
    //   'REMESSA PARA INDUSTRIALIZAÇÃO' => 5,
    //   'RETORNO DE DEMONSTRAÇÃO (ENTRADA)' => 6,
    //   'REMESSA PARA CONSERTO (ENTRADA)' => 7,
    //   'REMESSA VENDA ENTREGA FUTURA C/IMPOSTO' => 8,
    //   'RETORNO DE CONSERTO' => 9,
    //   'VENDA SIMPLES NACIONAL' => 10,
    //   'REMESSA SIMPLES - SEM IMPOSTO' => 11,
    //   'REMESSA PARA DEMONSTRAÇÃO' => 12,
    //   'VENDA ENTREGA FUTURA SIMPLES NACIONAL' => 13,
    //   'DEVOLUÇÃO DE VENDA (ENTRADA)' => 14,
    //   'VENDA SIMPLES NACIONAL (CLIENTE C/ IE)' => 15,
    //   'NOTA DE DÉBITO' => 16,
    //   'REMESSA PARA DOAÇÃO' => 17,
    //   'NOTA FISCAL DE SERVIÇO' => 18,
    //   'SIMPLES REMESSA (ENTRADA)' => 19,
    //   'REMESSA PARA EXPOSIÇÃO/FEIRA' => 20,
    //   'RETORNO DE DEMONSTRAÇÃO' => 21,
    //   'RETORNO DE EXPOSIÇAO/FEIRA (ENTRADA)' => 22,
    //   'NF COMPLEMENTAR' => 23,
    //   'RETORNO DE CONSERTO (ENTRADA)' => 24,
    //   'REMESSA PARA TROCA' => 25,
    //   'DEVOLUÇÃO DE COMPRA' => 26,
    // );


    // echo '<pre>';

    // foreach ($data as $key => $value) {
    //   $fiscaldocaccesskey = $value['chave de acesso 1'] ? $value['chave de acesso 1'] : $value['chave de acesso 2'];
    //   $fiscaldocdate = $value['data do documento 1'] ? strtotime(implode('-', array_reverse(explode('/', $value['data do documento 1'])))) : strtotime(implode('-', array_reverse(explode('/', $value['data do documento 2']))));
    //   $fiscaldocnumber = $value['NFe 1'] ? (int) $value['NFe 1'] : (int) $value['NFe 2'];
    //   $freight = $value['tipo de frete 2'] ? explode(' ', $value['tipo de frete 2'])[0] : explode(' ', $value['tipo de frete 1'])[0];


    //   $invoice = array(
    //     'fiscaldocaccesskey' => $fiscaldocaccesskey,
    //     'deadline' => strtotime($value['entregar ate']),
    //     'fiscaldocdate' => $fiscaldocdate,
    //     'fiscaldocnumber' => $fiscaldocnumber,
    //     'freighttypeid' => $freights[$freight]['id'],
    //     'freighttypename' => $freights[$freight]['title'],
    //     'operationtypeid' => $value['chave de acesso 1'] ? $operationtypes[$operationtypesava[$value['tipo de operacao 1']]]['id'] : $operationtypes[$operationtypescpb[$value['tipo de operacao 2']]]['id'],
    //     'operationtypename' => $value['chave de acesso 1'] ? $operationtypes[$operationtypesava[$value['tipo de operacao 1']]]['name'] : $operationtypes[$operationtypescpb[$value['tipo de operacao 2']]]['name'],
    //     'volumesquantity' => $value['quantidade de volume 1'] ? $value['quantidade de volume 1'] : $value['quantidade de volume 2'],
    //     'volumetype' => $value['tipo de volume 1'] ? $value['tipo de volume 1'] : $value['tipo de volume 2'],
    //     'grossweight' => $value['peso bruto 1'] ? $value['peso bruto 1'] : $value['peso bruto 2'],
    //     'netweight' => $value['peso liquido 1'] ? $value['peso liquido 1'] : $value['peso liquido 2'],
    //     'createdfrom' => $value['id criado de'],
    //     'customerpurchaseorder' => $value['ped compra cliente'] ? $value['ped compra cliente'] : null,
    //     'trafficguide' => $value['gruia de trafego'] ? $value['gruia de trafego'] : null,
    //   );

    //   $this->db->where(array('externalid' => $value['ID interno']))
    //     ->update('invoices', $invoice);
    // }
    // return;

    // echo '<pre>';

    // $invoices = $this->db->select('id, shippingaddress, billaddress, comments, additionalinformation')
    //   ->get('invoices')
    //   ->result();

    // foreach ($invoices as $key => $value) {
    //   $invoice = array(
    //     'shippingaddress' => str_replace('<br>', PHP_EOL, $value->shippingaddress),
    //     'billaddress' => str_replace('<br>', PHP_EOL, $value->billaddress),
    //     'comments' => str_replace('<br>', PHP_EOL, $value->comments),
    //     'additionalinformation' => str_replace('<br>', PHP_EOL, $value->additionalinformation)
    //   );

    //   $this->db->where(array('id' => $value->id))
    //     ->update('invoices', $invoice);
    // }

    // return;

    // UPDATE invoiceitems i
    // JOIN items it ON i.itemid = it.id
    // SET
    //     i.ischemical = it.ischemical,
    //     i.iscontrolledcivilpolice = it.iscontrolledcivilpolice,
    //     i.iscontrolledfederalpolice = it.iscontrolledfederalpolice,
    //     i.iscontrolledarmy = it.iscontrolledarmy,
    //     i.concentration = it.concentration,
    //     i.density = it.density,
    //     i.onuid = it.onuid,
    //     i.onucode = it.onucode,
    //     i.onudescription = it.onudescription,
    //     i.riskclass = it.riskclass,
    //     i.riskclassdescription = it.riskclassdescription,
    //     i.risknumber = it.risknumber,
    //     i.subsidiaryrisk = it.subsidiaryrisk,
    //     i.packinggroup = it.packinggroup,
    //     i.transportquantity = it.transportquantity
    // WHERE
    //     it.ischemical = 'T';

    // return;

    // UPDATE invoiceitems
    // SET
    //     itemgrossvalue = ROUND(itemquantity * itemprice, 2),
    //     itemdiscount = ROUND(itemquantity * IFNULL(itemdiscount, 0), 2),
    //     itemfreight = ROUND(itemquantity * IFNULL(itemfreight, 0), 2),
    //     itemtotal = ROUND((itemquantity * itemprice) + (itemquantity * IFNULL(itemfreight, 0)) - (itemquantity * IFNULL(itemdiscount, 0)), 2);

    // return;

    // UPDATE invoiceitems i
    //   JOIN items it ON i.itemid = it.id
    //   SET
    //       i.ncmid = it.ncmid,
    //       i.ncmdescription = it.ncmdescription,
    //       i.ncm  = it.ncm;

    // return;

    // echo '<pre>';

    // $filepath = FCPATH . 'uploads/impostoscpb.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 2000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);

    // foreach ($data as $key => $value) {

    //   $item = $this->db->select('id, externalid, name')
    //     ->where('externalid', $value['item id'])
    //     ->get('items')
    //     ->result();

    //   $invoice = $this->db->select('id, externalid')
    //     ->where('externalid', $value['fatura id'])
    //     ->get('invoices')
    //     ->result();

    //   $invoiceitem = $this->db->select('id, itemid, itemname, itemline')
    //     ->where('link', $invoice[0]->id)
    //     ->where('itemid', $item[0]->id)
    //     // ->where('itemline', $value['linha'])
    //     ->like('itemname', $value['item'])
    //     ->get('invoiceitems')
    //     ->result();

    //   if ($invoice && $item && $invoiceitem) {

    //     $tax = array(
    //       'id' => uuidv4(),
    //       'externalid' => $value['ID interno'],
    //       'link' => $invoiceitem[0]->id,
    //       'invoiceid' => $invoice[0]->id,
    //       'itemid' => $item[0]->id,
    //       'itemname' => $item[0]->name,
    //       'line' => ($value['linha'] + 1),
    //       'calculationbase' => number_format((float) $value['base de calculo'], 2, '.', ''),
    //       'taxname' => $value['codigo imposto'],
    //       'aliquot' => (float) $value['aliquota'] / 100,
    //       'taxvalue' => number_format((float) $value['valor do imposto'], 2, '.', ''),
    //       'cst' => $value['cst'],
    //       'isinactive' => 'F',
    //       'confirmed' => 'T',
    //       'ip' => $this->input->ip_address(),
    //       'platform' => $this->agent->platform(),
    //       'agent' => $this->agent->browser() . ' ' . $this->agent->version(),
    //       'referer' => $this->agent->referrer(),
    //       'created' => time()
    //     );

    //     $this->db->where(array('id' => $invoiceitem[0]->id))
    //       ->update('invoiceitems', array('itemline' => ($value['linha'] + 1)));

    //     // print_r($value);
    //     // print_r($invoice);
    //     // print_r($tax);
    //     // print_r($invoiceitem);

    //     // return;

    //     $this->db->insert('invoicetaxcpb', $tax);
    //   }
    // }

    // return;

    // $items = $this->db->select('id, name, ncmid, ncm, ncmdescription')
    //   ->where('ischemical', 'T')
    //   ->group_by('ncm')
    //   ->get('items')
    //   ->result();

    // foreach ($items as $key => $item) {

    //   $ncm = $this->db->select('id, name, title, description')
    //     ->where('name', $item->ncm)
    //     ->get('ncms')
    //     ->result();

    //   if ($ncm && strlen($ncm[0]->name) == 8) {

    //     $ncmsup = $this->db->select('id, name, title, description')
    //       ->where('name', substr($item->ncm, 0, 6))
    //       ->get('ncms')
    //       ->result();

    //     if ($ncmsup) {

    //       $description = mb_strtoupper(trim(rtrim($ncmsup[0]->description, '.')) . ', ' . trim($ncm[0]->description), 'UTF-8');

    //       // if (in_array(trim($ncmsup[0]->description), array('Outros', 'De magnésio', 'De sódio', 'De cobre'))) {

    //         $ncmsupsup = $this->db->select('id, name, title, description')
    //           ->where('name', substr($item->ncm, 0, 4))
    //           ->get('ncms')
    //           ->result();

    //         if ($ncmsupsup) {
    //           $description = mb_strtoupper(trim(rtrim($ncmsupsup[0]->description, '.')) . ', ' . trim(rtrim($ncmsup[0]->description, '.')) . ', ' . trim($ncm[0]->description));
    //         }

    //       // }

    //       echo substr($item->ncm, 0, 4) . PHP_EOL;
    //       echo substr($item->ncm, 0, 6) . PHP_EOL;
    //       echo $item->ncm . PHP_EOL;
    //       echo $description . PHP_EOL;

    //       echo PHP_EOL;

    //       $this->db->where(array('id' => $item->id))
    //         ->update(
    //           'items',
    //           array(
    //             'ncmid' => $ncm[0]->id,
    //             'ncmdescription' => $description,
    //           )
    //         );

    //       $this->db->where(array('id' => $ncm[0]->id))
    //         ->update(
    //           'ncms',
    //           array(
    //             'description' => $description,
    //           )
    //         );

    //     }
    //   }
    // }

    // return;

    // $ncms = $this->db->select('id, name, title, description')
    //   ->get('ncms')
    //   ->result();

    // foreach ($ncms as $key => $ncm) {
    //   $this->db->where(array('id' => $ncm->id))
    //     ->update(
    //       'ncms',
    //       array(
    //         'description' => mb_strtoupper($ncm->description, 'UTF-8'),
    //       )
    //     );
    // }

    // return;

    // $items = $this->db->select('id, name, ncmid, ncm, ncmdescription')
    //   ->get('items')
    //   ->result();

    // foreach ($items as $key => $item) {

    //   if ($item->ncm) {

    //     $ncm = $this->db->select('id, name, title, description')
    //       ->where('name', $item->ncm)
    //       ->get('ncms')
    //       ->result();

    //     if ($ncm) {
    //       $this->db->where(array('id' => $item->id))
    //         ->update(
    //           'items',
    //           array(
    //             'ncmid' => $ncm[0]->id,
    //             'ncm' => $ncm[0]->name,
    //             'ncmdescription' => $ncm[0]->description,
    //           )
    //         );
    //     }
    //   }
    // }

    // return;

    // $items = $this->db->select('id, externalid, name, subsidiaries, conversionfactorunit')
    //   ->where('iscontrolledfederalpolice ', 'T')
    //   ->get('items')
    //   ->result();

    // foreach ($items as $item) {

    //   $data = array(
    //     'name' => $item->name,
    //     'conversionunitid' => null,
    //     'conversionunit' => null,
    //   );

    //   if (
    //       strpos($item->name, ' 25G') !== false ||
    //       strpos($item->name, ' 50G') !== false ||
    //       strpos($item->name, ' 100G') !== false ||
    //       strpos($item->name, ' 125G') !== false ||
    //       strpos($item->name, ' 250G') !== false ||
    //       strpos($item->name, ' 500G') !== false ||
    //       strpos($item->name, ' 1000G') !== false ||
    //       strpos($item->name, ' 4000G') !== false ||
    //       strpos($item->name, ' 5000G') !== false ||
    //       strpos($item->name, ' 18000G') !== false ||
    //       strpos($item->name, ' 20000G') !== false ||
    //       strpos($item->name, ' 23000G') !== false ||
    //       strpos($item->name, ' 25000G') !== false ||
    //       strpos($item->name, ' 30000G') !== false ||
    //       strpos($item->name, ' 35000G') !== false ||
    //       strpos($item->name, ' 50KG') !== false ||
    //       strpos($item->name, ' 50000G') !== false ||
    //       strpos($item->name, ' 60KG') !== false ||
    //       strpos($item->name, ' 70KG') !== false ||
    //       strpos($item->name, ' 70000G') !== false ||
    //       strpos($item->name, ' 75KG') !== false ||
    //       strpos($item->name, ' 75000G') !== false ||
    //       strpos($item->name, ' 200KG') !== false ||
    //       strpos($item->name, ' 200000G') !== false ||
    //       strpos($item->name, ' 18KG') !== false ||
    //       strpos($item->name, ' C/18KG') !== false ||
    //       strpos($item->name, ' 20KG') !== false ||
    //       strpos($item->name, ' C/20KG') !== false ||
    //       strpos($item->name, ' 23 KG') !== false ||
    //       strpos($item->name, ' C/23KG') !== false ||
    //       strpos($item->name, ' 23KG') !== false ||
    //       strpos($item->name, ' 25 KG') !== false ||
    //       strpos($item->name, ' C/25KG') !== false ||
    //       strpos($item->name, ' 25KG') !== false ||
    //       strpos($item->name, ' 30 KG') !== false ||
    //       strpos($item->name, ' C/30KG') !== false ||
    //       strpos($item->name, ' 30KG') !== false ||
    //       strpos($item->name, ' 35 KG') !== false ||
    //       strpos($item->name, ' C/35KG') !== false ||
    //       strpos($item->name, ' 35KG') !== false ||
    //       strpos($item->name, ' 60000G') !== false ||
    //       strpos($item->name, ' 60 KG') !== false ||
    //       strpos($item->name, ' 70 KG') !== false ||
    //       strpos($item->name, ' 75 KG') !== false ||
    //       strpos($item->name, ' 200 KG') !== false
    //     ) {
    //     $data['conversionunit'] = 'KG';
    //     $data['conversionunitid'] = '26923e6b-72f3-2910-1c35-f3223f527bf7';
    //   }
    //   if (
    //       strpos($item->name, ' 25ML') !== false ||
    //       strpos($item->name, ' 50ML') !== false ||
    //       strpos($item->name, ' 100ML') !== false ||
    //       strpos($item->name, ' 125ML') !== false ||
    //       strpos($item->name, ' 250ML') !== false ||
    //       strpos($item->name, ' 500ML') !== false ||
    //       strpos($item->name, ' 1000ML') !== false ||
    //       strpos($item->name, ' 2,5LITROS') !== false ||
    //       strpos($item->name, ' 2,5 LITROS') !== false ||
    //       strpos($item->name, ' 2500ML') !== false ||
    //       strpos($item->name, ' 4000ML') !== false ||
    //       strpos($item->name, ' 4,0LITROS') !== false ||
    //       strpos($item->name, ' 4,0 LITROS') !== false ||
    //       strpos($item->name, ' 5000ML') !== false ||
    //       strpos($item->name, ' 18000ML') !== false ||
    //       strpos($item->name, ' 20000ML') !== false ||
    //       strpos($item->name, ' 20 LITROS') !== false ||
    //       strpos($item->name, ' 20 L') !== false ||
    //       strpos($item->name, ' 23000ML') !== false ||
    //       strpos($item->name, ' 23 L') !== false ||
    //       strpos($item->name, ' 25000ML') !== false ||
    //       strpos($item->name, ' 25 L') !== false ||
    //       strpos($item->name, ' 30000ML') !== false ||
    //       strpos($item->name, ' 35000ML') !== false ||
    //       strpos($item->name, ' 30 L') !== false ||
    //       strpos($item->name, ' 35 L') !== false ||
    //       strpos($item->name, ' 50000ML') !== false ||
    //       strpos($item->name, ' 50LITROS') !== false ||
    //       strpos($item->name, ' 60000ML') !== false ||
    //       strpos($item->name, ' 70000ML') !== false ||
    //       strpos($item->name, ' 75000ML') !== false ||
    //       strpos($item->name, ' 200000ML') !== false ||
    //       strpos($item->name, ' 200 LITROS') !== false ||
    //       strpos($item->name, ' 200 L') !== false
    //     ) {
    //     $data['conversionunit'] = 'LITRO';
    //     $data['conversionunitid'] = 'a8c6c422-cf3c-6905-fe57-618ceb1378be';
    //   }

    //   $this->db->where(array('id' => $item->id))
    //     ->update('items', $data);

    // }

    // return;

    // echo '<pre>';

    // $filepath = FCPATH . 'uploads/invoiceitems-valores-3.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 20000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);


    // $i = 0;
    // foreach ($data as $key => $value) {

    //   $data = array(
    //     'itemdiscount' => 0.00,
    //     'itemfreight' => 0.00,
    //     'itemtotal' => $value['itemgrossvalue'],
    //   );

    //   if ($value['itemdiscount'] > 0) {
    //     $data['itemdiscount'] = number_format($value['itemdiscount'], 2, '.', '');
    //   }

    //   if ($value['itemfreight'] > 0) {
    //     $data['itemfreight'] = number_format($value['itemfreight'], 2, '.', '');
    //   }

    //   if ($value['itemdiscount'] > 0 || $value['itemfreight'] > 0) {


    //     $item = $this->db->select('id, itemname, itemprice, itemgrossvalue, itemquantity, itemdiscount, itemfreight, itemtotal')
    //       ->where('id', $value['id'])
    //       ->get('invoiceitems')
    //       ->result();

    //     if ($item) {
    //       // print_r($item[0]);
    //       $this->db->where(array('id' => $item[0]->id))
    //         ->update('invoiceitems', $data);

    //       $i++;
    //     }
    //   }

    // }

    // echo $i;
    // return;

    // echo '<pre>';

    // $invoices = $this->db->select('id')
    //   ->get('invoices')
    //   ->result();

    // foreach ($invoices as $key => $value) {

    //   $invoiceitems = $this->db->select('id, itemprice, itemgrossvalue, itemquantity, itemdiscount, itemfreight, itemtotal')
    //     ->where(array(
    //       'link' => $value->id,
    //     ))
    //     ->get('invoiceitems')
    //     ->result();

    //   foreach ($invoiceitems as $key => $item) {
    //     $freight = (float) $item->itemfreight;
    //     $discount = (float) $item->itemdiscount;
    //     $itemprice = (float) $item->itemprice;
    //     $quantity = (float) $item->itemquantity;
    //     $total = (float) $item->itemtotal;

    //     $data = array(
    //       'itemdiscount' => $discount,
    //       'itemfreight' => $freight,
    //     );

    //     if (!$discount && $freight > 0 && $quantity > 0) {

    //       if (number_format($freight + ($quantity * $itemprice), 2, '.', '') == $total) {
    //         $data['itemfreight'] = $freight;
    //       }

    //       if (number_format(($quantity * $freight) + ($quantity * $itemprice), 2, '.', '') == $total) {
    //         $data['itemfreight'] = number_format($quantity * $freight, 2, '.', '');
    //       }

    //     }

    //     if ($discount > 0 && !$freight && $quantity > 0) {

    //       if (number_format($discount - ($quantity * $itemprice), 2, '.', '') == $total) {
    //         $data['itemdiscount'] = $discount;
    //       }

    //       if (number_format(($quantity * $discount) - ($quantity * $itemprice), 2, '.', '') == $total) {
    //         $data['itemdiscount'] = number_format($quantity * $discount, 2, '.', '');
    //       }

    //     }

    //     if ($discount > 0 && $freight > 0 && $quantity > 0) {

    //       if (number_format(($quantity * $itemprice) + $freight - $discount, 2, '.', '') == $total) {
    //         $data['itemdiscount'] = $discount;
    //         $data['itemfreight'] = $freight;
    //       }

    //       if (number_format(($quantity * $itemprice) + ($quantity * $freight) - ($quantity * $discount), 2, '.', '') == $total) {
    //         $data['itemdiscount'] = number_format($quantity * $discount, 2, '.', '');
    //         $data['itemfreight'] = number_format($quantity * $freight, 2, '.', '');
    //       }

    //     }

    //     $this->db->where(array('id' => $item->id))
    //       ->update('invoiceitems', $data);

    //   }
    // }

    // return;

    // echo '<pre>';

    // // 91829, 0
    // // 91829, 91829
    // // 91829, 183658

    // $i = 0;

    // $estimateitems = $this->db->select('
    //     id,
    //     itemid,
    //     ncmid,
    //     ncm,
    //     ncmdescription,
    //     ischemical,
    //     iscontrolledcivilpolice,
    //     iscontrolledfederalpolice,
    //     iscontrolledarmy,
    //     concentration,
    //     density,
    //     onucode,
    //     onudescription,
    //     riskclass,
    //     riskclassdescription,
    //     risknumber,
    //     subsidiaryrisk,
    //     packinggroup,
    //     transportquantity,
    //     pavilion,
    //     pallet,
    //     hall,
    //     street,
    //     shelfa,
    //     shelfb,
    //     shelfc,
    //     shelfd,
    //     shelfe,
    //     shelff,
    //     shelfg,
    //     shelfh,
    //     shelfi,
    //     shelfj,
    //     shelfk,
    //     shelfl,
    //     shelfm,
    //     shelfn,
    //     shelfo,
    //     shelfp,
    //     shelfq,
    //   ')
    //     ->limit(91829, 183658)
    //     ->get('estimateitems')
    //     ->result();

    // foreach ($estimateitems as $key => $estimateitem) {

    //   $item = $this->db->select('
    //     ncmid,
    //     ncm,
    //     ncmdescription,
    //     ischemical,
    //     iscontrolledcivilpolice,
    //     iscontrolledfederalpolice,
    //     iscontrolledarmy,
    //     concentration,
    //     density,
    //     onucode,
    //     onudescription,
    //     riskclass,
    //     riskclassdescription,
    //     risknumber,
    //     subsidiaryrisk,
    //     packinggroup,
    //     transportquantity,
    //     pavilion,
    //     pallet,
    //     hall,
    //     street,
    //     shelfa,
    //     shelfb,
    //     shelfc,
    //     shelfd,
    //     shelfe,
    //     shelff,
    //     shelfg,
    //     shelfh,
    //     shelfi,
    //     shelfj,
    //     shelfk,
    //     shelfl,
    //     shelfm,
    //     shelfn,
    //     shelfo,
    //     shelfp,
    //     shelfq,
    //   ')
    //     ->where(array('id' => $estimateitem->itemid))
    //     ->get('items')
    //     ->result();

    //   if ($item) {
    //     $i++;
    //     print_r($i . PHP_EOL);
    //     print_r($estimateitem->itemid . PHP_EOL);
    //     // return;

    //     $this->db->where(array('id' => $estimateitem->id))
    //       ->update('estimateitems', $item[0]);
    //   }
    // }

    // return;

    // echo '<pre>';

    // $status = array(
    //   'gerado' => '42c14e50-e921-e3e6-0e8d-10cc352c6548',
    //   'pendente enviar para aprovação' => 'dab8131c-82ae-3609-5f23-06c896d15370',
    //   'rejeitado' => 'f49f69a1-a88b-e63b-7d8f-7d848582f3f9',
    //   'pendente aprovação' => '5032babc-7a17-8275-074b-3967c11c29d4',
    //   'aprovado' => '7135dd2c-f739-ee1f-333c-215f0db7fccd',
    //   'cancelado' => '05b9a902-91db-f7ff-bb25-f4b2b383bb09',
    // );

    // $filepath = FCPATH . 'uploads/orcamentos.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 20000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);

    // foreach ($data as $key => $value) {

    //   $estimate = array(
    //     'status' => null,
    //   );

    //   if (mb_strtolower($value['Status']) == 'aprovado') {
    //     $estimate['status'] = $status['aprovado'];
    //   }

    //   if (mb_strtolower($value['Status']) == 'gerado' || mb_strtolower($value['Status']) == 'gerado parcialmente') {
    //     $estimate['status'] = $status['gerado'];
    //   }

    //   if (mb_strtolower($value['Status']) == 'pendente enviar para aprovação') {
    //     $estimate['status'] = $status['pendente enviar para aprovação'];
    //   }

    //   if (mb_strtolower($value['Status']) == 'pendente aprovação') {
    //     $estimate['status'] = $status['pendente aprovação'];
    //   }

    //   $estimateref = $this->db->select('id, customername, created')
    //     ->where(array('externalid' => $value['ID interno']))
    //     ->get('estimates')
    //     ->result();

    //   if ($estimateref) {
    //     $this->db->where(array('id' => $estimateref[0]->id))
    //       ->update('estimates', $estimate);

    //     $estimateitems = $this->db->select('id')
    //       ->where(array('link' => $estimateref[0]->id))
    //       ->get('estimateitems')
    //       ->result();

    //     foreach ($estimateitems as $key => $estimateitem) {
    //       $this->db->where(array('id' => $estimateitem->id))
    //         ->update('estimateitems', array('created' => $estimateref[0]->created));
    //     }

    //   }
    // }
    // return;

    // echo '<pre>';

    // $purchaseitems = $this->db->select('
    //     id,
    //     link,
    //     itemid,
    //     salesorders
    //   ')
    //   ->get('purchaseorderitems')
    //   ->result();

    // foreach ($purchaseitems as $key => $purchaseitem) {

    //   $item = $this->db->select('
    //     ncmid,
    //     ncm,
    //     ncmdescription,
    //     ischemical,
    //     iscontrolledcivilpolice,
    //     iscontrolledfederalpolice,
    //     iscontrolledarmy,
    //     concentration,
    //     density,
    //     onucode,
    //     onudescription,
    //     riskclass,
    //     riskclassdescription,
    //     risknumber,
    //     subsidiaryrisk,
    //     packinggroup,
    //     transportquantity,
    //     pavilion,
    //     pallet,
    //     hall,
    //     street,
    //     shelfa,
    //     shelfb,
    //     shelfc,
    //     shelfd,
    //     shelfe,
    //     shelff,
    //     shelfg,
    //     shelfh,
    //     shelfi,
    //     shelfj,
    //     shelfk,
    //     shelfl,
    //     shelfm,
    //     shelfn,
    //     shelfo,
    //     shelfp,
    //     shelfq,
    //   ')
    //     ->where(array('id' => $purchaseitem->itemid))
    //     ->get('items')
    //     ->result();

    //   $link = $this->db->select('
    //     id,
    //   ')
    //     ->where(array('externalid' => $purchaseitem->link))
    //     ->get('purchaseorders')
    //     ->result();

    //   if ($link && $item) {

    //     $data = $item[0];
    //     $data->link = $link[0]->id;

    //     print_r($purchaseitem);
    //     print_r($data);
    //     return;

    //     $this->db->where(array('id' => $purchaseitem->id))
    //       ->update('purchaseorderitems', $data);
    //   }
    // }

    // return;

    // echo '<pre>';

    // $purchaseitems = $this->db->select('
    //     id,
    //     link,
    //     itemid,
    //     salesorders
    //   ')
    //   ->get('purchaseorderitems')
    //   ->result();

    // foreach ($purchaseitems as $key => $purchaseitem) {

    //   $data = array ('salesorders' => str_replace('"]', ']', str_replace('["', '[', $purchaseitem->salesorders)));
    //   // print_r(json_decode($purchaseitem->salesorders));
    //   // return;

    //   $this->db->where(array('id' => $purchaseitem->id))
    //     ->update('purchaseorderitems', $data);
    // }

    // return;

    // echo '<pre>';

    // $receiptitems = $this->db->select('
    //     id,
    //     link,
    //   ')
    //   ->get('receiptitems')
    //   ->result();

    // foreach ($receiptitems as $key => $receiptitem) {

    //   $link = $this->db->select('
    //     id,
    //   ')
    //     ->where(array('externalid' => $receiptitem->link))
    //     ->get('receipts')
    //     ->result();

    //   if ($link) {

    //     $data = array('link' => $link[0]->id);

    //     // print_r($data);
    //     // return;

    //     $this->db->where(array('id' => $receiptitem->id))
    //       ->update('receiptitems', $data);
    //   }
    // }

    // return;

    // echo '<pre>';

    // $filepath = FCPATH . 'csvimports/carriers.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 1000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);

    // print_r($data);

    // $entitie = $this->db->select('
    //       id,
    //       carrierid,
    //       carriername
    //     ')
    //   ->where('carrierid REGEXP', '^[0-9]+$')
    //   ->get('purchaseorders')
    //   ->result();

    // print_r($entitie);
    // return;

    // foreach ($data as $key => $value) {

    //   $entitie = $this->db->select('
    //       id,
    //       name,
    //       legalname,
    //     ')
    //     ->where(array('document' => $value['cnpj']))
    //     ->get('entities')
    //     ->result();

    //   $purchaseorders = $this->db->select('
    //       id
    //     ')
    //     ->where(array('carrierid' => $value['ID interno']))
    //     ->get('purchaseorders')
    //     ->result();

    //   if ($entitie && $purchaseorders) {
    //     print_r($entitie);
    //     print_r($purchaseorders);

    //     foreach ($purchaseorders as $key => $purchaseorder) {
    //       $data = array(
    //         'carrierid' => $entitie[0]->id,
    //         'carriername' => $entitie[0]->name,
    //       );
    //       $this->db->where(array('id' => $purchaseorder->id))
    //         ->update('purchaseorders', $data);
    //     }
    //   }
    // }

    // return;

    // echo '<pre>';

    // $filepath = FCPATH . 'uploads/recebimento.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 1000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);

    // // print_r($data);

    // foreach ($data as $key => $value) {
    //   $created = explode(' ', $value['data doc']);
    //   $created = strtotime(implode('-', array_reverse(explode('/', $created[0]))) . ' ' . $created[1]);

    //   $fiscaldocnumber = !!$value['numero nota fiscal'] ? (int) $value['numero nota fiscal'] : null;

    //   $fiscaldocnumberdate = $value['data nota fiscal'] ? $value['data nota fiscal'] : null;
    //   if ($fiscaldocnumberdate) {
    //     $fiscaldocnumberdate = explode(' ', $value['data nota fiscal']);
    //     $fiscaldocnumberdate = strtotime(implode('-', array_reverse(explode('/', $fiscaldocnumberdate[0]))));
    //   }

    //   $data = array(
    //     'created' => $created,
    //     'fiscaldocnumber' => $fiscaldocnumber,
    //     'fiscaldocnumberdate' => $fiscaldocnumberdate
    //   );

    //   $this->db->where(array('externalid' => $value['ID interno']))
    //     ->update('receipts', $data);

    // }

    // return;

    // echo '<pre>';

    // $filepath = FCPATH . 'uploads/pedido-de-compra.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 1000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);

    // foreach ($data as $key => $value) {
    //   $created = explode(' ', $value['data doc']);
    //   $created = strtotime(implode('-', array_reverse(explode('/', $created[0]))) . ' ' . $created[1]);

    //   $data = array(
    //     'created' => $created
    //   );

    //   // print_r($data);
    //   // print_r($value['data doc']);

    //   $this->db->where(array('externalid' => $value['ID interno']))
    //     ->update('purchaseorders', $data);

    // }

    // return;

    // echo '<pre>';

    // $filepath = FCPATH . 'uploads/faturas-datas-fiscal.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 1000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);

    // // print_r($data);
    // // return;

    // foreach ($data as $key => $value) {
    //   $created = explode(' ', $value['Data de criação']);
    //   $created = strtotime(implode('-', array_reverse(explode('/', $created[0]))) . ' ' . $created[1]);

    //   if ($value['nfe ava']) {
    //     $fiscaldocnumber = !!$value['nfe ava'] ? (int) $value['nfe ava'] : null;
    //   }

    //   if ($value['nfe']) {
    //     $fiscaldocnumber = !!$value['nfe'] ? (int) $value['nfe'] : null;
    //   }

    //   if ($value['nfe data ava']) {
    //     $fiscaldocnumberdate = explode(' ', $value['nfe data ava']);
    //     $fiscaldocnumberdate = strtotime(implode('-', array_reverse(explode('/', $fiscaldocnumberdate[0]))));
    //   }

    //   if ($value['nfe data']) {
    //     $fiscaldocnumberdate = explode(' ', $value['nfe data']);
    //     $fiscaldocnumberdate = strtotime(implode('-', array_reverse(explode('/', $fiscaldocnumberdate[0]))));
    //   }

    //   if ($value['nfe status ava']) {
    //     $fiscaldocstatus = $value['nfe status ava'];
    //   }

    //   if ($value['nfe status']) {
    //     $fiscaldocstatus = $value['nfe status'];
    //   }

    //   if ($value['nfe chave ava']) {
    //     $fiscaldockey = $value['nfe chave ava'];
    //   }

    //   if ($value['nfe chave']) {
    //     $fiscaldockey = $value['nfe chave'];
    //   }


    //   $data = array(
    //     'created' => $created,
    //     'fiscaldocnumber' => $fiscaldocnumber,
    //     'fiscaldocdate' => $fiscaldocnumberdate,
    //     'fiscaldocstatus' => $fiscaldocstatus,
    //     'fiscaldocaccesskey' => $fiscaldockey,
    //   );

    //   print_r($data);
    //   print_r($value);

    //   $this->db->where(array('externalid' => $value['ID interno']))
    //     ->update('invoices', $data);

    // }

    // return;

    // $this->billingdoc->sending('a454365b-f61e-afbb-ac9f-bd951cb705b1');
    // $this->billingdoc->get('a454365b-f61e-afbb-ac9f-bd951cb705b1');

    // echo '<pre>';

    // $filepath = FCPATH . 'uploads/faturas-representante.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 1000, ',')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);

    // foreach ($data as $key => $value) {

    //   if ($value['representante id']) {

    //     $invoice = $this->db->select('
    //       id
    //     ')
    //       ->where(array('externalid' => $value['id interno']))
    //       ->get('invoices')
    //       ->result();

    //     if ($invoice) {

    //       $salesperson = $this->db->select('
    //           id,
    //           name
    //         ')
    //         ->where(array('externalid' => $value['representante id']))
    //         ->get('users')
    //         ->result();

    //       $this->db->where(array('id' => $invoice[0]->id))
    //         ->update('invoices', array(
    //           'salesmanid' => $salesperson[0]->id,
    //           'salesmanname' => $salesperson[0]->name
    //         ));
    //     }

    //   }
    // }

    // return;

    // echo '<pre>';

    // $filepath = FCPATH . 'uploads/invoices.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 15000, ',', '"')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);

    // $notimported = array();

    // foreach ($data as $key => $value) {

    //   $invoice = $this->db->select('
    //       id
    //     ')
    //     ->where(array('externalid' => $value['externalid']))
    //     ->get('invoices')
    //     ->result();

    //   if (!$invoice) {

    //     $invoiceid = $this->db->select('
    //       id
    //     ')
    //     ->where(array('id' => $value['id']))
    //     ->get('invoices')
    //     ->result();

    //     if ($invoiceid) {
    //       array_push($notimported, $value);
    //     } else {
    //       $this->db->insert('invoices', $value);
    //     }

    //   }
    // }

    // print_r($notimported);

    // return;

    // echo '<pre>';

    // $entitiesupdate = $this->db->select('
    //     id,
    //     externalid,
    //     isperson,
    //     document,
    //     name,
    //     legalname,
    //     activitysector,
    //     preferredvoltage,
    //     group,
    //     subgroup,
    //     civilpolicelicense,
    //     datecivilpolicelicense,
    //     federalpolicelicense,
    //     datefederalpolicelicense,
    //     armylicense,
    //     datearmylicense,
    //     founded,
    //     cnae,
    //     cnaedescription,
    //     ie,
    //     im,
    //     mei,
    //     simplesnacional,
    //     ieexempt,
    //     icmstaxpayer,
    //     ieimmune,
    //     publicentityexempticms,
    //     comments,
    //     creditlimit,
    //     minimumturnover,
    //     applybalance,
    //     email,
    //     url,
    //     defaultaddress,
    //     entitystatus,
    //     entitystatusdate,
    //     factor,
    //     freighttype,
    //     paymentweek,
    //     paymentmonth,
    //     invoicingmonth,
    //     phone,
    //     salesrep,
    //     iscarrier,
    //     iscustomer,
    //     issupplier,
    //     carriername,
    //     suframa,
    //     mlclient,
    //     isinactive,
    //     confirmed
    //   ')
    //   ->get('entitiesupdate')
    //   ->result();

    // foreach ($entitiesupdate as $key => $value) {

    //   print_r($value->legalname . PHP_EOL);

    //   $externalid = json_decode($value->externalid);

    //   if ($externalid) {
    //     foreach ($externalid as $key => $id) {
    //       $entitie = $this->db->select('
    //           isperson,
    //           document,
    //           name,
    //           legalname,
    //           activitysector,
    //           preferredvoltage,
    //           group,
    //           subgroup,
    //           civilpolicelicense,
    //           datecivilpolicelicense,
    //           federalpolicelicense,
    //           datefederalpolicelicense,
    //           armylicense,
    //           datearmylicense,
    //           founded,
    //           cnae,
    //           cnaedescription,
    //           ie,
    //           im,
    //           mei,
    //           simplesnacional,
    //           ieexempt,
    //           icmstaxpayer,
    //           ieimmune,
    //           publicentityexempticms,
    //           comments,
    //           creditlimit,
    //           minimumturnover,
    //           applybalance,
    //           email,
    //           url,
    //           defaultaddress,
    //           entitystatus,
    //           entitystatusdate,
    //           factor,
    //           freighttype,
    //           paymentweek,
    //           paymentmonth,
    //           invoicingmonth,
    //           phone,
    //           salesrep,
    //           iscarrier,
    //           iscustomer,
    //           issupplier,
    //           carriername,
    //           suframa,
    //           mlclient,
    //           isinactive,
    //           confirmed
    //         ')
    //         ->where(array('externalid' => $id))
    //         ->get('entities')
    //         ->result();

    //       if ($entitie) {
    //         $this->db->where(array('id' => $value->id))
    //           ->update('entitiesupdate', $entitie[0]);
    //       }

    //     }
    //   }
    // }

    // return;

    // echo '<pre>';

    // $entitiesupdate = $this->db->select('
    //     id,
    //     paymentweek,
    //   ')
    //   ->like('paymentweek', 'ter\u00c7a', 'both')
    //   ->get('entitiesupdate')
    //   ->result();

    // foreach ($entitiesupdate as $key => $value) {

    //   $data = array(
    //     'paymentweek' => mb_strtolower(str_replace('ter\u00c7a', 'terça', $value->paymentweek), 'UTF-8'),
    //   );
    //   $this->db->where(array('id' => $value->id))
    //     ->update('entitiesupdate', $data);
    // }

    // return;

    // echo '<pre>';

    // $entitiesupdate = $this->db->select('
    //     id,
    //     externalid
    //   ')
    //   ->where('externalid REGEXP "^[0-9]+$"')
    //   ->get('entitiesupdate')
    //   ->result();

    //   print_r($entitiesupdate);
    //   return;

    // foreach ($entitiesupdate as $key => $value) {

    //   $entitie = $this->db->select('
    //           isperson,
    //           document,
    //           name,
    //           legalname,
    //           activitysector,
    //           preferredvoltage,
    //           group,
    //           subgroup,
    //           civilpolicelicense,
    //           datecivilpolicelicense,
    //           federalpolicelicense,
    //           datefederalpolicelicense,
    //           armylicense,
    //           datearmylicense,
    //           founded,
    //           cnae,
    //           cnaedescription,
    //           ie,
    //           im,
    //           mei,
    //           simplesnacional,
    //           ieexempt,
    //           icmstaxpayer,
    //           ieimmune,
    //           publicentityexempticms,
    //           comments,
    //           creditlimit,
    //           minimumturnover,
    //           applybalance,
    //           email,
    //           url,
    //           defaultaddress,
    //           entitystatus,
    //           entitystatusdate,
    //           factor,
    //           freighttype,
    //           paymentweek,
    //           paymentmonth,
    //           invoicingmonth,
    //           phone,
    //           salesrep,
    //           iscarrier,
    //           iscustomer,
    //           issupplier,
    //           carriername,
    //           suframa,
    //           mlclient,
    //           isinactive,
    //           confirmed
    //         ')
    //     ->where(array('externalid' => $value->externalid))
    //     ->get('entities')
    //     ->result();

    //   if ($entitie) {

    //     $entitie[0]->externalid = '[' . json_encode($value->externalid) . ']';

    //     $this->db->where(array('id' => $value->id))
    //       ->update('entitiesupdate', $entitie[0]);
    //   }

    // }

    // return;

    // echo '<pre>';

    // $entitiesupdate = $this->db->select('
    //     id,
    //     group,
    //     subgroup
    //   ')
    //   ->where('`group` REGEXP "^[0-9]+$"')
    //   ->group_by('group')
    //   ->get('entities')
    //   ->result();

    // foreach ($entitiesupdate as $key => $value) {

    //   $group = $this->db->select('
    //           id,
    //           externalid,
    //           name,
    //           title,
    //           sector
    //         ')
    //     ->where(array('externalid' => $value->group))
    //     ->get('groups')
    //     ->result();

    //   print_r($value);
    //   print_r($group);

    //   if ($group) {

    //     $this->db->where(array('group' => $value->group))
    //       ->update('entities', array('group' => $group[0]->id));
    //   }

    // }

    // return;

    // echo '<pre>';

    // $entitiesupdate = $this->db->select('
    //     id,
    //     group,
    //     subgroup,
    //     isperson,
    //     activitysector,
    //     preferredvoltage,
    //     freighttype,
    //     salesrep,
    //     carrierid
    //   ')
    //   ->where('`carrierid` REGEXP "^[0-9]+$"')
    //   ->group_by('carrierid')
    //   ->get('entities')
    //   ->result();

    // print_r($entitiesupdate);
    // return;

    // $activitysectors = array(
    //   '1' => 'db4834a4-03d3-3f02-5859-70a085cda4b2',
    //   '29' => 'c7956089-0c18-8606-b6af-1c4ea0ceaee1',
    //   '3' => '883d1f31-7a96-36ef-c1d5-fe93997d2a64',
    //   '4' => '415d28a3-1962-9af7-ac80-09221524e598',
    //   '5' => '37f177c0-1d82-f63d-85f8-9025ae1ee35a'
    // );

    // foreach ($entitiesupdate as $key => $value) {

    //   $user = $this->db->select('
    //       id,
    //       externalid,
    //       name
    //     ')
    //     ->where(array('externalid' => $value->salesrep))
    //     ->get('users')
    //     ->result();

    //   print_r($value);
    //   print_r($user);

    //   if ($user) {
    //     $this->db->where(array('salesrep' => $value->salesrep))
    //       ->update('entities', array('salesrep' => $user[0]->id));
    //   }

    // }

    // return;


    // echo '<pre>';

    // $filepath = FCPATH . 'uploads/estimates-status-condpag.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 15000, ',', '"')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);

    // $status = array(
    //   'Aprovado' => '7135dd2c-f739-ee1f-333c-215f0db7fccd',
    //   'Gerado' => '42c14e50-e921-e3e6-0e8d-10cc352c6548',
    //   'Gerado Parcialmente' => '42c14e50-e921-e3e6-0e8d-10cc352c6548',
    //   'Pendente Aprovação' => '5032babc-7a17-8275-074b-3967c11c29d4',
    //   'Pendente Enviar para Aprovação' => 'dab8131c-82ae-3609-5f23-06c896d15370',
    // );

    // foreach ($data as $key => $value) {

    //   $estimate = $this->db->select('
    //       id,
    //       externalid,
    //       customername,
    //       termsid,
    //       termsname,
    //       status
    //     ')
    //     ->where(array('externalid' => $value['ID interno']))
    //     ->get('estimates')
    //     ->result();

    //   $terms = $this->db->select('
    //       id,
    //       externalid,
    //       name
    //     ')
    //     ->where(array('externalid' => $value['id condicoes de pag']))
    //     ->get('terms')
    //     ->result();



    //   $term = array(
    //     'termsid' => $value['id condicoes de pag'],
    //     'termsname' => $value['condicoes de pag'],
    //   );

    //   if ($terms) {
    //     $term = array(
    //       'termsid' => $terms[0]->id,
    //       'termsname' => $terms[0]->name,
    //     );
    //   } else {
    //     $termslike = $this->db->select('
    //       id,
    //       externalid,
    //       name
    //     ')
    //       ->like('name', $value['condicoes de pag'], 'both')
    //       ->get('terms')
    //       ->result();

    //     if ($termslike) {
    //       $term = array(
    //         'termsid' => $termslike[0]->id,
    //         'termsname' => $termslike[0]->name,
    //       );
    //     }

    //   }

    //   print_r($value);
    //   print_r($estimate);
    //   print_r($status[$value['status']]);
    //   print_r($terms);
    //   return;

    //   $data = array(
    //     'status' => $status[$value['status']]
    //   );

    //   if ($estimate) {
    //     $this->db->where(array('id' => $estimate[0]->id))
    //       ->update('estimates', $term);
    //   }

    // }

    // return;

    // echo '<pre>';

    // $estimatesupdate = $this->db->select('
    //     id,
    //     termsid,
    //     termsname,
    //     customerid,
    //     customername,
    //     contactid,
    //     contactname,
    //     salesmanid,
    //     salesmanname,
    //     freighttypeid,
    //     freighttypename,
    //     carrierid,
    //     carriername,
    //     billaddressid,
    //     billaddress,
    //     shippingaddressid,
    //     shippingaddress,
    //     termsid,
    //     termsname
    //   ')
    //   ->where('`termsid` REGEXP "^[0-9]+$"')
    //   ->group_by('termsid')
    //   ->get('estimates')
    //   ->result();

    // print_r($estimatesupdate);
    // return;

    // foreach ($estimatesupdate as $key => $value) {

    //   $relationship = $this->db->select('
    //       id,
    //       externalid,
    //       name
    //     ')
    //     ->where(array('externalid' => $value->contactid))
    //     ->get('relationships')
    //     ->result();

    //   print_r($value);
    //   print_r($relationship);
    //   return;

    //   if ($relationship) {
    //     $data = array(
    //       'contactid' => $relationship[0]->id,
    //       'contactname' => $relationship[0]->name
    //     );

    //     $this->db->where(array('id' => $value->id))
    //       ->update('estimates', $data);
    //   }

    // }

    // return;

    // echo '<pre>';

    // $estimateitemsupdate = $this->db->select('
    //     id,
    //     link,
    //     itemid,
    //     itemname,
    //     saleunitid,
    //     saleunitname,
    //     voltageid,
    //     voltagename,
    //     currencyid,
    //     currencyname,
    //     warrantyid,
    //     ncmid,
    //     ncm
    //   ')
    //   ->where('`ncmid` REGEXP "^[0-9]+$"')
    //   ->group_by('ncmid')
    //   ->get('estimateitems')
    //   ->result();

    // $units = array(
    //   'PAC' => '1727e998-3fb5-d9ef-b3a4-6031942f1560',
    //   'PT' => '1727e998-3fb5-d9ef-b3a4-6031942f1560',
    //   'CX' => '7553be97-2b46-aad5-fd8b-0133cdd205ac',
    //   'L' => 'a8c6c422-cf3c-6905-fe57-618ceb1378be',
    //   'UN' => '81015a84-b1cd-317d-f82c-5e5999524ac3',
    //   'LI' => 'a8c6c422-cf3c-6905-fe57-618ceb1378be',
    //   'GL' => 'a0be11cc-4df0-d379-942d-b37979eb6bcb',
    //   'FR' => 'cc902207-8db1-685b-9178-bfbd0f81c16e',
    //   'SC' => '81015a84-b1cd-317d-f82c-5e5999524ac3',
    //   'KIT' => '4c40e079-026e-bd55-855f-ece128fa9866',
    //   'LT' => 'a8c6c422-cf3c-6905-fe57-618ceb1378be',
    //   'PAR' => '81015a84-b1cd-317d-f82c-5e5999524ac3',
    //   'PCT' => '1727e998-3fb5-d9ef-b3a4-6031942f1560',
    //   'CAI' => '7553be97-2b46-aad5-fd8b-0133cdd205ac',
    //   'PE' => '7e2c2a59-2255-db9e-403b-67f19df58b1c',
    //   'GAL' => 'a0be11cc-4df0-d379-942d-b37979eb6bcb',
    //   'PAS' => '1727e998-3fb5-d9ef-b3a4-6031942f1560',
    //   'BOB' => 'cf9d558d-2a89-f503-f33a-a9c99889d016',
    //   'M' => '81015a84-b1cd-317d-f82c-5e5999524ac3',
    //   'FC' => 'cc902207-8db1-685b-9178-bfbd0f81c16e',
    //   'RAC' => '81015a84-b1cd-317d-f82c-5e5999524ac3',
    //   'MIL' => '1727e998-3fb5-d9ef-b3a4-6031942f1560',
    //   'ENV' => '1727e998-3fb5-d9ef-b3a4-6031942f1560',
    //   'CON' => '0d8e15b0-3e17-ba78-1419-b7498bae4700',
    //   'RL' => 'd72a294e-a515-6564-53a6-ec173eb8904e',
    //   'PEC' => '7e2c2a59-2255-db9e-403b-67f19df58b1c',
    //   'ROL' => 'd72a294e-a515-6564-53a6-ec173eb8904e',
    //   'PC' => '1727e998-3fb5-d9ef-b3a4-6031942f1560',
    //   'KG' => '26923e6b-72f3-2910-1c35-f3223f527bf7',
    //   'AMP' => '1727e998-3fb5-d9ef-b3a4-6031942f1560',
    //   'PÇ' => '1727e998-3fb5-d9ef-b3a4-6031942f1560',
    //   'CJ' => '0d8e15b0-3e17-ba78-1419-b7498bae4700',
    //   'UNI' => '81015a84-b1cd-317d-f82c-5e5999524ac3',
    //   'BB' => 'b11095ae-2dbe-d239-700e-414d385daf80',
    //   'JG' => '0d8e15b0-3e17-ba78-1419-b7498bae4700',
    // );

    // print_r($estimateitemsupdate);
    // return;

    // foreach ($estimateitemsupdate as $key => $value) {

    //   $unit = $this->db->select('
    //       id,
    //       name
    //     ')
    //     ->where('id', $units[$value->saleunitname])
    //     ->get('units')
    //     ->result();

    //   $data = array(
    //     'saleunitid' => $unit[0]->id,
    //     'saleunitname' => $unit[0]->name
    //   );

    //   print_r($value);
    //   print_r($unit);
    //   print_r($data);
    //   // return;

    //   $this->db->where(array('saleunitname' => $value->saleunitname))
    //     ->update('estimateitems', $data);

    // }

    // return;

    // create_producion_db( NULL, ['estimateitems'], TRUE );

    // echo '<pre>';

    // $filepath = FCPATH . 'uploads/pedidovendastatus.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 15000, ',', '"')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);

    // $status = array(
    //   'Aprovação do supervisor pendente' => '5032babc-7a17-8275-074b-3967c11c29d4',
    //   'Atendimento pendente' => '99169f7e-eb20-36c7-68f6-29c90d77e7d2',
    //   'Cancelado' => '05b9a902-91db-f7ff-bb25-f4b2b383bb09',
    //   'Faturado' => 'cc715d64-36ef-8f17-aa9c-ee973dbc84cd',
    //   'Faturamento pendente' => '1f2a6fba-10ae-27df-037e-202c883ef032',
    //   'Fechado' => 'dd006e89-1329-b8b4-14ad-e577a143c3a5',
    //   'Parcialmente atendido' => '250751c1-542e-f1a2-a854-da7641391db0'
    // );

    // foreach ($data as $key => $value) {

    //   $saleorder = $this->db->select('
    //      id,
    //      shippingaddress,
    //      billaddress
    //    ')
    //    ->where('externalid', $value['ID interno'])
    //    ->get('salesorders')
    //    ->result();

    //   if ($saleorder) {
    //     $data = array(
    //       'status' => $status[$value['Status']],
    //       'shippingaddress' => str_replace('<br>', PHP_EOL, $saleorder[0]->shippingaddress),
    //       'billaddress' => str_replace('<br>', PHP_EOL, $saleorder[0]->billaddress)
    //     );

    //     $this->db->where(array('id' => $saleorder[0]->id))
    //       ->update('salesorders', $data);
    //   }

    // }

    // return;

    // echo '<pre>';

    // $salesordersupdate = $this->db->select('
    //     id,
    //     employee,
    //     customerid,
    //     contactid,
    //     subsidiary,
    //     salesmanid,
    //     freighttypeid,
    //     carrierid,
    //     carriername,
    //     termsid,
    //     termsname,
    //     createdfrom
    //   ')
    //   ->where('`createdfrom` REGEXP "^[0-9]+$"')
    //   ->group_by('createdfrom')
    //   ->get('salesorders')
    //   ->result();

    // print_r($salesordersupdate);
    // return;

    // foreach ($salesordersupdate as $key => $value) {

    // }

    // return;

    // echo '<pre>';

    // $salesorderitemsupdate = $this->db->select('
    //     id,
    //     link,
    //     itemid,
    //     brandid,
    //     saleunitid,
    //     saleunitname,
    //     ncmid
    //     ncm,
    //     additionalinformation
    //   ')
    //   // ->where('`ncmid` REGEXP "^[0-9]+$"')
    //   ->where('`additionalinformation` !=', '')
    //   // ->group_by('ncmid')
    //   ->get('saleorderitems')
    //   ->result();

    // // print_r($salesorderitemsupdate);
    // // return;

    // foreach ($salesorderitemsupdate as $key => $value) {

    //   // $item = $this->db->select('
    //   //     items.id,
    //   //     items.saleunit as saleunitid,
    //   //     units.id as saleunitidcompare,
    //   //     units.name as saleunitname
    //   //   ')
    //   //   ->join('units', 'units.id = items.saleunit', 'left')
    //   //   ->where('items.id', $value->itemid)
    //   //   ->get('items')
    //   //   ->result();

    //   // print_r($value);
    //   // print_r($item);

    //   $additionalinformation = str_replace('<br>', '', $value->additionalinformation);
    //   $additionalinformation = str_replace('| |', '|', $additionalinformation);
    //   $additionalinformation = str_replace(' | ', '|', $additionalinformation);
    //   $additionalinformation = str_replace(' |', '|', $additionalinformation);
    //   $additionalinformation = str_replace(array("\r\n", "\n", "\r"), '', $additionalinformation);
    //   $additionalinformation = str_replace('|', PHP_EOL, $additionalinformation);

    //   print_r($additionalinformation);

    //   $data = array(
    //     'additionalinformation' => $additionalinformation
    //   );

    //   $this->db->where(array('id' => $value->id))
    //       ->update('saleorderitems', $data);

    // }

    // return;

    // create_producion_db( NULL, ['salesorders', 'estimates'], TRUE );

    // echo '<pre>';

    // $salesordersupdate = $this->db->select('
    //     id,
    //     externalid,
    //     customerid,
    //     customername,
    //     billaddressid,
    //     billaddress,
    //     shippingaddressid,
    //     shippingaddress,
    //   ')
    //   ->get('salesorders')
    //   ->result();

    // // print_r($salesordersupdate);
    // // return;

    // $i = 0;
    // foreach ($salesordersupdate as $key => $value) {

    //   $addresses = $this->db->select('
    //       id,
    //       address,
    //       street
    //     ')
    //     ->where('link', $value->customerid)
    //     ->get('addresses')
    //     ->result();

    //   $data = array(
    //     'billaddressid' => $value->billaddressid,
    //     'billaddress' => $value->billaddress,
    //     'shippingaddressid' => $value->shippingaddressid,
    //     'shippingaddress' => $value->shippingaddress,
    //   );

    //   if ($addresses) {
    //     foreach ($addresses as $key => $address) {
    //       if (strpos(mb_strtoupper($value->billaddress), mb_strtoupper($address->street)) !== FALSE) {
    //         $data['billaddressid'] = $address->id;
    //         $data['billaddress'] = $address->address;
    //       }

    //       if (strpos(mb_strtoupper($value->shippingaddress), mb_strtoupper($address->street)) !== FALSE) {
    //         $data['shippingaddressid'] = $address->id;
    //         $data['shippingaddress'] = $address->address;
    //       }
    //     }
    //   }

    //   // print_r($value);
    //   // print_r($addresses);
    //   // print_r($data);
    //   // echo PHP_EOL . PHP_EOL;
    //   // echo PHP_EOL . PHP_EOL;
    //   // return;

    //   $this->db->where(array('id' => $value->id))
    //     ->update('salesorders', $data);

    //   if ($i % 100 == 0) {
    //     print_r($i);
    //     echo PHP_EOL;
    //   }

    //   $i++;

    // }

    // return;

    // insert_production_data('invoicetax2');

    // echo '<pre>';

    // $filepath = FCPATH . 'uploads/faturas-status-cliente-transportadora.csv';
    // $handle = fopen($filepath, 'r');

    // $data = array();
    // $header = null;

    // while (($row = fgetcsv($handle, 15000, ',', '"')) !== false) {
    //   if (!$header) {
    //     $header = $row;
    //   } else {
    //     $data[] = array_combine($header, $row);
    //   }
    // }
    // fclose($handle);

    // $status = array(
    //   'Abrir' => '7135dd2c-f739-ee1f-333c-215f0db7fccd',
    //   'Aprovação do supervisor pendente' => '5032babc-7a17-8275-074b-3967c11c29d4',
    //   'Inutilizado' => '321e1ae3-a903-13de-0045-2d3aa29ce797',
    //   'Pago integralmente' => 'ede77718-f77a-f05e-f01d-138634454d37',
    //   'Rejeitado' => 'f49f69a1-a88b-e63b-7d8f-7d848582f3f9',
    // );



    // $i = 0;
    // foreach ($data as $key => $value) {

    //   $invoice = $this->db->select('
    //       id,
    //       externalid,
    //       customerid,
    //       customername,
    //       carrierid,
    //       carriername,
    //       billaddressid,
    //       billaddress,
    //       shippingaddressid,
    //       shippingaddress,
    //       status,
    //       termsid,
    //       termsname
    //     ')
    //     ->where('externalid', $value['id interno'])
    //     ->get('invoices')
    //     ->result();

    //   if ($invoice) {

    //     $data = array(
    //       'customerid' => $invoice[0]->customerid,
    //       'customername' => $invoice[0]->customername,
    //       'carrierid' => $invoice[0]->carrierid,
    //       'carriername' => $invoice[0]->carriername,
    //       'billaddressid' => $invoice[0]->billaddressid,
    //       'billaddress' => $invoice[0]->billaddress,
    //       'shippingaddressid' => $invoice[0]->shippingaddressid,
    //       'shippingaddress' => $invoice[0]->shippingaddress,
    //       'status' => $invoice[0]->status,
    //       'termsid' => null,
    //       'termsname' => ($value['condicoes de pagamento ava'] ? $value['condicoes de pagamento ava'] : $value['condicoes de pagamento cpb']),
    //     );

    //     $entity = $this->db->select('
    //         id,
    //         externalid,
    //         name
    //       ')
    //       ->like('externalid', '"' . $value['cliente id'] . '"', 'both')
    //       ->get('entities')
    //       ->result();

    //     if ($entity) {
    //       $data['customerid'] = $entity[0]->id;
    //     }

    //     $carrier = $this->db->select('
    //         id,
    //         externalid,
    //         name
    //       ')
    //       ->like('externalid', '"' . $value['transportadora fornecedor id'] . '"', 'both')
    //       ->get('entities')
    //       ->result();

    //     if ($carrier) {
    //       $data['carrierid'] = $carrier[0]->id;
    //     }

    //     if (strlen($invoice[0]->status) != 36) {
    //       $data['status'] = $status[$value['status']];
    //     }

    //     $addresses = $this->db->select('
    //         id,
    //         address,
    //         street
    //       ')
    //       ->where('link', $data['customerid'])
    //       ->get('addresses')
    //       ->result();

    //     if ($addresses) {
    //       foreach ($addresses as $key => $address) {
    //         if (strpos(mb_strtoupper($value['endereço de faturamento']), mb_strtoupper($address->street)) !== FALSE) {
    //           $data['billaddressid'] = $address->id;
    //           $data['billaddress'] = $address->address;
    //         }

    //         if (strpos(mb_strtoupper($value['endereço de entrega']), mb_strtoupper($address->street)) !== FALSE) {
    //           $data['shippingaddressid'] = $address->id;
    //           $data['shippingaddress'] = $address->address;
    //         }
    //       }
    //     }

    //     // print_r($value);
    //     // print_r($entity);
    //     // print_r($carrier);
    //     // print_r($invoice);
    //     // print_r($data);
    //     // return;

    //     $this->db->where(array('id' => $invoice[0]->id))
    //       ->update('invoices', $data);

    //   }

    //   if ($i % 100 == 0) {
    //     echo $i . PHP_EOL;
    //   }

    //   $i++;
    // }

    // return;

    // echo '<pre>';

    // $invoicesupdate = $this->db->select('
    //     id,
    //     externalid,
    //     termsid,
    //     termsname
    //   ')
    //   ->where('termsid IS NULL')
    //   ->group_by('termsname')
    //   ->get('invoices')
    //   ->result();

    // // print_r($invoicesupdate);
    // // return;

    // foreach ($invoicesupdate as $key => $value) {

    //   $data = array(
    //     'termsid' => $value->termsid,
    //     'termsname' => $value->termsname,
    //   );

    //   $terms = $this->db->select('
    //       id,
    //       externalid,
    //       name
    //     ')
    //     ->like('name', $value->termsname, 'none')
    //     ->get('terms')
    //     ->result();

    //   if ($terms) {
    //     $data['termsid'] = $terms[0]->id;
    //   }

    //   print_r($data);
    //   print_r($terms);

    //   $this->db->where(array('termsname' => $value->termsname))
    //     ->update('invoices', $data);
    // }

    // return;

    // echo '<pre>';

    // $invoicesupdate = $this->db->select('
    //     id,
    //     externalid,
    //     tranid,
    //     status,
    //     serviceid,
    //     customerid,
    //     customername,
    //     subsidiaryid,
    //     subsidiaryname,
    //     salesmanid,
    //     salesmanname,
    //     freighttypeid,
    //     freighttypename,
    //     carrierid,
    //     carriername,
    //     billaddressid,
    //     billaddress,
    //     shippingaddressid,
    //     shippingaddress,
    //     termsid,
    //     termsname,
    //     operationtypeid,
    //     operationtypename,
    //     createdfrom
    //   ')
    //   ->where('`createdfrom` REGEXP "^[0-9]+$"')
    //   // ->where('`termsid` IS NULL')
    //   // ->group_by('subsidiaryid')
    //   ->get('invoices')
    //   ->result();

    // // print_r($invoicesupdate);
    // // return;

    // foreach ($invoicesupdate as $key => $value) {

    //   $saleorder = $this->db->select('
    //       id,
    //       externalid,
    //       customerid,
    //       customername
    //     ')
    //     ->where('`externalid`', $value->createdfrom)
    //     ->get('salesorders')
    //     ->result();

    //   // print_r($value);
    //   // print_r($saleorder);
    //   // return;

    //   if ($saleorder) {

    //     $data = array(
    //       'createdfrom' => $saleorder[0]->id,
    //     );

    //     $this->db->where(array('id' => $value->id))
    //     ->update('invoices', $data);
    //   }


    // }

    // create_producion_db( NULL, ['invoices'], TRUE );



    $data['title'] = 'Dashboard | ' . $this->config->item('name');
    $data['class'] = 'dashboard';
    $data['js'] = array('header.js', 'dashboard.js');

    $this->my_header('headers/header', $data);
    $this->load->view('dashboard');
    $this->load->view('footers/footer');
  }
}
