<?php if (!defined('BASEPATH'))
  exit('No direct script access allowed');

// generate a unique identification number
if (!function_exists('uuidv4')) {
  function uuidv4($data = null)
  {
    $data = $data ?? random_bytes(16);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }
}

// checks if the string has only letters
if (!function_exists('check_string')) {
  function check_string($string)
  {
    $result = (bool) preg_match('/^[a-zA-ZaáàãâeéèêiíìîoóòõôuúùûçñÁÀÃÂEÉÈÊIÍÌÎOÓÒÕÔUÚÙÛÇÑ ]+$/i', $string);
    if ($result) {
      return TRUE;
    }
    return FALSE;
  }
}

if (!function_exists('stringtotimestamp')) {
  function stringtotimestamp($date)
  {
    if (!$date) {
      return NULL;
    }
    if (strpos($date, ':') !== false) {
      $date = explode(' ', $date);
      $date = implode('-', array_reverse(explode('/', $date[0]))) . ' ' . $date[1];
    } else {
      $date = implode('-', array_reverse(explode('/', $date)));
    }
    return $date ? strtotime($date) : NULL;
  }

}

// remove tudo que não seja letra ou numero
if (!function_exists('clean_string')) {
  function clear_string($string)
  {
    return preg_replace('/[^a-zA-Z0-9]/', '', $string);
  }
}

// procura um valor dentro de um array ou objeto (uni ou bi dimensional)
if (!function_exists('search_value')) {

  function search_value($needle, array $data)
  {
    $finded = [];
    foreach ($data as $key => $indata) {

      if (((is_array($indata) || is_object($indata)) && in_array($needle, (array) $indata)) || $needle === $indata)
        $finded[$key] = $indata;

    }
    return !!$finded ? $finded : FALSE;
  }
}

if (!function_exists('get_days_difference')) {
  function get_days_difference($timestamp)
  {
    $current = time();
    $currentdate = new DateTime();
    $currentdate->setTimestamp($current);

    $timestampdate = new DateTime();
    $timestampdate->setTimestamp($timestamp);

    $diff = $currentdate->diff($timestampdate);

    return $diff->days;
  }

}

if (!function_exists('check_session')) {
  function check_session($session)
  {
    $ci = get_instance();
    $session = $ci->session->userdata($session);
    if ($session) {
      return $session;
    }
    return FALSE;
  }
}

if (!function_exists('check_access')) {
  function check_access($roles, $function, $permissions)
  {
    $ci = get_instance();
    foreach ($roles as $role) {
      $permission = $ci->db->select('permissions')
        ->where('id', $role)
        ->get('roles')
        ->result();
      if ($permission) {
        foreach (json_decode($permission[0]->permissions) as $row) {
          if ($row->name == $function && in_array($row->level, $permissions)) {
            return TRUE;
          }
        }
      }
    }
    return FALSE;
  }
}

if (!function_exists('get_session_data')) {
  function get_session_data($session)
  {
    $ci = get_instance();

    $session = $ci->db->select('user_id')
      ->where('session_token', $session)
      ->get('user_sessions')
      ->result();

    if ($session) {
      return $session[0]->user_id;
    }
    $ci->session->unset_userdata('session_token');
    return FALSE;
  }
}

if (!function_exists('get_input')) {
  function get_input($type, $name, $placeholder, $icon = FALSE, $value = FALSE, $disabled = FALSE, $link = FALSE)
  {
    if ($type == 'hidden') {
      return '<input type="' . $type . '" name="' . $name . '" value="' . ($value ? $value : '') . '" ' . ($disabled ? 'disabled' : '') . '>';
    }
    return '<div class="form-input-content">
    <label for="' . $name . '">' . $placeholder . '</label>
    <div class="count-characters"></div>
    <div class="form-input-box">
    ' . ($link ? '<a href="' . $link . '" target="_blank">' . $icon . '</a>' : ($icon ? $icon : '')) . '
    <input type="' . $type . '" name="' . $name . '" placeholder="' . $placeholder . '" value="' . ($value ? $value : '') . '" ' . ($disabled ? 'disabled' : '') . '>
    </div>
    <div class="error-' . $name . ' error-input"></div>
    </div>';
  }
}

if (!function_exists('get_select')) {
  function get_select($name, $title, $icon = FALSE, $list = FALSE, $value = FALSE, $disabled = FALSE, $exclude = FALSE)
  {
    $options = '';
    if ($list) {
      foreach ($list as $line) {
        if ($exclude && (in_array($line->id, $exclude) || in_array($line->title, $exclude))) {
          continue;
        }
        $options .= '<option value="' . $line->id . '" ' . ($value && $line->id == $value ? 'selected' : '') . '>' . $line->title . '</option>';
      }
    }
    return '<div class="form-input-content">
    <label for="' . $name . '">' . $title . '</label>
    <div class="form-input-box">
    ' . ($icon ? $icon : '') . '
    <select name="' . $name . '" ' . ($disabled ? 'disabled' : '') . '>
    <option value="">Escolha um(a) ' . $title . '</option>'
      . $options .
      '</select>
    </div>
    <div class="error-' . $name . ' error-input"></div>
    </div>';
  }
}

if (!function_exists('get_textarea')) {
  function get_textarea($name, $rows, $placeholder, $text = FALSE, $disabled = FALSE)
  {
    return '<div class="form-input-content">
    <label for="' . $name . '">' . $placeholder . '</label>
    <div class="form-input-box">
    <textarea name="' . $name . '" rows="' . $rows . ' " placeholder="' . $placeholder . '" ' . ($disabled ? 'disabled' : '') . '>' . ($text ? $text : '') . '</textarea>
    </div>
    <div class="error-' . $name . ' error-input"></div>
    </div>';
  }
}

