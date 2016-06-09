<?php
namespace ApiTest;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
abstract class Base extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    

    public function setUp()
    {
        $this->setApplicationConfig(
            include(__DIR__."/../../../../config/application.config.php")
        );
        parent::setUp();
        
    }

    

}