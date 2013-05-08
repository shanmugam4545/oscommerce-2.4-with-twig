<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class specials {

    protected static $_template = "specials";

    public function execute()
    {
        $specials_query_raw = "select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' and s.status = '1' order by s.specials_date_added DESC";
        $specials_split = new splitPageResults($specials_query_raw, MAX_DISPLAY_SPECIAL_PRODUCTS);
        $specials_query = osc_db_query($specials_split->sql_query);
        if (($specials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
            $split_top = $specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, 'products&specials');
        }else{
            $split_top = null;
        }
        if (($specials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
            $split_bottom = $specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, 'products&specials');
        }else{
            $split_bottom = null;
        }
        $count = $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS);

        while ($specials = osc_db_fetch_array($specials_query)) {
            $special[] = $specials;
        }
        return array('template' => self::getTemplate(), 'data' => $special, 'split_top' => $split_top, 'split_bottom' => $split_bottom, 'count' => $count);
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