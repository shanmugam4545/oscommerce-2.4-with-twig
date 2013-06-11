<?php
/*
$Id$

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2010 osCommerce
Copyright (c) 2013 FoxP2 http://www.oscommerce.fr

Released under the GNU General Public License
*/

require('includes/application_top.php');

$languages = osc_get_languages();

// foxp2: todo -> move to templates table
$products_options_templates_available = array(
    array('id' => 'classic_dropdown', 'text' => 'Classic dropdown'),
    array('id' => 'button_dropdown', 'text' => 'Dropdown button'),
    array('id' => 'options_table', 'text' => 'Option with table'),
    array('id' => 'options_with_text', 'text' => 'Options with text'),
    array('id' => 'options_with_images', 'text' => 'Options with images'));

$action = (isset($_GET['action']) ? $_GET['action'] : '');

$step_row = 5;

$row_number = (isset($_GET['row_number']) && is_numeric($_GET['row_number'])) ? $_GET['row_number'] : 10;

$option_page = (isset($_GET['option_page']) && is_numeric($_GET['option_page'])) ? $_GET['option_page'] : 1;

$value_page = (isset($_GET['value_page']) && is_numeric($_GET['value_page'])) ? $_GET['value_page'] : 1;

$attribute_page = (isset($_GET['attribute_page']) && is_numeric($_GET['attribute_page'])) ? $_GET['attribute_page'] : 1;

$page_row = 'option_page=' . $option_page . '&value_page=' . $value_page . '&attribute_page=' . $attribute_page;

$page_info = 'option_page=' . $option_page . '&value_page=' . $value_page . '&attribute_page=' . $attribute_page . '&row_number=' . $row_number;

