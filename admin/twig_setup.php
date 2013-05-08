<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  require('includes/application_top.php');
  
  require(DIR_WS_CLASSES . 'TwigBox.php');
  
  define('TABLE_TWIG_TEMPLATE', 'twig_templates');
  
  function osc_get_template($default = '') {
      
    $templates_array = array();
    
    if ($default) {
        
      $countries_array[] = array('id' => $default,
                                 'title' => '',
                                 );
    }
    
    $templates_query = osc_db_query("select id, title, code from " . TABLE_TWIG_TEMPLATE . " order by id");
    
    while ($templates = osc_db_fetch_array($templates_query)) {
        
      $templates_array[] = array('id' => $templates['code'],
                                 'text' => $templates['title']);
    }

    return $templates_array;
  }
  
  function osc_cfg_pull_down_template_list($template_id) {
    return osc_draw_pull_down_menu('configuration_value', osc_get_template(), $template_id);
  }
  
  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (osc_not_null($action)) {
    switch ($action) {
      case 'save':
        $configuration_value = osc_db_prepare_input($_POST['configuration_value']);
        $cID = osc_db_prepare_input($_GET['cID']);

        osc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . osc_db_input($configuration_value) . "', last_modified = now() where configuration_id = '" . (int)$cID . "'");

        osc_redirect(osc_href_link(FILENAME_TWIG_SETUP, 'cID=' . $cID));
        break;
    }
  }

  require(DIR_WS_INCLUDES . 'template_top.php');
  ?>
<div class="row-fluid">
    <div class="heading-twig-setup" style="height:70px;">
    <img src="images/twig-logo-64.png" class="img-polaroid pull-right"/>
    <h2 class="text-success" style="line-height:64px;"><?php echo TWIG_TITLE_SET_UP; ?></h2>
    </div>
    <div class="span9" style="margin-left:0px;margin-top: 30px;margin-right:0px;">
    <table class="table table-hover table-bordered">
    <thead>
      <tr>
     <th><?php echo TABLE_HEADING_CONFIGURATION_TITLE; ?></th>
     <th style="text-align:center;"><?php echo TABLE_HEADING_CONFIGURATION_VALUE; ?></th>
     <th style="text-align:right;"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</th>
     </tr>
     </thead>   
  <tbody>

              

              
