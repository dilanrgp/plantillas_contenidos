<?php
	function nl2p($string) {
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
        require_once __DIR__ . '/../accesomysql.php';

	$template			= $_POST["TEMPLATE"];
	$template_number	= substr($template, -1);
	$idcustomer = 228;
	$dev = ($_SERVER['HTTP_HOST'] === 'localhost');

	$data = [
		'desc'		=> $_POST["DESCRIPCION"],
		'subdesc'	=> $_POST["SUBDESCRIPCION"],
		'desc2'		=> $_POST["DESCRIPCION_2"],
		'subdesc2'	=> $_POST["SUBDESCRIPCION_2"],
		'price'		=> $_POST["PRICE"],
		'subprice'	=> $_POST["SUBPRICE"],
		'claim' 	=> $_POST["CLAIM"],
		'legal' 	=> $_POST["LEGAL"],
		'img' 		=> $_POST['imagenamostrar'],
		'diesel' 	=> $_POST["PRICE_DIESEL"],
		'gasolina' 	=> $_POST["PRICE_GASOLINA"],
		'img' 		=> $_POST['imagenamostrar']		
	];
	
	$p = $data['price'];
	$pl = strlen($p);
	$c_pos = max(strpos($p, '.'), strpos($p, ','));

	if( $c_pos ) {
		$data['price_e'] = substr($p, 0, $c_pos);
		$data['price_c'] = ($c_pos + 1 !== $pl) ? substr($p, $c_pos - $pl + 1) : '';
	}

    $template_dir = BASE_PATH . '/228';
    $path_upload = $template_dir ."/uploads";
    $destination_path = getcwd().DIRECTORY_SEPARATOR . "uploads/";
    if($_FILES['IMG']['name']!=""){
        $nombre_image = time() . ".".pathinfo($_FILES['IMG']['name'], PATHINFO_EXTENSION);
        $target_path = $destination_path . $nombre_image;
        move_uploaded_file($_FILES['IMG']['tmp_name'], $target_path);
        $data['img'] = "https://".$_SERVER["HTTP_HOST"]. $path_upload. "/" .$nombre_image;
    }

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
			$tipo 		= 'offer';
			$bg_clases	= 'offer offer_3';
			break;
		case '4':
			$tipo 		= 'message';
			$bg_clases	= 'message';
			break;
		case '5':
			$tipo 		= 'gasolina';
			$bg_clases	= 'gasolina';
			break;			
	}

	$bg_clases .= ' horizontal';

	$path = 'config_'. time() . '.json';
	$jsonString = json_encode($data, JSON_PRETTY_PRINT);
	$fp = fopen($path, 'w');
	fwrite($fp, $jsonString);
	fclose($fp);
	$template_url = "/" . $idcustomer . "/" . "formulario.php?format=" . $template . "&config=" . $path;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Plantillas BADÍA</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;800&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="css/preview.css?v=001">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script language="JavaScript">
			function grabarplantilla()
			{
                var orientacion = '<?php echo $orientation; ?>';
				var atributos = null;
				var plantilla = null;
				var contenido = null;
				var contenedor =
								 "<html lang='en'>"+
								 "<head>"+
								 	"<meta http-equiv='Content-type' content='text/html; charset=utf-8'>"+
								 	"<title>Plantillas BADÍA</title>"+
                                    '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">'+
                                    '<link rel="preconnect" href="https://fonts.googleapis.com">'+
                                    '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'+
                                    '<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;800&display=swap" rel="stylesheet">'+
                                    "<link rel='stylesheet' href='<?php echo $template_dir ?>/css/preview.css'>"+	
								 "</head>"+
								 "<body class='<?php echo $bg_clases; ?>'>"+
								 	"<div class='<?= $template_number != 5 ? 'wrapper' : '' ?>' id='TEMPLATE_CONTENT' >"+
									document.getElementById("TEMPLATE_CONTENT").innerHTML + 
									"</div>"+ 
                                 "</body>"+
                                 "</html>";
				alert(contenedor); 
				
                $.post("../grabaplantilla.php", {html: contenedor, atributos: atributos, plantilla: plantilla, contenido:contenido}, function(response) {
                	if(response) {
                		var result = JSON.parse(response);
                		if(result.success) {
                    		console.log(result.data);
                            parent.postMessage({domain:'ladorian.ids.template', 'key': 'template-url', 'value': result.data}, '*');
							parent.postMessage({domain:'ladorian.ids.template', 'key': 'template_url', 'value': "<?php echo $template_url; ?>"}, '*');
						}
                	}
					window.close();
                });
			}
	</script>
