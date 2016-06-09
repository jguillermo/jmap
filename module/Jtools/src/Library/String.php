<?php
namespace Jtools\Library;

class String {

	public function __construct() {

	}

	/**
	 * $data = $str->getArraySubStr('djskdfjb"data","1"sdfsef"data","2"sdf','"data","','"');
	  $data = array('1','2');
	 * geenra un array de todos los resulados dentro de un txt que conincidan con el inicio
	 * de un string y con el final de otro string
	 * @param  string $txt       texto a procesar
	 * @param  string $strBefore string inicial a buscar
	 * @param  string $strAfter  string final a buscar
	 * @return array            lista de resultados
	 */
	public function getArraySubStr($txt, $strBefore, $strAfter) {
		$list = array();

		$lenStrBefore = strlen($strBefore);

		$pos = 0;
		do {
			$pos = strpos($txt, $strBefore, $pos);

			//var_dump($pos);

			if ($pos !== false) {
				$postFin = strpos($txt, $strAfter, ($pos + $lenStrBefore));

				//var_dump($postFin);

				if ($postFin !== false) {
					$list[] = substr($txt, ($pos + $lenStrBefore), $postFin - $pos - $lenStrBefore);

					//var_dump($list);

				}

				$pos += $lenStrBefore;

				//var_dump($pos);

			}

		} while ($pos !== false);

		return $list;
	}


	/**
	 * retorna una sub cadena pasando los parametros after y berore a buscar
	 * @param  string $txt       texto a procesar
	 * @param  string $strBefore string inicial a buscar
	 * @param  string $strAfter  string final a buscar
	 * @param  integer $numElemt  numero de elemto a retornar, por defecto retorna el primero
	 * @return obj             retorna la cadena se texto, si no lo encuentra retirna false
	 */
	public function subString($txt, $strBefore, $strAfter,$numElemt=0){
		$data = $this->getArraySubStr($txt, $strBefore, $strAfter);
		if(isset($data[$numElemt])) {
			return $data[$numElemt];
		}else{
			return false;
		}
	}

}