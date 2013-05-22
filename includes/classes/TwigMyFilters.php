<?php
/**
 * osCommerce Online Merchant
 * 
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

class TwigMyFilters extends Twig_Extension
{

    public function __construct() {}
    
    public function getFilters() 
    {
        return array(  
            new Twig_SimpleFilter('display_price', 'twig_display_price'), 
            new Twig_SimpleFilter('breakstring', 'twig_break_string'), 
            new Twig_SimpleFilter('is_array', '_is_array'),  
            new Twig_SimpleFilter('round_rating', 'round_rating'),  
                     
        );
    }
    public function getName()
    {
        return 'MyFiltersExtension';
                
    }
    

}
// filters
function twig_display_price($price,$tax_id,$quantity = 1) 
{
    global $currencies;
    return $currencies->display_price($price,$tax_id,$quantity);
}
function twig_break_string($string, $len, $break_char = '-') 
{
    $l = 0;
    $output = '';
    for ($i=0, $n=strlen($string); $i<$n; $i++) {
      $char = substr($string, $i, 1);
      if ($char != ' ') {
        $l++;
      } else {
        $l = 0;
      }
      if ($l > $len) {
        $l = 1;
        $output .= $break_char;
      }
      $output .= $char;
    }

    return $output;
}

function round_rating($rating) {
    return round($rating * 2 ) / 2;
}

function _is_array($array = array()) {
    if (is_array($array) && count($array) > 0) {
        return true;
    } else {
        return false;
    }
}
?>