<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

require(DIR_WS_MODULES . 'boxes/bm_templates.php');

  class twig_bm_templates extends bm_templates{
      
    var $code = 'twig_bm_templates';

    public function execute() { 
        global $OSCOM_Cache;

        // todo : classic dropdown menu if javascript disabled
        $hidden_get_variables = '';
        reset($_GET);
        while (list($key, $value) = each($_GET)) {
            if (is_string($value) && ($key != 'template') && ($key != session_name()) && ($key != 'x') && ($key != 'y') && ($key != 'per_page') && ($key != 'page')) {
                $hidden_get_variables .= osc_draw_hidden_field($key, $value);
            }
        }
        $template_data = '<div class="bfh-selectbox">';
        $template_data .= '<input type="hidden" value="">';
        $template_data .= $hidden_get_variables;
        $template_data .= '<a class="bfh-selectbox-toggle" role="button" data-toggle="bfh-selectbox" href="#">
                    <span class="bfh-selectbox-option input-medium" data-option="' . $_SESSION['template'] . '">' . $_SESSION['template_name'] . '</span>
                  <b class="caret"></b>
                  </a>
                  <div class="bfh-selectbox-options" id="templates-bfh-selectbox-options">                  
                    <ul role="listbox">';
        
        $OSCOM_Cache->read('twig-template');      

        foreach($OSCOM_Cache->getCache() as $template) {
            $template_data .= '<li role="option"><a id="' . $template['code'] . '" class="tp" tabindex="-1" href="#" data-option="' . $template['code'] . '">' . $template['title'] . '</a></li>';
        }

        $template_data .= '</ul></div></div>';

        $data = array('data' => $template_data,
                      'group' => $this->group,
                      'boxe' => $this->code,
                      'enabled' => $this->enabled,
                      'sort_order' => $this->sort_order,
                      'title' => $this->title);

        return $data;
    }
}
?>