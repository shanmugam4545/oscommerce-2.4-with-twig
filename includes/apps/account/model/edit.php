<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class edit {

    protected static $_template = "edit";

    public function execute()
    {
      global $OSCOM_Customer, $OSCOM_NavigationHistory, $OSCOM_PDO, $account, $OSCOM_Breadcrumb;

      if ( !$OSCOM_Customer->isLoggedOn() ) {
        $OSCOM_NavigationHistory->setSnapshot();

        osc_redirect(osc_href_link('account', 'login', 'SSL'));
      }      

      $Qaccount = $OSCOM_PDO->prepare('select customers_gender, customers_firstname, customers_lastname, customers_dob, customers_email_address, customers_telephone, customers_fax, customers_default_address_id from :table_customers where customers_id = :customers_id');
      $Qaccount->bindInt(':customers_id', $OSCOM_Customer->getID());
      $Qaccount->execute();

      $account = $Qaccount->fetch();
      $account_dob = osc_date_short($account['customers_dob']);
      $entry = array();
      if ( $account['customers_default_address_id'] !== null )
      {
          $Qab = $OSCOM_PDO->prepare('select c.countries_id, c.countries_iso_code_2, cu.customers_default_address_id from :table_address_book a, :table_countries c, :table_customers cu where a.address_book_id = :address_book_id and c.countries_id = a.entry_country_id and cu.customers_id = :customers_id');
          $Qab->bindInt(':customers_id', $OSCOM_Customer->getID());
          $Qab->bindInt(':address_book_id', $account['customers_default_address_id']);
          $Qab->execute();
          $entry = $Qab->fetch();
      }
      
        return array('template' => self::getTemplate(), 'data' => $account,'entry' => $entry, 'dob' => $account_dob);
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