if (osc_not_null($action)) {
    switch ($action) {
        case 'add_product_options':
            $option_image = new upload('option_image');
            $option_image->set_destination(DIR_FS_CATALOG_IMAGES . 'options_images');
            $products_options_id = osc_db_prepare_input($_POST['products_options_id']);            
            $option_template = osc_db_prepare_input($_POST['option_template']);
            $option_required = osc_db_prepare_input($_POST['option_required']);
            if ($option_image->parse() && $option_image->save()) {
                for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                    osc_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_image = '" . osc_db_input($option_image->filename) . "' where products_options_id = '" . (int) $products_options_id . "' and language_id = '" . (int) $languages[$i]['id'] . "'");
                }
            }          
            $option_name_array = $_POST['option_name'];            
            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                $option_name = osc_db_prepare_input($option_name_array[$languages[$i]['id']]);
                osc_db_query("insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id, products_options_name, products_options_template, products_options_required, products_options_image, language_id) values ('" . (int) $products_options_id . "', '" . osc_db_input($option_name) . "', '" . osc_db_input($option_template) . "','" . osc_db_input($option_required) . "','" . osc_db_input($option_image->filename) . "','" . (int) $languages[$i]['id'] . "')");
            
            }
            $OSCOM_Cache->clear('option_count');
            $messageStack->add_session(sprintf(INSERT_OPTION_NAME_SUCCESS, $products_options_id), 'success');
            osc_redirect(osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'add_product_option_values':
            $value_image = new upload('value_image');
            $value_image->set_destination(DIR_FS_CATALOG_IMAGES . 'values_images');
            $value_name_array = $_POST['value_name'];
            $value_id = osc_db_prepare_input($_POST['value_id']);
            $option_id = osc_db_prepare_input($_POST['option_id']);
            if ($value_image->parse() && $value_image->save()) {
                for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                    osc_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_image = '" . osc_db_input($value_image->filename) . "' where products_options_values_id = '" . (int) $value_id . "' and language_id = '" . (int) $languages[$i]['id'] . "'");
                }
            }             
            $option_description_array = osc_db_prepare_input($_POST['option_description']);
            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                $value_name = osc_db_prepare_input($value_name_array[$languages[$i]['id']]);
                $value_description = osc_db_prepare_input($option_description_array[$languages[$i]['id']]);
                osc_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name, products_options_values_image, products_options_values_description) values ('" . (int) $value_id . "', '" . (int) $languages[$i]['id'] . "', '" . osc_db_input($value_name) . "', '" . osc_db_input($value_image->filename) . "', '" . osc_db_input($value_description) . "')");
            }
            osc_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " (products_options_id, products_options_values_id) values ('" . (int) $option_id . "', '" . (int) $value_id . "')");
            $OSCOM_Cache->clear('value_count');
            $messageStack->add_session(sprintf(INSERT_OPTION_NAME_SUCCESS, $option_id), 'success');
            osc_redirect(osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'add_product_attributes':
            $products_id = osc_db_prepare_input($_POST['products_id']);
            $options_id = osc_db_prepare_input($_POST['options_id']);
            $values_id = osc_db_prepare_input($_POST['values_id']);
            $value_price = osc_db_prepare_input($_POST['value_price']);
            $price_prefix = osc_db_prepare_input($_POST['price_prefix']);
            osc_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES . " values (null, '" . (int) $products_id . "', '" . (int) $options_id . "', '" . (int) $values_id . "', '" . (float) osc_db_input($value_price) . "', '" . osc_db_input($price_prefix) . "')");
            if (DOWNLOAD_ENABLED == 'true') {
                $products_attributes_id = osc_db_insert_id();
                $products_attributes_filename = osc_db_prepare_input($_POST['products_attributes_filename']);
                $products_attributes_maxdays = osc_db_prepare_input($_POST['products_attributes_maxdays']);
                $products_attributes_maxcount = osc_db_prepare_input($_POST['products_attributes_maxcount']);
                if (osc_not_null($products_attributes_filename)) {
                    osc_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " values (" . (int) $products_attributes_id . ", '" . osc_db_input($products_attributes_filename) . "', '" . osc_db_input($products_attributes_maxdays) . "', '" . osc_db_input($products_attributes_maxcount) . "')");
                }
            }
            $OSCOM_Cache->clear('attribute_count');
            $messageStack->add_session(sprintf(INSERT_PRODUCT_ATTRIBUTE_SUCCESS, $products_attributes_id), 'success');
            osc_redirect(osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'update_option_name':            
            $option_name_array = $_POST['option_name'];
            $option_id = osc_db_prepare_input($_POST['option_id']); 
            $option_template = osc_db_prepare_input($_POST['option_template']); 
            $option_required = osc_db_prepare_input($_POST['option_required']); 
            $option_image = osc_db_prepare_input($_POST['option_image']); 
            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                $option_name = osc_db_prepare_input($option_name_array[$languages[$i]['id']]);
                osc_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_name = '" . osc_db_input($option_name) . "', products_options_template = '" . osc_db_input($option_template) . "', products_options_required = '" . osc_db_input($option_required) . "', products_options_image = '" . osc_db_input($option_image) . "' where products_options_id = '" . (int) $option_id . "' and language_id = '" . (int) $languages[$i]['id'] . "'");
            }
            $messageStack->add_session(sprintf(UPDATE_OPTION_NAME_SUCCESS, $option_id), 'info');
            osc_redirect(osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info));             
            break;
        case 'update_value':
            $value_name_array = $_POST['value_name'];
            $option_description_array = osc_db_prepare_input($_POST['option_description']);
            $value_id = osc_db_prepare_input($_POST['value_id']);
            $option_id = osc_db_prepare_input($_POST['option_id']);
            $value_image = osc_db_prepare_input($_POST['value_image']); 
            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                $value_name = osc_db_prepare_input($value_name_array[$languages[$i]['id']]);
                $value_description = osc_db_prepare_input($option_description_array[$languages[$i]['id']]);
                osc_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_description = '" . osc_db_input($value_description) . "' , products_options_values_name = '" . osc_db_input($value_name) . "', products_options_values_image = '" . osc_db_input($value_image) . "' where products_options_values_id = '" . osc_db_input($value_id) . "' and language_id = '" . (int) $languages[$i]['id'] . "'");
            }
            osc_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " set products_options_id = '" . (int) $option_id . "'  where products_options_values_id = '" . (int) $value_id . "'");            
            $messageStack->add_session(sprintf(UPDATE_OPTION_VALUE_SUCCESS, $value_id), 'info');
            osc_redirect(osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'update_product_attribute':
            $products_id = osc_db_prepare_input($_POST['products_id']);
            $options_id = osc_db_prepare_input($_POST['options_id']);
            $values_id = osc_db_prepare_input($_POST['values_id']);
            $value_price = osc_db_prepare_input($_POST['value_price']);
            $price_prefix = osc_db_prepare_input($_POST['price_prefix']);
            $attribute_id = osc_db_prepare_input($_POST['attribute_id']);
            osc_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES . " set products_id = '" . (int) $products_id . "', options_id = '" . (int) $options_id . "', options_values_id = '" . (int) $values_id . "', options_values_price = '" . (float) osc_db_input($value_price) . "', price_prefix = '" . osc_db_input($price_prefix) . "' where products_attributes_id = '" . (int) $attribute_id . "'");
            if (DOWNLOAD_ENABLED == 'true') {
                $products_attributes_filename = osc_db_prepare_input($_POST['products_attributes_filename']);
                $products_attributes_maxdays = osc_db_prepare_input($_POST['products_attributes_maxdays']);
                $products_attributes_maxcount = osc_db_prepare_input($_POST['products_attributes_maxcount']);
                if (osc_not_null($products_attributes_filename)) {
                    osc_db_query("replace into " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " set products_attributes_id = '" . (int) $attribute_id . "', products_attributes_filename = '" . osc_db_input($products_attributes_filename) . "', products_attributes_maxdays = '" . osc_db_input($products_attributes_maxdays) . "', products_attributes_maxcount = '" . osc_db_input($products_attributes_maxcount) . "'");
                }
            }           
            $messageStack->add_session(sprintf(UPDATE_PRODUCT_ATTRIBUTE_SUCCESS, $attribute_id), 'info');
            osc_redirect(osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'delete_option':
            $option_id = osc_db_prepare_input($_GET['option_id']);
            $option_image_query = osc_db_query("select products_options_image from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int) $option_id . "'");
            if (osc_db_num_rows($option_image_query)) {
                while ($option_image = osc_db_fetch_array($option_image_query)) {                    
                    if (file_exists(DIR_FS_CATALOG_IMAGES . 'options_images/' . $option_image['products_options_image'])) {                        
                        @unlink(DIR_FS_CATALOG_IMAGES . 'options_images/' . $option_image['products_options_image']);
                    }
                }
            }            
            osc_db_query("delete from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int) $option_id . "'");
            $products_options_values_query = osc_db_query("select products_options_values_id from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int) $option_id . "'");
            while ($products_options_values = osc_db_fetch_array($products_options_values_query)) {   
                osc_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int) $products_options_values['products_options_values_id'] . "'");                
            }            
            osc_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int) $option_id . "'");
            $OSCOM_Cache->clear('option_count');
            $messageStack->add_session(sprintf(DELETE_OPTION_NAME_SUCCESS, $option_id), 'warning');
            osc_redirect(osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'delete_value':
            $value_id = osc_db_prepare_input($_GET['value_id']);
            $value_image_query = osc_db_query("select products_options_values_image from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int) $value_id . "'");
            if (osc_db_num_rows($value_image_query)) {
                while ($value_image = osc_db_fetch_array($value_image_query)) {                    
                    if (file_exists(DIR_FS_CATALOG_IMAGES . 'values_images/' . $value_image['products_options_values_image'])) {                        
                        @unlink(DIR_FS_CATALOG_IMAGES . 'values_images/' . $value_image['products_options_values_image']);
                    }
                }
            }            
            osc_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int) $value_id . "'");
            osc_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int) $value_id . "'");
            osc_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_values_id = '" . (int) $value_id . "'");            
            $OSCOM_Cache->clear('value_count');
            $messageStack->add_session(sprintf(DELETE_OPTION_VALUE_SUCCESS, $value_id), 'warning');
            osc_redirect(osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'delete_attribute':
            $attribute_id = osc_db_prepare_input($_GET['attribute_id']);
            osc_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_attributes_id = '" . (int) $attribute_id . "'");
// added for DOWNLOAD_ENABLED. Always try to remove attributes, even if downloads are no longer enabled
            osc_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id = '" . (int) $attribute_id . "'");
            $OSCOM_Cache->clear('attribute_count');            
            $messageStack->add_session(sprintf(DELETE_PRODUCT_ATTRIBUTE_SUCCESS, $attribute_id), 'warning');
            osc_redirect(osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info));
            break;
    }
}

$max_options_id_query = osc_db_query("select max(products_options_id) + 1 as next_id from " . TABLE_PRODUCTS_OPTIONS);
$max_options_id_values = osc_db_fetch_array($max_options_id_query);
$next_id_option = osc_not_null($max_options_id_values['next_id']) ? $max_options_id_values['next_id'] : 1;

