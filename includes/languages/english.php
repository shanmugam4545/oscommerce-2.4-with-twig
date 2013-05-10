<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

// look in your $PATH_LOCALE/locale directory for available locales
// or type locale -a on the server.
// Examples:
// on RedHat try 'en_US'
// on FreeBSD try 'en_US.ISO_8859-1'
// on Windows try 'en', or 'English'
@setlocale(LC_TIME, 'en_US.ISO_8859-1');

define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('JQUERY_DATEPICKER_I18N_CODE', ''); // leave empty for en_US; see http://jqueryui.com/demos/datepicker/#localization
define('JQUERY_DATEPICKER_FORMAT', 'mm/dd/yy'); // see http://docs.jquery.com/UI/Datepicker/formatDate

define('BOOTSTRAP_DATEPICKER_I18N_CODE', null); // by default day/month/year are in english !
define('BOOTSTRAP_DATEPICKER_FORMAT', 'mm/dd/yyyy');

define('BOOTSTRAP_COUNTRIES_FORMAT', 'en_US');
define('BOOTSTRAP_STATES_FORMAT', 'en_US');
define('BOOTSTRAP_CURRENCIES_FORMAT', 'en_US');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function osc_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'USD');

// Global entries for the <html> tag
define('HTML_PARAMS', 'dir="ltr" lang="en"');

// charset for web pages and emails
define('CHARSET', 'utf-8');

// page title
define('TITLE', STORE_NAME);

// header text in includes/header.php
define('HEADER_TITLE_CREATE_ACCOUNT', 'Create an Account');
define('HEADER_TITLE_MY_ACCOUNT', 'My Account');
define('HEADER_TITLE_CART_CONTENTS', 'Cart Contents');
define('HEADER_TITLE_CHECKOUT', 'Checkout');
define('HEADER_TITLE_TOP', '<i class="icon-fa-home icon-large"></i> Home');
define('HEADER_TITLE_CATALOG', 'Catalog');
define('HEADER_TITLE_LOGOFF', 'Log Off');
define('HEADER_TITLE_LOGIN', 'Log In');
define('HEADER_TITLE_SIGNUP', 'Sign Up');
define('HEADER_TITLE_CART', 'Cart');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'requests since');

// text for gender
define('MALE', 'Male');
define('FEMALE', 'Female');
define('MALE_ADDRESS', 'Mr.');
define('FEMALE_ADDRESS', 'Ms.');

// text for date of birth example
define('DOB_FORMAT_STRING', 'mm/dd/yyyy');

// checkout procedure text
define('CHECKOUT_BAR_DELIVERY', 'Delivery Information');
define('CHECKOUT_BAR_PAYMENT', 'Payment Information');
define('CHECKOUT_BAR_CONFIRMATION', 'Confirmation');
define('CHECKOUT_BAR_FINISHED', 'Finished!');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Please Select');
define('TYPE_BELOW', 'Type Below');

// javascript messages
define('JS_ERROR', 'Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n');

define('JS_REVIEW_TEXT', '* The \'Review Text\' must have at least ' . REVIEW_TEXT_MIN_LENGTH . ' characters.\n');
define('JS_REVIEW_RATING', '* You must rate the product for your review.\n');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Please select a payment method for your order.\n');

define('JS_ERROR_SUBMITTED', 'This form has already been submitted. Please press Ok and wait for this process to be completed.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Please select a payment method for your order.');

define('CATEGORY_COMPANY', 'Company Details');
define('CATEGORY_PERSONAL', 'Your Personal Details');
define('CATEGORY_ADDRESS', 'Your Address');
define('CATEGORY_CONTACT', 'Your Contact Information');
define('CATEGORY_OPTIONS', 'Options');
define('CATEGORY_PASSWORD', 'Your Password');
define('CATEGORY_LOGIN','Informations for login');


