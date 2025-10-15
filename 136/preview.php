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

	$template			= $_POST["TEMPLATE"];
	$template_number	= substr($template, -1);
	$template_dir       = '/plantillascontenidov4/136';

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
			break;
		case '2':
			$tipo 		= 'oferta';
			$bg_clases	= 'oferta oferta_L';
			break;
		case '3':
			$tipo 		= 'evento';
			$bg_clases	= 'oferta oferta_L evento';
			break;
	}
	$idcustomer   = $_POST["idcustomer"];	
	$idcontent    = $_POST["idcontent"];
	$idcampaign   = $_POST["idcampaign"];
	
	include("../accesomysql.php");
	$directoriocliente = $directoriobase."/".$idcustomer."/";
	$dirbase = "ids.ladorianids.es";
	$plantillascontenido = "/plantillascontenidov4/".$idcustomer."/";
	
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
<!--
	<input type="hidden" name="atributos" id="atributos" value="<?php echo $json_string?>">
	<input type="hidden" name="idcontenttemplate" id="idcontenttemplate" value="<?php echo $idcontenttemplate?>">
	<input type="hidden" name="idcontent" id="idcontent" value="<?php echo $idcontent?>">
	<input type="hidden" name="oldimage" id="oldimage" value="<?=$old_image?>">
	<input type="hidden" name="destinationPath" id="destinationPath" value="<?=$destination_path?>">
	<input type="hidden" name="idcampaign" id="idcampaign" value="<?=$idcampaign?>">
-->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Plantillas costa andarax</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="fonts/font-awesome.min.css">
	<link rel="stylesheet" href="css/front-end.css">
	<!---////////// JCAM --->	
	<script language="JavaScript">
			function grabarplantilla()
			{
                var template_dir = '/plantillascontenidov4/136';
				var atributos = null;
				var plantilla = null;
				var contenido = null;

				var contenedor =
								 "<html lang='es'>"+
								 "<head>"+
								 	"<meta http-equiv='Content-type' content='text/html; charset=utf-8'>"+
								 	"<title>Plantillas costa andarax</title>"+
								 	"<link rel='preconnect' href='https://fonts.gstatic.com'>"+
									"<link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap'>"+
									"<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css'>"+
									"<link rel='stylesheet' href='<?php echo $template_dir ?>/fonts/font-awesome.min.css'>"+
									"<link rel='stylesheet' href='<?php echo $template_dir ?>/css/front-end.css'>"+	
								 "</head>"+
								 "<body class='<?php echo $bg_clases; ?>'>"+
								 	"<div class='wrapper' id='TEMPLATE_CONTENT' >"+ 
								 		document.getElementById("TEMPLATE_CONTENT").innerHTML +
								 	"</div>"+
                                 "</body>"+
                                 "</html>";
 
                $.post("../grabaplantilla.php", {html: contenedor, atributos: atributos, plantilla: plantilla, contenido:contenido}, function(response) {
                	if(response) {
                		var result = JSON.parse(response);
                		if(result.success) {
                    		console.log(result.data);
					    	parent.postMessage({domain:'ladorian.ids.template', 'key': 'template-url', 'value': result.data}, '*');
						}
                	}
					window.close();
                });
			}
	</script>
    <!---////////// ENDJCAM --->
</head>

<body class="<?php echo $bg_clases; ?>">
	<div class="wrapper" id="TEMPLATE_CONTENT">
		<div class="contenedor" name = "divcuerpoHTML" id="divcuerpoHTML">
			<header>
				<?php if( $data['facebook'] || $data['twitter'] || $data['instagram'] || $data['pinterest'] || $data['youtube'] || $data['linkedin'] ) : ?>
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
				<?php endif; ?>
			</header>

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

</body>
</html>