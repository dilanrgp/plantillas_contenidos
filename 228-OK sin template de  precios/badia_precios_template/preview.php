<?php

	$data = [
		'price_D'		=> $_POST["PRICE_DIESEL"],
		'price_G'		=> $_POST["PRICE_GASOLINA"],
	];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Plantillas precio BADÍA</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

	<link rel="stylesheet" href="css/preview.css">
</head>

<body class="<?php echo $bg_clases; ?>">
	<div id="TEMPLATE_CONTENT">
		<div class="contenedor">
			<p class="price" id="PRICE_DIESEL"><?php echo $data['price_D']; ?></p>
			<p class="price" id="PRICE_GASOLINA"><?php echo $data['price_G']; ?></p>
		</div>
	</div>

	<div class="wrapper" id="BUTTONS">
		<div class="btns">
			<input type="button" class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();">
			<input type="button" class="btn btn-primary" name="volver" value="Volver" onclick="window.close();">
		</div>
	</div>
</body>

</html>
























