<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */

require_once(DIR_WS_CLASSES . 'TwigHtmlOutput.php');
require_once(DIR_WS_CLASSES . 'TwigMyFilters.php');
require_once(DIR_WS_CLASSES . 'TwigFunctions.php');
require_once(DIR_WS_MODULES . 'TwigModules.php');


class TwigTemplate
{

    protected $_twig;

    protected $_app;

    protected $_parent_template = "classic";
    
    //protected $_template = TWIG_STORE_TEMPLATE; /* desactivate for demo /* 
    
    protected $_template_cache = TWIG_CACHE_ACTIVATION;
    
    protected $_mode_debug = TWIG_DEBUG_ACTIVATION;   

    protected $_template_extension = ".html.twig";

    protected $_columnsize;

    protected $_contentsize;    

    protected $_basehref;

    protected $_header_tags;

    protected $_breadcrumb;    

    protected $_footerscript;
    
    protected $_grid_container_width = 12;
    
    protected $_grid_content_width = 8;
    
    protected $_grid_column_width = 2;
    
    protected $_title;

    public function __construct() {
        global $OSCOM_APP;      
        
        $loader = new Twig_Loader_Filesystem(DIR_WS_MODULES . 'templates/' . $this->getTemplate() . '/content');
        
        if (is_dir(DIR_WS_MODULES . 'boxes' . '/view/template/' . $this->getTemplate())) {
            $loader->addPath(DIR_WS_MODULES . 'boxes' . '/view/template/' . $this->getTemplate());
        }
        $loader->addPath(DIR_WS_MODULES . 'boxes' . '/view/template/' . $this->getParentTemplate());

        if (is_dir(DIR_WS_INCLUDES . 'apps/' . $OSCOM_APP->getCode() . '/view/template/' . $this->getTemplate())) {
            $loader->addPath(DIR_WS_INCLUDES . 'apps/' . $OSCOM_APP->getCode() . '/view/template/' . $this->getTemplate());
        }
        $loader->addPath(DIR_WS_INCLUDES . 'apps/' . $OSCOM_APP->getCode() . '/view/template/' . $this->getParentTemplate());

        if (is_dir(DIR_WS_INCLUDES . 'apps/' . $OSCOM_APP->getCode() . '/view/template/' . $this->getTemplate() . '/modules')) {
            $loader->addPath(DIR_WS_INCLUDES . 'apps/' . $OSCOM_APP->getCode() . '/view/template/' . $this->getTemplate() . '/modules');
        }
        if (is_dir(DIR_WS_INCLUDES . 'apps/' . $OSCOM_APP->getCode() . '/view/template/' . $this->getParentTemplate() . '/modules')) {
            $loader->addPath(DIR_WS_INCLUDES . 'apps/' . $OSCOM_APP->getCode() . '/view/template/' . $this->getParentTemplate() . '/modules');
        }

        $this->_twig = new Twig_Environment($loader, 
                array('cache' => $this->getTemplateCache(),
                      'debug' => $this->getDebugMode()));
        
        $this->setGlobal();
        $this->addExtentions();
        $this->buildBlocks();
    }
    
    protected function getTemplateCache() 
    {
       if ($this->_template_cache === 'True' ) {
           
       return DIR_WS_INCLUDES . 'work/twig_cache';
       
       } else {
           
       return false;
       
       }
    }
    
    protected function getDebugMode()
    {
        if ($this->_mode_debug === 'True' ) {
            
            return true;
            
        }else{
            
            return false;
            
        }
    }
    
    public function getTemplate() 
    {        
       //return $this->_template; desactivate for demo
       return $_SESSION['template'];
        
    }
    
    public function setTemplate ($template)
    {
        $this->_template = $template;
    }

    protected function getParentTemplate() {
        return $this->_parent_template;
    }

    public function getTwig() {
        return $this->_twig;
    }

    public function getTemplateExtension() {
        return $this->_template_extension;
    }

    public function render() {
        
        $data = $this->getAppData();

        if (is_array($data) && !empty($data)) {
            
            $params = $this->getAppData();
            
        } else {

            $params = array();
        }

        $content = $this->_twig->render($params['template'] . $this->_template_extension, array_merge($this->getGlobalData(), $params));

        return $content;
    }

    private function getAppData() {
        global $OSCOM_APP;

        $reserved_words = array('empty', 'new', 'shipping'); // thanks HPDL !

        if (in_array(substr($OSCOM_APP->getContentFile(), 0, -4), $reserved_words)) {

            $top_model = substr($OSCOM_APP->getContentFile(), 0, -4) . '_' . $OSCOM_APP->getCode();
            
        } else {

            $top_model = substr($OSCOM_APP->getContentFile(), 0, -4);
        }

        if ( !class_exists($top_model) ) {

            if ( file_exists(DIR_WS_INCLUDES . 'apps/' . $OSCOM_APP->getCode() . '/model/' . $top_model . '.php') ) {
                
                include(DIR_WS_INCLUDES . 'apps/' . $OSCOM_APP->getCode() . '/model/' . $top_model . '.php');
                
            } else {
                
                include_once(DIR_WS_INCLUDES . 'apps/index/model/template_error.php');
                
                $top_model = 'template_error';
                
            }
        }
        
        $nick_kamen = new $top_model();
        
        return $nick_kamen->execute();
    }

