<?php

  /**
   * Sitemap Activation
   *
   *
   * @package  Croogo
   * @author   Darren Moore <darren.m@firecreek.co.uk>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://www.firecreek.co.uk
   */
  class SitemapActivation {

    /**
     * onActivate will be called if this returns true
     *
     * @param  object $controller Controller
     * @return boolean
     */
    public function beforeActivation(&$controller) {
      $this->_sql('activate');
      return true;
    }
      
      
    /**
     * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
     *
     * @param object $controller Controller
     * @return void
     */
    public function onActivation(&$controller) {
      // ACL: set ACOs with permissions
      $controller->Croogo->addAco('Sitemap');
      $controller->Croogo->addAco('Sitemap/admin_index');
      $controller->Croogo->addAco('Sitemap/admin_add');
      $controller->Croogo->addAco('Sitemap/admin_edit');
      $controller->Croogo->addAco('Sitemap/admin_delete');
      $controller->Croogo->addAco('Sitemap/index', array('registered', 'public'));
      
      $controller->Setting->write('Sitemap.types', '', array('editable' => 1, 'title' => 'Node Types','description'=>'Comma seperated, blank for all'));
      $controller->Setting->write('Sitemap.default_priority', '0.7', array('editable' => 1, 'title' => 'Default Priority'));
      $controller->Setting->write('Sitemap.default_frequency', 'weekly', array('editable' => 1, 'title' => 'Default Change Frequency'));
    }
    
    /**
     * onDeactivate will be called if this returns true
     *
     * @param  object $controller Controller
     * @return boolean
     */
    public function beforeDeactivation(&$controller) {
      $this->_sql('deactivate');
      return true;
    }
      
    /**
     * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
     *
     * @param object $controller Controller
     * @return void
     */
    public function onDeactivation(&$controller) {
      // ACL: remove ACOs with permissions
      $controller->Croogo->removeAco('Sitemap');
      
      $controller->Setting->deleteKey('Sitemap.types');
      $controller->Setting->deleteKey('Sitemap.default_priority');
      $controller->Setting->deleteKey('Sitemap.default_frequency');
    }
      
    
    /**
     * SQL
     *
     * @access private
     * @return void
     */
    private function _sql($file)
    {
      $sql = file_get_contents(APP.'plugins'.DS.'sitemap'.DS.'config'.DS.'schema'.DS.$file.'.sql');
      if(!empty($sql)){
        App::import('Core', 'File');
        App::import('Model', 'ConnectionManager');
        $db = ConnectionManager::getDataSource('default');

        $statements = explode(';', $sql);

        foreach ($statements as $statement) {
            if (trim($statement) != '') {
                $db->query($statement);
            }
        }
      }
    }
      
  }
  
?>