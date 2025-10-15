<?php
error_reporting(E_ALL);
//require_once __DIR__.'../../bootstrap/autoload.php';

//$dot = new \Dotenv\Dotenv(__DIR__.'/../../');
//$dot->load();

/*$sql_host  = getenv('DB_HOST');
$sql_login = getenv('DB_USERNAME');
$sql_pass  = getenv('DB_PASSWORD');
$sql_base  = getenv('DB_DATABASE');*/
$sql_host  =  "127.0.0.1";
$sql_login = "adminladorian";
$sql_pass  = "Idsv04_Lad0r1anPr0d";
$sql_base  = "ladorianidsv4_prod";

$scheme = 'http://';
if (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
    (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
) {
    $scheme = 'https://';
}
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = '/plantillascontenidov4';

if (!defined('BASE_PATH')) {
    define('BASE_PATH', $basePath);
}

$directoriobase = $scheme . $host . BASE_PATH;

if (!defined('BASE_URL')) {
    define('BASE_URL', $directoriobase);
}
