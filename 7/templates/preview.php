<?php
	$template			= $_POST["TEMPLATE"];
	$template_number	= substr($template, -1);
	
	switch ( $template_number ) {
		case '1':
			$tipo 		= 'oferta';
			$has_bg_img	= false;
			$has_price	= true;
			$has_claim	= false;
			$bg_clases	= 'oferta';
			$bg_color = 'bgwhite';
			$bgcontent = 'background-color: white';
			break;
		case '2':
			$tipo 		= 'oferta';
			$has_bg_img	= false;
			$has_price	= true;
			$has_claim	= true;
			$bg_clases	= 'oferta oferta_con_claim';
			$bg_color = 'bgwhite';
			$bgcontent = 'background-color: white';
			break;
		case '3':
			$tipo 		= 'oferta';
			$has_bg_img	= true;
			$has_price	= true;
			$has_claim	= false;
			$bg_clases	= 'oferta oferta_con_bg';
			$bg_color = 'bgwhite';
			$bgcontent = 'background-color: white';
			break;
		case '4':
			$tipo 		= 'oferta';
			$has_bg_img	= true;
			$has_price	= true;
			$has_claim	= true;
			$bg_clases	= 'oferta oferta_con_bg oferta_con_claim';
			$bg_color = 'bgwhite';
			$bgcontent = 'background-color: white';
			//$bgcontent = 'background:linear-gradient(to right, #56D6BF, #49A9B6)';
			break;
		case '5':
			$tipo 		= 'evento';
			$has_bg_img	= true;
			$has_price	= false;
			$has_claim	= true;
			$bg_clases	= 'evento oferta_con_bg oferta_con_claim';
			$bg_color = 'bgwhite';
			$bgcontent = 'background-color: white';
			//$bgcontent = 'background:linear-gradient(to right, #56D6BF, #49A9B6)';
			break;
		case '6':
			$tipo 		= 'horarios';
			$has_bg_img	= false;
			$has_price	= false;
			$has_claim	= false;
			$bg_clases	= 'horarios';
			$bg_color = '';
			$bgcontent = 'background:linear-gradient(to right, #56D6BF, #49A9B6)';
			break;
	}	
$idcustomer   = $_POST["idcustomer"];	
$idcontent    = $_POST["idcontent"];
$idcampaign   = $_POST["idcampaign"];

