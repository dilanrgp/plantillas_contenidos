<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Formulario de creacion de promocion para LACOLEGIALA</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

	<link rel="stylesheet" href="template.css">
</head>

<?php   

////////// JCAM

// Conexión a la B.D.
include("../accesomysql.php");
$idcustomer = 20;  // lacolegiala
$directoriocliente = $directoriobase."/".$idcustomer."/";

$conexionbd  = mysqli_connect($sql_host,$sql_login,$sql_pass,$sql_base) or die("Error en la conexión a la Base de Datos...:".mysqli_connect_error());
mysqli_select_db($conexionbd,$sql_base) OR  die ('Error en la selección de la Base de Datos...' . mysqli_error());

// Se recoge el Idcontenido que se pasa como argumento al pulsar el botón "Plantillas" en la opción CONTENIDOS cuando el tipo
// de contenido es "Plantilla HTML"
$idcontent = 0;
if(isset($_REQUEST['idcontent']))
{
	$idcontent = $_REQUEST['idcontent'];
	$idcontenttemplate = 0;
	$atributos = "";	
	
	// Se mira a ver si ya existe este contenido en la tabla de contenidos para obtener los atributos asociados
	$sql = "SELECT * from content where idcontent = ". $idcontent;	 
 	
	$registro=mysqli_query($conexionbd,$sql) or die("Error en la query...:". $sql."  ".mysqli_error($conexionbd));	
	if(mysqli_num_rows($registro) > 0)  
		while ($datos=mysqli_fetch_array($registro))  // Se lee el idtemplate asociado y los atributos que se introdujeron
		{
			$idcontenttemplate = $datos["idcontenttemplate"];	 
			$atributos = $datos["attributes"];			
		}
	
	// A partir del idtemplate asociado al contenido se obtiene el Nombre del template para luego ver que radiobutton hay 
	// que marcar en el formulario de plantillas.
	// El formato que hay que poner en el campo 'name' de la tabla "content_template" es el mismo que el del Formulario
	// ( ejemplo: TEMPLATE-1)
	
	$template = "";
	if($idcontenttemplate != 0)   // si ya se habia seleccionado previamente una plantilla para el Contenido es curso,
								  // se obtiene cual es
	{
		$sql = "SELECT * from content_template where idcontenttemplate = ". $idcontenttemplate;	 
		
		$registro=mysqli_query($conexionbd,$sql) or die("Error en la query...:". $sql."  ".mysqli_error($conexionbd));	
		while ($datos=mysqli_fetch_array($registro))  
		{
			$template = $datos["name"];
		}
	}
	
}
else
{
	echo "El contenido no existe...";
	exit;
}




// Inicializar todos los valores posibles que se pasan como atributos

// menu dia
$fechaday			= "";
$primero			= "";
$primero_precio		= "";
$segundo			= "";
$segundo_precio		= "";
// menu semana
$fechaweek			= "";
$Lprimero			= "";
$Lprimero_precio	= "";
$Lsegundo			= "";
$Lsegundo_precio	= "";

$Mprimero			= "";
$Mprimero_precio	= "";
$Msegundo			= "";
$Msegundo_precio	= "";

$Xprimero			= "";
$Xprimero_precio	= "";
$Xsegundo			= "";
$Xsegundo_precio	= "";

$Jprimero			= "";
$Jprimero_precio	= "";
$Jsegundo			= "";
$Jsegundo_precio	= "";

$Vprimero			= "";
$Vprimero_precio	= "";
$Vsegundo			= "";
$Vsegundo_precio	= "";

$Sprimero			= "";
$Sprimero_precio	= "";
$Ssegundo			= "";
$Ssegundo_precio	= "";
// Oferta	
$oferta_name		= "";
$oferta				= "";
// Promoción	
$product_name		= "";
$product_euros		= "";
$product_cents		= "";
$product_desc		= "";
$img_path			= "";
						

