<?php

namespace Wread\Controller;

use Zend\View\Model\ViewModel;

class DashboardController extends BaseController
{

    public function __construct()
    {   
       parent::__construct();
    }

    public function indexAction()
    {
       return new ViewModel();
    }

}
