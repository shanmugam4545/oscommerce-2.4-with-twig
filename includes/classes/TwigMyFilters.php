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