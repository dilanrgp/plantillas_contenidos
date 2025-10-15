<?php
	function splitPrice ($p) {
		$coma = strpos($p, '.');
		$e = $coma > 0 ? substr($p, 0, $coma) : $p;
		$c = $coma > 0 ? substr($p, -2) : '';

		return [$e, $c, $p, $coma];
	}




	$template			= $_POST["TEMPLATE"];
	$template_number	= substr($template, -1);




$idcontent    = $_POST["idcontent"];
$idcustomer   = $_POST["idcustomer"];
$idcampaign   = $_POST["idcampaign"];

include("../accesomysql.php");
$directoriocliente = $directoriobase."/".$idcustomer."/";
$dirbase = "dev.ladorianids.com";
$dirbase = "idsv4.ladorianids.es";
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


//echo $_FILE["MENU_1_IMG"];die;
$PROMO_DER_VIDEO="";
$MENU_1_IMG="";
$MENU_2_IMG="";
$MENU_3_IMG="";
$MENU_4_IMG="";
$OFFER_IMG="";


if(!empty($_FILES["PROMO_DER_VIDEO"]['name'])){
	$PROMO_DER_VIDEO = subeImage($_FILES,'PROMO_DER_VIDEO');
}
elseif(!empty($_POST['PROMO_DER_VIDEO_TEXT'])){
	$PROMO_DER_VIDEO = $_POST['PROMO_DER_VIDEO_TEXT'];
}
if(!empty($_FILES["MENU_1_IMG"]['name'])){
	$MENU_1_IMG = subeImage($_FILES,'MENU_1_IMG');
}
elseif(!empty($_POST['MENU_1_IMG_TEXT'])){
	$MENU_1_IMG = $_POST['MENU_1_IMG_TEXT'];
}
if(!empty($_FILES["MENU_2_IMG"]['name'])){
	$MENU_2_IMG = subeImage($_FILES,'MENU_2_IMG');
}
elseif(!empty($_POST['MENU_2_IMG_TEXT'])){
	$MENU_2_IMG = $_POST['MENU_2_IMG_TEXT'];
}
if(!empty($_FILES["MENU_3_IMG"]['name'])){
	$MENU_3_IMG = subeImage($_FILES,'MENU_3_IMG');
}
elseif(!empty($_POST['MENU_3_IMG_TEXT'])){
	$MENU_3_IMG = $_POST['MENU_3_IMG_TEXT'];
}
if(!empty($_FILES["MENU_4_IMG"]['name'])){
	$MENU_4_IMG = subeImage($_FILES,'MENU_4_IMG');
}
elseif(!empty($_POST['MENU_4_IMG_TEXT'])){
	$MENU_4_IMG = $_POST['MENU_4_IMG_TEXT'];
}
if(!empty($_FILES["OFFER_IMG"]['name'])){
	$OFFER_IMG = subeImage($_FILES,'OFFER_IMG');
}
elseif(!empty($_POST['OFFER_IMG_TEXT'])){
	$OFFER_IMG = $_POST['OFFER_IMG_TEXT'];
}


/***IMAGEN ANTERIORES 



$imagenelegida="";
$imagenleida="";

$old_image="";



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
		$imagen = "https://".$_SERVER["HTTP_HOST"].'/plantillascontenido/40/templates/'.$nombre_image;
	}	

}
else 
{
	if($_FILES['IMG']['name']!=""){
		$nombre_image = time() . ".".pathinfo($_FILES['IMG']['name'], PATHINFO_EXTENSION);
		$target_path = $destination_path ."templates/".$nombre_image;
		@move_uploaded_file($_FILES['IMG']['tmp_name'], $target_path);
		$imagen = "https://".$_SERVER["HTTP_HOST"].'/plantillascontenido/7/templates/'.$nombre_image;
	}
}	

*/



function subeImage($file,$name){
	$destination_path = getcwd().DIRECTORY_SEPARATOR;
	$imagen="";
	if($file[$name]['name']!=""){
		$nombre_image = time() . ".".pathinfo($file[$name]['name'], PATHINFO_EXTENSION);
		$target_path = $destination_path ."templates/".$nombre_image;
		@move_uploaded_file($file[$name]['tmp_name'], $target_path);
		$imagen = "http://".$_SERVER["HTTP_HOST"].'/plantillascontenido/40/templates/'.$nombre_image;
	}
	return $imagen;
} 


