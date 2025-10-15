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
        require_once __DIR__ . '/../accesomysql.php';

	$template			= $_POST["TEMPLATE"];
	$template_number	= substr($template, -1);
	$idcustomer = 229;
	$dev = ($_SERVER['HTTP_HOST'] === 'localhost');

    $template_dir = BASE_PATH . '/229';
    $path_upload = $template_dir ."/uploads";
    $destination_path = getcwd().DIRECTORY_SEPARATOR . "uploads/";
    if(isset($_FILES['IMG']) && $_FILES['IMG']['name']!=""){
        $nombre_image = time() . ".".pathinfo($_FILES['IMG']['name'], PATHINFO_EXTENSION);
        $target_path = $destination_path . $nombre_image;
        move_uploaded_file($_FILES['IMG']['tmp_name'], $target_path);
        $data['img'] = "https://".$_SERVER["HTTP_HOST"]. $path_upload. "/" .$nombre_image;
    }
	$data = [
		'description'		=> $_POST["DESCRIPCION"],
		'subdescription'	=> $_POST["SUBDESCRIPCION"],
		'description2'		=> $_POST["DESCRIPCION_2"],
		'subdescription2'	=> $_POST["SUBDESCRIPCION_2"],
		'price'				=> $_POST["PRICE"],
		'legal' 			=> $_POST["LEGAL"],
		'img'	 			=> $data['img'] ? $data['img'] : $_POST['imagenamostrar'],
		'multiproduct'		=> $_POST["MULTIPRODUCT"],
		'orientation'		=> $_POST["ORIENTATION"]
	];

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

	$bg_clases .= isset($data['orientation']) ? ' vertical' : ' horizontal';

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
	<title>Plantillas Q8</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/preview.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script language="JavaScript">
		function grabarplantilla()
		{
			var orientacion = '<?= $data['orientation'] ?>';
			var atributos = null;
			var plantilla = null;
			var contenido = null;
			var contenedor =
							 "<html lang='en'>"+
							 "<head>"+
								 "<meta http-equiv='Content-type' content='text/html; charset=utf-8'>"+
								 "<title>Plantillas Q8</title>"+
								'<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">'+
								"<link rel='stylesheet' href='<?php echo $template_dir ?>/css/preview.css'>"+
							 "</head>"+
							 "<body class='<?= $bg_clases ?>'>"+
								 "<div class='<?= $template_number != 5 ? 'wrapper' : '' ?>' id='TEMPLATE_CONTENT' >"+
								document.getElementById("TEMPLATE_CONTENT").innerHTML +
								"</div>"+
							 "</body>"+
							 "</html>";
			$.post("../grabaplantilla.php", {html: contenedor, atributos: atributos, plantilla: plantilla, contenido:contenido}, function(response) {
				if(response) {
					var result = JSON.parse(response);
					if(result.success) {
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
	<div class="wrapper" id="TEMPLATE_CONTENT">
		<div class="contenedor">
			<?php if( $tipo == 'offer' ) : ?>
				<div class="img-container">
					<div class="img-move">
						<div class="img" style="background-image:url(<?php echo $data['img'] ?>);"></div>
					</div>
				</div>
			<?php endif; ?>
			<div class="data-ofertas <?php echo (isset($data['multiproduct'])) ? 'product__2' : ''; ?>">
				<div class="info">
					<div class="info_content">
						<div class="description" id="DESCRIPCION"><?php echo nl2p($data['description']); ?></div>
						<div class="subdescription" id="SUBDESCRIPCION"><?php echo nl2p($data['subdescription']); ?></div>
					</div>
					<?php if(isset($data['multiproduct']) && $tipo == 'offer') : ?>
						<div class="info_content">
							<div class="description" id="DESCRIPCION_2"><?php echo nl2p($data['description2']); ?></div>
							<div class="subdescription" id="SUBDESCRIPCION_2"><?php echo nl2p($data['subdescription2']); ?></div>
						</div>
					<?php endif; ?>
				</div>
				<?php if( $tipo == 'offer' ) : ?>
					<div class="price">
						<div class="price__move">
							<div class="price__label">
								<p id="PRICE"><?php echo $data['price']; ?></p>
							</div>
						</div>
					</div>
					<div class="price-mirror"></div>
					<div id="LEGAL"><?php echo nl2p($data['legal']); ?></div>
				<?php endif; ?>
			</div>
			<?php if( $template_number == '1' ) : ?>
				<img src="img/logo-blanco.png" class="logo">
			<?php else : ?>
				<img src="img/logo-azul.png" class="logo">
			<?php endif; ?>
		</div>
	</div>
	<div class="wrapper" id="BUTTONS">
		<div class="btns">
			<input type="button" class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();">
			<input type="button" class="btn btn-primary" name="volver" value="Volver" onclick="window.close();">
		</div>
	</div>
</body>
</html>
























