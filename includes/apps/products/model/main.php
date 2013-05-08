<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class main {

    protected static $_template = "product_base";

    protected static $_product_gallery = "fancy";

    public function execute()
    {
    global $currencies, $cPath, $current_category_id;
    
    
    $cPath = osc_get_product_path((int)$_GET['id']);
    
    $product_info_query = osc_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id, p.products_template, p.products_gallery from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$_GET['id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
    $product_info = osc_db_fetch_array($product_info_query);
    osc_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$_GET['id'] . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");

    if ($new_price = osc_get_products_special_price($product_info['products_id'])) {
      $special_price =  $currencies->display_price($new_price, osc_get_tax_rate($product_info['products_tax_class_id']));
    } else {
      $special_price = null;
    }
    
    $manufacturer_info = array();
    if (osc_not_null($product_info['manufacturers_id']) ) {
        $manufacturer_query = osc_db_query("select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on (m.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$_SESSION['languages_id'] . "'), " . TABLE_PRODUCTS . " p  where p.products_id = '" . (int)$_GET['id'] . "' and p.manufacturers_id = m.manufacturers_id");
        if (osc_db_num_rows($manufacturer_query)) {
          $manufacturer_info = osc_db_fetch_array($manufacturer_query);
        }
        
    }

    if (osc_not_null($product_info['products_gallery']) ) {
        self::setTemplate($product_info['products_gallery']);
    }

    if ($product_info['products_date_available'] > date('Y-m-d H:i:s')) {
      $availability = '<link itemprop="availability" href="http://schema.org/PreOrder" />';
    } elseif ((STOCK_CHECK == 'true') && ($product_info['products_quantity'] < 1)) {
      $availability = '<link itemprop="availability" href="http://schema.org/OutOfStock" />';
    } else {
      $availability = '<link itemprop="availability" href="http://schema.org/InStock" />';
    }

    if (osc_not_null($product_info['products_image'])) {
      $pi_query = osc_db_query("select image, thumb, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . (int)$product_info['products_id'] . "' order by sort_order");
      if (osc_db_num_rows($pi_query) > 0) {
          while ($pi = osc_db_fetch_array($pi_query)) {
          $pi_galery[] = $pi;
          }
      }else{
          $pi_galery = null;
      }
    }

    $products_attributes_query = osc_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$_GET['id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$_SESSION['languages_id'] . "'");
    $products_attributes = osc_db_fetch_array($products_attributes_query);

    if ($products_attributes['total'] > 0) {

      $products_options_name_query = osc_db_query("select distinct popt.products_options_id, popt.products_options_template, popt.products_options_required, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$_GET['id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$_SESSION['languages_id'] . "' order by popt.products_options_name");
      while ($products_options_name = osc_db_fetch_array($products_options_name_query)) {
        $products_options_array = array();

        $products_options_query = osc_db_query("select pov.products_options_values_id, pov.products_options_values_name, pov.products_options_values_description, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$_GET['id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$_SESSION['languages_id'] . "'");
        while ($products_options = osc_db_fetch_array($products_options_query)) {

          $products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name'], 'description' => $products_options['products_options_values_description']);
          if ($products_options['options_values_price'] != '0') {
            $products_options_array[sizeof($products_options_array)-1]['option_prefix'] = $products_options['price_prefix'];
            $products_options_array[sizeof($products_options_array)-1]['option_price'] = $currencies->display_price($products_options['options_values_price'], osc_get_tax_rate($product_info['products_tax_class_id']));
          }else{
            $products_options_array[sizeof($products_options_array)-1]['option_prefix'] = null;
            $products_options_array[sizeof($products_options_array)-1]['option_price'] = null;
          }

        }
        if (is_string($_GET['id']) && isset($_SESSION['cart']->contents[$_GET['id']]['attributes'][$products_options_name['products_options_id']])) {
          $selected_attribute = $_SESSION['cart']->contents[$_GET['id']]['attributes'][$products_options_name['products_options_id']];
        } else {
          $selected_attribute = false;
        }

       $content[] = array('potemplate' => $products_options_name['products_options_template'],'porequired' => $products_options_name['products_options_required'],'poname' => $products_options_name['products_options_name'], 'id' => $products_options_name['products_options_id'] ,'data' => $products_options_array, 'selected_attribute' => $selected_attribute);
     }
    }else{
        $content = '';
    }
    if ($product_info['products_date_available'] > date('Y-m-d H:i:s')) {
        $date_available = osc_date_long($product_info['products_date_available']);
    }else{
        $date_available = null;
    }

    if ( osc_not_null($product_info['products_template']) ) {
        self::setTemplate($product_info['products_template']);
    }


        $product = array('template' => self::getTemplate(),
                         'product_id' => $product_info['products_id'],
                         'product_name' => $product_info['products_name'],
                         'product_model' => $product_info['products_model'],
                         'product_price' => $currencies->display_price($product_info['products_price'], osc_get_tax_rate($product_info['products_tax_class_id'])),
                         'special_price' => $special_price,
                         'availability' => $availability,
                         'session_currency' => osc_output_string($_SESSION['currency']),
                         'cpath' => $cPath,
                         'products_gallery' => self::getGalleryTemplate(),
                         'gallery_data' => $pi_galery,
                         'gallery_size' => osc_db_num_rows($pi_query),
                         'product_image' => $product_info['products_image'],
                         'product_description' => $product_info['products_description'],
                         'nb_product_attribute' => $products_attributes['total'],
                         'content' => $content,
                         'date_available' => $date_available,
                         'manufacturer_info' => $manufacturer_info);
        return $product;

    }

    protected static function getTemplate()
    {
        return static::$_template;
    }

    protected static function setTemplate($template)
    {
        static::$_template = $template;
    }

    protected static function getGalleryTemplate()
    {
        return static::$_product_gallery;
    }

    protected function setGalleryTemplate($template)
    {
        static::$_product_gallery = $template;
    }
}
?>