    private function getAppCode() {
        global $OSCOM_APP;
        return $OSCOM_APP->getCode();
    }
    
    private function getAppContentFile() {
        global $OSCOM_APP;
        return  substr($OSCOM_APP->getContentFile(), 0, -4);
    }

    private function addExtentions() {
        $this->_twig->addExtension(new TwigHtmlOutput());
        $this->_twig->addExtension(new TwigMyFilters());
        $this->_twig->addExtension(new TwigFunctions());
        $this->_twig->addExtension(new TwigModules());
        $this->_twig->addExtension(new Twig_Extension_Debug());
    }

    private function getBasehref() {
        global $request_type;
        return $this->_basehref = ($request_type == 'SSL' ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG;
    }

    private function getHeadertags() {
        global $OSCOM_Template;
        return $this->_header_tags = $OSCOM_Template->getBlocks('header_tags');
    }

    private function getBreadcrumb() {
        global $OSCOM_Breadcrumb;
        return $this->_breadcrumb = $OSCOM_Breadcrumb->get();
    }

    private function getFooterscript() {
        global $OSCOM_Template;
        return $this->_footerscript = $OSCOM_Template->getBlocks('footer_scripts');
    }

    private function getUserstatus() {
        global $OSCOM_Customer;
        return $OSCOM_Customer->isLoggedOn();
    }

    private function getGlobalData() {
        return array('title' => $this->getTitle(),
            'base_href' => $this->getBasehref(),
            'app_code' => $this->getAppCode(),
            'app_content_file' => $this->getAppContentFile(),
            'header_tags' => $this->getHeadertags(),
            'breadcrumb' => $this->getBreadcrumb(),
            'boxes' => $this->getBoxes(),           
            'footer_script' => $this->getFooterscript(),
            'isLoggedOn' => $this->getUserstatus());
    }

    private function setGlobal() {
        $this->_twig->addGlobal('GridColumnWidth', $this->getGridColumnWidth());
        $this->_twig->addGlobal('GridContentWidth', $this->getGridContentWidth());
        $this->_twig->addGlobal('GridContainerWidth', $this->getGridContainerWidth());
        $this->_twig->addGlobal('session', $_SESSION);
        $this->_twig->addGlobal('TwigExtension', $this->_template_extension);
    }

    public function getTitle() {
        global $OSCOM_Template;
        return $this->_title = osc_output_string_protected($OSCOM_Template->getTitle());
    }
    
    public function getGridContainerWidth() {
        return $this->_grid_container_width;
    }

    public function getGridContentWidth() {
        return $this->_grid_content_width;
    }

    public function getGridColumnWidth() {
        return $this->_grid_column_width;
    }

    public function addBlock($block, $group) {
        $this->_blocks[$group][] = $block;
    }

    public function hasBlocks($group) {
        return (isset($this->_blocks[$group]) && !empty($this->_blocks[$group]));
    }

    public function getBlocks($group) {
        if ($this->hasBlocks($group)) {
            return implode("\n", $this->_blocks[$group]);
        }
    }
    
    private function buildBlocks() {
        if (defined('TEMPLATE_BLOCK_GROUPS') && osc_not_null(TEMPLATE_BLOCK_GROUPS)) {
            $tbgroups_array = explode(';', TEMPLATE_BLOCK_GROUPS);

            foreach (array_keys($tbgroups_array, 'boxes', true) as $key) {
                unset($tbgroups_array[$key]);
            }
            foreach ($tbgroups_array as $group) {

                $module_key = 'MODULE_' . strtoupper($group) . '_INSTALLED';

                if (defined($module_key) && osc_not_null(constant($module_key))) {
                    $modules_array = explode(';', constant($module_key));

                    foreach ($modules_array as $module) {

                        $class = substr($module, 0, strrpos($module, '.'));

                        if (!class_exists($class)) {
                            include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/' . $group . '/' . $module);
                            include(DIR_WS_MODULES . $group . '/' . $class . '.php');
                        }
                        $mb = new $class();

                        if ($mb->isEnabled()) {
                            $mb->execute();
                        }
                    }
                }
            }
        }
    }    
   
    private function getBoxes() {

        $module_key = 'MODULE_BOXES_INSTALLED';

        $boxes = array();

        if (defined($module_key) && osc_not_null(constant($module_key))) {

            $modules_array = explode(';', constant($module_key));

            foreach ($modules_array as $module) {

                $twig_class = substr('twig_' . $module, 0, strrpos('twig_' . $module, '.'));

                if (!class_exists($twig_class)) {

                    include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/boxes/' . $module);

                    include(DIR_WS_MODULES . 'boxes/model/' . $twig_class . '.php');
                }

                $twig_mb = new $twig_class();

                if ($twig_mb->isEnabled()) {

                    $boxes[] = $twig_mb->execute();
                }
            }
            return $boxes;
        }
    }
}
?>