<?php
  $configuration_query = osc_db_query("select configuration_id, configuration_title, configuration_key, configuration_value, use_function, configuration_group_id from " . TABLE_CONFIGURATION . " where configuration_group_id = 16 and configuration_key like '%TWIG%'");
  while ($configuration = osc_db_fetch_array($configuration_query)) {
    if (osc_not_null($configuration['use_function'])) {
      $use_function = $configuration['use_function'];
      if (preg_match('/->/', $use_function)) {
        $class_method = explode('->', $use_function);
        if (!is_object(${$class_method[0]})) {
          include(DIR_WS_CLASSES . $class_method[0] . '.php');
          ${$class_method[0]} = new $class_method[0]();
        }
        $cfgValue = osc_call_function($class_method[1], $configuration['configuration_value'], ${$class_method[0]});
      } else {
        $cfgValue = osc_call_function($use_function, $configuration['configuration_value']);
      }
    } else {
      $cfgValue = $configuration['configuration_value'];
    }

    if ((!isset($_GET['cID']) || (isset($_GET['cID']) && ($_GET['cID'] == $configuration['configuration_id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
      $cfg_extra_query = osc_db_query("select configuration_key, configuration_description, date_added, last_modified, use_function, set_function from " . TABLE_CONFIGURATION . " where configuration_id = '" . (int)$configuration['configuration_id'] . "'");
      $cfg_extra = osc_db_fetch_array($cfg_extra_query);

      $cInfo_array = array_merge($configuration, $cfg_extra);
      $cInfo = new objectInfo($cInfo_array);
    }

    if ( (isset($cInfo) && is_object($cInfo)) && ($configuration['configuration_id'] == $cInfo->configuration_id) ) {
      echo '                  <tr id="defaultSelected" class="success" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . osc_href_link(FILENAME_TWIG_SETUP, 'cID=' . $cInfo->configuration_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '                  <tr onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . osc_href_link(FILENAME_TWIG_SETUP, 'cID=' . $configuration['configuration_id']) . '\'">' . "\n";
    }
?>
                <td><?php echo $configuration['configuration_title']; ?></td>
                <td><p class="text-center"><?php echo htmlspecialchars($cfgValue); ?></p></td>
                <td><p class="text-right"><?php if ( (isset($cInfo) && is_object($cInfo)) && ($configuration['configuration_id'] == $cInfo->configuration_id) ) { echo osc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . osc_href_link(FILENAME_TWIG_SETUP, 'cID=' . $configuration['configuration_id']) . '">' . osc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</p></td>
              </tr>
<?php
  }
?>
</table></tbody></div>
    <div class="span3 pull-right" style="margin-left:0px;margin-top: 20px;margin-right:0px;">
        <table><tr>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'edit':
      $heading[] = array('text' => '<h4>' . $cInfo->configuration_title . '</h4>');

      if ($cInfo->set_function) {
        eval('$value_field = ' . $cInfo->set_function . '"' . htmlspecialchars($cInfo->configuration_value) . '");');
      } else {
        $value_field = osc_draw_input_field('configuration_value', $cInfo->configuration_value);
      }

      $contents = array('form' => osc_draw_form('configuration', FILENAME_TWIG_SETUP, '&cID=' . $cInfo->configuration_id . '&action=save'));
      $contents[] = array('text' => '<p>' . TEXT_INFO_EDIT_INTRO . '</p>');
      $contents[] = array('text' => '<br /><strong>' . $cInfo->configuration_title . '</strong><br />' . $cInfo->configuration_description . '<br />' . $value_field);
      $contents[] = array('align' => 'center', 'text' => '<br /><div class="btn-group">' . osc_bootstrap_button(IMAGE_SAVE, null, null, 'success') . osc_bootstrap_button(IMAGE_CANCEL, null, osc_href_link(FILENAME_TWIG_SETUP, 'cID=' . $cInfo->configuration_id),'btn'). '</div>');
      break;
    default:
      if (isset($cInfo) && is_object($cInfo)) {
        $heading[] = array('text' => '<h4>' . $cInfo->configuration_title . '</h4>');

        $contents[] = array('align' => 'center', 'text' => osc_bootstrap_button(IMAGE_EDIT, 'wrench', osc_href_link(FILENAME_TWIG_SETUP, 'cID=' . $cInfo->configuration_id . '&action=edit'),'success'));
        $contents[] = array('text' => '<br /><p>' . $cInfo->configuration_description . '</p>');
        $contents[] = array('text' => '<br /><p><i class="icon-calendar"></i>' . TEXT_INFO_DATE_ADDED . ' ' . osc_date_short($cInfo->date_added) . '</p>');
        if (osc_not_null($cInfo->last_modified)) $contents[] = array('text' => '<p><i class="icon-calendar"></i>' . TEXT_INFO_LAST_MODIFIED . ' ' . osc_date_short($cInfo->last_modified) . '</p>');
      }
      break;
  }

  if ( (osc_not_null($heading)) && (osc_not_null($contents)) ) {
    echo '            <td class="span3">' . "\n";

    $box = new TwigBox;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table>
     
    </div>    
</div>
<div class="text-success"><p class="text-info text-center"><blockquote>Twig Library : developped by Fabien Potencier<small>&copy; Sensio Labs : <a href="http://twig.sensiolabs.org/" target="_blank">Official documentation</a></small><br />Adapted by FoxP2 for osCommerce 2.4 <small>&copy; foXtension.com : <a href="http://www.twig.foxtension.com/" target="_blank">Twig Dynamic Template System Project</a></small></blockquote></p></div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>