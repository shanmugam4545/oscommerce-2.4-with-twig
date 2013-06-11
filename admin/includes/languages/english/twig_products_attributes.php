<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE_OPT', 'Product Options');
define('HEADING_TITLE_VAL', 'Option Values');
define('HEADING_TITLE_ATRIB', 'Products Attributes');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_PRODUCT', 'Product Name');
define('TABLE_HEADING_OPT_NAME', 'Option Name');
define('TABLE_HEADING_OPT_VALUE', 'Option Value');
define('TABLE_HEADING_OPT_PRICE', 'Value Price');
define('TABLE_HEADING_OPT_PRICE_PREFIX', 'Prefix');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_DOWNLOAD', 'Downloadable products:');
define('TABLE_TEXT_FILENAME', 'Filename:');
define('TABLE_TEXT_MAX_DAYS', 'Expiry days:');
define('TABLE_TEXT_MAX_COUNT', 'Maximum download count:');

define('MAX_ROW_LISTS_OPTIONS', 10);

define('TEXT_WARNING_OF_DELETE', 'This option has products and values linked to it - it is not safe to delete it.');
define('TEXT_OK_TO_DELETE', 'This option has no products and values linked to it - it is safe to delete it.');
define('TEXT_OPTION_ID', 'Option ID');
define('TEXT_OPTION_NAME', 'Option Name');

/* Twig */
define('TABLE_HEADING_OPT_REQUIRED', 'Required');
define('TABLE_HEADING_OPT_TEMPLATE', 'Template');
define('TABLE_HEADING_OPT_IMAGE', 'Image');
definhe('TABLE_HEADING_OPT_VALUE_DESCRIPTION', 'Value Description');
define('BOX_CATALOG_CATEGORIES_TWIG_PRODUCTS_ATTRIBUTES', 'Twig Products Attributes');
define('NUMBER_OF_ROW_TO_DISPLAY', 'Numbers of row to display :');

/* messagestack */
define('INSERT_OPTION_NAME_SUCCESS', 'Option product with %s id\' has been added successfully');
define('UPDATE_OPTION_NAME_SUCCESS', 'Option product with %s id\' has been changed successfully');
define('DELETE_OPTION_NAME_SUCCESS', 'Option product with %s id\' has been deleted successfully');

define('INSERT_OPTION_VALUE_SUCCESS', 'Option with %s id\' has been added successfully');
define('UPDATE_OPTION_VALUE_SUCCESS', 'Option with %s id\' has been changed successfully');
define('DELETE_OPTION_VALUE_SUCCESS', 'Option with %s id\' has been deleted successfully');

define('INSERT_PRODUCT_ATTRIBUTE_SUCCESS', 'Product attribute with %s id\' has been added successfully');
define('UPDATE_PRODUCT_ATTRIBUTE_SUCCESS', 'Product attribute with %s id\' has been changed successfully');
define('DELETE_PRODUCT_ATTRIBUTE_SUCCESS', 'Product attribute with %s id\' has been deleted successfully');

define('ERROR_CATALOG_IMAGE_DIRECTORY_OPTIONS_IMAGES_NOT_WRITEABLE', 'Error: options_images directory is not writeable: ' . DIR_FS_CATALOG_IMAGES . 'options_images');
define('ERROR_CATALOG_IMAGE_DIRECTORY_OPTIONS_IMAGES_DOES_NOT_EXIST', 'Error: options_images directory does not exist: ' . DIR_FS_CATALOG_IMAGES . 'options_images');

define('ERROR_CATALOG_IMAGE_DIRECTORY_VALUES_IMAGES_NOT_WRITEABLE', 'Error: values_images directory is not writeable: ' . DIR_FS_CATALOG_IMAGES . 'values_images');
define('ERROR_CATALOG_IMAGE_DIRECTORY_VALUES_IMAGES_DOES_NOT_EXIST', 'Error: values_images directory does not exist: ' . DIR_FS_CATALOG_IMAGES . 'values_images');
?>