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
        global $OSCOM_PDO, $OSCOM_TwigTemplate;

        $manufacturers_box_array = array();

        $Qmanufacturers = $OSCOM_PDO->prepare('select m.manufacturers_id as id, m.manufacturers_name as text, m.manufacturers_image as image, mi.manufacturers_short_description as short_description from :table_manufacturers m, :table_manufacturers_info mi where  m.manufacturers_id = mi.manufacturers_id and mi.languages_id = :language_id order by m.manufacturers_name');
        $Qmanufacturers->bindInt(':language_id', $_SESSION['languages_id']);
        $Qmanufacturers->execute();

        if ($Qmanufacturers->fetch() !== false) {

            $manufacturers_box_array = $Qmanufacturers->fetchall();
        }

        if (isset($_GET['manufacturers_id'])) {
            $Qmanufacturers_name = $OSCOM_PDO->prepare('select manufacturers_id as id, manufacturers_name as manufacturer_name from :table_manufacturers where manufacturers_id = :mid');
            $Qmanufacturers_name->bindInt(':mid', $_GET['manufacturers_id']);
            $Qmanufacturers_name->execute();
            if ($Qmanufacturers_name->fetch() !== false) {
                $OSCOM_TwigTemplate->getTwig()->addGlobal('manufacturer_name', $Qmanufacturers_name->value('manufacturer_name'));
            }
        }
        $OSCOM_TwigTemplate->getTwig()->addGlobal('manufacturer_id', isset($_GET['manufacturers_id']) ? $_GET['manufacturers_id'] : '0');

        return $manufacturers_box_array;
    }

    public function execute() {

        $data = array('data' => $this->getData(),
            'group' => $this->group,
            'boxe' => $this->code,
            'enabled' => $this->enabled,
            'sort_order' => $this->sort_order,
            'title' => $this->title);

        return $data;
    }

}
?>