<?php
	function nl2p($string)
	{
		$paragraphs = '';
	
		foreach (explode("\n", $string) as $line) {
			if (trim($line)) {
				$paragraphs .= '<p>' . $line . '</p>';
			}
		}
	
		return $paragraphs;
	}
?>

<?php
	$template			= $_POST["TEMPLATE"];
	$template_number	= substr($template, -1);

	$data = [
		'title'		=> $_POST["TITLE"],				//
		'desc'		=> $_POST["DESCRIPCION"],			//
		'subdesc'	=> $_POST["SUBDESCRIPCION"],
		'price'		=> $_POST["PRICE"],
		'subprice'	=> $_POST["SUBPRICE"],				//
		'legal' 	=> $_POST["LEGAL"],			//
		'diente_1' 	=> $_POST["DIENTE_1"],			//
		'diente_2' 	=> $_POST["DIENTE_2"],			//
		'diente_3' 	=> $_POST["DIENTE_3"],			//
		'diente_4' 	=> $_POST["DIENTE_4"],			//
		'diente_5' 	=> $_POST["DIENTE_5"],			//
		'diente_6' 	=> $_POST["DIENTE_6"],			//
		'diente_7' 	=> $_POST["DIENTE_7"],			//
		'diente_8' 	=> $_POST["DIENTE_8"],			//
		'cambio_img'=> !empty($_POST["CAMBIO_IMG"])?$_POST["CAMBIO_IMG"]:null, 			//
		'num_dientes' 	=> intval($_POST["NUM_DIENTES"])			//
	];

