<?php

/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
require(DIR_WS_MODULES . 'boxes/bm_best_sellers.php');

class twig_bm_best_sellers extends bm_best_sellers {

    var $code = 'twig_bm_best_sellers';

    public function execute() {
        global $OSCOM_APP, $current_category_id, $OSCOM_PDO;

        $bestsellers_list = array();

        if ($OSCOM_APP->getCode() != 'products') {
            if (isset($current_category_id) && ($current_category_id > 0)) {
                $Qbest_sellers = $OSCOM_PDO->prepare('select distinct p.products_id, pd.products_name, p.products_image, p.products_ordered from :table_products p, :table_products_description pd, :table_products_to_categories p2c, :table_categories c where p.products_status = 1 and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = :language_id and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and :categorie_id in (c.categories_id, c.parent_id) order by p.products_ordered desc, pd.products_name limit :limit');
                $Qbest_sellers->bindInt(':language_id', $_SESSION['languages_id']);
                $Qbest_sellers->bindInt(':categorie_id', $current_category_id);
                $Qbest_sellers->bindInt(':limit', MAX_DISPLAY_BESTSELLERS);
            } else {
                $Qbest_sellers = $OSCOM_PDO->prepare('select distinct p.products_id, pd.products_name, p.products_image, p.products_ordered from :table_products p, :table_products_description pd where p.products_status = 1 and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = :language_id order by p.products_ordered desc, pd.products_name limit :limit');
                $Qbest_sellers->bindInt(':language_id', $_SESSION['languages_id']);
                $Qbest_sellers->bindInt(':limit', MAX_DISPLAY_BESTSELLERS);
            }
            $Qbest_sellers->execute();

            if ($Qbest_sellers->fetch() !== false) {

                $bestsellers_list = $Qbest_sellers->fetchall();
            }

            $data = array('data' => $bestsellers_list,
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