$data_offer = [
	'OFFER_TITLE'		=> $_POST["OFFER_TITLE"],
	'OFFER_SUBTITLE'	=> $_POST["OFFER_SUBTITLE"],
	'OFFER_IMG'			=> $OFFER_IMG ,
	'OFFER_PRICE'		=> splitPrice( $_POST["OFFER_PRICE"]),
	'OFFER_CONDITIONS'	=> $_POST["OFFER_CONDITIONS"],
	'OFFER_DESC'		=> $_POST["OFFER_DESC"]
];

$data_MB_MENU_1 = [
	'MENU_1_NAME'		=> $_POST["MENU_1_NAME"],
	'MENU_1_SUBTITLE'	=> $_POST["MENU_1_SUBTITLE"],
	'MENU_1_DESC_1'		=> $_POST["MENU_1_DESC_1"],
	'MENU_1_DESC_2'		=> $_POST["MENU_1_DESC_2"],
	'MENU_1_DESC_3'		=> $_POST["MENU_1_DESC_3"],
	'MENU_1_PRICE'		=> splitPrice( $_POST["MENU_1_PRICE"]),
	'MENU_1_IMG'		=> $MENU_1_IMG,
];
$data_MB_MENU_2 = [
	'MENU_2_NAME'		=> $_POST["MENU_2_NAME"],
	'MENU_2_SUBTITLE'	=> $_POST["MENU_2_SUBTITLE"],
	'MENU_2_DESC_1'		=> $_POST["MENU_2_DESC_1"],
	'MENU_2_DESC_2'		=> $_POST["MENU_2_DESC_2"],
	'MENU_2_DESC_3'		=> $_POST["MENU_2_DESC_3"],
	'MENU_2_PRICE'		=> splitPrice( $_POST["MENU_2_PRICE"]),
	'MENU_2_IMG'		=> $MENU_2_IMG,
];
$data_MB_MENU_3 = [
	'MENU_3_NAME'		=> $_POST["MENU_3_NAME"],
	'MENU_3_SUBTITLE'	=> $_POST["MENU_3_SUBTITLE"],
	'MENU_3_DESC_1'		=> $_POST["MENU_3_DESC_1"],
	'MENU_3_DESC_2'		=> $_POST["MENU_3_DESC_2"],
	'MENU_3_DESC_3'		=> $_POST["MENU_3_DESC_3"],
	'MENU_3_PRICE'		=> splitPrice( $_POST["MENU_3_PRICE"]),
	'MENU_3_IMG'		=> $MENU_3_IMG,
];
$data_MB_MENU_4 = [
	'MENU_4_NAME'		=> $_POST["MENU_4_NAME"],
	'MENU_4_SUBTITLE'	=> $_POST["MENU_4_SUBTITLE"],
	'MENU_4_DESC_1'		=> $_POST["MENU_4_DESC_1"],
	'MENU_4_DESC_2'		=> $_POST["MENU_4_DESC_2"],
	'MENU_4_DESC_3'		=> $_POST["MENU_4_DESC_3"],
	'MENU_4_PRICE'		=> splitPrice( $_POST["MENU_4_PRICE"]),
	'MENU_4_IMG'		=> $MENU_4_IMG,
];
$data_MB_R = [
	'PROMO_DER_TXT_1'		=> $_POST["PROMO_DER_TXT_1"],
	'PROMO_DER_TXT_2'		=> $_POST["PROMO_DER_TXT_2"],
	'PROMO_DER_TXT_3'		=> $_POST["PROMO_DER_TXT_3"],
	'PROMO_DER_BTN'			=> $_POST["PROMO_DER_BTN"],
	'PROMO_DER_PRICE'		=> splitPrice( $_POST["PROMO_DER_PRICE"] ),
	'PROMO_DER_COND'		=> $_POST["PROMO_DER_COND"],
	'PROMO_DER_VIDEO'		=> $PROMO_DER_VIDEO
];




