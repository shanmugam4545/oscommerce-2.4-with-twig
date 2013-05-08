<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class address_book {

    protected static $_template = "address_book";

    public function execute()
    {
      global $OSCOM_Customer, $OSCOM_PDO;
      
        $data = array();

        $Qab = $OSCOM_PDO->prepare('select address_book_id, entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from :table_address_book where customers_id = :customers_id order by firstname, lastname');
        $Qab->bindInt(':customers_id', $OSCOM_Customer->getID());
        $Qab->execute();

        while ( $Qab->fetch() ) {
            
        $format_id = osc_get_address_format_id($Qab->valueInt('country_id'));       
        
        
        $data[] = array('address_book_id' => $Qab->valueInt('address_book_id'),
                        'firstname' => $Qab->valueProtected('firstname'),
                        'lastname' => $Qab->valueProtected('lastname'),
                        'default_address' => $OSCOM_Customer->getDefaultAddressID(),
                        'address_format' => osc_address_format($format_id, $Qab->toArray(), true, ' ', '<br />'));
        
        } 
        
      
        return array('template' => self::getTemplate(), 'data' => $data, 'address_label' => osc_address_label($OSCOM_Customer->getID(), $OSCOM_Customer->getDefaultAddressID(), true, ' ', '<br />'),'count' => osc_count_customer_address_book_entries());
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