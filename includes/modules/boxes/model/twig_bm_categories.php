<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

require(DIR_WS_MODULES . 'boxes/bm_categories.php');

  class twig_bm_categories extends bm_categories {
    var $code = 'twig_bm_categories';
    
    public function __construct() {
        parent::bm_categories();
    }

    public function execute() { 
      global $cPath, $current_category_id;
      
      $OSCOM_CategoryTree = new category_tree();     
      
      $OSCOM_CategoryTree->setCategoryPath($cPath, '<strong><i class="icon-chevron-right pull-left text-info" style="padding-top:5px;"></i>','</strong>');

      $OSCOM_CategoryTree->setRootString('','');  

      $OSCOM_CategoryTree->setParentGroupString('<li><ul class="nav nav-list">', '</ul></li>');

      $data = array('data' => $OSCOM_CategoryTree->getTree(),
          'group' => $this->group,
          'boxe' => $this->code,
          'enabled' => $this->enabled,
          'sort_order' => $this->sort_order,
          'title' => $this->title);

      return $data;
    }
  }
?>