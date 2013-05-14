<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class TwigHtmlOutput extends Twig_Extension
{

    public function getFunctions()
    {

        return array(
            new Twig_SimpleFunction('link', 'twig_osc_href_link'),
            new Twig_SimpleFunction('image', 'twig_osc_image'),
            new Twig_SimpleFunction('form', 'twig_osc_draw_form'),
            new Twig_SimpleFunction('inputfield', 'twig_draw_input_field'),
            new Twig_SimpleFunction('password','twig_draw_password_field'),
            new Twig_SimpleFunction('hiddenfield', 'twig_draw_hidden_field'),
            new Twig_SimpleFunction('textareafield', 'twig_draw_textarea_field'),
            new Twig_SimpleFunction('button', 'twig_osc_draw_button'),
            new Twig_SimpleFunction('radio', 'twig_draw_radio_field'),
            new Twig_SimpleFunction('checkboxe', 'twig_draw_checkbox_field'),
            new Twig_SimpleFunction('pulldown', 'twig_draw_pull_down_menu'),
            new Twig_SimpleFunction('osc_output_string', 'twig_osc_output_string'),
            new Twig_SimpleFunction('hidesession', 'twig_hide_session_id'),
        );
    }
    public function getName()
    {
        return 'HtmlOutputExtension';

    }
}
  function twig_osc_output_string($string, $translate = false, $protected = false) {
    if ($protected == true) {
      return htmlspecialchars($string);
    } else {
      if ($translate == false) {
        return osc_parse_input_field_data($string, array('"' => '&quot;'));
      } else {
        return osc_parse_input_field_data($string, $translate);
      }
    }
  }
// function HTML
// Output a form radio field
  function twig_draw_radio_field($name, $value = '', $checked = false, $parameters = '') {
    return osc_draw_selection_field($name, 'radio', $value, $checked, $parameters);
  }
// Output a form checkbox field
  function twig_draw_checkbox_field($name, $value = '', $checked = false, $parameters = '') {
    return osc_draw_selection_field($name, 'checkbox', $value, $checked, $parameters);
  }
// The HTML href link wrapper function
  function twig_osc_href_link($app = null, $parameters = null, $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true, $page = null) {
    global $request_type, $session_started, $SID;

    if ( $app == 'index' ) {
      $app = null;
    }

    if ( $connection == 'SSL' ) {
      if ( ENABLE_SSL === true ) {
        $link = HTTPS_SERVER . DIR_WS_HTTPS_CATALOG;
      } else {
        $link = HTTP_SERVER . DIR_WS_HTTP_CATALOG;
      }
    } else {
      $link = HTTP_SERVER . DIR_WS_HTTP_CATALOG;
    }

    if ( isset($page) ) {
      $link .= $page;
      $separator = '?';
    } else {
      $link .= 'index.php';

      if ( isset($app) ) {
        $link .= '?' . $app;
        $separator = '&';
      } else {
        $separator = '?';
      }
    }

    if ( isset($parameters) ) {
      $link .= $separator . osc_output_string($parameters);
      $separator = '&';
    }

// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
    if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
      if (osc_not_null($SID)) {
        $_sid = $SID;
      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == true) ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
        if (HTTP_COOKIE_DOMAIN != HTTPS_COOKIE_DOMAIN) {
          $_sid = session_name() . '=' . session_id();
        }
      }
    }

    if (isset($_sid)) {
      $link .= $separator . osc_output_string($_sid);
    }

    while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);

    if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
      $link = str_replace('?', '/', $link);
      $link = str_replace('&', '/', $link);
      $link = str_replace('=', '/', $link);
    } else {
      $link = str_replace('&', '&amp;', $link);
    }

    return $link;
  }

