<?php
include "Reniec.php";

$reniec = new Reniec();
if(isset($_POST['dni'])) {
	$dni    =(isset($_POST['dni']))? $_POST['dni']:'';
	$codigo =(isset($_POST['codigo']))? $_POST['codigo']:'';
	$cookie =(isset($_POST['cookie']))? $_POST['cookie']:'';
	$resultado  = $reniec->processDni($dni,$codigo,$cookie);
	//var_dump($resultado);
	//var_dump($cookieImg);
}else{
	$dni='44326239';
}
$cookieImg = $reniec->getCookieImg();


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
  <body onload="limpiaimagen()">
	

	<div class="container">
	<?php
	if(isset($cookieImg)) {
		?>
		<div>


		<form action="" method="post" >
			<input type="hidden" name="cookie" value="<?php echo $cookieImg['cookie']?>">
			<div class="form-group">
  			  	<label for="txtruc1">Nº DNI</label>
  			  	<input type="text" class="form-control" name="dni"  value="<?php echo $dni;?>" id="txtruc1" placeholder="Nº DNI">
  			</div>
  			<div class="form-group">
  			  	<div class="input-group">
				  	<div class="input-group-btn"><img src="<?php echo $cookieImg['img']?>" id="pic"  alt=""></div>
				  	<input type="text" class="form-control txtcodigo" name="codigo" placeholder="Código">
				  	<span class="input-group-btn" style="vertical-align: top;">
        				<button class="btn btn-default" type="submit">Go</button>
      				</span>
				</div>
  			</div>
		</form>
		</div>
		<div class="progress" >
			<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
				<span class="sr-only"></span>
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
					<th>Dni</th>
					<td><?php echo $resultado['data']['dni']?></td>
				</tr>
				<tr>
					<th>Nombre(s)</th>
					<td><?php echo $resultado['data']['nom']?></td>
				</tr>
				<tr>
					<th>Ap. Paterno</th>
					<td><?php echo $resultado['data']['app']?></td>
				</tr>
				<tr>
					<th>Ap. Materno</th>
					<td><?php echo $resultado['data']['apm']?></td>
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

	</div>

	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<script src="http://tenso.rs/tesseract.js"></script>
	<script>

			function limpiaimagen(){

				var img = document.getElementById("pic");
				var canvas = document.createElement('canvas');
				canvas.width  = img.naturalWidth;
				canvas.height = img.naturalHeight;
				var contexto = canvas.getContext("2d");	
				contexto.drawImage(img,0,0);
				var imageData = contexto.getImageData(0,0,148,47);
				var data = imageData.data;
				for (var i=0; i<data.length; i+=4){
					if (data[i]<122){data[i]=0}else{data[i]=255;}
					if (data[i+1]<122){data[i+1]=0}else{data[i+1]=255;}
					if (data[i+2]<122){data[i+2]=0}else{data[i+2]=255;}

					if(data[i+2]<240 ){
						data[i] = 255;
						data[i+1] = 255;
						data[i+2] = 255;
					}
				}
				contexto.putImageData(imageData,0,0);
				recognize_image(contexto);
			}
			function recognize_image(contexto){
				Tesseract.recognize(contexto,{
					tessedit_char_blacklist:'e',
					progress: function(e){
						console.log('progress');
						//$('.progress .progress-bar').css('width',);
						
						$('.progress').show();
						if(e.recognized) {
							$('.progress .progress-bar').css('width',(e.recognized*100)+'%');
							if(e.recognized=='1') {
								$('.progress').hide('1000');
							}
						}else{
							$('.progress .progress-bar').css('width','10%');
						}
						
					}
				}).then( function(d){ 
					$('.progress').hide('1000');
					console.log(d);
					console.log('texto extraido');
					console.log(d.text); 
					console.log('texto extraido');

					$('.txtcodigo').val($.trim(d.text));
				} );
			}
		</script>

  </body>
</html>