if (!function_exists('get_checkbox')) {
  function get_checkbox($name, $title, $disabled = FALSE, $value = FALSE)
  {
    return '<div class="form-input-content">
    <div class="form-input-box no-background">
    <input type="checkbox" id="' . $name . '" class="toggle" name="' . $name . '" ' . ($value == 'T' ? 'checked' : '') . ' ' . ($disabled ? 'disabled' : '') . '>
    <label for="' . $name . '">
    <span></span>
    </label>
    <p>' . $title . '</p>
    </div>
    <div class="error-' . $name . ' error-input"></div>
    </div>';
  }
}

if (!function_exists('get_checkbox_button')) {
  function get_checkbox_button($name, $title, $disabled = FALSE, $value = FALSE)
  {
    $shuffle = bin2hex(random_bytes(8));
    if ($value) {
      $value = in_array($title, json_decode($value));
    }
    $val = is_string($title) ? $title : $title->id;
    $label = is_string($title) ? $title : $title->title;
    return '<div class="form-input-content">
    <div class="form-input-box no-background">
    <input type="checkbox" id="' . $shuffle . '" value="' . $val . '" ' . ' name="' . $name . '" ' . ($value ? 'checked' : FALSE) . ' ' . ($disabled ? 'disabled' : '') . '>
    <label for="' . $shuffle . '">' . $label . '</label>
    </div>
    </div>';
  }
}



if (!function_exists('get_file')) {
  function get_file($name, $title, $accept)
  {
    return '<div class="form-input-content">
    <label for="' . $name . '">' . $title . '</label>
    <div class="form-input-box drag-drop">
      <div class="drag-drop-content">
        <input name="' . $name . '" id="' . $name . '" ref="fileInput" type="file" class="file" accept="' . $accept . '">
        <div class="file-upload">
          <i class="ph ph-upload"></i>
          <br />
          escolha um arquivo ou arraste-o aqui
        </div>
      </div>
    </div>
    <div class="error-' . $name . ' error-input"></div>
  </div>';
  }
}

if (!function_exists('check_cpf')) {
  function check_cpf($cpf)
  {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
      return FALSE;
    } else {
      for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
          $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
          return FALSE;
        }
      }
      return $cpf;
    }
  }
}

if (!function_exists('check_cnpj')) {
  function check_cnpj($cnpj)
  {
    $j = 0;
    for ($i = 0; $i < (strlen($cnpj)); $i++) {
      if (is_numeric($cnpj[$i])) {
        $num[$j] = $cnpj[$i];
        $j++;
      }
    }
    if (count($num) != 14) {
      return FALSE;
    }
    if ($num[0] == 0 && $num[1] == 0 && $num[2] == 0 && $num[3] == 0 && $num[4] == 0 && $num[5] == 0 && $num[6] == 0 && $num[7] == 0 && $num[8] == 0 && $num[9] == 0 && $num[10] == 0 && $num[11] == 0) {
      $isCnpjValid = FALSE;
    } else {
      $j = 5;
      for ($i = 0; $i < 4; $i++) {
        $multiply[$i] = $num[$i] * $j;
        $j--;
      }
      $sum = array_sum($multiply);
      $j = 9;
      for ($i = 4; $i < 12; $i++) {
        $multiply[$i] = $num[$i] * $j;
        $j--;
      }
      $sum = array_sum($multiply);
      $resto = $sum % 11;
      if ($resto < 2) {
        $dg = 0;
      } else {
        $dg = 11 - $resto;
      }
      if ($dg != $num[12]) {
        $isCnpjValid = FALSE;
      }
    }
    if (!isset($isCnpjValid)) {
      $j = 6;
      for ($i = 0; $i < 5; $i++) {
        $multiply[$i] = $num[$i] * $j;
        $j--;
      }
      $sum = array_sum($multiply);
      $j = 9;
      for ($i = 5; $i < 13; $i++) {
        $multiply[$i] = $num[$i] * $j;
        $j--;
      }
      $sum = array_sum($multiply);
      $resto = $sum % 11;
      if ($resto < 2) {
        $dg = 0;
      } else {
        $dg = 11 - $resto;
      }
      if ($dg != $num[13]) {
        $isCnpjValid = FALSE;
      } else {
        $isCnpjValid = TRUE;
      }
    }
    if ($isCnpjValid) {
      return preg_replace('/[^0-9]/', '', $cnpj);
    } else {
      return FALSE;
    }
  }
}

if (!function_exists('check_date')) {
  function check_date($date)
  {
    return preg_match('/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/(19|20)\d\d$/', $date);
  }
}

if (!function_exists('check_ncm')) {
  function check_ncm($ncm)
  {

    $ci = get_instance();

    $ncm = $ci->db->select('name, title')
      ->where('name', $ncm)
      ->or_where('title', $ncm)
      ->get('ncms')
      ->result();

    if (!$ncm) {
      return FALSE;
    }
    return TRUE;
  }

}

if (!function_exists('check_cfop')) {
  function check_cfop($cfop)
  {

    $ci = get_instance();

    $cfop = $ci->db->select('name, title')
      ->where('name', $cfop)
      ->or_where('title', $cfop)
      ->get('cfops')
      ->result();

    if (count($cfop) == 0 || !$cfop) {
      return FALSE;
    }
    return TRUE;
  }

}

