<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

require(DIR_WS_MODULES . 'boxes/bm_information.php');

  class twig_bm_information extends bm_information{
    var $code = 'twig_bm_information';

    public function execute() { 
        
     $link = array(array('link' => 'shipping', 'icon' => 'icon-fa-truck', 'label' => MODULE_BOXES_INFORMATION_BOX_SHIPPING),
                   array('link' => 'privacy', 'icon' => 'icon-fa-lightbulb', 'label' => MODULE_BOXES_INFORMATION_BOX_PRIVACY),
                   array('link' => 'conditions', 'icon' => 'icon-fa-legal', 'label' => MODULE_BOXES_INFORMATION_BOX_CONDITIONS),
                   array('link' => 'contact', 'icon' => 'icon-fa-envelope-alt', 'label' => MODULE_BOXES_INFORMATION_BOX_CONTACT)
     );
      
      $data = array('data' => $link,
          'group' => $this->group,
          'boxe' => $this->code,
          'enabled' => $this->enabled,
          'sort_order' => $this->sort_order,
          'title' => $this->title);

      return $data;
    }

  }
?>
