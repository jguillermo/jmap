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
	
	<?php

	for ($i=1; $i <=18 ; $i++) { 
		?> <img class="imagenocr" src="./img/<?php echo $i?>.jpg" id="imgocr<?php echo $i?>" alt=""> <?php
	}
	?>
	
	<br><br><br>

	<?php

	for ($i=100; $i <=106 ; $i++) { 
		?> <img class="imagenocr" src="./img/<?php echo $i?>.jpg" id="imgocr<?php echo $i?>" alt=""> <?php
	}
	?>

	<div class="container">
		<div class="form-group">
  		  	<div class="input-group">
			  	
			  	<input type="text" class="form-control txtcodigo" name="codigo" placeholder="Código">
			  	
			</div>
  		</div>
	</div>

	<canvas id="canvas"></canvas>

	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<script src="http://tenso.rs/tesseract.js"></script>
	<script>
	$(document).ready(function(){
		$('.imagenocr').on('click',function(){
			limpiaimagen($(this).attr('id'));
		});
	});
			function limpiaimagen(idimg){

				var img = document.getElementById(idimg);
				var canvas = document.getElementById("canvas");//document.createElement('canvas');
				canvas.width  = img.naturalWidth;
				canvas.height = img.naturalHeight;
				var contexto = canvas.getContext("2d");	
				contexto.drawImage(img,0,0);
				var imageData = contexto.getImageData(0,0,100,50);
				var data = imageData.data;
				for (var i=0; i<data.length; i+=4){
					//if (data[i]<122){data[i]=0}else{data[i]=255;}
					//if (data[i+1]<122){data[i+1]=0}else{data[i+1]=255;}
					//if (data[i+2]<122){data[i+2]=0}else{data[i+2]=255;}

					//if(data[i+2]<240 ){
					//	data[i] = 255;
					//	data[i+1] = 255;
					//	data[i+2] = 255;
					//}
					
					console.log(data[i]+' '+data[i+1]+' '+data[i+2]);
					
					if(data[i] > 220 && data[i+1] > 220 && data[i+2] > 220 ){
						data[i] = 255;
						data[i+1] = 255;
						data[i+2] = 255;
					}else{
						data[i] = data[i] - 150;
						data[i+1] = data[i+1] - 150;
						data[i+2] = data[i+2] - 150;
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
					console.log(d);
					console.log(d.text); 

					$('.txtcodigo').val($.trim(d.text));
				} );
			}
		</script>

  </body>
</html>