if (!function_exists('check_bank')) {
  function check_bank($bank)
  {

    $ci = get_instance();

    $bank = $ci->db->select('name')
      ->where('name', $bank)
      ->get('banks')
      ->result();

    if (!$bank) {
      return FALSE;
    }
    return TRUE;
  }

}

if (!function_exists('edited_data')) {
  function edited_data($post, $data)
  {
    $ci = get_instance();

    $edited_data = array();

    foreach ($post as $key => $value) {
      if (
        in_array(
          $key,
          array(
            'subsidiaryid',
            'selectbilladdress',
            'termsid',
            'carrierid',
            'freighttypeid',
            'contactid',
            'itemdescription',
            'resolution',
            'confirm_password',
            'ip',
            'platform',
            'agent',
            'referer',
            'created',
            'updated'
          )
        )
      ) {
      } else {
        if ($key === 'password') {
          $edited_data[$key] = array(
            'previus' => '********',
            'new' => 'password has changed'
          );
        } else if ($value != $data->$key) {
          $previus = $data->$key;
          $new = $value;
          if ($key === 'dateofbirth' || $key === 'installmentdeadline') {
            $previus = $previus ? date('d/m/Y', $previus) : '';
            $new = $new ? date('d/m/Y', $new) : '';
          }
          if ($key === 'salutation') {
            $array = $ci->db->select('id, name, title')
              ->get('salutations')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'title') {
            $array = $ci->db->select('id, name, title')
              ->get('titles')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'supervisor' || $key === 'immediateapprover' || $key === 'topapprover') {
            $array = $ci->db->select('id, name')
              ->get('users')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->name : '';
            $new = $new ? $array[get_position_array($new, $array)]->name : '';
          }
          if ($key === 'subsidiary') {
            $array = $ci->db->select('id, name, title')
              ->get('subsidiaries')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'roles') {
            $array = $ci->db->select('id, name as title')
              ->get('roles')
              ->result();
            $previus_array = '';
            $new_array = '';
            if ($previus) {
              foreach (json_decode($previus) as $row) {
                $previus_array .= $array[get_position_array($row, $array)]->title . '<br/> ';
              }
            }
            if ($new) {
              foreach (json_decode($new) as $row) {
                $new_array .= $array[get_position_array($row, $array)]->title . '<br/> ';
              }
            }
            $previus = $previus ? json_encode($previus_array) : '';
            $new = $new ? json_encode($new_array) : '';
          }
          if ($key === 'permissions') {
            $previus_array = '';
            $new_array = '';
            if ($previus) {
              foreach (json_decode($previus) as $row) {
                $previus_array .= $row->name . ' -> ' . $row->level . '<br/> ';
              }
            }
            foreach (json_decode($new) as $row) {
              $new_array .= $row->name . ' -> ' . $row->level . '<br/> ';
            }
            $previus = $previus ? json_encode($previus_array) : '';
            $new = json_encode($new_array);
          }
          if ($key === 'taxregime') {
            $array = $ci->db->select('id, name, title')
              ->get('taxregimes')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'preferredvoltage') {
            $array = $ci->db->select('id, name, title')
              ->get('preferredvoltages')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'group') {
            $array = $ci->db->select('id, name, title')
              ->get('groups')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'subgroup') {
            $array = $ci->db->select('id, name, title')
              ->get('subgroups')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'activitysector') {
            $array = $ci->db->select('id, name, title')
              ->get('activitysectors')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'freighttype') {
            $array = $ci->db->select('id, name, title')
              ->get('freighttypes')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'paymentweek' || $key === 'paymentmonth' || $key === 'invoicingmonth') {
            $previus_array = '';
            $new_array = '';
            if ($previus) {
              foreach (json_decode($previus) as $row) {
                $previus_array .= $row . ', ';
              }
            }
            if ($new) {
              foreach (json_decode($new) as $row) {
                $new_array .= $row . ', ';
              }
            }
            $previus = $previus ? json_encode($previus_array) : '';
            $new = json_encode($new_array);
          }
          if ($key === 'permissionsfederalpolice') {
            $array = $ci->db->select('id, name, title')
              ->get('licenseactivitiesfederalpolice')
              ->result();
            $previus_array = '';
            $new_array = '';
            if ($previus) {
              foreach (json_decode($previus) as $row) {
                $previus_array .= $array[get_position_array($row, $array)]->title . ', ';
              }
            }
            if ($new) {
              foreach (json_decode($new) as $row) {
                $new_array .= $array[get_position_array($row, $array)]->title . ', ';
              }
            }
            $previus = $previus ? json_encode($previus_array) : '';
            $new = $new ? json_encode($new_array) : '';
          }
          if ($key === 'permissionsarmy') {
            $array = $ci->db->select('id, name, title')
              ->get('licenseactivitiesarmy')
              ->result();
            $previus_array = '';
            $new_array = '';
            if ($previus) {
              foreach (json_decode($previus) as $row) {
                $previus_array .= $array[get_position_array($row, $array)]->title . ', ';
              }
            }
            if ($new) {
              foreach (json_decode($new) as $row) {
                $new_array .= $array[get_position_array($row, $array)]->title . ', ';
              }
            }
            $previus = $previus ? json_encode($previus_array) : '';
            $new = $new ? json_encode($new_array) : '';
          }
          if ($key === 'brand') {
            $array = $ci->db->select('id, name, title')
              ->get('brands')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'subsidiaries') {
            $previus_array = '';
            $new_array = '';
            if ($previus) {
              foreach (json_decode($previus) as $row) {
                $previus_array .= $row . ', ';
              }
            }
            if ($new) {
              foreach (json_decode($new) as $row) {
                $new_array .= $row . ', ';
              }
            }
            $previus = $previus ? json_encode($previus_array) : '';
            $new = json_encode($new_array);
          }
          if ($key === 'saleunit') {
            $array = $ci->db->select('id, name, title')
              ->get('units')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'voltage') {
            $array = $ci->db->select('id, name, title')
              ->get('voltages')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'warranty') {
            $array = $ci->db->select('id, name, title')
              ->get('warranties')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'currency') {
            $array = $ci->db->select('id, name, title')
              ->get('currencies')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'pavilion' || $key === 'pallet' || $key === 'hall' || $key === 'street' || $key === 'shelfa' || $key === 'shelfb' || $key === 'shelfc' || $key === 'shelfd' || $key === 'shelfe' || $key === 'shelff' || $key === 'shelfg' || $key === 'shelfh' || $key === 'shelfi' || $key === 'shelfj' || $key === 'shelfk' || $key === 'shelfl' || $key === 'shelfm' || $key === 'shelfn' || $key === 'shelfo' || $key === 'shelfp' || $key === 'shelfq' || $key === 'shelfr' || $key === 'shelfs' || $key === 'shelft' || $key === 'shelfu' || $key === 'shelfv' || $key === 'shelfw' || $key === 'shelfx' || $key === 'shelfy' || $key === 'shelfz') {
            $previus_array = '';
            $new_array = '';
            if ($previus) {
              foreach (json_decode($previus) as $row) {
                $previus_array .= $row . ', ';
              }
            }
            if ($new) {
              foreach (json_decode($new) as $row) {
                $new_array .= $row . ', ';
              }
            }
            $previus = $previus ? json_encode($previus_array) : '';
            $new = json_encode($new_array);
          }
          if ($key === 'saleunit' || $key === 'purchaseunit') {
            $array = $ci->db->select('id, name, title')
              ->get('units')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'itemorigin') {
            $array = $ci->db->select('id, name, title')
              ->get('itemorigintypes')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          if ($key === 'status') {
            $array = $ci->db->select('id, name, title')
              ->get('status')
              ->result();
            $previus = $previus ? $array[get_position_array($previus, $array)]->title : '';
            $new = $new ? $array[get_position_array($new, $array)]->title : '';
          }
          $edited_data[$key] = array(
            'previus' => $previus,
            'new' => $new
          );
        } else {
        }
      }
    }
    if ($edited_data) {
      return $edited_data;
    }
    return;
  }
}

if (!function_exists('get_position_array')) {
  function get_position_array($id, $array)
  {
    return array_search($id, array_column($array, 'id'));
  }
}

if (!function_exists('editpurchaseorderstatus')) {
  function editpurchaseorderstatus($purchaseorder, $userid, $userroles)
  {

    $ci = get_instance();

    $purchaseorderitems = $ci->db->select('id, link, line, linequantityonhand, linequantityreceived, linequantitybilled, linequantity')
      ->where('link', $purchaseorder)
      ->where('isinactive', 'F')
      ->get('purchaseorderitems')
      ->result();

    $purchaseorderquantity = 0;
    $receiptquantity = 0;

    foreach ($purchaseorderitems as $key => $value) {
      $purchaseorderquantity += $value->linequantity;
      $receiptquantity += $value->linequantityreceived;
    }

    $previus_data = $ci->db->select('id, status')
      ->where('id', $purchaseorder)
      ->get('purchaseorders')
      ->result();

    $status = $previus_data[0]->status;

    if ($purchaseorderquantity == $receiptquantity) {
      $status = '870d6410-6666-9a50-f2be-49c8bcdb8ff6';
    }

    if ($receiptquantity < $purchaseorderquantity || $purchaseorderquantity > $receiptquantity) {
      $status = '7b6bc4d0-5e2d-67c6-b239-ecb9bbe0e030';
    }

    if ($receiptquantity == 0 && $status == '7b6bc4d0-5e2d-67c6-b239-ecb9bbe0e030') {
      $status = '7135dd2c-f739-ee1f-333c-215f0db7fccd';
    }

    $purchaseorderstatus = array(
      'status' => $status,
      'ip' => $ci->input->ip_address(),
      'platform' => $ci->agent->platform(),
      'agent' => $ci->agent->browser() . ' ' . $ci->agent->version(),
      'referer' => $ci->agent->referrer(),
      'updated' => time()
    );

    $ci->db->where(array('id' => $purchaseorder))
      ->update('purchaseorders', $purchaseorderstatus);

    $ci->data_persistence->log(
      [
        'table' => 'purchaseorder',
        'action' => 'edited purchase order',
        'user_id' => $userid,
        'user_role' => $userroles,
        'defined' => $purchaseorder,
        'data' => [
          'message' => 'Pedido de compra editado com sucesso.',
          'process' => edited_data($purchaseorderstatus, $previus_data[0])
        ]
      ],
    );
    return;
  }
}

if (!function_exists('editsaleorderstatus')) {
  function editsaleorderstatus($saleorderid, $userid, $userroles)
  {
    $ci = get_instance();

    $saleorder = $ci->db->select('SUM(itemquantity) as total')
      ->where('link', $saleorderid)
      ->get('saleorderitems')
      ->result();

    $separation = $ci->db->select('id')
      ->where('createdfrom', $saleorderid)
      ->get('separations')
      ->result();

    $committed = $ci->db->select('COALESCE(SUM(itemquantitycommitted), 0) as quantity')
      ->where('link', $separation[0]->id ?? NULL)
      ->where('isinactive', 'F')
      ->get('separationitems')
      ->result();

    $service = $ci->db->select('id')
      ->where('createdfrom', $saleorderid)
      ->get('services')
      ->result();

    $served = $ci->db->select('COALESCE(SUM(itemquantityserved), 0) as quantity')
      ->where('link', $service[0]->id ?? NULL)
      ->where('isinactive', 'F')
      ->get('serviceitems')
      ->result();

    $invoice = $ci->db->select('id')
      ->where('createdfrom', $saleorderid)
      ->get('invoices')
      ->result();

    $invoiced = $ci->db->select('COALESCE(SUM(itemquantity), 0) as quantity')
      ->where('link', $invoice[0]->id ?? NULL)
      ->where('isinactive', 'F')
      ->get('invoiceitems')
      ->result();

    $previus_data = $ci->db->select('status')
      ->where('id', $saleorderid)
      ->get('salesorders')
      ->result();

    $previus_status = $ci->db->select('id, name')
      ->where('id', $previus_data[0]->status)
      ->get('status')
      ->result();

    $status = $previus_status[0]->name;
    // atente-se aos nomes dos status, precisam ser iguais aos da tabela de status no banco de dados
    // todo exceção para quando algumas das quantidades for zerada (voltar o status - a discutir)
    if (isset($committed[0]->quantity)) {
      $status = (int) $committed[0]->quantity >= $saleorder[0]->total ? 'separado' : 'parcialmente separado';
    }

    if (isset($served[0]->quantity)) {
      $status = (int) $served[0]->quantity >= $saleorder[0]->total ? 'atendido' : 'parcialmente atendido';
    }

    if (isset($invoiced[0]->quantity)) {
      $status = (int) $invoiced[0]->quantity >= $saleorder[0]->total ? 'faturado' : 'parcialmente faturado';
    }

    $statusdata = $ci->db->select('id, name')
      ->where('name', $status)
      ->get('status')
      ->result();

    if ($status != $previus_status[0]->name) {
      $ci->db->where(array('id' => $saleorderid))
        ->update('salesorders', array('status' => $statusdata[0]->id));

      $ci->data_persistence->log(
        [
          'table' => 'saleorder',
          'action' => 'edited saleorder',
          'user_id' => $userid,
          'user_role' => $userroles,
          'defined' => $saleorderid,
          'data' => [
            'message' => 'Pedido de venda editado com sucesso.',
            'process' => edited_data(array('status' => $statusdata[0]->id), $previus_data[0])
          ]
        ]
      );
    }
    return;
  }
}

if (!function_exists('editreturnauthorizationstatus')) {
  function editreturnauthorizationstatus($returnauthorizationid, $userid, $userroles)
  {
    $ci = get_instance();

    $returnauthorization = $ci->db->select('SUM(itemquantity) as total')
      ->where('link', $returnauthorizationid)
      ->get('returnauthorizationitems')
      ->result();

    $returnreceipt = $ci->db->select('id')
      ->where('createdfrom', $returnauthorizationid)
      ->get('returnreceipts')
      ->result();

    $received = $ci->db->select('COALESCE(SUM(linereceived), 0) as quantity')
      ->where('link', $returnreceipt[0]->id ?? NULL)
      ->where('isinactive', 'F')
      ->get('returnreceiptitems')
      ->result();

    $previus_data = $ci->db->select('status')
      ->where('id', $returnauthorizationid)
      ->get('returnauthorizations')
      ->result();

    $previus_status = $ci->db->select('id, name')
      ->where('id', $previus_data[0]->status)
      ->get('status')
      ->result();

    $status = $previus_status[0]->name;
    // atente-se aos nomes dos status, precisam ser iguais aos da tabela de status no banco de dados
    if (isset($received[0]->quantity)) {
      $status = (int) $received[0]->quantity >= $returnauthorization[0]->total ? 'recebido' : 'parcialmente recebido';
    }

    $statusdata = $ci->db->select('id, name')
      ->where('name', $status)
      ->get('status')
      ->result();

    if ($status != $previus_status[0]->name) {
      $ci->db->where(array('id' => $returnauthorizationid))
        ->update('returnauthorizations', array('status' => $statusdata[0]->id));

      $ci->data_persistence->log(
        [
          'table' => 'returnauthorization',
          'action' => 'edited return authorization',
          'user_id' => $userid,
          'user_role' => $userroles,
          'defined' => $returnauthorizationid,
          'data' => [
            'message' => 'Autorização de devolução editada com sucesso.',
            'process' => edited_data(array('status' => $statusdata[0]->id), $previus_data[0])
          ]
        ]
      );
    }
    return;

  }

}

if (!function_exists('form_validation_errors')) {
  function form_validation_errors(array $additionalmessage = array())
  {
    $ci = &get_instance();

    $errors = array(
      'error' => TRUE,
      'error-fields' => array(),
      'CSRFerp' => $ci->security->get_csrf_hash()
    );

    foreach ($ci->form_validation->error_array() as $key => $value) {
      $k = clear_string($key);
      $k = substr($k, -2) == 'id' ? substr($k, 0, -2) : $k;
      $message = str_replace(' id ', ' ', $value);
      $errors['error-fields']["error-$k"] = $message;
    }

    $errors['error-fields']['errors'] = implode('<br>', $errors['error-fields']);

    $errors['error-fields'] = (object) $errors['error-fields'];

    $response = array_merge($errors, $additionalmessage);

    header('Content-Type: application/json');
    echo json_encode($response);
    return;
  }
}

if (!function_exists('check_user_is_allowed')) {

  function check_user_is_allowed(string $roles, string $function, array $permissions): void
  {
    $ci = get_instance();
    $check = check_access(json_decode($roles), $function, $permissions);
    if (!$check && $ci->input->server('REQUEST_METHOD') == 'POST') {
      http_response([
        'message' => "Você não tem permissão para acessar este recurso!"
      ], TRUE);
      exit;
    }
    if (!$check) {
      $ci->session->set_flashdata('error', 'Você não tem permissão para acessar este recurso!');

      if (isset($_SERVER['HTTP_REFERER'])) {
        redirect($_SERVER['HTTP_REFERER'], 'refresh');
      } else {
        redirect('dashboard', 'refresh');
      }
      exit;
    }

  }
}

if (!function_exists('http_response')) {

  function http_response(array $additionalmessage = array(), bool $haserror = FALSE, int $statuscode = 200)
  {

    $ci = get_instance();

    $errors = array(
      'error' => $haserror,
      'CSRFerp' => $ci->security->get_csrf_hash()
    );

    $response = array_merge($errors, $additionalmessage);

    $ci->output->set_status_header($statuscode);

    header('Content-Type: application/json');
    echo json_encode($response);
    return;
  }

}

if (!function_exists('find_table_with_id')) {
  function find_table_with_id($id)
  {

    if (!$id) {
      return FALSE;
    }

    $ci = get_instance();

    $dbname = $ci->db->database;

    $tables = $ci->db->query("SHOW TABLES")->result_array();

    foreach ($tables as $table) {
      $tablename = $table["Tables_in_$dbname"];

      $ci->db->reset_query();
      $ci->db->where('id', $id);
      $query = $ci->db->get($tablename);

      if ($query->num_rows() > 0) {
        return $tablename;
      }
    }

    return FALSE;
  }
}

if (!function_exists('insert_production_data')) {
  function insert_production_data($tablename, $truncate = FALSE)
  {
    if (!$tablename) {
      trigger_error('No table name provided');
      return;
    }

    $ci = get_instance();
    $ci->load->database();
    $ci->load->helper('file');

    $path = FCPATH . 'db/productionData/';

    $files = get_filenames($path);

    foreach ($files as $file) {
      if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
        $sql = file($path . $file);

        $filetable = preg_replace('/\d+/', '', explode('_', $tablename)[0]);

        if (!in_array($file, array("$tablename.sql"))) {
          continue;
        }

        if ($truncate) {
          $ci->db->query("TRUNCATE TABLE  `$filetable`;");
        }

        $instruction = preg_replace('/\r\n|\r|\n/', '', $sql[0]);

        $ci->db->trans_start();
        $query = '';
        $linehasinsert = substr(trim($sql[0]), -1) == ';';
        foreach ($sql as $line) {
          if ($linehasinsert) {
            $ci->db->query(trim($line));
            continue;
          }
          if ($line == $sql[0]) {
            continue;
          }
          if (!empty($line) && (substr(trim($line), -1) == ';' || substr(trim($line), -2) == '),')) {
            $query .= trim(substr(trim($line), 0, -1));
            $query = "$instruction $query;";
            $ci->db->query($query);
            $query = '';
            continue;

          }
          $query .= "$line\n";
        }
        $ci->db->trans_complete();

        if ($ci->db->trans_status() === FALSE) {
          log_message('error', 'Erro ao executar o arquivo SQL: ' . $file);
        } else {
          log_message('info', 'Arquivo SQL executado com sucesso: ' . $file);
        }
      }
    }
  }
}

