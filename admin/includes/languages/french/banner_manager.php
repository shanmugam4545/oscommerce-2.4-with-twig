<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Gestionnaire de bannières');

define('TABLE_HEADING_BANNERS', 'Bannières');
define('TABLE_HEADING_GROUPS', 'Groupes');
define('TABLE_HEADING_STATISTICS', 'Affichages / Clics');
define('TABLE_HEADING_STATUS', 'Statut');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_BANNERS_TITLE', 'Titre de la bannière :');
define('TEXT_BANNERS_URL', 'URL bannière :');
define('TEXT_BANNERS_GROUP', 'Dimension de la bannière :');
define('TEXT_BANNERS_NEW_GROUP', ', ou entrez une nouvelle dimension de la bannière ci-dessous');
define('TEXT_BANNERS_IMAGE', 'Image :');
define('TEXT_BANNERS_IMAGE_LOCAL', ', ou spécifiez un fichier local ci-dessous');
define('TEXT_BANNERS_IMAGE_TARGET', 'Cible de l\'image (Sauvegarder dans) :');
define('TEXT_BANNERS_HTML_TEXT', 'Texte HTML :');
define('TEXT_BANNERS_EXPIRES_ON', 'Expire le :');
define('TEXT_BANNERS_OR_AT', ', ou à');
define('TEXT_BANNERS_IMPRESSIONS', 'Impressions/Vues.');
define('TEXT_BANNERS_SCHEDULED_AT', 'Planifié le :');
define('TEXT_BANNERS_BANNER_NOTE', '<strong>Remarque sur la bannière :</strong><ul><li>Utilisez une image ou du texte HTML pour la bannière mais pas les deux.</li><li>Le texte HTML a priorité sur l\'image</li></ul>');
define('TEXT_BANNERS_INSERT_NOTE', '<strong>Remarque sur l\'image :</strong><ul><li>Le répertoire de destination lors du transfert doit avoir les bonnes permissions (écriture) sur le serveur!</li><li>Ne remplissez pas la cible de l\'image (\'Sauvegarder dans\') si vous ne transférez pas d\'image sur le serveur web (dans le cas où vous utilisez une image déja présente sur celui-ci).</li><li>La cible de l\'image (\'Sauvegarder dans\') doit pointer sur un répertoire existant et le slash de fin doit être présent (ex., banners/).</li></ul>');
define('TEXT_BANNERS_EXPIRCY_NOTE', '<strong>Remarque sur l\'expiration :</strong><ul><li>Seul un des 2 champs doit être saisi.</li><li>Pour laisser la bannière active, sans expiration automatique, laisser ces champs vides.</li></ul>');
define('TEXT_BANNERS_SCHEDULE_NOTE', '<strong>Remarque sur la planification :</strong><ul><li>Si la date de planification est précisée, la bannière sera activée seulement à partir de cette date.</li><li>Toutes les bannières planifiées seront marquées inactives jusqu\'à ce que la date de planification soit atteinte. Elles seront alors actives.</li></ul>');

define('TEXT_BANNERS_DATE_ADDED', 'Date d\'ajout :');
define('TEXT_BANNERS_SCHEDULED_AT_DATE', 'Planifié à: <strong>%s</strong>');
define('TEXT_BANNERS_EXPIRES_AT_DATE', 'Expire le : <strong>%s</strong>');
define('TEXT_BANNERS_EXPIRES_AT_IMPRESSIONS', 'Expire au bout de : <strong>%s</strong> affichages');
define('TEXT_BANNERS_STATUS_CHANGE', 'Changement du statut : %s');

define('TEXT_BANNERS_DATA', 'D<br \>A<br \>T<br \>A');
define('TEXT_BANNERS_LAST_3_DAYS', 'Les 3 derniers jours');
define('TEXT_BANNERS_BANNER_VIEWS', 'Nombre d\'affichages');
define('TEXT_BANNERS_BANNER_CLICKS', 'Nombre de clics');

define('TEXT_INFO_DELETE_INTRO', 'Etes vous sur de vouloir supprimer cette bannière ?');
define('TEXT_INFO_DELETE_IMAGE', 'Supprimer l\'image de la bannière');

define('SUCCESS_BANNER_INSERTED', 'Success : La banière a été insérée.');
define('SUCCESS_BANNER_UPDATED', 'Success : La banière a été mise à jour.');
define('SUCCESS_BANNER_REMOVED', 'Success : La banière a été supprimée.');
define('SUCCESS_BANNER_STATUS_UPDATED', 'Success : Le statut de la banière a été mis à jour.');

define('ERROR_BANNER_TITLE_REQUIRED', 'Erreur : Titre de banière requis.');
define('ERROR_BANNER_GROUP_REQUIRED', 'Erreur : Groupe de banière requis.');
define('ERROR_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Erreur : Le répertoire cible n\'existe pas: %s');
define('ERROR_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Erreur : Target directory is not writeable: %s');
define('ERROR_IMAGE_DOES_NOT_EXIST', 'Erreur : L\'image n\'existe pas.');
define('ERROR_IMAGE_IS_NOT_WRITEABLE', 'Erreur : L\'image ne peut pas être supprimée.');
define('ERROR_UNKNOWN_STATUS_FLAG', 'Erreur : Statut flag inconnu.');

define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', 'Erreur : Le répertoire de bannières n\'existe pas. Créer un répertoire \'graphs\' dans \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE', 'Erreur : Le répertoire de bannières n\'est pas autorisé en écriture.');
?>
