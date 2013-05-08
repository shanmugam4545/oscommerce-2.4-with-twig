<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  class paypal_express {
    var $code, $title, $description, $enabled;

// class constructor
    function paypal_express() {
      global $order;

      $this->signature = 'paypal|paypal_express|1.2|2.2';
      $this->api_version = '60.0';

      $this->code = 'paypal_express';
      $this->title = MODULE_PAYMENT_PAYPAL_EXPRESS_TEXT_TITLE;
      $this->public_title = MODULE_PAYMENT_PAYPAL_EXPRESS_TEXT_PUBLIC_TITLE;
      $this->description = MODULE_PAYMENT_PAYPAL_EXPRESS_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_PAYPAL_EXPRESS_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_PAYPAL_EXPRESS_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_PAYPAL_EXPRESS_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_PAYPAL_EXPRESS_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PAYPAL_EXPRESS_ZONE > 0) ) {
        $check_flag = false;
        $check_query = osc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_PAYPAL_EXPRESS_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        while ($check = osc_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }

    function checkout_initialization_method() {
      if (MODULE_PAYMENT_PAYPAL_EXPRESS_CHECKOUT_IMAGE == 'Dynamic') {
        if (MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTION_SERVER == 'Live') {
          $image_button = 'https://fpdbs.paypal.com/dynamicimageweb?cmd=_dynamic-image';
        } else {
          $image_button = 'https://fpdbs.sandbox.paypal.com/dynamicimageweb?cmd=_dynamic-image';
        }

        $params = array('locale=' . MODULE_PAYMENT_PAYPAL_EXPRESS_LANGUAGE_LOCALE);

        if (osc_not_null(MODULE_PAYMENT_PAYPAL_EXPRESS_API_USERNAME)) {
          $response_array = $this->getPalDetails();

          if (isset($response_array['PAL'])) {
            $params[] = 'pal=' . $response_array['PAL'];
            $params[] = 'ordertotal=' . $this->format_raw($_SESSION['cart']->show_total());
          }
        }

        if (!empty($params)) {
          $image_button .= '&' . implode('&', $params);
        }
      } else {
        $image_button = MODULE_PAYMENT_PAYPAL_EXPRESS_BUTTON;
      }

      $string = '<a href="' . osc_href_link('ext/modules/payment/paypal/express.php', '', 'SSL') . '"><img src="' . $image_button . '" alt="" title="' . osc_output_string_protected(MODULE_PAYMENT_PAYPAL_EXPRESS_TEXT_BUTTON) . '" /></a>';

      return $string;
    }

    function javascript_validation() {
      return false;
    }

    function selection() {
      return array('id' => $this->code,
                   'module' => $this->public_title);
    }

    function pre_confirmation_check() {
      global $order;

      if (!isset($_SESSION['ppe_token'])) {
        osc_redirect(osc_href_link('ext/modules/payment/paypal/express.php', '', 'SSL'));
      }

      if (!isset($_GET['do'])) {
        $response_array = $this->getExpressCheckoutDetails($_SESSION['ppe_token']);

        if (($response_array['ACK'] == 'Success') || ($response_array['ACK'] == 'SuccessWithWarning')) {
// load the selected shipping module
          include(DIR_WS_CLASSES . 'shipping.php');
          $shipping_modules = new shipping($_SESSION['shipping']);

          include(DIR_WS_CLASSES . 'order_total.php');
          $order_total_modules = new order_total;
          $order_total_modules->process();

          if ($response_array['AMT'] == $this->format_raw($order->info['total'])) {
            osc_redirect(osc_href_link('checkout', 'process', 'SSL'));
          } else {
            osc_redirect(osc_href_link('checkout', 'do=confirm', 'SSL'));
          }
        }
      }
    }

    function confirmation() {
      if (!isset($_SESSION['comments'])) {
        $_SESSION['comments'] = null;
      }

      $confirmation = false;

      if (empty($_SESSION['comments'])) {
        $confirmation = array('fields' => array(array('title' => MODULE_PAYMENT_PAYPAL_EXPRESS_TEXT_COMMENTS,
                                                      'field' => osc_draw_textarea_field('ppecomments', 'soft', '60', '5', $_SESSION['comments']))));
      }

      return $confirmation;
    }

    function process_button() {
      return false;
    }

    function before_process() {
      global $order, $response_array;

      if (empty($_SESSION['comments'])) {
        if (isset($_POST['ppecomments']) && osc_not_null($_POST['ppecomments'])) {
          $_SESSION['comments'] = osc_db_prepare_input($_POST['ppecomments']);

          $order->info['comments'] = $_SESSION['comments'];
        }
      }

      $params = array('TOKEN' => $_SESSION['ppe_token'],
                      'PAYERID' => $_SESSION['ppe_payerid'],
                      'AMT' => $this->format_raw($order->info['total']),
                      'CURRENCYCODE' => $order->info['currency']);

      if (is_numeric($_SESSION['sendto']) && ($_SESSION['sendto'] > 0)) {
        $params['SHIPTONAME'] = $order->delivery['firstname'] . ' ' . $order->delivery['lastname'];
        $params['SHIPTOSTREET'] = $order->delivery['street_address'];
        $params['SHIPTOCITY'] = $order->delivery['city'];
        $params['SHIPTOSTATE'] = osc_get_zone_code($order->delivery['country']['id'], $order->delivery['zone_id'], $order->delivery['state']);
        $params['SHIPTOCOUNTRYCODE'] = $order->delivery['country']['iso_code_2'];
        $params['SHIPTOZIP'] = $order->delivery['postcode'];
      }

      $response_array = $this->doExpressCheckoutPayment($params);

      if (($response_array['ACK'] != 'Success') && ($response_array['ACK'] != 'SuccessWithWarning')) {
        osc_redirect(osc_href_link('cart', 'error_message=' . stripslashes($response_array['L_LONGMESSAGE0']), 'SSL'));
      }
    }

    function after_process() {
      global $response_array, $insert_id, $order;

      $pp_result = 'Payer Status: ' . osc_output_string_protected($_SESSION['ppe_payerstatus']) . "\n" .
                   'Address Status: ' . osc_output_string_protected($_SESSION['ppe_addressstatus']) . "\n\n" .
                   'Payment Status: ' . osc_output_string_protected($response_array['PAYMENTSTATUS']) . "\n" .
                   'Payment Type: ' . osc_output_string_protected($response_array['PAYMENTTYPE']) . "\n" .
                   'Pending Reason: ' . osc_output_string_protected($response_array['PENDINGREASON']) . "\n" .
                   'Reversal Code: ' . osc_output_string_protected($response_array['REASONCODE']);

      $sql_data_array = array('orders_id' => $insert_id, 
                              'orders_status_id' => MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTIONS_ORDER_STATUS_ID, 
                              'date_added' => 'now()', 
                              'customer_notified' => '0',
                              'comments' => $pp_result);

      osc_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

      unset($_SESSION['ppe_token']);
      unset($_SESSION['ppe_payerid']);
      unset($_SESSION['ppe_payerstatus']);
      unset($_SESSION['ppe_addressstatus']);
    }

    function get_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = osc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_EXPRESS_STATUS'");
        $this->_check = osc_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      $check_query = osc_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " where orders_status_name = 'PayPal [Transactions]' limit 1");

      if (osc_db_num_rows($check_query) < 1) {
        $status_query = osc_db_query("select max(orders_status_id) as status_id from " . TABLE_ORDERS_STATUS);
        $status = osc_db_fetch_array($status_query);

        $status_id = $status['status_id']+1;

        $languages = osc_get_languages();

        foreach ($languages as $lang) {
          osc_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) values ('" . $status_id . "', '" . $lang['id'] . "', 'PayPal [Transactions]')");
        }

        $flags_query = osc_db_query("describe " . TABLE_ORDERS_STATUS . " public_flag");
        if (osc_db_num_rows($flags_query) == 1) {
          osc_db_query("update " . TABLE_ORDERS_STATUS . " set public_flag = 0 and downloads_flag = 0 where orders_status_id = '" . $status_id . "'");
        }
      } else {
        $check = osc_db_fetch_array($check_query);

        $status_id = $check['orders_status_id'];
      }

      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable PayPal Express Checkout', 'MODULE_PAYMENT_PAYPAL_EXPRESS_STATUS', 'False', 'Do you want to accept PayPal Express Checkout payments?', '6', '1', 'osc_cfg_select_option(array(\'True\', \'False\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Seller Account', 'MODULE_PAYMENT_PAYPAL_EXPRESS_SELLER_ACCOUNT', '', 'The email address of the seller account if no API credentials has been setup.', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('API Username', 'MODULE_PAYMENT_PAYPAL_EXPRESS_API_USERNAME', '', 'The username to use for the PayPal API service', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('API Password', 'MODULE_PAYMENT_PAYPAL_EXPRESS_API_PASSWORD', '', 'The password to use for the PayPal API service', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('API Signature', 'MODULE_PAYMENT_PAYPAL_EXPRESS_API_SIGNATURE', '', 'The signature to use for the PayPal API service', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Transaction Server', 'MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTION_SERVER', 'Live', 'Use the live or testing (sandbox) gateway server to process transactions?', '6', '0', 'osc_cfg_select_option(array(\'Live\', \'Sandbox\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Transaction Method', 'MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTION_METHOD', 'Sale', 'The processing method to use for each transaction.', '6', '0', 'osc_cfg_select_option(array(\'Authorization\', \'Sale\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('PayPal Account Optional', 'MODULE_PAYMENT_PAYPAL_EXPRESS_ACCOUNT_OPTIONAL', 'False', 'This must also be enabled in your PayPal account, in Profile > Website Payment Preferences.', '6', '0', 'osc_cfg_select_option(array(\'True\', \'False\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('PayPal Instant Update', 'MODULE_PAYMENT_PAYPAL_EXPRESS_INSTANT_UPDATE', 'True', 'Support PayPal shipping and tax calculations on the PayPal.com site during Express Checkout.', '6', '0', 'osc_cfg_select_option(array(\'True\', \'False\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('PayPal Checkout Image', 'MODULE_PAYMENT_PAYPAL_EXPRESS_CHECKOUT_IMAGE', 'Static', 'Use static or dynamic Express Checkout image buttons. Dynamic images are used with PayPal campaigns.', '6', '0', 'osc_cfg_select_option(array(\'Static\', \'Dynamic\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Debug E-Mail Address', 'MODULE_PAYMENT_PAYPAL_EXPRESS_DEBUG_EMAIL', '', 'All parameters of an invalid transaction will be sent to this email address.', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Payment Zone', 'MODULE_PAYMENT_PAYPAL_EXPRESS_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'osc_get_zone_class_title', 'osc_cfg_pull_down_zone_classes(', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display.', 'MODULE_PAYMENT_PAYPAL_EXPRESS_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Order Status', 'MODULE_PAYMENT_PAYPAL_EXPRESS_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'osc_cfg_pull_down_order_statuses(', 'osc_get_order_status_name', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('PayPal Transactions Order Status Level', 'MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTIONS_ORDER_STATUS_ID', '" . $status_id . "', 'Include PayPal transaction information in this order status level', '6', '0', 'osc_cfg_pull_down_order_statuses(', 'osc_get_order_status_name', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('cURL Program Location', 'MODULE_PAYMENT_PAYPAL_EXPRESS_CURL', '/usr/bin/curl', 'The location to the cURL program application.', '6', '0' , now())");
   }

    function remove() {
      osc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_PAYPAL_EXPRESS_STATUS', 'MODULE_PAYMENT_PAYPAL_EXPRESS_SELLER_ACCOUNT', 'MODULE_PAYMENT_PAYPAL_EXPRESS_API_USERNAME', 'MODULE_PAYMENT_PAYPAL_EXPRESS_API_PASSWORD', 'MODULE_PAYMENT_PAYPAL_EXPRESS_API_SIGNATURE', 'MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTION_SERVER', 'MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTION_METHOD', 'MODULE_PAYMENT_PAYPAL_EXPRESS_ACCOUNT_OPTIONAL', 'MODULE_PAYMENT_PAYPAL_EXPRESS_INSTANT_UPDATE', 'MODULE_PAYMENT_PAYPAL_EXPRESS_CHECKOUT_IMAGE', 'MODULE_PAYMENT_PAYPAL_EXPRESS_DEBUG_EMAIL', 'MODULE_PAYMENT_PAYPAL_EXPRESS_ZONE', 'MODULE_PAYMENT_PAYPAL_EXPRESS_ORDER_STATUS_ID', 'MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTIONS_ORDER_STATUS_ID', 'MODULE_PAYMENT_PAYPAL_EXPRESS_SORT_ORDER', 'MODULE_PAYMENT_PAYPAL_EXPRESS_CURL');
    }

    function sendTransactionToGateway($url, $parameters) {
      $server = parse_url($url);

      if (!isset($server['port'])) {
        $server['port'] = ($server['scheme'] == 'https') ? 443 : 80;
      }

      if (!isset($server['path'])) {
        $server['path'] = '/';
      }

      if (isset($server['user']) && isset($server['pass'])) {
        $header[] = 'Authorization: Basic ' . base64_encode($server['user'] . ':' . $server['pass']);
      }

      if (function_exists('curl_init')) {
        $curl = curl_init($server['scheme'] . '://' . $server['host'] . $server['path'] . (isset($server['query']) ? '?' . $server['query'] : ''));
        curl_setopt($curl, CURLOPT_PORT, $server['port']);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);

        $result = curl_exec($curl);

        curl_close($curl);
      } else {
        exec(escapeshellarg(MODULE_PAYMENT_PAYPAL_EXPRESS_CURL) . ' -d ' . escapeshellarg($parameters) . ' "' . $server['scheme'] . '://' . $server['host'] . $server['path'] . (isset($server['query']) ? '?' . $server['query'] : '') . '" -P ' . $server['port'] . ' -k', $result);
        $result = implode("\n", $result);
      }

      return $result;
    }

// format prices without currency formatting
    function format_raw($number, $currency_code = '', $currency_value = '') {
      global $currencies;

      if (empty($currency_code) || !$currencies->is_set($currency_code)) {
        $currency_code = $_SESSION['currency'];
      }

      if (empty($currency_value) || !is_numeric($currency_value)) {
        $currency_value = $currencies->currencies[$currency_code]['value'];
      }

      return number_format(osc_round($number * $currency_value, $currencies->currencies[$currency_code]['decimal_places']), $currencies->currencies[$currency_code]['decimal_places'], '.', '');
    }

    function getPalDetails() {
      if (MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTION_SERVER == 'Live') {
        $api_url = 'https://api-3t.paypal.com/nvp';
      } else {
        $api_url = 'https://api-3t.sandbox.paypal.com/nvp';
      }

      $params = array('VERSION' => $this->api_version,
                      'METHOD' => 'GetPalDetails',
                      'USER' => MODULE_PAYMENT_PAYPAL_EXPRESS_API_USERNAME,
                      'PWD' => MODULE_PAYMENT_PAYPAL_EXPRESS_API_PASSWORD,
                      'SIGNATURE' => MODULE_PAYMENT_PAYPAL_EXPRESS_API_SIGNATURE);

      $post_string = '';

      foreach ($params as $key => $value) {
        $post_string .= $key . '=' . urlencode(utf8_encode(trim($value))) . '&';
      }

      $post_string = substr($post_string, 0, -1);

      $response = $this->sendTransactionToGateway($api_url, $post_string);
      $response_array = array();
      parse_str($response, $response_array);

      if (!isset($response_array['PAL'])) {
        $this->sendDebugEmail();
      }

      return $response_array;
    }

    function setExpressCheckout($parameters) {
      if (MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTION_SERVER == 'Live') {
        $api_url = 'https://api-3t.paypal.com/nvp';
      } else {
        $api_url = 'https://api-3t.sandbox.paypal.com/nvp';
      }

      $params = array('VERSION' => $this->api_version,
                      'METHOD' => 'SetExpressCheckout',
                      'PAYMENTACTION' => ((MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTION_METHOD == 'Sale') || (!osc_not_null(MODULE_PAYMENT_PAYPAL_EXPRESS_API_USERNAME)) ? 'Sale' : 'Authorization'),
                      'RETURNURL' => osc_href_link('ext/modules/payment/paypal/express.php', 'osC_Action=retrieve', 'SSL', true, false),
                      'CANCELURL' => osc_href_link('ext/modules/payment/paypal/express.php', 'osC_Action=cancel', 'SSL', true, false));

      if (osc_not_null(MODULE_PAYMENT_PAYPAL_EXPRESS_API_USERNAME)) {
        $params['USER'] = MODULE_PAYMENT_PAYPAL_EXPRESS_API_USERNAME;
        $params['PWD'] = MODULE_PAYMENT_PAYPAL_EXPRESS_API_PASSWORD;
        $params['SIGNATURE'] = MODULE_PAYMENT_PAYPAL_EXPRESS_API_SIGNATURE;
      } else {
        $params['SUBJECT'] = MODULE_PAYMENT_PAYPAL_EXPRESS_SELLER_ACCOUNT;
      }

      if (MODULE_PAYMENT_PAYPAL_EXPRESS_ACCOUNT_OPTIONAL == 'True') {
        $params['SOLUTIONTYPE'] = 'Sole';
      }

      if (is_array($parameters) && !empty($parameters)) {
        $params = array_merge($params, $parameters);
      }

      $post_string = '';

      foreach ($params as $key => $value) {
        $post_string .= $key . '=' . urlencode(utf8_encode(trim($value))) . '&';
      }

      $post_string = substr($post_string, 0, -1);

      $response = $this->sendTransactionToGateway($api_url, $post_string);
      $response_array = array();
      parse_str($response, $response_array);

      if (($response_array['ACK'] != 'Success') && ($response_array['ACK'] != 'SuccessWithWarning')) {
        $this->sendDebugEmail();
      }

      return $response_array;
    }

    function getExpressCheckoutDetails($token) {
      if (MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTION_SERVER == 'Live') {
        $api_url = 'https://api-3t.paypal.com/nvp';
      } else {
        $api_url = 'https://api-3t.sandbox.paypal.com/nvp';
      }

      $params = array('VERSION' => $this->api_version,
                      'METHOD' => 'GetExpressCheckoutDetails',
                      'TOKEN' => $token);

      if (osc_not_null(MODULE_PAYMENT_PAYPAL_EXPRESS_API_USERNAME)) {
        $params['USER'] = MODULE_PAYMENT_PAYPAL_EXPRESS_API_USERNAME;
        $params['PWD'] = MODULE_PAYMENT_PAYPAL_EXPRESS_API_PASSWORD;
        $params['SIGNATURE'] = MODULE_PAYMENT_PAYPAL_EXPRESS_API_SIGNATURE;
      } else {
        $params['SUBJECT'] = MODULE_PAYMENT_PAYPAL_EXPRESS_SELLER_ACCOUNT;
      }

      $post_string = '';

      foreach ($params as $key => $value) {
        $post_string .= $key . '=' . urlencode(utf8_encode(trim($value))) . '&';
      }

      $post_string = substr($post_string, 0, -1);

      $response = $this->sendTransactionToGateway($api_url, $post_string);
      $response_array = array();
      parse_str($response, $response_array);

      if (($response_array['ACK'] != 'Success') && ($response_array['ACK'] != 'SuccessWithWarning')) {
        $this->sendDebugEmail();
      }

      return $response_array;
    }

    function doExpressCheckoutPayment($parameters) {
      if (MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTION_SERVER == 'Live') {
        $api_url = 'https://api-3t.paypal.com/nvp';
      } else {
        $api_url = 'https://api-3t.sandbox.paypal.com/nvp';
      }

      $params = array('VERSION' => $this->api_version,
                      'METHOD' => 'DoExpressCheckoutPayment',
                      'PAYMENTACTION' => ((MODULE_PAYMENT_PAYPAL_EXPRESS_TRANSACTION_METHOD == 'Sale') || (!osc_not_null(MODULE_PAYMENT_PAYPAL_EXPRESS_API_USERNAME)) ? 'Sale' : 'Authorization'),
                      'BUTTONSOURCE' => 'osCommerce22_Default_EC');

      if (osc_not_null(MODULE_PAYMENT_PAYPAL_EXPRESS_API_USERNAME)) {
        $params['USER'] = MODULE_PAYMENT_PAYPAL_EXPRESS_API_USERNAME;
        $params['PWD'] = MODULE_PAYMENT_PAYPAL_EXPRESS_API_PASSWORD;
        $params['SIGNATURE'] = MODULE_PAYMENT_PAYPAL_EXPRESS_API_SIGNATURE;
      } else {
        $params['SUBJECT'] = MODULE_PAYMENT_PAYPAL_EXPRESS_SELLER_ACCOUNT;
      }

      if (is_array($parameters) && !empty($parameters)) {
        $params = array_merge($params, $parameters);
      }

      $post_string = '';

      foreach ($params as $key => $value) {
        $post_string .= $key . '=' . urlencode(utf8_encode(trim($value))) . '&';
      }

      $post_string = substr($post_string, 0, -1);

      $response = $this->sendTransactionToGateway($api_url, $post_string);
      $response_array = array();
      parse_str($response, $response_array);

      if (($response_array['ACK'] != 'Success') && ($response_array['ACK'] != 'SuccessWithWarning')) {
        $this->sendDebugEmail();
      }

      return $response_array;
    }

    function sendDebugEmail() {
      if (osc_not_null(MODULE_PAYMENT_PAYPAL_EXPRESS_DEBUG_EMAIL)) {
        $email_body = '$_POST:' . "\n\n";

        foreach ($_POST as $key => $value) {
          $email_body .= $key . '=' . $value . "\n";
        }

        $email_body .= "\n" . '$_GET:' . "\n\n";

        foreach ($_GET as $key => $value) {
          $email_body .= $key . '=' . $value . "\n";
        }

        osc_mail('', MODULE_PAYMENT_PAYPAL_EXPRESS_DEBUG_EMAIL, 'PayPal Express Debug E-Mail', $email_body, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
      }
    }
  }
?>