// The HTML image wrapper function
  function twig_osc_image($src, $alt = '', $width = '', $height = '', $parameters = '') {
    if ( (empty($src) || ($src == DIR_WS_IMAGES)) && (IMAGE_REQUIRED == 'false') ) {
      return false;
    }

// alt is added to the img tag even if it is null to prevent browsers from outputting
// the image filename as default
    $image = '<img src="' . osc_output_string($src) . '" alt="' . osc_output_string($alt) . '"';

    if (osc_not_null($alt)) {
      $image .= ' title="' . osc_output_string($alt) . '"';
    }

    if ( (CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height)) ) {
      if ($image_size = @getimagesize($src)) {
        if (empty($width) && osc_not_null($height)) {
          $ratio = $height / $image_size[1];
          $width = intval($image_size[0] * $ratio);
        } elseif (osc_not_null($width) && empty($height)) {
          $ratio = $width / $image_size[0];
          $height = intval($image_size[1] * $ratio);
        } elseif (empty($width) && empty($height)) {
          $width = $image_size[0];
          $height = $image_size[1];
        }
      } elseif (IMAGE_REQUIRED == 'false') {
        return false;
      }
    }

    if (osc_not_null($width) && osc_not_null($height)) {
      $image .= ' width="' . osc_output_string($width) . '" height="' . osc_output_string($height) . '"';
    }

    if (osc_not_null($parameters)) $image .= ' ' . $parameters;

    $image .= ' />';

    return $image;
  }

// Output a form
  function twig_osc_draw_form($name, $action, $method = 'post', $parameters = '', $tokenize = false) {
    $form = '<form name="' . osc_output_string($name) . '" action="' . osc_output_string($action) . '" method="' . osc_output_string($method) . '"';

    if (osc_not_null($parameters)) $form .= ' ' . $parameters;

    $form .= '>';

    if ( ($tokenize == true) && isset($_SESSION['sessiontoken']) ) {
      $form .= '<input type="hidden" name="formid" value="' . osc_output_string($_SESSION['sessiontoken']) . '" />';
    }

    return $form;
  }

