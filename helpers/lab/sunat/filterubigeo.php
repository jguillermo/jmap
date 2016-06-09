<?php

function filterDirUbigeo($dir) {

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

$dir=array();
$dir[]='AV. GREGORIO ESCOBEDO,2 PISO NRO. 762 URB. FUNDO OYAGUE (FRENTE Y C.CULT.PERUANO JAPONES)LIMA - LIMA - JESUS MARIA';

$dir[]='AV. NICOLAS AYLLON NRO. 172 INT. 1410LIMA - LIMA - LIMA';

$dir[]='ALTO LOS INCAS NRO. S-3 URB. LOS INCAS (FRENTE AL COLEGIO)CUSCO - CUSCO - CUSCO';

$dir[]='ALTO LOS INCAS NRO. S-3 URB. LOS INCAS (FRENTE AL COLEGIO)CUSCO -  CUSCO  CUSCO';

foreach ($dir as $v) {
	var_dump($v);
	var_dump(filterDirUbigeo($v));
}