if($_POST['TEMPLATE'] == "TEMPLATE-1"){
	$atributos[] = array($data_offer);

}
elseif($_POST['TEMPLATE'] == "TEMPLATE-2"){
	$atributos[] = array($data_MB_MENU_1,$data_MB_MENU_2,$data_MB_MENU_3,$data_MB_MENU_4,$data_MB_R);
}

// Grabar en el campo "attributes" de content_template,	en formato JSON,, los valores de los campos variables
$json_string = json_encode($atributos);
// Se sustituye de momento la " por el caracter ^ ya que con la primera se corta la variable... En la grabacion se volvera a sustituir por la "
$json_string = str_replace("\"","^",$json_string);



/**<input type="hidden" name="oldimage" id="oldimage" value="<?=$old_image?>">
 * 
 * <input type="hidden" name="destinationPath" id="destinationPath" value="<?=$destination_path?>">
 */
?>
<input type="hidden" name="atributos" id="atributos" value="<?php echo $json_string?>">
<input type="hidden" name="idcontenttemplate" id="idcontenttemplate" value="<?php echo $idcontenttemplate?>">
<input type="hidden" name="idcontent" id="idcontent" value="<?php echo $idcontent?>">
<input type="hidden" name="idcampaign" id="idcampaign" value="<?=$idcampaign?>">

<!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!--><html lang="es"> <!--<![endif]-->

<head>
	<meta charset="UTF-8" />
	<title>Dominos Pizza</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/dominos_main.css">

</head>

