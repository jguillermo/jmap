<?php
namespace SkeletonModule\Controller;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
//use Zend\Math\Rand;
class BaseController extends AbstractActionController
{
    Protected $dataView;

    public function __construct()
    { 
        //sleep(5);
        $this->dataView=array(
            //'nk'              => Rand::getString(32, 'abcdefghijklmnopqrstuvwxyz', true),
            'isLogin'         => false,//\Api\Account\AuthenticationAdmin::isLogin(),
            'state'           => false,
            'showmsg'         => false,
            'msg'             => array() 
        );
    }
 
    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);
        $controller = $this;
        $subru = \SkeletonModule\Util\Route::get();
        $events->attach('dispatch', function ($e) use ($controller,$subru)
        {
            //if(!\Api\Account\AuthenticationAdmin::isLogin())
            //{
            //    switch ($subru)
            //    {
            //        case 'ajax':
            //        case 'json':
            //            return $controller->redirect()->toRoute('admin/json',array('controller'=>'admin','action'=>'logout-json'));
            //            break;
            //        //   break;
            //        default:
            //            return $controller->redirect()->toRoute('admin/html',array('controller'=>'account','action'=>'login'));
            //            break;
            //    }
            //}
            
        }, 100);
    }
}

/*

$sqlSelect = $this->table()->getSql()->select();
$sqlSelect->columns(array('column_name'));
$sqlSelect->join('othertable', 'othertable.id = yourtable.id', array(), 'left');
$resultSet = $this->tableGateway->selectWith(sqlSelect);
return $resultSet;

*/




        // $data = array(
        //     'result' => true,
        //     'data' => array()
        // );
        // return $this->getResponse()->setContent(json_encode($data));



        // quitar el layout por defecto
        //$view = new ViewModel(array('form'=>$tipodoc->form()));
        //$view->setTerminal(true);
        //return $view;
