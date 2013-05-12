<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Le répertoire de sessions n\'existe pas: ' . tep_session_save_path() . '. Les sessions ne fonctionneront pas tant que ce dossier ne sera pas créé.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Ecriture impossible dans le répertoire de sessions: ' . tep_session_save_path() . '. Les sessions ne fonctionneront pas tant que des droits corrects ne seront pas attribués à ce dossier.');
?>
