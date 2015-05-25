<?php

class BaseController extends Controller {

	public $breadcrumbs = array();

  /**
   * Initializer.
   *
   * @access   public
   * @return \BaseController
   */
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => array('post', 'delete', 'put')));
        $this->beforeFilter('ajax', array('on' => array('post', 'delete', 'put')));
        $this->setNav('');
        View::share('breadcrumbs', $this->breadcrumbs);
    }


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    protected function setNav($nav)
    {
        View::share('current_nav', $nav);
    }

	protected function addCrumb($name, $url='')
	{
        if($name){
    		$this->breadcrumbs[] = array(
     			'name' => $name,
     			'url' => $url
     		);
        }

        View::share('breadcrumbs', $this->breadcrumbs);
 		
        return $this->breadcrumbs;
    }

    protected function resetCrumbs($name=null, $url=null)
    {
        $this->breadcrumbs = array();

        return $this->addCrumb($name, $url='');
    }

}
