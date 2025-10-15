<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulario de creacion de promocion para Domino's</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/form.css">

</head>


<?php   

////////// JCAM

// Conexión a la B.D.
include("../accesomysql.php");
$idcustomer = 40;  // DOMINOS
$directoriocliente = $directoriobase."/".$idcustomer."/";
$template="TEMPLATE-1";
$idcontent   = 	0;
$idcampaign   = 0;


	$OFFER_TITLE			= "";
	$OFFER_SUBTITLE			= "";
	$OFFER_IMG				= "";
	$OFFER_PRICE			= "";
	$OFFER_CONDITIONS		= "";
	$OFFER_DESC				= "";
	$OFFER_IMG_TEXT			= "";
	$MENU_1_NAME			= "";
	$MENU_1_SUBTITLE		= "";
	$MENU_1_DESC_1			= "";
	$MENU_1_DESC_2			= "";
	$MENU_1_DESC_3			= "";
	$MENU_1_PRICE			= "";
	$MENU_1_IMG				= "";	
	$MENU_1_IMG_TEXT		= "";			
	$MENU_2_NAME			= "";
	$MENU_2_SUBTITLE		= "";
	$MENU_2_DESC_1			= "";
	$MENU_2_DESC_2			= "";
	$MENU_2_DESC_3			= "";
	$MENU_2_PRICE			= "";
	$MENU_2_IMG				= "";
	$MENU_2_IMG_TEXT		= "";
	$MENU_3_NAME			= "";
	$MENU_3_SUBTITLE		= "";
	$MENU_3_DESC_1			= "";
	$MENU_3_DESC_2			= "";
	$MENU_3_DESC_3			= "";
	$MENU_3_PRICE			= "";
	$MENU_3_IMG				= "";
	$MENU_3_IMG_TEXT		= "";			
	$MENU_4_NAME			= "";
	$MENU_4_SUBTITLE		= "";
	$MENU_4_DESC_1			= "";
	$MENU_4_DESC_2			= "";
	$MENU_4_DESC_3			= "";
	$MENU_4_PRICE			= "";
	$MENU_4_IMG				= "";
	$MENU_4_IMG_TEXT		= "";
	$PROMO_DER_TXT_1		= "";
	$PROMO_DER_TXT_2		= "";
	$PROMO_DER_TXT_3		= "";
	$PROMO_DER_BTN			= "";
	$PROMO_DER_PRICE		= "";
	$PROMO_DER_COND			= "";
	$PROMO_DER_VIDEO		= "";
	$PROMO_DER_VIDEO_TEXT	= "";


?>


