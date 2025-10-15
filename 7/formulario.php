<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Formulario de creacion de promocion para cofares</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="template.css">
</head>
<?php   
//error_reporting(E_ALL);
if(isset($_GET['version']))
	$version = $_GET['version'];
if(isset($_GET['format']))
	$template = $_GET['format'];
else
	$template="TEMPLATE-1";
if(isset($_GET['config'])){
	$config = $_GET['config'];
}

////////// JCAM

// Conexión a la B.D.
//include("../accesomysql.php");
$idcustomer = 7;  // COFARES
//$directoriocliente = $directoriobase."/".$idcustomer."/";
$idcontent   = 	0;
$idcampaign   = 0;

// Inicializar todos los valores posibles que se pasan como atributos
if(isset($config)){
	$json = file_get_contents($config);
	$json_data = json_decode($json);
	$farmacia = $json_data->farmacia;
	$title = $json_data->title;		
	$img = isset($json_data->img) ? $json_data->img : '';
	$content= $json_data->content;
	$price= $json_data->price;
	$claim= $json_data->claim;
	$horario_1= $json_data->horario_1;		
	$horario_2= $json_data->horario_2;		
	$horario_3= $json_data->horario_3;
	$facebook= $json_data->facebook;
	$twitter= $json_data->twitter;
	$pinterest= $json_data->pinterest;
	$youtube= $json_data->youtube;
	$linkedin= $json_data->linkedin;
} else {
	$farmacia = "";
	$title = "";		
	$img= "";
	$content= "";
	$price= "";
	$claim="";
	$horario_1="";		
	$horario_2="";		
	$horario_3="";
	$facebook="";
	$twitter="";
	$pinterest="";
	$youtube="";
	$linkedin="";
}
?>
<body>

