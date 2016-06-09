<?php

$URL_path='http://www.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=image';
$ch = curl_init ($URL_path);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
$result=curl_exec($ch);
curl_close ($ch);

var_dump($result);
echo $result;
exit();


$fp = fopen('./imgsunat.jpg','wb');
fwrite($fp, $result);
fclose($fp);

