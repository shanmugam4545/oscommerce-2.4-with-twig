<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat6.0 I used 'en_US'
// on FreeBSD 4.0 I use 'en_US.ISO_8859-1'
// this may not work under win32 environments..
if (strtolower(substr(PHP_OS, 0, 3)) === 'win') {
  @setlocale(LC_TIME, 'fra');
}else{
  setlocale(LC_TIME, 'fr_FR.ISO_8859-1');
}
define('DATE_FORMAT_SHORT', '%d/%m/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd/m/Y'); // this is used for date()
define('PHP_DATE_TIME_FORMAT', 'd/m/Y H:i:s'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('JQUERY_DATEPICKER_I18N_CODE', 'fr'); // leave empty for en_US; see http://jqueryui.com/demos/datepicker/#localization
define('JQUERY_DATEPICKER_FORMAT', 'dd/mm/yy'); // see http://docs.jquery.com/UI/Datepicker/formatDate

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" lang="fr"');

// charset for web pages and emails
define('CHARSET', 'utf-8');

// page title
define('TITLE', STORE_NAME);

// header text in includes/header.php
define('HEADER_TITLE_TOP', 'Administration');
define('HEADER_TITLE_SUPPORT_SITE', 'Site officiel');
define('HEADER_TITLE_ONLINE_CATALOG', 'Catalogue en ligne');
define('HEADER_TITLE_ADMINISTRATION', 'Administration');

// text for gender
define('MALE', 'Homme');
define('FEMALE', 'Femme');

// text for date of birth example
define('DOB_FORMAT_STRING', 'jj/mm/aaaa');

// configuration box text in includes/boxes/configuration.php
define('BOX_HEADING_CONFIGURATION', 'Configuration');
define('BOX_CONFIGURATION_MYSTORE', 'Mon site marchand');
define('BOX_CONFIGURATION_LOGGING', 'Enregistrement');
define('BOX_CONFIGURATION_CACHE', 'Cache');
define('BOX_CONFIGURATION_ADMINISTRATORS', 'Administrateurs');
define('BOX_CONFIGURATION_STORE_LOGO', 'Logo de la boutique');

// modules box text in includes/boxes/modules.php
define('BOX_HEADING_MODULES', 'Modules');

// categories box text in includes/boxes/catalog.php
define('BOX_HEADING_CATALOG', 'Catalogue');
define('BOX_CATALOG_CATEGORIES_PRODUCTS', 'Catégories/Produits');
define('BOX_CATALOG_CATEGORIES_PRODUCTS_ATTRIBUTES', 'Attributs produits');
define('BOX_CATALOG_MANUFACTURERS', 'Fabricants');
define('BOX_CATALOG_REVIEWS', 'Avis des clients');
define('BOX_CATALOG_SPECIALS', 'Promotions');
define('BOX_CATALOG_PRODUCTS_EXPECTED', 'Produits en attente');

// customers box text in includes/boxes/customers.php
define('BOX_HEADING_CUSTOMERS', 'Clients/Commandes');
define('BOX_CUSTOMERS_CUSTOMERS', 'Clients');
define('BOX_CUSTOMERS_ORDERS', 'Commandes');

// taxes box text in includes/boxes/taxes.php
define('BOX_HEADING_LOCATION_AND_TAXES', 'Lieux / Taxes');
define('BOX_TAXES_COUNTRIES', 'Pays');
define('BOX_TAXES_ZONES', 'Zones');
define('BOX_TAXES_GEO_ZONES', 'Zones fiscales');
define('BOX_TAXES_TAX_CLASSES', 'Classes fiscales');
define('BOX_TAXES_TAX_RATES', 'Taux fiscaux');

// reports box text in includes/boxes/reports.php
define('BOX_HEADING_REPORTS', 'Rapports');
define('BOX_REPORTS_PRODUCTS_VIEWED', 'Produits les plus consultés');
define('BOX_REPORTS_PRODUCTS_PURCHASED', 'Produits achetés');
define('BOX_REPORTS_ORDERS_TOTAL', 'Total de commande clients');

// tools text in includes/boxes/tools.php
define('BOX_HEADING_TOOLS', 'Outils');
define('BOX_TOOLS_ACTION_RECORDER', 'Traceur Sécurité');
define('BOX_TOOLS_BACKUP', 'Sauvegarde de base de données');
define('BOX_TOOLS_BANNER_MANAGER', 'Gestionnaire de bannières');
define('BOX_TOOLS_CACHE', 'Contrôle du cache');
define('BOX_TOOLS_DEFINE_LANGUAGE', 'Définissez langues');
define('BOX_TOOLS_MAIL', 'Envoyez un courrier électronique');
define('BOX_TOOLS_NEWSLETTER_MANAGER', 'Gestionnaire de bulletin d\'information');
define('BOX_TOOLS_SEC_DIR_PERMISSIONS', 'Sécurité des répertoires');
define('BOX_TOOLS_SERVER_INFO', 'Renseignements sur serveur');
define('BOX_TOOLS_VERSION_CHECK', 'Vérificateur de version');
define('BOX_TOOLS_WHOS_ONLINE', 'Qui est en ligne');

// localizaion box text in includes/boxes/localization.php
define('BOX_HEADING_LOCALIZATION', 'Localisation');
define('BOX_LOCALIZATION_CURRENCIES', 'Devises');
define('BOX_LOCALIZATION_LANGUAGES', 'Langues');
define('BOX_LOCALIZATION_ORDERS_STATUS', 'Statut des commandes');

// javascript messages
define('JS_ERROR', 'Des erreurs sont survenues durant le traitement de votre formulaire !\nMerci de faire les corrections suivantes :\n\n');

define('JS_OPTIONS_VALUE_PRICE', '* Le nouvel attribut produit necessite un prix\n');
define('JS_OPTIONS_VALUE_PRICE_PREFIX', '* Le nouvel attribut produit necessite un préfixe de prix\n');

define('JS_PRODUCTS_NAME', '*  Le nouveau produit necessite un nom\n');
define('JS_PRODUCTS_DESCRIPTION', '* Le nouveau produit necessite une description\n');
define('JS_PRODUCTS_PRICE', '* Le nouveau produit necessite un prix\n');
define('JS_PRODUCTS_WEIGHT', '* Le nouveau produit necessite un poids\n');
define('JS_PRODUCTS_QUANTITY', '* Le nouveau produit necessite une quantité\n');
define('JS_PRODUCTS_MODEL', '* Le nouveau produit necessite un modèle\n');
define('JS_PRODUCTS_IMAGE', '* Le nouveau produit necessite une image\n');

define('JS_SPECIALS_PRODUCTS_PRICE', '* Un nouveau prix pour ce produit doit être fixé\n');

define('JS_GENDER', '* La valeur de \'Civilité\' doit être choisie.\n');
define('JS_FIRST_NAME', '* L\'entrée \'Prénom\' doit avoir au moins ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' caractères.\n');
define('JS_LAST_NAME', '* L\'entrée \'Nom\' doit avoir au moins ' . ENTRY_LAST_NAME_MIN_LENGTH . ' caractères.\n');
define('JS_DOB', '* L\'entrée \'Date de naissance\' doit avoir la forme: xx/xx/xxxx (21/05/1975).\n');
define('JS_EMAIL_ADDRESS', '* L\'entrée \'Adresse électronique\' doit avoir au moins ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' caractères.\n');
define('JS_ADDRESS', '* L\'entrée \'Adresse\' doit avoir au moins ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' caractères.\n');
define('JS_POST_CODE', '* L\'entrée \'Code postal\' doit avoir au moins ' . ENTRY_POSTCODE_MIN_LENGTH . ' caractères.\n');
define('JS_CITY', '* L\'entrée \'Ville\' doit avoir au moins ' . ENTRY_CITY_MIN_LENGTH . ' caractères.\n');
define('JS_STATE', '* L\'entrée \'Etat\' doit avoir été choisie.\n');
define('JS_STATE_SELECT', '-- Choisissez ci-dessus --');
define('JS_ZONE', '* L\'entrée \'Etat\' doit être choisie parmi la liste pour ce pays.');
define('JS_COUNTRY', '* La valeur \'Pays\' doit être choisie.\n');
define('JS_TELEPHONE', '* L\'entrée \'Numéro de téléphone\' doit avoir au moins ' . ENTRY_TELEPHONE_MIN_LENGTH . ' caractères.\n');
define('JS_PASSWORD', '* Les entrées \'Mot de passe\' et \'Confirmation\' doivent avoir au moins ' . ENTRY_PASSWORD_MIN_LENGTH . ' caractères.\n');

define('JS_ORDER_DOES_NOT_EXIST', 'Le numéro de commande %s n\'existe pas !');

define('CATEGORY_PERSONAL', 'Données personnelles');
define('CATEGORY_ADDRESS', 'Adresse');
define('CATEGORY_CONTACT', 'Contact');
define('CATEGORY_COMPANY', 'Société');
define('CATEGORY_OPTIONS', 'Options');

define('ENTRY_GENDER', 'Civilité :');
define('ENTRY_GENDER_ERROR', '&nbsp;<span class="errorText">requis</span>');
define('ENTRY_FIRST_NAME', 'Prénom :');
define('ENTRY_FIRST_NAME_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' caract.</span>');
define('ENTRY_LAST_NAME', 'Nom :');
define('ENTRY_LAST_NAME_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_LAST_NAME_MIN_LENGTH . ' caract.</span>');
define('ENTRY_DATE_OF_BIRTH', 'Date de naissance :');
define('ENTRY_DATE_OF_BIRTH_ERROR', '&nbsp;<span class="errorText">(ex. 03/02/1961)</span>');
define('ENTRY_EMAIL_ADDRESS', 'Adresse électronique :');
define('ENTRY_EMAIL_ADDRESS_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' caract.</span>');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '&nbsp;<span class="errorText">L\'adresse électronique ne semble pas être valide!</span>');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '&nbsp;<span class="errorText">Cette adresse électronique existe déjà!</span>');
define('ENTRY_COMPANY', 'Nom de la société :');
define('ENTRY_STREET_ADDRESS', 'Adresse :');
define('ENTRY_STREET_ADDRESS_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' caract.</span>');
define('ENTRY_SUBURB', 'Complément adresse :');
define('ENTRY_POST_CODE', 'Code postal:');
define('ENTRY_POST_CODE_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_POSTCODE_MIN_LENGTH . ' caract.</span>');
define('ENTRY_CITY', 'ville:');
define('ENTRY_CITY_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_CITY_MIN_LENGTH . ' caract.</span>');
define('ENTRY_STATE', 'Etat :');
define('ENTRY_STATE_ERROR', '&nbsp;<span class="errorText">requis</span>');
define('ENTRY_COUNTRY', 'Pays:');
define('ENTRY_COUNTRY_ERROR', 'Vous devez sélectionner un pays dans le menu déroulant.');
define('ENTRY_TELEPHONE_NUMBER', 'Numéro de téléphone :');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_TELEPHONE_MIN_LENGTH . ' caract.</span>');
define('ENTRY_FAX_NUMBER', 'Numéro de fax :');
define('ENTRY_NEWSLETTER', 'Bulletin d\'informations :');
define('ENTRY_NEWSLETTER_YES', 'Abonné');
define('ENTRY_NEWSLETTER_NO', 'Non abonné');

// images
define('IMAGE_ANI_SEND_EMAIL', 'Envoyer un courrier électronique');
define('IMAGE_BACK', 'Retour');
define('IMAGE_BACKUP', 'Sauvegarde');
define('IMAGE_CANCEL', 'Annuler');
define('IMAGE_CONFIRM', 'Confirmer');
define('IMAGE_COPY', 'Copier');
define('IMAGE_COPY_TO', 'Copier vers');
define('IMAGE_DETAILS', 'Détails');
define('IMAGE_DELETE', 'Supprimer');
define('IMAGE_EDIT', 'Modifier');
define('IMAGE_EMAIL', 'Courrier électronique');
define('IMAGE_EXPORT', 'Exporter');
define('IMAGE_ICON_STATUS_GREEN', 'Actif');
define('IMAGE_ICON_STATUS_GREEN_LIGHT', 'Activer');
define('IMAGE_ICON_STATUS_RED', 'Inactif');
define('IMAGE_ICON_STATUS_RED_LIGHT', 'Désactiver');
define('IMAGE_ICON_INFO', 'Info');
define('IMAGE_INSERT', 'Insérer');
define('IMAGE_LOCK', 'Verouilller');
define('IMAGE_MODULE_INSTALL', 'Installer le module');
define('IMAGE_MODULE_REMOVE', 'Supprimer le module');
define('IMAGE_MOVE', 'Déplacer');
define('IMAGE_NEW_BANNER', 'Nouvelle bannière');
define('IMAGE_NEW_CATEGORY', 'Nouvelle catégorie');
define('IMAGE_NEW_COUNTRY', 'Nouveau pays');
define('IMAGE_NEW_CURRENCY', 'Nouvelle devise');
define('IMAGE_NEW_FILE', 'Nouveau fichier');
define('IMAGE_NEW_FOLDER', 'Nouveau dossier');
define('IMAGE_NEW_LANGUAGE', 'Nouvelle Langue');
define('IMAGE_NEW_NEWSLETTER', 'Nouveau bulletin d\'informations');
define('IMAGE_NEW_PRODUCT', 'Nouveau Produit');
define('IMAGE_NEW_TAX_CLASS', 'Nouvelle classe fiscale');
define('IMAGE_NEW_TAX_RATE', 'Nouvelle Taxe');
define('IMAGE_NEW_TAX_ZONE', 'Nouvelle zone fiscale');
define('IMAGE_NEW_ZONE', 'Nouvelle zone');
define('IMAGE_ORDERS', 'Commandes');
define('IMAGE_ORDERS_INVOICE', 'Facture');
define('IMAGE_ORDERS_PACKINGSLIP', 'Bon de Livraison');
define('IMAGE_PREVIEW', 'Prévisualiser');
define('IMAGE_RESTORE', 'Restaurer');
define('IMAGE_RESET', 'Réinitialiser');
define('IMAGE_SAVE', 'Sauvegarder');
define('IMAGE_SEARCH', 'rechercher');
define('IMAGE_SELECT', 'Choisir');
define('IMAGE_SEND', 'Envoyer');
define('IMAGE_SEND_EMAIL', 'Envoyer un courrier électronique');
define('IMAGE_UNLOCK', 'Déverrouiller');
define('IMAGE_UPDATE', 'Mettre à jour');
define('IMAGE_UPDATE_CURRENCIES', 'Mettre à jour le taux de change');
define('IMAGE_UPLOAD', 'Transférer');

define('ICON_CROSS', 'Faux');
define('ICON_CURRENT_FOLDER', 'Dossier courant');
define('ICON_DELETE', 'Supprimer');
define('ICON_ERROR', 'Erreur');
define('ICON_FILE', 'Fichier');
define('ICON_FILE_DOWNLOAD', 'Télécharger');
define('ICON_FOLDER', 'Dossier');
define('ICON_LOCKED', 'Verrouillé');
define('ICON_PREVIOUS_LEVEL', 'Niveau précédent');
define('ICON_PREVIEW', 'Prévisualiser');
define('ICON_STATISTICS', 'Statistiques');
define('ICON_SUCCESS', 'Succès');
define('ICON_TICK', 'Vrai');
define('ICON_UNLOCKED', 'Déverrouillé');
define('ICON_WARNING', 'Attention');

// constants for use in tep_prev_next_display function
// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Page %s sur %d');
define('JUMP_TO', 'Aller à la ...');
define('PAGE', 'Page');
define('TEXT_DISPLAY_NUMBER_OF_BANNERS', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> bannières)');
define('TEXT_DISPLAY_NUMBER_OF_COUNTRIES', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> pays)');
define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> clients)');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> devises)');
define('TEXT_DISPLAY_NUMBER_OF_LANGUAGES', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> langues)');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> fabricants)');
define('TEXT_DISPLAY_NUMBER_OF_NEWSLETTERS', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> bulletins d\'informations)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> commandes)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> statuts commandes)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> produits)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_EXPECTED', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> produits en attente)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> avis des clients)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> produits en promotion)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> classes fiscales)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_ZONES', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> zones fiscales)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_RATES', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> taux de TVA)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES', 'Affiche <strong>%d</strong> à <strong>%d</strong> (sur <strong>%d</strong> zones)');

