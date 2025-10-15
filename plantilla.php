<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Eleccion de plantilla por sector</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/plantilla.css?tmp=<?=time()?>">
	<script src="js/jquery-3.2.1.min.js"></script>

<script  type="text/javascript">

function onsubmitform()
{
  var location = window.location.href;
  var pathName = location.substring(0, location.lastIndexOf("/")+1);

  var eleccion=document.getElementsByName('TEMPLATE');
  let eleccionArray = Array.prototype.slice.call(eleccion, 0);
  let checked = eleccionArray.filter(f => f.checked)[0];
  url= pathName+checked.value+"/formulario.php";

  document.forma.setAttribute('action', url);
  return true;

}

function cerrar(){
	parent.postMessage({domain:'ladorian.ids.template',message: "close"}, "*");
}
</script>
</head>
<?php
$template = "TEMPLATE-1";
$idcustomer = $_GET["customer"];
$idsite = null;
if(isset($_GET["idsite"]))
	$idsite = $_GET["idsite"];
$entorno = $_GET["entorno"];
$cadena="";
include("accesomysql.php");
$conexionbd  = mysqli_connect($sql_host,$sql_login,$sql_pass,$sql_base) or die("Error en la conexión a la Base de Datos...:".mysqli_connect_error());
mysqli_select_db($conexionbd,$sql_base) OR  die ('Error en la selección de la Base de Datos...' . mysqli_error());
header("Content-Type: text/html;charset=iso-8859-1");
$conexionbd->query("SET NAMES 'utf8'");
$conexionbd->query("SET CHARACTER SET utf8");
mysqli_set_charset($conexionbd,'utf8');
if($entorno == 'demo'){
	$sql = "SELECT * FROM templates_sectors ORDER BY idtemplatesector";
	$result = mysqli_query($conexionbd,$sql);
	$cont = 1;
	while ($obj = $result->fetch_object()){

		if($cont == 1)
			$checked = "checked";
		else
			$checked = "";

		$cadena.="<div class='form-check col col-md-3 col-sm-6'>
					<label for='TEMPLATE-".$cont."' class='template-selection'>
						<div class='cell'>
							<input type='radio' id='".$obj->name."' name='TEMPLATE' id='TEMPLATE-".$cont."' value='" . $obj->idcustomer . "' ".$checked.">
							<label for='".$obj->name."'>".utf8_decode($obj->name)."</label>
						</div>
						<div class='cell'>
							<img src='".$obj->icon."'>
						</div>
					</label>
				 </div>";
		$cont+=1;
	}
} else {
	$sql = "SELECT idcustomer_master FROM templates_customers WHERE idcustomer=".$idcustomer;
	$result = mysqli_query($conexionbd,$sql);
	while ($obj = $result->fetch_object()){
		$id= $obj->idcustomer_master;
	}
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = $id.'/formulario.php';
	header("Location: https://$host$uri/$extra?idsite=$idsite");
}
?>
<body>

<div class="container body" role="main">
<div class="row">

	<form name="forma" id="forma" action="" method="POST" id="TEMPLATE_FORM" enctype="multipart/form-data" onsubmit="onsubmitform();" >
		<input type="hidden" name="url" id="url">

		<fieldset class="col-md-12 form-group" id="TEMPLATE">
			<h3>Elegir Sector de Actividad </h3>
			<br><br>
			<div class="row align-items-center">
				<?php  echo $cadena;?>
			</div>
		</fieldset>

		<div class="validation"></div>
		<div class="form-group text-center">
			<button onclick="onsubmitform()" class="btn btn-success">Mostrar</button>
			<button onclick="cerrar()" class="btn btn-success">Volver</button>
		</div>

	</form>

</div>
</div>

</body>
</html>


