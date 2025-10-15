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

	$dev = ($_SERVER['HTTP_HOST'] === 'localhost');

	$data = [
		'title'		=> $_POST["TITLE"],				//
		'content'	=> $_POST["CONTENT"],			//
		'price'		=> $_POST["PRICE"],
		'subprice'	=> $_POST["SUBPRICE"],
		'legal'		=> $_POST["LEGAL"],
		'claim'		=> $_POST["CLAIM"],
		'cambio_img'=> $_POST["CAMBIO_IMG"],				//
		'img'		=> $_POST["IMG"],				//
		'horario_1' => $_POST["HORARIO_1"],			//
		'horario_2' => $_POST["HORARIO_2"],			//
		'horario_3' => $_POST["HORARIO_3"],			//
		'tel' 		=> $_POST["TEL"],				//
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
			$tipo 		= 'oferta';
			$bg_clases	= 'oferta oferta_V';
			break;
		case '4':
			$tipo 		= 'horarios';
			$bg_clases	= 'horarios';
			break;
		case '5':
			$tipo 		= 'mensaje';
			$bg_clases	= 'mensaje';
			break;
	}

	if( $tipo != 'oferta' && !isset($data['cambio_img']) ) {
		$bg_clases .= ' no_img';
	}

    $template_dir = '/plantillascontenidov4/142';
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
	<title>Plantillas ORTOKA</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/preview.css">
	<script language="JavaScript">
			function grabarplantilla()
			{
				var atributos = null;
				var plantilla = null;
				var contenido = null;

				var contenedor =
								 "<html lang='es'>"+
								 "<head>"+
								 	"<meta http-equiv='Content-type' content='text/html; charset=utf-8'>"+
								 	"<title>Plantillas ORTOKA</title>"+
									"<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css'>"+
									"<link rel='stylesheet' href='<?php echo $template_dir ?>/css/preview.css'>"+	
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
</head>

<body class="<?php echo $bg_clases; ?>">
	<div class="wrapper" id="TEMPLATE_CONTENT">
		<img src="<?php echo $template_dir ?>/img/logo.png" class="logo">
		<div class="contenedor">
			<?php if( $tipo === 'horarios') : ?>

				<section class="horarios__main">
					<h1>Horario</h1>
					<p><?php echo $data['horario_1'] ? $data['horario_1'] : '&nbsp;'; ?></p>
					<p><?php echo $data['horario_2'] ? $data['horario_2'] : '&nbsp;'; ?></p>
					<p><?php echo $data['horario_3'] ? $data['horario_3'] : '&nbsp;'; ?></p>
					<?php if(strlen($data['tel'])) : ?>
						<p class="tel">tel. <span class="tel__num"><?php echo $data['tel']; ?></span></p>
					<?php endif; ?>
				</section>

			<?php else : ?>

				<section class="oferta__main">
					<figure class="oferta__img">
						<div style="background-image:url(<?php echo $data['img']; ?>)" class="img"></div>
					</figure>
					<div class="oferta__details group">
						<h1 class="oferta__name" id="TITLE"><?php echo nl2br($data['title']); ?></h1>
						<?php if( $data['content'] ) : ?>
							<div class="oferta__info" id="CONTENT">
								<p><?php echo nl2br($data['content']); ?></p>
							</div>
						<?php endif; ?>
					</div>
					<?php if( $data['claim'] || $data['price'] || $data['subprice'] || $data['legal'] ) : ?>
						<div class="oferta__extras">
							<?php if( $data['claim'] ) : ?>
								<h2 class="oferta__claim" id="CLAIM"><?php echo $data['claim']; ?></h2>
							<?php endif; ?>
								<h2 class="oferta__price" id="PRICE"><?php echo $data['price']; ?></h2>
							<?php if( $data['subprice'] ) : ?>
								<p id="SUBPRICE"><?php echo $data['subprice']; ?></p>
							<?php endif; ?>
							<?php if( $data['legal'] ) : ?>
								<p id="LEGAL"><?php echo $data['legal']; ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</section>

			<?php endif; ?>

		</div>
	</div>

	<div class="wrapper" id="BUTTONS">
		<div class="btns">
			<input type="button" class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();">
			<input type="button" class="btn btn-primary" name="volver" value="Volver" onclick="window.close(); window.history.back();">
		</div>
	</div>
</body>

</html>














