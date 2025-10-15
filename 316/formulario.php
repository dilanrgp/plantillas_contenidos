<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulario de creacion de promocion para cofares</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

	<link rel="stylesheet" href="css/TR-msg-template.css">
</head>


<?php   

////////// JCAM

// Conexión a la B.D.
include("../accesomysql.php");
$idcustomer   = 	316;
$directoriocliente = $directoriobase."/".$idcustomer."/";
$template="TEMPLATE-1";

$idcontent   = 	0;
$idcampaign   = 0;


$txtmsg = "";
$txtmsg = strip_tags($txtmsg);
//rint_r( );

?>



<body>

<div class="container body" role="main">
	<div class="row">
		<form action="TR-msg-preview.php" method="POST" id="TEMPLATE_FORM">

		<input type="hidden" name="idcontent" id="idcontent" value="<?php echo $idcontent?>">
		<input type="hidden" name="idcampaign" id="idcampaign" value="<?=$idcampaign?>">
		<input type="hidden" name="idcustomer" id="idcustomer" value="<?php echo $idcustomer?>">				


			<fieldset class="col-md-12 form-group" id="TEMPLATE">
				<h3>Formato de pantalla</h3>
				<div class="row align-items-center">
					<div class="form-check col col-md-3 col-sm-6">
						<label for="TEMPLATE-1" class="template-selection">
							<div class="cell">
								<input type="radio" name="TEMPLATE" id="TEMPLATE-1" <?php if ($template == "TEMPLATE-1") echo "checked";?>  value="TEMPLATE-1" required>
							</div>
							<div class="cell">
								<span>Pantalla vertical</span>
							</div>
						</label>
					</div>
					<div class="form-check col col-md-3 col-sm-6">
						<label for="TEMPLATE-2" class="template-selection">
							<div class="cell">
								<input type="radio" name="TEMPLATE" id="TEMPLATE-2" <?php if ($template == "TEMPLATE-2") echo "checked";?> value="TEMPLATE-2" required>
							</div>
							<div class="cell">
								<span>Pantalla horizontal</span>
							</div>
						</label>
					</div>

				</div>
			</fieldset>

			<fieldset class="col-md-12 form-group" id="CONFIG">
				<h3>Escribe tu mensaje</h3>

				<textarea name="CONTENT" id="CONTENT" placeholder="Escribe tu mensaje aquí" required><?=utf8_encode($txtmsg)?></textarea>

				<div class="validation"></div>

				<div><input type="submit" name="SUBMIT" id="SUBMIT" value="Previsualizar" class="btn btn-success">
				<input type="button" class="btn btn-success" name="volver" value="Volver" onclick="window.close();	window.history.back();">			
				</div>
				
				
				
			</fieldset>
		</form>
	</div>
</div>

	<script src="js/jquery-3.2.1.min.js"></script>

</body>
</html>