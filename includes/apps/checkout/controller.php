<?php
/**
 * osCommerce Online Merchant
 * 
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'http_client.php');
  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'order.php');
  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'order_total.php');
  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'payment.php');
  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'shipping.php');

  class app_checkout extends app {
    public function __construct() {
      global $OSCOM_Customer, $OSCOM_NavigationHistory, $OSCOM_PDO, $order, $OSCOM_Breadcrumb, $payment_modules, $shipping_modules, $order_total_modules, $order_totals, $any_out_of_stock;

// if there is nothing in the customers cart, redirect them to the shopping cart page
      if ( $_SESSION['cart']->count_contents() < 1 ) {
        osc_redirect(osc_href_link('cart'));
      }

// if the customer is not logged on, redirect them to the login page
      if ( !$OSCOM_Customer->isLoggedOn() ) {
        $OSCOM_NavigationHistory->setSnapshot();

        osc_redirect(osc_href_link('account', 'login', 'SSL'));
      }

// Stock Check
      $any_out_of_stock = false;

      if ( STOCK_CHECK == 'true' ) {
        foreach ( $_SESSION['cart']->get_products() as $p ) {
          if ( osc_check_stock($p['id'], $p['quantity']) ) {
            $any_out_of_stock = true;
            break;
          }
        }

// Out of Stock
        if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock == true) ) {
          osc_redirect(osc_href_link('cart'));
        }
      }

// no shipping is needed if the order contains only virtual products
      if ( $_SESSION['cart']->get_content_type() == 'virtual' ) {
        $_SESSION['shipping'] = false;
        $_SESSION['sendto'] = false;
      }

      $OSCOM_Breadcrumb->add(NAVBAR_TITLE, osc_href_link('checkout', '', 'SSL'));

      if ( $OSCOM_Customer->hasDefaultAddress() ) {
// if no shipping destination address was selected, use the customers own address as default
        if ( !isset($_SESSION['sendto']) ) {
          $_SESSION['sendto'] = $OSCOM_Customer->getDefaultAddressID();
        } else {
// verify the selected shipping address
          if ( is_numeric($_SESSION['sendto']) ) {
            $Qcheck = $OSCOM_PDO->prepare('select address_book_id from :table_address_book where address_book_id = :address_book_id and customers_id = :customers_id');
            $Qcheck->bindInt(':address_book_id', $_SESSION['sendto']);
            $Qcheck->bindInt(':customers_id', $OSCOM_Customer->getID());
            $Qcheck->execute();

            if ( $Qcheck->fetch() === false ) {
              $_SESSION['sendto'] = $OSCOM_Customer->getDefaultAddressID();

              if ( isset($_SESSION['shipping']) ) {
                unset($_SESSION['shipping']);
              }
            }
          }
        }

// if no billing destination address was selected, use the customers own address as default
        if ( !isset($_SESSION['billto']) ) {
          $_SESSION['billto'] = $OSCOM_Customer->getDefaultAddressID();
        } else {
// verify the selected billing address
          if ( is_numeric($_SESSION['billto']) ) {
            $Qcheck = $OSCOM_PDO->prepare('select address_book_id from :table_address_book where address_book_id = :address_book_id and customers_id = :customers_id');
            $Qcheck->bindInt(':address_book_id', $_SESSION['billto']);
            $Qcheck->bindInt(':customers_id', $OSCOM_Customer->getID());
            $Qcheck->execute();

            if ( $Qcheck->fetch() === false ) {
              $_SESSION['billto'] = $OSCOM_Customer->getDefaultAddressID();

              if ( isset($_SESSION['payment']) ) {
                unset($_SESSION['payment']);
              }
            }
          }
        }

// avoid hack attempts during the checkout procedure by checking the internal cartID
        if ( isset($_SESSION['cart']->cartID) && isset($_SESSION['cartID']) && ($_SESSION['cart']->cartID != $_SESSION['cartID']) && !isset($_GET['shipping']) ) {
          osc_redirect(osc_href_link('checkout', 'shipping', 'SSL'));
        }

// if no shipping method has been selected, redirect the customer to the shipping method selection page
        if ( !isset($_GET['shipping']) ) {
          if ( !isset($_SESSION['shipping']) ) {
            osc_redirect(osc_href_link('checkout', 'shipping', 'SSL'));
          }

// if no payment method has been selected, redirect the customer to the payment method selection page
          if ( !isset($_SESSION['payment']) && !isset($_GET['payment']) ) {
            osc_redirect(osc_href_link('checkout', 'payment', 'SSL'));
          }
        }

        $order = new order();

        if ( !isset($_GET['shipping']) && !isset($_GET['payment']) && isset($_SESSION['shipping']) && isset($_SESSION['payment']) ) {
// load the selected payment module
          $payment_modules = new payment($_SESSION['payment']);

          $order->cart();

          $payment_modules->update_status();

          if ( (is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($GLOBALS[$_SESSION['payment']])) || (is_object($GLOBALS[$_SESSION['payment']]) && ($GLOBALS[$_SESSION['payment']]->enabled == false)) ) {
            unset($_SESSION['payment']);

            osc_redirect(osc_href_link('checkout', 'payment&error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
          }

          if ( is_array($payment_modules->modules) ) {
            $payment_modules->pre_confirmation_check();
          }

// load the selected shipping module
          $shipping_modules = new shipping($_SESSION['shipping']);

          $order_total_modules = new order_total;
          $order_totals = $order_total_modules->process();

          $OSCOM_Breadcrumb->add(NAVBAR_TITLE_CONFIRMATION);
        }
      } else {
// No customer default address
        if ( !isset($_GET['shipping']) && !isset($_GET['payment']) ) {
          if ( !isset($_SESSION['sendto']) ) {
            osc_redirect(osc_href_link('checkout', 'shipping&address', 'SSL'));
          } elseif ( !isset($_SESSION['billto']) ) {
            osc_redirect(osc_href_link('checkout', 'payment&address', 'SSL'));
          }
        }
      }
    }
  }
?>