if (!function_exists('update_db')) {
  function update_db($tablename = FALSE)
  {

    $ci = get_instance();
    $ci->load->database();
    $ci->load->helper('file');

    $path = FCPATH . 'db/tables/';

    $files = get_filenames($path);

    foreach ($files as $file) {

      if (in_array($file, array('ci_sessions.sql'))) {
        continue;
      }

      if ($tablename && !in_array($file, array("$tablename.sql"))) {
        continue;
      }

      if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
        $sql = file($path . $file);
        $sql = array_slice($sql, 4);
        $sql = implode('', $sql);

        // $queries = explode(';\r', $sql);
        $queries = preg_split('/;\r\n|;\r|;\n/', $sql);

        // if (in_array($file, array('accounts.sql'))) {
        //   echo '<pre>';
        //   print_r($queries);
        //   exit();
        // }

        $ci->db->trans_start();
        foreach ($queries as $query) {
          $query = trim($query);
          if (!empty($query)) {
            $ci->db->query($query);
          }
        }
        $ci->db->trans_complete();

        if ($ci->db->trans_status() === FALSE) {
          log_message('error', 'Erro ao executar o arquivo SQL: ' . $file);
        } else {
          log_message('info', 'Arquivo SQL executado com sucesso: ' . $file);
        }
      }
    }
  }
}

