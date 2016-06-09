<?php
include "RucSunat.php";
include "TesseractOCR.php";

//$sdf=exec('echo EXEC');
//var_dump($sdf);
//if($sdf == 'EXEC'){
//    echo 'exec works';
//}
//exit();
//$cmd='tesseract D:\www\devmap\helpers\lab\sunat\fupload\sunath.jpg D:\www\devmap\helpers\lab\sunat\fupload\a  -l spa> 2>&1';
//
//
//$cmd= "whoami";
//echo exec($cmd,$build);
//var_dump($build);
//exit();


//D:\tesseract
//echo shell_exec('whoami');exit();
//$tempDir = sys_get_temp_dir();
$ruta=sys_get_temp_dir();
//if(!is_dir($ruta)){
//	if(!mkdir($ruta, 0777, true)){
//		 die('Fallo al crear las carpetas...');
//	}
//}

//echo shell_exec('whoami');
//


//exec("whoami > /dev/null 2>&1", $output);
//
//var_dump($output);
//
//exit();

//tesseract "D:\www\devmap\helpers\lab\sunat/sunath.jpg" "D:\www\devmap\helpers\lab\sunat\7841"  -l spa > /dev/null 2>&1

$imgfile=$ruta.DIRECTORY_SEPARATOR.'sunat.jpg';

$sunat = new RucSunat($imgfile);
$rucrs =(isset($_POST['rucrs']))? $_POST['rucrs']:'10443262399';
if(isset($_POST['ruc'])) {
	$ruc    =(isset($_POST['ruc']))? $_POST['ruc']:'';
	$codigo =(isset($_POST['codigo']))? $_POST['codigo']:'';
	$cookie =(isset($_POST['cookie']))? $_POST['cookie']:'';
	$resultado  = $sunat->processRuc($ruc,$codigo,$cookie);
	//var_dump($resultado);
}
if(isset($_POST['rs'])) {
	$rs        =(isset($_POST['rs']))? $_POST['rs']:'';
	$codigo    =(isset($_POST['codigo']))? $_POST['codigo']:'';
	$cookie    =(isset($_POST['cookie']))? $_POST['cookie']:'';
	$listaRucs = $sunat->listaRs($rs,$codigo,$cookie);
}else{
	$cookieImg = $sunat->getCookieImg();

	$tesseract = new TesseractOCR($imgfile);
	$tesseract->setTempDir($ruta);
	$tesseract->setLanguage("spa");
	$imghackeado=$tesseract->recognize();
	var_dump($imghackeado);

}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>sunat</title>

    <!-- Bootstrap -->
    	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<div class="container">
	<?php
	if(isset($cookieImg)) {
		?>
		<div>
		  	<!-- Nav tabs -->
		  	<ul class="nav nav-tabs" role="tablist">
		  	  	<li role="presentation" class="active"><a href="#tabruc" aria-controls="tabruc" role="tab" data-toggle="tab">Ruc</a></li>
		  	  	<li role="presentation"><a href="#tabrs" aria-controls="tabrs" role="tab" data-toggle="tab">Razón social</a></li>
		  	</ul>
		  	<!-- Tab panes -->
		  	<div class="tab-content">
		  	  	<div role="tabpanel" class="tab-pane active" id="tabruc">
		  	  		<div class="text-center" >
						
					</div>
		  	  		<form action="" method="post" >
						<input type="hidden" name="cookie" value="<?php echo $cookieImg['cookie']?>">
						<div class="form-group">
  						  	<label for="txtruc1">Nº Ruc</label>
  						  	<input type="text" class="form-control" name="ruc"  value="<?php echo $rucrs?>" id="txtruc1" placeholder="Nº Ruc">
  						</div>
  						<div class="form-group">
  						  	<div class="input-group">
							  	<div class="input-group-btn"><img src="<?php echo $cookieImg['img']?>" alt="" class="to_ocr"></div>
							  	<input type="text" class="form-control" name="codigo" placeholder="Código">
							  	<span class="input-group-btn" style="vertical-align: top;">
        							<button class="btn btn-default" type="submit">Go</button>
      							</span>
							</div>
  						</div>
					</form>
		  	  	</div>
		  	  	<div role="tabpanel" class="tab-pane" id="tabrs">
		  	  		
		  	  		<form action="" method="post" >
						<input type="hidden" name="cookie" value="<?php echo $cookieImg['cookie']?>">
  						<div class="form-group">
  						  	<label for="txtrs2">Razón social</label>
  						  	<input type="text" class="form-control" name="rs" id="txtrs2" placeholder="Razón social">
  						</div>
  						<div class="form-group">
  						  	<div class="input-group">
							  	<div class="input-group-btn"><img src="<?php echo $cookieImg['img']?>" alt="" class="to_ocr"></div>
							  	<input type="text" class="form-control" name="codigo" placeholder="Código">
							  	<span class="input-group-btn" style="vertical-align: top;">
        							<button class="btn btn-default" type="submit">Go</button>
      							</span>
							</div>
  						</div>
						
					</form>
		  	  	</div>
		  	</div>
		</div>
		<?php
	}
	?>

	<?php
	if(isset($resultado)){
		if($resultado['est']) {
			?>
			<table class="table">
				<tr>
					<th>Ruc</th>
					<td><?php echo $resultado['data']['ruc']?></td>
				</tr>
				<tr>
					<th>Razón Social</th>
					<td><?php echo $resultado['data']['rs']?></td>
				</tr>
				<tr>
					<th>Dirección</th>
					<td><?php echo $resultado['data']['dir']?></td>
				</tr>
			</table>
			<?php
		}else{
			?>
			<div class="alert alert-danger" role="alert"><?php echo $resultado['msg']?></div>
			<?php
		}
	}
	?>

	<?php
	if(isset($listaRucs)){
		?>
		<div>
			<table class="table">
			<?php
			foreach ($listaRucs as $row) {
				?>
				<tr>
					<td>
					<form action="" method="post">
						<input type="hidden" name="rucrs" value="<?php echo $row['ruc']?>">
						<input type="submit" value="<?php echo $row['ruc']?>">
					</form>
					</td>
					<td><?php echo $row['rs']?></td>
					<td><?php echo $row['ubi']?></td>
					<td><?php echo $row['est']?></td>
				</tr>
				<?php
			}
			?>
			</table>
		</div>	
		<?php
	}
	?>



	

	</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    	<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>