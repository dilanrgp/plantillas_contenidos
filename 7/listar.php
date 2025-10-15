<?php


    $dir=opendir("galeriacofares"); 
    while($archivo=readdir($dir)) 
    { 
		?> 
		<input type="checkbox" name="archivo[]" value="<?php echo $archivo;?>"> 
		<label><?php echo $archivo;?><br></label> 
		<?php 
    } 
	
	
	

$path="galeriacofares/ancianos"; 
$directorio=dir($path);
echo "Descargas ".$path.":<br><br>";
while ($archivo = $directorio->read())
	{
    		echo "<a href=".$archivo.">".$archivo."</a>.<br>";

		}	
$directorio->close();

?>


<?php
    // accepted file extensions
    $extensions = array("pdf","mp3","jpg","rar");
 
    // file name to download
    $file = $_GET["file"];
 
    // file size
    $size = filesize($file);
 
    // Prevent go throught directories
    if(strpos($file,"/")!==false){
        die("Permission denied to change directory, please, especify only a file name");
    }
 
    // test the file estension
    $ftmp = explode(".",$file);
    $fExt = strtolower($ftmp[count($ftmp)-1]);
    if(!in_array($fExt,$extensions)){
        die("ERROR: File extension not recognized: $fExt");
    }
 
    // if it was ok, let's download it
    header("Content-Transfer-Encoding: binary");    
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$file");
    header("Content-Length: $size");
    $fp=fopen("$file", "r");
    fpassthru($fp);
?>