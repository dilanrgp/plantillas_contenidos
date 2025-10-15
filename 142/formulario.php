<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulario de creacion de promocion para ORTOKA</title>

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
						<div class="form-check col col-md-2">
							<label for="TEMPLATE-1" class="template-selection">
								<div class="cell">
									<input type="radio" name="TEMPLATE" id="TEMPLATE-1" value="TEMPLATE-1">
								</div>
								<div class="cell">
									<p>Oferta 1</p>
									<img src="img/templates/producto_SQ.jpg">
								</div>
							</label>
						</div>
						<div class="form-check col col-md-2">
							<label for="TEMPLATE-2" class="template-selection">
								<div class="cell">
									<input type="radio" name="TEMPLATE" id="TEMPLATE-2" value="TEMPLATE-2">
								</div>
								<div class="cell">
									<p>Oferta 2</p>
									<img src="img/templates/producto_H.jpg">
								</div>
							</label>
						</div>
						<div class="form-check col col-md-2">
							<label for="TEMPLATE-3" class="template-selection">
								<div class="cell">
									<input type="radio" name="TEMPLATE" id="TEMPLATE-3" value="TEMPLATE-3">
								</div>
								<div class="cell">
									<p>Oferta 3</p>
									<img src="img/templates/producto_V.jpg">
								</div>
							</label>
						</div>
						<div class="form-check col col-md-2">
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
						<div class="form-check col col-md-2">
							<label for="TEMPLATE-5" class="template-selection">
								<div class="cell">
									<input type="radio" name="TEMPLATE" id="TEMPLATE-5" value="TEMPLATE-5">
								</div>
								<div class="cell">
									<p>Mensaje</p>
									<img src="img/templates/mensaje.jpg">
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

									<textarea name="CONTENT" id="CONTENT" placeholder="Descripción del producto / Mensaje"></textarea>
								</div>

								<div class="field-price">
									<p><input type="text" name="PRICE" id="PRICE" placeholder="125€"></p>
									<input type="text" name="SUBPRICE" id="SUBPRICE" placeholder="Financiación en 12 meses">
									<input type="text" name="LEGAL" id="LEGAL" placeholder="Promoción válida hasta el 31 de mayo de 2021">
								</div>

								<div class="field-claim">
									<p><input type="text" name="CLAIM" id="CLAIM" placeholder="Vigencia"></p>
								</div>

								<div class="img-preview"></div>
								<div class="img-border"></div>
							</div>

							<div class="fields-horarios">
								<input type="text" name="HORARIO_1" id="HORARIO_1" placeholder="Horario 1">
								<input type="text" name="HORARIO_2" id="HORARIO_2" placeholder="Horario 2">
								<input type="text" name="HORARIO_3" id="HORARIO_3" placeholder="Horario 3">
								<p class="tel">tel. <input type="text" name="TEL" id="TEL" placeholder="123 456 789"></p>
							</div>

							<!-- <div class="bg-image"></div> -->
						</div>

						<div class="extra-fields">
							<div class="fields-img">
								<h5>Imagen</h5>
								<div class="img_changer" id="IMG_CHANGER">
									<label for="CAMBIO_IMG">con imagen?</label>
									<input type="checkbox" name="CAMBIO_IMG" id="CAMBIO_IMG">
								</div>
								<input type="file" name="IMG" id="IMG">
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