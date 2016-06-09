<?php

$URL_path='http://www.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=image';
$ch = curl_init($URL_path);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// get headers too with this line
curl_setopt($ch, CURLOPT_HEADER, 1);
$result = curl_exec($ch);
curl_close ($ch);
preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
//$cookies = array();
//foreach($matches[1] as $item) {
//    parse_str($item, $cookie);
//    $cookies = array_merge($cookies, $cookie);
//}
$cookies = '';
foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    //$cookies = array_merge($cookies, $cookie);
    $cookies.=$item.'; '; 
}

$cookies=trim(trim($cookies),';');


$chimg = curl_init ($URL_path);
curl_setopt($chimg, CURLOPT_HEADER, 0);
curl_setopt($chimg, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($chimg, CURLOPT_BINARYTRANSFER,1);
curl_setopt( $chimg, CURLOPT_COOKIE, $cookies ); 
$resultimg=curl_exec($chimg);
curl_close ($chimg);




$fp = fopen('./imgsunat.jpg','wb');
fwrite($fp, $resultimg);
fclose($fp);



echo trim(trim($cookies),';');