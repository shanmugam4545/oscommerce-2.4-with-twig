<?php
/**
 * osCommerce Online Merchant
 * 
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

define('NAVBAR_TITLE', 'Commande');
define('NAVBAR_TITLE_SHIPPING', 'Mode de livraison');
define('NAVBAR_TITLE_SHIPPING_ADDRESS', 'Changer l\'adresse d\'expédition');
define('NAVBAR_TITLE_PAYMENT', 'Mode de paiement');
define('NAVBAR_TITLE_PAYMENT_ADDRESS', 'Changer l\'adresse de facturation');
define('NAVBAR_TITLE_CONFIRMATION', 'Confirmation');
define('NAVBAR_TITLE_SUCCESS', 'Succès');

define('HEADING_TITLE_SHIPPING', 'Information livraison');
define('HEADING_TITLE_SHIPPING_ADDRESS', 'Information livraison');
define('HEADING_TITLE_PAYMENT', 'Information paiement');
define('HEADING_TITLE_PAYMENT_ADDRESS', 'Information paiement');
define('HEADING_TITLE_CONFIRMATION', 'Confirmation commande');
define('HEADING_TITLE_SUCCESS', 'Votre commande vient d\'être prise en compte !');

define('TITLE_PLEASE_SELECT', 'Veuillez choisir');
define('TABLE_HEADING_COMMENTS', 'Ajoutez des commentaires au sujet de votre commande');

define('TABLE_HEADING_SHIPPING_ADDRESS', 'Adresse d\'expédition');
define('TEXT_CHOOSE_SHIPPING_DESTINATION', 'Veuillez choisir dans votre carnet d\'adresse le lieu où vous souhaitez être livré.');
define('TITLE_SHIPPING_ADDRESS', 'Adresse d\'expédition :');

define('TABLE_HEADING_SHIPPING_METHOD', 'Mode de livraison');
define('TEXT_CHOOSE_SHIPPING_METHOD', 'Veuillez choisir la Mode de livraison préférée à utiliser pour cette commande.');
define('TEXT_ENTER_SHIPPING_INFORMATION', 'C\'est actuellement le seul Mode de livraison disponible pour cette commande.');

define('TABLE_HEADING_BILLING_ADDRESS', 'Adresse de facturation');
define('TEXT_SELECTED_BILLING_DESTINATION', 'Veuillez choisir dans votre carnet d\'adresses l\'adresse où vous voudriez que la facture soit expédiée');
define('TITLE_BILLING_ADDRESS', 'Adresse de facturation :');

define('TABLE_HEADING_PAYMENT_METHOD', 'Mode de paiement');
define('TEXT_SELECT_PAYMENT_METHOD', 'Veuillez choisir la méthode de paiement à utiliser pour cette commande.');
define('TEXT_ENTER_PAYMENT_INFORMATION', 'C\'est actuellement le seul Mode de paiement disponible pour cette commande.');

define('HEADING_SHIPPING_INFORMATION', 'Information sur la livraison');
define('HEADING_DELIVERY_ADDRESS', 'Adresse de livraison');
define('HEADING_SHIPPING_METHOD', 'Mode de livraison');
define('HEADING_PRODUCTS', 'Produits');
define('HEADING_TAX', 'TVA');
define('HEADING_TOTAL', 'Total');
define('HEADING_BILLING_INFORMATION', 'Information de facturation');
define('HEADING_BILLING_ADDRESS', 'Adresse de facturation');
define('HEADING_PAYMENT_METHOD', 'Mode de paiement');
define('HEADING_PAYMENT_INFORMATION', 'Information de paiement');
define('HEADING_ORDER_COMMENTS', 'Commentaires au sujet de votre commande ');

define('TEXT_EDIT', 'Modifier');

define('EMAIL_TEXT_SUBJECT', 'Traitement de la commande');
define('EMAIL_TEXT_ORDER_NUMBER', 'Numéro de commande :');
define('EMAIL_TEXT_INVOICE_URL', 'Facture détaillée :');
define('EMAIL_TEXT_DATE_ORDERED', 'Date de commande :');
define('EMAIL_TEXT_PRODUCTS', 'Produits');
define('EMAIL_TEXT_SUBTOTAL', 'Sous-Total :');
define('EMAIL_TEXT_TAX', 'TVA :        ');
define('EMAIL_TEXT_SHIPPING', 'Expédition : ');
define('EMAIL_TEXT_TOTAL', 'Total :    ');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Adresse de livraison');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Adresse de facturation');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Mode de paiement');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', 'par l\'intermédiaire de');

define('TEXT_SUCCESS', 'Votre commande vient d\'être enregistrée par notre système ! Vos produits arriveront à destination dans 2-5 jours ouvrés');
define('TEXT_NOTIFY_PRODUCTS', 'Veuillez m\'alerter des mises à jour des produits que j\'ai choisis ci-dessous :');
define('TEXT_SEE_ORDERS', 'Vous pouvez voir l\'historique de votre commande en consultant la page <a href="' . osc_href_link('account', '', 'SSL') . '">\'Mon compte\'</a> et en cliquant sur <a href="' . osc_href_link('account', 'orders', 'SSL') . '">\'Historique\'</a>.');
define('TEXT_CONTACT_STORE_OWNER', 'Veuillez poser toute question au <a href="' . osc_href_link('info','contact') . '">gestionnaire du site</a>.');
define('TEXT_THANKS_FOR_SHOPPING', 'Merci d\'avoir fait vos achats en ligne avec nous !');

define('TABLE_HEADING_DOWNLOAD_DATE', 'date d\'expiration : ');
define('TABLE_HEADING_DOWNLOAD_COUNT', ' téléchargement(s) restant');
define('HEADING_DOWNLOAD', 'Téléchargez vos produits ici :');
define('FOOTER_DOWNLOAD', 'Vous pourrez télécharger vos produits plus tard sur \'%s\'');

define('TEXT_SELECTED_SHIPPING_DESTINATION', 'Veuillez choisir dans votre carnet d\'adresses l\'adresse où vous voudriez que les articles soient livrés.');

define('TABLE_HEADING_ADDRESS_BOOK_ENTRIES', 'Entrées du carnet d\'adresses');
define('TEXT_SELECT_OTHER_SHIPPING_DESTINATION', 'Veuillez choisir l\'adresse d\'expédition  si les articles de cette commande doivent être livrés ailleurs.');

define('TABLE_HEADING_NEW_SHIPPING_ADDRESS', 'Nouvelle adresse d\'expédition');
define('TEXT_CREATE_NEW_SHIPPING_ADDRESS', 'Veuillez utiliser ce formulaire pour créer une nouvelle adresse d\'expédition pour cette commande.');

define('TABLE_HEADING_PAYMENT_ADDRESS', 'Adresse de facturation');
define('TEXT_SELECTED_PAYMENT_DESTINATION', 'Ceci est l\'adresse sélectionnée, où la facture de cette commande sera expédiée.');
define('TITLE_PAYMENT_ADDRESS', 'Adresse de facturation :');

define('TEXT_SELECT_OTHER_PAYMENT_DESTINATION', 'Veuillez choisir l\'adresse de facturation  si la facture de cette commande doit être envoyée ailleurs.');

define('TABLE_HEADING_NEW_PAYMENT_ADDRESS', 'Nouvelle adresse de facturation');
define('TEXT_CREATE_NEW_PAYMENT_ADDRESS', 'Veuillez remplir le formulaire suivant afin de créer une nouvelle adresse de facturation pour cette commande.');
?>