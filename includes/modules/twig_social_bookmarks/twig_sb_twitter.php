<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  class twig_sb_twitter{
    var $code = 'twig_sb_twitter';
    var $image = 'twitter.png';
    var $icon = 'icon-ft-twitter';
    var $title;
    var $description;
    var $sort_order;    
    var $enabled = false;

    public function __construct() {
      $this->title = TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_TITLE;
      $this->public_title = TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_PUBLIC_TITLE;
      $this->description = TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_DESCRIPTION;

      if ( defined('TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_STATUS') ) {
        $this->sort_order = TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_SORT_ORDER;
        $this->enabled = (TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_STATUS == 'True');
      }
    }

    function getOutput() {
        
        $output = array('title' => osc_output_string_protected($this->public_title),
                        'link' => 'twitter.com/home?status=' . urlencode(osc_href_link('products', 'id=' . $_GET['id'], 'NONSSL', false)),
                        'target' => '_blank',
                        'image' => $this->image,
                        'icon' => $this->icon);
        return $output;      
    }
    
    function isEnabled() {
      return $this->enabled;
    }

    function getPublicTitle() {
      return $this->public_title;
    }

    function check() {
      return defined('TWIG_MODULE_SOCIAL_BOOKMARKS_PINTEREST_STATUS');
    }

    function install() {
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Pinterest Module', 'TWIG_MODULE_SOCIAL_BOOKMARKS_PINTEREST_STATUS', 'True', 'Do you want to allow Pinterest Button?', '6', '1', 'osc_cfg_select_option(array(\'True\', \'False\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Layout Position', 'TWIG_MODULE_SOCIAL_BOOKMARKS_PINTEREST_BUTTON_COUNT_POSITION', 'None', 'Horizontal or Vertical or None', '6', '2', 'osc_cfg_select_option(array(\'Horizontal\', \'Vertical\', \'None\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'TWIG_MODULE_SOCIAL_BOOKMARKS_PINTEREST_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      osc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('TWIG_MODULE_SOCIAL_BOOKMARKS_PINTEREST_STATUS', 'TWIG_MODULE_SOCIAL_BOOKMARKS_PINTEREST_BUTTON_COUNT_POSITION', 'TWIG_MODULE_SOCIAL_BOOKMARKS_PINTEREST_SORT_ORDER');
    }
  }
?>
