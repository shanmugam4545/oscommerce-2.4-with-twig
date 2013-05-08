<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  class twig_sb_google_plus_one{
    var $code = 'twig_sb_google_plus_one';
    var $icon = 'icon-fa-google-plus';
    var $image = 'googleplus.png';     
    var $title;
    var $description;
    var $sort_order;    
    var $enabled = false;

    public function __construct() {
      $this->title = TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_TITLE;
      $this->public_title = TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_PUBLIC_TITLE;
      $this->description = TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_DESCRIPTION;

      if ( defined('TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_STATUS') ) {
        $this->sort_order = TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_SORT_ORDER;
        $this->enabled = (TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_STATUS == 'True');
      }
    }   

    function getOutput() {
        
      $link = 'ee<div class="g-plusone" data-href="' . osc_href_link('products', 'id=' . $_GET['id'], 'NONSSL', false) . '" data-size="' . strtolower(TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_SIZE) . '" data-annotation="' . strtolower(TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_ANNOTATION) . '"';

      if (TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_ANNOTATION == 'Inline') {
        $link.= ' data-width="' . (int)TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_WIDTH . '" data-align="' . strtolower(TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_ALIGN) . '"';
      }

      $link .= '></div>';

      $link .= '<script type="text/javascript">
  (function() {
    var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
    po.src = \'https://apis.google.com/js/plusone.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>';
      
      $output = array('title' => osc_output_string_protected($this->public_title),
                      'link' => $link,
                      'target' => '_blank',
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
      return defined('TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_STATUS');
    }

    function install() {
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Google+ +1 Button Module', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_STATUS', 'True', 'Do you want to allow products to be recommended through Google+ +1 Button?', '6', '1', 'osc_cfg_select_option(array(\'True\', \'False\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Button Size', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_SIZE', 'Small', 'Sets the size of the button.', '6', '1', 'osc_cfg_select_option(array(\'Small\', \'Medium\', \'Standard\', \'Tall\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Annotation', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_ANNOTATION', 'None', 'The annotation to display next to the button.', '6', '1', 'osc_cfg_select_option(array(\'None\', \'Bubble\', \'Inline\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Inline Width', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_WIDTH', '120', 'The width of the inline annotation in pixels (minimum 120).', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Inline Alignment', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_ALIGN', 'Left', 'The alignment of the inline annotation.', '6', '1', 'osc_cfg_select_option(array(\'Left\', \'Right\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      osc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_STATUS', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_SIZE', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_ANNOTATION', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_WIDTH', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_ALIGN', 'TWIG_MODULE_SOCIAL_BOOKMARKS_GOOGLE_PLUS_ONE_SORT_ORDER');
    }
  }
?>