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

$action = (isset($_GET['action']) ? $_GET['action'] : '');

$option_page = (isset($_GET['option_page']) && is_numeric($_GET['option_page'])) ? $_GET['option_page'] : 1;

$value_page = (isset($_GET['value_page']) && is_numeric($_GET['value_page'])) ? $_GET['value_page'] : 1;

$attribute_page = (isset($_GET['attribute_page']) && is_numeric($_GET['attribute_page'])) ? $_GET['attribute_page'] : 1;

$page_info = 'option_page=' . $option_page . '&value_page=' . $value_page . '&attribute_page=' . $attribute_page;

if (osc_not_null($action)) {
    switch ($action) {
        case 'add_product_options':
            $products_options_id = osc_db_prepare_input($_POST['products_options_id']);           
            $option_name_array = $_POST['option_name'];
            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                $option_name = osc_db_prepare_input($option_name_array[$languages[$i]['id']]);
                osc_db_query("insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id, products_options_name, language_id) values ('" . (int) $products_options_id . "', '" . osc_db_input($option_name) . "', '" . (int) $languages[$i]['id'] . "')");
            }
            osc_redirect(osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'add_product_option_values':
            $value_name_array = $_POST['value_name'];
            $value_id = osc_db_prepare_input($_POST['value_id']);
            $option_id = osc_db_prepare_input($_POST['option_id']);
            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                $value_name = osc_db_prepare_input($value_name_array[$languages[$i]['id']]);
                osc_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . (int) $value_id . "', '" . (int) $languages[$i]['id'] . "', '" . osc_db_input($value_name) . "')");
            }
            osc_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " (products_options_id, products_options_values_id) values ('" . (int) $option_id . "', '" . (int) $value_id . "')");
            osc_redirect(osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
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
            osc_redirect(osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'update_option_name':
            $option_name_array = $_POST['option_name'];
            $option_id = osc_db_prepare_input($_POST['option_id']);           
            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                $option_name = osc_db_prepare_input($option_name_array[$languages[$i]['id']]);
                osc_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_name = '" . osc_db_input($option_name) . "' where products_options_id = '" . (int) $option_id . "' and language_id = '" . (int) $languages[$i]['id'] . "'");
            }
            osc_redirect(osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'update_value':
            $value_name_array = $_POST['value_name'];
            $value_id = osc_db_prepare_input($_POST['value_id']);
            $option_id = osc_db_prepare_input($_POST['option_id']);
            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                $value_name = osc_db_prepare_input($value_name_array[$languages[$i]['id']]);
                osc_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_name = '" . osc_db_input($value_name) . "' where products_options_values_id = '" . osc_db_input($value_id) . "' and language_id = '" . (int) $languages[$i]['id'] . "'");
            }
            osc_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " set products_options_id = '" . (int) $option_id . "'  where products_options_values_id = '" . (int) $value_id . "'");
            osc_redirect(osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
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
            osc_redirect(osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'delete_option':
            $option_id = osc_db_prepare_input($_GET['option_id']);
            osc_db_query("delete from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int) $option_id . "'");
            osc_redirect(osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'delete_value':
            $value_id = osc_db_prepare_input($_GET['value_id']);
            osc_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int) $value_id . "'");
            osc_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int) $value_id . "'");
            osc_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_values_id = '" . (int) $value_id . "'");
            osc_redirect(osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
            break;
        case 'delete_attribute':
            $attribute_id = osc_db_prepare_input($_GET['attribute_id']);
            osc_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_attributes_id = '" . (int) $attribute_id . "'");
// added for DOWNLOAD_ENABLED. Always try to remove attributes, even if downloads are no longer enabled
            osc_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id = '" . (int) $attribute_id . "'");
            osc_redirect(osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
            break;
    }
}
$max_options_id_query = osc_db_query("select max(products_options_id) + 1 as next_id from " . TABLE_PRODUCTS_OPTIONS);
$max_options_id_values = osc_db_fetch_array($max_options_id_query);
$next_id_option = $max_options_id_values['next_id'];

