<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE_OPT', 'Options produits');
define('HEADING_TITLE_VAL', 'Valeurs Options');
define('HEADING_TITLE_ATRIB', 'Attributs produits');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_PRODUCT', 'Nom Produit');
define('TABLE_HEADING_OPT_NAME', 'Nom Option');
define('TABLE_HEADING_OPT_VALUE', 'Valeur Option');
define('TABLE_HEADING_OPT_PRICE', 'Prix option');
define('TABLE_HEADING_OPT_PRICE_PREFIX', 'Prefixe');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_DOWNLOAD', 'Produits téléchargeables:');
define('TABLE_TEXT_FILENAME', 'Nom du fichier:');
define('TABLE_TEXT_MAX_DAYS', 'Jours de validité:');
define('TABLE_TEXT_MAX_COUNT', 'Nombre maximum de téléchargements:');

define('MAX_ROW_LISTS_OPTIONS', 10);

define('TEXT_WARNING_OF_DELETE', 'Cette option possède des produits liés - il n\'est pas possible de la supprimer.');
define('TEXT_OK_TO_DELETE', 'Cette option n\'a pas de produit lié, vous pouvez la supprimer.');
define('TEXT_OPTION_ID', 'ID Option');
define('TEXT_OPTION_NAME', 'Nom de l\'option');

/* Twig */
define('TWIG_PRODUCTS_ATTRIBUTES_TITLE', 'Twig Attributs produits');
define('TABLE_HEADING_OPT_REQUIRED', 'Obligatoire');
define('TABLE_HEADING_OPT_TEMPLATE', 'Template');
define('TABLE_HEADING_OPT_IMAGE', 'Image');
define('TABLE_HEADING_OPT_VALUE_DESCRIPTION', 'Description');
define('NUMBER_OF_ROW_TO_DISPLAY', 'Nombres de lignes affichées :');

/* messagestack */
define('INSERT_OPTION_NAME_SUCCESS', 'L\'ajout de l\'option produit N° %s a été effectuée avec succès');
define('UPDATE_OPTION_NAME_SUCCESS', 'La modification de l\'option produit N° %s a été effectuée avec succès');
define('DELETE_OPTION_NAME_SUCCESS', 'La suppression de l\'option produit N° %s a été effectuée avec succès');

define('INSERT_OPTION_VALUE_SUCCESS', 'L\'ajout de l\'option N° %s a été effectuée avec succès');
define('UPDATE_OPTION_VALUE_SUCCESS', 'La modification de l\'option N° %s a été effectuée avec succès');
define('DELETE_OPTION_VALUE_SUCCESS', 'La suppression de l\'option N° %s a été effectuée avec succès');

define('INSERT_PRODUCT_ATTRIBUTE_SUCCESS', 'L\'ajout de l\'attribut produit N° %s a été effectuée avec succès');
define('UPDATE_PRODUCT_ATTRIBUTE_SUCCESS', 'La modification de l\'attribut produit N° %s a été effectuée avec succès');
define('DELETE_PRODUCT_ATTRIBUTE_SUCCESS', 'La suppression de l\'attribut produit N° %s a été effectuée avec succès');

define('ERROR_CATALOG_IMAGE_DIRECTORY_OPTIONS_IMAGES_NOT_WRITEABLE', 'Erreur : Impossible d\'écrire dans le répertoire images : ' . DIR_FS_CATALOG_IMAGES . 'options_images');
define('ERROR_CATALOG_IMAGE_DIRECTORY_OPTIONS_IMAGES_DOES_NOT_EXIST', 'Erreur : Le répertoire options_images n\'existe pas : ' . DIR_FS_CATALOG_IMAGES . 'options_images');

define('ERROR_CATALOG_IMAGE_DIRECTORY_VALUES_IMAGES_NOT_WRITEABLE', 'Erreur : Impossible d\'écrire dans le répertoire images : ' . DIR_FS_CATALOG_IMAGES . 'values_images');
define('ERROR_CATALOG_IMAGE_DIRECTORY_VALUES_IMAGES_DOES_NOT_EXIST', 'Erreur : Le répertoire values_images n\'existe pas : ' . DIR_FS_CATALOG_IMAGES . 'values_images');
?>