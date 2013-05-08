<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class TwigCatHorizontalMenu extends category_tree
{
        var $root_category_id = 0,
            $max_level = 0,
            $root_start_string = '',
            $root_end_string = '',
            $parent_start_string = '',
            $parent_end_string = '',
            $parent_group_start_string = '',
            $parent_group_end_string = '',
            $parent_group_apply_to_root = false,
            $child_start_string = '',
            $child_end_string = '',
            $separator = '',
            $breadcrumb_separator = '_',
            $breadcrumb_usage = true,
            $spacer_string = '',
            $spacer_multiplier = 1,
            $follow_cpath = false,
            $cpath_array = array(),
            $cpath_start_string = '',
            $cpath_end_string = '';
            
            
            

    public function __construct() {        
        
        parent::__construct();     
        
    }

    protected function _buildBranch($parent_id, $level = 0) {        
  
        $result = $this->_getlevelone();

        return $result;
    }
    
    protected function _getlevelone() {
        global $cPath;
        
        $level_one = '';  

        if (isset($this->_data)) {

            $level_one .= '<div id="categorie">';

            $level_one .= '<div class="container navcat">';

            $level_one .= '<ul class="nav" id="header_menu">';         

            foreach ($this->_data[0] as $category_id => $category) {                

                $category_link = $this->buildBreadcrumb($category_id);          

                if ($cPath == $category_link) {

                    $level_one .= '<li class="active"><a href="' . osc_href_link(null, 'cPath=' . $category_link) . '"><i class="icon-fa-caret-right"></i>' . $category['name'] . '</a></li>';
                    
                } else {

                    $getchild = $this->getChildren($category_link);

                    if (isset($getchild) && !empty($getchild)) {

                        $level_one .= '<li><a href="' . osc_href_link(null, 'cPath=' . $category_link) . '">' . $category['name'] . '<i class="icon-fa-caret-down"></i></a></li>';
                        
                    } else {

                        $level_one .= '<li><a href="' . osc_href_link(null, 'cPath=' . $category_link) . '">' . $category['name'] . '</a></li>';
                    }
                }
            }

            $level_one .= '</ul>';

            $level_one .= '</div>';

            $level_one .= '</div>';

            $level_one .= $this->_getleveltwo($cPath);
        }

        return $level_one;
    }

    protected function _getleveltwo($category) {
        global $cPath;

        $category_id = $this->getChildren($category);      

        $level_two = '';       

        if (isset($category_id) && is_array($category_id) && !empty($category_id)) {

            if (!empty($cPath)) {

                $level_two .= '<div class="container">';

                $level_two .= '<div class="childnav">';

                $level_two .= '<ul>';

                foreach ($category_id as $cid => $id) {

                    $data = array($this->getData($id));

                    foreach ($data as $cat => $ca) {

                        $category_link = $this->buildBreadcrumb($ca['id']);                      

                        if ($ca['parent_id'] == $category) {

                            if (!$this->getChildren($ca['id'])) {

                                if ($cPath == $category_link) {                                   

                                    $level_two .= '<li class="active"><a href="' . osc_href_link(null, 'cPath=' . $category_link) . '"><i class="icon-fa-caret-right"></i>' . $ca['name'] . '</a></li>';
                                    
                                } else {

                                    $level_two .= '<li><a href="' . osc_href_link(null, 'cPath=' . $category_link) . '">' . $ca['name'] . '</a></li>';
                                }
                            } else {

                                if (substr($cPath, 0, -2) == $this->buildBreadcrumb($ca['id'], 2) || $cPath == $category_link) {

                                    $level_two .= '<li class="dropdown active">';
                                    
                                } else {

                                    $level_two .= '<li class="dropdown">';
                                    
                                }
                                $level_two .= '<a data-toggle="dropdown"  class="dropdown-toggle" href="' . osc_href_link(null, 'cPath=' . $category_link) . '">' . $ca['name'] . '<i class="icon-fa-caret-down"></i></a>';
                                
                                $level_two .= '<ul id="subcat" class="dropdown-menu">';

                                $level_two .= '<li class="dropdown submenu">';
                                
                                if ($cPath == $category_link) {
                                
                                $level_two .= '<li id="blockactive" class="block"><a href="' . osc_href_link(null, 'cPath=' . $category_link) . '"><i class="icon-fa-caret-right"></i>' . TEXT_VIEW_ALL . $ca['name'] . '</a></li>';
                                
                                }  else {
                                    
                                $level_two .= '<li class="block"><a href="' . osc_href_link(null, 'cPath=' . $category_link) . '">' . TEXT_VIEW_ALL . $ca['name'] . '</a></li>';
                                    
                                }

                                $level_two .= $this->_getsublevels($ca['id']);
                            }
                        }
                    }
                }

                $level_two .= '</ul>';

                $level_two .= '</div>';

                $level_two .= '</div>';

                //javascript
                $level_two .= '<script>';

                $level_two .= 'jQuery(\'.submenu\').hover(function () {';

                $level_two .= 'jQuery(this).children(\'ul\').removeClass(\'submenu-hide\').addClass(\'submenu-show\');';

                $level_two .= '}, function () {';

                $level_two .= 'jQuery(this).children(\'ul\').removeClass(\'.submenu-show\').addClass(\'submenu-hide\');';

                $level_two .= '});';

                $level_two .= '</script>';

                return $level_two;
            }
        }
    }
    
    protected function _getsublevels($id)
    {
        global $cPath;
        
        $sub_level = '';       
        
        $sub_category_id = $this->getChildren($id);
 
        foreach ($sub_category_id as $cid => $id) {           
            
            $data = array($this->getData($id));
            
            foreach ($data as $cat => $ca) {               
            
            $category_link = $this->buildBreadcrumb($ca['id']);
            
            if ($cPath == $category_link) {
            
            $sub_level .= '<li id="blockactive" class="block"><a href="' . osc_href_link(null, 'cPath=' . $category_link) . '"><i class="icon-fa-caret-right"></i>' . $ca['name'] . '</a></li>';
            
            }else{
                
            $sub_level .= '<li class="block"><a href="' . osc_href_link(null, 'cPath=' . $category_link) . '">' . $ca['name'] . '</a></li>';
                
                
            }

            
            
            }  

        }
        
        $sub_level .= '</ul>';
        
        $sub_level .= '</li>';
        
        return $sub_level;
    }
}
?>