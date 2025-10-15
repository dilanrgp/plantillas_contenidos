<?php   
if(isset($_GET['version']))
	$version = $_GET['version'];

if(isset($_GET['format']))
	$template = $_GET['format'];
else
	$template="TEMPLATE-1";
if(isset($_GET['config'])){
	$config = $_GET['config'];
}
// Inicializar todos los valores posibles que se pasan como atributos
if(isset($config)){
	$json = file_get_contents($config);
	$json_data = json_decode($json);
	$descripcion = $json_data->desc;
	$subdescripcion = $json_data->subdesc;
	$descripcion_2 = $json_data->desc2;
	$subdescripcion_2 = $json_data->subdesc2;	
	$price = $json_data->price;
	$subprice = $json_data->subprice;
	$claim = $json_data->claim;
	$legal = $json_data->legal;	
	$img = isset($json_data->img) ? $json_data->img : '';
	$priced = isset($json_data->price_D) ? $json_data->price_D : '';
	$priceg = isset($json_data->price_G) ? $json_data->price_G : '';	
} else {
	$descripcion = 'Marca 1';
	$subdescripcion = 'Descripción 1';
	$descripcion_2 = 'Marca 2';
	$subdescripcion_2 = 'Descripción 2';	
	$price = '';
	$subprice = '';
	$claim = '';
	$legal = '';	
	$img = '';
	$priced = '';
	$priceg = '';	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulario de creacion de promocion para BADÍA</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/form.css">
</head>
<body>
<div class="container body" role="main">
<div class="row">
	<form action="preview.php" method="POST" id="TEMPLATE_FORM" enctype="multipart/form-data">
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
							<img src="img/templates/oferta_1.jpg">
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
							<img src="img/templates/oferta_2.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col">
					<label for="TEMPLATE-3" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-3" <?php if ($template == "TEMPLATE-3") echo "checked";?> value="TEMPLATE-3">
						</div>
						<div class="cell">
							<p>Oferta 3</p>
							<img src="img/templates/oferta_3.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col">
					<label for="TEMPLATE-4" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-4" <?php if ($template == "TEMPLATE-4") echo "checked";?> value="TEMPLATE-4">
						</div>
						<div class="cell">
							<p>Mensaje informativo</p>
							<img src="img/templates/mensaje.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col">
					<label for="TEMPLATE-5" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-5" <?php if ($template == "TEMPLATE-5") echo "checked";?> value="TEMPLATE-5">
						</div>
						<div class="cell">
							<p>Precios gasolina</p>
							<img src="img/templates/precios.png">
						</div>
					</label>
				</div>				
			</div>
		</fieldset>
		<fieldset class="col-md-12 form-group" id="CONFIG">
			<h3>Configura tu plantilla</h3>
			<div class="config-container">
				<div class="template-config">
	 				<div class="fields-ofertas">
						<div class="field-price">
							<input type="text" name="SUBPRICE" id="SUBPRICE" value="<?= $subprice ?>" placeholder="Llévate 2 por">
							<input type="text" name="PRICE" id="PRICE" value="<?= $price ?>" placeholder="1,50€">
						</div>
						<div class="info">
							<textarea name="DESCRIPCION" id="DESCRIPCION"><?= $descripcion ?></textarea>
							<textarea name="SUBDESCRIPCION" id="SUBDESCRIPCION"><?= $subdescripcion ?></textarea>
						</div>
						<div class="info info-2" id="INFO_2">
							<textarea name="DESCRIPCION_2" id="DESCRIPCION_2"><?= $descripcion_2 ?></textarea>
							<textarea name="SUBDESCRIPCION_2" id="SUBDESCRIPCION_2"><?= $subdescripcion_2 ?></textarea>
						</div>
						<input type="text" name="LEGAL" id="LEGAL" value="<?= $legal ?>" placeholder="Oferta válida hasta el 31 de mayo de 2030">
					</div>
					<div class="img-preview" style="background: url(<?= $img ?>) no-repeat center center; background-size: contain;"></div>
					<textarea name="CLAIM" id="CLAIM"><?= $claim ?></textarea>
				</div>
			</div>
			
			<div class="config_precios-container">
				<div class="template_precios-config">
					<input type="text" name="PRICE_DIESEL" id="PRICE_DIESEL" value="<?= $priced ?>" class="price" placeholder="1,999">
					<input type="text" name="PRICE_GASOLINA" id="PRICE_GASOLINA" value="<?= $priceg ?>" class="price" placeholder="1,999">
				</div>
			</div>	
			
			
			<div class="extra-fields">
				<div class="fields-img">
					<h5>Imagen</h5>
					<input type="file" name="IMG" id="IMG">
					<input type="hidden" name="imagenamostrar" id="imagenamostrar" value="<?= $img ?>">					
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
	<script src="js/form.js?time=<?= time() ?>"></script>
</body>
</html>