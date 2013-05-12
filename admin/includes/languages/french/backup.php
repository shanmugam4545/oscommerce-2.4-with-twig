<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Gestionnaire de sauvegarde de la base de données');

define('TABLE_HEADING_TITLE', 'Titre');
define('TABLE_HEADING_FILE_DATE', 'Date');
define('TABLE_HEADING_FILE_SIZE', 'Taille');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_HEADING_NEW_BACKUP', 'Nouvelle sauvegarde');
define('TEXT_INFO_HEADING_RESTORE_LOCAL', 'Restaurer localement');
define('TEXT_INFO_NEW_BACKUP', 'N\'interrompez pas le processus de sauvegarde. Celui-ci peut durer quelques minutes');
define('TEXT_INFO_UNPACK', '<br \><br \>(après extraction des fichiers de l\'archive)');
define('TEXT_INFO_RESTORE', 'Ne pas interrompre le processus de restauration.<br \><br \>Plus le fichier est grand, plus cela prendra du temps!<br \><br \>Si possible, utilisez un client Mysql.<br \><br \>Par exemple :<br \><br \><strong>mysql -h' . DB_SERVER . ' -u' . DB_SERVER_USERNAME . ' -p ' . DB_DATABASE . ' < %s </strong> %s');
define('TEXT_INFO_RESTORE_LOCAL', 'Ne pas interrompre le processus de restauration.<br \><br \>Plus le fichier est grand, plus cela prendra du temps!');
define('TEXT_INFO_RESTORE_LOCAL_RAW_FILE', 'Le fichier transféré doit être au format SQL brut (texte).');
define('TEXT_INFO_DATE', 'Date :');
define('TEXT_INFO_SIZE', 'Taille :');
define('TEXT_INFO_COMPRESSION', 'Compression :');
define('TEXT_INFO_USE_GZIP', 'Utiliser GZIP');
define('TEXT_INFO_USE_ZIP', 'Utiliser ZIP');
define('TEXT_INFO_USE_NO_COMPRESSION', 'Pas de compression (Pur SQL)');
define('TEXT_INFO_DOWNLOAD_ONLY', 'Télécharger seulement (ne pas le stocker côté serveur)');
define('TEXT_INFO_BEST_THROUGH_HTTPS', 'Le meilleur serait le cas d\'une connexion HTTPS');
define('TEXT_DELETE_INTRO', 'Confirmez la suppression de cette sauvegarde');
define('TEXT_NO_EXTENSION', 'Aucune');
define('TEXT_BACKUP_DIRECTORY', 'Répertoire de sauvegarde :');
define('TEXT_LAST_RESTORATION', 'Dernière restauration :');
define('TEXT_FORGET', '(<u>oublier</u>)');

define('ERROR_BACKUP_DIRECTORY_DOES_NOT_EXIST', 'Erreur : Le répertoire de sauvegarde n\'existe pas. Merci de le préciser dans le fichier configure.php.');
define('ERROR_BACKUP_DIRECTORY_NOT_WRITEABLE', 'Erreur : Impossible d\'écrire dans le répertoire de sauvegarde.');
define('ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE', 'Erreur : Lien de téléchargement non disponible.');

define('SUCCESS_LAST_RESTORE_CLEARED', 'Réussite: : La date de derniere restauration est modifiée.');
define('SUCCESS_DATABASE_SAVED', 'Réussite: : La base de données a été sauvée.');
define('SUCCESS_DATABASE_RESTORED', 'Réussite: : La base de données a été restaurée.');
define('SUCCESS_BACKUP_DELETED', 'Réussite: : La base de données a été supprimée.');
?>
