<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class cfgm_twig_social_bookmarks {
    var $code = 'twig_social_bookmarks';
    var $directory;
    var $language_directory = DIR_FS_CATALOG_LANGUAGES;
    var $key = 'TWIG_MODULE_SOCIAL_BOOKMARKS_INSTALLED';
    var $title;
    var $template_integration = false;

    function cfgm_twig_social_bookmarks() {
      $this->directory = DIR_FS_CATALOG_MODULES . 'twig_social_bookmarks/';
      $this->title = MODULE_CFG_TWIG_MODULE_SOCIAL_BOOKMARKS_TITLE;
    }
  }
?>
