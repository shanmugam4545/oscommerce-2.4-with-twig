<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
  class twig_sb_email{
    var $code = 'twig_sb_email';
    var $title;
    var $description;
    var $sort_order;
    var $icon = 'icon-fa-envelope';
    var $image = 'email.png';
    var $enabled = false;
    
    public function __construct() {
      $this->title = TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_TITLE;
      $this->public_title = TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_PUBLIC_TITLE;
      $this->description = TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_DESCRIPTION;

      if ( defined('TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_STATUS') ) {
        $this->sort_order = TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_SORT_ORDER;
        $this->enabled = (TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_STATUS == 'True');
      }
    }
   
    
    public function getOutput() {
      
        $output = array('title' => osc_output_string_protected($this->public_title),
                        'link' => osc_href_link('products', 'tell_a_friend&id=' . $_GET['id']),
                        'image' => $this->image,
                        'icon' => $this->icon);
      return $output;
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
      return defined('TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_STATUS');
    }

    function install() {
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable E-Mail Module', 'TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_STATUS', 'True', 'Do you want to allow products to be shared through e-mail?', '6', '1', 'osc_cfg_select_option(array(\'True\', \'False\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      osc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_STATUS', 'TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_SORT_ORDER');
    }
  }
?>