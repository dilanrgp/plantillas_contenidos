<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulario de creacion de promocion para costa andarax</title>

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

	<link rel="stylesheet" href="css/form.css">
</head>
<?php   
error_reporting(E_ALL);
include("../accesomysql.php");
////////// JCAM

// Conexión a la B.D.
//include("../accesomysql.php");
$idcustomer = 136;  // costa andarax
$directoriocliente = $directoriobase."/".$idcustomer."/";
$template="TEMPLATE-1";
$idcontent   = 	0;
$idcampaign   = 0;

// Inicializar todos los valores posibles que se pasan como atributos
$title = "";		
$img= "";
$content= "";
$price= "";
$claim="";
$facebook="";
$twitter="";
$pinterest="";
$youtube="";
$linkedin="";


?>


<body>

<div class="container body" role="main">
<div class="row">
	<form action="preview.php" method="POST" id="TEMPLATE_FORM" enctype="multipart/form-data">
		<input type="hidden" name="idcontent" id="idcontent" value="">
		<input type="hidden" name="imagenamostrar" id="imagenamostrar" value="">	
		<input type="hidden" name="idcampaign" id="idcampaign" value="">				
		<input type="hidden" name="idcustomer" id="idcustomer" value="<?php echo $idcustomer?>">

		<fieldset class="col-md-12 form-group" id="TEMPLATE">
			<h3>Elije tu diseño</h3>
			<div class="row align-items-center">
				<div class="form-check col col-md-4">
					<label for="TEMPLATE-1" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-1" <?php if ($template == "TEMPLATE-1") echo "checked";?> value="TEMPLATE-1">
						</div>
						<div class="cell">
							<p>Oferta con producto pequeño</p>
							<img src="img/templates/producto_S.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-md-4">
					<label for="TEMPLATE-2" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-2" <?php if ($template == "TEMPLATE-2") echo "checked";?> value="TEMPLATE-2">
						</div>
						<div class="cell">
							<p>Oferta con producto grande 1</p>
							<img src="img/templates/producto_L_1.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-md-4">
					<label for="TEMPLATE-3" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-3" <?php if ($template == "TEMPLATE-3") echo "checked";?> value="TEMPLATE-3">
						</div>
						<div class="cell">
							<p>Oferta con producto grande 2</p>
							<img src="img/templates/producto_L_2.jpg">
						</div>
					</label>
				</div>
			</div>
		</fieldset>


		<fieldset class="col-md-12 form-group" id="CONFIG">
			<h3>Configura tu plantilla</h3>
			<p><em>(Los campos con borde blanco así como la imagen son obligatorios)</em></p>

			<div class="config-container">
				<div class="template-config">
	 				<div class="fields-ofertas">
	 					<div class="info">
							<textarea name="TITLE" id="TITLE" placeholder="Nombre del producto"></textarea>

							<textarea name="CONTENT" id="CONTENT" placeholder="Descripción del producto"></textarea>
						</div>

						<div class="field-price">
							<p><input type="text" name="PRICE" id="PRICE" placeholder="9,95€"></p>
						</div>

						<div class="field-claim">
							<p><input type="text" name="CLAIM" id="CLAIM" placeholder="Fecha de vigencia"></p>
						</div>

						<div class="img-preview"></div>
					</div>

					<!-- <div class="bg-image"></div> -->
				</div>

				<div class="field-img">
					<h5>Imagen</h5>
					<input type="file" name="IMG" id="IMG">
				</div>

				<div class="fields-RRSS">
					<h5>¿Tienes redes sociales?</h5>
					<div class="row">
						<div class="col form-check">
							<label class="form-check-label"><input type="checkbox" class="form-check-input" name="FACEBOOK" id="FACEBOOK"> Facebook</label></div>

						<div class="col form-check">
							<label class="form-check-label"><input type="checkbox" class="form-check-input" name="TWITTER" id="TWITTER"> Twitter</label></div>

						<div class="col form-check">
							<label class="form-check-label"><input type="checkbox" class="form-check-input" name="INSTAGRAM" id="INSTAGRAM"> Instagram</label></div>

						<div class="col form-check">
							<label class="form-check-label"><input type="checkbox" class="form-check-input" name="YOUTUBE" id="YOUTUBE"> Youtube</label></div>

						<div class="col form-check">
							<label class="form-check-label"><input type="checkbox" class="form-check-input" name="PINTEREST" id="PINTEREST"> Pinterest</label></div>

						<div class="col form-check">
							<label class="form-check-label"><input type="checkbox" class="form-check-input" name="LINKEDIN" id="LINKEDIN"> LinkedIn</label></div>
					</div>
				</div>
			</div>

			<div class="validation"></div>

			<div class="form-group text-center">
				<input type="submit" name="SUBMIT" id="SUBMIT" value="Previsualizar" class="btn btn-success">
				<input type="button" class="btn btn-primary" name="volver" value="Volver" onclick="window.close();	window.history.back();">
			</div>

		</fieldset>
	</form>
</div>
</div>

	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/form.js"></script>


</body>
</html>