if (!function_exists('create_db')) {
  function create_db(array $excludes = NULL, array $includes = NULL, $includedata = TRUE)
  {
    $ci = get_instance();
    $ci->load->database();
    $ci->load->dbutil();
    $ci->load->helper('file');

    $path = FCPATH . 'db/tables/';

    $tables = $ci->db->list_tables();

    foreach ($tables as $table) {
      if ($excludes && in_array($table, $excludes)) {
        continue;
      }
      if ($includes && !in_array($table, $includes)) {
        continue;
      }
      $prefs = array(
        'tables' => array($table),
        'format' => 'txt',
        'add_drop' => true,
        'add_insert' => $includedata,
        'newline' => "\n"
      );

      $backup = $ci->dbutil->backup($prefs);

      if (!write_file($path . $table . '.sql', $backup)) {
        log_message('error', 'Erro ao salvar o arquivo SQL para a tabela: ' . $table);
      } else {
        log_message('info', 'Arquivo SQL salvo com sucesso para a tabela: ' . $table);
      }
    }
  }
}

if (!function_exists('create_producion_db')) {
  function create_producion_db(array $excludes = NULL, array $includes = NULL, $includedata = TRUE, $batch_size = 30000)
  {
    $ci = get_instance();
    $ci->load->database();
    $ci->load->dbutil();
    $ci->load->helper('file');

    $path = FCPATH . 'db/productionData/';

    // Certifique-se que o diretório existe
    if (!is_dir($path)) {
      mkdir($path, 0755, true);
    }

    $tables = $ci->db->list_tables();

    foreach ($tables as $table) {
      if ($excludes && in_array($table, $excludes)) {
        continue;
      }
      if ($includes && !in_array($table, $includes)) {
        continue;
      }

      // Definir o número total de linhas na tabela
      $total_rows = $ci->db->count_all($table);

      // Exportar os dados da tabela em lotes de 40 mil
      if ($includedata) {
        $offset = 0;
        $batch_num = 1;

        while ($offset < $total_rows) {
          // Buscar os dados em lotes
          $query = $ci->db->get($table, $batch_size, $offset);
          $data = $query->result_array();

          if (!empty($data)) {
            $insert_statements = '';

            // Gerar instruções SQL para os dados
            foreach ($data as $row) {
              $insert_statements .= 'INSERT INTO `' . $table . '` (`' . implode('`, `', array_keys($row)) . '`) VALUES (' . implode(', ', array_map(array($ci->db, 'escape'), array_values($row))) . ");\n";
            }

            // Escrever os dados em um arquivo separado para cada lote
            $filename = $path . $table . '_data_part_' . $batch_num . '.sql';
            if (!write_file($filename, $insert_statements)) {
              log_message('error', 'Erro ao salvar os dados do lote ' . $batch_num . ' da tabela: ' . $table);
            } else {
              log_message('info', 'Arquivo SQL salvo com sucesso para o lote ' . $batch_num . ' da tabela: ' . $table);
            }
          }

          // Incrementar o offset para o próximo lote
          $offset += $batch_size;
          $batch_num++;

          // Liberar memória usada pela query
          $query->free_result();
        }
      }
    }
    // Resetar o limite de memória
    ini_restore('memory_limit');
  }
}

