<?php
	$template			= $_POST["TEMPLATE"];
	$template_number	= substr($template, -1);

	switch ( $template_number ) {
		case '1':
			$tipo 			= 'menu_dia';
			$body_classes	= 'plantilla-menu';
			$data 			= [
				'fecha'				=> $_POST["day"],
				'primero'			=> $_POST["primero"],
				'primero_precio'	=> $_POST["primero_precio"],
				'segundo'			=> $_POST["segundo"],
				'segundo_precio'	=> $_POST["segundo_precio"]
			];
			break;
		case '2':
			$tipo 			= 'menu_semana';
			$body_classes	= 'plantilla-menu';
			$data 			= [
				'fecha'	=> $_POST["week"],
				'lunes'	=> [
						'primero'			=> $_POST["Lprimero"],
						'primero_precio'	=> $_POST["Lprimero_precio"],
						'segundo'			=> $_POST["Lsegundo"],
						'segundo_precio'	=> $_POST["Lsegundo_precio"],
				],
				'martes'	=> [
						'primero'			=> $_POST["Mprimero"],
						'primero_precio'	=> $_POST["Mprimero_precio"],
						'segundo'			=> $_POST["Msegundo"],
						'segundo_precio'	=> $_POST["Msegundo_precio"],
				],
				'miercoles'	=> [
						'primero'			=> $_POST["Xprimero"],
						'primero_precio'	=> $_POST["Xprimero_precio"],
						'segundo'			=> $_POST["Xsegundo"],
						'segundo_precio'	=> $_POST["Xsegundo_precio"],
				],
				'jueves'	=> [
						'primero'			=> $_POST["Jprimero"],
						'primero_precio'	=> $_POST["Jprimero_precio"],
						'segundo'			=> $_POST["Jsegundo"],
						'segundo_precio'	=> $_POST["Jsegundo_precio"],
				],
				'viernes'	=> [
						'primero'			=> $_POST["Vprimero"],
						'primero_precio'	=> $_POST["Vprimero_precio"],
						'segundo'			=> $_POST["Vsegundo"],
						'segundo_precio'	=> $_POST["Vsegundo_precio"],
				],
				'sabado'	=> [
						'primero'			=> $_POST["Sprimero"],
						'primero_precio'	=> $_POST["Sprimero_precio"],
						'segundo'			=> $_POST["Ssegundo"],
						'segundo_precio'	=> $_POST["Ssegundo_precio"],
				],
			];
			break;
		case '3':
			$tipo 			= 'promocion';
			$body_classes	= 'plantilla-oferta';
			$data 			= [
				'oferta_name'	=> $_POST["oferta_name"],
				'oferta'		=> $_POST["oferta"]
			];
			break;
		case '4':
			$tipo 			= 'product';
			$body_classes	= 'plantilla-producto';
			$data 			= [
				'producto'		=> $_POST["product_name"],
				'descripcion'	=> $_POST["product_desc"],
				'euros'			=> $_POST["product_euros"],
				'cents'			=> $_POST["product_cents"]
				//,				'img_path'		=> $_POST["img_path"]
			];
			break;
	}

///////////////////////
//  JCAM  
$idcontent         = 	$_POST["idcontent"];
$idcustomer = 20;  // LA COLEGIALA

include("../accesomysql.php");
$directoriocliente = $directoriobase."/".$idcustomer."/";
$dirbase = "ladorianids.com";
//$dirbase = "idsv2.ladorian.es";

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


