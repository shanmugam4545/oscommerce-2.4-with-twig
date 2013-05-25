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
        global $OSCOM_PDO, $OSCOM_Breadcrumb, $cPath;
        
        $cPath = osc_get_product_path((int)$_GET['id']);

         if ( !empty($_GET['reviews']) && isset($_GET['id']) && !empty($_GET['id']) ) {

            $Qreview = $OSCOM_PDO->prepare('select rd.reviews_text, r.reviews_template, r.reviews_rating, r.reviews_id, r.customers_name, r.date_added, r.reviews_read, p.products_id, p.products_price, p.products_tax_class_id, p.products_image, p.products_model, pd.products_name, s.specials_new_products_price, pi.image from :table_products p left outer join :table_specials s on s.products_id = p.products_id ,:table_reviews r, :table_reviews_description rd,  :table_products_description pd, :table_products_images pi where r.reviews_id = :reviews_id and r.reviews_id = rd.reviews_id and rd.languages_id = :languages_id and r.products_id = p.products_id and p.products_status = 1 and p.products_id = pd.products_id and pd.language_id = rd.languages_id and pi.products_id = p.products_id and pi.sort_order = 1 limit :limit');
            $Qreview->bindInt(':reviews_id', $_GET['reviews']);
            $Qreview->bindInt(':languages_id', $_SESSION['languages_id']);
            $Qreview->bindInt(':limit', 1);
            $Qreview->execute();
            
            $review_array[] = $Qreview->toArray();
            
            if ( !isset($_GET['new']) ) {
              $Qupdate = $OSCOM_PDO->prepare('update :table_reviews set reviews_read = reviews_read where reviews_id = :reviews_id');
              $Qupdate->bindInt(':reviews_id', $_GET['reviews']);
              $Qupdate->execute();
            }

            $data = array();           

            if ( osc_not_null($review_array[0]['reviews_template']) )
            {
                $this->setTemplate($review_array[0]['reviews_template']);
                $data = call_user_func(array($review_array[0]['reviews_template'] , 'execute'),$_GET['id']);
            }
            return array('template' => self::getTemplate(), 'id' => $_GET['id'], 'md5' => md5($_SESSION['sessiontoken']), 'review_data' => $review_array, 'data' => $data);
        }
        
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