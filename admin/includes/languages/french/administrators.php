<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Administrateurs');

define('TABLE_HEADING_ADMINISTRATORS', 'Administrateurs');
define('TABLE_HEADING_HTPASSWD', 'Protégé par htpasswd');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_INSERT_INTRO', 'Veuillez entrer le nouvel administrateur avec ses données');
define('TEXT_INFO_EDIT_INTRO', 'Veuillez faire les changements necessaires');
define('TEXT_INFO_DELETE_INTRO', 'Confirmer la suppression de cet administrateur.');
define('TEXT_INFO_HEADING_NEW_ADMINISTRATOR', 'Nouvel administrateur');
define('TEXT_INFO_USERNAME', 'Nom d\'utilisateur:');
define('TEXT_INFO_NEW_PASSWORD', 'Nouveau mot de passe:');
define('TEXT_INFO_PASSWORD', 'Mot de passe:');
define('TEXT_INFO_PROTECT_WITH_HTPASSWD', 'Protégé avec htaccess/htpasswd');

define('ERROR_ADMINISTRATOR_EXISTS', 'Erreur: L\'Administrateur existe déja.');

define('HTPASSWD_INFO', '<strong>Sécurisation via htaccess/htpasswd</strong><p>Cette installation de l\'outil d\'administration de boutique osCommerce n\'utilise pas de sécurisation via htaccess/htpasswd.</p><p>Activer la sécurisation via htaccess/htpasswd stockera automatiquement le nom d\'utilisateur et le mot de passe de l\'administrateur dans un fichier htpasswd lors de la mise à jour du mot de passe de l\'administrateur.</p><p><strong>Veuillez noter</strong>, si cette protection est activée et que vous ne pouvez plus accéder à l\'outil d\'administration, veuillez apporter les modifications suivantes et consultez votre hébergeur pour permettre l\'utilisation de la sécurisation via htaccess/htpasswd:</p><p><u><strong>1. Modifier ce fichier:</strong></u><br /><br />' . DIR_FS_ADMIN . '.htaccess</p><p>Supprimer les lignes suivantes si elles existent:</p><p><i>%s</i></p><p><u><strong>2. Supprimer ce fichier:</strong></u><br /><br />' . DIR_FS_ADMIN . '.htpasswd_oscommerce</p>');
define('HTPASSWD_SECURED', '<strong>Sécurisation via htaccess/htpasswd</strong><p>Cette installation de l\'outil d\'administration de boutique osCommerce utilise la sécurisation via htaccess/htpasswd.</p>');
define('HTPASSWD_PERMISSIONS', '<strong>Sécurisation via htaccess/htpasswd</strong><p>Cette installation de l\'outil d\'administration de boutique osCommerce n\'utilise pas de sécurisation via htaccess/htpasswd.</p><p>Les fichiers doivent être accessibles en écriture pour le serveur web pour activer la sécurisation via htaccess/htpasswd:</p><ul><li>' . DIR_FS_ADMIN . '.htaccess</li><li>' . DIR_FS_ADMIN . '.htpasswd_oscommerce</li></ul><p>Rafraichissez la page pour verifier si les droits sur les fichiers ont été correctement paramétrés.</p>');
?>