if (!function_exists('updatencm')) {
  function updatencm()
  {
    $ci = get_instance();
    $items = $ci->db->select('id, ncmid, ncm, ncmdescription')->get('items')->result();

    foreach ($items as $item) {
      if (!$item->ncmid) {
        $ncmdata = $ci->db->select('id')
          ->where('name', trim($item->ncm))
          ->where('description', trim($item->ncmdescription))
          ->get('ncms')
          ->result();

        if (count($ncmdata) > 0) {
          $ci->db->where('id', $item->id)->update('items', ['ncmid' => $ncmdata[0]->id]);
        }
      }
    }
  }
}

if (!function_exists('get_w3')) {
  function get_w3($path = FALSE)
  {
    require_once APPPATH . 'third_party/aws/aws-autoloader.php';

    $s3 = new Aws\S3\S3Client(
      array(
        'credentials' => [
          'key' => AWS_KEY,
          'secret' => AWS_SECRET
        ],
        'endpoint' => 'https://s3.us-east-2.wasabisys.com',
        'region' => 'us-east-2',
        'version' => 'latest'
      )
    );

    try {

      $cmd = $s3->getCommand('GetObject', [
        'Bucket' => WASABI_BUCKET,
        'Key' => $path,
        'ACL' => 'public-read',
      ]);

      $request = $s3->createPresignedRequest($cmd, '+120 minutes');
      $presignedUrl = (string) $request->getUri();

      return $presignedUrl;

    } catch (Aws\S3\Exception\S3Exception $e) {
      return array(
        'error' => TRUE,
        'message' => 'Erro ao ler o arquivo: ' . $e->getMessage(),
      );
    }

  }
}

