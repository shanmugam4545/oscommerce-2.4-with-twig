<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class reviews_info {

    protected static $_template = "reviews_info_base";

    public function execute()
    {
        global $OSCOM_PDO, $Qp, $Qreview, $currencies, $products_price, $products_name, $OSCOM_Breadcrumb;

         if ( !empty($_GET['reviews']) && isset($_GET['id']) && !empty($_GET['id']) ) {
            $Qcheck = $OSCOM_PDO->prepare('select r.reviews_id, r.reviews_template from :table_reviews r, :table_reviews_description rd where r.reviews_id = :reviews_id and r.products_id = :products_id and r.reviews_id = rd.reviews_id and rd.languages_id = :languages_id and r.reviews_status = 1');
            $Qcheck->bindInt(':reviews_id', $_GET['reviews']);
            $Qcheck->bindInt(':products_id', $_GET['id']);
            $Qcheck->bindInt(':languages_id', $_SESSION['languages_id']);
            $Qcheck->execute();

            if ( $Qcheck->fetch() === false ) {
              osc_redirect(osc_href_link('products', 'reviews&id=' . $_GET['id']));
            }

            if ( osc_not_null($Qcheck->value('reviews_template')) )
            {
                self::setTemplate($Qcheck->value('reviews_template'));
            }

            if ( !isset($_GET['new']) ) {
              $Qupdate = $OSCOM_PDO->prepare('update :table_reviews set reviews_read = reviews_read+1 where reviews_id = :reviews_id');
              $Qupdate->bindInt(':reviews_id', $_GET['reviews']);
              $Qupdate->execute();
            }

            $Qreview = $OSCOM_PDO->prepare('select rd.reviews_text, r.reviews_template, r.reviews_rating, r.reviews_id, r.customers_name, r.date_added, r.reviews_read, p.products_id, p.products_price, p.products_tax_class_id, p.products_image, p.products_model, pd.products_name from :table_reviews r, :table_reviews_description rd, :table_products p, :table_products_description pd where r.reviews_id = :reviews_id and r.reviews_id = rd.reviews_id and rd.languages_id = :languages_id and r.products_id = p.products_id and p.products_status = 1 and p.products_id = pd.products_id and pd.language_id = rd.languages_id');
            $Qreview->bindInt(':reviews_id', $_GET['reviews']);
            $Qreview->bindInt(':languages_id', $_SESSION['languages_id']);
            $Qreview->execute();

            if ($new_price = osc_get_products_special_price($Qreview->valueInt('products_id'))) {
              $review_special_price = $currencies->display_price($new_price, osc_get_tax_rate($Qreview->valueInt('products_tax_class_id')));
            } else {
              $products_price = $currencies->display_price($Qreview->value('products_price'), osc_get_tax_rate($Qreview->valueInt('products_tax_class_id')));
              $review_special_price = null;
            }

            $data = array();

            if ( osc_not_null($Qreview->value('reviews_template')) )
            {
                $this->setTemplate($Qreview->value('reviews_template'));
                $data = call_user_func(array($Qreview->value('reviews_template') , 'execute'),$_GET['id']);
            }

            $products_name = $Qreview->value('products_name');



            if (osc_not_null($Qreview->value('products_model'))) {
              $products_model = $Qreview->value('products_model');
            }else{
              $products_model = null;
            }
        }
        return array('template' => self::getTemplate(), 'id' => $_GET['id'], 'md5' => md5($_SESSION['sessiontoken']), 'product_name' => $products_name, 'review_special_price' => $review_special_price,'review_product_price' => $products_price, 'product_model' => $products_model, 'review' => $Qreview->result, 'data' => $data);
    }

    protected static function getTemplate()
    {
        return static::$_template;
    }

    protected static function setTemplate($template)
    {
        static::$_template = $template;
    }
}

class reviews_info_with_gallery{

    public static function execute($product_id)
    {
        if ( isset($product_id) )
        {
            $pi_query = osc_db_query("select image, thumb, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . (int)$product_id . "' order by sort_order");
            while ($pi = osc_db_fetch_array($pi_query)) {
            $pi_galery[] = $pi;
            }
            return !empty($pi_galery) ? $pi_galery : null;
        }
        return false;
    }
}
?>