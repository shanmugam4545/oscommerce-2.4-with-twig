<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class shipping_checkout {

    protected static $_template = "shipping";

    public function execute()
    { 
        global $OSCOM_Customer,$quotes;
        $address = osc_address_label($OSCOM_Customer->getID(), $_SESSION['sendto'], true, ' ', '<br />');
        return array('template' => self::getTemplate(),'address' => $address, 'quote' => $quotes);
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
