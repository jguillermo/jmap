<?php

namespace Wread\Controller;

use Zend\Db\TableGateway\TableGateway;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class GeocodeController extends BaseController {

	public function __construct() {
		parent::__construct();
	}

	public function indexAction() {
		return new ViewModel();
	}

	public function urlAction() {

		$curl = new \Jtools\Library\Curl();
        
        $key="&key=AIzaSyC1kN_mt9f-KCks3hAO0DU1m1h_3iEGEio"; //construcionicg
        //$key="&key=AIzaSyC3MJkXK8ffXj4HK4jVS7dZK1xli_IVYe8"; // jguillermoicg

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?language=es'.$key.'&components=country%3APE&address=PAZ+SOLDAN+159%2C+San+isidro%2C+Lima';
        $datagapi = $curl->get($url);
        var_dump($datagapi);exit();

		return new JsonModel(array(
			'tables' => '',
		));
	}

    public function getListDbAction() {

        $adapter = \Jmap\Model\Adapter::getAdapter('msi');
        $metadata = new \Zend\Db\Metadata\Metadata($adapter);
        $tableNames = $metadata->getTableNames();
        return new JsonModel(array(
            'tables' => $tableNames,
        ));
    }

	public function getColumnsTableAction() {

		$datos = json_decode(file_get_contents("php://input"), true);
		$tableName = $datos['table'];

		$adapter = \Jmap\Model\Adapter::getAdapter('msi');

		$projectTable = new TableGateway($tableName, $adapter);
		$rowset = $projectTable->select(array('id' => 1));

		$row = $rowset->current();

		$columns = array();

		if (is_object($row)) {
			foreach ($row as $key => $value) {
				$columns[] = array('name' => $key, 'val' => $value);
			}
		}

		return new JsonModel(array(
			'columns' => $columns,
		));
	}

	public function processTotalAction() {

		$datos = json_decode(file_get_contents("php://input"), true);
		$tableName = $datos['name'];

		$adapter = \Jmap\Model\Adapter::getAdapter('msi');

		$projectTable = new TableGateway($tableName, $adapter);

		$rowset = $projectTable->select(function (\Zend\Db\Sql\Select $select) {
			$select->columns(array('count' => new \Zend\Db\Sql\Expression('COUNT(*)')));
			$select->where('id_lugar IS NULL');
		});
		$row = $rowset->current();

		return new JsonModel(array(
			'total' => (int) $row->count,
		));
	}

	public function processAjaxAction() {
		//sleep(2);

		$datos = json_decode(file_get_contents("php://input"), true);

		//var_dump($datos);
		$adapter = \Jmap\Model\Adapter::getAdapter('msi');

		$rp = $datos['rp'];
		$page = $datos['ajaxPage'];

		$tableName = $datos['data']['name'];
		$tableCatastro = $datos['data']['catastro'];
		$tableAddress = $datos['data']['address'];
		$tableNumber = $datos['data']['number'];
		$tableDist = trim(trim($datos['data']['dist']),',');

		// poa hoar toda la progra,acion se va aponer en este lugar, se debe cambiar este comprtamiento

		$projectTable = new TableGateway($tableName, $adapter);

		$rowset = $projectTable->select(function (\Zend\Db\Sql\Select $select) use ($rp, $page) {
			$select->where('id_lugar IS NULL');
			$offset = 0; //(int) (($page - 1) * $rp);
			$select->limit($rp);
			$select->offset($offset);
		});


        $rutasllamadas=array();

		if (is_object($rowset)) {

			$geocodeTable = new TableGateway('geocode', $adapter);

			foreach ($rowset as $row) {
				$catastro = trim($row->$tableCatastro);
				if (strlen($catastro) < 8) {
					$catastro = '';
				} else {
					$catastro = substr($catastro, 0, 8);
				}

                // mejorando la data de direccion
                $tblAddress= str_replace(array(',','.','-','_','"',"'",';'), " ", $row->$tableAddress) ;

				$direccion = $tblAddress . ' ' . $row->$tableNumber . ', ' . $tableDist;




				$idrow = $row->id;

				// buscar codigo catastral en la base de datos
                if($catastro==''){
                    $rowubi = null;
                }else{
                   $rowsetubi = $geocodeTable->select(function (\Zend\Db\Sql\Select $select) use ($catastro) {
                    $select->where(array('catastro' => $catastro));
                    $select->limit(1);
                });
                $rowubi = $rowsetubi->current(); 
                }
				
				// ya esta registrado el catastro en al base de datos
				if (is_object($rowubi)) {
					$id_lugar = (int) $rowubi->id;
					$projectTable->update(array('id_lugar' => $id_lugar), array('id' => $idrow));
				} else {
					// buscar en la gogole api
					$curl = new \Jtools\Library\Curl();
					//urlencode


                    $keyApiGoogle="&key=AIzaSyC1kN_mt9f-KCks3hAO0DU1m1h_3iEGEio"; //construcionicg
                    //$keyApiGoogle="&key=AIzaSyC3MJkXK8ffXj4HK4jVS7dZK1xli_IVYe8"; // jguillermoicg

					$url = 'https://maps.googleapis.com/maps/api/geocode/json?language=es'.$keyApiGoogle.'&components=country%3APE&address=' . urlencode($direccion);
					$datagapi = $curl->get($url);

					//var_dump($url);
					//foreach ($datagapi as $key => $value) {
					//	var_dump($key, $value);
					//}
					//var_dump($datagapi['results']['geometry']);exit();
					//var_dump(afdgvadfv);
                    

                    $formatted_address='';
                    if(count($datagapi['results'])==0){
                        $rutasllamadas[]=array('url'=>$url,'data'=>$datagapi);
                        $location['lng'] = '-75.015152';
                    }else{
                        $location = $datagapi['results'][0]['geometry']['location'];

                        $formatted_address = (isset($datagapi['results'][0]["formatted_address"]))? $datagapi['results'][0]["formatted_address"] :'';

                        
                    }
					

					// no existe, este es la coordenada de peru
					if ($location['lng'] == '-75.015152') {
						$projectTable->update(array('id_lugar' => -1), array('id' => $idrow));
					} else {

                        $data_geo_insert=array(
                            'dir_original' => $direccion,
                            'catastro' => $catastro,
                            'lat' => $location['lat'],
                            'long' => $location['lng'],
                        );

                        if($formatted_address!=''){
                            $data_geo_insert['direccion']=$formatted_address;
                        }

						// si existe
						$geocodeTable->insert($data_geo_insert);

						$last_id = $geocodeTable->getLastInsertValue();

						$projectTable->update(array('id_lugar' => $last_id), array('id' => $idrow));
					}

				}

				//var_dump($catastro, $direccion);
				//var_dump('-----------------');

			}

		}

		return new JsonModel(array(
			'columns' => $rutasllamadas,
		));
	}

	
}
