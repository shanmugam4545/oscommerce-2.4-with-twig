<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/
?>
<!doctype html>
<html <?php echo HTML_PARAMS; ?>>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">

<meta name="robots" content="noindex,nofollow">

<title><?php echo TITLE; ?></title>

<base href="<?php echo HTTP_SERVER . DIR_WS_ADMIN; ?>" />

<!--[if IE]><script src="<?php echo osc_catalog_href_link('ext/flot/excanvas.min.js'); ?>"></script><![endif]-->

<link rel="stylesheet" type="text/css" href="<?php echo osc_catalog_href_link('ext/bootstrap/css/bootstrap.min.css'); ?>" />

<!-- this is until boot strap is 100% -->


<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" href="<?php echo osc_catalog_href_link("ext/bootstrap/css/font-awesome.min.css"); ?>" />
<!--
<link rel="stylesheet" type="text/css" href="<?php echo osc_catalog_href_link('ext/bootstrap/admin/base-admin.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo osc_catalog_href_link('ext/bootstrap/admin/base-admin-responsive.css'); ?>" />
-->


<script src="includes/general.js"></script>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="<?php echo osc_catalog_href_link('ext/assets/js/html5shiv.js'); ?>"></script>
<![endif]-->

<script src="<?php echo osc_catalog_href_link('ext/jquery/jquery-1.9.1.min.js'); ?>"></script>

<script src="<?php echo osc_catalog_href_link('ext/bootstrap/js/bootstrap.min.js'); ?>"></script>

<!-- CDN is only for UI compatibility with jquery-1.9.1 untill boot strap is 100% integrated -->
<script src="//code.jquery.com/ui/1.10.0/jquery-ui.js"></script>


<?php
  if (osc_not_null(JQUERY_DATEPICKER_I18N_CODE)) {
?>

<script src="<?php echo osc_catalog_href_link('ext/jquery/ui/i18n/jquery.ui.datepicker-' . JQUERY_DATEPICKER_I18N_CODE . '.js'); ?>"></script>
<script>
$.datepicker.setDefaults($.datepicker.regional['<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>']);
</script>

<?php
  }
?>

<script src="<?php echo osc_catalog_href_link('ext/flot/jquery.flot.js'); ?>"></script>

</head>

<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#"><img src="./images/oscommerce_white_fill.png" alt="osCommerce Online Merchant" width="202" height="30" ></a>
            <div class="nav-collapse">
                <ul class="nav">
                    <li class="dropdown">
                        <a href="'<?php echo osc_catalog_href_link(); ?>'" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-fa-home icon-white"></i><?php echo HEADER_TITLE_ONLINE_CATALOG; ?></a>
                    </li>
                </ul>
            </div>
<div class="nav-collapse">
<ul class="nav pull-right">
<li class="dropdown">
<ul class="dropdown-menu">
<li><a href="">Account Settings</a></li>
<li><a href="">Privacy Settings</a></li>
<li class="divider"></li>
<li><a href="javascript:;">Help</a></li>
</ul>						
</li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<i class="icon-user"></i> 
Rod Howard
<b class="caret"></b>
</a>						
<ul class="dropdown-menu">
<li><a href="javascript:;">My Profile</a></li>
<li><a href="javascript:;">My Groups</a></li>
<li class="divider"></li>
<li><a href="javascript:;">Logout</a></li>
</ul>
</li>
</ul>
<form class="navbar-search pull-right">
<input type="text" class="search-query" placeholder="Search">
</form>
</div><!--/.nav-collapse -->	
</div> <!-- /container -->
</div> <!-- /navbar-inner -->	
</div> <!-- /navbar -->
<?php
  if (isset($_SESSION['admin'])) {    
      include(DIR_WS_INCLUDES . 'admin_menu_top.php');
  }
?>
<section id="bodyContent" class="span<?php echo isset($_SESSION['admin']) ? '12' : '12'; ?>">
