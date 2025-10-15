<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulario de creacion de promocion para cofares</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="fonts/font-awesome.min.css">
	<link rel="stylesheet" href="form.css">
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
							<img src="templates/templates/producto_S.jpg">
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
							<img src="templates/templates/producto_L.jpg">
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
							<img src="templates/templates/evento.jpg">
						</div>
					</label>
				</div>
			</div>
		</fieldset>


		<fieldset class="col-md-12 form-group" id="CONFIG">
			<h3>Configura tu plantilla</h3>

			<div class="config-container">
				<div class="template-config">
					<div class="border"></div>
	 				<div class="fields-ofertas">
	 					<div class="info">
							<textarea name="TITLE" id="TITLE" placeholder="Nombre del producto o evento"></textarea>

							<textarea name="CONTENT" id="CONTENT" placeholder="Descripción del producto/evento"></textarea>
						</div>

						<div class="field-price">
							<p><input type="text" name="PRICE" id="PRICE" placeholder="24,95€"></p>
						</div>

						<div class="field-claim">
							<p><input type="text" name="CLAIM" id="CLAIM" placeholder="Fecha de vigencia"></p>
						</div>

						<div class="img-preview"></div>
					</div>

					<div class="RRSS">
						<ul>
							<li><i class="fa fa-facebook"></i></li>
							<li><i class="fa fa-twitter"></i></li>
							<li><i class="fa fa-instagram"></i></li>
							<li><i class="fa fa-youtube"></i></li>
							<li><i class="fa fa-linkedin"></i></li>
							<li><i class="fa fa-pinterest-p"></i></li>
						</ul>
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

			<div class="form-group text-center"><input type="submit" name="SUBMIT" id="SUBMIT" value="Previsualizar" class="btn btn-success">
			 <input type="button" class="btn btn-success" name="volver" value="Volver" onclick="window.close();	window.history.back();">
		   </div>
		

		</fieldset>
	</form>
</div>
</div>

	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="script.js"></script>


</body>
</html>