<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulario de creacion de promocion para GLEM</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

	<link rel="stylesheet" href="css/glem-template.css">
</head>
<?php   
error_reporting(E_ALL);

// Conexión a la B.D.
include("../accesomysql.php");
$idcustomer = 96;  
$directoriocliente = $directoriobase."/".$idcustomer."/";
$template="TEMPLATE-1";
$idcontent   = 	0;
$idcampaign   = 0;

?>

<body>

<div class="container body" role="main">
<div class="row">
	<form action="preview.php" method="POST" id="TEMPLATE_FORM" enctype="multipart/form-data">
		<input type="hidden" name="idcustomer" id="idcustomer" value="<?php echo $idcustomer?>">
		<input type="hidden" name="imagenamostrar" id="imagenamostrar" value="">	
		
		<fieldset class="col-md-12 form-group" id="TEMPLATE">
			<h3>Elije tu diseño</h3>
			<div class="row align-items-center">
				<div class="form-check col">
					<label for="TEMPLATE-1" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-1" <?php if ($template == "TEMPLATE-1") echo "checked";?> value="TEMPLATE-1">
						</div>
						<div class="cell">
							<p>Oferta 1</p>
							<img src="glem/templates/oferta_1.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col">
					<label for="TEMPLATE-2" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-2" <?php if ($template == "TEMPLATE-2") echo "checked";?> value="TEMPLATE-2">
						</div>
						<div class="cell">
							<p>Oferta 2</p>
							<img src="glem/templates/oferta_2.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col">
					<label for="TEMPLATE-3" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-3" <?php if ($template == "TEMPLATE-3") echo "checked";?> value="TEMPLATE-3">
						</div>
						<div class="cell">
							<p>Mensaje informativo</p>
							<img src="glem/templates/mensaje.jpg">
						</div>
					</label>
				</div>
			</div>
		</fieldset>


		<fieldset class="col-md-12 form-group" id="CONFIG">
			<h3>Configura tu plantilla</h3>

			<h4>Formato de pantalla</h4>
				<div class="template-orientation table">
					<span class="cell">Horizontal</span>
					<div class="cell switch-container">
						<label class="switch">
							<input type="checkbox" id="ORIENTATION" name="ORIENTATION">
							<span class="slider"></span>
						</label>
					</div>
					<span class="cell">Vertical</span>
				</div>

			<div class="config-container">
				<div class="template-config">
	 				<div class="fields-ofertas">
	 					<div class="info">
							 <p class="oferta">Oferta</p>
							<textarea name="DESCRIPCION" id="DESCRIPCION"></textarea>
							<textarea name="SUBDESCRIPCION" id="SUBDESCRIPCION"></textarea>
						</div>

						<div class="field-price">
							<input type="text" name="PRICE" id="PRICE" placeholder="1,50">
							<span class="euro">€</span><span class="ud">/ud.</span>
							<input type="text" name="SUBPRICE" id="SUBPRICE" placeholder="Por la compra de 2 unidades">
						</div>
					</div>

					<div class="claim">
						<textarea name="CLAIM" id="CLAIM"></textarea>
					</div>
					
					<input type="text" name="LEGAL" id="LEGAL" placeholder="Promoción válida hasta el 31 de mayo de 2021">

					<div class="img-preview"><img src="<?php //echo $img?>"></div>
				</div>

			</div>
			<div class="extra-fields">
				<div class="fields-desc_config">
					<h5>Opciones</h5>
					<div class="field_changer">
						<input type="checkbox" name="CON_UD" id="CON_UD" checked>
						<label for="CON_UD">Precio /ud. ?</label>
					</div>
					<div class="field_changer">
						<input type="checkbox" name="CON_CLAIM" id="CON_CLAIM" checked>
						<label for="CON_CLAIM">Con claim ?</label>
					</div>
				</div>
				<div class="fields-img">
					<h5>Imagen</h5>
					<input type="file" name="IMG" id="IMG">
				</div>
			</div>

			<div class="validation"></div>

			<div class="form-group text-center">
				<input type="submit" name="SUBMIT" id="SUBMIT" value="Previsualizar" class="btn btn-success">
			</div>
		</fieldset>
	</form>
</div>
</div>

	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/glem.js?tmp=<?=time()?>"></script>
	<script language="JavaScript">
		function cerrar(){
			parent.postMessage({message: "close"}, "*");
		}
	<script>


</body>
</html>