<?php
/**
 * osCommerce Online Merchant
 * 
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  class app_info_action_contact {
    public static function execute(app $app) {
      global $OSCOM_Breadcrumb;

      $app->setContentFile('contact.php');

      $OSCOM_Breadcrumb->add(NAVBAR_TITLE_CONTACT, osc_href_link('info', 'contact'));
    }
  }
?>
