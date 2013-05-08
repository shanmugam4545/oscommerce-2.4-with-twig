<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
if (TWIG_STORE_TEMPLATE == 'classic') {
    define('TWIG_MAX_DISPLAY_SEARCH_RESULTS',(int)6);
    define('TWIG_MIN_DISPLAY_SEARCH_RESULTS', (int)4);
    
}
if (TWIG_STORE_TEMPLATE == 'fullpagecenter') {
    define('TWIG_MAX_DISPLAY_SEARCH_RESULTS', (int)9);
    define('TWIG_MIN_DISPLAY_SEARCH_RESULTS', (int)3);
}
if (TWIG_STORE_TEMPLATE == 'fullpage') {
    define('TWIG_MAX_DISPLAY_SEARCH_RESULTS', (int)12);
    define('TWIG_MIN_DISPLAY_SEARCH_RESULTS', (int)4);
}

class products {

    protected static $_template = "products";

    public function execute()
    {
        global $current_category_id, $cPath, $currencies; 
        
        $data = array();
        $filter = array();
        $display = isset($_GET['display']) ? $_GET['display'] : 'column';

        $page = (empty($_GET['page']) || !is_numeric($_GET['page']) || !isset($_GET['page'])) ? $page = 1 : $page = $_GET['page'];        
        $per_page = isset($_GET['per_page']) ? ($_GET['per_page'] < TWIG_MIN_DISPLAY_SEARCH_RESULTS ?  $_GET['per_page'] = TWIG_MIN_DISPLAY_SEARCH_RESULTS : $_GET['per_page']) : TWIG_MAX_DISPLAY_SEARCH_RESULTS;        
        $from =  $page == 1 ?  0 : $page * $per_page - $per_page;
        $to =  $page == 1 ? $per_page :   $per_page;
        
        /* HDPL : to remove
        $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                             'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                             'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                             'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                             'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                             'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                             'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                             'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);

        asort($define_list);
        */

        $category_query = osc_db_query("select c.categories_image as catimage, cd.categories_name as catname from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
        $category = osc_db_fetch_array($category_query);
        $catname = $category['catname'];
        $catimage = $category['catimage'];
        
        $count_query = osc_db_query("select count(p2c.products_id) as total FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p2c.categories_id = " . $current_category_id . "");
        $count = osc_db_fetch_array($count_query);
        $total = $count['total'];
        $level_per_page = (ceil($total / 3) <= 18 ) ? ceil($total / 3) : 18;
        
        $number_of_page= (ceil ($total / $per_page));      
        
        $products_listing_query = osc_db_query("select p.products_id, p.products_model, p.products_quantity, p.products_image, p.products_weight, pd.products_name, pd.products_short_description, p.manufacturers_id, m.manufacturers_name, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id , " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_status = '1' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id  and pd.language_id = '" . (int) $_SESSION['languages_id'] . "' and p2c.categories_id = '" . (int) $current_category_id . "' order by p.products_id limit " . $from . ", " . $to . "");

        $num_products_listing = osc_db_num_rows($products_listing_query);

        if ($num_products_listing > 0) {

            while ($products = osc_db_fetch_array($products_listing_query)) {
                
                $product_rating_query = osc_db_query("select distinct(r.products_id), avg(r.reviews_rating) as rating FROM " . TABLE_PRODUCTS . " p, " . TABLE_REVIEWS . " r where r.products_id = " . $products['products_id'] . "");
                while ($rating = osc_db_fetch_array($product_rating_query)) {

                    $data[] = array(                        
                        'product_id' => $products['products_id'],
                        'product_name' => $products['products_name'],
                        'product_image' => $products['products_image'],
                        'weight' => $products['products_weight'],
                        'manufacturer' => $products['manufacturers_name'],
                        'short_description' => $products['products_short_description'],
                        'images' => $this->getImages($products['products_id']),
                        'final_price' => $products['final_price'],
                        'rating' => $rating['rating'],                                             
                        'price' => $currencies->display_price($products['products_price'], $products['products_tax_class_id']),
                        'special_price' => osc_not_null($products['specials_new_products_price']) ? $currencies->display_price($products['specials_new_products_price'], $products['products_tax_class_id']) : 'no special',
                    );
                }
            }
        }

        return array('template' => self::getTemplate(),
                     'cpath' => $cPath, 
                     'catname' => $catname,
                     'catimage' => $catimage,
                     'total' => $total,
                     'page' => $page,
                     'from' => $from,
                     'to' => $to,
                     'number_of_page' => $number_of_page,                     
                     'level_per_page' => $level_per_page,
                     'display' => $display, 
                     'per_page' => (int)$per_page, 
                     'cci' => $current_category_id,
                     /*'define_list' => $define_list,  HPDL */
                     'data' => $data);
    }
    
    protected function getImages($id) 
    {
        
      $pi_query = osc_db_query("select image, thumb, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . (int) $id . "' order by sort_order limit 1");
        if (osc_db_num_rows($pi_query) > 0) {
            while ($pi = osc_db_fetch_array($pi_query)) {
                $pi_galery[] = $pi;
            }
        } else {
            $pi_galery = null;
        }
        return $pi_galery;
        
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