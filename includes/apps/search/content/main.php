<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
?>

<script type="text/javascript" src="public/template/<?php echo $OSCOM_Template->getCode(); ?>/js/general.js"></script>
<script type="text/javascript"><!--
function check_form() {
  var error_message = "<?php echo JS_ERROR; ?>";
  var error_found = false;
  var error_field;
  var keywords = document.advanced_search.keywords.value;
  var dfrom = document.advanced_search.dfrom.value;
  var dto = document.advanced_search.dto.value;
  var pfrom = document.advanced_search.pfrom.value;
  var pto = document.advanced_search.pto.value;
  var pfrom_float;
  var pto_float;

  if ( ((keywords == '') || (keywords.length < 1)) && ((dfrom == '') || (dfrom.length < 1)) && ((dto == '') || (dto.length < 1)) && ((pfrom == '') || (pfrom.length < 1)) && ((pto == '') || (pto.length < 1)) ) {
    error_message = error_message + "* <?php echo ERROR_AT_LEAST_ONE_INPUT; ?>\n";
    error_field = document.advanced_search.keywords;
    error_found = true;
  }

  if (dfrom.length > 0) {
    if (!IsValidDate(dfrom, '<?php echo DOB_FORMAT_STRING; ?>')) {
      error_message = error_message + "* <?php echo ERROR_INVALID_FROM_DATE; ?>\n";
      error_field = document.advanced_search.dfrom;
      error_found = true;
    }
  }

  if (dto.length > 0) {
    if (!IsValidDate(dto, '<?php echo DOB_FORMAT_STRING; ?>')) {
      error_message = error_message + "* <?php echo ERROR_INVALID_TO_DATE; ?>\n";
      error_field = document.advanced_search.dto;
      error_found = true;
    }
  }

  if ((dfrom.length > 0) && (IsValidDate(dfrom, '<?php echo DOB_FORMAT_STRING; ?>')) && (dto.length > 0) && (IsValidDate(dto, '<?php echo DOB_FORMAT_STRING; ?>'))) {
    if (!CheckDateRange(document.advanced_search.dfrom, document.advanced_search.dto)) {
      error_message = error_message + "* <?php echo ERROR_TO_DATE_LESS_THAN_FROM_DATE; ?>\n";
      error_field = document.advanced_search.dto;
      error_found = true;
    }
  }

  if (pfrom.length > 0) {
    pfrom_float = parseFloat(pfrom);
    if (isNaN(pfrom_float)) {
      error_message = error_message + "* <?php echo ERROR_PRICE_FROM_MUST_BE_NUM; ?>\n";
      error_field = document.advanced_search.pfrom;
      error_found = true;
    }
  } else {
    pfrom_float = 0;
  }

  if (pto.length > 0) {
    pto_float = parseFloat(pto);
    if (isNaN(pto_float)) {
      error_message = error_message + "* <?php echo ERROR_PRICE_TO_MUST_BE_NUM; ?>\n";
      error_field = document.advanced_search.pto;
      error_found = true;
    }
  } else {
    pto_float = 0;
  }

  if ( (pfrom.length > 0) && (pto.length > 0) ) {
    if ( (!isNaN(pfrom_float)) && (!isNaN(pto_float)) && (pto_float < pfrom_float) ) {
      error_message = error_message + "* <?php echo ERROR_PRICE_TO_LESS_THAN_PRICE_FROM; ?>\n";
      error_field = document.advanced_search.pto;
      error_found = true;
    }
  }

  if (error_found == true) {
    alert(error_message);
    error_field.focus();
    return false;
  } else {
    return true;
  }
}
//--></script>

<h1><?php echo HEADING_TITLE_1; ?></h1>

<?php
  if ( $OSCOM_MessageStack->exists('search') ) {
    echo $OSCOM_MessageStack->get('search');
  }
?>

<?php echo osc_draw_form('advanced_search', osc_href_link(), 'get', 'onsubmit="return check_form(this);"') . osc_draw_hidden_field('search', ''); ?>

<div class="contentContainer">
  <h2><?php echo HEADING_SEARCH_CRITERIA; ?></h2>

  <div class="contentText">
    <div>
      <?php echo osc_draw_input_field('q', '', 'style="width: 100%"'); ?>
    </div>

    <div>
      <span><?php echo '<a href="#helpSearch" role="button" class="btn btn-link" data-toggle="modal">' . TEXT_SEARCH_HELP_LINK . '</a>'; ?></span>
      <span style="float: right;"><?php echo osc_hide_session_id() . osc_draw_button(IMAGE_BUTTON_SEARCH, 'search', null, 'success'); ?></span>
    </div>

    <div id="helpSearch" class="modal hide" role="dialog" tabindex="-1" aria-labelledby="helpSearchLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><?php echo HEADING_SEARCH_HELP; ?></h3>
      </div>
      <div class="modal-body">
        <p><?php echo TEXT_SEARCH_HELP; ?></p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div>

    <br />

    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td class="fieldKey"><?php echo ENTRY_CATEGORIES; ?></td>
        <td class="fieldValue"><?php echo osc_draw_pull_down_menu('categories_id', osc_get_categories(array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES)))); ?></td>
      </tr>
      <tr>
        <td class="fieldKey">&nbsp;</td>
        <td class="smallText"><?php echo osc_draw_checkbox_field('inc_subcat', '1', true) . ' ' . ENTRY_INCLUDE_SUBCATEGORIES; ?></td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo ENTRY_MANUFACTURERS; ?></td>
        <td class="fieldValue"><?php echo osc_draw_pull_down_menu('manufacturers_id', osc_get_manufacturers(array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS)))); ?></td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo ENTRY_PRICE_FROM; ?></td>
        <td class="fieldValue"><?php echo osc_draw_input_field('pfrom'); ?></td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo ENTRY_PRICE_TO; ?></td>
        <td class="fieldValue"><?php echo osc_draw_input_field('pto'); ?></td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo ENTRY_DATE_FROM; ?></td>
        <td class="fieldValue"><?php echo osc_draw_input_field('dfrom', '', 'id="dfrom"'); ?><script type="text/javascript">$('#dfrom').datepicker({dateFormat: '<?php echo JQUERY_DATEPICKER_FORMAT; ?>', changeMonth: true, changeYear: true, yearRange: '-10:+0'});</script></td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo ENTRY_DATE_TO; ?></td>
        <td class="fieldValue"><?php echo osc_draw_input_field('dto', '', 'id="dto"'); ?><script type="text/javascript">$('#dto').datepicker({dateFormat: '<?php echo JQUERY_DATEPICKER_FORMAT; ?>', changeMonth: true, changeYear: true, yearRange: '-10:+0'});</script></td>
      </tr>
    </table>
  </div>
</div>

</form>
