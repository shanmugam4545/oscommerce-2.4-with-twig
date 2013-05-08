<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

class TwigProductsListing {
    
    protected $_data = array();
    var $_filter_block_position = 'top', /* left, right, top */
        $_product_display = 'column'; /* column, row */
    
    public function __construct($category_id) {       
        global $current_category_id;
        
        echo $current_category_id;
        
        $cat_query = osc_db_query("select c.categories_image as catimage, cd.categories_name as catname from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
        $cat = osc_db_fetch_array($cat_query);    

        $listing_sql = osc_db_query("select p.products_id, p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_status = '1' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' and p2c.categories_id = '" . (int)(int)$category_id . "'");
 
        $list = osc_db_fetch_array($listing_sql);  
        
        $this->_data = array('cat_name' => $cat['catname'], 'cat_image' => $cat['catimage'],'product_list' => $list);

        
    }
    public function __toString() {
      return $this->_buildProductsListing();
    }
    
    protected function getProductList()
    {
        global $current_category_id, $_GET;

          
          return $list;
    }
    
    protected function _buildProductsListing() {
        
        $result = '';
        
        $result .= '<div class="row-fuild">';
        
        $result .= $this->_getHeadingProductsListing();
        
        
        foreach ($this->_data as $key => $value)
        {
            //echo $key . $value;
            //echo $key['cat_name'][$value];
            //$result .= '<h1>' . $value['cat_name'] . '</h1>';
            //$result .= '<img src="' . DIR_WS_IMAGES . $value['cat_image'] . '" alt="' . $value['cat_name'] . '"/>';
        }
        
        $result .= '</div>';
        return $result;
    }
    protected function _getHeadingProductsListing() {
        
        $heading = '';
        if( $this->get_filter_block_position() == 'top')
        {
        $heading .= '<div class="headingpl">';     
        }else{
        $heading .= '<div class="span9 headingpl">';    
        }
        $heading .= '<img class="img-polaroid imgpl" src="' . DIR_WS_IMAGES . $this->_data['cat_image'] . '" alt="' . $this->_data['cat_name'] . '" />';
        $heading .= '<h1 class="headingproductlisting">' . $this->_data['cat_name'] . '</h1>';
        $heading .= '<hr>';
        $heading .= '</div>';        
        return $heading;
        
    }
    function get_filter_block_position()
    {
        return $this->_filter_block_position;
    }
    function set_filter_block_position($filter_position)
    {
        $this->_filter_block_position = $filter_position;
    }
}
?>