<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{
    public function loadAction()
    {
        return new ViewModel();  
    }

    public function loginAction()
    {
        //if($this->IsLoginAdmin())
        //{
        //    $this->redirect()->toRoute('admin');
        //}
        $msgs     = array();
        
        $employee = new \Api\User\Employee();
        
        $form     = $employee->formLogin();
        
        $request  = $this->getRequest();

        if ($request->isPost())
        {
            $form->setData($request->getPost());
            if ($form->isValid())
            {
                $dataFrm=$form->getData();
                $resultLogin=\Api\Account\AuthenticationAdmin::setLogin($dataFrm['username'],$dataFrm['password']);
                if($resultLogin->isValid())
                {
                    //var_dump(\Api\Account\AuthenticationAdmin::getUserLogin());
                    //$this->redirect()->toRoute('admin');
                }
                else
                {
                    $msgs[]='El Usuario o la contraseña que ingresaste son incorrectos.';
                }    
            }
            /*
            else
            {
                var_dump($form->getMessages());
            }
            */ 
        }
        return new ViewModel(array(
            'form' => $form,
            'msgs' => $msgs
        ));  
    }
}
