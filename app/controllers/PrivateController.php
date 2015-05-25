<?php

class PrivateController extends BaseController{

    public function __construct()
    {
        $this->beforeFilter('auth');
    }

}
