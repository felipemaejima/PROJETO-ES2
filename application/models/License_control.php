<?php
defined('BASEPATH') or exit('No direct script access allowed');

class license_control extends CI_Model
{
  public function check_custumer_license($itemid, $custumerid)
  {
    $message = null;
    $item = $this->db->select('name, ncm, iscontrolledcivilpolice, iscontrolledfederalpolice, iscontrolledarmy')
      ->where('id', $itemid)
      ->get('items')
      ->result()[0];


    $item_controlled = [
      'civilpolice' => $item->iscontrolledcivilpolice == 'T' ? TRUE : FALSE,
      'federalpolice' => $item->iscontrolledfederalpolice == 'T' ? TRUE : FALSE,
      'army' => $item->iscontrolledarmy == 'T' ? TRUE : FALSE
    ];

    foreach ($item_controlled as $type => $iscontrolled) {
      if ($iscontrolled) {
        $client_license = $this->db->select($type . 'license AS license, date' . $type . 'license AS datelicense')
          ->where('id', $custumerid)
          ->get('entities')
          ->result()[0];

        if (!empty($client_license->license) && $client_license->datelicense >= time()) {
          $select = '';
          if ($type == 'army') {
            $select = 'permissionsarmy, quantityarmy';
          } else if ($type == 'federalpolice') {
            $select = 'permissionsfederalpolice';
          } else {
            continue;
          }

          $client_license_control = $this->db->select($select)
            ->where('link', $custumerid)
            ->where('ncm', $item->ncm)
            ->get('licensecontrol')
            ->result_array();

          if (!empty($client_license_control)) {
            $permissions = json_decode($client_license_control[0]['permissions' . $type]);

            $licensesactivities_consult = $this->db->select('id, name')
              ->get('licenseactivities' . $type)
              ->result_array();

            $licensesactivities = [];
            foreach ($licensesactivities_consult as $key => $value) {
              if ($value['name'] == 'comercialização' || $value['name'] == 'utilização para consumo') {
                array_push($licensesactivities, $value['id']);
              }
            }

            if ($missing_licenses = array_diff($licensesactivities, $permissions)) {
              foreach ($licensesactivities_consult as $key => $value) {
                if (in_array($value['id'], $missing_licenses)) {
                  $message .= "O cliente não possui permissão para a atividade de " . $value['name'] . ", requerida para comprar o item " . $item->name . ".<br>";
                }
              }
            }
          } else {
            $message .= "O cliente não possui permissões referentes ao ncm " . $item->ncm . ", requerida para comprar o item " . $item->name . ".<br>";
          }
        } else {
          if (empty($client_license->license)) {
            $message .= "O cliente não possui a licença " . $this->translate_license($type) . ", requerida para comprar o item " . $item->name . ".<br>";
          } else if ($client_license->datelicense < time()) {
            $message .= "A licença " . $this->translate_license($type) . ", requerida para comprar o item " . $item->name . ", expirou.<br>";
          }
        }
      }
    }

    return $message;
  }

  private function translate_license($type)
  {
    switch ($type) {
      case 'army':
        return 'do exército';
      case 'federalpolice':
        return 'da polícia federal';
      case 'civilpolice':
        return 'da polícia civil';
    }
  }
}
