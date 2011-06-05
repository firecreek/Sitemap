<?php

  /**
   * Sitemap Controller
   *
   * @category Controller
   * @package  Croogo
   * @version  1.0
   * @author   Darren Moore <darren.m@firecreek.co.uk>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://www.firecreek.co.uk
   */
  class SitemapController extends SitemapAppController {
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Sitemap';
      
    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = array('Sitemap.Sitemap','Node');


    /**
     * Before filter
     *
     * @access public
     * @return void
     */
    public function beforeFilter() {
      parent::beforeFilter();

      // CSRF Protection
      if (in_array($this->params['action'], array('admin_index'))) {
        $this->Security->validatePost = false;
      }
    }


    /**
     * Admin index
     *
     * List existing redirect routes
     *
     * @access public
     * @return void
     */
    public function admin_index()
    {
      $this->set('title_for_layout', __('Sitemap', true));
      
      $records = $this->paginate();
      
      $this->set(compact('records'));
    }


    /**
     * Admin add
     *
     * @access public
     * @return void
     */
    public function admin_add()
    {
      $this->set('title_for_layout', __('Sitemap add', true));
      
      if (!empty($this->data)) {
        $this->Sitemap->create();
        if ($this->Sitemap->save($this->data)) {
          $this->Session->setFlash(__('The page has been saved', true), 'default', array('class' => 'success'));
          $this->redirect(array('action'=>'index'));
        } else {
          $this->Session->setFlash(__('The page could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
        }
      }
    }


    /**
     * Admin edit
     *
     * @access public
     * @return void
     */
    public function admin_edit($id)
    {
      $this->set('title_for_layout', __('Sitemap edit', true));
    
      if (!empty($this->data)) {
          if ($this->Sitemap->save($this->data)) {
              $this->Session->setFlash(__('The page has been saved', true), 'default', array('class' => 'success'));
              $this->redirect(array('action'=>'index'));
          } else {
              $this->Session->setFlash(__('The page could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
          }
      }
      if (empty($this->data)) {
          $this->data = $this->Sitemap->read(null, $id);
      }
    }


    /**
     * Admin delete
     *
     * @access public
     * @return void
     */
    public function admin_delete($id)
    {
      if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
          $blackHoleCallback = $this->Security->blackHoleCallback;
          $this->$blackHoleCallback();
      }
      if ($this->Sitemap->delete($id)) {
          $this->Session->setFlash(__('Page deleted', true), 'default', array('class' => 'success'));
          $this->redirect(array('action'=>'index'));
      }
    }


    /**
     * Output XML of sitemap based on settings
     *
     * @access public
     * @return void
     */
    public function index()
    {
      $this->layout = false;
      $output = array();
      
      //Settings
      $types = Configure::read('Sitemap.types');
      $defaultPriority = Configure::read('Sitemap.default_priority');
      $defaultFrequency = Configure::read('Sitemap.default_frequency');
    
      //From nodes table
      $conditions = array();
      if(!empty($types))
      {
        $conditions['Node.type'] = explode(',',$types);
      }
      $nodes = $this->Node->find('all',array(
        'conditions' => array_merge(array(
          'Node.status' => 1
        ),$conditions),
        'fields' => array('id','title','slug','type','updated')
      ));
      
      foreach($nodes as $node)
      {      
        $output[] = array(
          'loc'         => Router::url($node['Node']['url'],true),
          'lastmod'     => date('Y-m-d',strtotime($node['Node']['updated'])),
          'changefreq'  => isset($node['CustomField']['frequency']) ? $node['CustomField']['frequency'] : $defaultFrequency,
          'priority'    => isset($node['CustomField']['priority']) ? $node['CustomField']['priority'] : $defaultPriority
        );
      }
      
      //From sitemap table
      $pages = $this->Sitemap->find('all');
      
      foreach($pages as $page)
      {  
        $output[] = array(
          'loc'         =>  Router::url($page['Sitemap']['loc'],true),
          'lastmod'     => date('Y-m-d',strtotime($page['Sitemap']['lastmod'])),
          'changefreq'  => !empty($page['Sitemap']['changefreq']) ? $page['Sitemap']['changefreq'] : $defaultFrequency,
          'priority'    => !empty($page['Sitemap']['priority']) ? $page['Sitemap']['priority'] : $defaultPriority
        );
      }
      
      $this->set(compact('output'));
    }
    

  }
?>