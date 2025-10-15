<?php// Rutas al archivo (local y FTP)
$local_file = './carpeta/archivo.txt'; //Nombre archivo en nuestro PC
$server_file = 'nombrearchivoftp.txt'; //Nombre archivo en FTP

// Establecer la conexión
$ftp_server='miconexion.com';
$ftp_user_name='miusuario';
$ftp_user_pass='mipassword';
$conn_id = ftp_connect($ftp_server);

$local_file = './carpeta/archivo.txt'; //Nombre archivo en nuestro PC
$server_file = 'nombrearchivoftp.txt'; //Nombre archivo en FTP

// Loguearse con usuario y contraseña
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// Descarga el $server_file y lo guarda en $local_file
if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
echo "Se descargado el archivo con éxito\n";
} else {
echo "Ha ocurrido un error\n";
}
function ObtenerRuta(){
//Obriene ruta del directorio del Servidor FTP (Comando PWD)
$id_ftp=ConectarFTP(); //Obtiene un manejador y se conecta al Servidor FTP 
$Directorio=ftp_pwd($id_ftp); //Devuelve ruta actual p.e. "/home/willy"
ftp_quit($id_ftp); //Cierra la conexion FTP
return $Directorio; //Devuelve la ruta a la función
}

// Cerrar la conexión
ftp_close($conn_id);
?>