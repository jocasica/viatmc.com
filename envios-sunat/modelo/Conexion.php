<?php 


class Conexion{

function get_conexion()
{
    
try

{

    $conexion = new PDO("mysql:host=" . $_SERVER['APP_DB_HOST'] . ";dbname=" . $_SERVER['APP_DB_DATABASE'], $_SERVER['APP_DB_USERNAME'] , $_SERVER['APP_DB_PASSWORD'],
                    array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"//ACTIVAR LA VALIDACIÓN DE CODIFICACIÓN UTF8
                    )
            );
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//ACTIVSAR MENSAJES DE ERROR Y EXCEPCIÓN
return $conexion;//RETONAR LA CONEXIÓN


} catch (Exception $e) {
	
  echo "Error: ".$e->getMessage();//SE IMPRIME LOS ERRORES EN PANTALLA
}


}


}


?>