/*  	
	foreach ($_POST as $key => $value) {
		echo htmlspecialchars($key).": ".htmlspecialchars($value)."<br>";
	}
 */

	switch ( $template_number ) {
		case '1':
			$tipo 		= 'offer';
			$bg_clases	= 'offer offer_1';
			$has_bg_img	= false;
			break;
		case '2':
			$tipo 		= 'offer';
			$bg_clases	= 'offer offer_2';
			$has_bg_img	= false;
			break;
		case '3':
			$tipo 		= 'description';
			$bg_clases	= 'description';
			$has_bg_img	= true;
			break;
		case '4':
			$tipo 		= 'message';
			$bg_clases	= 'message';
			$has_bg_img	= true;
			break;
	}
	$idcustomer   = $_POST["idcustomer"];
	if( $tipo != 'offer' && !isset($data['cambio_img']) ) {
		$bg_clases .= ' no_img';
	}
	include("../accesomysql.php");
	$directoriocliente = $directoriobase."/".$idcustomer."/";
	$dirbase = "ids.ladorianids.es";
	$plantillascontenido = BASE_PATH . '/' . $idcustomer . '/';

	$conexionbd  = mysqli_connect($sql_host,$sql_login,$sql_pass,$sql_base) or die("Error en la conexión a la Base de Datos...:".mysqli_connect_error());
	mysqli_select_db($conexionbd,$sql_base) OR  die ('Error en la selección de la Base de Datos...' . mysqli_error());


	// Se mira qué TEMPLATE se ha elegido en la pantalla de elección de plantilla (porque se ha podido cambiar respecto al que hubiera)
	$sql = "SELECT idcontenttemplate AS wid from content_template where idcustomer = ". $idcustomer.
		" AND name = '". $template  ."'";	  	
	$registro=mysqli_query($conexionbd,$sql) or die("Error en la query...:". $sql."  ".mysqli_error($conexionbd));	
	while ($datos=mysqli_fetch_array($registro))  
	{
		$idcontenttemplate = $datos["wid"];
	}

	$data = array (
		'desc'		=> $_POST["DESCRIPCION"],
		'subdesc'	=> $_POST["SUBDESCRIPCION"],
		'title'				=> $_POST["TITLE"],
		'price'				=> $_POST["PRICE"],
		'subprice'			=> $_POST["SUBPRICE"],
		'legal'				=> $_POST["LEGAL"],
		'diente_1' 			=> $_POST["DIENTE_1"],
		'diente_2' 			=> $_POST["DIENTE_2"],
		'diente_3' 			=> $_POST["DIENTE_3"],
		'diente_4' 			=> $_POST["DIENTE_4"],
		'diente_5' 			=> $_POST["DIENTE_5"],
		'diente_6' 			=> $_POST["DIENTE_6"],
		'diente_7' 			=> $_POST["DIENTE_7"],
		'diente_8' 			=> $_POST["DIENTE_8"],
		'cambio_img' 		=> !empty($POST["CAMBIO_IMG"])?$POST["CAMBIO_IMG"]:false,
		'num_dientes'		=> $_POST["NUM_DIENTES"]
	);

	// Cuando alguno de los atributos sea una IMAGEN hay que ponerla como :   $_FILES["IMG"]["name"]
	$imagenelegida="";
	$imagenleida="";

	$old_image="";
	$destination_path = getcwd().DIRECTORY_SEPARATOR;

    $imagen="";

	if($_POST['imagenamostrar'] != ""){
		if($_POST['imagenamostrar'] == $_FILES['IMG']['name'] || $_FILES['IMG']['name'] == ""){
			$imagenleida =  $_POST['imagenamostrar'];
			$imagen = $imagenleida;
		}
		else
		{	//hay una foto y se puede reemplazar

			$old_image= $_POST['imagenamostrar'];
			$nombre_image = time() . ".".pathinfo($_FILES['IMG']['name'], PATHINFO_EXTENSION);
			$target_path = $destination_path ."templates/".$nombre_image;
			@move_uploaded_file($_FILES['IMG']['tmp_name'], $target_path);
			$imagen = "https://".$_SERVER["HTTP_HOST"].$plantillascontenido.'templates/'.$nombre_image;	
		}		
	}
	else 
	{

		if($_FILES['IMG']['name']!=""){
			$nombre_image = time() . ".".pathinfo($_FILES['IMG']['name'], PATHINFO_EXTENSION);
			$target_path = $destination_path ."templates/".$nombre_image;
			move_uploaded_file($_FILES['IMG']['tmp_name'], $target_path);
			$imagen = "https://".$_SERVER["HTTP_HOST"].$plantillascontenido.'templates/'.$nombre_image;
		}
	}	


	$atributos[] = array(
		'desc'				=> $_POST["DESCRIPCION"],
		'subdesc'			=> $_POST["SUBDESCRIPCION"],
		'title'				=> $_POST["TITLE"],
		'price'				=> $_POST["PRICE"],
		'subprice'			=> $_POST["SUBPRICE"],
		'legal'				=> $_POST["LEGAL"],
		'diente_1' 			=> $_POST["DIENTE_1"],
		'diente_2' 			=> $_POST["DIENTE_2"],
		'diente_3' 			=> $_POST["DIENTE_3"],
		'diente_4' 			=> $_POST["DIENTE_4"],
		'diente_5' 			=> $_POST["DIENTE_5"],
		'diente_6' 			=> $_POST["DIENTE_6"],
		'diente_7' 			=> $_POST["DIENTE_7"],
		'diente_8' 			=> $_POST["DIENTE_8"],
		'cambio_img' 		=> !empty($POST["CAMBIO_IMG"])?$POST["CAMBIO_IMG"]:false,
		'num_dientes'		=> $_POST["NUM_DIENTES"],
		'img'				=> $imagen
	);							
						
	// Grabar en el campo "attributes" de content_template,	en formato JSON,, los valores de los campos variables
	$json_string = json_encode($atributos);
	// Se sustituye de momento la " por el caracter ^ ya que con la primera se corta la variable... En la grabacion se volvera a sustituir por la "
	$json_string = str_replace("\"","^",$json_string);
