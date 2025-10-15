<?php
	$template			= $_POST["TEMPLATE"];
	$template_number	= substr($template, -1);

	$data = [
		'title'		=> $_POST["TITLE"],				//
		'content'	=> $_POST["CONTENT"],			//
		'price'		=> $_POST["PRICE"],
		'claim'		=> $_POST["CLAIM"],
		//'img'		=> $_POST["IMG"],				//
		'facebook' 	=> !empty($_POST["FACEBOOK"])?$_POST["FACEBOOK"]:null, 			//
		'twitter' 	=> !empty($_POST["TWITTER"])?$_POST["TWITTER"]:null,
		'instagram' => !empty($_POST["INSTAGRAM"])?$_POST["INSTAGRAM"]:null,			//
		'pinterest' => !empty($_POST["PINTEREST"])?$_POST["PINTEREST"]:null,		//
		'youtube' 	=> !empty($_POST["YOUTUBE"])?$_POST["YOUTUBE"]:null,			//
		'linkedin' 	=> !empty($_POST["LINKEDIN"])?$_POST["LINKEDIN"]:null,			//
	];

/* 	
	foreach ($_POST as $key => $value) {
		echo htmlspecialchars($key).": ".htmlspecialchars($value)."<br>";
	}
 */
	switch ( $template_number ) {
		case '1':
			$tipo 		= 'oferta';
			$bg_clases	= 'oferta';
			$has_bg_img	= false;
			break;
		case '2':
			$tipo 		= 'oferta';
			$bg_clases	= 'oferta oferta_L';
			$has_bg_img	= false;
			break;
		case '3':
			$tipo 		= 'evento';
			$bg_clases	= 'oferta oferta_L evento';
			$has_bg_img	= false;
			break;
	}
	$idcustomer   = $_POST["idcustomer"];	
	$idcontent    = $_POST["idcontent"];
	$idcampaign   = $_POST["idcampaign"];
	
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
	
	 
	// Se incluye este codigo ya que cuando se elige una plantilla que no tiene estos campos de RRSS, falla	
	$facebook = false;	
	$twitter = false;	
	$pinterest = false;	
	$youtube = false;
	$linkedin = false;
	$instagram = false;
	if(isset($_POST["FACEBOOK"])){ 	$facebook = true;}
	if(isset($_POST["TWITTER"])){	$twitter = true;}
	if(isset($_POST["PINTEREST"])){ $pinterest = true;}
	if(isset($_POST["YOUTUBE"])){	$youtube = true;}  
	if(isset($_POST["LINKEDIN"])){	$linkedin = true;} 
	if(isset($_POST["INSTAGRAM"])){	$instagram = true;}

		$data = array (
			'title'		=> $_POST["TITLE"],
			'content'	=> $_POST["CONTENT"],
			'price'		=> $_POST["PRICE"],
			'claim'		=> $_POST["CLAIM"],
			'facebook' 	=> $facebook,
			'twitter' 	=> $twitter,
			'pinterest' => $pinterest,
			'youtube' 	=> $youtube,
			'linkedin' 	=> $linkedin,
			'instagram' => $instagram
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
							'img'		=> $imagen,
							'title'		=> $_POST["TITLE"],
							'content'	=> $_POST["CONTENT"],
							'price'		=> $_POST["PRICE"],
							'claim'		=> $_POST["CLAIM"],
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

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Plantillas cofares</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="fonts/font-awesome.min.css">
	<link rel="stylesheet" href="front.css">
	
	

</head>

<body class="<?php echo $bg_clases; ?>">
	<div class="wrapper" id="TEMPLATE_CONTENT">
		<div class="contenedor" name = "divcuerpoHTML" id="divcuerpoHTML">
			<?php if( $data['facebook'] || $data['twitter'] || $data['instagram'] || $data['pinterest'] || $data['youtube'] || $data['linkedin'] ) : ?>
				<header>
					<div class="RRSS">
						<ul>
							<?php if( $data['facebook'] ) : ?>
								<li><i class="fa fa-facebook"></i></li>
							<?php endif; ?>
							<?php if( $data['twitter'] ) : ?>
								<li><i class="fa fa-twitter"></i></li>
							<?php endif; ?>
							<?php if( $data['instagram'] ) : ?>
								<li><i class="fa fa-instagram"></i></li>
							<?php endif; ?>
							<?php if( $data['youtube'] ) : ?>
								<li><i class="fa fa-youtube"></i></li>
							<?php endif; ?>
							<?php if( $data['linkedin'] ) : ?>
								<li><i class="fa fa-linkedin"></i></li>
							<?php endif; ?>
							<?php if( $data['pinterest'] ) : ?>
								<li><i class="fa fa-pinterest-p"></i></li>
							<?php endif; ?>
						</ul>
					</div>
				</header>
			<?php endif; ?>

			<section class="oferta__main">
				<figure class="oferta__img">
					<div style="background-image:url(<?php echo $imagen; ?>); background-repeat: no-repeat; background-position-y: center; background-position-x: center;     background-color: white;" class="img"></div>
				</figure>
				<div class="oferta__details group">
					<h1 class="oferta__name" id="TITLE"><?php echo nl2br($data['title']); ?></h1>
					<?php if( $data['content'] ) : ?>
						<div class="oferta__info" id="CONTENT">
							<p><?php echo nl2br($data['content']); ?></p>
						</div>
					<?php endif; ?>
				</div>
				<div class="oferta__extras">
					<?php if( $data['claim'] ) : ?>
						<h2 class="oferta__claim" id="CLAIM"><?php echo $data['claim']; ?></h2>
					<?php endif; ?>
					<h2 class="oferta__price" id="PRICE"><?php echo $data['price']; ?></h2>
				</div>
			</section>

		</div>
	</div>

	<div class="wrapper" id="BUTTONS">
		<div class="btns">
			<input type="button" id="saveplantilla" data-imagen="" data-imagen="" class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla()">
			<input type="button" class="btn btn-primary" name="volver" value="Volver" onclick="window.close(); window.history.back();">
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script> 		

	<script >
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

				var contenedor =
								 "<html lang='es'><head><meta http-equiv='Content-type' content='text/html; charset=utf-8'>"+
								 //"<title>Plantilla de menus diarios</title>"+								 
								 
								"<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css'>"+
								"<link rel='stylesheet' href='<?php echo $directoriobase?>/fonts/font-awesome.min.css'>"+													
								 
								"<link rel='stylesheet' href='<?php echo $directoriocliente?>"+"front.css'>"+
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
 resp={ 
					html : contenedor,
				  	atributos: atributos,
				  	plantilla: plantilla,
				  	contenido: contenido,
				  	idcampaign: idcampaign,
				  	imagen: $('#saveplantilla').data('imagen'),
				  	oldimage: oldimage,
				  	destinationPath: destinationPath
				  	 };
					   console.log(resp);
				$.ajax({
				  url: "../grabaplantilla.php",
				  method: "POST",
				  data: { 
					html : contenedor,
				  	atributos: atributos,
				  	plantilla: plantilla,
				  	contenido: contenido,
				  	idcampaign: idcampaign,
				  	imagen: $('#saveplantilla').data('imagen'),
				  	oldimage: oldimage,
				  	destinationPath: destinationPath
				  	 },
				  dataType: "json"
				})
				.done(function(result) {
					if(result.success) {
						console.log(result);
						parent.postMessage(result.data, '*');
					}
				}).fail(function( jqXHR, textStatus, errorThrown ) {
					console.log(jqXHR  );
				}).always(function(){
					window.close();
				});				
				

			}
	</script>
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




























