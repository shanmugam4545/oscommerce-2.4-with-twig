<?php

/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
require(DIR_WS_MODULES . 'boxes/bm_specials.php');

class twig_bm_specials extends bm_specials {

    var $code = 'twig_bm_specials';

    function execute() {
        global $OSCOM_APP, $OSCOM_PDO;

        $specials_box_array = array();

        if ($OSCOM_APP->getCode() != 'products') {

            $Qspecialsbox = $OSCOM_PDO->prepare('select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from :table_products p, :table_products_description pd, :table_specials s where p.products_status = 1 and p.products_id = s.products_id and pd.language_id = :language_id and s.status = 1 order by rand(), s.specials_date_added  desc limit :limit');
            $Qspecialsbox->bindInt(':language_id', $_SESSION['languages_id']);
            $Qspecialsbox->bindInt(':limit', MAX_RANDOM_SELECT_SPECIALS);
            $Qspecialsbox->execute();

            if ($Qspecialsbox->fetch() !== false) {
                $specials_box_array = $Qspecialsbox->fetchall();
            }

            $data = array('data' => $specials_box_array,
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