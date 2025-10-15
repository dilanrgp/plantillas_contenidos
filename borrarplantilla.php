<?php

$html =  $_GET["html"];

//$del = unlink("json/".$html.".json");
$del = unlink("ficheros/".$html.".html");
$del = unlink("ficheros/".$html.".jpg");

?>