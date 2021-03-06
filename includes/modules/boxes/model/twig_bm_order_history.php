<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

require(DIR_WS_MODULES . 'boxes/bm_order_history.php');

  class twig_bm_order_history extends bm_order_history {
    var $code = 'twig_bm_order_history';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_order_history() {
      $this->title = MODULE_BOXES_ORDER_HISTORY_TITLE;
      $this->description = MODULE_BOXES_ORDER_HISTORY_DESCRIPTION;

      if ( defined('MODULE_BOXES_ORDER_HISTORY_STATUS') ) {
        $this->sort_order = MODULE_BOXES_ORDER_HISTORY_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_ORDER_HISTORY_STATUS == 'True');

        $this->group = ((MODULE_BOXES_ORDER_HISTORY_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $OSCOM_Customer, $OSCOM_Template;

      if ($OSCOM_Customer->isLoggedOn()) {
// retreive the last x products purchased
        $orders_query = osc_db_query("select distinct op.products_id from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p where o.customers_id = '" . (int)$OSCOM_Customer->getID() . "' and o.orders_id = op.orders_id and op.products_id = p.products_id and p.products_status = '1' group by products_id order by o.date_purchased desc limit " . MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX);
        if (osc_db_num_rows($orders_query)) {
          $product_ids = '';
          while ($orders = osc_db_fetch_array($orders_query)) {
            $product_ids .= (int)$orders['products_id'] . ',';
          }
          $product_ids = substr($product_ids, 0, -1);

          $customer_orders_string = '';
          $products_query = osc_db_query("select products_id, products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id in (" . $product_ids . ") and language_id = '" . (int)$_SESSION['languages_id'] . "' order by products_name");
          while ($products = osc_db_fetch_array($products_query)) {
            $customer_orders_string .= '<li><span style="float: right;"><a href="' . osc_href_link('cart', 'add&id=' . $products['products_id'] . '&formid=' . md5($_SESSION['sessiontoken'])) . '">' . osc_image(DIR_WS_ICONS . 'cart.gif', ICON_CART) . '</a></span><a href="' . osc_href_link('products', 'id=' . $products['products_id']) . '">' . $products['products_name'] . '</a></li>';
          }

          $data = '<li class="nav-header">' . MODULE_BOXES_ORDER_HISTORY_BOX_TITLE . '</li>' .
                  $customer_orders_string;

          $OSCOM_Template->addBlock($data, $this->group);
        }
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_ORDER_HISTORY_STATUS');
    }

    function install() {
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Order History Module', 'MODULE_BOXES_ORDER_HISTORY_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'osc_cfg_select_option(array(\'True\', \'False\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_ORDER_HISTORY_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', '6', '1', 'osc_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_ORDER_HISTORY_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      osc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_ORDER_HISTORY_STATUS', 'MODULE_BOXES_ORDER_HISTORY_CONTENT_PLACEMENT', 'MODULE_BOXES_ORDER_HISTORY_SORT_ORDER');
    }
  }
?>
