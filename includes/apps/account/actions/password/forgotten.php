<?php
/**
 * osCommerce Online Merchant
 * 
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  class app_account_action_password_forgotten {
    public static function execute(app $app) {
      global $OSCOM_Breadcrumb;

      $app->setContentFile('password_forgotten.php');

      $OSCOM_Breadcrumb->add(NAVBAR_TITLE_PASSWORD_FORGOTTEN, osc_href_link('account', 'password&forgotten', 'SSL'));
    }
  }
?>
