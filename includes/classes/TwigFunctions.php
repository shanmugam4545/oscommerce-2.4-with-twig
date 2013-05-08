<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
require_once(DIR_WS_CLASSES . 'TwigCatMenu.php');
require_once(DIR_WS_CLASSES . 'TwigCatHorizontalMenu.php');
require(DIR_WS_CLASSES . 'TwigProductsListing.php');

class TwigFunctions extends Twig_Extension 
{


    public function getFunctions()
    {

        return array(
            new Twig_SimpleFunction('messagestack', 'twig_message_stack'),
            new Twig_SimpleFunction('header_message', 'twig_header_message'),
            new Twig_SimpleFunction('error_message', 'twig_error_message'),
            new Twig_SimpleFunction('info_message', 'twig_info_message'), 
            new Twig_SimpleFunction('categorie_menu','categories_twig_tree'), 
            new Twig_SimpleFunction('categorie_horizontal','cat_menu_horizontal'),
            new Twig_SimpleFunction('products_listing_base','twig_products_listing_base'),  
        );
    }

    public function getName()
    {
        return 'FunctionsExtension';

    }
}
function twig_products_listing_base($category_id)
{
    $products_listing = new TwigProductsListing($category_id);
    
    return $products_listing;
}

function cat_menu_horizontal() {
    
    $Tree = new TwigCatHorizontalMenu();   

    return $Tree;
}

function categories_twig_tree() {
    
    $Tree = new TwigCatMenu();

    return $Tree;
}

function twig_message_stack($stack)
{
    global $OSCOM_MessageStack;

    if ($OSCOM_MessageStack->exists($stack)) echo  $OSCOM_MessageStack->get($stack);

}
function twig_header_message()
{
    global $OSCOM_MessageStack;

    if ($OSCOM_MessageStack->exists('header')) {
        $string = '<div class="row-fluid">';
        $string .= $OSCOM_MessageStack->get('header');
        $string .= '</div>';

    return $string;
    }
}
function twig_error_message()
{
    if ( isset($_GET['error_message']) && osc_not_null($_GET['error_message'])) {

        $string = '<table border="0" width="100%" cellspacing="0" cellpadding="2">';
        $string .= '<tr class="headerError">';
        $string .= '<td class="headerError">' . htmlspecialchars(urldecode($_GET['error_message'])) . '</td>';
        $string .= '</tr>';
        $string .= '</table>';

    return $string;
    }
}
function twig_info_message()
{
    if ( isset($_GET['info_message']) && osc_not_null($_GET['info_message']) )
    {
        $string = '<table border="0" width="100%" cellspacing="0" cellpadding="2">';
        $string .= '<tr class="headerInfo">';
        $string .= '<td class="headerInfo">' . htmlspecialchars(urldecode($_GET['info_message'])) . '</td>';
        $string .= '</tr>';
        $string .= '</table>';

    return $string;
    }

}
?>