<div class="container body" role="main">
<div class="row">
	<form action="preview.php" method="post" id="TEMPLATE_FORM" enctype="multipart/form-data" >
		<!---Pasar parametros al Preview. Solo hay que pasar el idcontent y el idcontenttemplate ya que los atributos se pasaran
		campo a campo -->
	
		<input type="hidden" name="idcontent" id="idcontent" value="">
		<input type="hidden" name="imagenamostrar" id="imagenamostrar" value="<?= $img ?>">	
		<input type="hidden" name="idcampaign" id="idcampaign" value="">				
		<input type="hidden" name="idcustomer" id="idcustomer" value="<?php echo $idcustomer?>">				
		
		<fieldset class="col-md-12 form-group" id="TEMPLATE">
			<h3>Elije tu diseño</h3>
			<div class="row align-items-center">
				<div class="form-check col col-md-4 col-sm-6">
					<label for="TEMPLATE-1" class="template-selection">
						<div class="cell">
							<!--- JCAM -->
							<input type="radio" name="TEMPLATE" id="TEMPLATE-1"  <?php if ($template == "TEMPLATE-1") echo "checked";?>   value="TEMPLATE-1">
							<!--- ENDJCAM -->
						</div>
						<div class="cell">
							<p>Oferta básica</p>
							<img src="templates/templates/oferta_A.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-md-4 col-sm-6">
					<label for="TEMPLATE-2" class="template-selection">
						<div class="cell">
						<!--- JCAM -->						
							<input type="radio" name="TEMPLATE" id="TEMPLATE-2" <?php if ($template == "TEMPLATE-2") echo "checked";?> value="TEMPLATE-2">
						<!--- ENDJCAM -->						
						</div>
						<div class="cell">
							<p>Oferta con frase</p>
							<img src="templates/templates/oferta_B.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-md-4 col-sm-6">
					<label for="TEMPLATE-3" class="template-selection">
						<div class="cell">
						<!--- JCAM -->
							<input type="radio" name="TEMPLATE" id="TEMPLATE-3" <?php if ($template == "TEMPLATE-3") echo "checked";?> value="TEMPLATE-3">
						<!--- ENDJCAM -->							
						</div>
						<div class="cell">
							<p>Oferta con imagen de fondo</p>
							<img src="templates/templates/oferta_C.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-md-4 col-sm-6">
					<label for="TEMPLATE-4" class="template-selection">
						<div class="cell">
						<!--- JCAM -->						
							<input type="radio" name="TEMPLATE" id="TEMPLATE-4" <?php if ($template == "TEMPLATE-4") echo "checked";?> value="TEMPLATE-4">
						<!--- ENDJCAM -->							
						</div>
						<div class="cell">
							<p>Oferta con imagen de fondo y frase</p>
							<img src="templates/templates/oferta_D.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-md-4 col-sm-6">
					<label for="TEMPLATE-5" class="template-selection">
						<div class="cell">
						<!--- JCAM -->						
							<input type="radio" name="TEMPLATE" id="TEMPLATE-5" <?php if ($template == "TEMPLATE-5") echo "checked";?> value="TEMPLATE-5">
						<!--- ENDJCAM -->							
						</div>
						<div class="cell">
							<p>Evento</p>
							<img src="templates/templates/evento.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-md-4 col-sm-6">
					<label for="TEMPLATE-6" class="template-selection">
						<div class="cell">
						<!--- JCAM -->						
							<input type="radio" name="TEMPLATE" id="TEMPLATE-6" <?php if ($template == "TEMPLATE-6") echo "checked";?> value="TEMPLATE-6">
						<!--- ENDJCAM -->							
						</div>
						<div class="cell">
							<p>Horarios</p>
							<img src="templates/templates/horarios.jpg">
						</div>
					</label>
				</div>
			</div>
		</fieldset>
		<fieldset class="col-md-12 form-group" id="CONFIG">
			<h3>Configura tu plantilla</h3>
			<div class="config-container">
				<div class="template-config">
					<!--- JCAM -->
					<input type="text" name="NOMBRE_FARMACIA" id="NOMBRE_FARMACIA" value="<?php echo $farmacia ?>"  placeholder="NOMBRE FARMACIA">
					<!--- ENDJCAM  -->
	 				<div class="fields-ofertas">
	 					<div class="info">
					<!-- JCAM -->						
							<textarea name="TITLE" id="TITLE" rows="2" placeholder="Nombre del producto o evento"><?php echo $title ?></textarea>

							<textarea name="CONTENT" id="CONTENT" placeholder="Descripción del producto/evento"><?php echo $content ?> </textarea>
					<!--- ENDJCAM  -->				
					</div>
					<div class="field-price">
					<!--- JCAM -->						
							<p><input type="text" name="PRICE" id="PRICE" value="<?php echo $price ?>" placeholder="oferta"></p>
					<!-- ENDJCAM  -->
					</div>

					<div class="field-claim">
					<!--- JCAM -->						
							<p><input type="text" name="CLAIM" id="CLAIM" value="<?php echo $claim ?>" placeholder="Fecha de vigencia"></p>
					<!-- ENDJCAM  -->							
					</div>
					<!---<div class="img-preview"></div>-->		
					<div class="img-preview" style="background: url(<?= $img ?>) no-repeat center center; background-size: contain; "><img src="<?php //echo $img?>"></div>
					<div class="field-img">
							<h5>Imagen</h5>
					<!--- JCAM -->							
						<input type="file" name="IMG" id="IMG" value="" style="color: transparent;">
					<!--- ENDJCAM  -->								
					</div>
				</div>

				<div class="fields-horarios">
					<!--- JCAM -->					
						<input type="text" name="HORARIO_1" id="HORARIO_1" value="<?php echo $horario_1 ?>" placeholder="Horario 1">
						<input type="text" name="HORARIO_2" id="HORARIO_2" value="<?php echo $horario_2 ?>" placeholder="Horario 2">
						<input type="text" name="HORARIO_3" id="HORARIO_3" value="<?php echo $horario_3 ?>" placeholder="Horario 3">
					<!--- ENDJCAM  -->	
						<div class="fields-RRSS">
							<h5>¿Tienes redes sociales?</h5>
							<div class="row">
								<div class="col form-check">
									<label class="form-check-label"><input type="checkbox" class="form-check-input" name="FACEBOOK" id="FACEBOOK" <?php if ($facebook) echo "checked";?>  placeholder="http://www.facebook.com/..."> Facebook</label></div>
								<div class="col form-check">
									<label class="form-check-label"><input type="checkbox" class="form-check-input" name="TWITTER" id="TWITTER" <?php if ($twitter) echo "checked";?> placeholder="@usuario"> Twitter</label></div>
								<div class="col form-check">
									<label class="form-check-label"><input type="checkbox" class="form-check-input" name="PINTEREST" id="PINTEREST" <?php if ($pinterest) echo "checked";?> placeholder="nombre de usuario"> Pinterest</label></div>
								<div class="col form-check">
									<label class="form-check-label"><input type="checkbox" class="form-check-input" name="YOUTUBE" id="YOUTUBE" <?php if ($youtube) echo "checked";?> placeholder="https://www.youtube.com/user/..."> Youtube</label></div>
								<div class="col form-check">
									<label class="form-check-label"><input type="checkbox" class="form-check-input" name="LINKEDIN" id="LINKEDIN" <?php if ($linkedin) echo "checked";?> placeholder="https://www.linkedin.com/in/..."> LinkedIn</label></div>
							</div>
						</div>
				</div>
				<div class="bg-image backsize"></div>						
			</div>
			<div class="validation"></div>
			<div><input type="submit" name="SUBMIT" id="SUBMIT" value="Previsualizar" class="btn btn-success">
			<input type="button" class="btn btn-success" name="volver" value="Volver" onclick="window.close();	window.history.back();">			
			</div>
		</fieldset>
	</form>
</div>
</div>
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="script.js"></script>
</body>
</html>