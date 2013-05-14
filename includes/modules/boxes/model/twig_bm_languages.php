<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

require(DIR_WS_MODULES . 'boxes/bm_languages.php');

  class twig_bm_languages extends bm_languages {
    var $code = 'twig_bm_languages';

    function execute() {
      global $OSCOM_APP, $lng, $request_type;

      if ( $OSCOM_APP->getCode() != 'checkout' ) {
        if (!isset($lng) || (isset($lng) && !is_object($lng))) {
          include(DIR_WS_CLASSES . 'language.php');
          $lng = new language;
        }

        if (count($lng->catalog_languages) > 0) {          
          reset($lng->catalog_languages);         
          while (list($key, $value) = each($lng->catalog_languages)) {              
            $dataavailable[] = $value['code_iso'];            
          }
          
          $languages_data = '<div id="lang" class="bfh-selectbox bfh-languages hidden" data-language="' . $_SESSION['languages_code'] . '" data-available="' . implode(',',$dataavailable) . '" data-flags="true">
                  <input type="hidden" value="">
                  <a class="bfh-selectbox-toggle" role="button" data-toggle="bfh-selectbox" href="#">
                  <span class="bfh-selectbox-option input-medium" data-option=""></span>
                  <b class="caret"></b>
                  </a>
                  <div class="bfh-selectbox-options">                    
                    <ul role="listbox">
                    </ul>                  
                </div>
                </div>';
           $data = array('data' => $languages_data,
                         'group' => $this->group,
                         'boxe' => $this->code,
                         'enabled' => $this->enabled,
                         'sort_order' => $this->sort_order,
                         'title' => $this->title);

            return $data;     
        }
      }
    }
  }
?>