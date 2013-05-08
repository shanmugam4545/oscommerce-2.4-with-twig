<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
require(DIR_WS_MODULES . 'boxes/bm_twig_product_social_bookmarks.php');

  class twig_bm_twig_product_social_bookmarks extends bm_twig_product_social_bookmarks {
      
    var $code = 'twig_bm_twig_product_social_bookmarks';
    
    function execute() {
      global $OSCOM_APP;
      
      $social_bookmarks = array();

      if ( ($OSCOM_APP->getCode() == 'products') && is_null($OSCOM_APP->getCurrentAction()) && isset($_GET['id']) && !empty($_GET['id']) && defined('TWIG_MODULE_SOCIAL_BOOKMARKS_INSTALLED') && osc_not_null(TWIG_MODULE_SOCIAL_BOOKMARKS_INSTALLED) ) {
        $sbm_array = explode(';', TWIG_MODULE_SOCIAL_BOOKMARKS_INSTALLED);        

        foreach ( $sbm_array as $sbm ) {
          $class = substr($sbm, 0, strrpos($sbm, '.'));          

          if ( !class_exists($class) ) {
            include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/twig_social_bookmarks/' . $sbm);
            include(DIR_WS_MODULES . 'twig_social_bookmarks/' . $class . '.php');
          }

          $sb = new $class();

          if ($sb->isEnabled() ) {
            array_push($social_bookmarks,$sb->getOutput());
          }
        }
        
          $data = array('data' => $social_bookmarks,
          'group' => $this->group,
          'boxe' => $this->code,
          'enabled' => $this->enabled,
          'sort_order' => $this->sort_order,              
          'title' => $this->title);
      return $data;
      }
    }
  }
?>