if (!function_exists('gets_w3')) {
  function gets_w3($paths)
  {
    require_once APPPATH . 'third_party/aws/aws-autoloader.php';

    $s3 = new Aws\S3\S3Client(
      array(
        'credentials' => [
          'key' => AWS_KEY,
          'secret' => AWS_SECRET
        ],
        'endpoint' => 'https://s3.us-east-2.wasabisys.com',
        'region' => 'us-east-2',
        'version' => 'latest'
      )
    );

    try {

      $urls = [];
      foreach ($paths as $path) {

        $cmd = $s3->getCommand('GetObject', [
          'Bucket' => WASABI_BUCKET,
          'Key' => $path,
          'ACL' => 'public-read',
        ]);

        $request = $s3->createPresignedRequest($cmd, '+120 minutes');
        $urls[] = (string) $request->getUri();

      }
      return $urls;

    } catch (Aws\S3\Exception\S3Exception $e) {
      return array(
        'error' => TRUE,
        'message' => 'Erro ao ler o arquivo: ' . $e->getMessage(),
      );
    }

  }
}

if (!function_exists('delete_w3')) {

  function delete_w3($path)
  {
    require_once APPPATH . 'third_party/aws/aws-autoloader.php';

    $s3 = new Aws\S3\S3Client(
      array(
        'credentials' => [
          'key' => AWS_KEY,
          'secret' => AWS_SECRET
        ],
        'endpoint' => 'https://s3.us-east-2.wasabisys.com/',
        'region' => 'us-east-2',
        'version' => 'latest'
      )
    );

    try {

      if (substr($path, -1) == '/') {

        $listObjects = $s3->listObjects([
          'Bucket' => WASABI_BUCKET,
          'Prefix' => $path . '/',
        ]);

        foreach ($listObjects['Contents'] as $object) {
          $s3->deleteObject([
            'Bucket' => WASABI_BUCKET,
            'Key' => $object['Key'],
          ]);
        }


      } else {

        $s3->deleteObject([
          'Bucket' => WASABI_BUCKET,
          'Key' => $path,
        ]);

      }

    } catch (Aws\S3\Exception\S3Exception $e) {
      return [
        'error' => true,
        'message' => 'Erro ao excluir a pasta: ' . $e->getMessage(),
      ];
    }
  }
}

