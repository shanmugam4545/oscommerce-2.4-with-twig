<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  class twig_sb_google_plus_share{
    var $code = 'twig_sb_google_plus_share';
    var $title;
    var $description;
    var $sort_order;
    var $icon = 'icon-fa-googleplus';
    var $image = 'google.png';
    var $enabled = false;
    
    public function __construct() {
      $this->title = TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_TITLE;
      $this->public_title = TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_PUBLIC_TITLE;
      $this->description = TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_DESCRIPTION;

      if ( defined('TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_STATUS') ) {
        $this->sort_order = TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_SORT_ORDER;
        $this->enabled = (TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_STATUS == 'True');
      }
    }
    public function isEnabled() {
        return $this->enabled;
    }
    function getIcon() {
      return $this->icon;
    }

    function getPublicTitle() {
      return $this->public_title;
    }

    function check() {
      return defined('TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_STATUS');
    }

    function install() {
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Google+ Share Module', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_STATUS', 'True', 'Do you want to allow products to be shared through Google+?', '6', '1', 'osc_cfg_select_option(array(\'True\', \'False\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Annotation', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_ANNOTATION', 'Bubble', 'The annotation to display next to the button.', '6', '1', 'osc_cfg_select_option(array(\'Inline\', \'Bubble\', \'Vertical-Bubble\', \'None\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Width', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_WIDTH', '', 'The maximum width of the button.', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Height', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_HEIGHT', '20', 'Sets the height of the button.', '6', '1', 'osc_cfg_select_option(array(\'15\', \'20\', \'24\', \'60\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Alignment', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_ALIGN', 'Left', 'The alignment of the button assets.', '6', '1', 'osc_cfg_select_option(array(\'Left\', \'Right\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      osc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_STATUS', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_ANNOTATION', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_WIDTH', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_HEIGHT', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_ALIGN', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_SHARE_SORT_ORDER');
    }
  }
?>