</head>

<body class="<?php echo $bg_clases; ?>">
	<!--- JCAM  3/7/2022 Si se pone la clase no se muestra nada en la ventana
	<div class="wrapper" id="TEMPLATE_CONTENT"> --->

	<?php if( $template_number == '5' ) : ?>
	    <div id="TEMPLATE_CONTENT"> 
			<div id="GASOLINA_CONTENT">
				<p class="price" id="PRICE_DIESEL"><?php echo $data['diesel']; ?></p>
				<p class="price" id="PRICE_GASOLINA"><?php echo $data['gasolina']; ?></p>
			</div>
	<?php else : ?>	
	    <div class="wrapper" id="TEMPLATE_CONTENT"> 
			<div class="contenedor">
				<?php if( $template_number == '1' ) : ?>
					<img src="<?php echo $template_dir ?>/img/logo-color.png" class="logo">
				<?php elseif( $template_number !== '3' ) : ?>
					<img src="<?php echo $template_dir ?>/img/logo-blanco.png" class="logo">
				<?php endif ?>
				<?php if( $tipo == 'offer' ) : ?>
					<div class="data-ofertas">
						<div class="price">
							<p id="SUBPRICE"><?php echo $data['subprice']; ?></p>
							<div class="price__move">
								<div class="price__label">
									<p id="PRICE">
										<?php if( isset($data['price_c']) && $data['price_c'] ) : ?>
											<span class="euros"><?php echo $data['price_e']; ?></span>
											<span class="cents"><span class="coma">,</span><?php echo $data['price_c']; ?></span>
										<?php else : ?>
											<span class="euros"><?php echo $data['price']; ?></span>
										<?php endif; ?>
									</p>
								</div>
							</div>
						</div>
						<div class="info">
							<div id="DESCRIPCION"><?php echo nl2p($data['desc']); ?></div>
							<div id="SUBDESCRIPCION"><?php echo nl2p($data['subdesc']); ?></div>
							<?php if( $template_number !== '3' ) : ?>
								<div class="claim-container" id="CLAIM">
									<?php echo nl2p($data['claim']); ?>
								</div>
							<?php endif ?>
						</div>
						<?php if( $template_number == '3' ) : ?>
							<div class="info info-2">
								<div id="DESCRIPCION_2"><?php echo nl2p($data['desc2']); ?></div>
								<div id="SUBDESCRIPCION_2"><?php echo nl2p($data['subdesc2']); ?></div>
							</div>
						<?php endif ?>
					</div>
					<p id="LEGAL"><?php echo $data['legal']; ?></p>
					<div class="img-container">
						<div class="img-move">
							<?php if ($dev) : ?>
								<div class="img" style="background-image:url(<?php echo 'img_test/' . $data['img'] ?>);"></div>
							<?php else :?>
								<div class="img" style="background-image:url(<?php echo $data['img'] ?>);"></div>
							<?php endif; ?>
						</div>					
					</div>
				<?php else : ?>
					<div class="info">
						<div class="claim-container" id="CLAIM">
							<?php echo nl2p($data['claim']); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	
	<?php endif ?>

	
	<div class="wrapper" id="BUTTONS">
		<div class="btns">
			<input type="button" class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();">
			<input type="button" class="btn btn-primary" name="volver" value="Volver" onclick="window.close(); window.history.back();">
		</div>
	</div>

</body>

</html>
























