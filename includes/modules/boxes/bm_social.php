<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_social {
    var $code = 'bm_social';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_social() {
      $this->title = TWIG_MODULE_BOXES_SOCIAL_TITLE;
      $this->description = TWIG_MODULE_BOXES_SOCIAL_DESCRIPTION;

      if ( defined('TWIG_MODULE_BOXES_SOCIAL_STATUS') ) {
        $this->sort_order = TWIG_MODULE_BOXES_SOCIAL_SORT_ORDER;
        $this->enabled = (TWIG_MODULE_BOXES_SOCIAL_STATUS == 'True');

        $this->group = ((TWIG_MODULE_BOXES_SOCIAL_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
        return false;
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('TWIG_MODULE_BOXES_SOCIAL_STATUS');
    }

    function install() {
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Information Module', 'TWIG_MODULE_BOXES_SOCIAL_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'osc_cfg_select_option(array(\'True\', \'False\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'TWIG_MODULE_BOXES_SOCIAL_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'osc_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'TWIG_MODULE_BOXES_SOCIAL_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      osc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('TWIG_MODULE_BOXES_SOCIAL_STATUS', 'TWIG_MODULE_BOXES_SOCIAL_CONTENT_PLACEMENT', 'TWIG_MODULE_BOXES_SOCIAL_SORT_ORDER');
    }
  }
?>
