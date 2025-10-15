<?php
	function nl2p($string)
	{
		$paragraphs = '';

		foreach (explode("\n", $string) as $line) {
			if ($line && trim($line) !== '') {
				$paragraphs .= '<p>' . $line . '</p>';
			} else {
				$paragraphs .= '<br>';
			}
		}

		return $paragraphs;
	}
?>

<?php
        require_once __DIR__ . '/../accesomysql.php';

	$template			= $_POST["TEMPLATE"];
	$template_number	= substr($template, -1);

	$dev = ($_SERVER['HTTP_HOST'] === 'localhost');

	$data = [
		'title' 	=> $_POST["TITLE"],
		'desc'		=> $_POST["DESCRIPCION"],
		'subdesc'	=> $_POST["SUBDESCRIPCION"],
		'legal' 	=> $_POST["LEGAL"],
		'img'	 	=> $_POST["IMG"],
		'color'		=> $_POST["COLOR"],
		'orientation_centro'	=> $_POST["ORIENTATION_CENTRO"],
		'orientation'	=> $_POST["ORIENTATION"]
	];


/*
	foreach ($_POST as $key => $value) {
		echo htmlspecialchars($key).": ".htmlspecialchars($value)."<br>";
	}
*/

	switch ( $template_number ) {
		case '1':
			$tipo 		= 'offer';
			$bg_clases	= 'offer';
			break;
		case '2':
			$tipo 		= 'message';
			$bg_clases	= 'message';
			break;
		case '3':
			$tipo 		= 'message';
			$bg_clases	= 'message horarios';
			break;
	}

    $orientacion = '';
	if( $data['orientation_centro'] != 'ambos' ) {
        $orientacion = $data['orientation_centro'];
	} else {
        $orientacion = isset($data['orientation']) ? 'vertical' : 'horizontal';
	}
    $bg_clases .= ' ' . $orientacion;

    $template_dir = BASE_PATH . '/166';
    $path_upload = $template_dir ."/uploads";
    $destination_path = getcwd().DIRECTORY_SEPARATOR . "uploads/";
    if($_FILES['IMG']['name']!=""){
        $nombre_image = time() . ".".pathinfo($_FILES['IMG']['name'], PATHINFO_EXTENSION);
        $target_path = $destination_path . $nombre_image;
        move_uploaded_file($_FILES['IMG']['tmp_name'], $target_path);
        $data['img'] = "https://".$_SERVER["HTTP_HOST"]. $path_upload. "/" .$nombre_image;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Plantillas Opticalia</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/template.css">
    <script language="JavaScript">
			function grabarplantilla()
			{
                var orientacion = '<?php echo $orientacion; ?>';
				var atributos = null;
				var plantilla = null;
				var contenido = null;

				var contenedor =
								 "<html lang='es'>"+
								 "<head>"+
								 	"<meta http-equiv='Content-type' content='text/html; charset=utf-8'>"+
								 	"<title>Plantillas Opticalia</title>"+
                                    "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css'>"+
                                    "<link rel='stylesheet' href='<?php echo $template_dir ?>/css/template.css'>"+	
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
					    	//parent.postMessage(result.data, '*');
                            parent.postMessage({domain:'ladorian.ids.template', 'key': 'template-url', 'value': result.data}, '*');
                            parent.postMessage({domain:'ladorian.ids.template', 'key': 'orientation', 'value': orientacion}, '*');
						}
                	}
					window.close();
                });
			}
	</script>
</head>

<body class="<?php echo $bg_clases; ?>">
	<div class="wrapper" id="TEMPLATE_CONTENT">
		<div class="contenedor" <?php if( $tipo == 'offer' ) echo 'style="background-color:' . $data['color'] . ';"' ?>>
			<img src="<?php echo $template_dir ?>/img/logo.png" class="logo">

			<div class="data-ofertas">
				<?php if( $tipo == 'message' ) : ?>
					<h1 id="TITLE"><?php echo $data['title']; ?></h1>
				<?php endif; ?>

				<div id="DESCRIPCION"><?php echo nl2p($data['desc']); ?></div>

				<?php if( $tipo == 'offer' ) : ?>
					<div id="SUBDESCRIPCION"><?php echo nl2p($data['subdesc']); ?></div>
					<div id="LEGAL"><?php echo nl2p($data['legal']); ?></div>
				<?php endif; ?>
			</div>

			<?php if( $tipo == 'offer' ) : ?>
				<div class="img-container">
					<div class="img-move">
						<div class="img" style="background-image:url(<?php echo $data['img'] ?>);"></div>
					</div>
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

	<script src="<?php echo $template_dir ?>/js/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
	<script src="<?php echo $template_dir ?>/js/CustomEase.min.js"></script>
	<script src="<?php echo $template_dir ?>/js/front-end.js"></script>

</body>

</html>
























