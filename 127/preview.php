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
		'desc'		=> $_POST["DESCRIPCION"],
		'subdesc'	=> $_POST["SUBDESCRIPCION"],
		'price'		=> $_POST["PRICE"],
		'subprice'	=> $_POST["SUBPRICE"],
		'con_ud'	=> $_POST["CON_UD"],
		'claim' 	=> $_POST["CLAIM"],
		'con_claim' => $_POST["CON_CLAIM"],
		'legal' 	=> $_POST["LEGAL"],
		'img'	 	=> $_POST["IMG"]
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Plantillas GLEM</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/template.css">
</head>

<body class="<?php echo $bg_clases; ?>">
	<div class="wrapper" id="TEMPLATE_CONTENT">
		<div class="contenedor">
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
									<?php else : ?>
										<span class="currency">€</span>
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
						<?php if ($dev) : ?>
							<div class="img" style="background-image:url(<?php echo 'img_test/' . $data['img'] ?>);"></div>
						<?php else :?>
							<div class="img" style="background-image:url(<?php echo $data['img'] ?>);"></div>
						<?php endif; ?>
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
			<input type="button" class="btn btn-primary" name="volver" value="Volver" onclick="window.close();">
		</div>
	</div>
</body>

</html>
























