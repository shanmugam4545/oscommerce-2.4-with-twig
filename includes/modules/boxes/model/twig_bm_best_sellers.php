<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of twig_bm_best_sellers
 *
 * @author laurent
 */
require(DIR_WS_MODULES . 'boxes/bm_best_sellers.php');

class twig_bm_best_sellers extends bm_best_sellers{
    
    protected static $_template = "boxe_best_sellers";
    
    public function __construct() {
        parent::bm_best_sellers();
    }
    
    public function execute() 
    {
      global $OSCOM_APP, $current_category_id;

      if ( $OSCOM_APP->getCode() != 'products' ) {
        if (isset($current_category_id) && ($current_category_id > 0)) {
          $best_sellers_query = osc_db_query("select distinct p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and '" . (int)$current_category_id . "' in (c.categories_id, c.parent_id) order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);
        } else {
          $best_sellers_query = osc_db_query("select distinct p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);
        }

        if (osc_db_num_rows($best_sellers_query) >= MIN_DISPLAY_BESTSELLERS) {
          $bestsellers_list = array();

          while ($best_sellers = osc_db_fetch_array($best_sellers_query)) {
            $bestsellers_list[] = array('product_id' => $best_sellers['products_id'], 'product_name' => $best_sellers['products_name']);
          }

          $data = array('data' => $bestsellers_list,'group' => $this->group, 'template' => $this->getTemplate());
          
          return $data;
        }
      }
    }
    
    protected static function getTemplate()
    {
        return static::$_template;
    }

    protected static function setTemplate($template)
    {
        static::$_template = $template;
    }
}

?>
