<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Copyright (c) 2013 FoxP2 http://www.osommerce.fr

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Informations');
define('NAVBAR_TITLE', 'Info');

define('NAVBAR_TITLE_SHIPPING', 'Expédition et retours');
define('HEADING_TITLE_SHIPPING', 'Expédition et retours');
define('INFO_SHIPPING', 'Insérer ici vos informations expédition et retours.');

define('NAVBAR_TITLE_PRIVACY', 'Remarque sur la confidentialité');
define('HEADING_TITLE_PRIVACY', 'Remarque sur la confidentialité');
define('INFO_PRIVACY', 'Insérer ici vos remarques confidentialité.');

define('NAVBAR_TITLE_CONDITIONS', 'Conditions d\'utilisation');
define('HEADING_TITLE_CONDITIONS', 'Conditions d\'utilisation');
define('INFO_CONDITIONS', 'Mettre ici vos informations conditions d\'usage.');

define('HEADING_TITLE_CONTACT', 'Contactez-nous');
define('NAVBAR_TITLE_CONTACT', 'Contactez-nous');
define('INFO_CONTACT_SUCCESS', 'Votre requête a été envoyée au gestionnaire du site.');
define('EMAIL_SUBJECT', 'Demande en provenance de ' . STORE_NAME);

define('ENTRY_NAME', 'Nom et Prénom :');
define('ENTRY_EMAIL', 'Adresse email :');
define('ENTRY_ENQUIRY', 'Demande de renseignements :');
define('ERROR_ACTION_RECORDER', 'Erreur: Un formulaire de contact vient d\'être envoyé. Veuillez réessayer dans %s minutes.');

define('NAVBAR_TITLE_COOKIE_USAGE', 'Utilisation de cookie');
define('HEADING_TITLE_COOKIE_USAGE', 'Utilisation de cookie');
define('TEXT_INFORMATION_COOKIE_USAGE', 'Nous avons détecté que votre navigateur n\'accepte pas les cookies, ou la fonction cookies est désactivée.<br /><br />Pour continuer de faire des achats en ligne, nous vous encourageons à autoriser les cookies sur votre navigateur.<br /><br />Pour les navigateurs <strong>Internet Explorer</strong> , veuillez suivre ces instructions:<br /><ol><li>Cliquer sur la barre de menu Outils, et sélectionner Options Internet</li><li>Sélectionner l\'onglet Sécurité, et remettre le niveau de securité sur moyen</li></ol>Nous avons pris cette mesure de sécurité pour votre avantage et faisons des excuses ouvertes si n\'importe quels inconvénients sont causés.<br /><br />Entrez s\'il vous plaît en contact avec le propriétaire du magasin si vous avez des questions touchant à cette condition , ou continuez vos achats en ligne.');
define('BOX_INFORMATION_HEADING_COOKIE_USAGE', 'Cookies Vie privée et Sécurité');
define('BOX_INFORMATION_COOKIE_USAGE', 'On doit autoriser les cookies pour acheter en ligne sur ce magasin pour des questions liées à la vie privée et à la sécurité quant à votre visite sur ce site. En permettant l\'utilisation de cookie à votre navigateur, la communication entre vous et ce site est renforcée pour être certain qu\'il n\'y ai que vous qui faites des transactions pour votre propre défense et empêcher la fuite de vos information de vie privée.');

define('NAVBAR_TITLE_SSL_CHECK', 'Contrôle de la sécurité');
define('HEADING_TITLE_SSL_CHECK', 'Contrôle de la sécurité');
define('TEXT_INFORMATION_SSL_CHECK', 'Nous avons détecté que votre navigateur a généré une session SSL différente de l\'ID employé dans nos pages sécurisées. .<br /><br />Pour des mesures de sécurité vous devrez à à nouveau vous connecter à votre compte.<br /><br />Quelques navigateurs comme Konqueror 3.1 n\'ont pas la capacité de générer un identifiant de session sécurisé. Si vous utilisez un tel navigateur, nous recommandons de changer de navigateur : <a href="http://www.microsoft.com/ie/" target="_blank">Microsoft Internet Explorer</a>, <a href="http://channels.netscape.com/ns/browsers/download_other.jsp" target="_blank">Netscape</a>, ou <a href="http://www.mozilla.org/releases/" target="_blank">Mozilla</a>, pour continuer vos achats en ligne.<br /><br />Nous avons pris cette mesure de sécurité pour protéger vos informations personnelles et nous sommes navrés des désagréments encourus.<br /><br />Entrez en contact avec le gestionnaire du site pour plus d\'informations sur ce sujet.');
define('BOX_INFORMATION_HEADING_SSL_CHECK', 'Vie privée et sécurité ');
define('BOX_INFORMATION_SSL_CHECK', 'Nous validons la session SSL ID automatiquement produit par votre navigateur à chaque demande de page sécurisé faite à ce serveur.<br /><br />Cette validation assure que votre identité ne peut être usurpée durant votre navigation.');




/* twig */

define('ENTRY_CONTACT_REQUIRED', '<i class="icon-fa-chevron-sign-up"></i> Champs requis !');
define('ENTRY_CONTACT_FIRSTNAME', '*');
define('ENTRY_CONTACT_FIRSTNAME_MIN_LENGTH', '2');
define('ENTRY_CONTACT_FIRSTNAME_ERROR', 'Votre prénom doit contenir au minimum ' . ENTRY_CONTACT_FIRSTNAME_MIN_LENGTH . ' caractères.');
define('ENTRY_CONTACT_INPUT_FIRSTNAME', 'Votre prénom :');
define('ENTRY_CONTACT_PLACEHOLDER_FIRSTNAME', 'Prénom');
define('ENTRY_CONTACT_LASTNAME', '*');
define('ENTRY_CONTACT_LASTNAME_MIN_LENGTH', '2');
define('ENTRY_CONTACT_LASTNAME_ERROR', 'Votre nom doit contenir au minimum ' . ENTRY_CONTACT_LASTNAME_MIN_LENGTH . ' caractères.');
define('ENTRY_CONTACT_INPUT_LASTNAME', 'Votre nom :');
define('ENTRY_CONTACT_PLACEHOLDER_LASTNAME', 'Nom');
define('ENTRY_CONTACT_EMAIL', '*');
define('ENTRY_CONTACT_EMAIL_MIN_LENGTH', '2');
define('ENTRY_CONTACT_EMAIL_ERROR', 'Votre addresse email doit contenir au minimum ' . ENTRY_CONTACT_EMAIL_MIN_LENGTH . ' caractères.');
define('ENTRY_CONTACT_EMAIL_CHECK_ERROR', 'Votre addresse email ne semble pas être valide - Merci d\'apporter les corrections nécessaires.');
define('ENTRY_CONTACT_INPUT_EMAIL', 'Votre addresse email:');
define('ENTRY_CONTACT_PLACEHOLDER_EMAIL', 'Adresse email');
define('ENTRY_CONTACT_ENQUIRY_MIN_LENGTH', '50');
define('ENTRY_CONTACT_ENQUIRY_ERROR', 'Votre requète email doit contenir au minimum ' . ENTRY_CONTACT_ENQUIRY_MIN_LENGTH . ' caractères.');
define('CONTACT_US_FORM_ERROR_TITLE','Erreurs dans votre formulaire');
define('CONTACT_US_FORM_ERROR','Vous avez ');
define('CONTACT_US_FORM_ERROR_NUMBERS',' erreur(s) dans votre formulaire.<br />Veuillez appliquer les corrections nécessaires.');


?>