<body>
	<div class="container body" role="main">
		<form action="result.php" method="POST" id="TEMPLATE_FORM" class="row" enctype="multipart/form-data">
		<input type="hidden" name="idcontent" id="idcontent" value="<?php echo $idcontent?>">
		<input type="hidden" name="idcampaign" id="idcampaign" value="<?=$idcampaign?>">
		<input type="hidden" name="idcustomer" id="idcustomer" value="<?php echo $idcustomer?>">				

			<fieldset class="col-md-12 form-group" id="TEMPLATE_SELECTOR">
				<h3>Elije tu diseño</h3>
				<div class="row align-items-center">
					<div class="form-check col col-md-6">
						<label for="TEMPLATE-1" class="template-selection">
							<div class="cell">
								<input type="radio" name="TEMPLATE" id="TEMPLATE-1" <?php if ($template == "TEMPLATE-1") echo "checked";?>  value="TEMPLATE-1" required>
							</div>
							<div class="cell">
								<span>Oferta básica</span>
							</div>
						</label>
					</div>
					<div class="form-check col col-md-6">
						<label for="TEMPLATE-2" class="template-selection">
							<div class="cell">
								<input type="radio" name="TEMPLATE" id="TEMPLATE-2" <?php if ($template == "TEMPLATE-2") echo "checked";?> value="TEMPLATE-2" required>
							</div>
							<div class="cell">
								<span>Menuboard</span>
							</div>
						</label>
					</div>
				</div>
			</fieldset>


			

			
			<fieldset class="col-md-12 form-group" id="CONFIG">

				<div class="config-container" id="OFERTA">
					<input type="text" id="OFFER_TITLE" name="OFFER_TITLE" value="<?=$OFFER_TITLE?>" placeholder="Chococheese">
					<input type="text" id="OFFER_SUBTITLE" name="OFFER_SUBTITLE" value="<?=$OFFER_SUBTITLE?>" placeholder="Lo mejor del queso y el chocolate.">
					<input type="number" id="OFFER_PRICE" name="OFFER_PRICE" value="<?=$OFFER_PRICE?>" placeholder="2,99" step="any">
					<input type="text" id="OFFER_CONDITIONS" name="OFFER_CONDITIONS" value="<?=$OFFER_CONDITIONS?>" placeholder="2ud.">
					<textarea id="OFFER_DESC" name="OFFER_DESC" value="<?=$OFFER_DESC?>"  rows="3"></textarea>
					<label for="OFFER_IMG">Fondo:</label><input type="file" id="OFFER_IMG" name="OFFER_IMG" value="<?=$OFFER_IMG?>">
					<input type="hidden" id="OFFER_IMG_TEXT" name="OFFER_IMG_TEXT" value="<?=$OFFER_IMG_TEXT?>">
				</div>


				<div class="config-container" id="MENUBOARD">
					<div class="menus columna">
						<div id="MENU_1" class="menu">
							<input type="text" class="form-control menu-name" id="MENU_1_NAME" name="MENU_1_NAME" value="<?=$MENU_1_NAME?>" placeholder="Menú individual">
							<input type="text" class="form-control menu-subtitle" id="MENU_1_SUBTITLE" name="MENU_1_SUBTITLE" value="<?=$MENU_1_SUBTITLE?>" placeholder="Menú porciones">
							<input type="text" class="form-control menu-desc" id="MENU_1_DESC_1" name="MENU_1_DESC_1" value="<?=$MENU_1_DESC_1?>" placeholder="2 porciones">
							<input type="text" class="form-control menu-desc-small" id="MENU_1_DESC_2" name="MENU_1_DESC_2" value="<?=$MENU_1_DESC_2?>" placeholder="+ Bebida">
							<input type="text" class="form-control menu-desc-small" id="MENU_1_DESC_3" name="MENU_1_DESC_3" value="<?=$MENU_1_DESC_3?>" placeholder="+ Complemento">
							<input type="number" class="form-control menu-price" id="MENU_1_PRICE" name="MENU_1_PRICE" value="<?=$MENU_1_PRICE?>" placeholder="19,99" step="any">
							<input type="file" id="MENU_1_IMG" name="MENU_1_IMG" value="<?=$MENU_1_IMG?>" class="menu-img" style="<?php if(!empty($MENU_1_IMG)){ echo 'color: transparent;'; } ?>">
							<input type="hidden" id="MENU_1_IMG_TEXT" name="MENU_1_IMG_TEXT" value="<?=$MENU_1_IMG_TEXT?>">
						<?php /*	<span class="form-control"><?=$MENU_1_IMG?></span> */ ?>
						</div>


						<div id="MENU_2" class="menu">
							<input type="text" class="form-control menu-name" id="MENU_2_NAME" name="MENU_2_NAME" value="<?=$MENU_2_NAME?>" placeholder="Menú individual">
							<input type="text" class="form-control menu-subtitle" id="MENU_2_SUBTITLE" name="MENU_2_SUBTITLE" value="<?=$MENU_2_SUBTITLE?>" placeholder="Menú porciones">
							<input type="text" class="form-control menu-desc" id="MENU_2_DESC_1" name="MENU_2_DESC_1" value="<?=$MENU_2_DESC_1?>" placeholder="2 porciones">
							<input type="text" class="form-control menu-desc-small" id="MENU_2_DESC_2" name="MENU_2_DESC_2" value="<?=$MENU_2_DESC_2?>" placeholder="+ Bebida">
							<input type="text" class="form-control menu-desc-small" id="MENU_2_DESC_3" name="MENU_2_DESC_3" value="<?=$MENU_2_DESC_3?>" placeholder="+ Complemento">
							<input type="number" class="form-control menu-price" id="MENU_2_PRICE" name="MENU_2_PRICE" value="<?=$MENU_2_PRICE?>" placeholder="19,99" step="any">
							<input type="file" id="MENU_2_IMG" name="MENU_2_IMG" value="<?=$MENU_2_IMG?>" class="menu-img" style="<?php if(!empty($MENU_2_IMG)){ echo 'color: transparent;'; } ?>">
							<input type="hidden" id="MENU_2_IMG_TEXT" name="MENU_2_IMG_TEXT" value="<?=$MENU_2_IMG_TEXT?>">
						</div>

						<div id="MENU_3" class="menu">
							<input type="text" class="form-control menu-name" id="MENU_3_NAME" name="MENU_3_NAME" value="<?=$MENU_3_NAME?>" placeholder="Menú individual">
							<input type="text" class="form-control menu-subtitle" id="MENU_3_SUBTITLE" name="MENU_3_SUBTITLE" value="<?=$MENU_3_SUBTITLE?>" placeholder="Menú porciones">
							<input type="text" class="form-control menu-desc" id="MENU_3_DESC_1" name="MENU_3_DESC_1" value="<?=$MENU_3_DESC_1?>" placeholder="2 porciones">
							<input type="text" class="form-control menu-desc-small" id="MENU_3_DESC_2" name="MENU_3_DESC_2" value="<?=$MENU_3_DESC_2?>" placeholder="+ Bebida">
							<input type="text" class="form-control menu-desc-small"  id="MENU_3_DESC_3" name="MENU_3_DESC_3" value="<?=$MENU_3_DESC_3?>" placeholder="+ Complemento">
							<input type="number" class="form-control menu-price" id="MENU_3_PRICE" name="MENU_3_PRICE" value="<?=$MENU_3_PRICE?>" placeholder="19,99" step="any">
							<input type="file" id="MENU_3_IMG" name="MENU_3_IMG" value="<?=$MENU_3_IMG?>" class="menu-img" style="<?php if(!empty($MENU_3_IMG)){ echo 'color: transparent;'; } ?>">
							<input type="hidden"  id="MENU_3_IMG_TEXT" name="MENU_3_IMG_TEXT" value="<?=$MENU_3_IMG_TEXT?>">
						</div>

						<div id="MENU_4" class="menu">
							<input type="text" class="form-control menu-name" id="MENU_4_NAME" name="MENU_4_NAME" value="<?=$MENU_4_NAME?>" placeholder="Menú individual">
							<input type="text" class="form-control menu-subtitle" id="MENU_4_SUBTITLE" name="MENU_4_SUBTITLE" value="<?=$MENU_4_SUBTITLE?>" placeholder="Menú porciones">
							<input type="text" class="form-control menu-desc" id="MENU_4_DESC_1" name="MENU_4_DESC_1" value="<?=$MENU_4_DESC_1?>" placeholder="2 porciones">
							<input type="text" class="form-control menu-desc-small" id="MENU_4_DESC_2" name="MENU_4_DESC_2" value="<?=$MENU_4_DESC_2?>" placeholder="+ Bebida">
							<input type="text" class="form-control menu-desc-small" id="MENU_4_DESC_3" name="MENU_4_DESC_3" value="<?=$MENU_4_DESC_3?>" placeholder="+ Complemento">
							<input type="number" class="form-control menu-price" id="MENU_4_PRICE" name="MENU_4_PRICE" value="<?=$MENU_4_PRICE?>" placeholder="19,99" step="any">
							<input type="file" id="MENU_4_IMG" name="MENU_4_IMG" class="menu-img" value="<?=$MENU_4_IMG?>" style="<?php if(!empty($MENU_4_IMG)){ echo 'color: transparent;'; } ?>">
							<input type="hidden" id="MENU_4_IMG_TEXT" name="MENU_4_IMG_TEXT" value="<?=$MENU_4_IMG_TEXT?>">
						</div>
					</div>

					<div class="columna oferta">
						<input type="text" class="form-control" id="PROMO_DER_TXT_1" name="PROMO_DER_TXT_1" value="<?=$PROMO_DER_TXT_1?>" placeholder="ej.: #QUESOBRADA">
						<input type="text" class="form-control" id="PROMO_DER_TXT_2" name="PROMO_DER_TXT_2" value="<?=$PROMO_DER_TXT_2?>" placeholder="ej.: CHEESE EXPLOSION">
						<input type="text" class="form-control" id="PROMO_DER_TXT_3" name="PROMO_DER_TXT_3" value="<?=$PROMO_DER_TXT_3?>" placeholder="ej.: UNLIMITED">
						<input type="text" class="form-control" id="PROMO_DER_BTN" name="PROMO_DER_BTN" value="<?=$PROMO_DER_BTN?>" placeholder="ej.: AÑADE A TU MENÚ">
						<div class="conditions">
						<input type="number" class="form-control" id="PROMO_DER_PRICE" name="PROMO_DER_PRICE" value="<?=$PROMO_DER_PRICE?>" step="any">
							<textarea class="form-control" id="PROMO_DER_COND" name="PROMO_DER_COND" value="<?=$PROMO_DER_COND?>" rows="3"></textarea>
						</div>
						<div class="video_area">
						<input type="file" class="form-control-file" id="PROMO_DER_VIDEO" name="PROMO_DER_VIDEO" value="<?=$PROMO_DER_VIDEO?>">
						 <input type="hidden" id="PROMO_DER_VIDEO_TEXT" name="PROMO_DER_VIDEO_TEXT" value="<?=$PROMO_DER_VIDEO_TEXT?>"> 
						
						</div>
					</div>
				</div>

			<div class="validation"></div>

			<div class="form-group text-center">
				<input type="submit" name="SUBMIT" id="SUBMIT" value="Previsualizar" class="btn btn-success">
			<input type="button" class="btn btn-success" name="volver" value="Volver" onclick="window.close();	window.history.back();">			
			</div>

			</fieldset>
		</form>
	</div>

	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/form.js"></script>

</body>
</html>