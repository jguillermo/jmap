<?php

namespace Admin\Controller;

use Zend\View\Model\JsonModel;

class EntityController extends BaseController {

	protected $entity;

	protected $entityName;

	public function __construct($entityName = '') {
		parent::__construct();
		$this->entityName = $entityName;
	}

	protected function entity() {
		if (is_null($this->entity)) {
			$this->entity = new $this->entityName();
		}
		return $this->entity;
	}
	public function listAllAction() {

		$jsonp =  new JsonModel(array(
			'list' => $this->entity()->table()->getAllFilter(),
		));

		$callback = $this->getRequest()->getQuery('callback',false);
		if($callback){
			$jsonp->setJsonpCallback($callback);
		}
		return $jsonp;

	}

	public function entityBlockAction() {
		$jsonp = new JsonModel(array(
			'list' => $this->entity()->getData(),
		));


		$callback = $this->getRequest()->getQuery('callback',false);
		if($callback){
			$jsonp->setJsonpCallback($callback);
		}
		return $jsonp;

	}

}