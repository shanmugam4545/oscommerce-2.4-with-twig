<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  class bm_twig_product_social_bookmarks {
    var $code = 'bm_twig_product_social_bookmarks';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_twig_product_social_bookmarks() {
      $this->title = TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_TITLE;
      $this->description = TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_DESCRIPTION;

      if ( defined('TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_STATUS') ) {
        $this->sort_order = TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_SORT_ORDER;
        $this->enabled = true;

        $this->group = ((TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      return false;
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