<?php


class RucSunat {

	
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
			'data'=>array('ruc' =>'','rs'  =>'','dir' =>'','ubigeo'=>'')
		);

		try {

			if(!is_string($pagina)) {
				throw new Exception('error al obtener la pagina de la sunat');
			}

			$pagina=$this->comprimirViewjj($pagina);


			$erroCodigo=$this->getsubstringtxt($pagina,array('class="error"','El codigo ingresado es incorrecto'),'>');
			if($erroCodigo['est']) {
				throw new Exception('ERROR el codigo ingresado es incorrecto');
			}


			$erroCodigo=$this->getsubstringtxt($pagina,array('consultado no es válido. Debe verificar el número y volver a ingresar'),'>');
			if($erroCodigo['est']) {
				throw new Exception('ERROR el RUC consultado no es válido. Debe verificar el número y volver a ingresar');
			}


			//$erroCodigo=$this->getsubstringtxt($pagina,array('class="error"','El codigo ingresado es incorrecto'),'>');
			//if($erroCodigo['est']) {
			//	throw new Exception('ERROR el codigo ingresado es incorrecto');
			//}
			//El Sistema RUC NO REGISTRA un número de RUC para el Nombre o Razón Social


			//

			$prueba=$this->getsubstringtxt($pagina,array('N&uacute;mero de RUC'),'-');
			if(!$prueba['est']) {
				throw new Exception('error con el codigo o el ruc');
			}

			$ruc=$this->getsubstringtxt($pagina,array('N&uacute;mero de RUC','<td','>'),'-');

			$rs=$this->getsubstringtxt($pagina,array('-'),'</td',$ruc['data']['post']);

			$dir=$this->getsubstringtxt($pagina, array('Direcci&oacute;n del Domicilio','<td','>'), '</', $rs['data']['post']);

			$dir_ubi=$this->filterDirUbigeo($dir['data']['txt']);

			$data['data']=array(
				'ruc'    =>$ruc['data']['txt'],
				'rs'     =>$rs['data']['txt'],
				'dir'    =>$dir_ubi['dir'],
				'ubigeo' =>$dir_ubi['ubigeo'],
			);

			$data['est']=true;
			
		} catch (Exception $e) {
			$data['est']=false;
			$data['msg']=$e->getMessage();
		}

		return $data;

	}


	private function filterDirUbigeo($dir) {

		$data_return=array(
			'dir'=>$dir,
			'ubigeo'=>''
		);

		$deps=array(
			'AMAZONAS',       
			'ANCASH',         
			'APURIMAC',       
			'AREQUIPA',       
			'AYACUCHO',       
			'CAJAMARCA',      
			'CALLAO',         
			'CUSCO',          
			'HUANCAVELICA',   
			'HUANUCO',        
			'ICA',            
			'JUNIN',          
			'LA LIBERTAD',    
			'LAMBAYEQUE',     
			'LIMA',           
			'LORETO',         
			'MADRE DE DIOS',  
			'MOQUEGUA',       
			'PASCO',          
			'PIURA',          
			'PUNO',           
			'SAN MARTIN',     
			'TACNA',          
			'TUMBES',         
			'UCAYALI',    
		);

		$primerguion = strrpos($dir, ' - ');

		if($primerguion===false){
			return $data_return;
		}
		
		$segundoguion = strrpos($dir, ' - ',($primerguion-strlen($dir)-1 ));

		if($segundoguion===false){
			return $data_return;
		}

		$txtdirdep=substr($dir, 0,$segundoguion);

		
		foreach ($deps as $dep) {
			$lendep=strlen($dep)*-1;
			if(substr($txtdirdep, $lendep)==$dep){
				$data_return=array(
					'dir'    =>substr($txtdirdep,0,strlen($txtdirdep)+$lendep),
					'ubigeo' =>$dep.substr($dir, $segundoguion)
				);
			}
		}

		return $data_return;

	}


	/**
	 * genera la imagen del capcha y retorna la cookie asiciada a la imagen
	 * @return strimg valores de la cookie a usar
	 */
	public  function getCookieImg() {
		$URL_path='http://www.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=image';
		$ch = curl_init($URL_path);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// get headers too with this line
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$result = curl_exec($ch);
		curl_close ($ch);
		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);

		$cookies = '';
		foreach($matches[1] as $item) {
		    parse_str($item, $cookie);
		    $cookies.=$item.'; '; 
		}
		
		$cookies=trim(trim($cookies),';');


		$headimg=explode("Transfer-Encoding: chunked",$result);
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
		$fp = fopen($this->imgfile,'w') or die("Unable to open file!");
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

	public function processRuc($ruc,$codigo,$cookie) {
		//$ruc=(isset($_POST['ruc']))? $_POST['ruc']:'';
		//$codigo=(isset($_POST['codigo']))? $_POST['codigo']:'';
		//$cookie=(isset($_POST['cookie']))? $_POST['cookie']:'';
		$data=array(
			'est'=>false,
			'msg'=>'',
			'data'=>array()
		);

		try {


			if(!$this->isrucok($ruc)) {
				throw new Exception('ERROR no es un ruc valido');
			}

			$codigo=$this->processCodigo($codigo);
			$postData=array(
					'accion'   => 'consPorRuc', 
					'razSoc'   => '', 
					'nroRuc'   => $ruc, 
					'nrodoc'   => '', 
					'contexto' => 'ti-it', 
					'tQuery'   => 'on', 
					'search1'  => $ruc, 
					'codigo'   => $codigo, 
					'tipdoc'   => '1', 
					'search2'  => '', 
					'coddpto'  => '', 
					'codprov'  => '', 
					'coddist'  => '', 
					'search3'  => '', 
			);
			
			$pagina=$this->processSunat($postData,$cookie);
	
			$filtro = $this->filtraelementos($pagina);

			if(!$filtro['est']){
				throw new Exception($filtro['msg']);
			}
			$data['data']=$filtro['data'];


			$data['est']=true;
			
		} catch (Exception $e) {
			$data['est']=false;
			$data['msg']=$e->getMessage();
		}

		return $data;





		

	}

	public function listaRs($rs,$codigo,$cookie) {
		
		$codigo=$this->processCodigo($codigo);




		$rs=trim($rs);
		$rs=str_replace(array('á','é','í','ó','ú','Á','É','Í','Ó','Ú'), array('A','E','I','O','U','A','E','I','O','U'), $rs);
		$rs=strtoupper($rs);


		$postData=array(
			'accion'   => 'consPorRazonSoc',
			'razSoc'   => $rs,
			'nroRuc'   => '',
			'nrodoc'   => '',
			'contexto' => 'ti-it',
			'search1'  => '',
			'codigo'   => $codigo,
			'tipdoc'   => '1',
			'search2'  => '',
			'tQuery'   => 'on',
			'coddpto'  => '',
			'codprov'  => '',
			'coddist'  => '',
			'search3'  => $rs,
		);

		$pagina=$this->processSunat($postData,$cookie);

		return $this->getListRs($pagina);


	}


	private function getListRs($pagina) {



		$data=array(
			'est'=>false,
			'msg'=>'',
			'data'=>array()
		);

		try {



			$erroCodigo=$this->getsubstringtxt($pagina,array('class="error"','El codigo ingresado es incorrecto'),'>');
			if($erroCodigo['est']) {
				throw new Exception('ERROR el codigo ingresado es incorrecto');
			}


			$erroNoExiste=$this->getsubstringtxt($pagina,array('El Sistema RUC NO REGISTRA un número de RUC para el Nombre o Razón Social'),'>');
			if($erroNoExiste['est']) {
				throw new Exception('ERROR no se encuentran conincidencias');
			}



			
			foreach ($this->getArraySubStr($pagina,"javascript:sendNroRuc","</tr") as $row) {
				//var_dump($row);	
				
	
				$ruc=$this->getsubstringtxt($row,array('>'),'<');
				$rs=$this->getsubstringtxt($row,array('<td','>'),'</td',$ruc['data']['post']);
				$ubi=$this->getsubstringtxt($row,array('<td','>'),'</td',$rs['data']['post']);
				$est=$this->getsubstringtxt($row,array('<td','>'),'</td',$ubi['data']['post']);
	
				$data['data'][]=array(
					'ruc' =>$ruc['data']['txt'],
					'rs'  =>$rs['data']['txt'],
					'ubi' =>$ubi['data']['txt'],
					'est' =>$est['data']['txt']
				);
			}


			if(count($data['data'])==0){
				throw new Exception('ERROR no se encuentran conincidencias');
			}
			
			$data['est']=true;

		} catch (Exception $e) {
			$data['est']=false;
			$data['msg']=$e->getMessage();
		}

		return $data;




		

	}

	private function processSunat($postData,$cookie) {
		$URL_path = "http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
		$elements = '';
		foreach ($postData as $key => $value) {
			//var_dump($key,$value);
			if (is_array($value)) {
				foreach ($value as $k1 => $v1) {
					$elements .= $key . '[' . $k1 . ']=' . urlencode($v1) . '&';
				}
			} else {
				$elements .= $key . '=' . urlencode(utf8_decode($value)) . '&';
			}
		
		}
		$elements=rtrim($elements, '&');

		//var_dump($elements);
		
		
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


	public function isrucok($ruc){
		$est=false;
		if (preg_match('/^[0-9]{11}$/',$ruc)) {
			$lastNumber=$this->getLastNumber(substr($ruc,0,10));
			if($lastNumber!==false && $lastNumber==substr($ruc,10,1)){
				$est=true;
			}
		}
		return $est;
	}

	public function getLastNumber($txt){
		if (!preg_match('/^[0-9]{10}$/',$txt)) {
			return false;
		}
		$suma = 0;
		$x = 6;
		for ($i=0; $i<10;$i++){
		  if ( $i == 4 ) $x = 8;
		  $digito = substr($txt,$i,1);
		  $x--;
		  $suma+= ($digito*$x);
		}
		$resto = $suma % 11;
		$resto = 11 - $resto;
		if ( $resto >= 10) {
			$resto = $resto - 10;
		}
		return $resto;
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

		$data=array(
			'est'=>false,
			'msg'=>'',
			'data'=>array('txt' =>'','post' =>'')
		);
		try {

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