<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Catégories / Produits');
define('HEADING_TITLE_SEARCH', 'Rechercher :');
define('HEADING_TITLE_GOTO', 'Aller à :');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Catégories / Produits');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_STATUS', 'Statut');

define('TEXT_NEW_PRODUCT', 'Nouveau Produit dans &quot;%s&quot;');
define('TEXT_CATEGORIES', 'Catégories :');
define('TEXT_SUBCATEGORIES', 'Sous-catégories :');
define('TEXT_PRODUCTS', 'Produits :');
define('TEXT_PRODUCTS_PRICE_INFO', 'Prix :');
define('TEXT_PRODUCTS_TAX_CLASS', 'Classe Fiscale :');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'Ratio moyen :');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Quantité :');
define('TEXT_DATE_ADDED', 'Date d\'ajout :');
define('TEXT_DATE_AVAILABLE', 'Date disponibilité :');
define('TEXT_LAST_MODIFIED', 'Dernière modification :');
define('TEXT_IMAGE_NONEXISTENT', 'L\'IMAGE N\'EXISTE PAS');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Veuillez créer une nouvelle catégorie ou un produit dans ce niveau.');
define('TEXT_PRODUCT_MORE_INFORMATION', 'Pour plus d\'information, merci de visiter cette <a href="http://%s" target="blank"><u>page web</u></a> de produits.');
define('TEXT_PRODUCT_DATE_ADDED', 'Ce produit a été ajouté à notre catalogue le %s.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'Ce produit sera en stock le %s.');

define('TEXT_EDIT_INTRO', 'Merci de faire les changements nécessaires');
define('TEXT_EDIT_CATEGORIES_ID', 'ID de la catégorie :');
define('TEXT_EDIT_CATEGORIES_NAME', 'Nom de la catégorie :');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Image de la catégorie :');
define('TEXT_EDIT_SORT_ORDER', 'Ordre de tri :');

define('TEXT_INFO_COPY_TO_INTRO', 'Veuillez choisir une nouvelle catégorie dans laquelle vous voulez copier ce produit');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Catégories courantes :');

define('TEXT_INFO_HEADING_NEW_CATEGORY', 'Nouvelle la catégorie');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Modifier la catégorie');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Supprimer la catégorie');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Déplacer la catégorie');
define('TEXT_INFO_HEADING_DELETE_PRODUCT', 'Supprimer le produit');
define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Déplacer le produit');
define('TEXT_INFO_HEADING_COPY_TO', 'Copier vers');

define('TEXT_DELETE_CATEGORY_INTRO', 'Confirmez la suppression de cette catégorie');
define('TEXT_DELETE_PRODUCT_INTRO', 'Confirmez la suppression de définitivement ce produit');

define('TEXT_DELETE_WARNING_CHILDS', '<b>ATTENTION :</b> Il y a %s (sous-)catégories liées à cette catégorie !');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>ATTENTION :</b> Il y a %s produits liées à cette catégorie !');

define('TEXT_MOVE_PRODUCTS_INTRO', 'Veuillez sélectionner la catégorie ou vous voudriez que <b>%s</b> soit placé');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Veuillez sélectionner la catégorie ou vous voudriez que <b>%s</b> soit placé');
define('TEXT_MOVE', 'Déplacer <b>%s</b> vers :');

define('TEXT_NEW_CATEGORY_INTRO', 'Veuillez compléter les informations suivantes pour la nouvelle catégorie');
define('TEXT_CATEGORIES_NAME', 'Nom de la catégorie :');
define('TEXT_CATEGORIES_IMAGE', 'Image de la catégorie :');
define('TEXT_SORT_ORDER', 'Ordre de tri :');

define('TEXT_PRODUCTS_STATUS', 'Statut des produits :');
define('TEXT_PRODUCTS_DATE_AVAILABLE', 'Date de disponibilité :');
define('TEXT_PRODUCT_AVAILABLE', 'En stock');
define('TEXT_PRODUCT_NOT_AVAILABLE', 'Hors stock');
define('TEXT_PRODUCTS_MANUFACTURER', 'Fabricant du produit :');
define('TEXT_PRODUCTS_NAME', 'Nom du produit :');
define('TEXT_PRODUCTS_DESCRIPTION', 'Description du produit :');
define('TEXT_PRODUCTS_QUANTITY', 'Quantité de produit :');
define('TEXT_PRODUCTS_MODEL', 'Modèle du produit :');
define('TEXT_PRODUCTS_IMAGE', 'Image du produit :');
define('TEXT_PRODUCTS_MAIN_IMAGE', 'Image principale');
define('TEXT_PRODUCTS_LARGE_IMAGE', 'Image large');
define('TEXT_PRODUCTS_LARGE_IMAGE_HTML_CONTENT', 'Contenu HTML (pour le popup)');
define('TEXT_PRODUCTS_ADD_LARGE_IMAGE', 'Ajouter image large');
define('TEXT_PRODUCTS_LARGE_IMAGE_DELETE_TITLE', 'Supprimer image large du produit?');
define('TEXT_PRODUCTS_LARGE_IMAGE_CONFIRM_DELETE', 'Veuillez confirmer la suppression de l\'image large du produit.');
define('TEXT_PRODUCTS_URL', 'URL du produit :');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '<small>(sans http://)</small>');
define('TEXT_PRODUCTS_PRICE_NET', 'Prix du produit (HT) :');
define('TEXT_PRODUCTS_PRICE_GROSS', 'Prix du produit (TTC) :');
define('TEXT_PRODUCTS_WEIGHT', 'Poids du produit :');

define('EMPTY_CATEGORY', 'Catégorie vide');

define('TEXT_HOW_TO_COPY', 'Méthode de copie :');
define('TEXT_COPY_AS_LINK', 'Lien produit');
define('TEXT_COPY_AS_DUPLICATE', 'Dupliquer produit');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Erreur : Impossible de lier des produits dans la même catégorie.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Erreur : Impossible d\'écrire dans le répertoire images : ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Erreur : Le répertoire d\'images n\'existe pas : ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CANNOT_MOVE_CATEGORY_TO_PARENT', 'Erreur : La catégorie ne peut pas être déplacée dans la sous-catégorie.');
?>
