<?php

/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
require(DIR_WS_MODULES . 'boxes/bm_whats_new.php');

class twig_bm_whats_new extends bm_whats_new {

    var $code = 'twig_bm_whats_new';

    function execute() {
        global $OSCOM_PDO;

        $what_new_array = array();

        $Qwhatnewbox = $OSCOM_PDO->prepare('select p.products_id, p.products_image, p.products_price, s.specials_new_products_price, pd.products_name from :table_products p  left outer join :table_specials s on s.products_id = p.products_id inner join :table_products_description pd on pd.products_id = p.products_id and p.products_status = 1 and (s.status = 1 or s.status IS NULL) and pd.language_id = :language_id order by p.products_date_added DESC, rand() limit :limit');
        $Qwhatnewbox->bindInt(':language_id', $_SESSION['languages_id']);
        $Qwhatnewbox->bindInt(':limit', MAX_RANDOM_SELECT_NEW);
        $Qwhatnewbox->execute();

        if ($Qwhatnewbox->fetch() !== false) {

            $what_new_array = $Qwhatnewbox->fetchall();
        }


        $data = array('data' => $what_new_array,
            'group' => $this->group,
            'boxe' => $this->code,
            'enabled' => $this->enabled,
            'sort_order' => $this->sort_order,
            'title' => $this->title);

        return $data;
    }

}

?>