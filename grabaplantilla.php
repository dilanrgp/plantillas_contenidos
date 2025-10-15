<?php
error_reporting(E_ALL);
require_once __DIR__ . '/accesomysql.php';

// -----------------------------------------------------------------------------
// Helper functions
// -----------------------------------------------------------------------------

function respondWithJson(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit;
}

function respondWithError(string $message, int $statusCode = 400): void
{
    respondWithJson([
        'success' => false,
        'error'   => $message,
    ], $statusCode);
}

function openDatabaseConnection(): ?mysqli
{
    global $sql_host, $sql_login, $sql_pass, $sql_base;

    $connection = @mysqli_connect($sql_host, $sql_login, $sql_pass, $sql_base);

    if (!$connection) {
        return null;
    }

    mysqli_set_charset($connection, 'utf8');

    return $connection;
}

function getCustomerMaxTemplateSizeBytes(int $idcustomer): ?int
{
    static $cache = [];

    if (isset($cache[$idcustomer])) {
        return $cache[$idcustomer];
    }

    $connection = openDatabaseConnection();

    if (!$connection) {
        $cache[$idcustomer] = null;
        return null;
    }

    $query  = 'SELECT max_file_size_template FROM customers WHERE idcustomer = ? LIMIT 1';
    $stmt   = mysqli_prepare($connection, $query);
    $result = null;

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $idcustomer);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $maxSizeMb);
            if (mysqli_stmt_fetch($stmt)) {
                $maxSizeMb = is_numeric($maxSizeMb) ? (float) $maxSizeMb : 0.0;
                if ($maxSizeMb > 0) {
                    $result = (int) round($maxSizeMb * 1024 * 1024);
                }
            }
        }
        mysqli_stmt_close($stmt);
    }

    mysqli_close($connection);

    $cache[$idcustomer] = $result;

    return $result;
}

function decodeBase64Image(string $payload): ?string
{
    if (strpos($payload, ',') !== false) {
        [, $payload] = explode(',', $payload, 2);
    }

    $decoded = base64_decode($payload, true);

    return $decoded === false ? null : $decoded;
}

function resizeImageToMaxSize(string $imageData, int $maxBytes): ?string
{
    $image = @imagecreatefromstring($imageData);

    if (!$image) {
        return null;
    }

    $width  = imagesx($image);
    $height = imagesy($image);

    $scales   = [1.0, 0.9, 0.8, 0.7, 0.6, 0.5, 0.4, 0.3];
    $qualities = [90, 80, 70, 60, 50, 45, 40, 35, 30];

    foreach ($scales as $scale) {
        $targetWidth  = max(1, (int) round($width * $scale));
        $targetHeight = max(1, (int) round($height * $scale));

        $resampled = imagecreatetruecolor($targetWidth, $targetHeight);

        $background = imagecolorallocate($resampled, 255, 255, 255);
        imagefill($resampled, 0, 0, $background);
        imagecopyresampled($resampled, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
        imageinterlace($resampled, true);

        foreach ($qualities as $quality) {
            ob_start();
            imagejpeg($resampled, null, $quality);
            $buffer = ob_get_clean();

            if ($buffer !== false && strlen($buffer) <= $maxBytes) {
                imagedestroy($resampled);
                imagedestroy($image);
                return $buffer;
            }
        }

        imagedestroy($resampled);
    }

    imagedestroy($image);

    return null;
}

function saveTemplatePreviewImage(string $rawImage, string $directory, string $filename, int $idcustomer): array
{
    $decodedImage = decodeBase64Image($rawImage);

    if ($decodedImage === null) {
        return [
            'success' => false,
            'error'   => 'No se ha podido procesar la imagen recibida.',
        ];
    }

    $maxBytes = getCustomerMaxTemplateSizeBytes($idcustomer);

    if ($maxBytes !== null && strlen($decodedImage) > $maxBytes) {
        $resizedImage = resizeImageToMaxSize($decodedImage, $maxBytes);

        if ($resizedImage === null) {
            return [
                'success' => false,
                'error'   => 'La imagen supera el tamaño máximo permitido y no ha sido posible reducirla. Por favor, utiliza una imagen más ligera.',
            ];
        }

        $decodedImage = $resizedImage;
    }

    $filePath = rtrim($directory, '/') . '/' . ltrim($filename, '/');

    if (file_put_contents($filePath, $decodedImage) === false) {
        return [
            'success' => false,
            'error'   => 'No se ha podido guardar la imagen procesada en el servidor.',
        ];
    }

    return [
        'success' => true,
        'path'    => $filePath,
    ];
}

// -----------------------------------------------------------------------------
// Main controller
// -----------------------------------------------------------------------------

// Si ya estaba definido el campo html (el que incluye la pagina WEB) se graba la plantilla
// ya que los parametros se pasan por POST
$response="KO";
$archivo= "0plantilla.txt"; // el nombre de tu archivo
$fch= fopen($archivo, "w"); // Abres el archivo para escribir en él

if(isset($_POST['plantilla'])) {
        // Generar fichero HTML y caratula para el fichero HTML
        $rutaurl = rtrim(BASE_URL, '/') . '/';
        $rutafile = 'ficheros';

        fwrite($fch, "ruta...".$rutaurl."____"."file...".$rutafile.PHP_EOL); // Grabas

        if(!is_dir ($rutafile)){
                if (!file_exists($rutafile)) {
                        mkdir($rutafile, 0777, true);
                }
        }
        $tiempo = time();
        $response = grabarplantilla($tiempo,$rutafile."/",$_POST['html'],  $_POST['atributos'],  $_POST['plantilla'],  $_POST['contenido'] );
        $respuesta = ["success"=> true, "data"=>  $rutaurl.$response];

        if(!empty($_POST['imagen'])){
                $idcustomer = isset($_POST['idcustomer']) ? (int) $_POST['idcustomer'] : 0;

                if ($idcustomer <= 0) {
                        if (is_file($response)) {
                                @unlink($response);
                        }
                        fclose($fch);
                        respondWithError('No se ha recibido el identificador del cliente para validar la imagen.');
                }

                $imageFilename = $tiempo . '.jpg';
                $imageResult = saveTemplatePreviewImage($_POST['imagen'], $rutafile, $imageFilename, $idcustomer);

                if (!$imageResult['success']) {
                        if (is_file($response)) {
                                @unlink($response);
                        }
                        fclose($fch);
                        respondWithError($imageResult['error']);
                }
        }

        fwrite($fch, "url...".$rutaurl.$response.PHP_EOL); // Grabas
        fclose($fch);

        $response = "OK";

        if($response == "OK") {
                respondWithJson($respuesta);
        } else {
                echo false;
        }
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