// Cuando alguno de los atributos sea una IMAGEN hay que ponerla como :   $_FILES["img_path"]["name"]

	$destination_path = getcwd().DIRECTORY_SEPARATOR;
	$target_path = $destination_path ."templates/".basename( @$_FILES["img_path"]["name"]);
	@move_uploaded_file($_FILES['img_path']['tmp_name'], $target_path);

	//Se leen los argumentos tecleados en el Formulario
	$imagenelegida =  basename( @$_FILES["img_path"]["name"]);
	$imagenleida =  basename( $_POST['imagenamostrar']);

	
	if(is_null($imagenelegida) || $imagenelegida == "" || $imagenelegida == " ") 	// NO se ha elegido un Archivo
	{
		$archivoelegido = "N";
	}
	else  				// Se ha elegido un Archivo
	{
		$archivoelegido = "S";
	}

	if($archivoelegido == "S")
		$imagen = $directoriocliente."templates/".$_FILES["img_path"]["name"];
	else
		$imagen = $directoriocliente."templates/".$imagenleida;

	
	$atributos[] = array(
	// menu dia
				'fechaday'			=> $_POST["day"],
				'primero'			=> $_POST["primero"],
				'primero_precio'	=> $_POST["primero_precio"],
				'segundo'			=> $_POST["segundo"],
				'segundo_precio'	=> $_POST["segundo_precio"],
	// menu semana
				'fechaweek'			=> $_POST["week"],
				'Lprimero'			=> $_POST["Lprimero"],
				'Lprimero_precio'	=> $_POST["Lprimero_precio"],
				'Lsegundo'			=> $_POST["Lsegundo"],
				'Lsegundo_precio'	=> $_POST["Lsegundo_precio"],

				'Mprimero'			=> $_POST["Mprimero"],
				'Mprimero_precio'	=> $_POST["Mprimero_precio"],
				'Msegundo'			=> $_POST["Msegundo"],
				'Msegundo_precio'	=> $_POST["Msegundo_precio"],

				'Xprimero'			=> $_POST["Xprimero"],
				'Xprimero_precio'	=> $_POST["Xprimero_precio"],
				'Xsegundo'			=> $_POST["Xsegundo"],
				'Xsegundo_precio'	=> $_POST["Xsegundo_precio"],

				'Jprimero'			=> $_POST["Jprimero"],
				'Jprimero_precio'	=> $_POST["Jprimero_precio"],
				'Jsegundo'			=> $_POST["Jsegundo"],
				'Jsegundo_precio'	=> $_POST["Jsegundo_precio"],

				'Vprimero'			=> $_POST["Vprimero"],
				'Vprimero_precio'	=> $_POST["Vprimero_precio"],
				'Vsegundo'			=> $_POST["Vsegundo"],
				'Vsegundo_precio'	=> $_POST["Vsegundo_precio"],

				'Sprimero'			=> $_POST["Sprimero"],
				'Sprimero_precio'	=> $_POST["Sprimero_precio"],
				'Ssegundo'			=> $_POST["Ssegundo"],
				'Ssegundo_precio'	=> $_POST["Ssegundo_precio"],
	// Oferta	
				'oferta_name'		=> $_POST["oferta_name"],
				'oferta'			=> $_POST["oferta"],
	// Promoción	
				'product_name'		=> @$_POST["product_name"],
				'product_desc'		=> @$_POST["product_desc"],
				'product_euros'		=> @$_POST["product_euros"],
				'product_cents'		=> @$_POST["product_cents"],
				'img_path'			=> @$imagen
						 );							
						
	// Grabar en el campo "attributes" de content_template,	en formato JSON,, los valores de los campos variables
	$json_string = json_encode($atributos);
	// Se sustituye de momento la " por el caracter ^ ya que con la primera se corta la variable... En la grabacion se volvera a sustituir por la "
	$json_string = str_replace("\"","^",$json_string);
?>
<input type="hidden" name="atributos" id="atributos" value="<?php echo $json_string?>">
<input type="hidden" name="idcontenttemplate" id="idcontenttemplate" value="<?php echo $idcontenttemplate?>">
<input type="hidden" name="idcontent" id="idcontent" value="<?php echo $idcontent?>">
<!--- ENDJCAM --->

<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Plantillas La Colegiala</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="estilo.css">
	
