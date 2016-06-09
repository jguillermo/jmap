<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;

class SisController extends BaseController
{

    public function __construct()
    {   
       parent::__construct();
    }

    public function layoutAdminAction()
    {
       return new ViewModel();
    }

}