// Output a form input field
  function twig_draw_input_field($name, $value = '', $parameters = '', $placeholder = '', $type = 'text', $reinsert_value = true) {
    $field = '<input type="' . osc_output_string($type) . '" name="' . osc_output_string($name) . '"';

    if ( ($reinsert_value == true) && ( (isset($_GET[$name]) && is_string($_GET[$name])) || (isset($_POST[$name]) && is_string($_POST[$name])) ) ) {
      if (isset($_GET[$name]) && is_string($_GET[$name])) {
        $value = $_GET[$name];
      } elseif (isset($_POST[$name]) && is_string($_POST[$name])) {
        $value = $_POST[$name];
      }
    }

    if (osc_not_null($value)) {
      $field .= ' value="' . osc_output_string($value) . '"';
    }

    if (osc_not_null($placeholder)) {
      $field .= ' placeholder="' . osc_output_string($placeholder) . '"';
    }    

    if (osc_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= ' />';

    return $field;
  }

  
// Output a form password field
  function twig_draw_password_field($name, $value = '', $parameters = '') {
    return twig_draw_input_field($name, $value, $parameters, 'password', 'password', false);
  }
  
// Output a form textarea field
// The $wrap parameter is no longer used in the core xhtml template
  function twig_draw_textarea_field($name, $wrap, $width, $height, $text = '', $parameters = '', $reinsert_value = true) {
    $field = '<textarea name="' . osc_output_string($name) . '" cols="' . osc_output_string($width) . '" rows="' . osc_output_string($height) . '"';

    if (osc_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if ( ($reinsert_value == true) && ( (isset($_GET[$name]) && is_string($_GET[$name])) || (isset($_POST[$name]) && is_string($_POST[$name])) ) ) {
      if (isset($_GET[$name]) && is_string($_GET[$name])) {
        $field .= osc_output_string_protected($_GET[$name]);
      } elseif (isset($_POST[$name]) && is_string($_POST[$name])) {
        $field .= osc_output_string_protected($_POST[$name]);
      }
    } elseif (osc_not_null($text)) {
      $field .= osc_output_string_protected($text);
    }

    $field .= '</textarea>';

    return $field;
  }
// Output a Bootstrap Button
  function twig_osc_draw_button($title = null, $icon = null, $link = null, $style = null, $params = null) {
    $types = array('submit', 'button', 'reset');
    $styles = array('primary', 'info', 'success', 'warning', 'danger', 'inverse', 'link');

    if ( !isset($params['type']) ) {
      $params['type'] = 'submit';
    }

    if ( !in_array($params['type'], $types) ) {
      $params['type'] = 'submit';
    }

    if ( ($params['type'] == 'submit') && isset($link) ) {
      $params['type'] = 'button';
    }

    if ( isset($style) && !in_array($style, $styles) ) {
      unset($style);
    }

    $button = '';

    if ( ($params['type'] == 'button') && isset($link) ) {
      $button .= '<a href="' . $link . '"';

      if ( isset($params['newwindow']) ) {
        $button .= ' target="_blank"';
      }
    } else {
      $button .= '<button type="' . osc_output_string($params['type']) . '"';
    }

    if ( isset($params['params']) ) {
      $button .= ' ' . $params['params'];
    }

    $button .= ' class="btn';

    if ( isset($style) ) {
      $button .= ' btn-' . $style;
    }

    $button .= '">';

    if ( isset($icon) ) {
      if ( !isset($params['iconpos']) ) {
        $params['iconpos'] = 'left';
      }

      if ( $params['iconpos'] == 'left' ) {
        $button .= '<i class="icon-fa-' . $icon;

        if ( isset($style) ) {
          $button .= ' icon-white';
        }

        $button .= '"></i> ';
      }
    }

    $button .= $title;

    if ( isset($icon) && ($params['iconpos'] == 'right') ) {
      $button .= ' <i class="icon-fa-' . $icon;

      if ( isset($style) ) {
        $button .= ' icon-white';
      }

      $button .= '"></i>';
    }

    if ( ($params['type'] == 'button') && isset($link) ) {
      $button .= '</a>';
    } else {
      $button .= '</button>';
    }

    return $button;
  }

// Output a form hidden field
  function twig_draw_hidden_field($name, $value = '', $parameters = '') {
    $field = '<input type="hidden" name="' . osc_output_string($name) . '"';

    if (osc_not_null($value)) {
      $field .= ' value="' . osc_output_string($value) . '"';
    } elseif ( (isset($_GET[$name]) && is_string($_GET[$name])) || (isset($_POST[$name]) && is_string($_POST[$name])) ) {
      if ( (isset($_GET[$name]) && is_string($_GET[$name])) ) {
        $field .= ' value="' . osc_output_string($_GET[$name]) . '"';
      } elseif ( (isset($_POST[$name]) && is_string($_POST[$name])) ) {
        $field .= ' value="' . osc_output_string($_POST[$name]) . '"';
      }
    }

    if (osc_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= ' />';

    return $field;
  }
  
// Output a form pull down menu
  function twig_draw_pull_down_menu($name, $values, $default = '', $parameters = '', $required = false, $limit = false) {
    $field = '<select name="' . osc_output_string($name) . '"';

    if (osc_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if (empty($default) && ( (isset($_GET[$name]) && is_string($_GET[$name])) || (isset($_POST[$name]) && is_string($_POST[$name])) ) ) {
      if (isset($_GET[$name]) && is_string($_GET[$name])) {
        $default = $_GET[$name];
      } elseif (isset($_POST[$name]) && is_string($_POST[$name])) {
        $default = $_POST[$name];
      }
    }
    if ($limit == true) {
    $field .= '<option value="">' . PULL_DOWN_DEFAULT . '</option>';
    }
    
    for ($i=0, $n=sizeof($values); $i<$n; $i++) {
      $field .= '<option value="' . osc_output_string($values[$i]['id']) . '"';
      if ($default == $values[$i]['id']) {
        $field .= ' selected="selected"';
      }

      $field .= '>' . osc_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>';
    }
    $field .= '</select>';

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
  }
  
// Hide form elements
  function twig_hide_session_id() {
    global $session_started, $SID;

    if (($session_started == true) && osc_not_null($SID)) {
      return osc_draw_hidden_field(session_name(), session_id());
    }
  }
?>