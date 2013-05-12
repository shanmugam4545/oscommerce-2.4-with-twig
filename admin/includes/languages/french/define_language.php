<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Définir les langues');

define('TABLE_HEADING_FILES', 'Fichiers');
define('TABLE_HEADING_WRITABLE', 'Accessible en écriture');
define('TABLE_HEADING_LAST_MODIFIED', 'Dernière modification');

define('TEXT_EDIT_NOTE', '<strong>Mofifier les définitions</strong><br /><br />Chaque définition linguistique est définie en utilisant la fonction PHP <a href="http://www.php.net/define" target="_blank">define()</a> de la manière suivante:<br /><br /><nobr>define(\'TEXT_MAIN\', \'<span style="background-color: #FFFF99;">Ce texte peut être modifié. C\\\'est vraiment très simple à faire!</span>\');</nobr><br /><br />Le texte mis en évidence peut être édité. Comme les définitions linguistique utilisent des guillemets pour contenir le texte, chaque guillemet dans le texte de définition doit être échappé avec un antislash (exemple, C\\\'est).');

define('TEXT_FILE_DOES_NOT_EXIST', 'Le fichier n\'existe pas.');

define('ERROR_FILE_NOT_WRITEABLE', 'Erreur: Impossible d\'écrire dans le fichier. Veuillez définir les bonnes permissions sur: %s');
?>
