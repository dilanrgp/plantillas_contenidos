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
	<form action="preview.php" method="POST" id="TEMPLATE_FORM">

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
							<img src="img/templates/oferta_1.jpg">
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
							<img src="img/templates/oferta_2.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col">
					<label for="TEMPLATE-3" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-3" value="TEMPLATE-3">
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

					<div class="img-preview"></div>
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
	<script src="js/form.js"></script>


</body>
</html>