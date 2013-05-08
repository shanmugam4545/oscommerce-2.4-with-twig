<?php
/**
 * osCommerce Online Merchant
 * 
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

  class app_products_action_download {
    public static function execute(app $app) {
      global $OSCOM_Customer, $OSCOM_PDO;

      if ( !$OSCOM_Customer->isLoggedOn() ) {
        osc_redirect(osc_href_link('account', 'login', 'SSL'));
      }

// Check download.php was called with proper GET parameters
      if ( (isset($_GET['order']) && !is_numeric($_GET['order'])) || (isset($_GET['id']) && !is_numeric($_GET['id'])) ) {
        osc_redirect(osc_href_link());
      }

// Check that order_id, customer_id and filename match
      $Qdownload = $OSCOM_PDO->prepare('select date_format(o.date_purchased, "%Y-%m-%d") as date_purchased_day, opd.download_maxdays, opd.download_count, opd.download_maxdays, opd.orders_products_filename from :table_orders o, :table_orders_products op, :table_orders_products_download opd, :table_orders_status os where o.orders_id = :orders_id and o.customers_id = :customers_id and o.orders_id = op.orders_id and op.orders_products_id = opd.orders_products_id and opd.orders_products_download_id = :orders_products_download_id and opd.orders_products_filename != "" and o.orders_status = os.orders_status_id and os.downloads_flag = "1" and os.language_id = :language_id');
      $Qdownload->bindInt(':orders_id', $_GET['order']);
      $Qdownload->bindInt(':customers_id', $OSCOM_Customer->getID());
      $Qdownload->bindInt(':orders_products_download_id', $_GET['id']);
      $Qdownload->bindInt(':language_id', $_SESSION['languages_id']);
      $Qdownload->execute();

      if ( $Qdownload->fetch() === false ) {
        osc_redirect(osc_href_link());
      }

// MySQL 3.22 does not have INTERVAL
      list($dt_year, $dt_month, $dt_day) = explode('-', $Qdownload->value('date_purchased_day'));
      $download_timestamp = mktime(23, 59, 59, $dt_month, $dt_day + $Qdownload->valueInt('download_maxdays'), $dt_year);

// Die if time expired (maxdays = 0 means no time limit)
      if (($Qdownload->valueInt('download_maxdays') != 0) && ($download_timestamp <= time())) die;

// Die if remaining count is <=0
      if ($Qdownload->valueInt('download_count') <= 0) die;

// Die if file is not there
      if (!file_exists(DIR_FS_DOWNLOAD . $Qdownload->value('orders_products_filename'))) die;

// Now decrement counter
      $Qupdate = $OSCOM_PDO->prepare('update :table_orders_products_download set download_count = download_count-1 where orders_products_download_id = :orders_products_download_id');
      $Qupdate->bindInt(':orders_products_download_id', $_GET['id']);
      $Qupdate->execute();

// Now send the file with header() magic
      header('Expires: Mon, 26 Nov 1962 00:00:00 GMT');
      header('Last-Modified: ' . gmdate('D,d M Y H:i:s') . ' GMT');
      header('Cache-Control: no-cache, must-revalidate');
      header('Pragma: no-cache');
      header('Content-Type: Application/octet-stream');
      header('Content-disposition: attachment; filename=' . $Qdownload->value('orders_products_filename'));

      if (DOWNLOAD_BY_REDIRECT == 'true') {
// This will work only on Unix/Linux hosts
        $this->_unlink_temp_dir(DIR_FS_DOWNLOAD_PUBLIC);
        $tempdir = osc_create_random_value(20);
        umask(0000);
        mkdir(DIR_FS_DOWNLOAD_PUBLIC . $tempdir, 0777);
        symlink(DIR_FS_DOWNLOAD . $Qdownload->value('orders_products_filename'), DIR_FS_DOWNLOAD_PUBLIC . $tempdir . '/' . $Qdownload->value('orders_products_filename'));

        if (file_exists(DIR_FS_DOWNLOAD_PUBLIC . $tempdir . '/' . $Qdownload->value('orders_products_filename'))) {
          osc_redirect(osc_href_link(DIR_WS_DOWNLOAD_PUBLIC . $tempdir . '/' . $Qdownload->value('orders_products_filename')));
        }
      }

// Fallback to readfile() delivery method. This will work on all systems, but will need considerable resources
      readfile(DIR_FS_DOWNLOAD . $Qdownload->value('orders_products_filename'));

      exit;
    }

    // Unlinks all subdirectories and files in $dir
    // Works only on one subdir level, will not recurse
    protected function _unlink_temp_dir($dir) {
      $h1 = opendir($dir);
      while ($subdir = readdir($h1)) {
    // Ignore non directories
        if (!is_dir($dir . $subdir)) continue;
    // Ignore . and .. and CVS
        if ($subdir == '.' || $subdir == '..' || $subdir == 'CVS') continue;
    // Loop and unlink files in subdirectory
        $h2 = opendir($dir . $subdir);
        while ($file = readdir($h2)) {
          if ($file == '.' || $file == '..') continue;
          @unlink($dir . $subdir . '/' . $file);
        }
        closedir($h2); 
        @rmdir($dir . $subdir);
      }
      closedir($h1);
    }
  }
?>
