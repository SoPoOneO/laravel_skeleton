<?php

class BaseController extends Controller {

	public $breadcrumbs = [];

  /**
   * Initializer.
   *
   * @access   public
   * @return \BaseController
   */
    public function __construct()
    {
        $this->beforeFilter('csrf', ['on' => ['put', 'path', 'post', 'delete']]);
        $this->setNav('home');
        $this->addCrumb('Home', '/');
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
    		$this->breadcrumbs[] = [
     			'name' => $name,
     			'url' => $url
     		];
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
