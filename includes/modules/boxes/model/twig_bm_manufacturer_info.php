<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

require(DIR_WS_MODULES . 'boxes/bm_manufacturer_info.php');

  class twig_bm_manufacturer_info extends bm_manufacturer_info{
    var $code = 'twig_bm_manufacturer_info';
    
    public function execute() { 
      global $OSCOM_APP, $OSCOM_PDO;
      
      $manufacturer_info_box = array();
        
      if ( ($OSCOM_APP->getCode() == 'products') && is_null($OSCOM_APP->getCurrentAction()) && isset($_GET['id']) && !empty($_GET['id']) ) {
        $Qmanufacturerbox = $OSCOM_PDO->prepare('select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url from :table_manufacturers m left join :table_manufacturers_info mi on (m.manufacturers_id = mi.manufacturers_id and mi.languages_id = :language_id) , :table_products p where p.products_id = :pid and p.manufacturers_id = m.manufacturers_id');
        $Qmanufacturerbox->bindInt(':language_id', $_SESSION['languages_id']);
        $Qmanufacturerbox->bindInt(':pid', osc_get_prid($_GET['id']));
        $Qmanufacturerbox->execute();
        
        if ($Qmanufacturerbox !== false) {
          
          $manufacturer_info_box = $Qmanufacturerbox->fetchall();
        }      

      $data = array('data' => $manufacturer_info_box,
                    'group' => $this->group,
                    'boxe' => $this->code,
                    'enabled' => $this->enabled,
                    'sort_order' => $this->sort_order,
                    'title' => $this->title);

      return $data;
      }
    }
  }
?>