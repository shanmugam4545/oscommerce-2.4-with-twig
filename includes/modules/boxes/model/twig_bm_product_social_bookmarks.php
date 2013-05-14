<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  class twig_bm_product_social_bookmarks{
    var $code = 'twig_bm_product_social_bookmarks';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;


    function execute() {
      global $OSCOM_APP;

      if ( ($OSCOM_APP->getCode() == 'products') && is_null($OSCOM_APP->getCurrentAction()) && isset($_GET['id']) && !empty($_GET['id']) && defined('TWIG_TWIG_MODULE_SOCIAL_BOOKMARKS_INSTALLED') && osc_not_null(TWIG_TWIG_MODULE_SOCIAL_BOOKMARKS_INSTALLED) ) {
        $sbm_array = explode(';', TWIG_MODULE_SOCIAL_BOOKMARKS_INSTALLED);

        $social_bookmarks = array();
        

        foreach ( $sbm_array as $sbm ) {
          $class = 'twig_' . substr($sbm, 0, strrpos($sbm, '.'));
          

          if ( !class_exists($class) ) {
            include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/social_bookmarks/' . $sbm);
            include(DIR_WS_MODULES . 'social_bookmarks/' . $class . '.php');
          }

          $sb = new $class();

          if ($sb->isEnabled() ) {
            array_push($social_bookmarks,$sb->getOutput());
          }
        }
        var_dump($social_bookmarks);


          $data = array('data' => $social_bookmarks,
          'group' => $this->group,
          'boxe' => $this->code,
          'enabled' => $this->enabled,
          'sort_order' => $this->sort_order,
          'title' => $this->title);

      return $data;
      }
    }
    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_STATUS');
    }

    function install() {
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Twig Product Social Bookmarks modules', 'TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'osc_cfg_select_option(array(\'True\', \'False\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', '6', '1', 'osc_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      osc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_STATUS', 'TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_CONTENT_PLACEMENT', 'TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_SORT_ORDER');
    }
  }
?>
