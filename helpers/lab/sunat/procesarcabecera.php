<?php

$URL_path='http://www.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=image';


//$URL_path='http://192.168.1.128/devmap/helpers/lab/sunat/imgprueba.jpg';
$ch = curl_init($URL_path);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER,0);
curl_setopt($ch, CURLOPT_HEADER, 1);
$result = curl_exec($ch);
curl_close ($ch);


$headimg=explode("Transfer-Encoding: chunked",$result);

$img_curl=trim($headimg[1]);

$img = imagecreatefromstring($img_curl);

$img_base= base64_encode($img_curl);


var_dump(trim($headimg[1]));
var_dump($img);
var_dump($img_base);

print($img_base);
echo "<br>";

$imgruta= 'data:image/jpeg;base64,' . base64_encode($img_curl);

?>

<img src="<?php echo $imgruta?>" alt="">