if(!is_null($atributos))
{
	$arrayatributos = json_decode($atributos, true);   // el true es para obtener un array asociativo, no un stdclass
	//var_dump($arrayatributos);   //mostrar estructura	
	if (is_array($arrayatributos))
	{		
		// menu dia
		$fechaday			= $arrayatributos[0]["fechaday"];
		$primero			= $arrayatributos[0]["primero"];
		$primero_precio		= $arrayatributos[0]["primero_precio"];
		$segundo			= $arrayatributos[0]["segundo"];
		$segundo_precio		= $arrayatributos[0]["segundo_precio"];
		// menu semana
		$fechaweek			= $arrayatributos[0]["fechaweek"];
		$Lprimero			= $arrayatributos[0]["Lprimero"];
		$Lprimero_precio	= $arrayatributos[0]["Lprimero_precio"];
		$Lsegundo			= $arrayatributos[0]["Lsegundo"];
		$Lsegundo_precio	= $arrayatributos[0]["Lsegundo_precio"];

		$Mprimero			= $arrayatributos[0]["Mprimero"];
		$Mprimero_precio	= $arrayatributos[0]["Mprimero_precio"];
		$Msegundo			= $arrayatributos[0]["Msegundo"];
		$Msegundo_precio	= $arrayatributos[0]["Msegundo_precio"];

		$Xprimero			= $arrayatributos[0]["Xprimero"];
		$Xprimero_precio	= $arrayatributos[0]["Xprimero_precio"];
		$Xsegundo			= $arrayatributos[0]["Xsegundo"];
		$Xsegundo_precio	= $arrayatributos[0]["Xsegundo_precio"];

		$Jprimero			= $arrayatributos[0]["Jprimero"];
		$Jprimero_precio	= $arrayatributos[0]["Jprimero_precio"];
		$Jsegundo			= $arrayatributos[0]["Jsegundo"];
		$Jsegundo_precio	= $arrayatributos[0]["Jsegundo_precio"];

		$Vprimero			= $arrayatributos[0]["Vprimero"];
		$Vprimero_precio	= $arrayatributos[0]["Vprimero_precio"];
		$Vsegundo			= $arrayatributos[0]["Vsegundo"];
		$Vsegundo_precio	= $arrayatributos[0]["Vsegundo_precio"];

		$Sprimero			= $arrayatributos[0]["Sprimero"];
		$Sprimero_precio	= $arrayatributos[0]["Sprimero_precio"];
		$Ssegundo			= $arrayatributos[0]["Ssegundo"];
		$Ssegundo_precio	= $arrayatributos[0]["Ssegundo_precio"];
		// Oferta	
		$oferta_name		= $arrayatributos[0]["oferta_name"];
		$oferta				= $arrayatributos[0]["oferta"];
		// Promoción	
		$product_name		= $arrayatributos[0]["product_name"];
		$product_desc		= $arrayatributos[0]["product_desc"];
		$product_euros		= $arrayatributos[0]["product_euros"];
		$product_cents		= $arrayatributos[0]["product_cents"];
		$img_path			= $arrayatributos[0]["img_path"];	
		
	}
}

////////// ENDJCAM

?>


<body>

