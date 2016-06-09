<?php
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


$txt="  <table>
			<tr>
				<td>
					dato<strong>1</strong>
				</td>
			</tr>
			<tr>
				<td>
					direccion
				</td>
			</tr>
		</table>";


$data1=getsubstringtxt($txt,array('<table','<tr','<td','>'),'<strong');
var_dump($data1);
$data2=getsubstringtxt($txt,array('<tr','<td','>'),'</td',$data1['post']);
var_dump($data2);