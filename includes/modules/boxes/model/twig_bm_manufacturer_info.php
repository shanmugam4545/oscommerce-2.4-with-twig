<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/
require(DIR_WS_MODULES . 'boxes/bm_manufacturer_info.php');

  class twig_bm_manufacturer_info extends bm_manufacturer_info{
    var $code = 'twig_bm_manufacturer_info';
    
    public function execute() { 
      global $OSCOM_APP;
      
      $manufacturer_info = array();
        
      if ( ($OSCOM_APP->getCode() == 'products') && is_null($OSCOM_APP->getCurrentAction()) && isset($_GET['id']) && !empty($_GET['id']) ) {
        $manufacturer_query = osc_db_query("select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on (m.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$_SESSION['languages_id'] . "'), " . TABLE_PRODUCTS . " p  where p.products_id = '" . osc_get_prid($_GET['id']) . "' and p.manufacturers_id = m.manufacturers_id");
        if (osc_db_num_rows($manufacturer_query)) {
          $manufacturer = osc_db_fetch_array($manufacturer_query);
          
          $manufacturer_info = $manufacturer;
        }
      

      $data = array('data' => $manufacturer_info,
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