<div class="container body" role="main">
<div class="row">
	<form action="preview.php" method="POST" id="TEMPLATE_FORM" enctype="multipart/form-data">
		
		<!---////////// JCAM 	
		<!---Pasar parametros al Preview. Solo hay que pasar el idcontent y el idcontenttemplate ya que los atributos se pasaran
		campo a campo --->
	
		<input type="hidden" name="idcontent" id="idcontent" value="<?php echo $idcontent?>">
		<input type="hidden" name="imagenamostrar" id="imagenamostrar" value="<?php echo $img_path?>">	
		
		<!---<input type="hidden" name="atributos" id="atributos" value="<?php echo $atributos?>">	--->	
	
		<!---////////// ENDJCAM	--->
		
		<fieldset class="col-md-12 form-group" id="TEMPLATE">
			<h3>Elije tu diseño</h3>
			<div class="row align-items-center">
				<div class="form-check col col-sm-6">
					<label for="TEMPLATE-1" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-1" <?php if ($template == "TEMPLATE-1") echo "checked";?>  value="TEMPLATE-1">
						</div>
						<div class="cell">
							<p>Menú del día</p>
							<img src="templates/templates/menu_dia.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-sm-6">
					<label for="TEMPLATE-2" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-2" <?php if ($template == "TEMPLATE-2") echo "checked";?> value="TEMPLATE-2">
						</div>
						<div class="cell">
							<p>Menú semanal</p>
							<img src="templates/templates/menu_semanal.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-sm-6">
					<label for="TEMPLATE-3" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-3" <?php if ($template == "TEMPLATE-3") echo "checked";?> value="TEMPLATE-3">
						</div>
						<div class="cell">
							<p>Promoción del día</p>
							<img src="templates/templates/promocion.jpg">
						</div>
					</label>
				</div>
				<div class="form-check col col-sm-6">
					<?php /*
					<label for="TEMPLATE-4" class="template-selection">
						<div class="cell">
							<input type="radio" name="TEMPLATE" id="TEMPLATE-4" <?php if ($template == "TEMPLATE-4") echo "checked";?> value="TEMPLATE-4">
						</div>
						<div class="cell">
							<p>Producto</p>
							<img src="templates/templates/producto.jpg">
						</div>
					</label>
					*/
					?>
				</div>
			</div>
		</fieldset>


		<fieldset class="col-md-12 form-group" id="CONFIG">
			<h3>Configura tu plantilla</h3>

			<div class="config-container">
				<div class="template-config">

					<fieldset id="CONFIG_TEMPLATE_1" class="config-content">
						<input type="text" name="day" id="day" value="<?php echo $fechaday ?>" placeholder="Viernes 29 de septiembre">
						<textarea name="primero" id="primero" placeholder="primer plato"><?php echo $primero ?></textarea>
				    	<input type="text" name="primero_precio" id="primero_precio" value="<?php echo $primero_precio ?>" placeholder="3,80">
						<textarea name="segundo" id="segundo" placeholder="segundo plato"><?php echo $segundo ?></textarea>
						<input type="text" name="segundo_precio" id="segundo_precio" value="<?php echo $segundo_precio ?>" placeholder="5,75">
					</fieldset>

					<fieldset id="CONFIG_TEMPLATE_2" class="config-content">
						<input type="text" name="week" id="week" value="<?php echo $fechaweek ?>" placeholder="Semana del 25/09 al 30/09">
						<div class="dia">
							<p class="dia__name">Lunes</p>
							<div class="dia__menu">
								<textarea name="Lprimero" id="Lprimero" placeholder="Primer plato"><?php echo $Lprimero ?></textarea>
								<input type="text" name="Lprimero_precio" id="Lprimero_precio" value="<?php echo $Lprimero_precio ?>" placeholder="2,35">
							</div>
							<div class="dia__menu">
								<textarea name="Lsegundo" id="Lsegundo" placeholder="Segundo plato"><?php echo $Lsegundo ?></textarea>
								<input type="text" name="Lsegundo_precio" id="Lsegundo_precio" value="<?php echo $Lsegundo_precio ?>" placeholder="6,40">
							</div>
						</div>
						<div class="dia">
							<p class="dia__name">Martes</p>
							<div class="dia__menu">
								<textarea name="Mprimero" id="Mprimero"  placeholder="Primer plato"><?php echo $Mprimero ?></textarea>
								<input type="text" name="Mprimero_precio" id="Mprimero_precio" value="<?php echo $Mprimero_precio ?>" placeholder="2,35">
							</div>
							<div class="dia__menu">
								<textarea name="Msegundo" id="Msegundo" placeholder="Segundo plato"><?php echo $Msegundo ?></textarea>
								<input type="text" name="Msegundo_precio" id="Msegundo_precio" value="<?php echo $Msegundo_precio ?>" placeholder="6,40">
							</div>
						</div>
						<div class="dia">
							<p class="dia__name">Miercoles</p>
							<div class="dia__menu">
								<textarea name="Xprimero" id="Xprimero" placeholder="Primer plato"><?php echo $Xprimero ?></textarea>
								<input type="text" name="Xprimero_precio" id="Xprimero_precio" value="<?php echo $Xprimero_precio ?>" placeholder="2,35">
							</div>
							<div class="dia__menu">
								<textarea name="Xsegundo" id="Xsegundo" placeholder="Segundo plato"><?php echo $Xsegundo ?></textarea>
								<input type="text" name="Xsegundo_precio" id="Xsegundo_precio" value="<?php echo $Xsegundo_precio ?>" placeholder="6,40">
							</div>
						</div>
						<div class="dia">
							<p class="dia__name">Jueves</p>
							<div class="dia__menu">
								<textarea name="Jprimero" id="Jprimero" placeholder="Primer plato"><?php echo $Jprimero ?></textarea>
								<input type="text" name="Jprimero_precio" id="Jprimero_precio" value="<?php echo $Jprimero_precio ?>" placeholder="2,35">
							</div>
							<div class="dia__menu">
								<textarea name="Jsegundo" id="Jsegundo" placeholder="Segundo plato"><?php echo $Jsegundo ?></textarea>
								<input type="text" name="Jsegundo_precio" id="Jsegundo_precio" value="<?php echo $Jsegundo_precio ?>" placeholder="6,40">
							</div>
						</div>
						<div class="dia">
							<p class="dia__name">Viernes</p>
							<div class="dia__menu">
								<textarea name="Vprimero" id="Vprimero" placeholder="Primer plato"><?php echo $Vprimero ?></textarea>
								<input type="text" name="Vprimero_precio" id="Vprimero_precio" value="<?php echo $Vprimero_precio ?>" placeholder="2,35">
							</div>
							<div class="dia__menu">
								<textarea name="Vsegundo" id="Vsegundo" placeholder="Segundo plato"><?php echo $Vsegundo ?></textarea>
								<input type="text" name="Vsegundo_precio" id="Vsegundo_precio" value="<?php echo $Vsegundo_precio ?>" placeholder="6,40">
							</div>
						</div>
						<div class="dia">
							<p class="dia__name">Sabado</p>
							<div class="dia__menu">
								<textarea name="Sprimero" id="Sprimero" placeholder="Primer plato"><?php echo $Sprimero ?></textarea>
								<input type="text" name="Sprimero_precio" id="Sprimero_precio" value="<?php echo $Sprimero_precio ?>" placeholder="2,35">
							</div>
							<div class="dia__menu">
								<textarea name="Ssegundo" id="Ssegundo" placeholder="Segundo plato"><?php echo $Ssegundo ?></textarea>
								<input type="text" name="Ssegundo_precio" id="Ssegundo_precio"value="<?php echo $Ssegundo_precio ?>"  placeholder="6,40">
							</div>
						</div>
					</fieldset>

					<fieldset id="CONFIG_TEMPLATE_3" class="config-content">
						<textarea name="oferta_name" id="oferta_name" placeholder="Napolitanas de chocolate"><?php echo $oferta_name ?></textarea>
						<input type="text" name="oferta" id="oferta" value="<?php echo $oferta ?>" placeholder="1,25 €">
					</fieldset>