<body>
	<?php if($_POST['TEMPLATE'] == "TEMPLATE-2") {?>
	<div class="wrapper <?php echo $template_number == "2" ? 'active' : 'hidden' ?>" id="MENUBOARD">
		<div class="left">
			<div class="left_sup">
				<div class="slider">
					<div class="slide" id="MENU_DESTACADO_1">
						<h1><?php echo $data_MB_MENU_1['MENU_1_NAME']; ?></h1>
						<h2 class="slide_name"><span><?php echo $data_MB_MENU_1['MENU_1_SUBTITLE']; ?></span></h2>
						<div class="slide_content">
							<div class="slide_desc">
								<h3><?php echo $data_MB_MENU_1['MENU_1_DESC_1']; ?></h3>
								<p><?php echo $data_MB_MENU_1['MENU_1_DESC_2']; ?></p>
								<p><?php echo $data_MB_MENU_1['MENU_1_DESC_3']; ?></p>
							</div>
							<div class="slide_img">
								<!-- <img src="images/pizza-3.png"> -->
								<?php if($data_MB_MENU_1['MENU_1_IMG'] != "" ) {?>
								<img src="<?php echo $data_MB_MENU_1['MENU_1_IMG']; ?>">
								<?php } ?>
							</div>
							<p class="price slide_price"><?php echo $data_MB_MENU_1['MENU_1_PRICE'][0]; ?><?php if ($data_MB_MENU_1["MENU_1_PRICE"][1]) : ?><span class="cents"><?php echo $data_MB_MENU_1["MENU_1_PRICE"][1]; ?></span><?php endif; ?> <span class="euro">€</span></p>
						</div>
					</div>
					<div class="slide" id="MENU_DESTACADO_2">
						<h1><?php echo $data_MB_MENU_2['MENU_2_NAME']; ?></h1>
						<h2 class="slide_name"><span><?php echo $data_MB_MENU_2['MENU_2_SUBTITLE']; ?></span></h2>
						<div class="slide_content">
							<div class="slide_desc">
								<h3><?php echo $data_MB_MENU_2['MENU_2_DESC_1']; ?></h3>
								<p><?php echo $data_MB_MENU_2['MENU_2_DESC_2']; ?></p>
								<p><?php echo $data_MB_MENU_2['MENU_2_DESC_3']; ?></p>
							</div>
							<div class="slide_img">
								<!-- <img src="images/pizza-3.png"> -->
								<?php if($data_MB_MENU_2['MENU_2_IMG'] != "" ) {?>
								<img src="<?php echo $data_MB_MENU_2['MENU_2_IMG']; ?>">
								<?php } ?>
							</div>
							<p class="price slide_price"><?php echo $data_MB_MENU_2['MENU_2_PRICE'][0]; ?><?php if ($data_MB_MENU_2["MENU_2_PRICE"][1]) : ?><span class="cents"><?php echo $data_MB_MENU_2["MENU_2_PRICE"][1]; ?></span><?php endif; ?> <span class="euro">€</span></p>
						</div>
					</div>
					<div class="slide" id="MENU_DESTACADO_3">
						<h1><?php echo $data_MB_MENU_3['MENU_3_NAME']; ?></h1>
						<h2 class="slide_name"><span><?php echo $data_MB_MENU_3['MENU_3_SUBTITLE']; ?></span></h2>
						<div class="slide_content">
							<div class="slide_desc">
								<h3><?php echo $data_MB_MENU_3['MENU_3_DESC_1']; ?></h3>
								<p><?php echo $data_MB_MENU_3['MENU_3_DESC_2']; ?></p>
								<p><?php echo $data_MB_MENU_3['MENU_3_DESC_3']; ?></p>
							</div>
							<div class="slide_img">
								<!-- <img src="images/pizza-3.png"> -->
								<?php if($data_MB_MENU_3['MENU_3_IMG'] != "" ) {?>
								<img src="<?php echo $data_MB_MENU_3['MENU_3_IMG']; ?>">
								<?php } ?>
							</div>
							<p class="price slide_price"><?php echo $data_MB_MENU_3['MENU_3_PRICE'][0]; ?><?php if ($data_MB_MENU_3["MENU_3_PRICE"][1]) : ?><span class="cents"><?php echo $data_MB_MENU_3["MENU_3_PRICE"][1]; ?></span><?php endif; ?> <span class="euro">€</span></p>
						</div>
					</div>
					<div class="slide" id="MENU_DESTACADO_4">
						<h1><?php echo $data_MB_MENU_4['MENU_4_NAME']; ?></h1>
						<h2 class="slide_name"><span><?php echo $data_MB_MENU_4['MENU_4_SUBTITLE']; ?></span></h2>
						<div class="slide_content">
							<div class="slide_desc">
								<h3><?php echo $data_MB_MENU_4['MENU_4_DESC_1']; ?></h3>
								<p><?php echo $data_MB_MENU_4['MENU_4_DESC_2']; ?></p>
								<p><?php echo $data_MB_MENU_4['MENU_4_DESC_3']; ?></p>
							</div>
							<div class="slide_img">
								<!-- <img src="images/pizza-3.png"> -->
								<?php if($data_MB_MENU_4['MENU_4_IMG'] != "" ) {?>
								<img src="<?php echo $data_MB_MENU_4['MENU_4_IMG']; ?>">
								<?php } ?>
							</div>
							<p class="price slide_price"><?php echo $data_MB_MENU_4['MENU_4_PRICE'][0]; ?><?php if ($data_MB_MENU_4["MENU_4_PRICE"][1]) : ?><span class="cents"><?php echo $data_MB_MENU_4["MENU_4_PRICE"][1]; ?></span><?php endif; ?> <span class="euro">€</span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="left_inf">
				<div class="left_inf_row">
					<div class="menu" id="MENU_1">
						<p class="menu_title">
							<span class="triangle triangles_before"></span>
							<span class=title><?php echo $data_MB_MENU_1['MENU_1_NAME']; ?></span>
							<span class="triangle triangles_after"></span>
						</p>
						<p class="menu_pedido"><?php echo $data_MB_MENU_1['MENU_1_DESC_1']; ?></p>
						<p class="menu_pedido_detalle"><?php echo $data_MB_MENU_1['MENU_1_DESC_2']; ?></p>
						<p class="menu_pedido_detalle"><?php echo $data_MB_MENU_1['MENU_1_DESC_3']; ?></p>
						<p class="price menu_price"><?php echo $data_MB_MENU_1['MENU_1_PRICE'][0]; ?><?php if ($data_MB_MENU_1["MENU_1_PRICE"][1]) : ?><span class="cents"><?php echo $data_MB_MENU_1["MENU_1_PRICE"][1]; ?></span><?php endif; ?> <span class="euro">€</span></p>
					</div>
					<div class="menu" id="MENU_2">
						<p class="menu_title">
							<span class="triangle triangles_before"></span>
							<span class=title><?php echo $data_MB_MENU_2['MENU_2_NAME']; ?></span>
							<span class="triangle triangles_after"></span>
						</p>
						<p class="menu_pedido"><?php echo $data_MB_MENU_2['MENU_2_DESC_1']; ?></p>
						<p class="menu_pedido_detalle"><?php echo $data_MB_MENU_2['MENU_2_DESC_2']; ?></p>
						<p class="menu_pedido_detalle"><?php echo $data_MB_MENU_2['MENU_2_DESC_3']; ?></p>
						<p class="price menu_price"><?php echo $data_MB_MENU_2['MENU_2_PRICE'][0]; ?><?php if ($data_MB_MENU_2["MENU_2_PRICE"][1]) : ?><span class="cents"><?php echo $data_MB_MENU_2["MENU_2_PRICE"][1]; ?></span><?php endif; ?> <span class="euro">€</span></p>
					</div>
				</div>

				<div class="left_inf_row">
					<div class="menu" id="MENU_3">
						<p class="menu_title">
							<span class="triangle triangles_before"></span>
							<span class=title><?php echo $data_MB_MENU_3['MENU_3_NAME']; ?></span>
							<span class="triangle triangles_after"></span>
						</p>
						<p class="menu_pedido"><?php echo $data_MB_MENU_3['MENU_3_DESC_1']; ?></p>
						<p class="menu_pedido_detalle"><?php echo $data_MB_MENU_3['MENU_3_DESC_2']; ?></p>
						<p class="menu_pedido_detalle"><?php echo $data_MB_MENU_3['MENU_3_DESC_3']; ?></p>
						<p class="price menu_price"><?php echo $data_MB_MENU_3['MENU_3_PRICE'][0]; ?><?php if ($data_MB_MENU_3["MENU_3_PRICE"][1]) : ?><span class="cents"><?php echo $data_MB_MENU_3["MENU_3_PRICE"][1]; ?></span><?php endif; ?> <span class="euro">€</span></p>					
					</div>

					<div class="menu" id="MENU_4">
						<p class="menu_title">
							<span class="triangle triangles_before"></span>
							<span class=title><?php echo $data_MB_MENU_4['MENU_4_NAME']; ?></span>
							<span class="triangle triangles_after"></span>
						</p>
						<p class="menu_pedido"><?php echo $data_MB_MENU_4['MENU_4_DESC_1']; ?></p>
						<p class="menu_pedido_detalle"><?php echo $data_MB_MENU_4['MENU_4_DESC_2']; ?></p>
						<p class="menu_pedido_detalle"><?php echo $data_MB_MENU_4['MENU_4_DESC_3']; ?></p>
						
						<p class="price menu_price"><?php echo $data_MB_MENU_4['MENU_4_PRICE'][0]; ?><?php if ($data_MB_MENU_4["MENU_4_PRICE"][1]) : ?><span class="cents"><?php echo $data_MB_MENU_4["MENU_4_PRICE"][1]; ?></span><?php endif; ?> <span class="euro">€</span></p>
					</div>
				</div>
			</div>
		</div>

		<div class="right">
			<div class="table">
				<div class="row">
					<div class="cell">
						<div class="right_offer">
							<p class="txt_1"><?php echo $data_MB_R["PROMO_DER_TXT_1"]; ?></p>
							<p class="txt_2"><?php echo $data_MB_R["PROMO_DER_TXT_2"]; ?></p>
							<p class="txt_3"><?php echo $data_MB_R["PROMO_DER_TXT_3"]; ?></p>
							<p class="btn"><?php echo $data_MB_R["PROMO_DER_BTN"]; ?></p>
							<div class="offer">
								<p class="offer_price"><span class="euros"><?php echo $data_MB_R["PROMO_DER_PRICE"][0]; ?></span><?php if ($data_MB_R["PROMO_DER_PRICE"][1]) : ?><span class="cents"><?php echo $data_MB_R["PROMO_DER_PRICE"][1]; ?></span><?php endif; ?><span class="euro">€</span></p>
								<p class="offer_details"><?php echo nl2br($data_MB_R["PROMO_DER_COND"]); ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="cell cell_img">
						<video class="video" autoplay muted loop>
							<?php if ($data_MB_R["PROMO_DER_VIDEO"] != ""){ ?>
							 <source src="<?php echo $data_MB_R["PROMO_DER_VIDEO"]; ?>">
							<?php } else { ?>
							 <source src="<?php echo $directoriocliente?>/images/cheese_explosion.mp4">
							<?php } ?>
						</video>
					</div>
				</div>
			</div>
		</div>
							
	</div><!--Fin de container -->

	<?php } elseif($_POST['TEMPLATE'] == "TEMPLATE-1") {?>

	<div class="wrapper <?php echo $template_number == "1" ? 'active' : 'hidden' ?>" id="OFERTA" style="background-image:url(<?php echo $data_offer['OFFER_IMG']; ?>)">
		<p class="oferta_title txt_1"><?php echo $data_offer['OFFER_TITLE']; ?></p>
		<p class="oferta_subtitle menu_pedido_detalle"><?php echo $data_offer['OFFER_SUBTITLE']; ?></p>
		<p class="oferta_price">
			<?php echo $data_offer['OFFER_PRICE'][0] ?><?php if( $data_offer['OFFER_PRICE'][1] ) : ?><span class="cents">,<?php echo $data_offer['OFFER_PRICE'][1] ?></span><?php endif; ?><span class="euro">€</span>
		</p>
		<?php if( $data_offer['OFFER_CONDITIONS'] ) : ?>
			<p class="oferta_price_conditions"><?php echo $data_offer['OFFER_CONDITIONS'] ?></p>
		<?php endif; ?>
		<?php if( $data_offer['OFFER_DESC'] ) : ?>
			<p class="oferta_details"><?php echo nl2br($data_offer['OFFER_DESC']); ?></p>
		<?php endif; ?>
		<img src="<?php echo $directoriocliente?>/images/logo-dominos.png" class="oferta_logo">
		 <div class="oferta_product">
			<img src="">
		</div>
	</div>

	<?php } ?>

	<br><br>
	
	<div class="wrapper" id="BUTTONS">
		<div class="btns">
			
			<input type="button" id="saveplantilla" data-imagen="" data-imagen=""  class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();"> 
			<input type="button" class="btn btn-primary" name="volver" value="Volver" onclick="window.close();	window.history.back();">			
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
	<script src="<?php echo $directoriocliente?>js/jquery.bxslider.js"></script>
	<script src="<?php echo $directoriocliente?>js/msg.js"></script>
	<script src="<?php echo $directoriocliente?>js/loadslider.js"></script>
	<script>
	

		function grabarplantilla()
		{
	
		
			$('#saveplantilla').addClass('disabled');
			$('#saveplantilla').prop('onclick',null).off('click');

			var atributos = document.getElementById("atributos").value;
			var plantilla = document.getElementById("idcontenttemplate").value;
			var contenido = document.getElementById("idcontent").value;
			var idcampaign = document.getElementById("idcampaign").value;

			var contenedor =
								"<html lang='es'><head><meta http-equiv='Content-type' content='text/html; charset=utf-8'>"+
								
							"<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css'>"+
							"<link rel='stylesheet' href='<?php echo $directoriobase?>/fonts/font-awesome.min.css'>"+													
							"<link rel='stylesheet' href='<?php echo $directoriocliente?>"+"css/dominos_main.css'>"+
						 
							
								"</head><body >"+
								"<div class='wrapper' id='TEMPLATE_CONTENT' >"+								 
								document.getElementsByClassName("active")[0].outerHTML+
								"</div>"+
								"<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'><\/script>"+
								"<script src='https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js'><\/script>" +
								"<script src='<?php echo $directoriocliente?>js/jquery.bxslider.js'><\/script>"+
								"<script src='<?php echo $directoriocliente?>js/msg.js'><\/script>"+
								"<script src='<?php echo $directoriocliente?>js/loadslider.js'><\/script>"+
								"</body></html>";

								//$('.active').html()

			$.ajax({
				url: "../grabaplantilla.php",
				method: "POST",
				data: { 
				html : contenedor,
				atributos: atributos,
				plantilla: plantilla,
				contenido: contenido,
				idcampaign: idcampaign,
					},
				dataType: "json"
			})
			.done(function(result) {
				if(result.success) {
					parent.postMessage({domain:'ladorian.ids.template', 'key': 'template-url', 'value': result.data}, '*');
				}
			}).fail(function(){
			}).always(function(){
				window.close();
			});				
			
		}


	</script>
</body>
</html>
