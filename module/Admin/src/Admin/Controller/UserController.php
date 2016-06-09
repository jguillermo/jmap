<?php

namespace Admin\Controller;

use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class UserController extends BaseController {

	public function __construct() {
		parent::__construct();
	}

	public function indexAction() {

		//$encrip = new \Jmap\Util\Crypt();
		//
		//$add=$encrip->addStrRandom('hola');
		//$rem=$encrip->removeStrRandom($add);
		//
		//var_dump($add,$rem);

		$encrip = new \Jmap\Util\Crypt();

		$e = $encrip->encode('hola');
		$d = $encrip->decode($e);
		var_dump($e, $d);

		$e = $encrip->dynamicEncode('hola');
		$d = $encrip->dynamicDecode($e);
		var_dump($e, $d);

		//sleep(5);
		return new ViewModel();
	}

	public function listaAction() {
		//sleep(5);
		$user = new \Api\User\User();

		$jsonp = new JsonModel(array(
			'users' => $user->table(true)->getRelation(),
		));

		$callback = $this->getRequest()->getQuery('callback',false);
		if($callback){
			$jsonp->setJsonpCallback($callback);
		}
		

		return $jsonp;
	}

	public function editNewAction() {
		//sleep(5);
		return new ViewModel();
	}

	public function listAction() {
		//sleep(5);
		return new ViewModel();
	}

	public function searchAction() {


		// trabajr en esta libreria para mejorar el filtrado de datos 
		$request = $this->getRequest();

		$userSearch = array();


		$data = $request->getQuery('data',false);

		if( $data ) {
			$data=json_decode($data, true);
			//var_dump($data);exit();
			if(!isset($data['data']['value'])) {
				$data=false;
			}
		}

		if ($data) {
			$user     = new \Api\User\User();
			$column = 'name';
			$search = array(
				array('column' => $column, 'value' => $data['data']['value'], 'type' => 'like'),
			);
			$userSearch = $user->table(true)->search($search);

		}
		//sleep(5);

		$jsonp =  new JsonModel(array(
			'users' => $userSearch,'data'=>$data
		));
		$callback = $request->getQuery('callback',false);
		if($callback){
			$jsonp->setJsonpCallback($callback);
		}
		return $jsonp;
	}

	public function getByIdAction() {

		$request = $this->getRequest();

		$dataUser = array();


		$data = $request->getQuery('data',false);

		if($data) {
			$data=json_decode($data, true);
			//var_dump($data);exit();
			if(!isset($data['data']['id'])) {
				$data=false;
			}
		}


		if ($data) {
			$encrip = new \Jmap\Util\Crypt();

			
			$id   = $encrip->dynamicDecode($data['data']['id']);
			//var_dump($data,$id);exit();

			$user     = new \Api\User\User();
			$dataUser = $user->getAllData($id);
		}

		$jsonp = new JsonModel(array(
			'user' => $dataUser,'id'=>$id,
		));


		$callback = $request->getQuery('callback',false);
		if($callback){
			$jsonp->setJsonpCallback($callback);
		}
		return $jsonp;

	}

	public function phoneEntityBlockAction() {

		//sleep(5);

		$userPhone = new \Api\User\Phone();
		
		$jsonp =  new JsonModel(array(
			'list' => $userPhone->getData(),
		));

		$callback = $request->getQuery('callback',false);
		if($callback){
			$jsonp->setJsonpCallback($callback);
		}
		return $jsonp;

	}

	public function listIdentityTypeAction() {

		$userIdentityType = new \Api\User\IdentityType();
		$jsonp = new JsonModel($userIdentityType->getListCountUser());

		$callback = $request->getQuery('callback',false);
		if($callback){
			$jsonp->setJsonpCallback($callback);
		}
		return $jsonp;

	}
}