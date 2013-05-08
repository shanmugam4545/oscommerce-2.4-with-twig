<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

class categories {

    protected static $_template = "categories_base";

    public function execute()
    {
        global $current_category_id, $cPath, $cPath_array;
        
        $data = array();
        
        $category_query = osc_db_query("select cd.categories_name, c.categories_template, c.categories_image from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int) $current_category_id . "' and cd.categories_id = '" . (int) $current_category_id . "' and cd.language_id = '" . (int) $_SESSION['languages_id'] . "'");
        $category = osc_db_fetch_array($category_query);  

        if (isset($cPath) && strpos('_', $cPath)) {
// check to see if there are deeper categories within the current category
            $category_links = array_reverse($cPath_array);
            for ($i = 0, $n = sizeof($category_links); $i < $n; $i++) {
                $categories_query = osc_db_query("select count(*) as total from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int) $category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int) $_SESSION['languages_id'] . "'");
                $categories = osc_db_fetch_array($categories_query);
                
                if ($categories['total'] < 1) {
                    // do nothing, go through the loop
                } else {
                    $categories_query = osc_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.categories_template, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int) $category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int) $_SESSION['languages_id'] . "' order by sort_order, cd.categories_name");
                    
                    break; // we've found the deepest category the customer is in
                }
            }
        } else {
            $categories_query = osc_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.categories_template, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int) $current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int) $_SESSION['languages_id'] . "' order by sort_order, cd.categories_name");
            
        }

        $number_of_categories = osc_db_num_rows($categories_query);

        while ($categories = osc_db_fetch_array($categories_query)) {
            
            $cPath_new = osc_get_path($categories['categories_id']);
            
            $data[] = array('cat_name' => $categories['categories_name'],'cat_image' => $categories['categories_image'],'cat_link' => $cPath_new);
        }       
        
        $new_products_category_id = $current_category_id;

        if (osc_not_null($category['categories_template'])) {
            self::setTemplate($category['categories_template']);
        }

        return array('template' => self::getTemplate(), 'cat_name' => $category['categories_name'],'cat_image'=>$category['categories_image'],'data' => $data, 'new_products_category_id' => $new_products_category_id);
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
class category_smartphone {

}
?>