?>
<input type="hidden" name="atributos" id="atributos" value="<?php echo $json_string?>">
<input type="hidden" name="idcontenttemplate" id="idcontenttemplate" value="<?php echo $idcontenttemplate?>">
<input type="hidden" name="idcontent" id="idcontent" value="<?php echo $idcontent?>">
<input type="hidden" name="oldimage" id="oldimage" value="<?=$old_image?>">
<input type="hidden" name="destinationPath" id="destinationPath" value="<?=$destination_path?>">
<input type="hidden" name="idcampaign" id="idcampaign" value="<?=$idcampaign?>">
<input type="hidden" name="idcustomer" id="idcustomer" value="<?= $idcustomer ?>">

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Plantillas carralero</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/carralero.css">
	<?php 

	if($has_bg_img){
		
		if(empty($imagen) && !empty($POST["CAMBIO_IMG"])){
			echo "<h1>Para continuar primero debes seleccionar una imagen</h1>";
			echo "<meta http-equiv=\"refresh\" content=\"3;url=". $_SERVER['HTTP_REFERER']."\"/>";
			die;
		}

		$tamanio = getImageSize($imagen);
		$ancho =$tamanio[0];
		$alto =$tamanio[1];

		if($ancho > $alto){
		?>
			<style>
				.oferta_con_bg #TEMPLATE_CONTENT {
					background-image: url('<?php echo $imagen; ?>')	!important;	
					background-repeat: no-repeat!important;
					background-size:cover!important;
					background-position:center center!important
				}
			</style>
		<?php
		}
		else{
		?>
		<style>
			.oferta_con_bg #TEMPLATE_CONTENT {
				background-image: url('<?php echo $imagen; ?>')	!important;	
				background-repeat: no-repeat!important;
				background-size:contain!important;
				background-position:center center!important
			}
		
		</style>
		<?php  }
	}
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script> 		

	<script language="JavaScript">
			function cerrar(){
				parent.postMessage({message: "close"}, "*");
			}
			function grabarplantilla()
			{
		
				$('#saveplantilla').addClass('disabled');
				//
				$('#saveplantilla').prop('onclick',null).off('click');

				var atributos = document.getElementById("atributos").value;
				var plantilla = document.getElementById("idcontenttemplate").value;
				var contenido = document.getElementById("idcontent").value;
				var idcampaign = document.getElementById("idcampaign").value;
				var oldimage = document.getElementById("oldimage").value;
				var destinationPath = document.getElementById("destinationPath").value;

                                var idcustomer = document.getElementById("idcustomer").value;

                                var contenedor =
                                                                 "<html lang='es'><head><meta http-equiv='Content-type' content='text/html; charset=utf-8'>"+
								 //"<title>Plantilla de menus diarios</title>"+								 
								 
								"<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css'>"+
								"<link rel='stylesheet' href='<?php echo $directoriobase?>/fonts/font-awesome.min.css'>"+													
								 
								"<link rel='stylesheet' href='<?php echo $directoriocliente?>"+"css/carralero.css'>"+
								"<?php if( $has_bg_img ) { 
									$tamanio = getImageSize($imagen);
									$ancho =$tamanio[0];
									$alto =$tamanio[1];
								if($ancho > $alto){
								?>"+
								"	<style> "+
								"		.oferta_con_bg #TEMPLATE_CONTENT {" +
								"			background-image: url('<?php echo $imagen; ?>')	!important;	" +	
								"			background-repeat: no-repeat!important;" +	
								"			background-size:cover!important;" +	
								"			background-position:center center!important	" +	
								"		} "   +
								" 	.bgwhite{background-color:white;}"+
								"	</style> " + 
								"<?php } else { ?>"	+		
								"	<style> "+
								"		.oferta_con_bg #TEMPLATE_CONTENT {" +
								"			background-image: url('<?php echo $imagen; ?>')	!important;	" +		
								"			background-repeat: no-repeat!important;	" +	
								"			background-size:contain!important;	" +	
								"			background-position:center center!important	" +	
								"		} "   +
								" 	.bgwhite{background-color:white;}"+
								"	</style> " + 
								"<?php } }?>"	+						 
							 
								 "</head><body class='<?php echo $bg_clases; ?>' >"+
								 "<div class='wrapper' id='TEMPLATE_CONTENT' >"+								 
								 document.getElementById("divcuerpoHTML").outerHTML+
								 "</div></body></html>";

	//			$('.loading').css('display','block');

                                var $saveButton = $('#saveplantilla');

                                function enableSaveButton() {
                                        $saveButton.removeClass('disabled');
                                        $saveButton.off('click').on('click', grabarplantilla);
                                }

                                $.ajax({
                                  url: "../grabaplantilla.php",
                                  method: "POST",
                                  data: {
                                        html : contenedor,
                                        atributos: atributos,
                                        plantilla: plantilla,
                                        contenido: contenido,
                                        idcampaign: idcampaign,
                                        idcustomer: idcustomer,
                                        imagen: $('#saveplantilla').data('imagen'),
                                        oldimage: oldimage,
                                        destinationPath: destinationPath
                                         },
                                  dataType: "json"
                                })
                                .done(function(result) {
                                        if(result && result.success) {
                                                parent.postMessage({domain:'ladorian.ids.template', 'key': 'template-url', 'value': result.data}, '*');
                                                window.close();
                                        } else {
                                                var message = (result && result.error) ? result.error : 'Se ha producido un error al guardar la plantilla.';
                                                alert(message);
                                                enableSaveButton();
                                        }
                                }).fail(function(jqXHR){
                                        var message = 'Se ha producido un error al guardar la plantilla.';
                                        if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                                                message = jqXHR.responseJSON.error;
                                        }
                                        alert(message);
                                        enableSaveButton();
                                });
				

			}
	</script>	