define('ENTRY_COMPANY', 'Company Name:');
define('PLACEHOLDER_ENTRY_COMPANY', 'Your Company Name');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Gender:');
define('ENTRY_GENDER_ERROR', 'Please select your Gender.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'First Name:');
define('ENTRY_FIRST_NAME_ERROR', 'Your First Name must contain a minimum of ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' characters.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Last Name:');
define('ENTRY_LAST_NAME_ERROR', 'Your Last Name must contain a minimum of ' . ENTRY_LAST_NAME_MIN_LENGTH . ' characters.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Date of Birth:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Your Date of Birth must be in this format: MM/DD/YYYY (eg 05/21/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (eg. 05/21/1970)');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail Address:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Your E-Mail Address must contain a minimum of ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' characters.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Your E-Mail Address does not appear to be valid - please make any necessary corrections.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Your E-Mail Address already exists in our records - please log in with the e-mail address or create an account with a different address.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Street Address:');
define('PLACEHOLDER_ENTRY_STREET_ADDRESS', 'Your Address');
define('ENTRY_STREET_ADDRESS_ERROR', 'Your Street Address must contain a minimum of ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' characters.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Suburb:');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_SUBURB_ERROR', 'Your personnal street details.');
define('PLACEHOLDER_ENTRY_SUBURB', 'Address Details');
define('ENTRY_POST_CODE', 'Post Code:');
define('ENTRY_POST_CODE_ERROR', 'Your Post Code must contain a minimum of ' . ENTRY_POSTCODE_MIN_LENGTH . ' characters.');
define('ENTRY_POST_CODE_TEXT', '*');
define('PLACEHOLDER_ENTRY_POSTCODE', 'Your postcode');
define('ENTRY_CITY', 'City:');
define('ENTRY_CITY_ERROR', 'Your City must contain a minimum of ' . ENTRY_CITY_MIN_LENGTH . ' characters.');
define('ENTRY_CITY_TEXT', '*');
define('PLACEHOLDER_ENTRY_CITY', 'Your City');
define('ENTRY_STATE', 'State/Province:');
define('ENTRY_STATE_ERROR', 'Your State must contain a minimum of ' . ENTRY_STATE_MIN_LENGTH . ' characters.');
define('ENTRY_STATE_ERROR_SELECT', 'Please select a state from the States pull down menu.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Country:');
define('ENTRY_COUNTRY_ERROR', 'You must select a country from the Countries pull down menu.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Telephone Number:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Your Telephone Number must contain a minimum of ' . ENTRY_TELEPHONE_MIN_LENGTH . ' characters.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Fax Number:');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Newsletter:');
define('ENTRY_NEWSLETTER_ERROR', 'We don\'t share your email with others commercial websites.');
define('ENTRY_NEWSLETTER_TEXT', 'Subscribe newsletter');
define('ENTRY_NEWSLETTER_YES', 'Subscribed');
define('ENTRY_NEWSLETTER_NO', 'Unsubscribed');
define('ENTRY_PASSWORD', 'Password:');
define('ENTRY_SHOW_PASSWORD', 'Show password');
define('CLICK_SHOW_PASSWORD', 'Click to show password');
define('CLICK_HIDE_PASSWORD', 'Click to hide password');
define('ENTRY_PASSWORD_ERROR', 'Your Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'The Password Confirmation must match your Password.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', 'Password Confirmation:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Current Password:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Your Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW', 'New Password:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Your new Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'The Password Confirmation must match your new Password.');
define('PASSWORD_HIDDEN', '--HIDDEN--');
define('PASSWORD_HIDE', 'Hide password');
define('PLACEHOLDER_EMAIL_ADRESS', 'Your Email Address');

define('FORM_REQUIRED_INFORMATION', '* Required information');
define('FORM_ERROR','You have ');
define('FORM_ERROR_NUMBERS',' errors in your form.<br />Please make corrections');
define('INFO', 'Info');
define('ALL_FORM_REQUIRED_INFORMATION', 'Required information');
define('FORM_ERROR_TITLE', 'Error in your form');

// constants for use in osc_prev_next_display function
define('TEXT_RESULT_PAGE', 'Result Pages:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> products)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> orders)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> reviews)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> new products)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> specials)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'First Page');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Previous Page');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Next Page');
define('PREVNEXT_TITLE_LAST_PAGE', 'Last Page');
define('PREVNEXT_TITLE_PAGE_NO', 'Page %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Previous Set of %d Pages');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Next Set of %d Pages');
define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;FIRST');
define('PREVNEXT_BUTTON_PREV', '[&lt;&lt;&nbsp;Prev]');
define('PREVNEXT_BUTTON_NEXT', '[Next&nbsp;&gt;&gt;]');
define('PREVNEXT_BUTTON_LAST', 'LAST&gt;&gt;');

define('BUTTON_NEXT', 'Next');
define('BUTTON_PREV', 'Prev');
define('BUTTON_SLIDESHOW', 'Slideshow');

define('IMAGE_BUTTON_ADD_ADDRESS', 'Add Address');
define('IMAGE_BUTTON_ADDRESS_BOOK', 'Address Book');
define('IMAGE_BUTTON_BACK', 'Back');
define('IMAGE_BUTTON_BUY_NOW', 'Buy Now');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Change Address');
define('IMAGE_BUTTON_CHECKOUT', 'Checkout');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Confirm Order');
define('IMAGE_BUTTON_CONTINUE', 'Continue');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Continue Shopping');
define('IMAGE_BUTTON_DELETE', 'Delete');
define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Edit Account');
define('IMAGE_BUTTON_HISTORY', 'Order History');
define('IMAGE_BUTTON_LOGIN', 'Sign In');
define('IMAGE_BUTTON_IN_CART', 'Add to Cart');
define('IMAGE_BUTTON_NOTIFICATIONS', 'Notifications');
define('IMAGE_BUTTON_QUICK_FIND', 'Quick Find');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Remove Notifications');
define('IMAGE_BUTTON_REVIEWS', 'Reviews');
define('IMAGE_BUTTON_SEARCH', 'Search');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Shipping Options');
define('IMAGE_BUTTON_TELL_A_FRIEND', 'Tell a Friend');
define('IMAGE_BUTTON_UPDATE', 'Update');
define('IMAGE_BUTTON_UPDATE_CART', 'Update Cart');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Write Review');

define('SMALL_IMAGE_BUTTON_DELETE', 'Delete');
define('SMALL_IMAGE_BUTTON_EDIT', 'Edit');
define('SMALL_IMAGE_BUTTON_VIEW', 'View');
define('SMALL_IMAGE_BUTTON_CLOSE', 'Close');

define('ICON_ARROW_RIGHT', 'more');
define('ICON_CART', 'In Cart');
define('ICON_ERROR', 'Error');
define('ICON_SUCCESS', 'Success');
define('ICON_WARNING', 'Warning');

define('TEXT_GREETING_PERSONAL', 'Welcome back <span class="greetUser">%s!</span> Would you like to see which <a href="%s"><u>new products</u></a> are available to purchase?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>If you are not %s, please <a href="%s"><u>log yourself in</u></a> with your account information.</small>');
define('TEXT_GREETING_GUEST', 'Welcome <span class="greetUser">Guest!</span> Would you like to <a href="%s"><u>log yourself in</u></a>? Or would you prefer to <a href="%s"><u>create an account</u></a>?');

define('TEXT_SORT_PRODUCTS', 'Sort products ');
define('TEXT_DESCENDINGLY', 'descendingly');
define('TEXT_ASCENDINGLY', 'ascendingly');
define('TEXT_BY', ' by ');
define('TEXT_VIEW_ALL', 'View all ');

define('TEXT_REVIEW_BY', 'by %s');
define('TEXT_REVIEW_WORD_COUNT', '%s words');
define('TEXT_REVIEW_RATING', 'Rating: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Date Added: %s');
define('TEXT_NO_REVIEWS', 'There are currently no product reviews.');
define('TEXT_REVIEWS_SEE','see %s times');

define('TEXT_NO_NEW_PRODUCTS', 'There are currently no products.');

define('TEXT_UNKNOWN_TAX_RATE', 'Unknown tax rate');

define('TEXT_REQUIRED', '<span class="errorText">Required</span>');

define('ERROR_OSC_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><strong><small>OSC ERROR:</small> Cannot send the email through the specified SMTP server. Please check your php.ini setting and correct the SMTP server if necessary.</strong></font>');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'The expiry date entered for the credit card is invalid. Please check the date and try again.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'The credit card number entered is invalid. Please check the number and try again.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'The first four digits of the number entered are: %s. If that number is correct, we do not accept that type of credit card. If it is wrong, please try again.');