define('PREVNEXT_BUTTON_PREV', '&lt;&lt;');
define('PREVNEXT_BUTTON_NEXT', '&gt;&gt;');

define('TEXT_DEFAULT', 'défaut');
define('TEXT_SET_DEFAULT', 'mettre par défaut');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* Requis</span>');

define('TEXT_CACHE_CATEGORIES', 'Bloc catégories');
define('TEXT_CACHE_MANUFACTURERS', 'Bloc fabricants');
define('TEXT_CACHE_ALSO_PURCHASED', 'Module d\'achat supplémentaire');

define('TEXT_NONE', '--aucun--');
define('TEXT_TOP', 'Haut');

define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Erreur : le chemin cible n\'existe pas.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Erreur : Impossible d\'écrire dans le répertoire cible.');
define('ERROR_FILE_NOT_SAVED', 'Erreur : fichier transférer non sauvegardé.');
define('ERROR_FILETYPE_NOT_ALLOWED', 'Erreur : type de fichier transféré non-permis.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Réussite : Le fichier transféré a été sauvegardé.');
define('WARNING_NO_FILE_UPLOADED', 'Attention : fichier non transféré.');

define('TEXT_TRUE_CONFIG', 'Oui');
define('TEXT_FALSE_CONFIG', 'Non');
define('TEXT_ASC_CONFIG', 'Croissant');
define('TEXT_DESC_CONFIG', 'Décroissant');
define('TEXT_DATE_EXPECTED_CONFIG', 'Par date');
define('TEXT_PRODUCT_NAME_CONFIG', 'Par nom produit');
define('TEXT_LEFT_COLUMN_CONFIG', 'Colonne de gauche');
define('TEXT_RIGHT_COLUMN_CONFIG', 'Colonne de droite');
define('TEXT_WEIGHT_CONFIG', 'Poids');
define('TEXT_PRICE_CONFIG', 'Prix');

/* twig */
define('BOX_CONFIGURATION_TWIG','Réglages Twig');
// categories box text in includes/boxes/catalog.php
define('BOX_CATALOG_CATEGORIES_TWIG_PRODUCTS_ATTRIBUTES', '<i class="icon-fa-plus"></i> Twig Attributs produits');
?>
