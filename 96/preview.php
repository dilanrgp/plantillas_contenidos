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
		'desc'		=> $_POST["DESCRIPCION"],
		'subdesc'	=> $_POST["SUBDESCRIPCION"],
		'price'		=> $_POST["PRICE"],
		'subprice'	=> $_POST["SUBPRICE"],
		'con_ud'	=> $_POST["CON_UD"],
		'claim' 	=> $_POST["CLAIM"],
		'con_claim' => $_POST["CON_CLAIM"],
		'legal' 	=> $_POST["LEGAL"],
		'orientation'	=> $_POST["ORIENTATION"]
	];

	$p = $data['price'];
	$pl = strlen($p);
	$c_pos = max(strpos($p, '.'), strpos($p, ','));

	if( $c_pos ) {
		$data['price_e'] = substr($p, 0, $c_pos);
		$data['price_c'] = ($c_pos + 1 !== $pl) ? substr($p, $c_pos - $pl + 1) : '';

		if( strlen($data['price_c']) == 1 ) $data['price_c'] .= '0';
	} else {
		$data['price_e'] = $p;
	}

/*  	
	foreach ($_POST as $key => $value) {
		echo htmlspecialchars($key).": ".htmlspecialchars($value)."<br>";
	}
*/

	switch ( $template_number ) {
		case '1':
			$tipo 		= 'offer';
			$bg_clases	= 'offer offer_1';
			break;
		case '2':
			$tipo 		= 'offer';
			$bg_clases	= 'offer offer_2';
			break;
		case '3':
			$tipo 		= 'message';
			$bg_clases	= 'message';
			break;
	}

	if( $template_number === '1' && !isset($data['con_claim']) ) {
		$bg_clases .= ' no_claim';
	}

	$bg_clases .= isset($data['orientation']) ? ' vertical' : ' horizontal';


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
		'price'		=> $_POST["PRICE"],
		'subprice'	=> $_POST["SUBPRICE"],
		'con_ud'	=> $_POST["CON_UD"],
		'claim' 	=> $_POST["CLAIM"],
		'con_claim' => $_POST["CON_CLAIM"],
		'legal' 	=> $_POST["LEGAL"],
		'orientation'	=> $_POST["ORIENTATION"]
	);

	$p = $data['price'];
	$pl = strlen($p);
	$c_pos = max(strpos($p, '.'), strpos($p, ','));

	if( $c_pos ) {
		$data['price_e'] = substr($p, 0, $c_pos);
		$data['price_c'] = ($c_pos + 1 !== $pl) ? substr($p, $c_pos - $pl + 1) : '';

		if( strlen($data['price_c']) == 1 ) $data['price_c'] .= '0';
	} else {
		$data['price_e'] = $p;
	}

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
			move_uploaded_file($_FILES['IMG']['tmp_name'], $target_path);
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
		'desc'		=> $_POST["DESCRIPCION"],
		'subdesc'	=> $_POST["SUBDESCRIPCION"],
		'price'		=> $_POST["PRICE"],
		'subprice'	=> $_POST["SUBPRICE"],
		'con_ud'	=> $_POST["CON_UD"],
		'claim' 	=> $_POST["CLAIM"],
		'con_claim' => $_POST["CON_CLAIM"],
		'legal' 	=> $_POST["LEGAL"],
		'orientation'	=> $_POST["ORIENTATION"],
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

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Plantillas GLEM</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/glem.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;500;700&display=swap" rel="stylesheet">
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

				var contenedor =
								 "<html lang='es'><head><meta http-equiv='Content-type' content='text/html; charset=utf-8'>"+
								"<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css'>"+
								"<link rel='stylesheet' href='<?php echo $directoriobase?>/fonts/font-awesome.min.css'>"+
								"<link rel='stylesheet' href='<?php echo $directoriocliente?>"+"css/glem.css'>"+							 
								 "</head><body class='<?php echo $bg_clases; ?>' >"+
								 "<div class='wrapper' id='TEMPLATE_CONTENT' >"+								 
								 document.getElementById("divcuerpoHTML").outerHTML+
								 "</div></body></html>";

	//			$('.loading').css('display','block');

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
						parent.postMessage({domain:'ladorian.ids.template', 'key': 'template-url', 'value': result.data}, '*');
					}
				}).fail(function(){
				}).always(function(){
					window.close();
				});				
				

			}
	</script>
</head>

<body class="<?php echo $bg_clases; ?>">
	<div class="wrapper" id="TEMPLATE_CONTENT">
		<div class="contenedor" name = "divcuerpoHTML" id="divcuerpoHTML">
			<div class="left-stripe">
				<div class="top-stripe"></div>
				<?php if( $template_number === '1' && isset($data['con_claim']) ) : ?>
					<div class="bottom-stripe"></div>
				<?php endif; ?>
			</div>
			<?php if( $tipo == 'message' ) : ?>
				<div class="raya-container">
					<div class="raya"></div>
				</div>
			<?php endif; ?>
			<img src="glem/logo.png" class="logo">
			<?php if( $tipo == 'offer' ) : ?>
				<div class="data-ofertas">
					<div class="info">
						<p class="oferta">Oferta</p>
						<div id="DESCRIPCION"><?php echo nl2p($data['desc']); ?></div>
						<div id="SUBDESCRIPCION"><?php echo nl2p($data['subdesc']); ?></div>
					</div>

					<div class="price">
						<div class="price__move">
							<div class="price__label">
								<p id="PRICE">
									<span class="euros"><?php echo $data['price_e']; ?></span>
									<?php if( isset($data['price_c']) && $data['price_c'] ) : ?>
										<span class="cents"><span class="coma">,</span><?php echo $data['price_c']; ?><span class="currency">€</span></span>
									<?php //else : ?>
										<!---<span class="currency">€</span>--->
									<?php endif; ?>
									<?php if (isset($data['con_ud'])) echo '<span class="ud">/ud.</span>'; ?>
								</p>
							</div>
						</div>
						<p id="SUBPRICE"><?php echo $data['subprice']; ?></p>
					</div>
				</div>
				<p id="LEGAL"><?php echo $data['legal']; ?></p>
				<div class="img-container">
					<div class="img-move">						
						<div class="img" style="background-image:url(<?php echo $imagen ?>);"></div>
					</div>
				</div>
			<?php endif; ?>
			<?php if( $template_number === '3' || ($template_number === '1' && isset($data['con_claim'])) ) : ?>
				<div class="claim-container" id="CLAIM">
					<?php echo nl2p($data['claim']); ?>
				</div>
			<?php endif; ?>



		</div>
	</div>

	<div class="wrapper" id="BUTTONS">
		<div class="btns">
			<input type="button" class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();">
			<input type="button" class="btn btn-primary" name="volver" value="Volver" onclick="window.close(); window.history.back();">
		</div>
	</div>
	<!-- <script>
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
		
	</script>		 -->
</body>

</html>
