require(DIR_WS_INCLUDES . 'template_top.php');
?>
<div class="accordion" id="products_attributes_accordion">
<!-- options and values//-->
<!-- options //-->
<?php
if ($action == 'delete_product_option') { // delete product option
    $options = osc_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int) $_GET['option_id'] . "' and language_id = '" . (int) $_SESSION['languages_id'] . "'");
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
    if (osc_db_num_rows($products)) {
    ?>
    <table class="table table-condensed table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="text-align:center;"><?php echo TABLE_HEADING_ID; ?></th>
                        <th style="text-align:center;"><?php echo TABLE_HEADING_PRODUCT; ?></th>
                        <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_VALUE; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rows = 0;
                    while ($products_values = osc_db_fetch_array($products)) {
                        $rows++;
                        ?>
                        <tr>
                            <td style="vertical-align:middle;text-align: center;"><?php echo $products_values['products_id']; ?>
                            <td style="vertical-align:middle;text-align: center;"><?php echo $products_values['products_name']; ?>
                            <td style="vertical-align:middle;text-align: center;"><?php echo $products_values['products_options_values_name']; ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        <div class="text-error"><strong><?php echo TEXT_WARNING_OF_DELETE; ?></strong>
        <a class="btn btn-small pull-right" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a>
        </div>
    <?php } else { ?>
        <div class="text-error"><strong><?php echo TEXT_OK_TO_DELETE; ?></strong>
        <span class="pull-right btn-group"><a class="btn btn-small btn-danger" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_option&option_id=' . $_GET['option_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-trash icon-white"></i> <?php echo IMAGE_DELETE; ?></a><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a></span>
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
                $options = "select * from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . (int) $_SESSION['languages_id'] . "' order by products_options_id";
                $options_split = new splitPageResults($option_page, MAX_ROW_LISTS_OPTIONS, $options, $options_query_numrows);
                echo $options_split->display_pagination($options_query_numrows, MAX_ROW_LISTS_OPTIONS, MAX_DISPLAY_PAGE_LINKS, $option_page, 'value_page=' . $value_page . '&attribute_page=' . $attribute_page, 'option_page');
                ?>
            </div>
            <div id="blockoptions" class="accordion-body row-fluid collapse">
                <div class="accordion-inner">
                    <?php
                    if (($action == 'update_option') && $_GET['option_id']) {
                        echo '<form name="option" action="' . osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_option_name&' . $page_info, 'NONSSL') . '" method="post">';
                    } else {
                        echo '<form name="options" action="' . osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=add_product_options&' . $page_info, 'NONSSL') . '" method="post"><input type="hidden" name="products_options_id" value="' . $next_id_option . '">';
                    }
                    ?>

                    <table class="table table-condensed table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_ID; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_NAME; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_ACTION; ?></th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php
                                $next_id = 1;
                                $rows = 0;
                                $options = osc_db_query($options);
                                while ($options_values = osc_db_fetch_array($options)) {
                                    $rows++;
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
                                            <td style="vertical-align:middle;text-align: center;"><div class="btn-group" style="margin-top:-15px"><button class="btn btn-small btn-primary" type="submit"><i class="icon-check icon-white"></i> <?php echo IMAGE_SAVE; ?></button><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a></div></td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $options_values["products_options_id"]; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $options_values["products_options_name"]; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><div class="btn-group"><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_option&option_id=' . $options_values['products_options_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-edit"></i> <?php echo IMAGE_EDIT; ?></a><a class="btn btn-danger btn-small" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_product_option&option_id=' . $options_values['products_options_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-trash icon-white"></i> <?php echo IMAGE_DELETE; ?></a></div></td>
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
                                        <td style="vertical-align:middle;text-align: center;"><button type="submit" class="btn btn-small btn-success" style="margin-top:-15px"><i class="icon-plus icon-white"></i> <?php echo IMAGE_INSERT; ?></button></td>
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
    $values = osc_db_query("select products_options_values_id, products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int) $_GET['value_id'] . "' and language_id = '" . (int) $_SESSION['languages_id'] . "'");
    $values_values = osc_db_fetch_array($values);
    ?>
    <?php
    $products = osc_db_query("select p.products_id, pd.products_name, po.products_options_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS . " po, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . (int) $_SESSION['languages_id'] . "' and po.language_id = '" . (int) $_SESSION['languages_id'] . "' and pa.products_id = p.products_id and pa.options_values_id='" . (int) $_GET['value_id'] . "' and po.products_options_id = pa.options_id order by pd.products_name");
    if (osc_db_num_rows($products)) {
        ?>
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#products_attributes_accordion" href="#blockoptionsvalues">
                    <h3 class="text-info pull-left"><?php echo HEADING_TITLE_VAL; ?></h3></a>
            </div>
            <div id="blockoptionsvalues" class="accordion-body row-fluid collapse">
                <div class="accordion-inner">
                    <h4 class="text-warning"><?php echo TABLE_HEADING_OPT_VALUE; ?> : <?php echo $values_values['products_options_values_name']; ?></h4> 
                    <table class="table table-condensed table-bordered table-striped table-hover">
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
                                $rows++;
                                ?>
                                <tr>
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $products_values['products_id']; ?></td>
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $products_values['products_name']; ?></td>
                                    <td style="vertical-align:middle;text-align: center;"><?php echo $products_values['products_options_name']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="text-error"><strong><?php echo TEXT_WARNING_OF_DELETE; ?></strong>
                        <a class="btn pull-right" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a>
                    </div>
                <?php } else { ?>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#products_attributes_accordion" href="#blockoptionsvalues">
                                <h3 class="text-info pull-left"><?php echo HEADING_TITLE_VAL; ?></h3></a>
                        </div>
                        <div id="blockoptionsvalues" class="accordion-body row-fluid collapse">
                            <div class="text-error"><p class="text-center"><strong><?php echo TEXT_OK_TO_DELETE; ?></strong></p>
                                <div class="btn-group pull-right"><a class="btn btn-small btn-danger" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_value&value_id=' . $_GET['value_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-trash icon-white"></i> <?php echo IMAGE_DELETE; ?></a><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a></div>
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
                    $values = "select pov.products_options_values_id, pov.products_options_values_name, pov2po.products_options_id from " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov left join " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " pov2po on pov.products_options_values_id = pov2po.products_options_values_id where pov.language_id = '" . (int) $_SESSION['languages_id'] . "' order by pov.products_options_values_id";
                    $values_split = new splitPageResults($value_page, MAX_ROW_LISTS_OPTIONS, $values, $values_query_numrows);
                    echo $values_split->display_pagination($values_query_numrows, MAX_ROW_LISTS_OPTIONS, MAX_DISPLAY_PAGE_LINKS, $value_page, 'option_page=' . $option_page . '&attribute_page=' . $attribute_page, 'value_page');
                    ?>
                </div>
                <div id="blockoptionsvalues" class="accordion-body row-fluid collapse">
                    <div class="accordion-inner">
                        <?php
                        if (($action == 'update_option_value') && ($_GET['value_id'])) {
                            echo '<form name="values" action="' . osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_value&' . $page_info, 'NONSSL') . '" method="post">';
                        } else {
                            echo '<form name="values" action="' . osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=add_product_option_values&' . $page_info, 'NONSSL') . '" method="post">';
                        }
                        ?>
                        <table class="table table-condensed table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_ID; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_NAME; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_OPT_VALUE; ?></th>
                                    <th style="text-align:center;"><?php echo TABLE_HEADING_ACTION; ?></th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php
                                $max_values_id_query = osc_db_query("select max(products_options_values_id) + 1 as next_id from " . TABLE_PRODUCTS_OPTIONS_VALUES);
                                $max_values_id_values = osc_db_fetch_array($max_values_id_query);
                                $option_value_next_id = $max_values_id_values['next_id'];
                                $next_id = 1;
                                $rows = 0;
                                $values = osc_db_query($values);
                                while ($values_values = osc_db_fetch_array($values)) {
                                    $options_name = osc_options_name($values_values['products_options_id']);
                                    $values_name = $values_values['products_options_values_name'];
                                    $rows++;
                                    ?>
                                    <?php
                                    if (($action == 'update_option_value') && ($_GET['value_id'] == $values_values['products_options_values_id'])) {
                                        $inputs = '';
                                        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                            $value_name = osc_db_query("select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int) $values_values['products_options_values_id'] . "' and language_id = '" . (int) $languages[$i]['id'] . "'");
                                            $value_name = osc_db_fetch_array($value_name);
                                            $inputs .= '<div class="input-prepend" style="margin-top:5px;"><span class="add-on"><img alt="' . $languages[$i]['name'] . '" src="' . DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'] . '"></span><input type="text" name="value_name[' . $languages[$i]['id'] . ']" value="' . $value_name['products_options_values_name'] . '"></div><br />';
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
                                            <td style="vertical-align:middle;text-align: center;"><div class="btn-group"><button class="btn btn-small btn-primary" type="submit"><i class="icon-check icon-white"></i> <?php echo IMAGE_SAVE; ?></button><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a></div></td>
                                        </tr>
        <?php } else { ?>
                                        <tr>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $values_values["products_options_values_id"]; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $options_name; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><?php echo $values_name; ?></td>
                                            <td style="vertical-align:middle;text-align: center;"><div class="btn-group"><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_option_value&value_id=' . $values_values['products_options_values_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-edit"></i> <?php echo IMAGE_EDIT; ?></a><a class="btn btn-small btn-danger" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_option_value&value_id=' . $values_values['products_options_values_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-trash icon-white"></i> <?php echo IMAGE_DELETE; ?></a></div></td>
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
                                                }
                                                $inputs = '';
                                                for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                                    $inputs .= '<div class="input-prepend" style="margin-top:5px;"><span class="add-on"><img alt="' . $languages[$i]['name'] . '" src="' . DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'] . '"></span><input type="text" name="value_name[' . $languages[$i]['id'] . ']"></div><br />';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align:middle;text-align: center;"><input type="hidden" name="value_id" value="<?php echo $next_id; ?>"><?php echo $inputs; ?></td>
                                        <td style="vertical-align:middle;text-align: center;"><button type="submit" class="btn-small btn-success"><i class="icon-plus icon-white"></i> <?php echo IMAGE_INSERT; ?></button></td>
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
        $attributes = "select pa.* from " . TABLE_PRODUCTS_ATTRIBUTES . " pa left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on pa.products_id = pd.products_id and pd.language_id = '" . (int) $_SESSION['languages_id'] . "' order by pd.products_name";
        $attributes_split = new splitPageResults($attribute_page, MAX_ROW_LISTS_OPTIONS, $attributes, $attributes_query_numrows);
        echo $attributes_split->display_pagination($attributes_query_numrows, MAX_ROW_LISTS_OPTIONS, MAX_DISPLAY_PAGE_LINKS, $attribute_page, 'option_page=' . $option_page . '&value_page=' . $value_page, 'attribute_page');
        ?>
    </div>    
    <div id="blockproductsattributes" class="accordion-body row-fluid collapse">
        <div class="accordion-inner">
            <form name="attributes" action="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=' . $form_action . '&' . $page_info); ?>" method="post">
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
                            $rows++;
                            ?>
                            <?php
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
                                    <td style="vertical-align:middle;text-align: center;"><div class="btn-group"><button class="btn btn-small btn-primary"><i class="icon-check icon-white"></i> <?php echo IMAGE_SAVE; ?></button><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a></div></td>
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
                                <tr class="error">
                                    <td style="vertical-align:middle;text-align: center;"><strong><?php echo $attributes_values["products_attributes_id"]; ?></strong></td>
                                    <td style="vertical-align:middle;text-align: center;"><strong><?php echo $products_name_only; ?></strong></td>
                                    <td style="vertical-align:middle;text-align: center;"><strong><?php echo $options_name; ?></strong></td>
                                    <td style="vertical-align:middle;text-align: center;"><strong><?php echo $values_name; ?></strong></td>
                                    <td style="vertical-align:middle;text-align: center;"><strong><?php echo $attributes_values["options_values_price"]; ?></strong></td>
                                    <td style="vertical-align:middle;text-align: center;"><strong><?php echo $attributes_values["price_prefix"]; ?></strong></td>
                                    <td style="vertical-align:middle;text-align: center;"><div class="btn-group"><a class="btn btn-small btn-danger" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_attribute&attribute_id=' . $_GET['attribute_id'] . '&' . $page_info); ?>"><i class="icon-trash icon-white"></i> <?php echo IMAGE_DELETE; ?></a><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info, 'NONSSL'); ?>"><i class="icon-circle-arrow-left"></i> <?php echo IMAGE_CANCEL; ?></a></div></td>
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
                                    <td style="vertical-align:middle;text-align: center;"><div class="btn-group"><a class="btn btn-small" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_attribute&attribute_id=' . $attributes_values['products_attributes_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-edit"></i> <?php echo IMAGE_EDIT; ?></a><a class="btn btn-small btn-danger" href="<?php echo osc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_product_attribute&attribute_id=' . $attributes_values['products_attributes_id'] . '&' . $page_info, 'NONSSL'); ?>"><i class="icon-trash icon-white"></i> <?php echo IMAGE_DELETE; ?></a></div></td>
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
    var state;
    var block = this.id;
    function isStored(){        
        state = localStorage.getItem('#'+block);        
        return state;
    };
        if( isStored(this.id)) {
            if(state === 'in collapse') {
            $( this ).collapse( 'show' );
            $('.'+block).removeClass('hide');
            }
            if(state === 'collapse') {
            $( this ).collapse( 'hide' );            
            }
        }else{
            $( this ).collapse();
            $('.'+block).removeClass('hide');
        }
    });
    $('.accordion-heading > a').click(function(){
        var block = jQuery(this).attr('href');
        var state = jQuery(block).attr('class').substring(25);
        if (state === 'in collapse') {
        localStorage.setItem(block,'collapse');
        $('.'+block.substring(1)).addClass('hide');
        }else{
        localStorage.setItem(block,'in collapse'); 
        $('.'+block.substring(1)).removeClass('hide');
        }
        
     });
</script>                            
<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
?>