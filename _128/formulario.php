<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>EXOIL - Formulario de creación de contenidos</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
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
							<input type="radio" name="TEMPLATE" id="TEMPLATE-1" value="TEMPLATE-1">
						</div>
						<div class="cell">
							<p>Oferta 1</p>
							<img src="img/templates/template_1.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col">
					<label for="TEMPLATE-2" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-2" value="TEMPLATE-2">
						</div>
						<div class="cell">
							<p>Oferta 2</p>
							<img src="img/templates/template_2.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col">
					<label for="TEMPLATE-3" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-3" value="TEMPLATE-3">
						</div>
						<div class="cell">
							<p>Oferta 3</p>
							<img src="img/templates/template_3.jpg">
						</div>
					</label>
				</div>
			</div>
		</fieldset>


		<fieldset class="col-md-12 form-group" id="CONFIG">
			<h3>Configura tu plantilla</h3>

			<div class="config-info">
				<p><u>Formatear el precio:</u> Poner <big><strong>**</strong></big> delante y detrás del texto a reducir. <span class="small"><em>(El símbolo del euro se reduce automáticamente.)</em></span></p>
				<blockquote><em>Ej.:</em> 2**x**3€ &rArr; <big>2</big><small>x</small><big>3</big><small>€</small></blockquote>
			</div>

			<div class="config-container">
				<div class="template-config">
	 				<div class="fields-ofertas">
	 					<div class="title">
							<input type="text" name="PRETITLE" id="PRETITLE" placeholder="¡Horchata o granizado!">
							<input type="text" name="TITLE" id="TITLE" placeholder="Oferta">
						</div>

						<div class="info">
							<textarea name="DESCRIPCION" id="DESCRIPCION" placeholder="ANTICONGELANTE / LIMPIAPARABRISAS"></textarea>
							<textarea name="SUBDESCRIPCION" id="SUBDESCRIPCION" placeholder="AMBIENTADORES DE TODOS LOS AROMAS"></textarea>
						</div>

						<div class="field-price">
							<input type="text" name="PRICE" id="PRICE" placeholder="1,50€">
							<input type="text" name="SUBPRICE" id="SUBPRICE" placeholder="3,38€/Ud">
						</div>
					</div>

					<div class="details">
						<textarea name="DETAILS" id="DETAILS" placeholder="Pack Ahorro"></textarea>
					</div>

					<div class="img-preview"></div>
				</div>

			</div>
			<div class="extra-fields">
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
	<script src="js/form.js?v=04"></script>


</body>
</html>