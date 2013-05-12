<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

  $paypal_express_ping_button = '';
  if (defined('MODULE_PAYMENT_PAYPAL_EXPRESS_STATUS')) {
    $paypal_express_ping_button = '<p><img src="images/icons/locked.gif">&nbsp;<a href=' . tep_href_link('ext/modules/payment/paypal/paypal_express.php', 'action=test', 'SSL') . ' target="_blank" style="text-decoration: underline; font-weight: bold;">Test API Credentials</a></p>';
  }

  define('MODULE_PAYMENT_PAYPAL_EXPRESS_TEXT_TITLE', 'Paiement PayPal Express');
  define('MODULE_PAYMENT_PAYPAL_EXPRESS_TEXT_PUBLIC_TITLE', 'PayPal (inclut le paiement par Carte Bancaire)');
  define('MODULE_PAYMENT_PAYPAL_EXPRESS_TEXT_DESCRIPTION', '<img src="images/icon_popup.gif" border="0">&nbsp;<a href="https://www.paypal.com/mrb/pal=PS2X9Q773CKG4" target="_blank" style="text-decoration: underline; font-weight: bold;">Consultez le site web de PayPal</a>&nbsp;<a href="javascript:toggleDivBlock(\'paypalExpressInfo\');">(info)</a><span id="paypalExpressInfo" style="display: none;"><br /><i>Utilisez le lien ci-dessus pour faire bénéficier osCommerce d\'une petite commission pour l\'apport d\'un nouveau client Paypal.</i></span>' . $paypal_express_ping_button);
  define('MODULE_PAYMENT_PAYPAL_EXPRESS_TEXT_BUTTON', 'Payer avec PayPal');
  define('MODULE_PAYMENT_PAYPAL_EXPRESS_TEXT_COMMENTS', 'Commentaires:');
  define('MODULE_PAYMENT_PAYPAL_EXPRESS_EMAIL_PASSWORD', 'Un compte a été automatiquement créé pour vous avec l\'adresse mail et le mot de passe suivants:' . "\n\n" . 'Adresse mail : %s' . "\n" . 'Mot de passe: %s' . "\n\n");
  define('MODULE_PAYMENT_PAYPAL_EXPRESS_BUTTON', 'https://www.paypal.com/fr_FR/i/btn/btn_xpressCheckout.gif');
  define('MODULE_PAYMENT_PAYPAL_EXPRESS_LANGUAGE_LOCALE', 'fr_FR');

  unset($paypal_express_ping_button);
?>
