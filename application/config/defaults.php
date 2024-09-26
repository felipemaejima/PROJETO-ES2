<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['name'] = 'SIGA 2.0';

$config['sender'] = 'webmaster@erp.app';

$config['closecities'] = ['Mogi das Cruzes', 'Suzano', 'Poá', 'Itaquaquecetuba', 'Ferraz de Vasconcelos',  
    'Arujá', 'Santa Isabel', 'Biritiba Mirim', 'Salesópolis', 'Guararema', 'Jacareí', 'São José dos Campos'];

$config['default_operation_types'] = [
    'venda_nfe' => '93d975f3-3f87-3b2b-7e9c-80f25c2aef48',
    'venda_simples_nacional' =>  '3df4b5de-d6d4-5147-9349-00205abecb4a'
];