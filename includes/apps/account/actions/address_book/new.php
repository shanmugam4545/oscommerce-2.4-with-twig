<?php
/**
 * osCommerce Online Merchant
 * 
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  class app_account_action_address_book_new {
    public static function execute(app $app) {
      global $OSCOM_Breadcrumb, $OSCOM_MessageStack;

      $app->setContentFile('address_book_process.php');

      if (osc_count_customer_address_book_entries() >= MAX_ADDRESS_BOOK_ENTRIES) {
        $OSCOM_MessageStack->addError('addressbook', ERROR_ADDRESS_BOOK_FULL);

        osc_redirect(osc_href_link('account', 'address_book', 'SSL'));
      }

      $OSCOM_Breadcrumb->add(NAVBAR_TITLE_ADDRESS_BOOK_NEW, osc_href_link('account', 'address_book&new', 'SSL'));
    }
  }
?>