$max_values_id_query = osc_db_query("select max(products_options_values_id) + 1 as next_id from " . TABLE_PRODUCTS_OPTIONS_VALUES);
$max_values_id_values = osc_db_fetch_array($max_values_id_query);
$option_value_next_id = osc_not_null($max_values_id_values['next_id']) ? $max_values_id_values['next_id'] : 1;

  if (is_dir(DIR_FS_CATALOG_IMAGES . 'options_images')) {
    if (!osc_is_writable(DIR_FS_CATALOG_IMAGES. 'options_images')) $messageStack->add_session(ERROR_CATALOG_IMAGE_DIRECTORY_OPTIONS_IMAGES_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add_session(ERROR_CATALOG_IMAGE_DIRECTORY_OPTIONS_IMAGES_DOES_NOT_EXIST, 'error');
  }
  
  if (is_dir(DIR_FS_CATALOG_IMAGES . 'values_images')) {
    if (!osc_is_writable(DIR_FS_CATALOG_IMAGES. 'values_images')) $messageStack->add_session(ERROR_CATALOG_IMAGE_DIRECTORY_VALUES_IMAGES_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add_session(ERROR_CATALOG_IMAGE_DIRECTORY_VALUES_IMAGES_DOES_NOT_EXIST, 'error');
  }

require(DIR_WS_INCLUDES . 'template_top.php');

?>
    <div class="heading-twig-setup" style="height:90px;">
    <img src="images/twig-logo-64.png" alt="twig-logo-64.png" class="img-polaroid pull-right"/>
    <h2 class="text-success" style="line-height:64px;"><?php echo TWIG_PRODUCTS_ATTRIBUTES_TITLE; ?></h2>
    </div>
<?php
  if ($messageStack->size > 0) {
    echo '<div class="clearfix">';
    echo $messageStack->output();
    echo '</div>';
    
  }
?>    
<div class="accordion" id="products_attributes_accordion">
<!-- options and values//-->
<!-- options //-->
<?php
if ($action == 'delete_product_option') { // delete product option    
    $options = osc_db_query("select products_options_id, products_options_name, products_options_template, products_options_required, products_options_image from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int) $_GET['option_id'] . "' and language_id = '" . (int) $_SESSION['languages_id'] . "'");
    $options_values = osc_db_fetch_array($options);    
?>
     <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="products_attributes_accordion" href="#blockoptions">
                <h3 class="text-info"><?php echo HEADING_TITLE_OPT; ?></h3></a>
        </div>
        <div id="blockoptions" class="accordion-body row-fluid collapse">
            <div class="accordion-inner">
                <h4><?php echo TABLE_HEADING_OPT_NAME; ?> : <?php echo $options_values['products_options_name']; ?></h4>
    <?php
    $products = osc_db_query("select p.products_id, pd.products_name, pov.products_options_values_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov, " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pov.language_id = '" . (int) $_SESSION['languages_id'] . "' and pd.language_id = '" . (int) $_SESSION['languages_id'] . "' and pa.products_id = p.products_id and pa.options_id='" . (int) $_GET['option_id'] . "' and pov.products_options_values_id = pa.options_values_id order by pd.products_name");
    $products_count = osc_db_num_rows($products);
    ?>    
        <?php if( $products_count > 0) { ?>
            <table class="table table-condensed table-bordered table-striped table-hover">
            <caption class="well text-error"><strong><?php echo TEXT_WARNING_OF_DELETE; ?></strong></caption>       
                <thead>
                    <tr>
                        <th style="text-align:center;"><?php echo TABLE_HEADING_ID; ?></th>
                        <th style="text-align:center;"><?php echo TABLE_HEADING_PRODUCT; ?></th>
                        <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_VALUE; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php                    
                    while ($products_values = osc_db_fetch_array($products)) {                        
                        ?>
                        <tr class="warning">
                            <td style="vertical-align:middle;text-align: center;"><?php echo $products_values['products_id']; ?>
                            <td style="vertical-align:middle;text-align: center;"><?php echo $products_values['products_name']; ?>
                            <td style="vertical-align:middle;text-align: center;"><?php echo $products_values['products_options_values_name']; ?>
                        </tr>
                        <?php  }   ?>
                </tbody>
            </table>
      <div>
        <a class="btn btn-small pull-right" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a>
      </div>
    <?php } else { ?>
        <div class="text-warning"><strong><?php echo TEXT_OK_TO_DELETE; ?></strong>
        <span class="pull-right btn-group"><a class="btn btn-small btn-danger" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=delete_option&option_id=' . $_GET['option_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-trash icon-white"></i> <?php echo IMAGE_DELETE; ?></a><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a></span>
        </div> 
        <?php
    }
} else {
        ?>
    <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="products_attributes_accordion" href="#blockoptions">
                    <h3 class="text-info pull-left"><?php echo HEADING_TITLE_OPT; ?></h3>
                </a>
            </div>
            <div class="text-info blockoptions hide" style="margin-right:10px;">
                <?php 
                   if ($OSCOM_Cache->read('option_count')) {
                        $option_count = $OSCOM_Cache->getCache();
                    } else {
                        $option_count_query = osc_db_query("select distinct(products_options_id) from " . TABLE_PRODUCTS_OPTIONS);
                        $option_count = osc_db_num_rows($option_count_query);
                        $OSCOM_Cache->write($option_count, 'option_count');
                    }
                $options = "select * from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . (int) $_SESSION['languages_id'] . "' order by products_options_id";
                $options_split = new splitPageResults($option_page, $row_number, $options, $options_query_numrows);
                echo $options_split->display_pagination($options_query_numrows, $row_number, (MAX_DISPLAY_PAGE_LINKS/$row_number), $option_page, 'value_page=' . $value_page . '&attribute_page=' . $attribute_page . '&row_number=' . $row_number, 'option_page');
                ?>
            </div>
            <div id="blockoptions" class="accordion-body row-fluid collapse">
                <div class="accordion-inner">
                    <?php
                    if (($action == 'update_option') && $_GET['option_id']) {                        
                        echo '<form name="option" action="' . osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=update_option_name&' . $page_info, 'NONSSL') . '" method="post" enctype="multipart/form-data">';
                    } else {                        
                        echo '<form name="options" action="' . osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=add_product_options&' . $page_info, 'NONSSL') . '" method="post" enctype="multipart/form-data"><input type="hidden" name="products_options_id" value="' . $next_id_option . '">';
                    }
                    ?>
                    <table class="table table-condensed table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_ID; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_NAME; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_TEMPLATE; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_REQUIRED; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_IMAGE; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_ACTION; ?></th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php                               
                                $options = osc_db_query($options);                                                              
                                while ($options_values = osc_db_fetch_array($options)) {
                                    if (($action == 'update_option') && ($_GET['option_id'] == $options_values['products_options_id'])) {
                                        $inputs = '';
                                        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                            $option_name = osc_db_query("select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . $options_values['products_options_id'] . "' and language_id = '" . $languages[$i]['id'] . "'");
                                            $option_name = osc_db_fetch_array($option_name);
                                            $inputs .= '<div class="input-prepend" style="margin-top:5px;"><span class="add-on"><img alt="' . $languages[$i]['name'] . '" src="' . DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'] . '"></span><input type="text" name="option_name[' . $languages[$i]['id'] . ']" value="' . $option_name['products_options_name'] . '"></div><br />';
                                        }
                                        ?>
                                        <tr class="info">
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $options_values['products_options_id']; ?><input type="hidden" name="option_id" value="<?php echo $options_values['products_options_id']; ?>">&nbsp;</td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $inputs; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo osc_draw_pull_down_menu('option_template', $products_options_templates_available, $options_values['products_options_template']); ?></td>
                                             <td style="vertical-align:middle;text-align: center;">
                                            <div class="btn-group" style="margin-top:-15px;" data-toggle-name="option_required" data-toggle="buttons-radio">
                                                <button type="button" value="1" class="btn" data-toggle="button"><?php echo TEXT_TRUE_CONFIG; ?></button>
                                                <button type="button" value="0" class="btn" data-toggle="button"><?php echo TEXT_FALSE_CONFIG; ?></button>
                                            </div>                                            
                                            <input type="hidden" name="option_required" value="<?php echo $options_values['products_options_required']; ?>">
                                            </td>                                           
                                            <td style="vertical-align:middle;text-align: center;"><input style="margin-top: -15px" name="option_image" type="file" value=""></td>                                            
                                            <td style="vertical-align:middle;text-align: center;"><div class="btn-group" style="margin-top:-15px"><button class="btn btn-small btn-primary" type="submit"><i class="icon-check icon-white"></i> <?php echo IMAGE_SAVE; ?></button><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a></div></td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $options_values["products_options_id"]; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $options_values["products_options_name"]; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $options_values['products_options_template']; ?></td>
                                            <td style="vertical-align:middle;text-align: center;">
                                                <?php
                                                if ($options_values['products_options_required'] == '1') {
                                                    echo '<span class="text-success"><strong><i class="icon-fa-ok-sign"></i>  ' . TEXT_TRUE_CONFIG . '</strong></span>';
                                                } else {
                                                    echo '<span class="text-error"><strong><i class="icon-fa-remove-sign"></i>  ' . TEXT_FALSE_CONFIG . '</strong></span>';
                                                }
                                                ?>
                                            </td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo osc_not_null($options_values['products_options_image']) ? osc_image(DIR_WS_CATALOG_IMAGES . 'options_images/' . $options_values['products_options_image'],$options_values['products_options_image'],'50','50') : '' ; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><div class="btn-group"><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=update_option&option_id=' . $options_values['products_options_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-edit"></i> <?php echo IMAGE_EDIT; ?></a><a class="btn btn-danger btn-small" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=delete_product_option&option_id=' . $options_values['products_options_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-trash icon-white"></i> <?php echo IMAGE_DELETE; ?></a></div></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                if ($action != 'update_option') {                                    
                                    $inputs = '';
                                    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                        $inputs .= '<div class="input-prepend" style="margin-top:5px;"><span class="add-on"><img alt="' . $languages[$i]['name'] . '" src="' . DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'] . '"></span><input type="text" name="option_name[' . $languages[$i]['id'] . ']" ></div><br />';
                                    }
                                    ?>
                                    <tr class="success">
                                        <td style="vertical-align:middle;text-align: center;"><?php echo $next_id_option; ?></td>
                                        <td style="vertical-align:middle;text-align: center;"><?php echo $inputs; ?></td>
                                        <td style="vertical-align:middle;text-align: center;"><?php echo osc_draw_pull_down_menu('option_template', $products_options_templates_available, $options_values['products_options_template']); ?></td>
                                        <td style="vertical-align:middle;text-align: center;">
                                            <div class="btn-group" style="margin-top:-15px;" data-toggle-name="option_required" data-toggle="buttons-radio">
                                                <button type="button" value="1" class="btn" data-toggle="button"><?php echo TEXT_TRUE_CONFIG; ?></button>
                                                <button type="button" value="0" class="btn" data-toggle="button"><?php echo TEXT_FALSE_CONFIG; ?></button>
                                            </div>
                                            <input type="hidden" name="option_required" value="1">                                            
                                        </td>
                                        <td style="vertical-align:middle;text-align: center;"><input style="margin-top: -15px" name="option_image" type="file"></td>
                                        <td style="vertical-align:middle;text-align: center;"><button type="submit" class="btn btn-small btn-success" style="margin-top:-15px"><i class="icon-plus icon-white"></i> <?php echo IMAGE_INSERT; ?></button></td>
                                    </tr>
                                    <tr class="well">
                                        <td colspan="6">
                                            <span class="text-info pull-left"><strong><?php echo NUMBER_OF_ROW_TO_DISPLAY; ?></strong>
                                                <span class="btn-group" data-toggle-name="row_number" data-toggle="buttons-radio">                                                    
                                                    <?php                                                  
                                                    for($x=1; $x <= ceil($option_count/$step_row); $x++) {                                                         
                                                        echo '<a class="btn btn-info" data-toggle="button" href="' . osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_row . '&row_number=' . $x*$step_row) . '">' . $x*$step_row . '</a>';
                                                    }?>
                                                </span>
                                            </span>
                                            <input type="hidden" name="row_number" value="<?php echo $row_number; ?>">
                                        </td>
                                   </tr>
                                <?php
                            }
                            echo '</tbody></table></form>';
                        }                        
                    ?>
                </div>
          </div>
    </div>
<!-- options eof //-->
<!-- value //-->
<?php
if ($action == 'delete_option_value') { // delete product option value
    $values = osc_db_query("select products_options_values_id, products_options_values_name, products_options_values_image from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int) $_GET['value_id'] . "' and language_id = '" . (int) $_SESSION['languages_id'] . "'");
    $values_values = osc_db_fetch_array($values);
    ?>
    <?php
    $products = osc_db_query("select p.products_id, pd.products_name, po.products_options_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS . " po, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . (int) $_SESSION['languages_id'] . "' and po.language_id = '" . (int) $_SESSION['languages_id'] . "' and pa.products_id = p.products_id and pa.options_values_id='" . (int) $_GET['value_id'] . "' and po.products_options_id = pa.options_id order by pd.products_name");
    $products_count = osc_db_num_rows($products);
        ?>
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#products_attributes_accordion" href="#blockoptionsvalues">
                    <h3 class="text-info pull-left"><?php echo HEADING_TITLE_VAL; ?></h3></a>
            </div>
            <div id="blockoptionsvalues" class="accordion-body row-fluid collapse">
                <div class="accordion-inner">
                    <h4 class="text-warning"><?php echo TABLE_HEADING_OPT_VALUE; ?> : <?php echo $values_values['products_options_values_name']; ?></h4> 
                    <?php if ( $products_count > 0 ) { ?>
                    <table class="table table-condensed table-bordered table-striped table-hover row-fluid">
                        <caption class="well text-error"><strong><?php echo TEXT_WARNING_OF_DELETE; ?></strong></caption>
                        <thead>
                            <tr>
                                <th style="text-align:center;"><?php echo TABLE_HEADING_ID; ?></th>
                                <th style="text-align:center;"><?php echo TABLE_HEADING_PRODUCT; ?></th>
                                <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_NAME; ?></th>
                            </tr>
                        </thead> 
                        <tbody>
                            <?php
                            while ($products_values = osc_db_fetch_array($products)) {                                
                                ?>
                                <tr class="warning">
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $products_values['products_id']; ?></td>
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $products_values['products_name']; ?></td>
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $products_values['products_options_name']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div>
                        <a class="btn pull-right" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a>
                    </div>
                <?php } else { ?>
                            <div class="text-error"><p class="text-center"><strong><?php echo TEXT_OK_TO_DELETE; ?></strong></p>
                                <div class="btn-group pull-right">
                                    <a class="btn btn-small btn-danger" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=delete_value&value_id=' . $_GET['value_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-trash icon-white"></i> <?php echo IMAGE_DELETE; ?></a><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a>
                                </div>
                            </div>
<?php
}
} else {
?>
        <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#products_attributes_accordion2" href="#blockoptionsvalues">
                        <h3 class="text-info pull-left"><?php echo HEADING_TITLE_VAL; ?></h3>
                    </a>
                </div>
                <div class="pull-right blockoptionsvalues hide" style="margin-right:10px;">
                <?php
                   if ($OSCOM_Cache->read('value_count')) {
                        $value_count = $OSCOM_Cache->getCache();
                    } else {
                    $value_count_query = osc_db_query("select distinct(products_options_values_id) from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS);
                    $value_count = osc_db_num_rows($value_count_query);  
                        $OSCOM_Cache->write($value_count, 'value_count');
                    }                  
                    $values = "select pov.products_options_values_id, pov.products_options_values_name, pov.products_options_values_image, pov.products_options_values_description, pov2po.products_options_id from " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov left join " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " pov2po on pov.products_options_values_id = pov2po.products_options_values_id where pov.language_id = '" . (int) $_SESSION['languages_id'] . "' order by pov.products_options_values_id";
                    $values_split = new splitPageResults($value_page, $row_number, $values, $values_query_numrows);
                    echo $values_split->display_pagination($values_query_numrows, $row_number, (MAX_DISPLAY_PAGE_LINKS/$row_number), $value_page, 'option_page=' . $option_page . '&attribute_page=' . $attribute_page. '&row_number=' . $row_number, 'value_page');
                    ?>
                </div>
                <div id="blockoptionsvalues" class="accordion-body row-fluid collapse">
                    <div class="accordion-inner">
                        <?php
                        if (($action == 'update_option_value') && ($_GET['value_id'])) {
                            echo '<form name="values" action="' . osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=update_value&' . $page_info, 'NONSSL') . '" method="post" enctype="multipart/form-data">';
                        } else {
                            echo '<form name="values" action="' . osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=add_product_option_values&' . $page_info, 'NONSSL') . '" method="post" enctype="multipart/form-data">';
                        }
                        ?>                        
                        <table class="table table-condensed table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_ID; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_NAME; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_VALUE; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_IMAGE; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_VALUE_DESCRIPTION; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_ACTION; ?></th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php                              
                                $values = osc_db_query($values);                                
                                while ($values_values = osc_db_fetch_array($values)) {                                    
                                    $options_name = osc_options_name($values_values['products_options_id']);
                                    $values_name = $values_values['products_options_values_name'];  
                                    $values_image = $values_values['products_options_values_image'];  
                                    $values_description = $values_values['products_options_values_description'];  
                                    ?>
                                    <?php
                                    if (($action == 'update_option_value') && ($_GET['value_id'] == $values_values['products_options_values_id'])) {
                                        $inputs = '';
                                        $textarea = '';
                                        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                            $value_name = osc_db_query("select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int) $values_values['products_options_values_id'] . "' and language_id = '" . (int) $languages[$i]['id'] . "'");
                                            $value_name = osc_db_fetch_array($value_name);
                                            $inputs .= '<div class="input-prepend" style="margin-top:5px;"><span class="add-on"><img alt="' . $languages[$i]['name'] . '" src="' . DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'] . '"></span><input type="text" name="value_name[' . $languages[$i]['id'] . ']" value="' . $value_name['products_options_values_name'] . '"></div><br />';
                                        }
                                        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                            $value_description = osc_db_query("select products_options_values_description from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int) $values_values['products_options_values_id'] . "' and language_id = '" . (int) $languages[$i]['id'] . "'");
                                            $value_description = osc_db_fetch_array($value_description);
                                            $textarea .= '<div style="margin-top:5px;"><span class="add-on"><img alt="' . $languages[$i]['name'] . '" src="' . DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'] . '"></span><br /><textarea  rows="10" class="input-xlarge" name="option_description[' . $languages[$i]['id'] . ']" >' . $value_description['products_options_values_description'] . '</textarea></div><br />';
                                        }                                        
                                        ?>
                                        <tr class="info">
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $values_values['products_options_values_id']; ?><input type="hidden" name="value_id" value="<?php echo $values_values['products_options_values_id']; ?>"></td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo "\n"; ?><select name="option_id">
                                                    <?php
                                                    $options = osc_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . (int) $_SESSION['languages_id'] . "' order by products_options_name");
                                                    while ($options_values = osc_db_fetch_array($options)) {
                                                        echo "\n" . '<option  value="' . $options_values['products_options_id'] . '"';
                                                        if ($values_values['products_options_id'] == $options_values['products_options_id']) {
                                                            echo ' selected';
                                                        }
                                                        echo '>' . $options_values['products_options_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select></td>
                                            <td style="vertical-align:middle;text-align: center"><?php echo $inputs; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><input style="margin-top: -15px" name="value_image" type="file"><br /><?php echo $values_values['products_options_values_image']; ?></td>
                                            <td style="vertical-align:middle;text-align: center"><?php echo $textarea; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><div class="btn-group"><button class="btn btn-small btn-primary" type="submit"><i class="icon-check icon-white"></i> <?php echo IMAGE_SAVE; ?></button><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a></div></td>
                                        </tr>
        <?php } else { ?>
                                        <tr>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $values_values["products_options_values_id"]; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $options_name; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $values_name; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $values_image ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $values_description; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><div class="btn-group"><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=update_option_value&value_id=' . $values_values['products_options_values_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-edit"></i> <?php echo IMAGE_EDIT; ?></a><a class="btn btn-small btn-danger" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=delete_option_value&value_id=' . $values_values['products_options_values_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-trash icon-white"></i> <?php echo IMAGE_DELETE; ?></a></div></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                <?php if ($action != 'update_option_value') { ?>
                                    <tr class="success">
                                        <td style="vertical-align:middle;text-align: center;"><?php echo $option_value_next_id; ?></td>
                                        <td style="vertical-align:middle;text-align: center;"><select name="option_id">
                                                <?php
                                                $options = osc_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . $_SESSION['languages_id'] . "' order by products_options_name");
                                                while ($options_values = osc_db_fetch_array($options)) {
                                                    echo '<option value="' . $options_values['products_options_id'] . '">' . $options_values['products_options_name'] . '</option>';
                                                }?>
                                                </select>
                                                <?php 
                                                $inputs = '';
                                                $textarea = '';
                                                for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                                    $inputs .= '<div class="input-prepend" style="margin-top:5px;"><span class="add-on"><img alt="' . $languages[$i]['name'] . '" src="' . DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'] . '"></span><input type="text" name="value_name[' . $languages[$i]['id'] . ']"></div><br />';
                                                    $textarea .= '<div style="margin-top:5px;"><span class="add-on"><img alt="' . $languages[$i]['name'] . '" src="' . DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'] . '"></span><br /><textarea class="input-xlarge" rows="5" name="option_description[' . $languages[$i]['id'] . ']"></textarea></div><br />';
                                                }
                                                ?>
                                            
                                        </td>
                                        <td style="vertical-align:middle;text-align: center;"><input type="hidden" name="value_id" value="<?php echo $option_value_next_id; ?>"><?php echo $inputs; ?></td>
                                        <td style="vertical-align:middle;text-align: center;"><input style="margin-top: -15px" name="value_image" type="file"></td>              
                                        <td style="vertical-align:middle;text-align: center;"><?php echo $textarea; ?></td>
                                        <td style="vertical-align:middle;text-align: center;"><button type="submit" class="btn-small btn-success"><i class="icon-plus icon-white"></i> <?php echo IMAGE_INSERT; ?></button></td>
                                    </tr>
                                    <tr class="well">
                                        <td colspan="6">
                                            <span class="pull-left text-info"><strong><?php echo NUMBER_OF_ROW_TO_DISPLAY; ?></strong>
                                                <span class="btn-group" data-toggle-name="row_number" data-toggle="buttons-radio">                                                
                                                    <?php                                                                
                                                    for($y=1; $y <= ceil($value_count/$step_row); $y++) {                                                         
                                                        echo '<a class="btn btn-info" data-toggle="button" href="' . osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_row . '&row_number=' . $y*$step_row) . '">' . $y*$step_row . '</a>';
                                                    }?>
                                                </span>
                                            </span>
                                            <input type="hidden" name="row_number" value="<?php echo $row_number; ?>">
                                        </td>
                                   </tr>                                    
                                    <?php
                                }                                
                           echo '</tbody></table></form>';                            
                                                }
                            ?>  
</div>
                </div>
        </div>               
            
        
<!-- option value eof //-->
<!-- products_attributes //-->  
<div class="accordion-group">
    <div class="accordion-heading">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#products_attributes_accordion" href="#blockproductsattributes">
            <h3 class="text-info pull-left"><?php echo HEADING_TITLE_ATRIB; ?></h3>
        </a>
    </div>
    <?php
    if ($action == 'update_attribute') {
        $form_action = 'update_product_attribute';
    } else {
        $form_action = 'add_product_attributes';
    }
    ?>
    <div class="blockproductsattributes hide">
        <?php
        if ($OSCOM_Cache->read('attribute_count')) {
            $attribute_count = $OSCOM_Cache->getCache();
        } else {
            $attribute_count_query = osc_db_query("select * from " . TABLE_PRODUCTS_ATTRIBUTES);
            $attribute_count = osc_db_num_rows($attribute_count_query);
            $OSCOM_Cache->write($attribute_count, 'attribute_count');
        }
        $attributes = "select pa.* from " . TABLE_PRODUCTS_ATTRIBUTES . " pa left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on pa.products_id = pd.products_id and pd.language_id = '" . (int) $_SESSION['languages_id'] . "' order by pd.products_name";
        $attributes_split = new splitPageResults($attribute_page, $row_number, $attributes, $attributes_query_numrows);
        echo $attributes_split->display_pagination($attributes_query_numrows, $row_number, (MAX_DISPLAY_PAGE_LINKS/$row_number), $attribute_page, 'option_page=' . $option_page . '&value_page=' . $value_page . '&row_number=' . $row_number, 'attribute_page');
        ?>
    </div>    
    <div id="blockproductsattributes" class="accordion-body row-fluid collapse">
        <div class="accordion-inner">
            <form name="attributes" action="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=' . $form_action . '&' . $page_info); ?>" method="post">
                <table class="table table-condensed table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="text-align:center;"><?php echo TABLE_HEADING_ID; ?></th>
                            <th style="text-align:center;"><?php echo TABLE_HEADING_PRODUCT; ?></th>
                            <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_NAME; ?></th>
                            <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_VALUE; ?></th>
                            <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_PRICE; ?></th>
                            <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_PRICE_PREFIX; ?></th>
                            <th style="text-align:center;"><?php echo TABLE_HEADING_ACTION; ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $next_id = 1;
                        $attributes = osc_db_query($attributes);
                        while ($attributes_values = osc_db_fetch_array($attributes)) {
                            $products_name_only = osc_get_products_name($attributes_values['products_id']);
                            $options_name = osc_options_name($attributes_values['options_id']);
                            $values_name = osc_values_name($attributes_values['options_values_id']);
                            if (($action == 'update_attribute') && ($_GET['attribute_id'] == $attributes_values['products_attributes_id'])) {
                                ?>
                                <tr class="info">
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $attributes_values['products_attributes_id']; ?><input type="hidden" name="attribute_id" value="<?php echo $attributes_values['products_attributes_id']; ?>"></td>
                                    <td style="vertical-align:middle;text-align: center;"><select name="products_id">
                                            <?php
                                            $products = osc_db_query("select p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "' order by pd.products_name");
                                            while ($products_values = osc_db_fetch_array($products)) {
                                                if ($attributes_values['products_id'] == $products_values['products_id']) {
                                                    echo "\n" . '<option value="' . $products_values['products_id'] . '" SELECTED>' . $products_values['products_name'] . '</option>';
                                                } else {
                                                    echo "\n" . '<option value="' . $products_values['products_id'] . '">' . $products_values['products_name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td style="vertical-align:middle;text-align: center;"><select name="options_id">
                                            <?php
                                            $options = osc_db_query("select * from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . $_SESSION['languages_id'] . "' order by products_options_name");
                                            while ($options_values = osc_db_fetch_array($options)) {
                                                if ($attributes_values['options_id'] == $options_values['products_options_id']) {
                                                    echo "\n" . '<option value="' . $options_values['products_options_id'] . '" SELECTED>' . $options_values['products_options_name'] . '</option>';
                                                } else {
                                                    echo "\n" . '<option value="' . $options_values['products_options_id'] . '">' . $options_values['products_options_name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td style="vertical-align:middle;text-align: center;"><select name="values_id">
                                            <?php
                                            $values = osc_db_query("select * from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where language_id ='" . $_SESSION['languages_id'] . "' order by products_options_values_name");
                                            while ($values_values = osc_db_fetch_array($values)) {
                                                if ($attributes_values['options_values_id'] == $values_values['products_options_values_id']) {
                                                    echo "\n" . '<option value="' . $values_values['products_options_values_id'] . '" SELECTED>' . $values_values['products_options_values_name'] . '</option>';
                                                } else {
                                                    echo "\n" . '<option value="' . $values_values['products_options_values_id'] . '">' . $values_values['products_options_values_name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td style="vertical-align:middle;text-align: center;"><input type="text" name="value_price" value="<?php echo $attributes_values['options_values_price']; ?>" class="input-block-level"></td>
                                    <td style="vertical-align:middle;text-align: center;"><input type="text" name="price_prefix" value="<?php echo $attributes_values['price_prefix']; ?>" class="input-block-level"></td>
                                    <td style="vertical-align:middle;text-align: center;"><div class="btn-group"><button class="btn btn-small btn-primary"><i class="icon-check icon-white"></i> <?php echo IMAGE_SAVE; ?></button><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a></div></td>
                                </tr>
                                <?php
                                if (DOWNLOAD_ENABLED == 'true') {
                                    $download_query_raw = "select products_attributes_filename, products_attributes_maxdays, products_attributes_maxcount from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id='" . $attributes_values['products_attributes_id'] . "'";
                                    $download_query = osc_db_query($download_query_raw);
                                    if (osc_db_num_rows($download_query) > 0) {
                                        $download = osc_db_fetch_array($download_query);
                                        $products_attributes_filename = $download['products_attributes_filename'];
                                        $products_attributes_maxdays = $download['products_attributes_maxdays'];
                                        $products_attributes_maxcount = $download['products_attributes_maxcount'];
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <table class="table table-condensed table-bordered table-striped table-hover row-fluid">
                                                <tr>
                                                    <td style="vertical-align:middle;text-align: center;"><?php echo TABLE_HEADING_DOWNLOAD; ?></td>
                                                    <td style="vertical-align:middle;text-align: center;"><?php echo TABLE_TEXT_FILENAME; ?></td>
                                                    <td style="vertical-align:middle;text-align: center;"><?php echo osc_draw_input_field('products_attributes_filename', $products_attributes_filename, 'size="15"'); ?></td>
                                                    <td style="vertical-align:middle;text-align: center;"><?php echo TABLE_TEXT_MAX_DAYS; ?></td>
                                                    <td style="vertical-align:middle;text-align: center;"><?php echo osc_draw_input_field('products_attributes_maxdays', $products_attributes_maxdays, 'size="5"'); ?></td>
                                                    <td style="vertical-align:middle;text-align: center;"><?php echo TABLE_TEXT_MAX_COUNT; ?></td>
                                                    <td style="vertical-align:middle;text-align: center;"><?php echo osc_draw_input_field('products_attributes_maxcount', $products_attributes_maxcount, 'size="5"'); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } elseif (($action == 'delete_product_attribute') && ($_GET['attribute_id'] == $attributes_values['products_attributes_id'])) {
                                ?>
                                <tr class="warning">
                                    <td style="vertical-align:middle;text-align: center;"><strong><?php echo $attributes_values["products_attributes_id"]; ?></strong></td>
                                    <td style="vertical-align:middle;text-align: center;"><strong><?php echo $products_name_only; ?></strong></td>
                                    <td style="vertical-align:middle;text-align: center;"><strong><?php echo $options_name; ?></strong></td>
                                    <td style="vertical-align:middle;text-align: center;"><strong><?php echo $values_name; ?></strong></td>
                                    <td style="vertical-align:middle;text-align: center;"><strong><?php echo $attributes_values["options_values_price"]; ?></strong></td>
                                    <td style="vertical-align:middle;text-align: center;"><strong><?php echo $attributes_values["price_prefix"]; ?></strong></td>
                                    <td style="vertical-align:middle;text-align: center;"><div class="btn-group"><a class="btn btn-small btn-danger" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=delete_attribute&attribute_id=' . $_GET['attribute_id'] . '&' . $page_info); ?>"><i class="icon-trash icon-white"></i> <?php echo IMAGE_DELETE; ?></a><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a></div></td>
                                </tr>
                                <?php
                            } else {
                                ?>
                                <tr>
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $attributes_values["products_attributes_id"]; ?></td>
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $products_name_only; ?></td>
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $options_name; ?></td>
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $values_name; ?></td>
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $attributes_values["options_values_price"]; ?></td>
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $attributes_values["price_prefix"]; ?></td>
                                    <td style="vertical-align:middle;text-align: center;"><div class="btn-group"><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=update_attribute&attribute_id=' . $attributes_values['products_attributes_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-edit"></i> <?php echo IMAGE_EDIT; ?></a><a class="btn btn-small btn-danger" href="<?php echo osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, 'action=delete_product_attribute&attribute_id=' . $attributes_values['products_attributes_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-trash icon-white"></i> <?php echo IMAGE_DELETE; ?></a></div></td>
                                </tr>
                                <?php
                            }
                            $max_attributes_id_query = osc_db_query("select max(products_attributes_id) + 1 as next_id from " . TABLE_PRODUCTS_ATTRIBUTES);
                            $max_attributes_id_values = osc_db_fetch_array($max_attributes_id_query);
                            $next_id = $max_attributes_id_values['next_id'];
                        }
                        if ($action != 'update_attribute' && $action != 'delete_product_attribute') {
                            ?>
                            <tr class="success">
                                <td style="vertical-align:middle;text-align: center;"><?php echo $next_id; ?></td>
                                <td style="vertical-align:middle;text-align: center;"><select name="products_id">
                                        <?php
                                        $products = osc_db_query("select p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "' order by pd.products_name");
                                        while ($products_values = osc_db_fetch_array($products)) {
                                            echo '<option value="' . $products_values['products_id'] . '">' . $products_values['products_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td style="vertical-align:middle;text-align: center;"><select name="options_id">
                                        <?php
                                        $options = osc_db_query("select * from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . $_SESSION['languages_id'] . "' order by products_options_name");
                                        while ($options_values = osc_db_fetch_array($options)) {
                                            echo '<option value="' . $options_values['products_options_id'] . '">' . $options_values['products_options_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td style="vertical-align:middle;text-align: center;"><select name="values_id">
                                        <?php
                                        $values = osc_db_query("select * from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where language_id = '" . $_SESSION['languages_id'] . "' order by products_options_values_name");
                                        while ($values_values = osc_db_fetch_array($values)) {
                                            echo '<option value="' . $values_values['products_options_values_id'] . '">' . $values_values['products_options_values_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td style="vertical-align:middle;text-align: center;"><input type="text" name="value_price" class="input-block-level"></td>
                                <td style="vertical-align:middle;text-align: center;"><input type="text" name="price_prefix" class="input-block-level" value="+"></td>
                                <td style="vertical-align:middle;text-align: center;"><button class="btn btn-small btn-success" type="submit"><i class="icon-plus icon-white"></i> <?php echo IMAGE_INSERT; ?></button></td>
                            </tr>
                                    <tr class="well">
                                        <td colspan="7">
                                            <span class="pull-left text-info"><strong><?php echo NUMBER_OF_ROW_TO_DISPLAY; ?></strong>
                                                <span class="btn-group" data-toggle-name="row_number" data-toggle="buttons-radio">                                                
                                                    <?php                                                     
                                                    for($z=1; $z <= ceil($attribute_count/$step_row); $z++) {                                                         
                                                        echo '<a class="btn btn-info" data-toggle="button" href="' . osc_href_link(FILENAME_TWIG_PRODUCTS_ATTRIBUTES, $page_row . '&row_number=' . $z*$step_row) . '">' . $z*$step_row . '</a>';
                                                    }?>
                                                </span>
                                            </span>
                                            <input type="hidden" name="row_number" value="<?php echo $row_number; ?>">
                                        </td>
                                   </tr>                              
                            <?php
                            if (DOWNLOAD_ENABLED == 'true') {
                                $products_attributes_maxdays = DOWNLOAD_MAX_DAYS;
                                $products_attributes_maxcount = DOWNLOAD_MAX_COUNT;
                                ?>
                                <tr>
                                    <td>
                                        <table class="table table-condensed table-bordered table-striped table-hover row-fluid">
                                            <tr>
                                                <td style="vertical-align:middle;text-align: center;"><?php echo TABLE_HEADING_DOWNLOAD; ?></td>
                                                <td style="vertical-align:middle;text-align: center;"><?php echo TABLE_TEXT_FILENAME; ?></td>
                                                <td style="vertical-align:middle;text-align: center;"><?php echo osc_draw_input_field('products_attributes_filename', $products_attributes_filename, 'size="15"'); ?></td>
                                                <td style="vertical-align:middle;text-align: center;"><?php echo TABLE_TEXT_MAX_DAYS; ?></td>
                                                <td style="vertical-align:middle;text-align: center;"><?php echo osc_draw_input_field('products_attributes_maxdays', $products_attributes_maxdays, 'size="5"'); ?></td>
                                                <td style="vertical-align:middle;text-align: center;"><?php echo TABLE_TEXT_MAX_COUNT; ?></td>
                                                <td style="vertical-align:middle;text-align: center;"><?php echo osc_draw_input_field('products_attributes_maxcount', $products_attributes_maxcount, 'size="5"'); ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <?php
                            } // end of DOWNLOAD_ENABLED section
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>  
</div>
</div>
<script>
$(".collapse").collapse().each(function(){
var state; var block = this.id;
    function isStored(){ state = localStorage.getItem('#'+block); return state; };
        if( isStored(this.id)) {
            if(state === 'in collapse') { $( this ).collapse( 'show' ); $('.'+block).removeClass('hide'); }
            if(state === 'collapse') { $( this ).collapse( 'hide' ); }
        }else{
            $( this ).collapse(); $('.'+block).removeClass('hide');
        }
    });
$('.accordion-heading > a').click(function(){
var block = jQuery(this).attr('href');  var state = jQuery(block).attr('class').substring(25);
    if (state === 'in collapse') { localStorage.setItem(block,'collapse'); $('.'+block.substring(1)).addClass('hide');
        }else{ localStorage.setItem(block,'in collapse'); $('.'+block.substring(1)).removeClass('hide'); }        
     });   
$(function() {
$('div.btn-group[data-toggle-name]').each(function() {
var group = $(this);var form = group.parents('form').eq(0);var name = group.attr('data-toggle-name');var hidden = $('input[name="' + name + '"]', form);
$('button', group).each(function() {  var button = $(this); button.on('click', function() { hidden.val($(this).val()); });
if (button.val() === hidden.val()) { button.addClass('active'); } }); });});
$(function() { 
$('span.btn-group[data-toggle-name]').each(function() { var group = $(this); var form = group.parents('form').eq(0); var name = group.attr('data-toggle-name'); var hidden = $('input[name="' + name + '"]',form);    
$('a', group).each(function() { var link = $(this); link.on('click', function() { hidden.val($(this).val()); });    
if (link.text() === hidden.val()) { link.addClass('active'); } }); }); });
</script>                            
<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
?>