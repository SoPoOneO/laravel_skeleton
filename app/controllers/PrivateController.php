<?php

class PrivateController extends BaseController{

    public function __construct()
    {
    	parent::__construct();
        $this->beforeFilter('auth');
    }

}