<!---////////// JCAM --->	
	<script language="JavaScript">
			function grabarplantilla()
			{

				var atributos = document.getElementById("atributos").value;
				var plantilla = document.getElementById("idcontenttemplate").value;
				var contenido = document.getElementById("idcontent").value;
				//var contenedor = document.getElementById("container").outerHTML;
				/*
						document.documentElement.innerHTML;
						document.documentElement.outerHTML;
						document.getElementsByTagName('html')[0].outerHTML;     <--------------------------
						document.getElementsByTagName(‘body’)[0].outerHTML;
				*/

				var contenedor =
								 "<html lang='es'><head><meta http-equiv='Content-type' content='text/html; charset=utf-8'>"+
								 //"<title>Plantilla de menus diarios</title>"+
								 "<link rel='stylesheet' href='<?php echo $directoriocliente?>"+"estilo.css'>"+					 
								 "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css'>"+						 
								 "</head><body class='<?php echo $body_classes; ?>' >"+
								 //"<div class='wrapper' id='TEMPLATE_CONTENT' >"+	
								"<div class='wrapper' >"+										 
								 document.getElementById("divcuerpoHTML").outerHTML+
								 "</div></body></html>";

				if (window.XMLHttpRequest)
				 {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
				 }
				 else
				 {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				 }

				 xmlhttp.onreadystatechange = function()
				 {
					 				 
						if (xmlhttp.readyState == 4 || xmlhttp.status == 200)  // http completado y ha sido ok
						{
							var response = xmlhttp.responseText; // 
							var result = JSON.parse(response);
							if(result.success) {
								parent.postMessage({domain:'ladorian.ids.template', 'key': 'template-url', 'value': result.data}, '*');
							}
						  
							 //Se cierra la ventana y se vuelve al Formulario  
							 window.close();
						}
				 };
				// Se pasa de esta forma ya que si se pasa por GET se pasan caracteres raros en el contenido
				params= "html="+contenedor+"&atributos="+atributos+"&plantilla="+plantilla+"&contenido="+contenido;				 
				xmlhttp.open("POST","<?php echo $directoriobase.'/grabaplantilla.php'?>",true);				
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.send(params);

			}
	</script>	
<!---////////// ENDJCAM --->		
	
	
</head>


