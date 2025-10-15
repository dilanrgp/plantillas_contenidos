<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulario de creacion de promocion para cofares</title>

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
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
				<div class="form-check col col-md-3">
					<label for="TEMPLATE-1" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-1" value="TEMPLATE-1">
						</div>
						<div class="cell">
							<p>Oferta con producto pequeño</p>
							<img src="img/templates/producto_S.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-md-3">
					<label for="TEMPLATE-2" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-2" value="TEMPLATE-2">
						</div>
						<div class="cell">
							<p>Oferta con producto grande</p>
							<img src="img/templates/producto_L.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-md-3">
					<label for="TEMPLATE-3" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-3" value="TEMPLATE-3">
						</div>
						<div class="cell">
							<p>Evento</p>
							<img src="img/templates/evento.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-md-3">
					<label for="TEMPLATE-4" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-4" value="TEMPLATE-4">
						</div>
						<div class="cell">
							<p>Horarios</p>
							<img src="img/templates/horarios.jpg">
						</div>
					</label>
				</div>
			</div>
		</fieldset>


		<fieldset class="col-md-12 form-group" id="CONFIG">
			<h3>Configura tu plantilla</h3>
			<p><em>(Los campos con borde rojo así como la imagen son obligatorios)</em></p>
			
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
							<textarea name="TITLE" id="TITLE" placeholder="Producto o evento"></textarea>

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

					<div class="fields-horarios">
						<input type="text" name="HORARIO_1" id="HORARIO_1" placeholder="Horario 1">
						<input type="text" name="HORARIO_2" id="HORARIO_2" placeholder="Horario 2">
						<input type="text" name="HORARIO_3" id="HORARIO_3" placeholder="Horario 3">
						<p class="tel">tel. <input type="text" name="TEL" id="TEL" placeholder="123 456 789"></p>
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

			<div class="form-group text-center"><input type="submit" name="SUBMIT" id="SUBMIT" value="Previsualizar" class="btn btn-success"></div>

		</fieldset>
	</form>
</div>
</div>

	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/form.js"></script>


</body>
</html>