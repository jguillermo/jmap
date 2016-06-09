<?php

namespace SkeletonModule\Controller;

use Zend\View\Model\ViewModel;

class AppController extends BaseController
{

    public function __construct()
    {   
       parent::__construct();
    }

    public function layoutAction()
    {
       return new ViewModel();
    }

}
