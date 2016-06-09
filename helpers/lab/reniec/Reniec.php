<?php


class Reniec {

	
	//private $imgfile;
	public function __construct() {
		
	}
	//public function __construct($imgfile) {
	//	$this->imgfile = $imgfile;
	//}

	/**
	 * limpia el string, quita los enter, tabbulador, quita los 2 espacions en blanco
	 * @param  string $view texto a limpiar
	 * @return string       texto limpio
	 */
	private function comprimirViewjj($view) {
		$view  = trim(str_replace(array("\n","\t","\r")," ",$view)); // quita los enter tabular
	    $view  = preg_replace("/([ ]){2,}/"," ",$view);// quita espacios en blanco
	    $view  = trim(str_replace(" <","<",$view)); 
	    $view  = trim(str_replace("> ",">",$view)); 
		return $view;
	}
	
	private function filtraelementos($pagina) {

		$data=array(
			'est'=>false,
			'msg'=>'',
			'data'=>array('dni' =>'','nom'  =>'','app' =>'','apm'=>'')
		);

		try {

			//echo $pagina;

			if(!is_string($pagina)) {
				throw new Exception('error al cargar la pagina de la reniec');
			}

			$prueba=$this->getsubstringtxt($pagina,array('Resultado de la Consulta de Datos'),'>');
			if(!$prueba['est']) {
				throw new Exception('error al cargar la pagina de la reniec');
			}

			$noexisteDni=$this->getsubstringtxt($pagina,array('No se encuentra en el Archivo Magn&eacute;tico del RENIEC'),'>',$prueba['data']['post']);
			if($noexisteDni['est']) {
				throw new Exception('ERROR el DNI no existe');
			}

			$erroCodigo=$this->getsubstringtxt($pagina,array('Ingrese el c&oacute;digo que aparece en la imagen'),'>',$prueba['data']['post']);
			if($erroCodigo['est']) {
				throw new Exception('ERROR Ingrese el c&oacute;digo que aparece en la imagen');
			}

			$erroMenorEdad=$this->getsubstringtxt($pagina,array('pertenece a un menor de edad.'),'>',$prueba['data']['post']);
			if($erroMenorEdad['est']) {
				throw new Exception('ERROR el DNI pertenece a un menor de edad.');
			}


			

			$nom_app_apm=$this->getsubstringtxt($pagina,array('table>','tr>','<td','>'),'<br>',$prueba['data']['post']);

			if(!$nom_app_apm['est']){
				throw new Exception('ERROR al cargar los datos de la reniec');
			}

			$dni=$this->getsubstringtxt($pagina,array('>'),'<',$nom_app_apm['data']['post']);

			if(!$dni['est']){
				throw new Exception('ERROR al cargar los datos de la reniec');
			}

			$sepnom=explode("\n", trim($nom_app_apm['data']['txt']));

			$nom=trim($sepnom[0]);
			$app=(isset($sepnom[1]))? trim($sepnom[1]):'';
			$apm=(isset($sepnom[2]))? trim($sepnom[2]):'';

			
			//var_dump($dni);
			//var_dump($sepnom);
			//exit();

			$data['data']=array(
				'dni' => trim($dni['data']['txt']),
				'nom' => $nom,
				'app' => $app,
				'apm' => $apm
			);

			$data['est']=true;
			
		} catch (Exception $e) {
			$data['est']=false;
			$data['msg']=$e->getMessage();
		}

		return $data;

	}


	


	/**
	 * genera la imagen del capcha y retorna la cookie asiciada a la imagen
	 * @return strimg valores de la cookie a usar
	 */
	public  function getCookieImg() {
		$URL_path='https://cel.reniec.gob.pe/valreg/codigo.do';
		$ch = curl_init($URL_path);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// get headers too with this line
		curl_setopt($ch, CURLOPT_HEADER, 1);

		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

		$result = curl_exec($ch);
		curl_close ($ch);


		


		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);

		$cookies = '';
		foreach($matches[1] as $item) {
		    parse_str($item, $cookie);
		    $cookies.=$item.'; '; 
		}
		
		$cookies=trim(trim($cookies),';');


		$headimg=explode(",0:1)",$result);
		$img_curl=trim($headimg[1]);
		//$this->saveimg($img_curl);
		$img64= 'data:image/jpeg;base64,' . base64_encode($img_curl);



		//var_dump($this->imgfile);
		
		//$chimg = curl_init ($URL_path);
		//curl_setopt($chimg, CURLOPT_HEADER, 0);
		//curl_setopt($chimg, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($chimg, CURLOPT_BINARYTRANSFER,1);
		//curl_setopt( $chimg, CURLOPT_COOKIE, $cookies ); 
		//$resultimg=curl_exec($chimg);
		//curl_close ($chimg);
		//
		//$fp = fopen($this->ruta_img .'imgsunat.jpg','wb');
		//fwrite($fp, $resultimg);
		//fclose($fp);

