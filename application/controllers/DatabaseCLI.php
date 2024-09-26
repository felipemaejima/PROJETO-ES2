<?php

class DatabaseCLI extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }
  
  /**
   * Atualiza e insere os dados de produção no o banco de dados
   * ATENÇÃO: ESTA FUNÇÃO REMONTA TODO O BANCO DE DADOS COM O FORMATO E OS DADOS DOS ARQUIVOS SQL NA PASTA 'db'
   *
   * @param boolean $update Define se o banco deve ser atualizado antes da inserção dos dados
   * @param string $tablename Nome da tabela que será atualizada, caso não seja informado, todos os dados serão inseridos
   * @param boolean $truncate Faz truncate na tabela antes de inserir, só é válida se tablename for informado
   * @return void
   */
  public function update($update = TRUE, $tablename = false, $truncate = false)
  {
    
    set_time_limit(0);
    ini_set('memory_limit', -1);

    if ($update) {
      update_db();
    }
    if ($tablename) {
      insert_production_data($tablename, $truncate);
      return;
    } 

    insert_production_data('accounts', true);
    insert_production_data('activitysectors', true);
    insert_production_data('addresses', true);
    insert_production_data('agreements', true);
    insert_production_data('brands', true);
    insert_production_data('cities', true);
    insert_production_data('currencies', true);
    insert_production_data('entities', true);
    insert_production_data('estimateitems_data_part_1', true);
    insert_production_data('estimateitems_data_part_2', false);
    insert_production_data('estimateitems_data_part_3', false);
    insert_production_data('estimateitems_data_part_4', false);
    insert_production_data('estimateitems_data_part_5', false);
    insert_production_data('estimateitems_data_part_6', false);
    insert_production_data('estimateitems_data_part_7', false);
    insert_production_data('estimateitems_data_part_8', false);
    insert_production_data('estimateitems_data_part_9', false);
    insert_production_data('estimateitems_data_part_10', false);
    insert_production_data('estimates', true);
    insert_production_data('freighttypes', true);
    insert_production_data('groups', true);
    insert_production_data('invoiceinstallmentpayments', true);
    insert_production_data('invoiceinstallments', true);
    insert_production_data('invoiceitems1', true);
    insert_production_data('invoiceitems2', false);
    insert_production_data('invoices', true);
    insert_production_data('invoicetax1', true);
    insert_production_data('invoicetax2', false);
    insert_production_data('itemorigintypes', true);
    insert_production_data('items', true);
    insert_production_data('itemsupplier', true);
    insert_production_data('licensecontrol', true);
    insert_production_data('ncms', true);
    insert_production_data('purchaseorderchargeexpenses', true);
    insert_production_data('purchaseordercharges', true);
    insert_production_data('purchaseorderitems', true);
    insert_production_data('purchaseorders', true);
    insert_production_data('receiptitems', true);
    insert_production_data('receipts', true);
    insert_production_data('relationships', true);
    insert_production_data('saleorderitems', true);
    insert_production_data('salesorders', true);
    insert_production_data('salutations', true);
    insert_production_data('states', true);
    insert_production_data('subgroups', true);
    insert_production_data('terms', true);
    insert_production_data('types', true);
    insert_production_data('units', true);
    insert_production_data('users', true);
    insert_production_data('voltages', true);
    insert_production_data('warranties', true);

    sleep(5);

    ini_restore('memory_limit');

  }

}