</head>

<body class="<?php echo $bg_clases; ?>">
	<div class="wrapper" id="TEMPLATE_CONTENT">
		<div class="contenedor" name = "divcuerpoHTML" id="divcuerpoHTML">
			<?php if( $tipo == 'description' ) : ?>
				<img src="carralero-templates/logo-white.png" class="logo">
			<?php else : ?>
				<img src="carralero-templates/logo.png" class="logo">
			<?php endif; ?>
			<?php if( isset($data['title']) ) : ?>
				<?php if( $has_bg_img ) : ?>
				<div class="bg-mask"></div>
			<?php endif; ?>
				<header id="TITLE">
					<div class="title-move">
						<?php echo nl2p($data['title']); ?>
					</div>
				</header>
			<?php endif; ?>


			<div class="data-ofertas">
				<div class="info">
					<div id="DESCRIPCION"><?php echo nl2p($data['desc']); ?></div>
					<div id="SUBDESCRIPCION"><?php echo nl2p($data['subdesc']); ?></div>
				</div>

				<div class="price">
					<div class="price__move">
						<div class="price__label">
							<p id="PRICE"><?php echo $data['price']; ?></p>
							<p id="SUBPRICE"><?php echo $data['subprice']; ?></p>
							<p id="LEGAL"><?php echo $data['legal']; ?></p>
						</div>
					</div>
				</div>
			</div>

			<?php if( $tipo !== 'message' || isset($data['cambio_img']) ) : ?>
				<div class="img-container">
					<div class="img-move">
						<div class="img" style="background-image:url(<?php echo $imagen ?>);"></div>
					</div>
				</div>
			<?php endif; ?>
			<?php if( $template_number == '2' ) : ?>
				<div class="img-border"></div>
				<div class="img-bg"></div>
			<?php endif; ?>

			<?php if( $tipo == 'description' ) : ?>
				<div class="fields-dientes" id="TEETH">
					<div class="column">
						<div id="DIENTE_1" class="diente">
							<div class="diente_content">
								<?php echo nl2p($data['diente_1']); ?>
							</div>
						</div>
						<div id="DIENTE_2" class="diente">
							<div class="diente_content">
								<?php echo nl2p($data['diente_2']); ?>
							</div>
						</div>
					</div>
					<div class="column">
						<div id="DIENTE_3" class="diente">
							<div class="diente_content">
								<?php echo nl2p($data['diente_3']); ?>
							</div>
						</div>
						<div id="DIENTE_4" class="diente">
							<div class="diente_content">
								<?php echo nl2p($data['diente_4']); ?>
							</div>
						</div>
					</div>
					<?php if( $data['num_dientes'] > 4 ) : ?>
						<div class="column">
							<div id="DIENTE_5" class="diente">
								<div class="diente_content">
									<?php echo nl2p($data['diente_5']); ?>
								</div>
							</div>
							<div id="DIENTE_6" class="diente">
								<div class="diente_content">
									<?php echo nl2p($data['diente_6']); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if( $data['num_dientes'] > 6 ) : ?>
						<div class="column">
							<div id="DIENTE_7" class="diente">
								<div class="diente_content">
									<?php echo nl2p($data['diente_7']); ?>
								</div>
							</div>
							<div id="DIENTE_8" class="diente">
								<div class="diente_content">
									<?php echo nl2p($data['diente_8']); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="wrapper" id="BUTTONS">
		<div class="btns">
			<input type="button" class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();">
			<input type="button" class="btn btn-primary" name="volver" value="Volver" onclick="window.close();	window.history.back();">
		</div>
	</div>

	<script>
		$(document).ready(function(){

			html2canvas($('#TEMPLATE_CONTENT'), {
	         onrendered: function (canvas) {
					var imgageData = canvas.toDataURL("image/png");
				    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
					$("#saveplantilla").data("imagen", newData);
					console.log(newData);
				}
				

	         });			    

		});

		$(window).load(function() { 
			$(".loading").delay(5000).fadeOut("slow"); 
		});	
		
	</script>		
</body>

</html>
