define('FOOTER_TEXT_BODY', 'Copyright &copy; ' . date('Y') . ' <a href="' . osc_href_link() . '">' . STORE_NAME . '</a><br />Powered by <a href="http://www.oscommerce.com" target="_blank">osCommerce</a>');

/* twig */
define('NAV_ACCOUNT_INFORMATION', 'My informations');
define('NAV_ACCOUNT_ADDRESS_BOOK', 'My address book');
define('NAV_ACCOUNT_PASSWORD', 'My account password');
define('NAV_ORDERS_VIEW', 'My Orders');
define('NAV_EMAIL_NOTIFICATIONS_NEWSLETTERS', 'Newsletters');
define('NAV_EMAIL_NOTIFICATIONS_PRODUCTS', 'Product notification list');
define('TEXT_SHOP_ADDRESS', 'Our address');
define('TEXT_VIEW_GOOGLE_MAP_SHOP_ADDRESS', 'View on Google Map');
define('TEXT_VIEW_GOOGLE_MAP_BUTTON', 'Go to ...');
define('NO_ACCOUNT_HERE', 'No account ?');
define('SIGN_IN_WITH_GOOGLE', '<i class="icon-fa-google-plus-sign"></i> Sign In with Google');
define('SIGN_IN_WITH_TWITTER', '<i class="icon-fa-twitter-sign"></i> Sign In with Twitter');
define('PRODUCT_OPTION_OPTIONAL', 'this option is optionnal');

