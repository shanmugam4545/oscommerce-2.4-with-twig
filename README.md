oscommerce-2.4-with-twig
========================

based on Twig Library

Database modifications :

ALTER TABLE `categories` ADD `categories_template` varchar(255) NULL 
ALTER TABLE `categories_description` ADD `categories_short_description` TEXT NULL 
ALTER TABLE `categories_description` ADD `categories_long_description` TEXT NULL 
ALTER TABLE `products` ADD `products_template` varchar(255) NULL 
ALTER TABLE `products` ADD `products_gallery` varchar(255) NULL 
ALTER TABLE `products_description` ADD `products_short_description` TEXT NULL 
ALTER TABLE `products_images` ADD `thumb` varchar(255) NULL 
ALTER TABLE `products_options` ADD `products_options_template` varchar(255) DEFAULT classic_dropdown
ALTER TABLE `products_options` ADD `products_options_required` INT(1) DEFAULT 1
ALTER TABLE `products_options_values` ADD `products_options_values_description` TEXT NULL
ALTER TABLE `reviews` ADD `reviews_template` varchar(255) NULL 

CREATE TABLE IF NOT EXISTS `twig_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `author_www` varchar(255) NOT NULL,
  `parent` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `twig_templates` (`id`, `title`, `code`, `author`, `author_www`, `parent`) VALUES
(1, 'classic', 'classic', 'foxp2', 'www.foxtension.com', 1),
(2, 'full page center', 'fullpagecenter', 'foxp2', 'www.foxtension.com', 0),
(3, 'full page', 'fullpage', 'foxp2', 'www.foxtension.com', 0);

INSERT INTO `configuration` (`configuration_id`, `configuration_title`, `configuration_key`, `configuration_value`, `configuration_description`, `configuration_group_id`, `sort_order`, `last_modified`, `date_added`, `use_function`, `set_function`) VALUES
('', 'Twig Dynamic Template System Activation', 'TWIG_ACTIVATION', 'True', 'Do you want activate Twig Dynamic Template System ?', 16, 1, '2013-05-08 22:14:35', '2013-04-12 00:00:00', '', 'osc_cfg_select_option(array(''True'', ''False''), '),
('', 'Twig Store Template', 'TWIG_STORE_TEMPLATE', 'classic', 'Template used for your store', 16, 2, '2013-05-08 23:20:37', '2013-03-27 00:00:00', NULL, 'osc_cfg_pull_down_template_list('),
('', 'Twig Cache Activation', 'TWIG_CACHE_ACTIVATION', 'True', 'Do you want activate cache for Twig ?', 16, 3, '2013-04-17 12:41:27', '2013-04-13 00:00:00', NULL, 'osc_cfg_select_option(array(''True'', ''False''), '),
('', 'Twig debug activation', 'TWIG_DEBUG_ACTIVATION', 'True', 'During development, set to True.(when debug option is setup to true, each template files are recompiled)', 16, 4, '2013-04-15 02:57:48', '2013-04-13 00:00:00', NULL, 'osc_cfg_select_option(array(''True'', ''False''),'),
('', 'Enable Information Module', 'TWIG_MODULE_BOXES_SOCIAL_STATUS', 'True', 'Do you want to add the module to your shop?', 6, 1, NULL, '2013-04-21 17:34:46', NULL, 'osc_cfg_select_option(array(''True'', ''False''), '),
('', 'Content Placement', 'TWIG_MODULE_BOXES_SOCIAL_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', 6, 1, NULL, '2013-04-21 17:34:46', NULL, 'osc_cfg_select_option(array(''Left Column'', ''Right Column''), '),
('', 'Sort Order', 'TWIG_MODULE_BOXES_SOCIAL_SORT_ORDER', '6010', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2013-04-21 17:34:46', NULL, NULL),
('', 'Enable Product Social Bookmarks Module', 'TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_STATUS', 'True', 'Do you want to add the module to your shop?', 6, 1, NULL, '2013-04-26 18:31:14', NULL, 'osc_cfg_select_option(array(''True'', ''False''), '),
('', 'Content Placement', 'TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', 6, 1, NULL, '2013-04-26 18:31:14', NULL, 'osc_cfg_select_option(array(''Left Column'', ''Right Column''), '),
('', 'Sort Order', 'TWIG_MODULE_BOXES_PRODUCT_SOCIAL_BOOKMARKS_SORT_ORDER', '7010', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2013-04-26 18:31:14', NULL, NULL),
('', 'Installed Modules', 'TWIG_MODULE_SOCIAL_BOOKMARKS_INSTALLED', 'twig_sb_email.php;twig_sb_digg.php;twig_sb_twitter.php', 'This is automatically updated. No need to edit.', 6, 0, '2013-04-27 01:17:56', '2013-04-26 20:54:50', NULL, NULL),
('', 'Enable Digg TWIG_MODULE', 'TWIG_MODULE_SOCIAL_BOOKMARKS_DIGG_STATUS', 'True', 'Do you want to allow products to be shared through Digg?', 6, 1, NULL, '2013-04-27 00:48:09', NULL, 'osc_cfg_select_option(array(''True'', ''False''), '),
('', 'Sort Order', 'TWIG_MODULE_SOCIAL_BOOKMARKS_DIGG_SORT_ORDER', '2', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2013-04-27 00:48:09', NULL, NULL),
('', 'Enable E-Mail Module', 'TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_STATUS', 'True', 'Do you want to allow products to be shared through e-mail?', 6, 1, NULL, '2013-04-27 01:17:37', NULL, 'osc_cfg_select_option(array(''True'', ''False''), '),
('', 'Sort Order', 'TWIG_MODULE_SOCIAL_BOOKMARKS_EMAIL_SORT_ORDER', '1', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2013-04-27 01:17:37', NULL, NULL),
('', 'Enable Pinterest Module', 'TWIG_MODULE_SOCIAL_BOOKMARKS_PINTEREST_STATUS', 'True', 'Do you want to allow Pinterest Button?', 6, 1, NULL, '2013-05-01 09:10:32', NULL, 'osc_cfg_select_option(array(''True'', ''False''), '),
('', 'Layout Position', 'TWIG_MODULE_SOCIAL_BOOKMARKS_PINTEREST_BUTTON_COUNT_POSITION', 'None', 'Horizontal or Vertical or None', 6, 2, NULL, '2013-05-01 09:10:32', NULL, 'osc_cfg_select_option(array(''Horizontal'', ''Vertical'', ''None''), '),
('', 'Sort Order', 'TWIG_MODULE_SOCIAL_BOOKMARKS_PINTEREST_SORT_ORDER', '3', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2013-05-01 09:10:32', NULL, NULL);

