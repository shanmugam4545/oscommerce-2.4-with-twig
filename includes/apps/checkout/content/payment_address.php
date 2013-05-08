<?php
/**
 * osCommerce Online Merchant
 * 
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
?>

<script type="text/javascript"><!--
var selected;

function selectRowEffect(object, buttonSelect) {
  if (!selected) {
    if (document.getElementById) {
      selected = document.getElementById('defaultSelected');
    } else {
      selected = document.all['defaultSelected'];
    }
  }

  if (selected) selected.className = 'moduleRow';
  object.className = 'moduleRowSelected';
  selected = object;

// one button is not an array
  if (document.checkout_address.address[0]) {
    document.checkout_address.address[buttonSelect].checked=true;
  } else {
    document.checkout_address.address.checked=true;
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}

function check_form_optional(form_name) {
  var form = form_name;

  var firstname = form.elements['firstname'].value;
  var lastname = form.elements['lastname'].value;
  var street_address = form.elements['street_address'].value;

  if (firstname == '' && lastname == '' && street_address == '') {
    return true;
  } else {
    return check_form(form_name);
  }
}
//--></script>

<?php require(DIR_WS_INCLUDES . 'form_check.js.php'); ?>

<h1><?php echo HEADING_TITLE_PAYMENT_ADDRESS; ?></h1>

<?php
  if ( $OSCOM_MessageStack->exists('checkout_address') ) {
    echo $OSCOM_MessageStack->get('checkout_address');
  }
?>

<?php echo osc_draw_form('checkout_address', osc_href_link('checkout', 'payment&address&process', 'SSL'), 'post', 'onsubmit="return check_form_optional(checkout_address);" class="form-horizontal"', true); ?>

<div class="contentContainer">

<?php
  if ( $OSCOM_Customer->hasDefaultAddress() ) {
    if ($process == false) {
?>

  <h2><?php echo TABLE_HEADING_PAYMENT_ADDRESS; ?></h2>

  <div class="contentText">
    <div class="ui-widget infoBoxContainer" style="float: right;">
      <div class="ui-widget-header infoBoxHeading"><?php echo TITLE_PAYMENT_ADDRESS; ?></div>

      <div class="ui-widget-content infoBoxContents">
        <?php echo osc_address_label($OSCOM_Customer->getID(), $_SESSION['billto'], true, ' ', '<br />'); ?>
      </div>
    </div>

    <?php echo TEXT_SELECTED_PAYMENT_DESTINATION; ?>
  </div>

  <div style="clear: both;"></div>

<?php
      if ($addresses_count > 1) {
?>

  <h2><?php echo TABLE_HEADING_ADDRESS_BOOK_ENTRIES; ?></h2>

  <div class="contentText">
    <div style="float: right;">
      <?php echo '<strong>' . TITLE_PLEASE_SELECT . '</strong>'; ?>
    </div>

    <?php echo TEXT_SELECT_OTHER_PAYMENT_DESTINATION; ?>
  </div>

  <div class="contentText">
    <table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
        $radio_buttons = 0;

        $addresses_query = osc_db_query("select address_book_id, entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$OSCOM_Customer->getID() . "'");
        while ($addresses = osc_db_fetch_array($addresses_query)) {
          $format_id = osc_get_address_format_id($addresses['country_id']);

         if ($addresses['address_book_id'] == $_SESSION['billto']) {
            echo '      <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
          } else {
            echo '      <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
          }
?>

        <td><strong><?php echo $addresses['firstname'] . ' ' . $addresses['lastname']; ?></strong></td>
        <td align="right"><?php echo osc_draw_radio_field('address', $addresses['address_book_id'], ($addresses['address_book_id'] == $_SESSION['billto'])); ?></td>
      </tr>
      <tr>
        <td colspan="2" style="padding-left: 15px;"><?php echo osc_address_format($format_id, $addresses, true, ' ', ', '); ?></td>
      </tr>

<?php
          $radio_buttons++;
        }
?>

    </table>
  </div>

<?php
      }
    }
  }

  if ($addresses_count < MAX_ADDRESS_BOOK_ENTRIES) {
?>

  <h2><?php echo TABLE_HEADING_NEW_PAYMENT_ADDRESS; ?></h2>

  <div class="contentText">
    <?php echo TEXT_CREATE_NEW_PAYMENT_ADDRESS; ?>
  </div>

  <?php require(DIR_WS_MODULES . 'checkout_new_address.php'); ?>

<?php
  }
?>

  <div class="contentText">
    <div style="float: left; width: 60%; padding-top: 5px; padding-left: 15%;">
      <div class="progress">
        <div class="bar" style="width: 66%;"></div>
      </div>

      <table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
          <td align="center" width="33%" class="checkoutBarFrom"><?php echo '<a href="' . osc_href_link('checkout', 'shipping', 'SSL') . '" class="checkoutBarFrom">' . CHECKOUT_BAR_DELIVERY . '</a>'; ?></td>
          <td align="center" width="33%" class="checkoutBarCurrent"><?php echo '<a href="' . osc_href_link('checkout', 'payment', 'SSL') . '" class="checkoutBarCurrent">' . CHECKOUT_BAR_PAYMENT . '</a>'; ?></td>
          <td align="center" width="33%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>
        </tr>
      </table>
    </div>

    <div style="float: right;"><?php echo osc_draw_button(IMAGE_BUTTON_CONTINUE, 'ok-sign', null, 'success'); ?></div>
  </div>

<?php
  if ($process == true) {
?>

  <div class="contentText">
    <?php echo osc_draw_button(IMAGE_BUTTON_BACK, 'arrow-left', osc_href_link('checkout', 'payment&address', 'SSL')); ?>
  </div>

<?php
  }
?>

</div>

</form>
