<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

require(DIR_WS_MODULES . 'boxes/bm_social.php');

  class twig_bm_social extends bm_social {   
      
    var $code = 'twig_bm_social';

    public function execute() {
        
     $link = array(array('link' => 'http://www.facebook.com', 'icon' => 'icon-fa-facebook', 'label' => TWIG_MODULE_BOXES_SOCIAL_BOX_FACEBOOK),
                   array('link' => 'https://plus.google.com', 'icon' => 'icon-fa-google-plus', 'label' => TWIG_MODULE_BOXES_SOCIAL_BOX_GOOGLE_PLUS),
                   array('link' => 'http://www.twitter.com', 'icon' => 'icon-fa-twitter', 'label' => TWIG_MODULE_BOXES_SOCIAL_BOX_TWITTER),
                   array('link' => 'http://pinterest.com', 'icon' => 'icon-fa-pinterest-sign', 'label' => TWIG_MODULE_BOXES_SOCIAL_BOX_PINTEREST)
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
