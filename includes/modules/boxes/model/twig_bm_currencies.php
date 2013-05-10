<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/
require(DIR_WS_MODULES . 'boxes/bm_currencies.php');

  class twig_bm_currencies extends bm_currencies {
    var $code = 'twig_bm_currencies';

    function execute() {
      global $OSCOM_APP, $currencies, $request_type;

      if ( $OSCOM_APP->getCode() != 'checkout' ) {
        if (isset($currencies) && is_object($currencies) && (count($currencies->currencies) > 1)) {
          reset($currencies->currencies);
          $currencies_array = array();
          while (list($key, $value) = each($currencies->currencies)) {
            $currencies_array[] = array('id' => $key, 'text' => $value['title']);
            $currencies_available[] = $key;
          }

          $hidden_get_variables = '';
          reset($_GET);
          while (list($key, $value) = each($_GET)) {
            if ( is_string($value) && ($key != 'currency') && ($key != session_name()) && ($key != 'x') && ($key != 'y') ) {
              $hidden_get_variables .= osc_draw_hidden_field($key, $value);
            }
          }

          $currencies_data = '<div id="cur" class="bfh-selectbox bfh-currencies hidden" data-currency="' . $_SESSION['currency'] . '" data-currencyList="'. implode(',',$currencies_available) . '" data-flags="true">
          <input type="hidden" value="">';
          $currencies_data .= $hidden_get_variables;
          $currencies_data .= '<a class="bfh-selectbox-toggle" role="button" data-toggle="bfh-selectbox" href="#">
                  <span class="bfh-selectbox-option input-medium" data-option=""></span>
                  <b class="caret"></b>
                  </a>
                  <div class="bfh-selectbox-options" id="currencies-bfh-selectbox-options">                  
                    <ul role="listbox">
                    </ul>                  
                </div>
                </div>';
          
           $data = array('data' => $currencies_data,
                         'group' => $this->group,
                         'boxe' => $this->code,
                         'enabled' => $this->enabled,
                         'sort_order' => $this->sort_order,
                         'title' => $this->title);

            return $data;          
        }
      }
    }
  }
?>
