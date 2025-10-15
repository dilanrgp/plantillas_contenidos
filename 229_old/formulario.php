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
	$orientation = $json_data->orientation;
	$description = $json_data->description;
	$subdescription = $json_data->subdescription;
	$description2 = $json_data->description2;
	$subdescription2 = $json_data->subdescription2;
	$price = $json_data->price;
	$legal = $json_data->legal;
	$multiproduct = $json_data->multiproduct;
	$img = isset($json_data->img) ? $json_data->img : '';
} else {
	$orientation = false;
	$description = '';
	$subdescription = '';
	$description2 = '';
	$subdescription2 = '';
	$price = '';
	$legal = '';
	$multiproduct = false;
	$img = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulario de creacion de promocion para GLEM</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
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
								<p>Mensaje informativo</p>
								<img src="img/templates/mensaje.jpg">
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
							<input type="checkbox" id="ORIENTATION" name="ORIENTATION" <?php if ($orientation == true) echo "checked";?>>
							<span class="slider"></span>
						</label>
					</div>
					<span class="cell">Vertical</span>
				</div>
				<div class="config-container">
					<div class="template-config">
	 					<div class="fields-ofertas">
	 						<div class="info">
								<textarea name="DESCRIPCION" id="DESCRIPCION" class="description"><?= $description ?></textarea>
								<textarea name="SUBDESCRIPCION" id="SUBDESCRIPCION" class="subdescription"><?= $subdescription ?></textarea>
							</div>
	 						<div class="info" id="PRODUCTO_2">
								<textarea name="DESCRIPCION_2" id="DESCRIPCION_2" class="description"><?= $description2 ?></textarea>
								<textarea name="SUBDESCRIPCION_2" id="SUBDESCRIPCION_2" class="subdescription"><?= $subdescription2 ?></textarea>
							</div>
							<div class="field-price">
								<input type="text" name="PRICE" id="PRICE" placeholder="1,50€" value="<?= $price ?>">
							</div>
							<textarea name="LEGAL" id="LEGAL" placeholder="Promoción válida hasta el 31 de mayo de 2021"><?= $legal ?></textarea>
						</div>
						<div class="img-preview" <?php if ($img != '') echo 'style="background: url(' . $img . ') no-repeat center center; background-size: contain;"' ?>></div>
					</div>
				</div>
				<div class="extra-fields">
					<div class="multiproduct">
						<h5>Cantidad productos</h5>
						<div class="template-orientation table">
							<span class="cell">1</span>
							<div class="cell switch-container">
								<label class="switch">
									<input type="checkbox" id="MULTIPRODUCT" name="MULTIPRODUCT" <?php if ($multiproduct == true) echo "checked";?>>
									<span class="slider"></span>
								</label>
							</div>
							<span class="cell">2</span>
						</div>
					</div>
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
<script src="js/form.js"></script>
</body>
</html>