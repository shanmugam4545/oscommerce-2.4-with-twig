<?php
/**
 * osCommerce Online Merchant
 * 
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  class app_account_action_address_book_delete_process {
    public static function execute(app $app) {
      global $OSCOM_Customer, $OSCOM_MessageStack, $OSCOM_PDO;

      if ( isset($_GET['formid']) && ($_GET['formid'] == md5($_SESSION['sessiontoken'])) ) {
        $Qdelete = $OSCOM_PDO->prepare('delete from :table_address_book where address_book_id = :address_book_id and customers_id = :customers_id');
        $Qdelete->bindInt(':address_book_id', $_GET['id']);
        $Qdelete->bindInt(':customers_id', $OSCOM_Customer->getID());
        $Qdelete->execute();

        $OSCOM_MessageStack->addSuccess('addressbook', SUCCESS_ADDRESS_BOOK_ENTRY_DELETED);

        osc_redirect(osc_href_link('account', 'address_book', 'SSL'));
      }
    }
  }
?>
