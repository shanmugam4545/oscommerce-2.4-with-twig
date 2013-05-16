<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

require(DIR_WS_MODULES . 'boxes/bm_shopping_cart.php');

  class twig_bm_shopping_cart extends bm_shopping_cart {
      
    var $code = 'twig_bm_shopping_cart';
    
    public function execute() {
      global $currencies;
      
      $cart_contents_string = '';

      if ($_SESSION['cart']->count_contents() > 0) {
        $cart_contents_string = '';
        $products = $_SESSION['cart']->get_products();
        for ($i=0, $n=sizeof($products); $i<$n; $i++) {

          $cart_contents_string .= '<li';

          if ((isset($_SESSION['new_products_id_in_cart'])) && ($_SESSION['new_products_id_in_cart'] == $products[$i]['id'])) {
            $cart_contents_string .= ' class="active"';

            unset($_SESSION['new_products_id_in_cart']);
          }

          $cart_contents_string .= '><a href="' . osc_href_link('products', 'id=' . $products[$i]['id']) . '">' . $products[$i]['quantity'] . '&nbsp;x&nbsp;' . $products[$i]['name'] . '</a></li>';
        }

        $cart_contents_string .= '<li class="total_shopping_cart">total :' . $currencies->format($_SESSION['cart']->show_total()) . '</li>';
      }else{
        $cart_contents_string .= '<li>' . MODULE_BOXES_SHOPPING_CART_BOX_CART_EMPTY . '</li>'; 
      }

      $data_shopping_cart_boxe = $cart_contents_string;
 
      $shopping_cart = array('data' => $data_shopping_cart_boxe,
                             'group' => $this->group,
                             'boxe' => $this->code,
                             'enabled' => $this->enabled,
                             'sort_order' => $this->sort_order,
                             'title' => $this->title);

      return $shopping_cart;
    }
  }
?>