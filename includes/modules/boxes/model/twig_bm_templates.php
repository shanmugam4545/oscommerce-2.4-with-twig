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
      global $request_type;         
          
          $templates_array = array();
          
          $templates_query = osc_db_query("select id, title, code from twig_templates order by id");
    
            while ($templates = osc_db_fetch_array($templates_query)) {
        
            $templates_array[] = array('id' => $templates['code'],
                                       'text' => $templates['title']);
            }
            
          $hidden_get_variables = '';
          reset($_GET);
          while (list($key, $value) = each($_GET)) {              
            if ( is_string($value) && ($key != 'template') && ($key != session_name()) && ($key != 'x') && ($key != 'y') && ($key != 'per_page') && ($key != 'page')) {
              $hidden_get_variables .= osc_draw_hidden_field($key, $value);
              
            }
          }
            
          $data =  osc_draw_form('templates', osc_href_link(null, '', $request_type, false), 'get') . $hidden_get_variables .                   
                    osc_draw_pull_down_menu('template', $templates_array, $_SESSION['template'] , 'onchange="this.form.submit();" id="templates_pulldown"') .
                    osc_hide_session_id() . '</form>';                  

            $data = array(
                 'data' => $data,
                 'group' => $this->group,
                 'boxe' => $this->code,
                 'enabled' => $this->enabled,
                 'sort_order' => $this->sort_order,
                 'title' => $this->title);

             return $data;     
    }
  }
?>