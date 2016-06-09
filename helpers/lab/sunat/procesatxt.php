<?php



function comprimirViewjj($view) {
		$view  = trim(str_replace(array("\n","\t","\r")," ",$view)); // quita los enter tabular
    	$view  = preg_replace("/([ ]){2,}/"," ",$view);// quita espacios en blanco
    	$view  = trim(str_replace(" <","<",$view)); 
    	$view  = trim(str_replace("> ",">",$view)); 
		return $view;
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
function getsubstringtxt($txt,$txtBefore,$txtAfter,$txtpost=0) {
	
	$lenStrBefore=0;
	foreach ($txtBefore as $before) {
		$txtpost = strpos($txt, $before, $txtpost);
		if ($txtpost === false) {
			exit('no existe :'.$before);
		}
		$lenStrBefore = strlen($before);
	}

	$txtpostfin = strpos($txt, $txtAfter, $txtpost);

	if ($txtpostfin === false) {
		exit('no existe :'.$txtAfter);
	}

	return array(
		'txt'=>substr($txt, ($txtpost + $lenStrBefore), $txtpostfin - $txtpost - $lenStrBefore),
		'post'=>$txtpostfin,
	);

}



$página_inicio = comprimirViewjj(file_get_contents('./rpta_persona.php'));





$ruc=getsubstringtxt($página_inicio,array('N&uacute;mero de RUC','<td','>'),'-');

$nombre=getsubstringtxt($página_inicio,array('-'),'</td',$ruc['post']);

$direccion=getsubstringtxt($página_inicio, array('Direcci&oacute;n del Domicilio','<td','>'), '</', $nombre['post']);

var_dump($ruc);
var_dump($nombre);
var_dump($direccion);



