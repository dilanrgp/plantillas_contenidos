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
	<form action="preview.php" method="POST" id="TEMPLATE_FORM" class="col">


		<fieldset class="form-group col" id="CONFIG">
			<h3>Define los precios</h3>

			<div class="config-container">
				<div class="template-config">
					<input type="text" name="PRICE_DIESEL" id="PRICE_DIESEL" class="price" placeholder="1,999" required>
					<input type="text" name="PRICE_GASOLINA" id="PRICE_GASOLINA" class="price" placeholder="1,999" required>
				</div>
			</div>

			<div class="form-group text-center">
				<input type="submit" name="SUBMIT" id="SUBMIT" value="Previsualizar" class="btn btn-success">
			</div>
		</fieldset>
	</form>
</div>
</div>

</body>
</html>