if (!function_exists('update_folder_w3')) {

  function update_folder_w3($old_path, $path)
  {
    require_once APPPATH . 'third_party/aws/aws-autoloader.php';

    $s3 = new Aws\S3\S3Client(
      array(
        'credentials' => [
          'key' => AWS_KEY,
          'secret' => AWS_SECRET
        ],
        'endpoint' => 'https://s3.us-east-2.wasabisys.com/',
        'region' => 'us-east-2',
        'version' => 'latest'
      )
    );

    try {
      $listObjects = $s3->listObjects([
        'Bucket' => WASABI_BUCKET,
        'Prefix' => $old_path . '/',
      ]);

      foreach ($listObjects['Contents'] as $object) {
        $old_key = $object['Key'];
        $new_key = str_replace($old_path, $path, $old_key);

        $s3->copyObject([
          'Bucket' => WASABI_BUCKET,
          'CopySource' => WASABI_BUCKET . '/' . $old_key,
          'Key' => $new_key,
        ]);

        $s3->deleteObject([
          'Bucket' => WASABI_BUCKET,
          'Key' => $old_key,
        ]);
      }


    } catch (Aws\S3\Exception\S3Exception $e) {
      return [
        'error' => true,
        'message' => 'Erro ao atualizar a pasta: ' . $e->getMessage(),
      ];
    }
  }
}

if (!function_exists('upload_w3')) {
  function upload_w3($directory, $file = FALSE, $name = FALSE)
  {
    require_once APPPATH . 'third_party/aws/aws-autoloader.php';

    $s3 = new Aws\S3\S3Client(
      array(
        'credentials' => [
          'key' => AWS_KEY,
          'secret' => AWS_SECRET
        ],
        'endpoint' => 'https://s3.us-east-2.wasabisys.com',
        'region' => 'us-east-2',
        'version' => 'latest'
      )
    );

    try {

      if ($name) {
        $s3->putObject([
          'Bucket' => WASABI_BUCKET,
          'Key' => $directory . '/' . $name,
          'ACL' => 'public-read',
          'SourceFile' => $file,
        ]);
        return TRUE;
      }

      $listObjects = $s3->listObjects([
        'Bucket' => WASABI_BUCKET,
        'Prefix' => $directory . '/'
      ]);

      if (empty($listObjects['Contents'])) {

        $s3->putObject([
          'Bucket' => WASABI_BUCKET,
          'Key' => $directory . '/',
          'ACL' => 'public-read',
          'Body' => '',
        ]);

        return TRUE;
      }

    } catch (Aws\S3\Exception\S3Exception $e) {
      return array(
        'error' => TRUE,
        'message' => 'Erro ao fazer upload do arquivo: ' . $e->getMessage()
      );
    }
  }
}

if (!function_exists('dump')) {
    /**
     * Exibe informações de uma ou mais variáveis em um modal
     *
     * @param  mixed  $args  Variáveis a serem exibidas
     * @return void
     */
    function dump(...$args)
    {
        echo '<div id="dump-modal" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: rgba(0, 0, 0, 0.7);
                color: #000;
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;">
                <div style="
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                max-height: 90vh;
                overflow-y: auto;
                width: 80vw;
                position: relative;">
                    <span id="close-modal" style="
                    position: absolute;
                    top: 10px;
                    right: 20px;
                    cursor: pointer;
                    font-size: 20px;">&times;</span>
                    <pre style="white-space: pre-wrap; word-wrap: break-word; font-size: 14px;">';

        foreach ($args as $arg) {
            print_r($arg);
        }

        echo '</pre></div></div>';

        echo '<script>
            document.getElementById("close-modal").onclick = function() {
                document.getElementById("dump-modal").style.display = "none";
            };
        </script>';
    }
}

if (!function_exists('dd')) {
    /**
     * Exibe informações de uma ou mais variáveis em um modal e interrompe a execução.
     *
     * @param  mixed  $args  Variáveis a serem exibidas
     * @return void
     */
    function dd(...$args)
    {
        dump(...$args);
        die(1); // Interrompe a execução do script
    }
}