define('PRODUCT_OPTION_RADIO_BUTTON','Select this option');

define('TWIG_PRODUCT_IMAGE','Product Image');
define('TWIG_PRODUCT_NAME','Product Name');
define('TWIG_PRODUCT_MODEL','Product Model');
define('TWIG_PRODUCT_QTY','Product Quantity');
define('TWIG_PRODUCT_UNIT_PRICE', 'Unit Price');
define('TWIG_PRODUCT_TOTAL_PRICE', 'Total Price');
define('TWIG_PRODUCT_REMOVE', 'Remove');
define('TWIG_PRODUCT_OPTION_NAME', 'Option Name');
define('TWIG_PRODUCT_OPTION_VALUE', 'Option Value');
define('TWIG_PRODUCT_OPTION_UNIT_PRICE', 'Option Unit Price');
define('TWIG_PRODUCT_OPTION_TOTAL_PRICE', 'Option Total Price');
define('TWIG_OPTION_PRICE_FREE', '<span class="label label-success">Free option</span>');
define('TWIG_OUT_OF_STOCK_CANT_CHECKOUT', '<i class="icon-fa-hand-up"></i>  Product above dont exist in desired quantity in our stock.<br />Please alter the quantity of products above, Thank you');
define('TWIG_OF_STOCK_CAN_CHECKOUT', '<i class="icon-fa-hand-up"></i> Product above dont exist in desired quantity in our stock.<br />You can buy them anyway and check the quantity we have in stock for immediate deliver in the checkout process.');

define('TWIG_PAGE_NOT_FOUND', 'Page Not Found <small>Error 404</small>');
define('TWIG_PAGE_NOT_FOUND_TEXT', '<p>The page you requested could not be found, either contact your webmaster or try again. Use your browsers <b>Back</b> button to navigate to the page you have prevously come from</p><p><b>Or you could just press this neat little button:</b></p>');
define('TWIG_PAGE_NOT_FOUND_BUTTON', 'Take me home');

define('TWIG_RATING_EMPTY', '<span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span>');
define('TWIG_RATING_1', '<span class="icon-fa-star text-warning"></span><span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span>');
define('TWIG_RATING_1.5',  '<span class="icon-fa-star text-warning"></span><span class="icon-fa-star-half text-warning"></span><span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span>');
define('TWIG_RATING_2','<span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span>');
define('TWIG_RATING_2.5','<span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star-half text-warning"></span><span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span>');
define('TWIG_RATING_3','<span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star-empty"></span><span class="icon-fa-star-empty"></span>');
define('TWIG_RATING_3.5', '<span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star-half text-warning"></span><span class="icon-fa-star-empty"></span>');
define('TWIG_RATING_4', '<span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star-empty"></span>');
define('TWIG_RATING_4.5', '<span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star-half text-warning"></span>');
define('TWIG_RATING_5', '<span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span><span class="icon-fa-star text-warning"></span>');

define('PRODUCTS_LISTING_PRODUCTS_PER_PAGE', 'products per page');
define('PRODUCTS_LISTING_PRODUCT_NAME', 'name');
define('PRODUCTS_LISTING_PRODUCT_PRICE', 'price');
define('PRODUCTS_LISTING_PRODUCT_SPECIAL', 'special');
define('PRODUCTS_LISTING_PRODUCT_RATING', 'rating');
define('PRODUCTS_LISTING_PRODUCT_BRAND', 'brand');
define('PRODUCTS_LISTING_PRODUCT_ASC', 'asc');
define('PRODUCTS_LISTING_PRODUCT_DESC', 'desc');
define('PRODUCTS_LISTING_PRODUCT_DISPLAY_PRICE', 'Price :');
define('PRODUCTS_LISTING_PRODUCT_DISPLAY_SPECIAL_PRICE', 'Special Price :');
define('PRODUCTS_LISTING_PRODUCT_NO_SPECIAL', 'No special');
define('PRODUCTS_LISTING_PRODUCT_DISPLAY_RATING', 'Rating :');
define('PRODUCTS_LISTING_PRODUCT_DISPLAY_BRAND', 'Brand :');
define('PRODUCTS_LISTING_PRODUCT_BUTTON_OPEN_IMAGE', 'Open image');
define('PRODUCTS_LISTING_PRODUCT_BUTTON_SEE_DETAILS', 'See detail');
?>