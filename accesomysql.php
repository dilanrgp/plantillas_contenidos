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


$directoriobase = "https://".$_SERVER["HTTP_HOST"]."/plantillascontenidov4";