		return array('cookie'=>$cookies,'img'=>$img64);
	}

	private function saveimg($img_curl) {
		$fp = fopen('./imgreniec.jpg','w') or die("Unable to open file!");
		fwrite($fp, $img_curl);
		fclose($fp);
	}

	private function processCodigo($codigo){
		$codigo=trim($codigo);
		$codigo=str_replace(" ", "", $codigo);
		$codigo=str_replace("|", "I", $codigo);
		$codigo=str_replace(array('á','é','í','ó','ú','Á','É','Í','Ó','Ú'), array('A','E','I','O','U','A','E','I','O','U'), $codigo);
		$codigo=strtoupper($codigo);
		return $codigo; 
	}

	public function processDni($dni,$codigo,$cookie) {
		//$ruc=(isset($_POST['ruc']))? $_POST['ruc']:'';
		//$codigo=(isset($_POST['codigo']))? $_POST['codigo']:'';
		//$cookie=(isset($_POST['cookie']))? $_POST['cookie']:'';
		$codigo=$this->processCodigo($codigo);
		$postData=array(
			'accion'          =>'buscar',
			'tecla_7'         =>'4',
			'tecla_8'         =>'1',
			'tecla_9'         =>'8',
			'tecla_4'         =>'6',
			'tecla_5'         =>'5',
			'tecla_6'         =>'0',
			'tecla_1'         =>'9',
			'tecla_2'         =>'7',
			'tecla_3'         =>'2',
			'tecla_0'         =>'3',
			'nuDni'           =>$dni,
			'imagen'          =>$codigo,
			'bot_consultar.x' =>'110',
			'bot_consultar.y' =>'10',
		);

		$pagina=$this->processReniec($postData,$cookie);

		//$pagina=str_replace('src="', 'src="https://cel.reniec.gob.pe/valreg/', $pagina);
		//$pagina=str_replace('href="', 'href="https://cel.reniec.gob.pe/valreg/', $pagina);

		//echo $pagina;exit();

		return $this->filtraelementos($pagina);

	}

	private function processReniec($postData,$cookie) {
		$URL_path = "https://cel.reniec.gob.pe/valreg/valreg.do";
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
		
		curl_setopt($curl, CURLOPT_URL, $URL_path);
		
		
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $elements);
		
		curl_setopt( $curl, CURLOPT_COOKIE, $cookie ); 
		
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_REFERER, '');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		if(substr($URL_path,0,5)=="https"){
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
		}
		
		$data = curl_exec($curl);

		//echo($data);
		
		//if($data === false)
		//{
		//    echo 'Curl error: ' . curl_error($curl);
		//}
		
		if (is_resource($curl)) {
			curl_close($curl);
		}
		
		return utf8_encode($data);

		


	}



	/**
	 * en esta primera version txtafter es solo un string
	 * se debe mejorar este script
	 * ($txt,array('<table','<tr','<td'),array('</td','</tr'))
	 * buscara en la tabla y selecionar el texto dentro del td y tambien retorna la pocion de </td.
	 * busca una cadena en de texto, filtrado por los dato sini y fin
	 * @param  string  $txt     texto a buscar
	 * @param  array  $txtBefore listado de string que se debe completar para que encuentre lo buscado
	 * @param  array  $txtAfter listado de string que se va abuscar para que s encuentre lo buscado
	 * @param  int $txtpost  iniciar en la posicion x
	 * @return array           texto y la posicion del texto encontrado
	 */
	private function getsubstringtxt($txt,$txtBefore,$txtAfter,$txtpost=0) {

		//var_dump($txtpost);
		//var_dump(is_numeric($txtpost));

		
		$data=array(
			'est'=>false,
			'msg'=>'',
			'data'=>array('txt' =>'','post' =>'')
		);
		try {

			if(!is_numeric($txtpost)){
				throw new Exception('Error de servidor, no se envio los datos a la busqueda corectamente');
			}

			$lenStrBefore=0;
			foreach ($txtBefore as $before) {
				$txtpost = strpos($txt, $before, $txtpost);
				if ($txtpost === false) {
					throw new Exception('no existe :'.$before);
				}
				$lenStrBefore = strlen($before);
			}
			$txtpostfin = strpos($txt, $txtAfter, $txtpost);
			if ($txtpostfin === false) {
				throw new Exception('no existe :'.$txtAfter);
			}

			$data['data']=array(
				'txt'=>substr($txt, ($txtpost + $lenStrBefore), $txtpostfin - $txtpost - $lenStrBefore),
				'post'=>$txtpostfin,
			);
			$data['est']=true;
			
		} catch (Exception $e) {

			$data['est']=false;
			$data['msg']=$e->getMessage();
			
		}
	
		return $data;
	
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
	private function getArraySubStr($txt, $strBefore, $strAfter) {
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
	private function subString($txt, $strBefore, $strAfter,$numElemt=0){
		$data = $this->getArraySubStr($txt, $strBefore, $strAfter);
		if(isset($data[$numElemt])) {
			return $data[$numElemt];
		}else{
			return false;
		}
	}




}