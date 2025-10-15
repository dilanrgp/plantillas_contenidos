<?php
	require_once __DIR__ . '/../accesomysql.php';

	$template			= $_POST["TEMPLATE"];
	$template_number	= substr($template, -1);

	$dev = true;

	$data = [
		'title'		=> $_POST["TITLE"],				//
		'content'	=> $_POST["CONTENT"],			//
		'price'		=> $_POST["PRICE"],
		'claim'		=> $_POST["CLAIM"],
		'img'		=> $_POST["IMG"],				//
		'horario_1' => $_POST["HORARIO_1"],			//
		'horario_2' => $_POST["HORARIO_2"],			//
		'horario_3' => $_POST["HORARIO_3"],			//
		'tel' 		=> $_POST["TEL"],				//
		'facebook' 	=> $_POST["FACEBOOK"], 			//
		'twitter' 	=> $_POST["TWITTER"],			//
		'instagram' => $_POST["INSTAGRAM"],			//
		'pinterest' => $_POST["PINTEREST"],			//
		'youtube' 	=> $_POST["YOUTUBE"],			//
		'linkedin' 	=> $_POST["LINKEDIN"]			//
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
		case '4':
			$tipo 		= 'horarios';
			$bg_clases	= 'horarios';
			break;
	}

    $template_dir = BASE_PATH . '/177';
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
	<title>Plantillas cofares</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="fonts/font-awesome.min.css">
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
								 	"<title>Plantillas Cofares</title>"+
                                    "<link rel='preconnect' href='https://fonts.gstatic.com'>"+
                                    "<link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap' rel='stylesheet'>"+
                                    "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css'>"+
                                    "<link rel='stylesheet' href='<?php echo $template_dir ?>/fonts/font-awesome.min.css'>"+
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
		<div class="contenedor">
			<header>
				<!-- <img src="<?php echo $template_dir ?>/img/logo.png" class="logo"> -->
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
					<figure class="oferta__img_container">
						<div class="oferta__img">
							<div class="oferta_img_cut">
								<div style="background-image:url(<?php echo $data['img']; ?>)" class="img"></div>
							</div>
							<?php if( $tipo !== 'evento') : ?>
								<h2 class="oferta__price" id="PRICE"><?php echo $data['price']; ?></h2>
							<?php endif; ?>
						</div>
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
					<?php if( $tipo === 'evento') : ?>
						<h2 class="oferta__price" id="PRICE"><?php echo $data['price']; ?></h2>
					<?php endif; ?>
					</div>
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




























