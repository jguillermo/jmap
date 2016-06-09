<?php
$ruc=(isset($_POST['ruc']))? $_POST['ruc']:'';
$codigo=(isset($_POST['codigo']))? $_POST['codigo']:'';
$cookie=(isset($_POST['cookie']))? $_POST['cookie']:'';


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

$URL_path = "http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";

//$URL_path = "http://192.168.1.128/sunat/informe.php";



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


if($data === false)
{
    echo 'Curl error: ' . curl_error($curl);
}

if (is_resource($curl)) {
	curl_close($curl);
}



echo utf8_encode($data);




//$chhtml = curl_init ($URL_path);
////curl_setopt($chhtml, CURLOPT_HEADER, 1);
////curl_setopt($chhtml, CURLOPT_RETURNTRANSFER, 1);
////curl_setopt($chhtml, CURLOPT_BINARYTRANSFER, 1);
//
//
//curl_setopt($chhtml, CURLOPT_CUSTOMREQUEST, 'POST');
//curl_setopt($chhtml, CURLOPT_POST, true);
//curl_setopt($chhtml, CURLOPT_POSTFIELDS, $elements);
//
//
//curl_setopt($chhtml, CURLOPT_COOKIESESSION, 1);
//
//
//curl_setopt($chhtml, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36" ); 
//
//curl_setopt( $chhtml, CURLOPT_COOKIE, $cookie ); 
//$resulhtml=curl_exec($chhtml);
//
//if($resulhtml === false)
//{
//    echo 'Curl error: ' . curl_error($chhtml);
//}
//else
//{
//    echo 'Operación completada sin errores';
//}
//
//
//
//curl_close ($chhtml);
//
//
//var_dump($resulhtml);
//



