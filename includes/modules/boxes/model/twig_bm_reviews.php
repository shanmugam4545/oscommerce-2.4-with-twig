<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
require(DIR_WS_MODULES . 'boxes/bm_reviews.php');

class twig_bm_reviews extends bm_reviews {

    var $code = 'twig_bm_reviews';

    function execute() {
        global $OSCOM_APP, $OSCOM_PDO;

        $random_reviews = array();

        if (($OSCOM_APP->getCode() == 'products') && is_null($OSCOM_APP->getCurrentAction()) && isset($_GET['id']) && !empty($_GET['id'])) {

            $Qrandom_reviews = $OSCOM_PDO->prepare('select r.reviews_id, r.reviews_rating, p.products_id, p.products_image, pd.products_name, concat(substring(rd.reviews_text, 1, 60),\'...\') as reviews_text from :table_reviews r, :table_reviews_description rd, :table_products p, :table_products_description pd where p.products_id = :id and p.products_status = :status and p.products_id = r.products_id and r.reviews_id = rd.reviews_id and rd.languages_id = :language_id and p.products_id = pd.products_id and pd.language_id = :language_id and r.reviews_status = :status order by rand() limit :limit');
            $Qrandom_reviews->bindInt(':id', osc_get_prid($_GET['id']));
            $Qrandom_reviews->bindInt(':language_id', (int) $_SESSION['languages_id']);
            $Qrandom_reviews->bindInt(':status', 1);
            $Qrandom_reviews->bindInt(':limit', 1);
            $Qrandom_reviews->execute();
            $random_reviews = $Qrandom_reviews->fetchall();
        } else {
            $Qrandomreviews = $OSCOM_PDO->prepare('select r.reviews_status, r.reviews_id, r.reviews_rating, p.products_id, p.products_image, pd.products_name, concat(substring(rd.reviews_text, 1, 60),\'...\') as reviews_text from :table_reviews r, :table_reviews_description rd, :table_products p, :table_products_description pd where p.products_status = :status and p.products_id = r.products_id  and r.reviews_id = rd.reviews_id and rd.languages_id = :language_id and p.products_id = pd.products_id and pd.language_id = :language_id and r.reviews_status = :status order by rand() limit :limit');
            $Qrandomreviews->bindInt(':language_id', (int) $_SESSION['languages_id']);
            $Qrandomreviews->bindInt(':status', 1);
            $Qrandomreviews->bindInt(':limit', MAX_RANDOM_SELECT_REVIEWS);
            $Qrandomreviews->execute();
            if ($Qrandomreviews->fetch() !== false) {
                $random_reviews = $Qrandomreviews->fetchall();
            }
        }

        $data = array('data' => $random_reviews,
            'group' => $this->group,
            'boxe' => $this->code,
            'enabled' => $this->enabled,
            'sort_order' => $this->sort_order,
            'title' => $this->title);

        return $data;
    }
}
?>