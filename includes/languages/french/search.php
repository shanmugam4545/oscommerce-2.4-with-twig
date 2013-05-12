<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', 'Recherche avancée');
define('NAVBAR_TITLE_2', 'Résultat de la recherche');

define('HEADING_TITLE_1', 'Recherche avancée');
define('HEADING_TITLE_2', 'Produits répondant aux critères de recherche');

define('HEADING_SEARCH_CRITERIA', 'Critères de recherche');

define('TEXT_SEARCH_IN_DESCRIPTION', 'Chercher dans les descriptions de produits');
define('ENTRY_CATEGORIES', 'Catégories:');
define('ENTRY_INCLUDE_SUBCATEGORIES', 'Inclure les sous-catégories');
define('ENTRY_MANUFACTURERS', 'Fabricants :');
define('ENTRY_PRICE_FROM', 'Prix à partir de :');
define('ENTRY_PRICE_TO', 'Prix jusqu\'à :');
define('ENTRY_DATE_FROM', 'Depuis la date :');
define('ENTRY_DATE_TO', 'Jusqu\'à la date :');

define('TEXT_SEARCH_HELP_LINK', '<u>Aide à la recherche</u> [?]');

define('TEXT_ALL_CATEGORIES', 'Toutes catégories');
define('TEXT_ALL_MANUFACTURERS', 'Tous fabricants');

define('HEADING_SEARCH_HELP', 'Aide à la recherche');
define('TEXT_SEARCH_HELP', 'Vous pouvez séparer les mots clés par les opérateurs logiques AND et OR. Par exemple, vous pouvez entrer <u>Microsoft AND souris</u>. Cette recherche vous affichera les résultats qui répondent simultanément aux deux critères. Toutefois, si vous tapez <u>souris OR clavier</u>, seront listés les articles qui ont au moins l\'un des deux mots dans les champs sélectionnés. Si aucun opérateur n\'est précisé, la recherche s\'effectuera avec l\'opérateur AND.<br /><br />Vous pouvez également faire une recherche sur une chaine en l\'encadrant de guillements. Par exemple, une recherche sur  <u>"ordinateur portable"</u> vous affichera la liste de tous les articles ayant exactement cette chaine dans leur description.<br /><br />Les parenthèses peuvent être utilisées pour contr&ocirc;ler l\'ordre de traitement des opérateurs logiques. Par exemple entrez <u>Microsoft and clavier or souris or "visual basic")</u>.');
define('TEXT_CLOSE_WINDOW', '<u>Fermer la fenêtre</u> [x]');

define('TABLE_HEADING_IMAGE', '');
define('TABLE_HEADING_MODEL', 'Modèle');
define('TABLE_HEADING_PRODUCTS', 'Nom du produit');
define('TABLE_HEADING_MANUFACTURER', 'Fabricant');
define('TABLE_HEADING_QUANTITY', 'Quantité');
define('TABLE_HEADING_PRICE', 'Prix');
define('TABLE_HEADING_WEIGHT', 'Poids');
define('TABLE_HEADING_BUY_NOW', 'Acheter maintenant');

define('TEXT_NO_PRODUCTS', 'Il n\'y a aucun produit correspondant à vos critères de recherche.');

define('ERROR_AT_LEAST_ONE_INPUT', 'Au moins un critère de recherche doit être rempli.');
define('ERROR_INVALID_FROM_DATE', 'Date du champ <u>Depuis la date<\/u> invalide.');
define('ERROR_INVALID_TO_DATE', 'Date du champ <u>Jusqu\'à la date<\/u>  invalide.');
define('ERROR_TO_DATE_LESS_THAN_FROM_DATE', 'La date du champ <u>Jusqu\'à la date<\/u> doit être supérieure ou égale à la date du champ <u>Depuis la date<\/u>');
define('ERROR_PRICE_FROM_MUST_BE_NUM', 'Le prix du champ <u>Prix à partir de<\/u> ne doit contenir que des chiffres.');
define('ERROR_PRICE_TO_MUST_BE_NUM', 'Le prix du champ <u>Prix jusqu\'à<\/u> ne doit contenir que des chiffres.');
define('ERROR_PRICE_TO_LESS_THAN_PRICE_FROM', 'Le prix du champ <u>Prix jusqu\'à<\/u> doit être supérieure ou égale au prix du champ <u>Prix à partir de<\/u>.');
define('ERROR_INVALID_KEYWORDS', 'Mots-clés invalides.');
?>