<?php /*
					<fieldset id="CONFIG_TEMPLATE_4" class="config-content">
						<textarea name="product_name" id="product_name" placeholder="Nombre del producto"><?php echo $product_name ?></textarea>
						<input type="text" name="product_euros" id="product_euros" value="<?php echo $product_euros ?>" placeholder="2">
						<input type="text" name="product_cents" id="product_cents" value="<?php echo $product_cents ?>" placeholder="80">
						<textarea name="product_desc" id="product_desc" placeholder="Descripción del producto."><?php echo $product_desc ?></textarea>
						
	
						
						<div class="img-preview" <?php if( strlen($img_path) > 1) : ?> style="background-image:url(<?php echo $img_path?>)" <?php endif;?> > </div>			
						
						<input type="file" name="img_path" id="img_path" value="<?php echo $img_path?>" style="color: transparent;">
										
	
					</fieldset>
*/ ?>
				</div>
			</div>

			<div class="form-group text-center"><input type="submit" name="SUBMIT" id="SUBMIT" value="Previsualizar" class="btn btn-success">
		    <input type="button" class="btn btn-success" name="volver" value="Volver" onclick="window.close();	window.history.back();">
		   </div>
			

			<div class="validation"></div>

		</fieldset>
	</form>
</div>
</div>

	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="script.js"></script>
	<script></script>

</body>
</html>