<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class main {

    protected static $_template = "main";

    public function execute()
    {
        global $currencies, $payment_modules;

        $any_out_of_stock = 0;
        $products = $_SESSION['cart']->get_products();
        $hidden_field = array();        
        
        for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      // Push all attributes information in an array
          if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
              reset($products[$i]['attributes']);
            while (list($option, $value) = each($products[$i]['attributes'])) {
              
              $hidden_field[] = osc_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
              $attributes = osc_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                          from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                          where pa.products_id = '" . (int)$products[$i]['id'] . "'
                                          and pa.options_id = '" . (int)$option . "'
                                          and pa.options_id = popt.products_options_id
                                          and pa.options_values_id = '" . (int)$value . "'
                                          and pa.options_values_id = poval.products_options_values_id
                                          and popt.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                          and poval.language_id = '" . (int)$_SESSION['languages_id'] . "'");
              $attributes_values = osc_db_fetch_array($attributes);

              $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
              $products[$i][$option]['options_values_id'] = $value;
              $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
              
              $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];           
              $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
              $products[$i][$option]['options_values_unit_price'] = $attributes_values['price_prefix'] . ' ' . $currencies->format($attributes_values['options_values_price']);
              if ($products[$i][$option]['options_values_price'] > 0) {
              $products[$i][$option]['options_values_final_price'] = $attributes_values['price_prefix'] . ' ' . $currencies->display_price($attributes_values['options_values_price'],0,$products[$i]['quantity']);
              }else{
              $products[$i][$option]['options_values_final_price'] = TWIG_OPTION_PRICE_FREE;    
              }
            }
          }
          $products[$i]['unit_price'] = $currencies->display_price($products[$i]['price'], osc_get_tax_rate($products[$i]['tax_class_id']));
          $products[$i]['calculate_price'] = $currencies->display_price($products[$i]['final_price'], osc_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']);
        }
      for ($i=0, $n=sizeof($products); $i<$n; $i++) {
            if (STOCK_CHECK == 'true') {

            $stock_check = osc_check_stock($products[$i]['id'], $products[$i]['quantity']);
              if (osc_not_null($stock_check)) {
                $any_out_of_stock = 1;
                $products[$i]['out_of_stock'] = true;
              }else{
                $products[$i]['out_of_stock'] = false;
              }
            }
      }

      $checkout_methods = $payment_modules;

        return array('template' => $this->getTemplate(),'data' => $products, 'hidden_field' => $hidden_field, 'token' => md5($_SESSION['sessiontoken']),'subtotal' => $currencies->format($_SESSION['cart']->show_total()),'payment_modules' => $checkout_methods);
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
