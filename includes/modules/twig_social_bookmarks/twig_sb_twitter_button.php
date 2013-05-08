<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  class twig_sb_twitter_button{
    var $code = 'twig_sb_twitter_button';
    var $icon = 'icon-fa-twitter-sign';
    var $image = 'twitter.png';
    var $enabled = false;
    var $description;
    var $sort_order;    

    public function __construct() {
      $this->title = TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_TITLE;
      $this->public_title = TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_PUBLIC_TITLE;
      $this->description = TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_DESCRIPTION;

      if ( defined('TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_STATUS') ) {
        $this->sort_order = TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_SORT_ORDER;
        $this->enabled = (TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_STATUS == 'True');
      }
    }
    
    function getOutput() {
      $params = array('url=' . urlencode(osc_href_link('products', 'id=' . $_GET['id'], 'NONSSL', false)));

      if ( strlen(TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_ACCOUNT) > 0 ) {
        $params[] = 'via=' . urlencode(TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_ACCOUNT);
      }

      if ( strlen(TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_RELATED_ACCOUNT) > 0 ) {
        $params[] = 'related=' . urlencode(TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_RELATED_ACCOUNT) . ((strlen(TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_RELATED_ACCOUNT_DESC) > 0) ? ':' . urlencode(TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_RELATED_ACCOUNT_DESC) : '');
      }

      if ( TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_COUNT_POSITION == 'Vertical' ) {
        $params[] = 'count=vertical';
      } elseif ( TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_COUNT_POSITION == 'None' ) {
        $params[] = 'count=none';
      }

      $params = implode('&', $params);
      
      $script = '<script src="http://platform.twitter.com/widgets.js"></script>';
      
      $output = array('title' => osc_output_string_protected($this->public_title),
                      'link' => 'http://twitter.com/share?' . $params . '',
                      'target' => '_blank',
                      'script' => $script,
                      'image' => $this->image,
                      'icon' => $this->icon);
        return $output;       
    }

    function isEnabled() {
      return $this->enabled;
    }

    function getIcon() {
      return $this->icon;
    }

    function getPublicTitle() {
      return $this->public_title;
    }

    function check() {
      return defined('TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_STATUS');
    }

    function install() {
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Twitter Button Module', 'TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_STATUS', 'True', 'Do you want to allow products to be shared through Twitter Button?', '6', '0', 'osc_cfg_select_option(array(\'True\', \'False\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Shop Owner Twitter Account', 'TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_ACCOUNT', '', 'The Twitter account to attribute the tweet to and is recommended to the user to follow.', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Related Twitter Account', 'TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_RELATED_ACCOUNT', '', 'A related Twitter account that is also recommended to the user to follow.', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Related Twitter Account Description', 'TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_RELATED_ACCOUNT_DESC', '', 'A description for the related Twitter account.', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Count Position', 'TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_COUNT_POSITION', 'Horizontal', 'The position of the counter.', '6', '0', 'osc_cfg_select_option(array(\'Horizontal\', \'Vertical\', \'None\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      osc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_STATUS', 'TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_ACCOUNT', 'TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_RELATED_ACCOUNT', 'TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_RELATED_ACCOUNT_DESC', 'TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_COUNT_POSITION', 'TWIG_MODULE_SOCIAL_BOOKMARKS_TWITTER_BUTTON_SORT_ORDER');
    }
  }
?>
