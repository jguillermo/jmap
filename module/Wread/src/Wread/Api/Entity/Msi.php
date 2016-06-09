<?php

namespace Wread\Api\Entity;

class Msi {

    private $curl;

	public function __construct() {

	}

	private function getUrl( $guid ) {
		return "http://api.datosabiertos.msi.gob.pe/datastreams/invoke/{$guid}?auth_key=903dea6f412c96948503219e1a41bd0ba91862d4&output=json_array";

	}

    private function curl() {
        if(is_null($this->curl)) {
            $this->curl = new \Jtools\Library\Curl();
        }
        return $this->curl;
    }

	public function getGuidGroup( $url ) {

		$urlparents="http://datosabiertos.msi.gob.pe";

		$str      = new \Jtools\Library\String();

		//$page = 'ner, "dataservice_guid", "JORNA-Y-CAMPA-SALUD");ner, "dataservice_guid", "ACTIV-GRATU");ainer, "dataservice_guid", "CAMPA-VETER");Container, "dataservice_guid", "ACTIV-ATENC-A-LA-PERSO");';
		$page     = $this->curl()->get($url, array(), false);

		//subString
		
		$listGuid = $str->getArraySubStr($page, '"dataservice_guid", "', '"');


		// obtenemos la subcadena conde estan contenidos los parents
		$contParents = $str->subString($page, 'id="sortable"', '/form>');

		$listUrls=$str->getArraySubStr($contParents, 'a href="', '"');
		$listTitles=$str->getArraySubStr($contParents, 'class="handle">', '</a>');


		$dataParent=array();
		foreach ($listUrls as $keyLink =>  $url) {
			$dataParent[]=array('title'=>trim($listTitles[$keyLink]),'url'=>$urlparents.$url);
		}



		
		
		//var_dump($page);exit();
		return array('guid' => $listGuid,'parents'=>$dataParent);
	}

	public function getTableGuid( $guid ) {

        return $this->curl()->get( $this->getUrl( $guid ) );
		
	}

}
