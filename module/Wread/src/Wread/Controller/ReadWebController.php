<?php

namespace Wread\Controller;

use Zend\View\Model\JsonModel;

class ReadWebController extends BaseController {

	public function __construct() {
		parent::__construct();
	}

	public function processUrlAction() {


        $request = $this->getRequest();

        $dataProcess = array();

        if ($request->isPost()) {
            $data = json_decode(file_get_contents("php://input"), true);
            $w= new \Wread\Api\ProcessEntity($data['ent']);
            $dataProcess= $w->getContGroup($data['url']);
        }
        

        //$w= new \Wread\Api\ProcessUrl();    $dataProcess= $w->get('www','msi');exit();

          
        
		return new JsonModel($dataProcess);
	}

    public function getTableGuidAction() {
        $request = $this->getRequest();

        $tableGuid = array();

        if ($request->isPost()) {

            $data = json_decode(file_get_contents("php://input"), true);

            $ui = new \Wread\Api\ProcessEntity($data['ent']);

            $tableGuid= $ui->getTableGuid($data['guid']);



        }
        
        return new JsonModel($tableGuid);
    }

}
