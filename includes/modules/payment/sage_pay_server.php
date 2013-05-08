<?php
/*
  $Id: $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  class sage_pay_server {
    var $code, $title, $description, $enabled;

// class constructor
    function sage_pay_server() {
      global $order;

      $this->signature = 'sage_pay|sage_pay_server|1.1|2.3';
      $this->api_version = '2.23';

      $this->code = 'sage_pay_server';
      $this->title = MODULE_PAYMENT_SAGE_PAY_SERVER_TEXT_TITLE;
      $this->public_title = MODULE_PAYMENT_SAGE_PAY_SERVER_TEXT_PUBLIC_TITLE;
      $this->description = MODULE_PAYMENT_SAGE_PAY_SERVER_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_SAGE_PAY_SERVER_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_SAGE_PAY_SERVER_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_SAGE_PAY_SERVER_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_SAGE_PAY_SERVER_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_SAGE_PAY_SERVER_ZONE > 0) ) {
        $check_flag = false;
        $check_query = osc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_SAGE_PAY_SERVER_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
        while ($check = osc_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->billing['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }

    function javascript_validation() {
      return false;
    }

    function selection() {
      return array('id' => $this->code,
                   'module' => $this->public_title);
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
      return false;
    }

    function process_button() {
      return false;
    }

    function before_process() {
      global $OSCOM_Customer, $order, $order_totals;

      $error = null;

      if (isset($_GET['check']) && ($_GET['check'] == 'SERVER')) {
        $sig = $_POST['VPSTxId'] . $_POST['VendorTxCode'] . $_POST['Status'];

        if ($_POST['Status'] == 'OK') {
          $sig .= $_POST['TxAuthNo'];
        }

        $sig .= substr(MODULE_PAYMENT_SAGE_PAY_SERVER_VENDOR_LOGIN_NAME, 0, 15);

        if ( ($_POST['Status'] != 'AUTHENTICATED') && ($_POST['Status'] != 'REGISTERED') ) {
          $sig .= $_POST['AVSCV2'];
        }

        $sig .= $_SESSION['sage_pay_server_securitykey'];

        if ( ($_POST['Status'] != 'AUTHENTICATED') && ($_POST['Status'] != 'REGISTERED') ) {
          $sig .= $_POST['AddressResult'] . $_POST['PostCodeResult'] . $_POST['CV2Result'];
        }

        $sig .= $_POST['GiftAid'] . $_POST['3DSecureStatus'];

        if ($_POST['3DSecureStatus'] == 'OK') {
          $sig .= $_POST['CAVV'];
        }

        if ( ($_POST['AddressStatus'] == 'NONE') || ($_POST['AddressStatus'] == 'CONFIRMED') || ($_POST['AddressStatus'] == 'UNCONFIRMED') ) {
          $sig .= $_POST['AddressStatus'];
        }

        if ( ($_POST['PayerStatus'] == 'VERIFIED') || ($_POST['PayerStatus'] == 'UNVERIFIED') ) {
          $sig .= $_POST['PayerStatus'];
        }

        if ( in_array($_POST['CardType'], array('VISA', 'MC', 'DELTA', 'SOLO', 'MAESTRO', 'UKE', 'AMEX', 'DC', 'JCB', 'SWITCH', 'LASER', 'PAYPAL')) ) {
          $sig .= $_POST['CardType'];
        }

        $sig .= $_POST['Last4Digits'];

        if (isset($_POST['VPSSignature']) && ($_POST['VPSSignature'] == strtoupper(md5($sig)))) {
          if ( ($_POST['Status'] != 'OK') && ($_POST['Status'] != 'AUTHENTICATED') && ($_POST['Status'] != 'REGISTERED') ) {
            unset($_SESSION['sage_pay_server_securitykey']);
            unset($_SESSION['sage_pay_server_nexturl']);

            $error = $this->getErrorMessageNumber($_POST['StatusDetail']);

            if ( MODULE_PAYMENT_SAGE_PAY_SERVER_PROFILE_PAGE == 'Normal' ) {
              $error_url = osc_href_link('checkout', 'payment&payment_error=' . $this->code . (osc_not_null($error) ? '&error=' . $error : '') . '&' . session_name() . '=' . session_id(), 'SSL', false);
            } else {
              $error_url = osc_href_link('ext/modules/payment/sage_pay/redirect.php', 'payment_error=' . $this->code . (osc_not_null($error) ? '&error=' . $error : '') . '&' . session_name() . '=' . session_id(), 'SSL', false);
            }

            $result = 'Status=OK' . chr(13) . chr(10) .
                      'RedirectURL=' . $this->formatURL($error_url);
          } else {
            $result = 'Status=OK' . chr(13) . chr(10) .
                      'RedirectURL=' . $this->formatURL(osc_href_link('checkout', 'process&check=PROCESS&key=' . md5($_SESSION['sage_pay_server_securitykey']) . '&VPSTxId=' . $_POST['VPSTxId'] . '&' . session_name() . '=' . session_id(), 'SSL', false));
          }
        } else {
          unset($_SESSION['sage_pay_server_securitykey']);
          unset($_SESSION['sage_pay_server_nexturl']);

          $error = $this->getErrorMessageNumber($_POST['StatusDetail']);

          if ( MODULE_PAYMENT_SAGE_PAY_SERVER_PROFILE_PAGE == 'Normal' ) {
            $error_url = osc_href_link('checkout', 'payment&payment_error=' . $this->code . (osc_not_null($error) ? '&error=' . $error : '') . '&' . session_name() . '=' . session_id(), 'SSL', false);
          } else {
            $error_url = osc_href_link('ext/modules/payment/sage_pay/redirect.php', 'payment_error=' . $this->code . (osc_not_null($error) ? '&error=' . $error : '') . '&' . session_name() . '=' . session_id(), 'SSL', false);
          }

          $result = 'Status=INVALID' . chr(13) . chr(10) .
                    'RedirectURL=' . $this->formatURL($error_url);
        }

        echo $result;
        exit;
      } elseif (isset($_GET['check']) && ($_GET['check'] == 'PROCESS')) {
        if ($_GET['key'] == md5($_SESSION['sage_pay_server_securitykey'])) {
          unset($_SESSION['sage_pay_server_securitykey']);
          unset($_SESSION['sage_pay_server_nexturl']);

          if ( isset($_GET['VPSTxId']) ) {
            $order->info['comments'] = 'Sage Pay Reference ID: ' . $_GET['VPSTxId'] . (osc_not_null($order->info['comments']) ? "\n\n" . $order->info['comments'] : '');
          }

          return true;
        }
      } else {
        $params = array('VPSProtocol' => $this->api_version,
                        'ReferrerID' => 'C74D7B82-E9EB-4FBD-93DB-76F0F551C802',
                        'Vendor' => substr(MODULE_PAYMENT_SAGE_PAY_SERVER_VENDOR_LOGIN_NAME, 0, 15),
                        'VendorTxCode' => substr(date('YmdHis') . '-' . $OSCOM_Customer->getID() . '-' . $_SESSION['cartID'], 0, 40),
                        'Amount' => $this->format_raw($order->info['total']),
                        'Currency' => $_SESSION['currency'],
                        'Description' => substr(STORE_NAME, 0, 100),
                        'NotificationURL' => $this->formatURL(osc_href_link('checkout', 'process&check=SERVER&' . session_name() . '=' . session_id(), 'SSL', false)),
                        'BillingSurname' => substr($order->billing['lastname'], 0, 20),
                        'BillingFirstnames' => substr($order->billing['firstname'], 0, 20),
                        'BillingAddress1' => substr($order->billing['street_address'], 0, 100),
                        'BillingCity' => substr($order->billing['city'], 0, 40),
                        'BillingPostCode' => substr($order->billing['postcode'], 0, 10),
                        'BillingCountry' => $order->billing['country']['iso_code_2'],
                        'BillingPhone' => substr($order->customer['telephone'], 0, 20),
                        'DeliverySurname' => substr($order->delivery['lastname'], 0, 20),
                        'DeliveryFirstnames' => substr($order->delivery['firstname'], 0, 20),
                        'DeliveryAddress1' => substr($order->delivery['street_address'], 0, 100),
                        'DeliveryCity' => substr($order->delivery['city'], 0, 40),
                        'DeliveryPostCode' => substr($order->delivery['postcode'], 0, 10),
                        'DeliveryCountry' => $order->delivery['country']['iso_code_2'],
                        'DeliveryPhone' => substr($order->customer['telephone'], 0, 20),
                        'CustomerEMail' => substr($order->customer['email_address'], 0, 255),
                        'Apply3DSecure' => '0');

        $ip_address = osc_get_ip_address();

        if ( (ip2long($ip_address) != -1) && (ip2long($ip_address) != false) ) {
          $params['ClientIPAddress']= $ip_address;
        }

        if ( MODULE_PAYMENT_SAGE_PAY_SERVER_TRANSACTION_METHOD == 'Payment' ) {
          $params['TxType'] = 'PAYMENT';
        } elseif ( MODULE_PAYMENT_SAGE_PAY_SERVER_TRANSACTION_METHOD == 'Deferred' ) {
          $params['TxType'] = 'DEFERRED';
        } else {
          $params['TxType'] = 'AUTHENTICATE';
        }

        if ($params['BillingCountry'] == 'US') {
          $params['BillingState'] = osc_get_zone_code($order->billing['country']['id'], $order->billing['zone_id'], '');
        }

        if ($params['DeliveryCountry'] == 'US') {
          $params['DeliveryState'] = osc_get_zone_code($order->delivery['country']['id'], $order->delivery['zone_id'], '');
        }

        if ( MODULE_PAYMENT_SAGE_PAY_SERVER_PROFILE_PAGE != 'Normal' ) {
          $params['Profile'] = 'LOW';
        }

        $contents = array();

        foreach ($order->products as $product) {
          $product_name = $product['name'];

          if (isset($product['attributes'])) {
            foreach ($product['attributes'] as $att) {
              $product_name .= '; ' . $att['option'] . '=' . $att['value'];
            }
          }

          $contents[] = str_replace(array(':', "\n", "\r", '&'), '', $product_name) . ':' . $product['qty'] . ':' . $this->format_raw($product['final_price']) . ':' . $this->format_raw(($product['tax'] / 100) * $product['final_price']) . ':' . $this->format_raw((($product['tax'] / 100) * $product['final_price']) + $product['final_price']) . ':' . $this->format_raw(((($product['tax'] / 100) * $product['final_price']) + $product['final_price']) * $product['qty']);
        }

        foreach ($order_totals as $ot) {
          $contents[] = str_replace(array(':', "\n", "\r", '&'), '', strip_tags($ot['title'])) . ':---:---:---:---:' . $this->format_raw($ot['value']);
        }

        $params['Basket'] = substr(sizeof($contents) . ':' . implode(':', $contents), 0, 7500);

        $post_string = '';

        foreach ($params as $key => $value) {
          $post_string .= $key . '=' . urlencode(trim($value)) . '&';
        }

        switch (MODULE_PAYMENT_SAGE_PAY_SERVER_TRANSACTION_SERVER) {
          case 'Live':
            $gateway_url = 'https://live.sagepay.com/gateway/service/vspserver-register.vsp';
            break;

          case 'Test':
            $gateway_url = 'https://test.sagepay.com/gateway/service/vspserver-register.vsp';
            break;

          default:
            $gateway_url = 'https://test.sagepay.com/Simulator/VSPServerGateway.asp?Service=VendorRegisterTx';
            break;
        }

        $transaction_response = $this->sendTransactionToGateway($gateway_url, $post_string);

        $string_array = explode(chr(10), $transaction_response);
        $return = array();

        foreach ($string_array as $string) {
          if (strpos($string, '=') != false) {
            $parts = explode('=', $string, 2);
            $return[trim($parts[0])] = trim($parts[1]);
          }
        }

        if ($return['Status'] == 'OK') {
          $_SESSION['sage_pay_server_securitykey'] = $return['SecurityKey'];

          $_SESSION['sage_pay_server_nexturl'] = $return['NextURL'];

          if ( MODULE_PAYMENT_SAGE_PAY_SERVER_PROFILE_PAGE == 'Normal' ) {
            osc_redirect($return['NextURL']);
          } else {
            osc_redirect(osc_href_link('ext/modules/payment/sage_pay/checkout.php', '', 'SSL'));
          }
        } else {
          $error = $this->getErrorMessageNumber($return['StatusDetail']);
        }
      }

      unset($_SESSION['sage_pay_server_securitykey']);
      unset($_SESSION['sage_pay_server_nexturl']);

      osc_redirect(osc_href_link('checkout', 'payment&payment_error=' . $this->code . (osc_not_null($error) ? '&error=' . $error : ''), 'SSL'));
    }

    function after_process() {
      $_SESSION['cart']->reset(true);

// unregister session variables used during checkout
      unset($_SESSION['sendto']);
      unset($_SESSION['billto']);
      unset($_SESSION['shipping']);
      unset($_SESSION['payment']);
      unset($_SESSION['comments']);

      osc_redirect(osc_href_link('ext/modules/payment/sage_pay/redirect.php', '', 'SSL'));
    }

    function get_error() {
      $message = MODULE_PAYMENT_SAGE_PAY_SERVER_ERROR_GENERAL;

      if ( isset($_GET['error']) && is_numeric($_GET['error']) && $this->errorMessageNumberExists($_GET['error']) ) {
        $message = $this->getErrorMessage($_GET['error']) . ' ' . MODULE_PAYMENT_SAGE_PAY_SERVER_ERROR_GENERAL;
      }

      $error = array('title' => MODULE_PAYMENT_SAGE_PAY_SERVER_ERROR_TITLE,
                     'error' => $message);

      return $error;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = osc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SAGE_PAY_SERVER_STATUS'");
        $this->_check = osc_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Sage Pay Server Module', 'MODULE_PAYMENT_SAGE_PAY_SERVER_STATUS', 'False', 'Do you want to accept Sage Pay Server payments?', '6', '0', 'osc_cfg_select_option(array(\'True\', \'False\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Vendor Login Name', 'MODULE_PAYMENT_SAGE_PAY_SERVER_VENDOR_LOGIN_NAME', '', 'The vendor login name to connect to the gateway with.', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Profile Payment Page', 'MODULE_PAYMENT_SAGE_PAY_SERVER_PROFILE_PAGE', 'Normal', 'Profile page to use for the payment page.', '6', '0', 'osc_cfg_select_option(array(\'Normal\', \'Low\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Transaction Method', 'MODULE_PAYMENT_SAGE_PAY_SERVER_TRANSACTION_METHOD', 'Authenticate', 'The processing method to use for each transaction.', '6', '0', 'osc_cfg_select_option(array(\'Authenticate\', \'Deferred\', \'Payment\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Transaction Server', 'MODULE_PAYMENT_SAGE_PAY_SERVER_TRANSACTION_SERVER', 'Simulator', 'Perform transactions on the production server or on the testing server.', '6', '0', 'osc_cfg_select_option(array(\'Live\', \'Test\', \'Simulator\'), ', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display.', 'MODULE_PAYMENT_SAGE_PAY_SERVER_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Payment Zone', 'MODULE_PAYMENT_SAGE_PAY_SERVER_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'osc_get_zone_class_title', 'osc_cfg_pull_down_zone_classes(', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Order Status', 'MODULE_PAYMENT_SAGE_PAY_SERVER_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'osc_cfg_pull_down_order_statuses(', 'osc_get_order_status_name', now())");
      osc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('cURL Program Location', 'MODULE_PAYMENT_SAGE_PAY_SERVER_CURL', '/usr/bin/curl', 'The location to the cURL program application.', '6', '0' , now())");
    }

    function remove() {
      osc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_SAGE_PAY_SERVER_STATUS', 'MODULE_PAYMENT_SAGE_PAY_SERVER_VENDOR_LOGIN_NAME', 'MODULE_PAYMENT_SAGE_PAY_SERVER_PROFILE_PAGE', 'MODULE_PAYMENT_SAGE_PAY_SERVER_TRANSACTION_METHOD', 'MODULE_PAYMENT_SAGE_PAY_SERVER_TRANSACTION_SERVER', 'MODULE_PAYMENT_SAGE_PAY_SERVER_ZONE', 'MODULE_PAYMENT_SAGE_PAY_SERVER_ORDER_STATUS_ID', 'MODULE_PAYMENT_SAGE_PAY_SERVER_SORT_ORDER', 'MODULE_PAYMENT_SAGE_PAY_SERVER_CURL');
    }

    function sendTransactionToGateway($url, $parameters) {
      $server = parse_url($url);

      if (isset($server['port']) === false) {
        $server['port'] = ($server['scheme'] == 'https') ? 443 : 80;
      }

      if (isset($server['path']) === false) {
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
        exec(escapeshellarg(MODULE_PAYMENT_SAGE_PAY_SERVER_CURL) . ' -d ' . escapeshellarg($parameters) . ' "' . $server['scheme'] . '://' . $server['host'] . $server['path'] . (isset($server['query']) ? '?' . $server['query'] : '') . '" -P ' . $server['port'] . ' -k', $result);
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

    function loadErrorMessages() {
      $errors = array();

      if (file_exists(dirname(__FILE__) . '/../../../ext/modules/payment/sage_pay/errors.php')) {
        include(dirname(__FILE__) . '/../../../ext/modules/payment/sage_pay/errors.php');
      }

      $this->_error_messages = $errors;
    }

    function getErrorMessageNumber($string) {
      if (!isset($this->_error_messages)) {
        $this->loadErrorMessages();
      }

      $error = explode(' ', $string, 2);

      if (is_numeric($error[0]) && $this->errorMessageNumberExists($error[0])) {
        return $error[0];
      }

      return false;
    }

    function getErrorMessage($number) {
      if (!isset($this->_error_messages)) {
        $this->loadErrorMessages();
      }

      if (is_numeric($number) && $this->errorMessageNumberExists($number)) {
        return $this->_error_messages[$number];
      }

      return false;
    }

    function errorMessageNumberExists($number) {
      if (!isset($this->_error_messages)) {
        $this->loadErrorMessages();
      }

      return (is_numeric($number) && isset($this->_error_messages[$number]));
    }

    function formatURL($url) {
      return str_replace('&amp;', '&', $url);
    }
  }
?>
