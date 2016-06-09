<?php
namespace Jtools\Library;

class Curl {

	public function __construct() {

	}

	/**
	 * retorna una pagina web en forma de curl de una url especifica
	 * @param  string  $url      url de la pagina web , solo poner controlador y function del sistema admin
	 * @param  array   $postData datos del post, si no es array json se pone atrue
	 * @param  boolean $json     forma del dato de laconsulta, true convierte el string en array
	 * @return obj            retorno de la respuesta, puede ser html, o array
	 */
	public function get($url, $postData = array(), $json = true) {
		//$postData = array("user" => ontuts, "password" => "test");
		/*Convierte el array en el formato adecuado para cURL*/

		$elements = '';

		foreach ($postData as $key => $value) {
			//var_dump($key,$value);
			if (is_array($value)) {
				foreach ($value as $k1 => $v1) {
					$elements .= $key . '[' . $k1 . ']=' . urlencode($v1) . '&';
				}
			} else {
				$elements .= $key . '=' . urlencode($value) . '&';
			}

		}
		rtrim($elements, '&');

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36");

		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept-Language: es-es,en"));

		curl_setopt($curl, CURLOPT_URL, $url);

		if ($elements == '') {
			curl_setopt($curl, CURLOPT_POST, false);
		} else {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $elements);
		}

		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_REFERER, '');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		if(substr($url,0,5)=="https"){
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
		}

		

		$data = curl_exec($curl);

		if (is_resource($curl)) {
			curl_close($curl);
		}

		if ($json) {
			$data = @json_decode($data, true);
		}
		return $data;

	}

}