include("../accesomysql.php");
$directoriocliente = $directoriobase."/".$idcustomer."/";
$dirbase = "ladorianids.com";
$dirbase = "idsv4.ladorianids.es";
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

 
// Se incluye este codigo ya que cuando se elige una plantilla que no tiene estos campos de RRSS, falla	
$facebook = false;	
$twitter = false;	
$pinterest = false;	
$youtube = false;
$linkedin = false;
if(isset($_POST["FACEBOOK"])){ 	$facebook = true;}
if(isset($_POST["TWITTER"])){	$twitter = true;}
if(isset($_POST["PINTEREST"])){ $pinterest = true;}
if(isset($_POST["YOUTUBE"])){	$youtube = true;}  
if(isset($_POST["LINKEDIN"])){	$linkedin = true;} 

	$data = array (
		'farmacia'	=> $_POST["NOMBRE_FARMACIA"],
		//'img'		=> $_POST["IMG"],
		'title'		=> $_POST["TITLE"],
		'content'	=> $_POST["CONTENT"],
		'price'		=> $_POST["PRICE"],
		'claim'		=> $_POST["CLAIM"],
		'horario_1' => $_POST["HORARIO_1"],
		'horario_2' => $_POST["HORARIO_2"],
		'horario_3' => $_POST["HORARIO_3"],
		
		'facebook' 	=> $facebook,
		'twitter' 	=> $twitter,
		'pinterest' => $pinterest,
		'youtube' 	=> $youtube,
		'linkedin' 	=> $linkedin
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
	echo $_FILES['IMG']['tmp_name']."<br>";
	echo $target_path."<br>";
	echo $imagen."<br>";
		}
	}	


	$atributos[] = array(
						'farmacia'	=> $_POST["NOMBRE_FARMACIA"],
						'img'		=> $imagen,
						'title'		=> $_POST["TITLE"],
						'content'	=> $_POST["CONTENT"],
						'price'		=> $_POST["PRICE"],
						'claim'		=> $_POST["CLAIM"],
						'horario_1' => $_POST["HORARIO_1"],
						'horario_2' => $_POST["HORARIO_2"],
						'horario_3' => $_POST["HORARIO_3"],							
						'facebook' 	=> $facebook,
						'twitter' 	=> $twitter,
						'pinterest' => $pinterest,
						'youtube' 	=> $youtube,
						'linkedin' 	=> $linkedin
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
<!--- ENDJCAM -->


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Plantillas cofares</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="../fonts/font-awesome.min.css">

	<link rel="stylesheet" href="estilo.css?tmp=<?=time()?>">
	
	<?php 

	if($has_bg_img){
		
		if(empty($imagen)){
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
	
<!---////////// JCAM -->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script> 		

	<script language="JavaScript">
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
								 
								"<link rel='stylesheet' href='<?php echo $directoriocliente?>"+"estilo2.css'>"+
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
                                        if (result && result.success) {
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
<!---////////// ENDJCAM -->	
</head>




<body class="<?php echo $bg_clases; ?>">
<!--- s -->
<div class="loading"></div>

	<div class="wrapper" id="TEMPLATE_CONTENT" style="<?=$bgcontent?>">
		<div class="contenedor" name = "divcuerpoHTML" id="divcuerpoHTML">
<!--- x -->	
			<?php if( $has_bg_img ) : ?>
				<div class="bg-mask"></div>
			<?php endif; ?>
			<header>
				<div class="nombre">
					<h2><span>Farmacia</span><span id="NOMBRE_FARMACIA"><?php echo $data['farmacia']; ?></span></h2>
					<?php if ( $tipo === 'oferta' || $tipo === 'evento' ) : ?>
						<img src="<?php echo $directoriocliente.'templates/cruz.png'?>" class="icon">
					<?php endif; ?>
				</div>
				<?php if ( $tipo === 'horarios' ) : ?>
					<?php if( $data['facebook'] || $data['twitter'] || $data['pinterest'] || $data['youtube'] || $data['linkedin'] ) : ?>
						<div class="RRSS">
							<p>Síguenos en:</p>
							<ul>
								<?php if( $data['facebook'] ) : ?>
									<li><i class="fa fa-facebook-official"></i></li>
								<?php endif; ?>
								<?php if( $data['twitter'] ) : ?>
									<li><i class="fa fa-twitter"></i></li>
								<?php endif; ?>
								<?php if( $data['pinterest'] ) : ?>
									<li><i class="fa fa-pinterest-p"></i></li>
								<?php endif; ?>
								<?php if( $data['youtube'] ) : ?>
									<li><i class="fa fa-youtube"></i></li>
								<?php endif; ?>
								<?php if( $data['linkedin'] ) : ?>
									<li><i class="fa fa-linkedin"></i></li>
								<?php endif; ?>
							</ul>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</header>

			<?php if( $tipo === 'horarios') : ?>

				<section class="horarios__main">
					<h1>Horario</h1>
					<p><?php echo $data['horario_1'] ? $data['horario_1'] : '&nbsp;'; ?></p>
					<p><?php echo $data['horario_2'] ? $data['horario_2'] : '&nbsp;'; ?></p>
					<p><?php echo $data['horario_3'] ? $data['horario_3'] : '&nbsp;'; ?></p>
				</section>

			<?php else : ?>

				<section class="oferta__main">
					<?php if( $has_bg_img ) : ?>
						<div class="oferta__details group">
							<h1 class="oferta__name"><?php echo $data['title']; ?></h1>
					<?php else : ?>
						<h1 class="oferta__name"><?php echo $data['title']; ?></h1>
						<div class="oferta__details group">
							<figure class="oferta__img" 
							     style="background-image: url(<?=$imagen;?>); background-repeat:no-repeat; background-position: center center; background-size: contain;">
							</figure>

				<?php endif; ?>

				<?php if($template_number == 1) {
				?>
					<div class="ofelta__info">
						<?=nl2br($data['content']); ?>
					</div>
					<?php if( $has_price && !$has_bg_img ) : ?>
						<h2 class="ofelta__price"><?php echo $data['price']; ?></h2>
					<?php endif; ?>
				<?php
				}
				elseif($template_number == 2) {
					?>
						<div class="ofelta2__info">
							<?=nl2br($data['content']); ?>
						</div>
						<?php if( $has_price && !$has_bg_img ) : ?>
							<h2 class="ofelta2__price"><?php echo $data['price']; ?></h2>
						<?php endif; ?>
					<?php
				}
				else{
				?>
					<div class="oferta__info">
						<?=nl2br($data['content']); ?>
						<?php if( $has_price && !$has_bg_img ) : ?>
							<h2 class="oferta__price"><?php echo $data['price']; ?></h2>
						<?php endif; ?>
					</div>
				<?php
				}
				?>

						</div>
					<?php if( $has_price && $has_bg_img ) : ?>
						<h2 class="oferta__price"><?php echo $data['price']; ?></h2>
					<?php endif; ?>
					<?php if( $has_claim ) : ?>
						<h2 class="oferta__claim <?php if( $tipo === 'evento' ) echo 'evento__claim' ?>"><?php echo $data['claim']; ?></h2>
					<?php endif; ?>
				</section>

			<?php endif; ?>

		</div>
	</div>


	
	
	<br><br>
	
	<div class="wrapper" id="BUTTONS">
		<div class="btns">
			<?php $ira = "https://".$dirbase."/campaign/campaigns/campaigncontent/".$idcontent; ?>
			<input type="button" id="saveplantilla" data-imagen="" data-imagen=""  class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();"> 
			<!---<input type="button" class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();window.close();	window.history.back();"> -->
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


	<style>
/* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999999;
  height: 5em;
  width: 5em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.3);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 40px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

	</style>

</body>
</html>