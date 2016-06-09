<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ruc</title>
</head>
<body>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

	<img src="" alt="" id="imgsunat">
	<form action="procesaruc.php" method="post" >
		<input type="hidden" id="cookie" name="cookie"><br>
		<input type="text" name="codigo" placeholder="codigo"><br>
		<input type="text" name="ruc" value="10443262399" placeholder="ruc"><br>
		<input type="submit" value="go">
		
	</form>

	<script>
		$(function(){
			$.post('cookiesdeotraweb.php',function(cookie){
				$('#cookie').val(cookie);
				$('#imgsunat').attr('src','./imgsunat.jpg?'+Math.random());
			})
		})
	</script>
</body>
</html>