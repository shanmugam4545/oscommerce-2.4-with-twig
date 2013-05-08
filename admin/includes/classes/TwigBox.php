<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TwigBox
 *
 * @author laurent
 */
class TwigBox extends box{
    
    public function __construct() {
        parent::box();
    }
    
    function infoBox($heading, $contents) {
      $this->table_row_parameters = 'class="text-success text-center"';
      $this->table_data_parameters = '';
      $this->heading = $this->tableBlock($heading);

      $this->table_row_parameters = '';
      $this->table_data_parameters = '';
      $this->contents = $this->tableBlock($contents);

      return $this->heading . $this->contents;
    }
    
    function menuBox($heading, $contents) {
      $this->table_data_parameters = '';
      if (isset($heading[0]['link'])) {
        $this->table_data_parameters .= ' onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . $heading[0]['link'] . '\'"';
        $heading[0]['text'] = '&nbsp;<a href="' . $heading[0]['link'] . '">' . $heading[0]['text'] . '</a>&nbsp;';
      } else {
        $heading[0]['text'] = '&nbsp; ' . $heading[0]['text'] . '&nbsp;';
      }
      $this->heading = $this->tableBlock($heading);

      $this->table_data_parameters = '';
      $this->contents = (!empty($contents) ? $this->tableBlock($contents) : '');

      return $this->heading . $this->contents;
    }
}

?>
