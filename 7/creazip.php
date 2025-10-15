<?php

$carpeta = 'galeriacofares';
$permitidos = array('jpg','mp4');
$archivo_final = 'descargagaleria.zip';  // .zip *
$zip = new ZipArchive();
if ($zip->open($archivo_final, ZIPARCHIVE::CREATE)!=TRUE){die('No se ha podido crear un archivo zip!');}
 
function archivar($carpeta,$permitidos,$zip)
{
        $carpetas = scandir($carpeta);
        foreach($carpetas as $archivo)
        {
				echo $carpeta.'/'.$archivo."<br>";			
                if (($archivo == '.')||($archivo == '..')){continue;}
 
                elseif (is_dir($carpeta.'/'.$archivo)){
					archivar($carpeta.'/'.$archivo,$permitidos,$zip);
 
				}else{
					$extension = substr($archivo, strrpos($archivo, '.') + 1);
					if (in_array($extension, $permitidos)) {
                        //$zip->addFile($carpeta.'/'.$archivo,$carpeta.'/'.$archivo);
						$zip->addFile($carpeta.'/'.$archivo);
					}
                }

        }
}
 
archivar($carpeta,$permitidos,$zip);
$zip->close();
 header("Content-type: application/octet-stream");
 header("Content-disposition: attachment; filename=descargagaleria.zip");
 // leemos el archivo creado
 readfile('descargagaleria.zip');
//unlink('descargagaleria.zip');//Destruyearchivo temporal
	
 
 
?>