<body class="<?php echo $body_classes; ?>">
<div class="wrapper">
	<div name = "divcuerpoHTML" id="divcuerpoHTML" class="contenedor">

		<?php if ( $tipo === 'menu_dia') : ?>
			<div class="menu-bg">
				<img src="<?php echo $directoriocliente?>templates/bg-menu.jpg">
			</div>
			<section class="menu menu--individual">
				<header class="menu__header">
					<h1 class="menu__name">Menú del día</h1>
					<h2 class="menu__date"><span><?php echo $data['fecha']; ?></span></h2>
				</header>
				<p class="menu__plato">1&deg; <?php echo $data['primero'] . '.....' . $data['primero_precio']; ?> &euro;</p>
				<p class="separator">&hellip;</p>
				<p class="menu__plato">2&deg; <?php echo $data['segundo'] . '.....' . $data['segundo_precio']; ?> &euro;</p>
			</section>
			
		<?php elseif ( $tipo === 'menu_semana') : ?>
			<div class="menu-bg">
				<img src="<?php echo $directoriocliente?>templates/bg-menu.jpg">
			</div>
			<section class="menu">
				<header class="menu__header">
					<img src="<?php echo $directoriobase?>/img/colegiala-front/colegiala-title-menu-semanal.png" class="menu__title-semanal">
					<h2 class="menu__date"><span><?php echo $data['fecha']; ?></span></h2>
				</header>
				<div class="menu--semanal">
					<div class="menu__fila">
						<div class="menu__dia">
							<h3 class="menu__nombre-dia">Lunes</h3>
							<p class="menu__plato">1&deg; <?php echo $data['lunes']['primero'] . '.....' . $data['lunes']['primero_precio']; ?> &euro;</p>
							<p class="menu__plato">2&deg; <?php echo $data['lunes']['segundo'] . '.....' . $data['lunes']['segundo_precio']; ?> &euro;</p>
						</div>
						<div class="menu__dia">
							<h3 class="menu__nombre-dia">Miercoles</h3>
							<p class="menu__plato">1&deg; <?php echo $data['miercoles']['primero']. '.....' . $data['miercoles']['primero_precio']; ?> &euro;</p>
							<p class="menu__plato">2&deg; <?php echo $data['miercoles']['segundo'] . '.....' . $data['miercoles']['segundo_precio']; ?> &euro;</p>
						</div>
						<div class="menu__dia">
							<h3 class="menu__nombre-dia">Viernes</h3>
							<p class="menu__plato">1&deg; <?php echo $data['viernes']['primero'] . '.....' . $data['viernes']['primero_precio']; ?> &euro;</p>
							<p class="menu__plato">2&deg; <?php echo $data['viernes']['segundo'] . '.....' . $data['viernes']['segundo_precio']; ?> &euro;</p>
						</div>
					</div>
					<div class="menu__fila">
						<div class="menu__dia">
							<h3 class="menu__nombre-dia">Martes</h3>
							<p class="menu__plato">1&deg; <?php echo $data['martes']['primero'] . '.....' . $data['martes']['primero_precio']; ?> &euro;</p>
							<p class="menu__plato">2&deg; <?php echo $data['martes']['segundo'] . '.....' . $data['martes']['segundo_precio']; ?> &euro;</p>
						</div>
						<div class="menu__dia">
							<h3 class="menu__nombre-dia">Jueves</h3>
							<p class="menu__plato">1&deg; <?php echo $data['jueves']['primero'] . '.....' . $data['jueves']['primero_precio']; ?> &euro;</p>
							<p class="menu__plato">2&deg; <?php echo $data['jueves']['segundo'] . '.....' . $data['jueves']['segundo_precio']; ?> &euro;</p>
						</div>
						<div class="menu__dia">
							<h3 class="menu__nombre-dia">Sabado</h3>
							<p class="menu__plato">1&deg; <?php echo $data['sabado']['primero'] . '.....' . $data['sabado']['primero_precio']; ?> &euro;</p>
							<p class="menu__plato">2&deg; <?php echo $data['sabado']['segundo'] . '.....' . $data['sabado']['segundo_precio']; ?> &euro;</p>
						</div>
					</div>
				</div>
			</section>
			
		<?php elseif ( $tipo === 'promocion') : ?>
			<section class="oferta">
				<div class="oferta__pizarra">
					<div class="oferta__wrapper">
						<h1 class="oferta__title">HOY TENEMOS EN PROMOCION</h1>
						<h2 class="oferta__product"><?php echo $data['oferta_name']; ?></h2>
						<p class="oferta__descuento"><?php echo $data['oferta']; ?></p>
					</div>
				</div>
				<div class="oferta__mesa"></div>
				<div class="oferta__productos"></div>
			</section>
			
		<?php elseif ( $tipo === 'product') : ?>
			<div class="vignette"></div>
			<section class="product">
				<div class="product__info">
					<h1 class="product__name"><?php echo $data['producto']; ?></h1>
					<p class="product__desc"><?php echo $data['descripcion']; ?></p>
				</div>

				<div class="product__img_move">
					<img src="<?php echo $imagen; ?>" class="product__img">
				</div>
				
				<div class="product__price <?php if( strlen($data['euros']) > 1 ) echo 'product__price--big' ?> ">
					<span class="euros"><?php echo $data['euros']; ?></span>
					<?php if( isset( $data['cents'] ) && $data['cents'] !== '') : ?>
						<span class="cents">,<?php echo $data['cents']; ?></span>
					<?php endif; ?>
					<span class="simbolo <?php if( isset( $data['cents'] ) && $data['cents'] !== '') echo 'simbolo--small'; ?>">€</span>
					<div class="product__price_bg"></div>
				</div>
			 </section>
			
		<?php endif; ?>


	</div>
	<div class="wrapper" id="BUTTONS">
			<div class="btns">
			<?php $ira = "https://".$dirbase."/campaign/campaigns/campaigncontent/".$idcontent; ?>
			<input type="button" class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();window.location.href = '<?php echo $ira?>';">
			<!--- NO FUNCIONA <input type="button" class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();window.close();	window.history.back();">--->

			<input type="button" class="btn btn-primary" name="volver" value="Volver" onclick="window.close();	window.history.back();">			

			</div>
	</div>
	

	



	
</div>		
		
</body>

</html>
