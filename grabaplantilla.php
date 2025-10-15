<?php
error_reporting(E_ALL);
// Si ya estaba definido el campo html (el que incluye la pagina WEB) se graba la plantilla
// ya que los parametros se pasan por POST
$response="KO";
$archivo= "0plantilla.txt"; // el nombre de tu archivo
$fch= fopen($archivo, "w"); // Abres el archivo para escribir en él	

if(isset($_POST['plantilla'])) {  
	// Generar fichero HTML y caratula para el fichero HTML
	$rutaurl = "https://" .$_SERVER["HTTP_HOST"]. "/plantillascontenidov4/";	
	$rutafile = "ficheros/";
		
	fwrite($fch, "ruta...".$rutaurl."____"."file...".$rutafile.PHP_EOL); // Grabas		

	if(!is_dir ($rutafile)){
		if (!file_exists($rutafile)) {
			mkdir($rutafile, 0777, true);
		}
	}
	$tiempo = time();	
	$response = grabarplantilla($tiempo,$rutafile,$_POST['html'],  $_POST['atributos'],  $_POST['plantilla'],  $_POST['contenido'] );
	$respuesta = ["success"=> true, "data"=>  $rutaurl.$response];
	if(isset($_POST['imagen']) && $_POST['imagen'] != '' && isset($_POST['contenido']) && $_POST['contenido'] != ''){
		$actual =  $_POST['imagen'];
		list($type, $data) = explode(';', $actual);
		list(, $actual)    = explode(',', $actual);
		$actual = base64_decode($actual);

		$str_image = $tiempo.".jpg";
		file_put_contents($rutafile . $str_image, $actual); 
		$str_newimage = $rutafile . $str_image;
	
		$headers = get_headers($str_newimage, 1);
		
		fwrite($fch, "headers....".$headers.PHP_EOL); // Grabas		

		sleep(3);
				
		if(isset($headers['Content-Length']) && $headers['Content-Length']>0){

		if($rtn == "OK"){
				echo true;
		}else{
				echo false;
		} 
		die;			
		}
	}
	
	fwrite($fch, "url...".$rutaurl.$response.PHP_EOL); // Grabas		
	fclose($fch);
	
	$response = "OK";
	
	if($response == "OK") echo json_encode($respuesta); 
	else echo false;
	die;	
} 

// funcion para grabar la plantilla en curso en la tabla content_template
function grabarplantilla($tiempo,$rutahtml, $html,  $atributos, $plantilla, $contenido) {		
	// COGER LAS CREDENCIALES DE ACCESO A LA BASE DE DATOS DE LAS VARIABLES CORRESPONDIENTES PARA NO TENER QUE DEFINIRLAS AQUI

	include("accesomysql.php");
	
	$archivo= "1plantilla.txt"; // el nombre de tu archivo
	$fch= fopen($archivo, "w"); // Abres el archivo para escribir en él			

	// Se sustituye la ' por la ",  el caracter ^ que se puso anteriormente por la " y se quitan los caracteres [ y ] porque no deben existir cuando se hace el json_decode
	$contenedor = str_replace("'","\"",$html);	

	$contenedor = sanitizeOutput($contenedor);

	$str_nombre = $tiempo.".html";
	fwrite($fch, $rutahtml . $str_nombre.PHP_EOL );
	file_put_contents($rutahtml . $str_nombre, $html); 	

	fclose($fch); // Cierras el archivo.

	// Devolver el resultado
	return $rutahtml.$str_nombre;
}

function grabarplantillatext($html,  $atributos, $plantilla, $contenido,$textconntent){	
	include("accesomysql.php");
	
	$conexionbd  = mysqli_connect($sql_host,$sql_login,$sql_pass,$sql_base) or die("Error en la conexión a la Base de Datos...:".mysqli_connect_error());
	mysqli_select_db($conexionbd,$sql_base) OR  die ('Error en la selección de la Base de Datos...' . mysqli_error());
	header("Content-Type: text/html;charset=iso-8859-1");
	$conexionbd->query("SET NAMES 'utf8'");
	$conexionbd->query("SET CHARACTER SET utf8");
	
	mysqli_set_charset($conexionbd,'utf8');			
	$contenedor = str_replace("'","\"",$html);
	$atributos = str_replace("^","\"",$atributos);			
	$atributos = mysqli_real_escape_string($conexionbd,$atributos); 
		
	$textconntent= str_replace("'","\"",$textconntent);

	$contenedor = sanitizeOutput($contenedor);

	$sql = "UPDATE content SET attributes = '" . $textconntent .
	"', content_html = '" . $contenedor .
	"', idcontenttemplate = '" . $plantilla .
	"' WHERE idcontent = ".$contenido; 

	$result=mysqli_query($conexionbd,$sql);
	if ($result) 
		$ret="OK";//   .mysqli_error($conexionbd);
	else
		$ret="KO";//   .mysqli_error($conexionbd);	

	$close = mysqli_close($conexionbd); 	

	// Devolver el resultado
	return $ret;
}

function sanitizeOutput($buffer) {
    $search = array(
        '/\>[^\S ]+/s',     // Quitamos espacios en blanco después de las etiquetas, excepto los espacios en sí
        '/[^\S ]+\</s',     // Quitamos espacios en blanco antes de las etiquetas, excepto los espacios en sí
        '/(\s)+/s',         // Acortamos los espacios en blanco
        '/<!--(.|\s)*?-->/' // Quitamos los comentarios HTML
    );
 
    $replace = array(
        '>',
        '<',
        '\\1',
        ''
    );
 
    $output = preg_replace($search, $replace, $buffer);
 
    return $output;
}