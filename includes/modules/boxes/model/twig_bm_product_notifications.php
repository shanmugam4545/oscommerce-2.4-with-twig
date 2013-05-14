<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

require(DIR_WS_MODULES . 'boxes/bm_product_notifications.php');

  class twig_bm_product_notifications extends bm_product_notifications {
    var $code = 'twig_bm_product_notifications';

    public function execute() {
      global $OSCOM_APP, $OSCOM_Customer, $request_type;

      if ( ($OSCOM_APP->getCode() == 'products') && is_null($OSCOM_APP->getCurrentAction()) && isset($_GET['id']) && !empty($_GET['id']) ) {
        if ($OSCOM_Customer->isLoggedOn()) {
          $check_query = osc_db_query("select count(*) as count from " . TABLE_PRODUCTS_NOTIFICATIONS . " where products_id = '" . osc_get_prid($_GET['id']) . "' and customers_id = '" . (int)$OSCOM_Customer->getID() . "'");
          $check = osc_db_fetch_array($check_query);

          $notification_exists = (($check['count'] > 0) ? true : false);
        } else {
          $notification_exists = false;
        }

        $notif_contents = '';

        if ($notification_exists == true) {
          $notif_contents = '<li><span><a href="' . osc_href_link('products', 'notify&delete&id=' . $_GET['id'], $request_type) . '"></a></span><a href="' . osc_href_link('products', 'notify&delete&id=' . $_GET['id'], $request_type) . '"><i class="icon-book"></i>' . sprintf(MODULE_BOXES_PRODUCT_NOTIFICATIONS_BOX_NOTIFY_REMOVE, osc_get_products_name($_GET['id'])) .'</a></li>';
        } else {
          $notif_contents = '<li><span><a href="' . osc_href_link('products', 'notify&add&id=' . $_GET['id'], $request_type) . '"></a></span><a href="' . osc_href_link('products', 'notify&add&id=' . $_GET['id'], $request_type) . '"><i class="icon-book"></i>' . sprintf(MODULE_BOXES_PRODUCT_NOTIFICATIONS_BOX_NOTIFY, osc_get_products_name($_GET['id'])) .'</a></li>';
        }

        $data = '<li class="nav-header"><a href="' . osc_href_link('account', 'notifications', 'SSL') . '">' . MODULE_BOXES_PRODUCT_NOTIFICATIONS_BOX_TITLE . '</a></li>' .
                $notif_contents;

      $notification = array('data' => $data,
          'group' => $this->group,
          'boxe' => $this->code,
          'enabled' => $this->enabled,
          'sort_order' => $this->sort_order,
          'title' => $this->title);

      return $notification;
      }
    }
  }
?>
