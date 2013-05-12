<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Commandes');
define('HEADING_TITLE_SEARCH', 'ID de Commande:');
define('HEADING_TITLE_STATUS', 'Statut:');

define('TABLE_HEADING_COMMENTS', 'Commentaires');
define('TABLE_HEADING_CUSTOMERS', 'Clients');
define('TABLE_HEADING_ORDER_TOTAL', 'Total commande');
define('TABLE_HEADING_DATE_PURCHASED', 'Date d\'achat');
define('TABLE_HEADING_STATUS', 'Statut');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_QUANTITY', 'Qté.');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Réf./Modèle');
define('TABLE_HEADING_PRODUCTS', 'Produit');
define('TABLE_HEADING_TAX', 'TVA');
define('TABLE_HEADING_TOTAL', 'Total');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Prix (HT)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Prix (TTC)');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Total (HT)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Total (TTC)');

define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Client informé');
define('TABLE_HEADING_DATE_ADDED', 'Date d\'ajout');

define('ENTRY_CUSTOMER', 'Client:');
define('ENTRY_SOLD_TO', 'Facturé à:');
define('ENTRY_DELIVERY_TO', 'Destinataire:');
define('ENTRY_SHIP_TO', 'Livré à:');
define('ENTRY_SHIPPING_ADDRESS', 'Adresse de livraison:');
define('ENTRY_BILLING_ADDRESS', 'Adresse de facturation:');
define('ENTRY_PAYMENT_METHOD', 'Mode de paiement:');
define('ENTRY_CREDIT_CARD_TYPE', 'Type de CB:');
define('ENTRY_CREDIT_CARD_OWNER', 'Titulaire CB:');
define('ENTRY_CREDIT_CARD_NUMBER', 'N° de CB:');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Expiration CB:');
define('ENTRY_SUB_TOTAL', 'Sous-Total:');
define('ENTRY_TAX', 'TVA:');
define('ENTRY_SHIPPING', 'Port:');
define('ENTRY_TOTAL', 'Total:');
define('ENTRY_DATE_PURCHASED', 'Date d\'achat:');
define('ENTRY_STATUS', 'Statut:');
define('ENTRY_DATE_LAST_UPDATED', 'Dernière mise à jour:');
define('ENTRY_NOTIFY_CUSTOMER', 'Informer le client:');
define('ENTRY_NOTIFY_COMMENTS', 'Ajouter un commentaire:');
define('ENTRY_PRINTABLE', 'Afficher une facture');

define('TEXT_INFO_HEADING_DELETE_ORDER', 'Supprimer commande');
define('TEXT_INFO_DELETE_INTRO', 'Confirmez la supression de cette commande');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Remettre les produits en stock');
define('TEXT_DATE_ORDER_CREATED', 'Date de création:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Dernière modification:');
define('TEXT_INFO_PAYMENT_METHOD', 'Mode de paiement:');

define('TEXT_ALL_ORDERS', 'Toutes les commandes');
define('TEXT_NO_ORDER_HISTORY', 'Pas d\'historique de commande disponible');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Mise à jour commande');
define('EMAIL_TEXT_ORDER_NUMBER', 'Numéro de commande:');
define('EMAIL_TEXT_INVOICE_URL', 'Facture:');
define('EMAIL_TEXT_DATE_ORDERED', 'Date d\'achat:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Votre commande a changé de statut (état de traitement).' . "\n\n" . 'Nouveau statut: %s' . "\n\n" . 'Veuillez répondre à ce mail pour tout complément d\'information.' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Les commentaires éventuels sur votre commande sont :' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'Erreur: La commande est introuvable.');
define('SUCCESS_ORDER_UPDATED', 'Réussite: Commande mise à jour.');
define('WARNING_ORDER_NOT_UPDATED', 'Attention: Aucun changement enregistré.');
?>
