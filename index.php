<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  require('includes/application_top.php'); 
  
  if (is_dir(DIR_FS_CATALOG. '/lib/lib/Twig') && TWIG_ACTIVATION === 'True') { // check if git submodule is included !

    echo $OSCOM_TwigTemplate->render();
    
    } else {

    require($OSCOM_Template->getTemplateFilename());
    
}

require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
