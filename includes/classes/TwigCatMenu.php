<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class TwigCatMenu extends category_tree
{
    var $root_category_id = 0,
        $max_level = 0,
        $root_start_string = '',
        $root_end_string = '',
        $parent_start_string = '<li class="dropdown">',        
        $parent_end_string = '</li>',
        $parent_group_start_string = '<ul class="dropdown-menu">',
        $parent_group_end_string = '</ul></li>',
        $parent_group_apply_to_root = false,
        $child_start_string = '<li class="dropdown submenu">',
        $child_end_string = '',
        $separator = '',
        $breadcrumb_separator = '_',
        $breadcrumb_usage = true,
        $spacer_string = '',
        $spacer_multiplier = 1,
        $follow_cpath = false,
        $cpath_array = array(),
        $cpath_start_string = '',
        $cpath_end_string = '',
        $caret = '',
        $class = '';

        
        
    public function __construct() {
        parent::__construct();        
    }
    
    protected function _buildBranch($parent_id, $level = 0) {
      $result = ((($level === 0) && ($this->parent_group_apply_to_root === true)) || ($level > 0)) ? $this->parent_group_start_string : null;

      if ( isset($this->_data[$parent_id]) ) {
        foreach ( $this->_data[$parent_id] as $category_id => $category ) {
          if ( $this->breadcrumb_usage === true ) {
            $category_link = $this->buildBreadcrumb($category_id);
          } else {
            $category_link = $category_id;
          }

          $result .= $this->child_start_string;
          
          if ( $level >= 2 ) {              
          $result .= $this->child_start_string;         
          }
          
          if ( isset($this->_data[$category_id]) && $level >= 1 ) {
              $this->separator = '<i class="icon-fa-play"></i>';
          }else{
              $this->separator = '';
          }

          if ( $level === 0 ) {            
            $result .= $this->parent_start_string;
          }
          
          if ( ($this->follow_cpath === true) && in_array($category_id, $this->cpath_array) ) {
            $link_title = $this->cpath_start_string . $category['name'] . $this->cpath_end_string;
          } else {
            $link_title = $category['name'];
          }
          
          if ( isset($this->_data[$category_id]) && $level === 0 ) {
              $this->class = ' data-toggle="dropdown" class="dropdown-toggle"';
              $this->caret = '<b class="caret"></b>';             
          }else{
              $this->caret = '';
              $this->class = '';
          }


          $result .= str_repeat($this->spacer_string, $this->spacer_multiplier * $level) . '<a href="' . osc_href_link(null, 'cPath=' . $category_link) . '"' . $this->class . '>' . $link_title .  $this->caret . $this->separator .'</a>';

          if ( !isset($this->_data[$category_id]) && $level === 0 ) {
            $result .= $this->parent_end_string;
          }

          
          if ( isset($this->_data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level+1)) ) {
            if ( $this->follow_cpath === true ) {
              if ( in_array($category_id, $this->cpath_array) ) {
                $result .= $this->_buildBranch($category_id, $level+1);
              }
            } else {
              $result .= $this->_buildBranch($category_id, $level+1);
            }
          }
        }
      }

      $result .= ((($level === 0) && ($this->parent_group_apply_to_root === true)) || ($level > 0)) ? $this->parent_group_end_string : null;

      return $result;
    }
}
?>