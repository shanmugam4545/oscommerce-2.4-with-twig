<?php

/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
require(DIR_WS_MODULES . 'boxes/bm_manufacturers.php');

class twig_bm_manufacturers extends bm_manufacturers {

    var $code = 'twig_bm_manufacturers';
    
    public function getData() {
        global $OSCOM_PDO;

        $manufacturers_box_array = array();


            $Qmanufacturers = $OSCOM_PDO->prepare('select m.manufacturers_id as id, m.manufacturers_name as text, m.manufacturers_image as image, mi.manufacturers_short_description as short_description from :table_manufacturers m, :table_manufacturers_info mi where  m.manufacturers_id = mi.manufacturers_id and mi.languages_id = :language_id order by m.manufacturers_name');
            $Qmanufacturers->bindInt(':language_id', $_SESSION['languages_id']);
            $Qmanufacturers->execute();

            if ($Qmanufacturers->fetch() !== false) {

                $manufacturers_box_array = $Qmanufacturers->fetchall();
            }
         return $manufacturers_box_array;
        
    }

    public function execute() {

            $data = array('data' => $this->getData(),
                          'manufacturer_id' => (isset($_GET['manufacturers_id']) ? $_GET['manufacturers_id'] : null),
                          'group' => $this->group,
                          'boxe' => $this->code,
                          'enabled' => $this->enabled,
                          'sort_order' => $this->sort_order,
                          'title' => $this->title);

            return $data;
        }
    }
?>