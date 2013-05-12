<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Devises');

define('TABLE_HEADING_CURRENCY_NAME', 'Devise');
define('TABLE_HEADING_CURRENCY_CODES', 'Code');
define('TABLE_HEADING_CURRENCY_VALUE', 'Valeur');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_EDIT_INTRO', 'Merci de faire les changements nécessaires');
define('TEXT_INFO_COMMON_CURRENCIES', '-- Devises communes --');
define('TEXT_INFO_CURRENCY_TITLE', 'Titre :');
define('TEXT_INFO_CURRENCY_CODE', 'Code:');
define('TEXT_INFO_CURRENCY_SYMBOL_LEFT', 'Symbole gauche :');
define('TEXT_INFO_CURRENCY_SYMBOL_RIGHT', 'Symbole droit :');
define('TEXT_INFO_CURRENCY_DECIMAL_POINT', 'Point décimal :');
define('TEXT_INFO_CURRENCY_THOUSANDS_POINT', 'Séparateur de milliers :');
define('TEXT_INFO_CURRENCY_DECIMAL_PLACES', 'Nombre de décimales :');
define('TEXT_INFO_CURRENCY_LAST_UPDATED', 'Dernière mise à jour :');
define('TEXT_INFO_CURRENCY_VALUE', 'Valeur :');
define('TEXT_INFO_CURRENCY_EXAMPLE', 'Exemple de sortie :');
define('TEXT_INFO_INSERT_INTRO', 'Merci de rentrer la nouvelle devise avec ces donées liées');
define('TEXT_INFO_DELETE_INTRO', 'Etes vous sur de vouloir supprimer cette devise ?');
define('TEXT_INFO_HEADING_NEW_CURRENCY', 'Nouvelle devise');
define('TEXT_INFO_HEADING_EDIT_CURRENCY', 'Modifier devise');
define('TEXT_INFO_HEADING_DELETE_CURRENCY', 'Supprimer devise');
define('TEXT_INFO_SET_AS_DEFAULT', TEXT_SET_DEFAULT . ' (Requiert une mise à jour manuelle de la valeur de la devise)');
define('TEXT_INFO_CURRENCY_UPDATED', 'Le taux de change pour %s (%s) a été mis à jour avec succès par l\'intermédiaire de %s.');

define('ERROR_REMOVE_DEFAULT_CURRENCY', 'Erreur : La devise par défaut ne peut être supprimée. Merci de choisir une autre devise par défaut et de réessayer.');
define('ERROR_CURRENCY_INVALID', 'Erreur : Le taux de change pour %s (%s) n\'a pas été mis à jour par l\'intermédiaire de %s. S\'agit t\'il d\'un code devise valide ?');
define('WARNING_PRIMARY_SERVER_FAILED', 'Attention : Le serveur de taux de change primaire (%s) a echoué %s (%s) - essayer avec le serveur de taux de change secondaire.');
?>
