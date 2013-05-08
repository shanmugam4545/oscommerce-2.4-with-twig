<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class address_book_process {

    protected static $_template = "address_book_process";

    public function execute()
    { 
        global $OSCOM_Customer,$OSCOM_PDO;
        
        if (!isset($process)) $process = false;
        
        $address = null;
        
        if ( isset($_GET['id']) && is_numeric($_GET['id']) ) {
          $Qab = $OSCOM_PDO->prepare('select entry_gender, entry_company, entry_firstname, entry_lastname, entry_street_address, entry_suburb, entry_postcode, entry_city, entry_state, entry_zone_id, entry_country_id from :table_address_book where address_book_id = :address_book_id and customers_id = :customers_id');
          $Qab->bindInt(':address_book_id', $_GET['id']);
          $Qab->bindInt(':customers_id', $OSCOM_Customer->getID());
          $Qab->execute();
          $Qab->fetch();
          $address = $Qab->result;
        }
      
        $data = array('id' => isset($_GET['id']),
                      'gender' => $OSCOM_Customer->getGender(),
                      'firstname' => $OSCOM_Customer->getFirstName(),
                      'lastname' => $OSCOM_Customer->getLastName(), 
                      'process' => $process); 
        
      
        return array('template' => self::getTemplate(), 'data' => $data, 'address' => $address);
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